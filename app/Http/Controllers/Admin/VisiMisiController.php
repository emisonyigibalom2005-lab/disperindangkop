<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisiMisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisiMisiController extends Controller
{
    public function index()
    {
        $visiMisi = VisiMisi::first();
        return view('admin.visi_misi.index', compact('visiMisi'));
    }

    public function create()
    {
        // Cek apakah sudah ada data
        $exists = VisiMisi::exists();
        if ($exists) {
            return redirect()->route('admin.visi-misi.index')
                ->with('error', 'Visi & Misi sudah ada. Silakan edit yang sudah ada.');
        }
        
        return view('admin.visi_misi.create');
    }

    public function store(Request $request)
    {
        // Cek apakah sudah ada data
        $exists = VisiMisi::exists();
        if ($exists) {
            return redirect()->route('admin.visi-misi.index')
                ->with('error', 'Visi & Misi sudah ada. Silakan edit yang sudah ada.');
        }

        $request->validate([
            'visi' => 'required',
            'misi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $data = $request->only(['visi', 'misi', 'status']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('visi-misi', 'public');
        }

        VisiMisi::create($data);

        return redirect()->route('admin.visi-misi.index')
            ->with('success', 'Visi & Misi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $visiMisi = VisiMisi::findOrFail($id);
        return view('admin.visi_misi.edit', compact('visiMisi'));
    }

    public function update(Request $request, $id)
    {
        $visiMisi = VisiMisi::findOrFail($id);

        $request->validate([
            'visi' => 'required',
            'misi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $data = $request->only(['visi', 'misi', 'status']);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($visiMisi->gambar) {
                Storage::disk('public')->delete($visiMisi->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('visi-misi', 'public');
        }

        $visiMisi->update($data);

        return redirect()->route('admin.visi-misi.index')
            ->with('success', 'Visi & Misi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $visiMisi = VisiMisi::findOrFail($id);

        // Hapus gambar jika ada
        if ($visiMisi->gambar) {
            Storage::disk('public')->delete($visiMisi->gambar);
        }

        $visiMisi->delete();

        return redirect()->route('admin.visi-misi.index')
            ->with('success', 'Visi & Misi berhasil dihapus.');
    }
}
