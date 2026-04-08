@extends('public.layouts.app')
@section('title','Galeri - DISPERINDAGKOP Tolikara')
@section('content')

<div class="page-header">
    <div class="container">
        <h1><i class="fas fa-images mr-3"></i>Galeri Kegiatan</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Galeri</li>
        </ol></nav>
    </div>
</div>

<section class="section">
<div class="container">

{{-- Tab Filter --}}
<div class="d-flex justify-content-center mb-4">
    <div class="btn-group">
        <a href="{{ route('public.galeri') }}"
           class="btn {{ !$tipe ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-th mr-1"></i> Semua
        </a>
        <a href="{{ route('public.galeri') }}?tipe=foto"
           class="btn {{ $tipe=='foto' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-camera mr-1"></i> Foto
        </a>
        <a href="{{ route('public.galeri') }}?tipe=video"
           class="btn {{ $tipe=='video' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-video mr-1"></i> Video
        </a>
    </div>
</div>

<div class="row">
@forelse($galeri as $g)
<div class="col-lg-4 col-md-6 mb-4">
    <div class="galeri-card">
        <div class="galeri-card-img">
            <img src="{{ asset('storage/'.$g->foto) }}"
                 alt="{{ $g->judul }}"
                 onerror="this.src='https://via.placeholder.com/500x320?text=Foto+Kegiatan'">
            {{-- Badge kategori pojok kiri atas --}}
            @if($g->kategori)
            <span class="galeri-badge">{{ $g->kategori }}</span>
            @endif
            {{-- Tombol zoom --}}
            <a href="{{ asset('storage/'.$g->foto) }}" target="_blank" class="galeri-zoom">
                <i class="fas fa-expand-alt"></i>
            </a>
        </div>
        <div class="galeri-card-body">
            <h6 class="galeri-judul">{{ $g->judul }}</h6>
            @if($g->deskripsi)
            <p class="galeri-desc">{{ Str::limit($g->deskripsi, 80) }}</p>
            @endif
            <div class="galeri-meta">
                <span><i class="fas fa-calendar-alt mr-1"></i>{{ $g->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12 text-center py-5 text-muted">
    <i class="fas fa-images fa-4x d-block mb-3" style="opacity:.2"></i>
    Belum ada foto galeri
</div>
@endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $galeri->links('pagination::bootstrap-4') }}
</div>

</div>
</section>

@push('styles')
<style>
.galeri-card {
    border-radius: 16px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
    transition: all .35s cubic-bezier(.22,.61,.36,1);
    height: 100%;
}
.galeri-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 48px rgba(26,58,110,.15);
}
.galeri-card-img {
    position: relative;
    height: 240px;
    overflow: hidden;
}
.galeri-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .45s ease;
}
.galeri-card:hover .galeri-card-img img {
    transform: scale(1.08);
}
.galeri-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    background: var(--accent);
    color: #1a1a1a;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 100px;
    letter-spacing: .5px;
    text-transform: uppercase;
}
.galeri-zoom {
    position: absolute;
    top: 14px;
    right: 14px;
    width: 36px;
    height: 36px;
    background: rgba(255,255,255,.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 14px;
    opacity: 0;
    transition: opacity .3s;
    text-decoration: none;
}
.galeri-card:hover .galeri-zoom {
    opacity: 1;
}
.galeri-card-body {
    padding: 20px 22px 22px;
    border-top: 3px solid var(--accent);
}
.galeri-judul {
    font-weight: 700;
    color: var(--primary);
    font-size: 15px;
    margin-bottom: 6px;
    line-height: 1.4;
}
.galeri-desc {
    font-size: 13px;
    color: #5a6475;
    line-height: 1.7;
    margin-bottom: 12px;
}
.galeri-meta {
    font-size: 12px;
    color: #9aa0ad;
    font-weight: 600;
}
.galeri-meta i {
    color: var(--accent);
}
</style>
@endpush
@endsection
