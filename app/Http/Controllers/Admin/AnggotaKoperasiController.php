<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Koperasi;
use Illuminate\Http\Request;

class AnggotaKoperasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::with('koperasi')->whereNotNull('koperasi_id');
        
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                  ->orWhere('no_anggota', 'like', "%{$s}%")
                  ->orWhere('nik', 'like', "%{$s}%");
            });
        }
        
        if ($request->filled('koperasi_id')) {
            $query->where('koperasi_id', $request->koperasi_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $anggotaKoperasi = $query->latest()->paginate(15)->appends($request->query());
        $koperasiList = Koperasi::where('status_verifikasi', 'diverifikasi')->get();
        
        $stats = [
            'total' => Anggota::whereNotNull('koperasi_id')->count(),
            'aktif' => Anggota::whereNotNull('koperasi_id')->where('status', 'Aktif')->count(),
            'pending' => Anggota::whereNotNull('koperasi_id')->where('status', 'Pending')->count(),
        ];
        
        return view('admin.anggota-koperasi.index', compact('anggotaKoperasi', 'koperasiList', 'stats'));
    }
    
    public function create()
    {
        // Ambil daftar koperasi yang sudah diverifikasi
        $koperasiList = Koperasi::where('status_verifikasi', 'diverifikasi')
            ->where('status_usaha', 'aktif')
            ->get();
        
        // Ambil daftar anggota yang belum tergabung di koperasi manapun
        $anggotaBelumTergabung = Anggota::whereNull('koperasi_id')
            ->where('status', 'Aktif')
            ->get();
        
        return view('admin.anggota-koperasi.create', compact('koperasiList', 'anggotaBelumTergabung'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'koperasi_id' => 'required|exists:koperasi,id',
            'anggota_id' => 'required|exists:anggotas,id',
        ], [
            'koperasi_id.required' => 'Koperasi wajib dipilih',
            'koperasi_id.exists' => 'Koperasi tidak ditemukan',
            'anggota_id.required' => 'Anggota wajib dipilih',
            'anggota_id.exists' => 'Anggota tidak ditemukan',
        ]);
        
        try {
            $anggota = Anggota::findOrFail($validated['anggota_id']);
            $koperasi = Koperasi::findOrFail($validated['koperasi_id']);
            
            // Cek apakah anggota sudah tergabung di koperasi lain
            if ($anggota->koperasi_id) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Anggota sudah tergabung di koperasi: ' . $anggota->koperasi->nama_usaha);
            }
            
            // Tambahkan anggota ke koperasi
            $anggota->update([
                'koperasi_id' => $validated['koperasi_id']
            ]);
            
            // Kirim notifikasi ke anggota
            if ($anggota->user_id) {
                \App\Models\Notifikasi::create([
                    'user_id' => $anggota->user_id,
                    'judul' => '🎉 Anda Telah Bergabung dengan Koperasi',
                    'pesan' => 'Selamat! Anda telah bergabung dengan koperasi: ' . $koperasi->nama_usaha . '. Silakan cek dashboard Anda untuk informasi lebih lanjut.',
                    'tipe' => 'success',
                    'link' => route('anggota.dashboard'),
                    'is_read' => false,
                ]);
            }
            
            // Log activity
            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'create',
                'module' => 'Anggota Koperasi',
                'description' => 'Menambahkan anggota ' . $anggota->nama . ' ke koperasi ' . $koperasi->nama_usaha,
                'ip_address' => $request->ip(),
            ]);
            
            return redirect()->route('admin.anggota-koperasi.index')
                ->with('success', 'Anggota berhasil ditambahkan ke koperasi: ' . $koperasi->nama_usaha);
                
        } catch (\Exception $e) {
            \Log::error('Error menambahkan anggota ke koperasi: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $anggota = Anggota::findOrFail($id);
            $koperasiNama = $anggota->koperasi ? $anggota->koperasi->nama_usaha : '-';
            
            // Hapus dari koperasi (set koperasi_id = null)
            $anggota->update([
                'koperasi_id' => null
            ]);
            
            // Kirim notifikasi ke anggota
            if ($anggota->user_id) {
                \App\Models\Notifikasi::create([
                    'user_id' => $anggota->user_id,
                    'judul' => 'Anda Telah Dikeluarkan dari Koperasi',
                    'pesan' => 'Anda telah dikeluarkan dari koperasi: ' . $koperasiNama . '. Silakan hubungi admin untuk informasi lebih lanjut.',
                    'tipe' => 'warning',
                    'link' => route('anggota.dashboard'),
                    'is_read' => false,
                ]);
            }
            
            // Log activity
            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'delete',
                'module' => 'Anggota Koperasi',
                'description' => 'Mengeluarkan anggota ' . $anggota->nama . ' dari koperasi ' . $koperasiNama,
                'ip_address' => request()->ip(),
            ]);
            
            return redirect()->route('admin.anggota-koperasi.index')
                ->with('success', 'Anggota berhasil dikeluarkan dari koperasi.');
                
        } catch (\Exception $e) {
            \Log::error('Error mengeluarkan anggota dari koperasi: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
