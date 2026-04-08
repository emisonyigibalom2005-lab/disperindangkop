<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Bantuan;
use App\Models\JadwalDistribusi;
use App\Models\Notifikasi;
use App\Models\PenerimaBantuan;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BantuanController extends Controller
{
    public function index(Request $request)
    {
        $query = Bantuan::with('createdBy');

        if ($request->filled('search')) {
            $query->where('nama_bantuan', 'like', '%' . $request->search . '%')
                ->orWhere('kode_bantuan', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bantuan = $query->latest()->paginate(15)->appends($request->query());

        return view('admin.bantuan.index', compact('bantuan'));
    }

    public function create()
    {
        return view('admin.bantuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bantuan' => 'required|string|max:255',
            'jenis_bantuan' => 'required|in:tunai,barang,pelatihan,lainnya',
            'tahun' => 'required|integer|min:2020|max:2099',
            'periode' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'anggaran' => 'required|numeric|min:0',
            'kuota' => 'required|integer|min:1',
        ]);

        $bantuan = Bantuan::create([
            'kode_bantuan' => Bantuan::generateKode(),
            'nama_bantuan' => $request->nama_bantuan,
            'jenis_bantuan' => $request->jenis_bantuan,
            'tahun' => $request->tahun,
            'periode' => $request->periode,
            'deskripsi' => $request->deskripsi,
            'anggaran' => $request->anggaran,
            'kuota' => $request->kuota,
            'status' => 'aktif',
            'created_by' => auth()->id(),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'module' => 'Bantuan',
            'description' => 'Membuat program bantuan: ' . $bantuan->kode_bantuan,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.bantuan.show', $bantuan)
            ->with('success', 'Program bantuan berhasil dibuat dengan kode ' . $bantuan->kode_bantuan);
    }

    public function show(Bantuan $bantuan)
    {
        $bantuan->load('createdBy', 'penerima.koperasi', 'jadwal.petugas');
        $koperasiTersedia = Koperasi::where('status_verifikasi', 'diverifikasi')
            ->where('status_usaha', 'aktif')
            ->whereNotIn('id', $bantuan->penerima->pluck('koperasi_id'))
            ->get();

        return view('admin.bantuan.show', compact('bantuan', 'koperasiTersedia'));
    }

    public function edit(Bantuan $bantuan)
    {
        return view('admin.bantuan.edit', compact('bantuan'));
    }

    public function update(Request $request, Bantuan $bantuan)
    {
        $request->validate([
            'nama_bantuan' => 'required|string|max:255',
            'jenis_bantuan' => 'required|in:tunai,barang,pelatihan,lainnya',
            'tahun' => 'required|integer|min:2020|max:2099',
            'periode' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'anggaran' => 'required|numeric|min:0',
            'kuota' => 'required|integer|min:1',
            'status' => 'required|in:aktif,selesai,dibatalkan',
        ]);

        $bantuan->update($request->only([
            'nama_bantuan',
            'jenis_bantuan',
            'tahun',
            'periode',
            'deskripsi',
            'anggaran',
            'kuota',
            'status',
        ]));

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'module' => 'Bantuan',
            'description' => 'Mengubah program bantuan: ' . $bantuan->kode_bantuan,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.bantuan.show', $bantuan)
            ->with('success', 'Program bantuan berhasil diperbarui.');
    }

    public function destroy(Bantuan $bantuan)
    {
        $kode = $bantuan->kode_bantuan;
        $bantuan->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'module' => 'Bantuan',
            'description' => 'Menghapus program bantuan: ' . $kode,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('admin.bantuan.index')
            ->with('success', 'Program bantuan berhasil dihapus.');
    }

    public function penerima(Bantuan $bantuan)
    {
        $bantuan->load('penerima.koperasi');
        $koperasiTersedia = Koperasi::where('status_verifikasi', 'diverifikasi')
            ->where('status_usaha', 'aktif')
            ->whereNotIn('id', $bantuan->penerima->pluck('koperasi_id'))
            ->get();

        return view('admin.bantuan.penerima', compact('bantuan', 'koperasiTersedia'));
    }

    public function tambahPenerima(Request $request, Bantuan $bantuan)
    {
        $request->validate([
            'koperasi_id' => 'required|exists:koperasi,id',
            'jumlah_bantuan' => 'required|numeric|min:0',
        ]);

        // Cek duplikasi
        $exists = PenerimaBantuan::where('bantuan_id', $bantuan->id)
            ->where('koperasi_id', $request->koperasi_id)->exists();

        if ($exists) {
            return back()->with('error', 'Koperasi ini sudah terdaftar sebagai penerima bantuan ini.');
        }

        // Cek kuota
        if ($bantuan->penerima()->count() >= $bantuan->kuota) {
            return back()->with('error', 'Kuota penerima bantuan sudah penuh (' . $bantuan->kuota . ' orang).');
        }

        $penerima = PenerimaBantuan::create([
            'bantuan_id' => $bantuan->id,
            'koperasi_id' => $request->koperasi_id,
            'jumlah_bantuan' => $request->jumlah_bantuan,
            'status' => 'terdaftar',
        ]);

        // Kirim notifikasi ke koperasi
        $koperasi = Koperasi::find($request->koperasi_id);
        if ($koperasi && $koperasi->user_id) {
            Notifikasi::create([
                'user_id' => $koperasi->user_id,
                'judul' => 'Terdaftar Sebagai Penerima Bantuan',
                'pesan' => 'Anda terdaftar sebagai penerima ' . $bantuan->nama_bantuan . '. Silahkan cek jadwal distribusi.',
                'jenis' => 'success',
                'url' => route('koperasi.bantuan.riwayat'),
            ]);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'module' => 'Bantuan',
            'description' => 'Menambah penerima bantuan: ' . ($koperasi->nama_usaha ?? '-') . ' ke ' . $bantuan->kode_bantuan,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Koperasi berhasil ditambahkan sebagai penerima bantuan.');
    }

    public function validasiPenerima(Request $request, PenerimaBantuan $penerima)
    {
        $request->validate([
            'status' => 'required|in:divalidasi,diterima,ditolak',
            'tanggal_penerimaan' => 'nullable|date',
            'catatan' => 'nullable|string|max:500',
        ]);

        $penerima->update([
            'status' => $request->status,
            'tanggal_penerimaan' => $request->tanggal_penerimaan,
            'catatan' => $request->catatan,
            'validated_by' => auth()->id(),
            'validated_at' => now(),
        ]);

        // Notifikasi ke Koperasi
        if ($penerima->koperasi && $penerima->koperasi->user_id) {
            $pesan = $request->status === 'diterima'
                ? 'Bantuan ' . $penerima->bantuan->nama_bantuan . ' telah diterima.'
                : 'Status bantuan ' . $penerima->bantuan->nama_bantuan . ' diperbarui menjadi ' . $request->status . '.';

            Notifikasi::create([
                'user_id' => $penerima->koperasi->user_id,
                'judul' => 'Update Status Bantuan',
                'pesan' => $pesan,
                'jenis' => $request->status === 'diterima' ? 'success' : 'info',
                'url' => route('koperasi.bantuan.riwayat'),
            ]);
        }

        return back()->with('success', 'Status penerima bantuan berhasil diperbarui.');
    }

    public function cetakSK(PenerimaBantuan $penerima)
    {
        $penerima->load('koperasi', 'bantuan');
        $pdf = Pdf::loadView('admin.bantuan.pdf.sk', compact('penerima'))
            ->setPaper('a4', 'portrait');
        return $pdf->download('SK-Bantuan-' . $penerima->koperasi->no_registrasi . '.pdf');
    }
}