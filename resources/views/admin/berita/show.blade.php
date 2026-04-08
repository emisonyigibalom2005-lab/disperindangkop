@extends('layouts.admin')
@section('title', 'Detail Berita')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Detail Berita</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST"
                onsubmit="return confirm('Hapus berita ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">← Kembali</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            @if ($berita->thumbnail)
                <img src="{{ asset('storage/' . $berita->thumbnail) }}"
                    class="img-fluid rounded mb-4" style="max-height:300px; width:100%; object-fit:cover;">
            @endif

            <div class="d-flex gap-2 mb-3">
                <span class="badge bg-{{ $berita->status === 'publish' ? 'success' : 'secondary' }} fs-6">
                    {{ ucfirst($berita->status) }}
                </span>
                <span class="badge bg-info fs-6">{{ ucfirst($berita->kategori) }}</span>
            </div>

            <h2>{{ $berita->judul }}</h2>

            <p class="text-muted">
                Oleh <strong>{{ $berita->createdBy?->name ?? '-' }}</strong>
                · {{ $berita->created_at->format('d M Y, H:i') }}
                @if ($berita->published_at)
                    · Dipublikasikan: {{ $berita->published_at->format('d M Y, H:i') }}
                @endif
            </p>

            <hr>

            <div class="mt-3" style="line-height:1.8;">
                {!! nl2br(e($berita->konten)) !!}
            </div>
        </div>
    </div>
</div>
@endsection