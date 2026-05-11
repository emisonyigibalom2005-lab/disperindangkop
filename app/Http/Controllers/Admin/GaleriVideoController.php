<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;

class GaleriVideoController extends Controller
{
    public function index(Request $request)
    {
        $galeri = Galeri::where('tipe', 'video')
            ->with('createdBy')
            ->orderBy('urutan', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('admin.galeri-video.index', compact('galeri'));
    }

    public function create()
    {
        return view('admin.galeri-video.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'video_url' => 'required|url',
            'deskripsi' => 'nullable',
            'kategori' => 'nullable|string'
        ]);

        $data = [
            'tipe' => 'video',
            'judul' => $request->judul,
            'video_url' => $request->video_url,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori ?? 'kegiatan',
            'urutan' => Galeri::where('tipe', 'video')->max('urutan') + 1,
            'is_active' => true,
            'created_by' => auth()->id()
        ];

        // Generate thumbnail from YouTube URL
        if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $request->video_url, $matches)) {
            $data['foto'] = 'https://img.youtube.com/vi/' . $matches[1] . '/maxresdefault.jpg';
        } elseif (preg_match('/youtu\.be\/([^?]+)/', $request->video_url, $matches)) {
            $data['foto'] = 'https://img.youtube.com/vi/' . $matches[1] . '/maxresdefault.jpg';
        }

        Galeri::create($data);

        return redirect()->route('admin.galeri-video.index')
            ->with('success', 'Video berhasil ditambahkan ke galeri');
    }

    public function show($id)
    {
        $galeriVideo = Galeri::where('tipe', 'video')->findOrFail($id);
        return view('admin.galeri-video.show', compact('galeriVideo'));
    }

    public function edit($id)
    {
        $galeriVideo = Galeri::where('tipe', 'video')->findOrFail($id);
        return view('admin.galeri-video.edit', compact('galeriVideo'));
    }

    public function update(Request $request, $id)
    {
        $galeriVideo = Galeri::where('tipe', 'video')->findOrFail($id);

        $request->validate([
            'judul' => 'required|max:255',
            'video_url' => 'required|url',
            'deskripsi' => 'nullable',
            'kategori' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $data = [
            'judul' => $request->judul,
            'video_url' => $request->video_url,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori ?? 'kegiatan',
            'urutan' => $request->urutan ?? $galeriVideo->urutan,
            'is_active' => $request->has('is_active') ? $request->is_active : true
        ];

        // Update thumbnail from YouTube URL
        if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $request->video_url, $matches)) {
            $data['foto'] = 'https://img.youtube.com/vi/' . $matches[1] . '/maxresdefault.jpg';
        } elseif (preg_match('/youtu\.be\/([^?]+)/', $request->video_url, $matches)) {
            $data['foto'] = 'https://img.youtube.com/vi/' . $matches[1] . '/maxresdefault.jpg';
        }

        $galeriVideo->update($data);

        return redirect()->route('admin.galeri-video.index')
            ->with('success', 'Video berhasil diupdate');
    }

    public function destroy($id)
    {
        $galeriVideo = Galeri::where('tipe', 'video')->findOrFail($id);

        try {
            $galeriVideo->delete();

            return redirect()->route('admin.galeri-video.index')
                ->with('success', 'Video berhasil dihapus dari galeri');
        } catch (\Exception $e) {
            return redirect()->route('admin.galeri-video.index')
                ->with('error', 'Gagal menghapus video: ' . $e->getMessage());
        }
    }
}
