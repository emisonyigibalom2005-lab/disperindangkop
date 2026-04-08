@extends('layouts.app')
@section('title','Sertifikat Koperasi')
@section('page-title','Sertifikat Koperasi')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.laporan.index') }}">Laporan</a></li>
<li class="breadcrumb-item active">Sertifikat Koperasi</li>
@endsection
@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-certificate mr-2 text-warning"></i>Daftar Sertifikat Koperasi Terverifikasi</h3>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-5"><input type="text" name="search" class="form-control" placeholder="Cari nama usaha / pemilik..." value="{{ request('search') }}"></div>
                <div class="col-md-3">
                    <select name="distrik" class="form-control">
                        <option value="">Semua Distrik</option>
                        @foreach($distrik as $d)<option value="{{ $d }}" {{ request('distrik')===$d?'selected':'' }}>{{ $d }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button></div>
                <div class="col-md-2"><a href="{{ route('admin.laporan.sertifikat') }}" class="btn btn-secondary w-100">Reset</a></div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="thead-light">
                    <tr><th>#</th><th>No. Registrasi</th><th>Nama Usaha</th><th>Pemilik</th><th>Distrik</th><th>Kategori</th><th>Tgl Verifikasi</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                @forelse($koperasi as $i => $u)
                <tr>
                    <td>{{ $koperasi->firstItem()+$i }}</td>
                    <td><span class="badge badge-primary">{{ $u->no_registrasi }}</span></td>
                    <td><strong>{{ $u->nama_usaha }}</strong></td>
                    <td>{{ $u->nama_pemilik }}</td>
                    <td>{{ $u->distrik }}</td>
                    <td><span class="badge badge-{{ $u->kategori==='mikro'?'info':($u->kategori==='kecil'?'success':'warning') }}">{{ ucfirst($u->kategori) }}</span></td>
                    <td><small>{{ $u->verified_at ? \Carbon\Carbon::parse($u->verified_at)->format('d/m/Y') : '-' }}</small></td>
                    <td>
                        <a href="{{ route('admin.laporan.cetakSertifikat', $u) }}" target="_blank" class="btn btn-sm btn-warning">
                            <i class="fas fa-certificate mr-1"></i> Cetak PDF
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted"><i class="fas fa-certificate fa-2x d-block mb-2"></i>Belum ada Koperasi terverifikasi</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">{{ $koperasi->links('pagination::bootstrap-4') }}</div>
</div>
@endsection
