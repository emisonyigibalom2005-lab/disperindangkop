@extends('layouts.app')
@section('title','Detail Koperasi')
@section('page-title','Detail Koperasi')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('pimpinan.koperasi') }}">Koperasi</a></li>
<li class="breadcrumb-item active">{{ $koperasi->nama_usaha }}</li>
@endsection
@section('content')
<div class="card shadow-sm"><div class="card-body">
<table class="table table-borderless">
<tr><td class="text-muted">Nama Usaha</td><td><strong>{{ $koperasi->nama_usaha }}</strong></td></tr>
<tr><td class="text-muted">Pemilik</td><td>{{ $koperasi->nama_pemilik }}</td></tr>
<tr><td class="text-muted">No. Registrasi</td><td>{{ $koperasi->no_registrasi }}</td></tr>
<tr><td class="text-muted">Distrik</td><td>{{ $koperasi->distrik }}</td></tr>
<tr><td class="text-muted">Kategori</td><td>{{ ucfirst($koperasi->kategori) }}</td></tr>
<tr><td class="text-muted">Status</td><td>{!! $koperasi->status_verifikasi_label !!}</td></tr>
</table>
<a href="{{ route('pimpinan.koperasi') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
</div></div>
@endsection
