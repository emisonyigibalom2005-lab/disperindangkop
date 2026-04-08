@extends('layouts.app')
@section('title','Profil Anggota')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user mr-2"></i>Data Profil Anggota</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ $anggota->foto_url }}" width="100" height="100" class="rounded-circle border" style="object-fit:cover">
                        <h5 class="mt-2 font-weight-bold">{{ $anggota->nama }}</h5>
                        <span class="badge badge-{{ $anggota->status === 'Aktif' ? 'success' : 'warning' }}">{{ $anggota->status }}</span>
                    </div>
                    <table class="table table-bordered">
                        <tr><th width="40%">No. Anggota</th><td>{{ $anggota->no_anggota }}</td></tr>
                        <tr><th>NIK</th><td>{{ $anggota->nik }}</td></tr>
                        <tr><th>Tempat, Tgl Lahir</th><td>{{ $anggota->tempat_lahir }}, {{ $anggota->tanggal_lahir ? $anggota->tanggal_lahir->format('d M Y') : '-' }}</td></tr>
                        <tr><th>Jenis Kelamin</th><td>{{ $anggota->jenis_kelamin }}</td></tr>
                        <tr><th>Agama</th><td>{{ $anggota->agama }}</td></tr>
                        <tr><th>No. HP</th><td>{{ $anggota->no_hp }}</td></tr>
                        <tr><th>Email</th><td>{{ $anggota->email }}</td></tr>
                        <tr><th>Distrik</th><td>{{ $anggota->distrik }}</td></tr>
                        <tr><th>Desa</th><td>{{ $anggota->desa }}</td></tr>
                        <tr><th>Nama Usaha</th><td>{{ $anggota->nama_usaha }}</td></tr>
                        <tr><th>Modal Usaha</th><td>Rp {{ number_format($anggota->modal_usaha,0,',','.') }}</td></tr>
                        <tr><th>Omzet/Bulan</th><td>Rp {{ number_format($anggota->omzet_per_bulan,0,',','.') }}</td></tr>
                        <tr><th>Total Simpanan</th><td>Rp {{ number_format($anggota->total_simpanan,0,',','.') }}</td></tr>
                    </table>
                    <a href="{{ route('anggota.kartu') }}" class="btn btn-primary">
                        <i class="fas fa-id-card mr-1"></i> Lihat Kartu Anggota
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
