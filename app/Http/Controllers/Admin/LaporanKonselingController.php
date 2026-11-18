<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingKonseling;
use App\Models\Siswa;
use Illuminate\Support\Facades\Response;

class LaporanKonselingController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'per_page' => ['nullable', 'in:10,25,50,100'],
        ]);
        $search = trim($validated['search'] ?? '');
        $perPage = (int) ($validated['per_page'] ?? 10);
        $query = BookingKonseling::with(['jadwal.guru', 'siswa']);
        if ($search !== '') {
            $query->whereHas('siswa', fn ($q) => $q->where('nama_lengkap', 'like', '%'.$search.'%'));
        }

        // Filter by Date Range (based on jadwal_konselings.tanggal)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            });
        } elseif ($request->filled('start_date')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('tanggal', '>=', $request->start_date);
            });
        } elseif ($request->filled('end_date')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('tanggal', '<=', $request->end_date);
            });
        }

        // Filter by Kategori
        if ($request->filled('kategori') && $request->kategori !== 'Semua Kategori') {
            $query->where('kategori_masalah', $request->kategori);
        }

        // Get unique categories for the filter dropdown
        $categories = BookingKonseling::select('kategori_masalah')->distinct()->pluck('kategori_masalah');

        // Paginate students, not individual sessions, so each student stays on one page.
        $siswaPage = Siswa::whereIn('id', (clone $query)->select('siswa_id'))
            ->orderBy('nama_lengkap')->orderBy('id')->paginate($perPage)->withQueryString();
        $laporans = $query->whereIn('siswa_id', $siswaPage->getCollection()->modelKeys())
            ->get()->groupBy('siswa_id');
        $semuaSesi = BookingKonseling::with('jadwal')
            ->whereIn('siswa_id', $laporans->keys())
            ->get()
            ->groupBy('siswa_id');
        $nomorSesi = [];
        foreach ($semuaSesi as $sesi) {
            foreach ($sesi->sortBy(fn ($item) => ($item->jadwal->tanggal ?? '') . ' ' . ($item->jadwal->jam_mulai ?? '') . ' ' . str_pad((string) $item->id, 20, '0', STR_PAD_LEFT))->values() as $index => $booking) {
                $nomorSesi[$booking->id] = $index + 1;
            }
        }

        return view('Admin.laporan.index', compact('laporans', 'categories', 'semuaSesi', 'nomorSesi', 'siswaPage', 'search', 'perPage'));
    }

    public function export(Request $request)
    {
        $validated = $request->validate(['search' => ['nullable', 'string', 'max:255']]);
        $search = trim($validated['search'] ?? '');
        $query = BookingKonseling::with(['jadwal.guru', 'siswa']);
        if ($search !== '') {
            $query->whereHas('siswa', fn ($q) => $q->where('nama_lengkap', 'like', '%'.$search.'%'));
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            });
        } elseif ($request->filled('start_date')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('tanggal', '>=', $request->start_date);
            });
        } elseif ($request->filled('end_date')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('tanggal', '<=', $request->end_date);
            });
        }

        if ($request->filled('kategori') && $request->kategori !== 'Semua Kategori') {
            $query->where('kategori_masalah', $request->kategori);
        }

        $laporans = $query->get();

        $filename = "laporan_konseling_" . date('Y-m-d_H-i') . ".csv";

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('No', 'Siswa', 'Guru BK', 'Kategori Masalah', 'Keluhan Awal', 'Tanggal', 'Jam', 'Status');

        $callback = function() use($laporans, $columns) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);

            $no = 1;
            foreach ($laporans as $laporan) {
                $row['No']  = $no++;
                $row['Siswa']    = $laporan->siswa->nama_lengkap ?? '-';
                $row['Guru BK']    = $laporan->jadwal->guru->nama_lengkap ?? '-';
                $row['Kategori Masalah']  = $laporan->kategori_masalah;
                $row['Keluhan Awal'] = $laporan->keluhan_awal;
                $row['Tanggal']  = $laporan->jadwal ? \Carbon\Carbon::parse($laporan->jadwal->tanggal)->translatedFormat('d F Y') : '-';
                $row['Jam']  = $laporan->jadwal ? $laporan->jadwal->jam_mulai . ' - ' . $laporan->jadwal->jam_selesai : '-';
                $row['Status']  = $laporan->jadwal->status ?? '-';

                $fields = array($row['No'], $row['Siswa'], $row['Guru BK'], $row['Kategori Masalah'], $row['Keluhan Awal'], $row['Tanggal'], $row['Jam'], $row['Status']);
                fputcsv($file, array_map(function ($value) {
                    $value = (string) ($value ?? '');
                    return preg_match('/^[\s]*[=+@\-]/u', $value) ? "'".$value : $value;
                }, $fields));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
