<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuruRequest extends FormRequest
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
        return [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'nullable|string|max:255',
            'bidang_keahlian' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:1000',
            'no_hp' => 'nullable|string|max:30',
            'password' => 'required|min:8'
        ];
    }
}
