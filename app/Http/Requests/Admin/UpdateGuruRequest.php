<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Guru;

class UpdateGuruRequest extends FormRequest
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
        $guru = Guru::findOrFail($this->route('guru'));
        
        return [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $guru->user_id,
            'nip' => 'nullable|string|max:255',
            'bidang_keahlian' => 'nullable|string|max:255',
            'alamat' => 'sometimes|nullable|string|max:1000',
            'no_hp' => 'sometimes|nullable|string|max:30',
            'password' => 'nullable|min:8'
        ];
    }
}
