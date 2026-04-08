@extends('layouts.app')
@section('title','Data Koperasi')
@section('page-title','Data Koperasi')
@section('breadcrumb')<li class="breadcrumb-item active">Koperasi</li>@endsection
@section('content')
<div class="card shadow-sm">
<div class="card-header"><h3 class="card-title">Data Koperasi <span class="badge badge-primary ml-1">{{ $koperasi->total() }}</span></h3></div>
<div class="card-body p-0"><table class="table table-hover table-sm mb-0">
<thead class="thead-light"><tr><th>#</th><th>No. Reg</th><th>Nama Usaha</th><th>Distrik</th><th>Kategori</th><th>Status</th></tr></thead>
<tbody>
@forelse($koperasi as $i => $u)
<tr><td>{{ $koperasi->firstItem()+$i }}</td><td>{{ $u->no_registrasi }}</td><td>{{ $u->nama_usaha }}</td><td>{{ $u->distrik }}</td>
<td>{{ ucfirst($u->kategori) }}</td><td>{!! $u->status_verifikasi_label !!}</td></tr>
@empty
<tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada data</td></tr>
@endforelse
</tbody></table></div>
<div class="card-footer">{{ $koperasi->links('pagination::bootstrap-4') }}</div>
</div>
@endsection
