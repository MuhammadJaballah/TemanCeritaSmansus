<?php

namespace App\Http\Requests\Siswa;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Services\JadwalTetap;

class StoreBookingKonselingRequest extends FormRequest
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
            'guru_id' => 'required|exists:gurus,id',
            'jenis_jadwal' => ['required', Rule::in(['tetap', 'permintaan'])],
            'tanggal' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'waktu' => ['required', 'date_format:H:i', 'before_or_equal:23:14'],
            'kategori_masalah' => 'required|string|max:255',
            'keluhan_awal' => 'required|string',
        ];
    }
}
