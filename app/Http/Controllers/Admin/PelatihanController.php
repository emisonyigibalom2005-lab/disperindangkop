<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\PendaftaranPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelatihanController extends Controller
{
    public function index()
    {
        $pelatihan = Pelatihan::withCount('pendaftaran')->orderBy('tanggal_mulai', 'desc')->get();
        return view('admin.pelatihan.index', compact('pelatihan'));
    }
    public function create()
    {
        return view('admin.pelatihan.create');
    }
    public function store(Request $request)
    {
        $request->validate(['judul' => 'required', 'tanggal_mulai' => 'required|date']);
        $d = $request->only(['judul', 'deskripsi', 'penyelenggara', 'tanggal_mulai', 'tanggal_selesai', 'lokasi', 'kuota', 'status', 'syarat']);
        if ($request->hasFile('foto'))
            $d['foto'] = $request->file('foto')->store('pelatihan', 'public');
        Pelatihan::create($d);
        return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan berhasil ditambah!');
    }
    public function edit(Pelatihan $pelatihan)
    {
        return view('admin.pelatihan.edit', compact('pelatihan'));
    }
    public function update(Request $request, Pelatihan $pelatihan)
    {
        $request->validate(['judul' => 'required', 'tanggal_mulai' => 'required|date']);
        $d = $request->only(['judul', 'deskripsi', 'penyelenggara', 'tanggal_mulai', 'tanggal_selesai', 'lokasi', 'kuota', 'status', 'syarat']);
        if ($request->hasFile('foto')) {
            if ($pelatihan->foto)
                Storage::disk('public')->delete($pelatihan->foto);
            $d['foto'] = $request->file('foto')->store('pelatihan', 'public');
        }
        $pelatihan->update($d);
        return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan diperbarui!');
    }
    public function destroy(Pelatihan $pelatihan)
    {
        if ($pelatihan->foto)
            Storage::disk('public')->delete($pelatihan->foto);
        $pelatihan->delete();
        return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan dihapus!');
    }
    public function peserta(Pelatihan $pelatihan)
    {
        $peserta = $pelatihan->pendaftaran()->orderBy('created_at', 'desc')->get();
        return view('admin.pelatihan.peserta', compact('pelatihan', 'peserta'));
    }
    public function updateStatusPeserta(Request $request, PendaftaranPelatihan $pendaftaran)
    {
        $pendaftaran->update(['status' => $request->status, 'catatan' => $request->catatan]);
        return back()->with('success', 'Status peserta diperbarui!');
    }
}