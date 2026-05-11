@extends('public.layouts.app')
@section('title','Direktori Koperasi - DISPERINDAGKOP Tolikara')

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 100%);
    padding: 60px 0 40px;
    color: #fff;
}

.anggota-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid #e5e7eb;
    height: 100%;
}

.anggota-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(26,58,110,0.15);
    border-color: #1a3a6e;
}

.anggota-header {
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    padding: 25px 20px;
    text-align: center;
    position: relative;
}

.anggota-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f5a623, #fdb944);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-size: 36px;
    color: #fff;
    font-weight: 800;
    box-shadow: 0 4px 15px rgba(245,166,35,0.4);
    border: 4px solid rgba(255,255,255,0.3);
}

.anggota-body {
    padding: 20px;
}

.info-item {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
}

.info-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    flex-shrink: 0;
    font-size: 14px;
}

.badge-distrik {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    display: inline-block;
    margin-bottom: 8px;
}

.badge-desa {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 10px;
    font-weight: 600;
    display: inline-block;
}
</style>
@endpush

@section('content')
<div class="page-header">
<div class="container">
<h1><i class="fas fa-users mr-3"></i>Direktori Anggota Koperasi</h1>
<nav aria-label="breadcrumb">
<ol class="breadcrumb" style="background:transparent;padding:0;margin-top:10px">
<li class="breadcrumb-item"><a href="{{ route('public.home') }}" style="color:rgba(255,255,255,0.9)">Beranda</a></li>
<li class="breadcrumb-item active" style="color:#fff">Direktori Anggota Koperasi</li>
</ol>
</nav>
</div>
</div>

<section class="section">
<div class="container">

<!-- Search & Filter -->
<div class="card border-0 shadow-sm mb-4" style="border-radius:12px">
<div class="card-body p-4">
<form method="GET">
<div class="row">
<div class="col-md-7 mb-3 mb-md-0">
<div class="input-group">
<div class="input-group-prepend"><span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span></div>
<input type="text" name="search" class="form-control border-left-0" placeholder="Cari nama anggota, nama usaha, no. anggota..." value="{{ request('search') }}">
</div>
</div>
<div class="col-md-3 mb-3 mb-md-0">
<select name="distrik" class="form-control">
<option value="">Semua Distrik</option>
@foreach($distrik as $d)
<option value="{{ $d }}" {{ request('distrik')===$d?'selected':'' }}>{{ $d }}</option>
@endforeach
</select>
</div>
<div class="col-md-1">
<button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
</div>
<div class="col-md-1">
<a href="{{ route('public.koperasi') }}" class="btn btn-secondary w-100"><i class="fas fa-times"></i></a>
</div>
</div>
</form>
</div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
<p class="text-muted mb-0">Menampilkan <strong>{{ $anggota->total() }}</strong> Anggota Koperasi terdaftar</p>
</div>

<div class="row">
@forelse($anggota as $a)
<div class="col-md-4 col-sm-6 mb-4">
<div class="anggota-card">
<div class="anggota-header">
<div class="anggota-avatar">
{{ strtoupper(substr($a->nama, 0, 1)) }}
</div>
<h5 style="color:#fff;font-weight:800;margin-bottom:5px;font-size:17px">{{ $a->nama }}</h5>
<small style="color:rgba(255,255,255,0.9);font-weight:600;font-size:12px">{{ $a->no_anggota }}</small>
</div>

<div class="anggota-body">
<div class="text-center mb-3">
<span class="badge-distrik">
<i class="fas fa-map-marked-alt mr-1"></i>{{ $a->distrik }}
</span>
@if($a->desa && $a->desa != '-')
<span class="badge-desa">
<i class="fas fa-map-marker-alt mr-1"></i>{{ $a->desa }}
</span>
@endif
</div>

<div class="info-item">
<div class="info-icon" style="background:#fef3c7">
<i class="fas fa-store" style="color:#d97706"></i>
</div>
<div style="flex:1">
<small style="color:#6b7280;font-size:11px;display:block">Nama Usaha</small>
<strong style="color:#1a3a6e;font-size:13px">{{ $a->nama_usaha }}</strong>
</div>
</div>

@if($a->bidang_usaha)
<div class="info-item">
<div class="info-icon" style="background:#dbeafe">
<i class="fas fa-briefcase" style="color:#1e40af"></i>
</div>
<div style="flex:1">
<small style="color:#6b7280;font-size:11px;display:block">Bidang Usaha</small>
<strong style="color:#1a3a6e;font-size:13px">{{ $a->bidang_usaha }}</strong>
</div>
</div>
@endif

@if($a->lama_berdiri_usaha)
<div class="info-item">
<div class="info-icon" style="background:#d1fae5">
<i class="fas fa-calendar-alt" style="color:#047857"></i>
</div>
<div style="flex:1">
<small style="color:#6b7280;font-size:11px;display:block">Lama Berdiri</small>
<strong style="color:#1a3a6e;font-size:13px">{{ $a->lama_berdiri_usaha }}</strong>
</div>
</div>
@endif

@if($a->jumlah_karyawan)
<div class="info-item">
<div class="info-icon" style="background:#ede9fe">
<i class="fas fa-users" style="color:#6d28d9"></i>
</div>
<div style="flex:1">
<small style="color:#6b7280;font-size:11px;display:block">Jumlah Karyawan</small>
<strong style="color:#1a3a6e;font-size:13px">{{ $a->jumlah_karyawan }} orang</strong>
</div>
</div>
@endif

<div class="mt-3">
<a href="{{ route('public.koperasi.detail', $a->id) }}" class="btn btn-primary btn-block" style="border-radius:10px;font-weight:700;padding:12px;font-size:14px;box-shadow:0 4px 12px rgba(26,58,110,0.3);transition:all 0.3s ease" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 16px rgba(26,58,110,0.4)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 12px rgba(26,58,110,0.3)'">
<i class="fas fa-book-open mr-2"></i>Baca Selengkapnya
</a>
</div>

<div class="mt-2 text-center">
<span class="badge" style="background:linear-gradient(135deg,#10b981,#059669);color:#fff;padding:8px 16px;font-size:12px;border-radius:20px;font-weight:700;box-shadow:0 2px 8px rgba(16,185,129,0.3)">
<i class="fas fa-check-circle mr-1"></i>Terverifikasi
</span>
</div>
</div>
</div>
</div>
@empty
<div class="col-12">
<div class="text-center py-5">
<i class="fas fa-users fa-4x text-muted mb-3 d-block"></i>
<h5 class="text-muted">Anggota Koperasi tidak ditemukan</h5>
<p class="text-muted">Coba ubah kata kunci atau filter pencarian</p>
<a href="{{ route('public.koperasi') }}" class="btn btn-primary">Reset Pencarian</a>
</div>
</div>
@endforelse
</div>

<div class="d-flex justify-content-center mt-4">
{{ $anggota->links('pagination::bootstrap-4') }}
</div>

</div>
</section>
@endsection
