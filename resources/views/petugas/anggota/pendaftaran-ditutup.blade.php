@extends('layouts.app')
@section('title', 'Pendaftaran Ditutup')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0" style="border-radius:20px;margin-top:50px">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <div style="width:120px;height:120px;background:linear-gradient(135deg,#ef4444,#dc2626);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;box-shadow:0 10px 30px rgba(239,68,68,0.3)">
                            <i class="fas fa-calendar-times fa-3x text-white"></i>
                        </div>
                    </div>
                    
                    <h2 class="font-weight-bold mb-3" style="color:#1a3a6e">
                        Pendaftaran Anggota Sedang Ditutup
                    </h2>
                    
                    <p class="text-muted mb-4" style="font-size:16px;line-height:1.8">
                        Saat ini tidak ada periode pendaftaran anggota koperasi yang aktif.<br>
                        Silakan hubungi <strong>Admin</strong> untuk membuka periode pendaftaran baru.
                    </p>
                    
                    <div class="alert alert-info" style="border-radius:12px;border:none;background:#dbeafe;border-left:4px solid #3b82f6">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle fa-2x mr-3" style="color:#3b82f6"></i>
                            <div class="text-left">
                                <h6 class="font-weight-bold mb-2" style="color:#1e40af">Informasi:</h6>
                                <ul class="mb-0 pl-3" style="color:#1e3a8a">
                                    <li>Hanya <strong>Admin</strong> yang dapat membuka periode pendaftaran baru</li>
                                    <li><strong>Petugas</strong> harus menunggu periode pendaftaran dibuka oleh Admin</li>
                                    <li>Admin dapat mendaftarkan anggota kapan saja tanpa tergantung periode</li>
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
                            Hubungi Admin untuk membuka periode pendaftaran
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
