<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PrediksiJurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RekomendasiJurusanController extends Controller
{
    public const MIPA_FEATURES = [
        'agama' => 'Pendidikan Agama',
        'pkn' => 'PKN',
        'b_indo' => 'Bahasa Indonesia',
        'mtk_umum' => 'Matematika Umum',
        'sejarah_indonesia' => 'Sejarah Indonesia',
        'bahasa_inggris' => 'Bahasa Inggris',
        'seni_budaya' => 'Seni Budaya',
        'pjok' => 'PJOK',
        'prakarya' => 'Prakarya & Kewirausahaan',
        'bmr' => 'Budaya Melayu Riau (BMR)',
        'matematika_peminatan' => 'Matematika Peminatan',
        'fisika' => 'Fisika',
        'kimia' => 'Kimia',
        'biologi' => 'Biologi',
    ];

    public const IPS_FEATURES = [
        'agama' => 'Pendidikan Agama',
        'pkn' => 'PKN',
        'b_indo' => 'Bahasa Indonesia',
        'mtk_umum' => 'Matematika Umum',
        'sejarah_indonesia' => 'Sejarah Indonesia',
        'bahasa_inggris' => 'Bahasa Inggris',
        'seni_budaya' => 'Seni Budaya',
        'pjok' => 'PJOK',
        'prakarya' => 'Prakarya & Kewirausahaan',
        'bmr' => 'Budaya Melayu Riau (BMR)',
        'geografi' => 'Geografi',
        'sejarah_peminatan' => 'Sejarah Peminatan',
        'sosiologi' => 'Sosiologi',
        'ekonomi' => 'Ekonomi',
    ];

    public function index()
    {
        $siswa = auth()->user()->siswa;
        $riwayatPrediksi = PrediksiJurusan::where('siswa_id', $siswa->id)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        $prediksiTerbaru = $riwayatPrediksi->first();

        $mipaFeatures = self::MIPA_FEATURES;
        $ipsFeatures = self::IPS_FEATURES;

        return view('Siswa.RekomendasiJurusan.Index', compact(
            'siswa',
            'riwayatPrediksi',
            'prediksiTerbaru',
            'mipaFeatures',
            'ipsFeatures'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jalur' => ['required', 'in:ipa,ips'],
        ], [
            'jalur.required' => 'Silakan pilih jalur peminatan (IPA atau IPS).',
            'jalur.in' => 'Jalur peminatan harus berupa IPA atau IPS.',
        ]);

        $jalur = strtolower($request->input('jalur'));
        $featureMap = $jalur === 'ipa' ? self::MIPA_FEATURES : self::IPS_FEATURES;

        $rules = [];
        $attributes = [];
        foreach ($featureMap as $key => $label) {
            $rules[$key] = ['required', 'numeric', 'min:0', 'max:100'];
            $attributes[$key] = $label;
        }

        $validatedScores = $request->validate($rules, [
            'required' => 'Nilai :attribute wajib diisi.',
            'numeric' => 'Nilai :attribute harus berupa angka.',
            'min' => 'Nilai :attribute minimal 0.',
            'max' => 'Nilai :attribute maksimal 100.',
        ], $attributes);

        $payload = [];
        foreach (array_keys($featureMap) as $key) {
            $payload[$key] = (float) $validatedScores[$key];
        }

        $baseUrl = rtrim(config('services.ml_api.url', 'http://127.0.0.1:5000'), '/');
        $endpoint = $jalur === 'ipa' ? "{$baseUrl}/predict/ipa" : "{$baseUrl}/predict/ips";

        try {
            $response = Http::timeout(15)->acceptJson()->post($endpoint, $payload);
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Tidak dapat terhubung ke server Machine Learning (' . $baseUrl . '). Pastikan aplikasi Flask (ML/app.py) sedang berjalan.');
        }

        if ($response->failed()) {
            $errMsg = $response->json('error') ?? 'Gagal memproses prediksi dari server Machine Learning.';
            return back()
                ->withInput()
                ->with('error', $errMsg);
        }

        $result = $response->json();
        $recommendations = $result['recommendations'] ?? [];
        $trackLabel = $result['track'] ?? strtoupper($jalur);

        if (empty($recommendations)) {
            return back()
                ->withInput()
                ->with('error', 'Server Machine Learning tidak mengembalikan daftar rekomendasi jurusan.');
        }

        $topSummary = collect($recommendations)
            ->take(3)
            ->map(function ($rec) {
                $cat = $rec['category'] ?? '-';
                $conf = isset($rec['confidence_percentage']) ? number_format((float) $rec['confidence_percentage'], 1) . '%' : '';
                return trim("{$cat} ({$conf})");
            })
            ->implode(', ');

        $siswa = auth()->user()->siswa;

        PrediksiJurusan::create([
            'siswa_id' => $siswa->id,
            'jalur' => $trackLabel,
            'input_nilai' => $payload,
            'rekomendasi' => $topSummary,
            'hasil_detail' => $recommendations,
        ]);

        return redirect()
            ->route('siswa.rekomendasi.index')
            ->with('success', 'Prediksi rekomendasi jurusan jalur ' . $trackLabel . ' berhasil diproses dan disimpan!');
    }
}

