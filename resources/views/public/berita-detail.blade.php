@extends('public.layouts.app')
@section('title', $berita->judul . ' - DISPERINDAGKOP Tolikara')
@section('content')
<div class="page-header">
<div class="container">
<h1 style="font-size:1.5rem">{{ Str::limit($berita->judul, 80) }}</h1>
<nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('public.home') }}">Beranda</a></li><li class="breadcrumb-item"><a href="{{ route('public.berita') }}">Berita</a></li><li class="breadcrumb-item active">Detail</li></ol></nav>
</div>
</div>
<section class="section">
<div class="container">
<div class="row">
<div class="col-lg-8">
<div class="card border-0 shadow-sm" style="border-radius:12px;overflow:hidden">
@if($berita->thumbnail)<img src="{{ asset('storage/'.$berita->thumbnail) }}" class="w-100" style="max-height:400px;object-fit:cover">@endif
<div class="p-4">
<p class="text-muted"><i class="fas fa-calendar mr-2"></i>{{ $berita->created_at->format('d F Y') }} <span class="mx-2">|</span><i class="fas fa-eye mr-1"></i>{{ $berita->views }} views</p>
<h2 class="font-weight-bold mb-4" style="color:var(--primary)">{{ $berita->judul }}</h2>
<div style="font-size:15px;line-height:1.8;color:#444">{!! $berita->konten !!}</div>
</div>
</div>
<a href="{{ route('public.berita') }}" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
</div>
<div class="col-lg-4 mt-4 mt-lg-0">
<div class="card border-0 shadow-sm" style="border-radius:12px">
<div class="card-header bg-white"><h6 class="mb-0 font-weight-bold" style="color:var(--primary)">Berita Lainnya</h6></div>
<div class="card-body p-0">
@foreach($lainnya as $l)
<a href="{{ route('public.berita.detail',$l) }}" class="d-flex p-3 border-bottom text-decoration-none">
<div class="mr-3" style="width:60px;height:60px;border-radius:8px;overflow:hidden;flex-shrink:0;background:var(--light)">
@if($l->foto)<img src="{{ asset('storage/'.$l->foto) }}" style="width:100%;height:100%;object-fit:cover">@else<div style="height:100%;display:flex;align-items:center;justify-content:center"><i class="fas fa-newspaper text-muted"></i></div>@endif
</div>
<div><p style="font-size:13px;font-weight:600;color:var(--primary);margin:0">{{ Str::limit($l->judul,50) }}</p><small class="text-muted">{{ $l->created_at->format('d M Y') }}</small></div>
</a>
@endforeach
</div>
</div>
</div>
</div>
</div>
</section>
@endsection
