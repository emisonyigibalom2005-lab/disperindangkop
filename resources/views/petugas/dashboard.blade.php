@extends('layouts.app')
@section('title','Dashboard Petugas')
@section('page-title','Dashboard Petugas')
@section('breadcrumb')<li class="breadcrumb-item active">Dashboard</li>@endsection
@section('content')
<div class="row">
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-primary"><i class="fas fa-store"></i></span><div class="info-box-content"><span class="info-box-text">Total Koperasi</span><span class="info-box-number">{{ $stats['total_koperasi'] }}</span></div></div></div>
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span><div class="info-box-content"><span class="info-box-text">Pending Verifikasi</span><span class="info-box-number">{{ $stats['koperasi_pending'] }}</span></div></div></div>
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span><div class="info-box-content"><span class="info-box-text">Terverifikasi</span><span class="info-box-number">{{ $stats['koperasi_verified'] }}</span></div></div></div>
<div class="col-md-3"><div class="info-box shadow-sm"><span class="info-box-icon bg-info"><i class="fas fa-hand-holding-usd"></i></span><div class="info-box-content"><span class="info-box-text">Bantuan Aktif</span><span class="info-box-number">{{ $stats['total_bantuan'] }}</span></div></div></div>
</div>
<div class="card shadow-sm"><div class="card-header"><h3 class="card-title"><i class="fas fa-clock mr-2"></i>Koperasi Menunggu Verifikasi</h3></div>
<div class="card-body p-0"><table class="table table-sm mb-0">
<thead class="thead-light"><tr><th>No. Registrasi</th><th>Nama Usaha</th><th>Pemilik</th><th>Distrik</th><th>Aksi</th></tr></thead>
<tbody>
@forelse($koperasi_pending as $u)
<tr><td>{{ $u->no_registrasi }}</td><td>{{ $u->nama_usaha }}</td><td>{{ $u->nama_pemilik }}</td><td>{{ $u->distrik }}</td>
<td><a href="{{ route('petugas.koperasi.show',$u) }}" class="btn btn-sm btn-primary">Verifikasi</a></td></tr>
@empty
<tr><td colspan="5" class="text-center py-3 text-muted">Tidak ada Koperasi pending</td></tr>
@endforelse
</tbody></table></div></div>
@endsection
