@extends('layouts.admin')
@section('title', 'Galeri Kegiatan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Galeri Kegiatan</h1>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary">+ Tambah Foto</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse ($galeri as $item)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="{{ asset('storage/' . $item->foto) }}"
                    class="card-img-top" style="height:180px; object-fit:cover;">
                <div class="card-body">
                    <h6 class="card-title">{{ $item->judul }}</h6>
                    @if ($item->deskripsi)
                        <p class="card-text text-muted small">{{ Str::limit($item->deskripsi, 60) }}</p>
                    @endif
                </div>
                <div class="card-footer d-flex gap-2">
                    <a href="{{ route('admin.galeri.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.galeri.destroy', $item) }}" method="POST"
                        onsubmit="return confirm('Hapus foto ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center text-muted py-4">Belum ada foto galeri.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-3">{{ $galeri->links() }}</div>
</div>
@endsection