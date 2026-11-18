<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
        if (in_array($this->user()->role, ['guru', 'siswa'], true)) {
            $rules['alamat'] = ['sometimes', 'nullable', 'string', 'max:1000'];
            $rules['no_hp'] = ['sometimes', 'nullable', 'string', 'max:30'];
        }
        return $rules;
    }
}
