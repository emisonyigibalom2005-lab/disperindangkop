<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Bantuan;
use App\Models\Berita;
use App\Models\PenerimaBantuan;
use App\Models\Koperasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Koperasi, Bantuan, Penerima, dll
        $stats = [
            'total_koperasi' => Koperasi::count(),
            'koperasi_verified' => Koperasi::where('status_verifikasi', 'diverifikasi')->count(),
            'koperasi_pending' => Koperasi::where('status_verifikasi', 'pending')->count(),
            'koperasi_ditolak' => Koperasi::where('status_verifikasi', 'ditolak')->count(),
            'koperasi_aktif' => Koperasi::where('status_usaha', 'aktif')->count(),
            'total_users' => User::count(),
            'total_bantuan' => Bantuan::count(),
            'bantuan_aktif' => Bantuan::where('status', 'aktif')->count(),
            'penerima_bantuan' => PenerimaBantuan::where('status', 'diterima')->count(),
        ];

        // Grafik: koperasi per distrik (top 10)
        $koperasiPerDistrik = Koperasi::select('distrik', DB::raw('COUNT(*) as total'))
            ->groupBy('distrik')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Grafik: koperasi per kategori
        $koperasiPerKategori = Koperasi::select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')
            ->get();

        // Grafik: Bantuan per tahun
        $bantuanPerTahun = PenerimaBantuan::join('bantuan', 'penerima_bantuan.bantuan_id', '=', 'bantuan.id')
            ->select('bantuan.tahun', DB::raw('COUNT(*) as total'))
            ->where('penerima_bantuan.status', 'diterima')
            ->groupBy('bantuan.tahun')
            ->orderBy('bantuan.tahun')
            ->get();

        // Koperasi terbaru menunggu verifikasi
        $pendingKoperasi = Koperasi::where('status_verifikasi', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        // Aktivitas terbaru
        $recentActivity = ActivityLog::with('user')
            ->latest()
            ->limit(8)
            ->get();

        // Berita terbaru (draft)
        $draftBerita = Berita::where('status', 'draft')->count();

        return view('admin.dashboard.index', compact(
            'stats',
            'koperasiPerDistrik',
            'koperasiPerKategori',
            'bantuanPerTahun',
            'pendingKoperasi',
            'recentActivity',
            'draftBerita'
        ));
    }
}