@extends('public.layouts.app')
@section('title','Berita - DISPERINDAGKOP Tolikara')
@section('content')
<div class="page-header">
<div class="container">
<h1><i class="fas fa-newspaper mr-3"></i>Berita & Informasi</h1>
<nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('public.home') }}">Beranda</a></li><li class="breadcrumb-item active">Berita</li></ol></nav>
</div>
</div>
<section class="section">
<div class="container">
<div class="row">
<div class="col-lg-8">
<form method="GET" class="mb-4">
<div class="input-group">
<input type="text" name="search" class="form-control" placeholder="Cari berita..." value="{{ request('search') }}">
<div class="input-group-append"><button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button></div>
</div>
</form>
<div class="row">
@forelse($berita as $b)
<div class="col-md-6 mb-4">
<div class="card-news h-100">
@if($b->thumbnail)
<img src="{{ asset('storage/'.$b->thumbnail) }}" alt="{{ $b->judul }}" style="height:180px;object-fit:cover;width:100%">
@else
<div style="height:180px;background:linear-gradient(135deg,var(--primary),#2d5fad);display:flex;align-items:center;justify-content:center"><i class="fas fa-newspaper fa-3x" style="color:rgba(255,255,255,.3)"></i></div>
@endif
<div class="p-3">
<p class="news-meta"><i class="fas fa-calendar mr-1"></i>{{ $b->created_at->format('d M Y') }}</p>
<h5 style="font-size:15px">{{ Str::limit($b->judul,70) }}</h5>
<a href="{{ route('public.berita.detail',$b) }}" class="btn btn-sm btn-outline-primary">Baca →</a>
</div>
</div>
</div>
@empty
<div class="col-12 text-center py-5 text-muted"><i class="fas fa-newspaper fa-3x d-block mb-3"></i>Belum ada berita</div>
@endforelse
</div>
<div class="d-flex justify-content-center mt-3">{{ $berita->links('pagination::bootstrap-4') }}</div>
</div>
<div class="col-lg-4">
<div class="card border-0 shadow-sm" style="border-radius:12px">
<div class="card-header bg-white"><h6 class="mb-0 font-weight-bold" style="color:var(--primary)"><i class="fas fa-fire mr-2" style="color:var(--secondary)"></i>Berita Populer</h6></div>
<div class="card-body p-0">
@foreach($populer as $p)
<a href="{{ route('public.berita.detail',$p) }}" class="d-flex p-3 border-bottom text-decoration-none" style="color:inherit">
<div class="mr-3" style="width:60px;height:60px;border-radius:8px;overflow:hidden;flex-shrink:0;background:var(--light);display:flex;align-items:center;justify-content:center">
@if($p->foto)<img src="{{ asset('storage/'.$p->foto) }}" style="width:100%;height:100%;object-fit:cover">@else<i class="fas fa-newspaper text-muted"></i>@endif
</div>
<div><p style="font-size:13px;font-weight:600;margin:0;color:var(--primary)">{{ Str::limit($p->judul,50) }}</p><small class="text-muted">{{ $p->created_at->format('d M Y') }}</small></div>
</a>
@endforeach
</div>
</div>
</div>
</div>
</div>
</section>
@endsection
