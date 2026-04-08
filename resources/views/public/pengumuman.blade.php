@extends('public.layouts.app')
@section('title','Pengumuman - DISPERINDAGKOP Tolikara')
@section('content')
<style>
.page-header{background:linear-gradient(135deg,#0d2240,#1a3a6e);padding:60px 0 40px;color:#fff;}
.peng-card{background:#fff;border-radius:16px;box-shadow:0 2px 20px rgba(0,0,0,.07);overflow:hidden;margin-bottom:24px;transition:transform .3s;}
.peng-card:hover{transform:translateY(-4px);}
.peng-badge{display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:4px 12px;border-radius:100px;margin-bottom:12px;}
.bi{background:#eff6ff;color:#1d4ed8;}
.bw{background:#fffbeb;color:#a16207;}
.bs{background:#f0fdf4;color:#15803d;}
.bd{background:#fff1f2;color:#be123c;}
</style>

<div class="page-header">
    <div class="container">
        <h1 class="mb-1"><i class="fas fa-bullhorn mr-3"></i>Pengumuman</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0">
                <li class="breadcrumb-item"><a href="{{ route('public.home') }}" class="text-white-50">Beranda</a></li>
                <li class="breadcrumb-item active text-white">Pengumuman</li>
            </ol>
        </nav>
    </div>
</div>

<section style="padding:60px 0;background:#f5f7fc;">
<div class="container">
    @forelse($pengumuman as $p)
    <div class="peng-card">
        @if($p->foto)
        <img src="{{ asset('storage/'.$p->foto) }}" style="width:100%;max-height:300px;object-fit:cover;" alt="{{ $p->judul }}">
        @endif

        @if($p->video)
            @if($p->jenis_video === 'youtube' && $p->youtube_embed)
            <div style="aspect-ratio:16/9">
                <iframe src="{{ $p->youtube_embed }}" style="width:100%;height:100%;border:0;" allowfullscreen></iframe>
            </div>
            @elseif($p->jenis_video === 'upload')
            <video controls style="width:100%;aspect-ratio:16/9;">
                <source src="{{ asset('storage/'.$p->video) }}" type="video/mp4">
            </video>
            @endif
        @endif

        <div style="padding:24px 28px;">
            @php
                $bc = ['info'=>'bi','warning'=>'bw','success'=>'bs','danger'=>'bd'][$p->jenis] ?? 'bi';
                $emoji = ['info'=>'📘','warning'=>'⚠️','success'=>'✅','danger'=>'🚨'][$p->jenis] ?? 'ℹ️';
            @endphp
            <span class="peng-badge {{ $bc }}">{{ $emoji }} {{ ucfirst($p->jenis) }}</span>
            <small class="text-muted ml-2"><i class="fas fa-calendar-alt mr-1"></i>{{ $p->created_at->format('d F Y') }}</small>

            <h4 style="font-weight:800;color:#1a3a6e;margin:10px 0 12px;">{{ $p->judul }}</h4>
            <p style="color:#4a5568;line-height:1.85;font-size:14.5px;">{{ $p->isi }}</p>

            @if($p->link)
            <a href="{{ $p->link }}" target="_blank" class="btn btn-sm btn-primary mt-2">
                <i class="fas fa-external-link-alt mr-1"></i> Selengkapnya
            </a>
            @endif

            {{-- TOMBOL DOWNLOAD PDF --}}
            <a href="{{ route('public.pengumuman.download', $p->id) }}" 
               class="btn btn-sm btn-outline-danger mt-2 ml-1" target="_blank">
                <i class="fas fa-file-pdf mr-1"></i> Download PDF
            </a>

        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <i class="fas fa-bullhorn fa-4x d-block mb-3" style="color:#ddd;"></i>
        <p class="text-muted">Belum ada pengumuman saat ini.</p>
    </div>
    @endforelse

    <div class="d-flex justify-content-center mt-3">
        {{ $pengumuman->links('pagination::bootstrap-4') }}
    </div>
</div>
</section>
@endsection
