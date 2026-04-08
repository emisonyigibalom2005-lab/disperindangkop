<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::orderBy('urutan', 'asc')->paginate(8);
        return view('admin.galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'kategori' => 'required',
            'urutan' => 'nullable|integer',
            'is_active' => 'required|boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('galeri', 'public');
        }

        Galeri::create($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function show(Galeri $galeri)
    {
        return view('admin.galeri.show', compact('galeri'));
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kategori' => 'required',
            'urutan' => 'nullable|integer',
            'is_active' => 'required|boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('galeri', 'public');
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Galeri $galeri)
    {
        if ($galeri->foto && \Storage::disk('public')->exists($galeri->foto)) {
            \Storage::disk('public')->delete($galeri->foto);
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
