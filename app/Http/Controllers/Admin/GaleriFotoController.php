<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;

class GaleriFotoController extends Controller
{
    public function index(Request $request)
    {
        $galeri = Galeri::where('tipe', 'foto')
            ->with('createdBy')
            ->orderBy('urutan', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('admin.galeri-foto.index', compact('galeri'));
    }

    public function create()
    {
        return view('admin.galeri-foto.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'judul' => 'nullable|max:255',
            'deskripsi' => 'nullable',
            'kategori' => 'nullable|string'
        ]);

        $data = [
            'tipe' => 'foto',
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori ?? 'kegiatan',
            'urutan' => Galeri::where('tipe', 'foto')->max('urutan') + 1,
            'is_active' => true,
            'created_by' => auth()->id()
        ];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['foto'] = $file->storeAs('galeri', $filename, 'public');
            
            // Gunakan judul dari input atau auto-generate dari nama file
            if ($request->filled('judul')) {
                $data['judul'] = $request->judul;
            } else {
                $originalName = $file->getClientOriginalName();
                $data['judul'] = pathinfo($originalName, PATHINFO_FILENAME);
            }
        }

        Galeri::create($data);

        return redirect()->route('admin.galeri-foto.index')
            ->with('success', 'Foto berhasil ditambahkan ke galeri');
    }

    public function show($id)
    {
        $galeriFoto = Galeri::where('tipe', 'foto')->findOrFail($id);
        return view('admin.galeri-foto.show', compact('galeriFoto'));
    }

    public function edit($id)
    {
        $galeriFoto = Galeri::where('tipe', 'foto')->findOrFail($id);
        return view('admin.galeri-foto.edit', compact('galeriFoto'));
    }

    public function update(Request $request, $id)
    {
        $galeriFoto = Galeri::where('tipe', 'foto')->findOrFail($id);

        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'judul' => 'nullable|max:255',
            'deskripsi' => 'nullable',
            'kategori' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $data = [
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori ?? 'kegiatan',
            'urutan' => $request->urutan ?? $galeriFoto->urutan,
            'is_active' => $request->has('is_active') ? $request->is_active : true
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($galeriFoto->foto && \Storage::disk('public')->exists($galeriFoto->foto)) {
                \Storage::disk('public')->delete($galeriFoto->foto);
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['foto'] = $file->storeAs('galeri', $filename, 'public');
            
            // Update judul jika ada input atau auto-generate dari nama file baru
            if ($request->filled('judul')) {
                $data['judul'] = $request->judul;
            } else {
                $originalName = $file->getClientOriginalName();
                $data['judul'] = pathinfo($originalName, PATHINFO_FILENAME);
            }
        } else {
            // Jika tidak upload foto baru, update judul jika ada input
            if ($request->filled('judul')) {
                $data['judul'] = $request->judul;
            }
        }

        $galeriFoto->update($data);

        return redirect()->route('admin.galeri-foto.index')
            ->with('success', 'Foto berhasil diupdate');
    }

    public function destroy($id)
    {
        $galeriFoto = Galeri::where('tipe', 'foto')->findOrFail($id);

        try {
            // Hapus file foto
            if ($galeriFoto->foto && \Storage::disk('public')->exists($galeriFoto->foto)) {
                \Storage::disk('public')->delete($galeriFoto->foto);
            }

            $galeriFoto->delete();

            return redirect()->route('admin.galeri-foto.index')
                ->with('success', 'Foto berhasil dihapus dari galeri');
        } catch (\Exception $e) {
            return redirect()->route('admin.galeri-foto.index')
                ->with('error', 'Gagal menghapus foto: ' . $e->getMessage());
        }
    }
}
