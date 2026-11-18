<?php

namespace App\Services;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Throwable;
use ZipArchive;

class ImportSiswaExcel
{
    public function import(UploadedFile $file, string $password): int
    {
        $this->checkArchive($file->getRealPath());
        try {
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(false);
            $workbook = $reader->load($file->getRealPath());
        } catch (Throwable $e) {
            throw ValidationException::withMessages(['file' => 'File tidak dapat dibaca. Pastikan file merupakan Excel .xlsx yang valid.']);
        }

        try {
            $sheet = $workbook->getSheet(0);
            $lastRow = $sheet->getHighestDataRow();
            $lastColumn = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());
            if ($lastRow > 1001 || $lastColumn > 4) {
                throw ValidationException::withMessages(['file' => 'Gunakan empat kolom template dan maksimal 1.000 baris siswa.']);
            }
            $headers = [];
            foreach (['A', 'B', 'C', 'D'] as $column) {
                $cell = $sheet->getCell($column.'1');
                $headers[] = mb_strtolower(trim((string) $cell->getValue()));
            }
            if ($headers !== ['nama_lengkap', 'email', 'nisn', 'kelas']) {
                throw ValidationException::withMessages(['file' => 'Judul kolom harus sesuai template: nama_lengkap, email, nisn, kelas.']);
            }

            $rows = [];
            $errors = [];
            $emails = [];
            $nisns = [];
            for ($rowNumber = 2; $rowNumber <= $lastRow; $rowNumber++) {
                $values = [];
                foreach (['A', 'B', 'C', 'D'] as $column) {
                    $cell = $sheet->getCell($column.$rowNumber);
                    if ($cell->getDataType() === DataType::TYPE_FORMULA) {
                        $errors[] = "Baris $rowNumber: rumus tidak didukung; gunakan nilai biasa.";
                        continue 2;
                    }
                    $values[] = trim((string) ($column === 'C' ? $cell->getFormattedValue() : $cell->getValue()));
                }
                if (count(array_filter($values, fn ($value) => $value !== '')) === 0) continue;
                [$name, $email, $nisn, $kelas] = $values;
                $data = ['nama_lengkap' => $name, 'email' => mb_strtolower($email), 'nisn' => $nisn !== '' ? $nisn : null, 'kelas' => $kelas !== '' ? $kelas : null];
                $validator = Validator::make($data, [
                    'nama_lengkap' => 'required|string|max:255', 'email' => 'required|email|max:255',
                    'nisn' => 'nullable|string|max:255', 'kelas' => 'nullable|string|max:255',
                ]);
                if ($validator->fails()) {
                    $errors[] = "Baris $rowNumber: ".implode(' ', $validator->errors()->all());
                    continue;
                }
                if (isset($emails[$data['email']])) $errors[] = "Baris $rowNumber: email duplikat di dalam file.";
                if ($data['nisn'] !== null && isset($nisns[$data['nisn']])) $errors[] = "Baris $rowNumber: NISN duplikat di dalam file.";
                $emails[$data['email']] = true;
                if ($data['nisn'] !== null) $nisns[$data['nisn']] = true;
                $rows[$rowNumber] = $data;
            }
            if (!$rows && !$errors) $errors[] = 'File tidak berisi data siswa.';

            $existingEmails = User::whereIn(DB::raw('LOWER(email)'), array_keys($emails))->pluck('email')->map(fn ($email) => mb_strtolower($email))->flip();
            $existingNisn = Siswa::whereIn('nisn', array_keys($nisns))->pluck('nisn')->flip();
            foreach ($rows as $number => $row) {
                if ($existingEmails->has($row['email'])) $errors[] = "Baris $number: email sudah terdaftar.";
                if ($row['nisn'] !== null && $existingNisn->has($row['nisn'])) $errors[] = "Baris $number: NISN sudah terdaftar.";
            }
            if ($errors) {
                if (count($errors) > 20) $errors = array_merge(array_slice($errors, 0, 20), ['Masih ada kesalahan lain. Perbaiki file lalu coba lagi.']);
                throw ValidationException::withMessages(['file' => $errors]);
            }

            return DB::transaction(function () use ($rows, $password) {
                $hash = Hash::make($password);
                foreach ($rows as $row) {
                    do { $username = 'siswa_'.Str::lower(Str::random(20)); }
                    while (User::where('username', $username)->exists());
                    $user = User::create(['name' => $row['nama_lengkap'], 'username' => $username, 'email' => $row['email'], 'password' => $hash, 'role' => 'siswa']);
                    Siswa::create(['user_id' => $user->id, 'nama_lengkap' => $row['nama_lengkap'], 'nisn' => $row['nisn'], 'kelas' => $row['kelas']]);
                }
                return count($rows);
            });
        } finally {
            $workbook->disconnectWorksheets();
        }
    }

    private function checkArchive(string $path): void
    {
        $zip = new ZipArchive();
        if ($zip->open($path) !== true) {
            throw ValidationException::withMessages(['file' => 'File bukan Excel .xlsx yang valid.']);
        }
        try {
            $total = 0;
            if ($zip->numFiles > 1000) throw ValidationException::withMessages(['file' => 'Isi file Excel terlalu besar.']);
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $entry = $zip->statIndex($i);
                $total += $entry['size'] ?? 0;
                if ($total > 20 * 1024 * 1024) throw ValidationException::withMessages(['file' => 'Isi file Excel terlalu besar.']);
            }
        } finally {
            $zip->close();
        }
    }
}
