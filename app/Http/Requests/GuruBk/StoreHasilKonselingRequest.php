<?php

namespace App\Http\Requests\GuruBk;

use Illuminate\Foundation\Http\FormRequest;

class StoreHasilKonselingRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'booking_id' => 'required|exists:booking_konselings,id',
            'kategori_masalah' => 'required|string|max:255',
            'catatan_hasil' => 'required|string',
        ];
    }
}
