<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::with('createdBy');

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $berita = $query->latest()->paginate(15)->appends($request->query());

        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|string|max:100',
            'status' => 'required|in:draft,published,archived',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('berita', 'public');
        }

        $berita = Berita::create([
            'judul' => $request->judul,
            'slug' => Berita::generateSlug($request->judul),
            'konten' => $request->konten,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'thumbnail' => $thumbnailPath,
            'created_by' => auth()->id(),
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.berita.show', $berita)
            ->with('success', 'Berita berhasil disimpan.');
    }

    public function show($id) { $berita = Berita::findOrFail($id); return view('admin.berita.show', compact('berita')); } public function show_unused(Berita $berita)
    {
        return view('admin.berita.show', compact('berita'));
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|string|max:100',
            'status' => 'required|in:draft,published,archived',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $thumbnailPath = $berita->thumbnail;
        if ($request->hasFile('thumbnail')) {
            if ($berita->thumbnail) {
                Storage::disk('public')->delete($berita->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('berita', 'public');
        }

        $berita->update([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'thumbnail' => $thumbnailPath,
            'published_at' => $request->status === 'published' && !$berita->published_at
                ? now()
                : $berita->published_at,
        ]);

        return redirect()->route('admin.berita.show', $berita)
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->thumbnail) {
            Storage::disk('public')->delete($berita->thumbnail);
        }
        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function publish(Berita $berita)
    {
        $berita->update([
            'status' => 'published',
            'published_at' => $berita->published_at ?? now(),
        ]);

        return redirect()->route('admin.berita.show', $berita)
            ->with('success', 'Berita berhasil dipublikasikan.');
    }
}