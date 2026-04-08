@extends('layouts.app')
@section('title','Dashboard Pimpinan')
@section('page-title','Dashboard Pimpinan')
@section('breadcrumb')<li class="breadcrumb-item active">Dashboard</li>@endsection
@section('content')
<div class="row">
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-primary"><i class="fas fa-store"></i></span><div class="info-box-content"><span class="info-box-text">Total Koperasi</span><span class="info-box-number">{{ $stats['total_koperasi'] }}</span></div></div></div>
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span><div class="info-box-content"><span class="info-box-text">Koperasi Terverifikasi</span><span class="info-box-number">{{ $stats['koperasi_verified'] }}</span></div></div></div>
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-warning"><i class="fas fa-hand-holding-usd"></i></span><div class="info-box-content"><span class="info-box-text">Program Bantuan</span><span class="info-box-number">{{ $stats['total_bantuan'] }}</span></div></div></div>
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-info"><i class="fas fa-users"></i></span><div class="info-box-content"><span class="info-box-text">Penerima Bantuan</span><span class="info-box-number">{{ $stats['penerima_bantuan'] }}</span></div></div></div>
</div>
<div class="row">
<div class="col-md-6"><div class="card shadow-sm"><div class="card-header bg-light"><h6 class="mb-0 font-weight-bold">Koperasi per Kategori</h6></div><div class="card-body p-0">
<table class="table table-sm mb-0"><thead class="thead-light"><tr><th>Kategori</th><th>Jumlah</th></tr></thead><tbody>
@foreach($koperasiPerKategori as $k)<tr><td>{{ ucfirst($k->kategori) }}</td><td><span class="badge badge-primary">{{ $k->total }}</span></td></tr>@endforeach
</tbody></table></div></div></div>
<div class="col-md-6"><div class="card shadow-sm"><div class="card-header bg-light"><h6 class="mb-0 font-weight-bold">Top 10 Koperasi per Distrik</h6></div><div class="card-body p-0">
<table class="table table-sm mb-0"><thead class="thead-light"><tr><th>Distrik</th><th>Jumlah</th></tr></thead><tbody>
@foreach($koperasiPerDistrik as $d)<tr><td>{{ $d->distrik }}</td><td><span class="badge badge-success">{{ $d->total }}</span></td></tr>@endforeach
</tbody></table></div></div></div>
</div>
@endsection
