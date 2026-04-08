@extends('layouts.app')
@section('title','Data Koperasi')
@section('page-title','Manajemen Koperasi')
@section('breadcrumb')<li class="breadcrumb-item active">Koperasi</li>@endsection
@section('content')
<div class="card shadow-sm">
<div class="card-header"><h3 class="card-title"><i class="fas fa-store mr-2"></i>Data Koperasi <span class="badge badge-primary ml-1">{{ $koperasi->total() }}</span></h3>
<div class="card-tools"><a href="{{ route('petugas.koperasi.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus mr-1"></i>Tambah</a></div>
</div>
<div class="card-body">
<form method="GET" class="mb-3"><div class="row">
<div class="col-md-5"><input type="text" name="search" class="form-control" placeholder="Cari Koperasi..." value="{{ request('search') }}"></div>
<div class="col-md-3"><select name="status_verifikasi" class="form-control"><option value="">Semua Status</option><option value="pending" {{ request('status_verifikasi')==='pending'?'selected':'' }}>Pending</option><option value="diverifikasi" {{ request('status_verifikasi')==='diverifikasi'?'selected':'' }}>Terverifikasi</option><option value="ditolak" {{ request('status_verifikasi')==='ditolak'?'selected':'' }}>Ditolak</option></select></div>
<div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button></div>
<div class="col-md-2"><a href="{{ route('petugas.koperasi.index') }}" class="btn btn-secondary w-100">Reset</a></div>
</div></form>
<div class="table-responsive"><table class="table table-hover table-sm">
<thead class="thead-light"><tr><th>#</th><th>No. Reg</th><th>Nama Usaha</th><th>Pemilik</th><th>Distrik</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead>
<tbody>
@forelse($koperasi as $i => $u)
<tr><td>{{ $koperasi->firstItem()+$i }}</td><td><small class="text-primary">{{ $u->no_registrasi }}</small></td><td>{{ $u->nama_usaha }}</td><td>{{ $u->nama_pemilik }}</td><td>{{ $u->distrik }}</td>
<td><span class="badge badge-{{ $u->kategori==='mikro'?'primary':($u->kategori==='kecil'?'success':'warning') }}">{{ ucfirst($u->kategori) }}</span></td>
<td>{!! $u->status_verifikasi_label !!}</td>
<td>
    <a href="{{ route('petugas.koperasi.show',$u) }}" class="btn btn-sm btn-primary" title="Detail"><i class="fas fa-eye"></i></a>
</td></tr>
@empty
<tr><td colspan="8" class="text-center py-4 text-muted">Tidak ada data</td></tr>
@endforelse
</tbody></table></div>
</div>
<div class="card-footer">{{ $koperasi->links('pagination::bootstrap-4') }}</div>
</div>
@endsection
