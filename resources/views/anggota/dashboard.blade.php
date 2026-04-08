@extends('layouts.app')
@section('title','Dashboard Anggota')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body d-flex align-items-center">
                    <img src="{{ $anggota->foto_url }}" class="rounded-circle mr-3" width="70" height="70" style="object-fit:cover">
                    <div>
                        <h4 class="mb-0 font-weight-bold">{{ $anggota->nama }}</h4>
                        <small>{{ $anggota->no_anggota }} &bull; {{ $anggota->nama_usaha }}</small><br>
                        <span class="badge badge-light text-primary mt-1">{{ $anggota->status }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow text-center border-0">
                <div class="card-body">
                    <i class="fas fa-store fa-2x text-primary mb-2"></i>
                    <h6 class="font-weight-bold">Usaha</h6>
                    <p class="mb-0">{{ $anggota->nama_usaha }}</p>
                    <small class="text-muted">{{ $anggota->distrik }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow text-center border-0">
                <div class="card-body">
                    <i class="fas fa-money-bill-wave fa-2x text-success mb-2"></i>
                    <h6 class="font-weight-bold">Modal Usaha</h6>
                    <p class="mb-0">Rp {{ number_format($anggota->modal_usaha,0,',','.') }}</p>
                    <small class="text-muted">Omset: Rp {{ number_format($anggota->omzet_per_bulan,0,',','.') }}/bln</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow text-center border-0">
                <div class="card-body">
                    <i class="fas fa-piggy-bank fa-2x text-warning mb-2"></i>
                    <h6 class="font-weight-bold">Total Simpanan</h6>
                    <p class="mb-0">Rp {{ number_format($anggota->total_simpanan,0,',','.') }}</p>
                    <small class="text-muted">Terverifikasi: {{ $anggota->tanggal_verifikasi ? $anggota->tanggal_verifikasi->format('d M Y') : '-' }}</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6 mb-3">
            <a href="{{ route('anggota.kartu') }}" class="btn btn-primary btn-block btn-lg shadow">
                <i class="fas fa-id-card mr-2"></i> Lihat Kartu Anggota
            </a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="{{ route('anggota.profil') }}" class="btn btn-outline-primary btn-block btn-lg shadow">
                <i class="fas fa-user mr-2"></i> Data Profil Saya
            </a>
        </div>
    </div>
</div>
@endsection
