@extends('layouts.app')
@section('title','Laporan')
@section('page-title','Laporan')
@section('breadcrumb')<li class="breadcrumb-item active">Laporan</li>@endsection
@section('content')
<div class="row">
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-primary"><i class="fas fa-store"></i></span><div class="info-box-content"><span class="info-box-text">Total Koperasi</span><span class="info-box-number">{{ $stats['total_koperasi'] }}</span></div></div></div>
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-success"><i class="fas fa-check"></i></span><div class="info-box-content"><span class="info-box-text">Terverifikasi</span><span class="info-box-number">{{ $stats['koperasi_verified'] }}</span></div></div></div>
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-warning"><i class="fas fa-hand-holding-usd"></i></span><div class="info-box-content"><span class="info-box-text">Program Bantuan</span><span class="info-box-number">{{ $stats['total_bantuan'] }}</span></div></div></div>
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-info"><i class="fas fa-users"></i></span><div class="info-box-content"><span class="info-box-text">Penerima Bantuan</span><span class="info-box-number">{{ $stats['penerima_bantuan'] }}</span></div></div></div>
</div>
<div class="row">
<div class="col-md-6"><div class="card shadow-sm"><div class="card-body text-center">
<i class="fas fa-store fa-3x text-primary mb-3 d-block"></i>
<h5>Laporan Koperasi</h5>
<a href="{{ route('pimpinan.laporan.exportExcel') }}" class="btn btn-success mr-2"><i class="fas fa-file-excel mr-1"></i>Excel</a>
<a href="{{ route('pimpinan.laporan.exportPdf') }}" class="btn btn-danger"><i class="fas fa-file-pdf mr-1"></i>PDF</a>
</div></div></div>
<div class="col-md-6"><div class="card shadow-sm"><div class="card-body text-center">
<i class="fas fa-hand-holding-usd fa-3x text-success mb-3 d-block"></i>
<h5>Laporan Bantuan</h5>
<a href="{{ route('pimpinan.laporan.bantuan') }}" class="btn btn-info"><i class="fas fa-eye mr-1"></i>Lihat</a>
</div></div></div>
</div>
@endsection
