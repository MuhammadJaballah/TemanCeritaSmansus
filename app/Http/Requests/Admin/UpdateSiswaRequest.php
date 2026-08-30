<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Siswa;

class UpdateSiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $siswa = Siswa::findOrFail($this->route('siswa'));
        
        return [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
            'nisn' => 'nullable|string|max:255',
            'kelas' => 'nullable|string|max:255',
            'password' => 'nullable|min:8'
        ];
    }
}
