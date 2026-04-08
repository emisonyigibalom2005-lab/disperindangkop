@extends('layouts.app')
@section('title','Dashboard Koperasi')
@section('page-title','Dashboard Koperasi')
@section('breadcrumb')<li class="breadcrumb-item active">Dashboard</li>@endsection
@section('content')
<div class="row">
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-primary"><i class="fas fa-store"></i></span><div class="info-box-content"><span class="info-box-text">Status Usaha</span><span class="info-box-number" style="font-size:16px">{{ $koperasi ? ucfirst($koperasi->status_verifikasi) : 'Belum Terdaftar' }}</span></div></div></div>
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-success"><i class="fas fa-hand-holding-usd"></i></span><div class="info-box-content"><span class="info-box-text">Bantuan Aktif</span><span class="info-box-number">{{ $bantuan_aktif }}</span></div></div></div>
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-warning"><i class="fas fa-history"></i></span><div class="info-box-content"><span class="info-box-text">Riwayat Bantuan</span><span class="info-box-number">{{ $riwayat_bantuan }}</span></div></div></div>
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-info"><i class="fas fa-bell"></i></span><div class="info-box-content"><span class="info-box-text">Notifikasi Baru</span><span class="info-box-number">{{ $notifikasi_baru }}</span></div></div></div>
</div>
@if($koperasi)
<div class="card shadow-sm"><div class="card-header bg-light"><h6 class="mb-0 font-weight-bold">Data Usaha Saya</h6></div>
<div class="card-body">
<div class="row">
<div class="col-md-6">
<table class="table table-borderless table-sm">
<tr><td class="text-muted">Nama Usaha</td><td><strong>{{ $koperasi->nama_usaha }}</strong></td></tr>
<tr><td class="text-muted">No. Registrasi</td><td>{{ $koperasi->no_registrasi }}</td></tr>
<tr><td class="text-muted">Jenis Usaha</td><td>{{ $koperasi->jenis_usaha }}</td></tr>
<tr><td class="text-muted">Kategori</td><td>{{ ucfirst($koperasi->kategori) }}</td></tr>
</table>
</div>
<div class="col-md-6">
<table class="table table-borderless table-sm">
<tr><td class="text-muted">Distrik</td><td>{{ $koperasi->distrik }}</td></tr>
<tr><td class="text-muted">Status</td><td>{!! $koperasi->status_verifikasi_label !!}</td></tr>
<tr><td class="text-muted">Telepon</td><td>{{ $koperasi->no_telp ?? '-' }}</td></tr>
</table>
</div>
</div>
</div></div>
@else
<div class="alert alert-warning"><i class="fas fa-exclamation-triangle mr-2"></i>Data Koperasi Anda belum terdaftar. Hubungi petugas untuk pendaftaran.</div>
@endif
@endsection
