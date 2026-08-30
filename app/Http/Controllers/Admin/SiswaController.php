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

class SiswaController extends Controller
{
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
