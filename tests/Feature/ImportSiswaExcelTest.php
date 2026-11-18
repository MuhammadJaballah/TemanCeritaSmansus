<?php

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

beforeEach(function () {
    $this->withoutVite();
    $this->admin = User::create(['name' => 'Admin', 'username' => 'import-admin', 'email' => 'admin-import@example.com', 'password' => 'password', 'role' => 'admin']);
});

function excelSiswa(array $rows, bool $formula = false): UploadedFile
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->fromArray($rows, null, 'A1');
    if (isset($rows[1][2])) $sheet->setCellValueExplicit('C2', $rows[1][2], DataType::TYPE_STRING);
    if ($formula) $sheet->setCellValue('A2', '=1+1');
    $path = tempnam(sys_get_temp_dir(), 'siswa');
    (new Xlsx($spreadsheet))->save($path);
    $spreadsheet->disconnectWorksheets();
    return new UploadedFile($path, 'siswa.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);
}

test('template dapat diunduh dan impor membuat akun siswa yang bisa login', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.siswa.template-import'));
    $response->assertOk()->assertDownload('template_import_siswa.xlsx');
    $path = tempnam(sys_get_temp_dir(), 'template');
    file_put_contents($path, $response->streamedContent());
    $template = IOFactory::createReader('Xlsx')->load($path);
    expect($template->getActiveSheet()->getCell('A1')->getValue())->toBe('nama_lengkap')
        ->and($template->getActiveSheet()->getCell('C1')->getValue())->toBe('nisn');
    $template->disconnectWorksheets();
    unlink($path);

    $file = excelSiswa([['nama_lengkap', 'email', 'nisn', 'kelas'], ['Siswa Baru', 'baru@example.com', '0012345678', 'XI IPA 1'], ['Siswa Dua', 'dua@example.com', '', 'X A']]);
    $this->post(route('admin.siswa.import'), ['file' => $file, 'password' => 'KataSandi123'])->assertSessionHasNoErrors()->assertRedirect(route('admin.siswa.index'));
    $user = User::where('email', 'baru@example.com')->firstOrFail();
    expect($user->role)->toBe('siswa')->and(Hash::check('KataSandi123', $user->password))->toBeTrue();
    $this->assertDatabaseHas('siswas', ['user_id' => $user->id, 'nisn' => '0012345678', 'kelas' => 'XI IPA 1']);
    expect(Siswa::count())->toBe(2);
    $this->post(route('logout'));
    $this->post(route('login'), ['email' => 'baru@example.com', 'password' => 'KataSandi123'])->assertRedirect(route('siswa.dashboard', absolute: false));
    $this->assertAuthenticatedAs($user);
    $this->get(route('siswa.dashboard'))->assertOk();
});

test('baris tidak valid dan data duplikat menolak seluruh impor', function () {
    $existing = User::create(['name' => 'Lama', 'username' => 'existing-import', 'email' => 'lama@example.com', 'password' => 'password', 'role' => 'siswa']);
    Siswa::create(['user_id' => $existing->id, 'nama_lengkap' => 'Lama', 'nisn' => '0012345678']);
    $file = excelSiswa([['nama_lengkap', 'email', 'nisn', 'kelas'], ['Baru', 'baru@example.com', '0000000001', 'X'], ['Lain', 'LAMA@example.com', '0012345678', 'X']]);
    $this->actingAs($this->admin)->post(route('admin.siswa.import'), ['file' => $file, 'password' => 'password123'])->assertSessionHasErrorsIn('import', 'file');
    $this->assertDatabaseMissing('users', ['email' => 'baru@example.com']);
    expect(Siswa::count())->toBe(1);

    $duplicate = excelSiswa([['nama_lengkap', 'email', 'nisn', 'kelas'], ['Pertama', 'sama@example.com', '123', 'X'], ['Kedua', 'SAMA@example.com', '123', 'XI']]);
    $this->post(route('admin.siswa.import'), ['file' => $duplicate, 'password' => 'password123'])->assertSessionHasErrorsIn('import', 'file');
    $this->assertDatabaseMissing('users', ['email' => 'sama@example.com']);
});

test('format salah, rumus, dan akses selain admin ditolak', function () {
    $wrong = excelSiswa([['nama', 'email', 'nisn', 'kelas'], ['Baru', 'baru@example.com', '1', 'X']]);
    $this->actingAs($this->admin)->post(route('admin.siswa.import'), ['file' => $wrong, 'password' => 'password123'])->assertSessionHasErrorsIn('import', 'file');
    $this->get(route('admin.siswa.index'))->assertOk()->assertSee('Impor belum berhasil')->assertSee('importModal: true', false)->assertSee('Judul kolom harus sesuai template');
    $formula = excelSiswa([['nama_lengkap', 'email', 'nisn', 'kelas'], ['Baru', 'baru@example.com', '1', 'X']], true);
    $this->post(route('admin.siswa.import'), ['file' => $formula, 'password' => 'password123'])->assertSessionHasErrorsIn('import', 'file');
    $this->post(route('admin.siswa.import'), ['file' => UploadedFile::fake()->createWithContent('siswa.xlsx', 'bukan excel'), 'password' => 'password123'])->assertSessionHasErrorsIn('import', 'file');
    $student = User::factory()->create(['role' => 'siswa']);
    $this->actingAs($student)->post(route('admin.siswa.import'), [])->assertForbidden();
    $this->get(route('admin.siswa.template-import'))->assertForbidden();
    expect(Siswa::count())->toBe(0);
});
