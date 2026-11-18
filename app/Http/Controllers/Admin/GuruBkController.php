<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\StoreGuruRequest;
use App\Http\Requests\Admin\UpdateGuruRequest;

class GuruBkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gurus = Guru::with('user')->get();
        return view('Admin.guru.index', compact('gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuruRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['nama_lengkap'],
            'username' => explode('@', $validated['email'])[0] . '_' . rand(1000, 9999), 
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'guru'
        ]);

        Guru::create([
            'user_id' => $user->id,
            'nama_lengkap' => $validated['nama_lengkap'],
            'nip' => $validated['nip'] ?? null,
            'bidang_keahlian' => $validated['bidang_keahlian'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuruRequest $request, string $id)
    {
        $guru = Guru::findOrFail($id);
        
        $validated = $request->validated();

        $user = $guru->user;
        $user->name = $validated['nama_lengkap'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        $guru->update(array_merge([
            'nama_lengkap' => $validated['nama_lengkap'],
            'nip' => $validated['nip'] ?? null,
            'bidang_keahlian' => $validated['bidang_keahlian'] ?? null,
        ], array_intersect_key($validated, array_flip(['alamat', 'no_hp']))));

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guru = Guru::findOrFail($id);
        // Deleting user will cascade and delete the guru profile
        $guru->user->delete();
        
        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil dihapus');
    }
}
