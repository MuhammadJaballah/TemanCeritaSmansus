<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\StoreSiswaRequest;
use App\Http\Requests\Admin\UpdateSiswaRequest;
use App\Services\ImportSiswaExcel;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SiswaController extends Controller
{
    public function templateImport()
    {
        return response()->streamDownload(function () {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Data Siswa');
            $sheet->fromArray(['nama_lengkap', 'email', 'nisn', 'kelas'], null, 'A1');
            $sheet->getStyle('A1:D1')->getFont()->setBold(true);
            $sheet->getStyle('C2:C1001')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
            foreach (['A' => 28, 'B' => 34, 'C' => 20, 'D' => 20] as $column => $width) $sheet->getColumnDimension($column)->setWidth($width);
            $sheet->freezePane('A2');
            (new Xlsx($spreadsheet))->save('php://output');
            $spreadsheet->disconnectWorksheets();
        }, 'template_import_siswa.xlsx', ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
    }

    public function import(Request $request, ImportSiswaExcel $importer)
    {
        $data = $request->validateWithBag('import', [
            'file' => ['required', 'file', 'mimes:xlsx', 'max:2048'],
            'password' => ['required', 'string', 'min:8', 'max:72'],
        ]);
        try {
            $count = $importer->import($request->file('file'), $data['password']);
        } catch (ValidationException $e) {
            throw $e->errorBag('import');
        } catch (QueryException $e) {
            if (in_array((string) $e->getCode(), ['23000', '23505', '19'], true)) {
                throw ValidationException::withMessages(['file' => 'Data bertabrakan dengan akun yang sudah ada. Periksa kembali email dan NISN, lalu coba lagi.'])->errorBag('import');
            }
            throw $e;
        }
        return redirect()->route('admin.siswa.index')->with('success', "$count data siswa berhasil diimpor.");
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswas = Siswa::with('user')->get();
        return view('Admin.siswa.index', compact('siswas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiswaRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['nama_lengkap'],
            'username' => explode('@', $validated['email'])[0] . '_' . rand(1000, 9999), 
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'siswa'
        ]);

        Siswa::create([
            'user_id' => $user->id,
            'nama_lengkap' => $validated['nama_lengkap'],
            'nisn' => $validated['nisn'],
            'kelas' => $validated['kelas']
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiswaRequest $request, string $id)
    {
        $siswa = Siswa::findOrFail($id);
        
        $validated = $request->validated();

        $user = $siswa->user;
        $user->name = $validated['nama_lengkap'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        $siswa->update([
            'nama_lengkap' => $validated['nama_lengkap'],
            'nisn' => $validated['nisn'],
            'kelas' => $validated['kelas']
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        // Deleting user will cascade and delete the siswa profile
        $siswa->user->delete();
        
        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil dihapus');
    }
}
