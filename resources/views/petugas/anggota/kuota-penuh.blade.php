@extends('layouts.app')
@section('title', 'Kuota Pendaftaran Penuh')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0" style="border-radius:20px;margin-top:50px">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <div style="width:120px;height:120px;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;box-shadow:0 10px 30px rgba(245,158,11,0.3)">
                            <i class="fas fa-users-slash fa-3x text-white"></i>
                        </div>
                    </div>
                    
                    <h2 class="font-weight-bold mb-3" style="color:#1a3a6e">
                        Kuota Pendaftaran Sudah Penuh
                    </h2>
                    
                    <p class="text-muted mb-4" style="font-size:16px;line-height:1.8">
                        Mohon maaf, kuota pendaftaran untuk periode ini sudah mencapai batas maksimal.
                    </p>
                    
                    <div class="card mb-4" style="border-radius:12px;border:2px solid #f59e0b;background:#fffbeb">
                        <div class="card-body">
                            <h5 class="font-weight-bold mb-3" style="color:#92400e">
                                <i class="fas fa-calendar-alt mr-2"></i>{{ $periodeAktif->nama_periode }}
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fas fa-calendar-check fa-2x mr-3" style="color:#d97706"></i>
                                        <div class="text-left">
                                            <small class="text-muted d-block">Periode</small>
                                            <strong style="color:#92400e">
                                                {{ \Carbon\Carbon::parse($periodeAktif->tanggal_mulai)->format('d M Y') }} - 
                                                {{ \Carbon\Carbon::parse($periodeAktif->tanggal_selesai)->format('d M Y') }}
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fas fa-users fa-2x mr-3" style="color:#d97706"></i>
                                        <div class="text-left">
                                            <small class="text-muted d-block">Kuota</small>
                                            <strong style="color:#92400e">
                                                {{ $periodeAktif->jumlah_pendaftar }} / {{ $periodeAktif->kuota }} Pendaftar
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height:25px;border-radius:12px">
                                <div class="progress-bar bg-warning" role="progressbar" 
                                     style="width:100%;font-weight:bold;font-size:14px" 
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                    100% PENUH
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info" style="border-radius:12px;border:none;background:#dbeafe;border-left:4px solid #3b82f6">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle fa-2x mr-3" style="color:#3b82f6"></i>
                            <div class="text-left">
                                <h6 class="font-weight-bold mb-2" style="color:#1e40af">Solusi:</h6>
                                <ul class="mb-0 pl-3" style="color:#1e3a8a">
                                    <li>Hubungi <strong>Admin</strong> untuk menambah kuota periode ini</li>
                                    <li>Atau tunggu periode pendaftaran berikutnya</li>
                                    <li><strong>Admin</strong> dapat mendaftarkan anggota tanpa tergantung kuota</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('petugas.anggota.index') }}" class="btn btn-lg px-5" style="background:#1a3a6e;color:white;border-radius:12px;box-shadow:0 4px 15px rgba(26,58,110,0.3)">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Anggota
                        </a>
                    </div>
                    
                    <div class="mt-4 pt-4 border-top">
                        <p class="text-muted mb-2">
                            <i class="fas fa-question-circle mr-2"></i>Butuh bantuan?
                        </p>
                        <p class="text-muted">
                            Hubungi Admin untuk menambah kuota atau membuka periode baru
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
