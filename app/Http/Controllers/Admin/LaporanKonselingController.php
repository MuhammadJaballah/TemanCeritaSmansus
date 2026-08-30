<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingKonseling;
use Illuminate\Support\Facades\Response;

class LaporanKonselingController extends Controller
{
    public function index(Request $request)
    {
        $query = BookingKonseling::with(['jadwal.guru', 'siswa']);

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

        $laporans = $query->latest()->get();

        return view('Admin.laporan.index', compact('laporans', 'categories'));
    }

    public function export(Request $request)
    {
        $query = BookingKonseling::with(['jadwal.guru', 'siswa']);

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

        $columns = array('No', 'Siswa', 'Guru BK', 'Kategori Masalah', 'Tanggal', 'Jam', 'Status');

        $callback = function() use($laporans, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $no = 1;
            foreach ($laporans as $laporan) {
                $row['No']  = $no++;
                $row['Siswa']    = $laporan->siswa->nama_lengkap ?? '-';
                $row['Guru BK']    = $laporan->jadwal->guru->nama_lengkap ?? '-';
                $row['Kategori Masalah']  = $laporan->kategori_masalah;
                $row['Tanggal']  = $laporan->jadwal ? \Carbon\Carbon::parse($laporan->jadwal->tanggal)->translatedFormat('d F Y') : '-';
                $row['Jam']  = $laporan->jadwal ? $laporan->jadwal->jam_mulai . ' - ' . $laporan->jadwal->jam_selesai : '-';
                $row['Status']  = $laporan->jadwal->status ?? '-';

                fputcsv($file, array($row['No'], $row['Siswa'], $row['Guru BK'], $row['Kategori Masalah'], $row['Tanggal'], $row['Jam'], $row['Status']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
