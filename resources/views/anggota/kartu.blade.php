@extends('layouts.app')
@section('title','Kartu Anggota')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="text-right mb-3">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print mr-1"></i> Cetak Kartu
                </button>
            </div>
            {{-- KARTU ANGGOTA --}}
            <div id="kartu-cetak" class="card shadow-lg border-0" style="border-radius:16px;overflow:hidden;">
                <div style="background:linear-gradient(135deg,#1a237e,#1976d2);padding:20px 24px 12px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="text-white mb-0 font-weight-bold">DISPERINDAGKOP</h5>
                            <small class="text-white-50">Kabupaten Tolikara</small>
                        </div>
                        <span class="badge badge-warning px-3 py-2" style="font-size:13px;">KARTU ANGGOTA</span>
                    </div>
                </div>
                <div class="card-body" style="background:#f8f9fa;">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $anggota->foto_url }}" width="90" height="90" class="rounded-circle border border-primary mr-4" style="object-fit:cover">
                        <div>
                            <h5 class="font-weight-bold mb-1">{{ $anggota->nama }}</h5>
                            <span class="badge badge-primary">{{ $anggota->no_anggota }}</span><br>
                            <small class="text-muted">{{ $anggota->distrik }}, Kab. Tolikara</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">NIK</small>
                            <p class="font-weight-bold mb-1">{{ $anggota->nik }}</p>
                            <small class="text-muted">Jenis Kelamin</small>
                            <p class="font-weight-bold mb-1">{{ $anggota->jenis_kelamin }}</p>
                            <small class="text-muted">No. HP</small>
                            <p class="font-weight-bold mb-1">{{ $anggota->no_hp }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Nama Usaha</small>
                            <p class="font-weight-bold mb-1">{{ $anggota->nama_usaha }}</p>
                            <small class="text-muted">Distrik</small>
                            <p class="font-weight-bold mb-1">{{ $anggota->distrik }}</p>
                            <small class="text-muted">Tgl. Verifikasi</small>
                            <p class="font-weight-bold mb-1">{{ $anggota->tanggal_verifikasi ? $anggota->tanggal_verifikasi->format('d M Y') : '-' }}</p>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <span class="badge badge-success px-4 py-2" style="font-size:13px;">{{ $anggota->status }}</span>
                    </div>
                </div>
                <div style="background:linear-gradient(135deg,#1a237e,#1976d2);padding:10px 24px;text-align:center;">
                    <small class="text-white-50">Kartu ini adalah bukti keanggotaan resmi DISPERINDAGKOP Kab. Tolikara</small>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
@media print {
    body * { visibility: hidden; }
    #kartu-cetak, #kartu-cetak * { visibility: visible; }
    #kartu-cetak { position: absolute; left: 0; top: 0; width: 100%; }
}
</style>
@endsection
