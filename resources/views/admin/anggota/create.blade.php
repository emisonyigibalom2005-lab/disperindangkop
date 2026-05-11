@extends('layouts.app')
@section('title', 'Pendaftaran Anggota Koperasi Baru')

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 50%, #4a7bc8 100%);
    padding: 50px 0;
    margin-bottom: 30px;
    border-radius: 0 0 20px 20px;
    box-shadow: 0 4px 20px rgba(26, 58, 110, 0.15);
    position: relative;
    overflow: hidden;
}
.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
}
.page-header::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -5%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 50%;
}
.page-header .container {
    position: relative;
    z-index: 1;
}
.page-header h1 {
    font-size: 2.2rem;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    letter-spacing: -0.5px;
}
.page-header .lead {
    font-size: 1.1rem;
    opacity: 0.95;
    font-weight: 400;
}
.page-header .icon-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    margin-bottom: 15px;
    backdrop-filter: blur(10px);
}
.page-header .icon-badge i {
    font-size: 32px;
}
.steps-indicator {
    position: relative;
    padding: 20px 0;
    margin-bottom: 30px;
}
.steps-indicator::before {
    content: '';
    position: absolute;
    top: 35px;
    left: 10%;
    right: 10%;
    height: 2px;
    background: #e5e7eb;
    z-index: 0;
}
.step-item {
    text-align: center;
    position: relative;
    z-index: 1;
}
.step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: 3px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 8px;
    font-weight: 700;
    color: #9ca3af;
}
.step-item.active .step-circle {
    background: #1a3a6e;
    border-color: #1a3a6e;
    color: white;
}
.step-item.completed .step-circle {
    background: #10b981;
    border-color: #10b981;
    color: white;
}
.step-item small {
    font-size: 11px;
    color: #9ca3af;
    font-weight: 600;
}
.step-item.active small {
    color: #1a3a6e;
}
.form-step {
    display: none;
}
.form-step.active {
    display: block;
}
.form-control {
    border-radius: 8px;
    border: 2px solid #e5e7eb;
    padding: 10px 14px;
}
.form-control:focus {
    border-color: #1a3a6e;
    box-shadow: 0 0 0 3px rgba(26, 58, 110, 0.1);
}
.form-label {
    font-weight: 600;
    color: #374151;
    font-size: 13px;
    margin-bottom: 6px;
}
.form-control.is-invalid {
    border-color: #dc3545 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px 16px;
    padding-right: 40px;
}
.form-control.is-valid {
    border-color: #10b981 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%2310b981' viewBox='0 0 12 12'%3e%3cpolyline points='1 7 4 10 11 3'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px 16px;
    padding-right: 40px;
}
.input-group .form-control.is-valid {
    background-position: right calc(2.25rem + 12px) center;
    padding-right: calc(2.25rem + 40px);
}
.input-group .form-control.is-invalid {
    background-position: right calc(2.25rem + 12px) center;
    padding-right: calc(2.25rem + 40px);
}
select.form-control.is-valid,
select.form-select.is-valid {
    border-color: #10b981 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%2310b981' viewBox='0 0 12 12'%3e%3cpolyline points='1 7 4 10 11 3'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 30px center;
    background-size: 16px 16px;
}
select.form-control.is-invalid,
select.form-select.is-invalid {
    border-color: #dc3545 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 30px center;
    background-size: 16px 16px;
}
.invalid-feedback {
    display: block;
    color: #dc3545;
    font-size: 0.85rem;
    margin-top: 5px;
}
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container text-center text-white">
        <div class="icon-badge">
            <i class="fas fa-user-plus"></i>
        </div>
        <h1 class="mb-3">Pendaftaran Anggota Koperasi Baru</h1>
        <p class="lead mb-0">Lengkapi formulir berikut untuk mendaftarkan anggota koperasi baru dengan data yang lengkap dan akurat</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if(isset($periodeAktif))
                <div class="alert alert-info" style="border-radius:12px;border:none;box-shadow:0 2px 8px rgba(0,0,0,0.1);background:#dbeafe;border-left:4px solid #3b82f6;">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-info-circle" style="font-size:24px;color:#3b82f6;margin-right:15px;margin-top:3px;"></i>
                        <div style="flex:1;">
                            <h5 style="color:#1e40af;font-weight:700;margin-bottom:8px;">
                                <i class="fas fa-calendar-check mr-2"></i>Periode Pendaftaran Aktif
                            </h5>
                            <div style="color:#1e3a8a;line-height:1.6;">
                                <p class="mb-2"><strong>{{ $periodeAktif->nama_periode }}</strong></p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small><i class="fas fa-calendar-alt mr-1"></i> <strong>Mulai:</strong> {{ \Carbon\Carbon::parse($periodeAktif->tanggal_mulai)->format('d M Y') }}</small>
                                    </div>
                                    <div class="col-md-6">
                                        <small><i class="fas fa-calendar-times mr-1"></i> <strong>Berakhir:</strong> {{ \Carbon\Carbon::parse($periodeAktif->tanggal_berakhir)->format('d M Y') }}</small>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small>
                                        <i class="fas fa-users mr-1"></i> 
                                        <strong>Kuota:</strong> {{ $periodeAktif->jumlah_pendaftar }} / {{ $periodeAktif->kuota }} pendaftar
                                        <span class="badge badge-{{ $periodeAktif->jumlah_pendaftar >= $periodeAktif->kuota ? 'danger' : 'success' }} ml-2">
                                            {{ $periodeAktif->kuota - $periodeAktif->jumlah_pendaftar }} slot tersisa
                                        </span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="card" style="border-radius:16px;border:none;box-shadow:0 4px 20px rgba(0,0,0,0.08)">
                    <div class="card-body p-4">
                        {{-- Steps Indicator --}}
                        <div class="steps-indicator">
                            <div class="d-flex justify-content-between">
                                <div class="step-item active" data-step="1">
                                    <div class="step-circle">1</div>
                                    <small>Data Pribadi</small>
                                </div>
                                <div class="step-item" data-step="2">
                                    <div class="step-circle">2</div>
                                    <small>Alamat</small>
                                </div>
                                <div class="step-item" data-step="3">
                                    <div class="step-circle">3</div>
                                    <small>Data Usaha</small>
                                </div>
                                <div class="step-item" data-step="4">
                                    <div class="step-circle">4</div>
                                    <small>Dokumen</small>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.anggota.store') }}" method="POST" enctype="multipart/form-data" id="formPendaftaran" novalidate>
                            @csrf
                            
                            @if($errors->any())
                            <div class="alert alert-danger" id="errorSummary" style="border-radius:12px;border:none;border-left:4px solid #dc3545;box-shadow:0 4px 20px rgba(220,53,69,0.3);background:#fff5f5">
                                <div class="d-flex align-items-start mb-3">
                                    <div style="width:50px;height:50px;background:#dc3545;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                        <i class="fas fa-exclamation-triangle fa-lg text-white"></i>
                                    </div>
                                    <div class="ml-3 flex-grow-1">
                                        <h5 class="font-weight-bold mb-2" style="color:#dc3545">
                                            Pendaftaran Belum Bisa Diproses
                                        </h5>
                                        <p class="mb-0" style="color:#721c24">
                                            Terdapat <strong>{{ $errors->count() }} kesalahan</strong> pada form yang harus diperbaiki terlebih dahulu.
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="error-list p-3" style="max-height:350px;overflow-y:auto;background:white;border-radius:8px;border:1px solid #f5c6cb">
                                    <h6 class="font-weight-bold mb-3" style="color:#721c24">
                                        <i class="fas fa-list-ul mr-2"></i>Daftar Kesalahan:
                                    </h6>
                                    @foreach($errors->all() as $index => $error)
                                    <div class="error-item mb-2 p-3 d-flex align-items-start" style="background:#fff;border-radius:8px;border:1px solid #f5c6cb;box-shadow:0 2px 4px rgba(220,53,69,0.1)">
                                        <div style="width:28px;height:28px;background:#dc3545;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                            <strong style="color:white;font-size:12px">{{ $index + 1 }}</strong>
                                        </div>
                                        <div class="ml-3">
                                            <p class="mb-0" style="color:#721c24;font-weight:500">{{ $error }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-3 p-3" style="background:white;border-radius:8px;border:1px solid #f5c6cb">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-lightbulb fa-lg mr-3" style="color:#f59e0b"></i>
                                        <div>
                                            <h6 class="font-weight-bold mb-2" style="color:#1a3a6e">Cara Memperbaiki:</h6>
                                            <ul class="mb-0 pl-3" style="color:#374151">
                                                <li>Periksa setiap field yang ditandai dengan <span style="color:#dc3545;font-weight:600">border merah</span></li>
                                                <li>Pastikan semua field yang bertanda <span style="color:#dc3545;font-weight:600">bintang merah (*)</span> sudah diisi</li>
                                                <li>Data yang sudah Anda isi sebelumnya <strong>tetap tersimpan</strong>, tidak perlu mengisi ulang</li>
                                                <li>Perbaiki hanya field yang bermasalah, lalu klik <strong>"Simpan & Tambahkan"</strong> lagi</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(session('error'))
                            <div class="alert alert-danger" style="border-radius:12px;border:none;border-left:4px solid #dc3545;box-shadow:0 4px 15px rgba(220,53,69,0.2)">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                            </div>
                            @endif

                            @if(session('success'))
                            <div class="alert alert-success" style="border-radius:12px;border:none;border-left:4px solid #10b981;box-shadow:0 4px 15px rgba(16,185,129,0.2)">
                                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                            </div>
                            @endif
                            
                            {{-- Step 1: Data Pribadi --}}
                            <div class="form-step active" data-step="1">
                                <h5 class="mb-4 font-weight-bold" style="color:#1a3a6e">
                                    <i class="fas fa-user mr-2"></i>Data Pribadi
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">NIK (16 digit) <span class="text-danger">*</span></label>
                                        <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" maxlength="16" required value="{{ old('nik') }}" placeholder="Contoh: 9113221112309001">
                                        @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" required value="{{ old('nama') }}" placeholder="Nama sesuai KTP">
                                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" name="tempat_lahir" class="form-control" required value="{{ old('tempat_lahir') }}" placeholder="Contoh: Jayapura">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_lahir" class="form-control" required value="{{ old('tanggal_lahir') }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select name="jenis_kelamin" class="form-control" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="L" {{ old('jenis_kelamin')=='L'?'selected':'' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin')=='P'?'selected':'' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                                        <select name="status_perkawinan" class="form-control @error('status_perkawinan') is-invalid @enderror" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Lajang" {{ old('status_perkawinan')=='Lajang'?'selected':'' }}>Lajang</option>
                                            <option value="Menikah" {{ old('status_perkawinan')=='Menikah'?'selected':'' }}>Menikah</option>
                                            <option value="Cerai" {{ old('status_perkawinan')=='Cerai'?'selected':'' }}>Cerai</option>
                                        </select>
                                        @error('status_perkawinan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Pendidikan Terakhir <span class="text-danger">*</span></label>
                                        <select name="pendidikan_terakhir" class="form-control @error('pendidikan_terakhir') is-invalid @enderror" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Tidak Sekolah" {{ old('pendidikan_terakhir')=='Tidak Sekolah'?'selected':'' }}>Tidak Sekolah</option>
                                            <option value="SD" {{ old('pendidikan_terakhir')=='SD'?'selected':'' }}>SD</option>
                                            <option value="SMP" {{ old('pendidikan_terakhir')=='SMP'?'selected':'' }}>SMP</option>
                                            <option value="SMA/SMK" {{ old('pendidikan_terakhir')=='SMA/SMK'?'selected':'' }}>SMA/SMK</option>
                                            <option value="D3" {{ old('pendidikan_terakhir')=='D3'?'selected':'' }}>D3</option>
                                            <option value="S1" {{ old('pendidikan_terakhir')=='S1'?'selected':'' }}>S1</option>
                                            <option value="S2" {{ old('pendidikan_terakhir')=='S2'?'selected':'' }}>S2</option>
                                            <option value="S3" {{ old('pendidikan_terakhir')=='S3'?'selected':'' }}>S3</option>
                                            <option value="Petani" {{ old('pendidikan_terakhir')=='Petani'?'selected':'' }}>Petani</option>
                                        </select>
                                        @error('pendidikan_terakhir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Agama <span class="text-danger">*</span></label>
                                        <select name="agama" class="form-control" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Kristen" {{ old('agama')=='Kristen'?'selected':'' }}>Kristen</option>
                                            <option value="Islam" {{ old('agama')=='Islam'?'selected':'' }}>Islam</option>
                                            <option value="Katolik" {{ old('agama')=='Katolik'?'selected':'' }}>Katolik</option>
                                            <option value="Hindu" {{ old('agama')=='Hindu'?'selected':'' }}>Hindu</option>
                                            <option value="Buddha" {{ old('agama')=='Buddha'?'selected':'' }}>Buddha</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">No. HP/WhatsApp <span class="text-danger">*</span></label>
                                        <input type="text" name="no_hp" class="form-control" required value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890">
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h6 class="font-weight-bold mb-3" style="color:#1a3a6e">
                                    <i class="fas fa-lock mr-2"></i>Data Akun Login
                                </h6>
                                <p class="text-muted mb-3" style="font-size:13px">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Buat akun login untuk anggota agar bisa mengakses dashboard
                                </p>
                                
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}" placeholder="contoh@email.com">
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <small class="text-muted">Email untuk login ke dashboard anggota</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Minimal 6 karakter">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')" style="border-radius:0 8px 8px 0">
                                                    <i class="fas fa-eye" id="password-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <small class="text-muted">Minimal 6 karakter</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Ketik ulang password">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')" style="border-radius:0 8px 8px 0">
                                                    <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <small class="text-muted">Harus sama dengan password</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Step 2: Alamat --}}
                            <div class="form-step" data-step="2">
                                <h5 class="mb-4 font-weight-bold" style="color:#1a3a6e">
                                    <i class="fas fa-map-marker-alt mr-2"></i>Alamat Lengkap
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Desa</label>
                                        <input type="text" name="desa" class="form-control @error('desa') is-invalid @enderror" value="{{ old('desa') }}" placeholder="Nama desa">
                                        @error('desa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Distrik <span class="text-danger">*</span></label>
                                        <select name="distrik" class="form-control @error('distrik') is-invalid @enderror" required>
                                            <option value="">-- Pilih Distrik --</option>
                                            <option value="Airgaram" {{ old('distrik')=='Airgaram'?'selected':'' }}>Airgaram</option>
                                            <option value="Anawi" {{ old('distrik')=='Anawi'?'selected':'' }}>Anawi</option>
                                            <option value="Aweku" {{ old('distrik')=='Aweku'?'selected':'' }}>Aweku</option>
                                            <option value="Bewani" {{ old('distrik')=='Bewani'?'selected':'' }}>Bewani</option>
                                            <option value="Biandoga" {{ old('distrik')=='Biandoga'?'selected':'' }}>Biandoga</option>
                                            <option value="Biuk" {{ old('distrik')=='Biuk'?'selected':'' }}>Biuk</option>
                                            <option value="Bogonuk" {{ old('distrik')=='Bogonuk'?'selected':'' }}>Bogonuk</option>
                                            <option value="Bokondini" {{ old('distrik')=='Bokondini'?'selected':'' }}>Bokondini</option>
                                            <option value="Bokoneri" {{ old('distrik')=='Bokoneri'?'selected':'' }}>Bokoneri</option>
                                            <option value="Danime" {{ old('distrik')=='Danime'?'selected':'' }}>Danime</option>
                                            <option value="Dow" {{ old('distrik')=='Dow'?'selected':'' }}>Dow</option>
                                            <option value="Dundu" {{ old('distrik')=='Dundu'?'selected':'' }}>Dundu</option>
                                            <option value="Egiam" {{ old('distrik')=='Egiam'?'selected':'' }}>Egiam</option>
                                            <option value="Geya" {{ old('distrik')=='Geya'?'selected':'' }}>Geya</option>
                                            <option value="Gika" {{ old('distrik')=='Gika'?'selected':'' }}>Gika</option>
                                            <option value="Goyage" {{ old('distrik')=='Goyage'?'selected':'' }}>Goyage</option>
                                            <option value="Gundagi" {{ old('distrik')=='Gundagi'?'selected':'' }}>Gundagi</option>
                                            <option value="Kai" {{ old('distrik')=='Kai'?'selected':'' }}>Kai</option>
                                            <option value="Kamboneri" {{ old('distrik')=='Kamboneri'?'selected':'' }}>Kamboneri</option>
                                            <option value="Kanggime" {{ old('distrik')=='Kanggime'?'selected':'' }}>Kanggime</option>
                                            <option value="Karubaga" {{ old('distrik')=='Karubaga'?'selected':'' }}>Karubaga</option>
                                            <option value="Kembu" {{ old('distrik')=='Kembu'?'selected':'' }}>Kembu</option>
                                            <option value="Kondaga" {{ old('distrik')=='Kondaga'?'selected':'' }}>Kondaga</option>
                                            <option value="Kuari" {{ old('distrik')=='Kuari'?'selected':'' }}>Kuari</option>
                                            <option value="Kubu" {{ old('distrik')=='Kubu'?'selected':'' }}>Kubu</option>
                                            <option value="Li Anogomma" {{ old('distrik')=='Li Anogomma'?'selected':'' }}>Li Anogomma</option>
                                            <option value="Nabunage" {{ old('distrik')=='Nabunage'?'selected':'' }}>Nabunage</option>
                                            <option value="Nelawi" {{ old('distrik')=='Nelawi'?'selected':'' }}>Nelawi</option>
                                            <option value="Numba" {{ old('distrik')=='Numba'?'selected':'' }}>Numba</option>
                                            <option value="Nunggawi" {{ old('distrik')=='Nunggawi'?'selected':'' }}>Nunggawi</option>
                                            <option value="Panaga" {{ old('distrik')=='Panaga'?'selected':'' }}>Panaga</option>
                                            <option value="Poganeri" {{ old('distrik')=='Poganeri'?'selected':'' }}>Poganeri</option>
                                            <option value="Tagime" {{ old('distrik')=='Tagime'?'selected':'' }}>Tagime</option>
                                            <option value="Tagineri" {{ old('distrik')=='Tagineri'?'selected':'' }}>Tagineri</option>
                                            <option value="Telenggeme" {{ old('distrik')=='Telenggeme'?'selected':'' }}>Telenggeme</option>
                                            <option value="Timori" {{ old('distrik')=='Timori'?'selected':'' }}>Timori</option>
                                            <option value="Tiom" {{ old('distrik')=='Tiom'?'selected':'' }}>Tiom</option>
                                            <option value="Umagi" {{ old('distrik')=='Umagi'?'selected':'' }}>Umagi</option>
                                            <option value="Wakuwo" {{ old('distrik')=='Wakuwo'?'selected':'' }}>Wakuwo</option>
                                            <option value="Wari/Taiyeve II" {{ old('distrik')=='Wari/Taiyeve II'?'selected':'' }}>Wari/Taiyeve II</option>
                                            <option value="Wenam" {{ old('distrik')=='Wenam'?'selected':'' }}>Wenam</option>
                                            <option value="Wina" {{ old('distrik')=='Wina'?'selected':'' }}>Wina</option>
                                            <option value="Wollo" {{ old('distrik')=='Wollo'?'selected':'' }}>Wollo</option>
                                            <option value="Woniki" {{ old('distrik')=='Woniki'?'selected':'' }}>Woniki</option>
                                            <option value="Wugi" {{ old('distrik')=='Wugi'?'selected':'' }}>Wugi</option>
                                            <option value="Yuko" {{ old('distrik')=='Yuko'?'selected':'' }}>Yuko</option>
                                        </select>
                                        @error('distrik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kabupaten</label>
                                        <input type="text" name="kabupaten" class="form-control @error('kabupaten') is-invalid @enderror" value="{{ old('kabupaten', 'Tolikara') }}" placeholder="Kabupaten">
                                        @error('kabupaten')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Alamat Lengkap</label>
                                        <textarea name="alamat_lengkap" class="form-control @error('alamat_lengkap') is-invalid @enderror" rows="3" placeholder="Alamat lengkap tempat tinggal">{{ old('alamat_lengkap') }}</textarea>
                                        @error('alamat_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kode Pos</label>
                                        <input type="text" name="kode_pos" class="form-control @error('kode_pos') is-invalid @enderror" value="{{ old('kode_pos') }}" placeholder="99411">
                                        @error('kode_pos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Koordinat GPS</label>
                                        <input type="text" name="koordinat_gps" class="form-control @error('koordinat_gps') is-invalid @enderror" placeholder="-3.123456, 138.123456" value="{{ old('koordinat_gps') }}">
                                        @error('koordinat_gps')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <small class="text-muted">Format: Latitude, Longitude</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status Kepemilikan Rumah</label>
                                        <select name="status_kepemilikan_rumah" class="form-control @error('status_kepemilikan_rumah') is-invalid @enderror">
                                            <option value="">Pilih</option>
                                            <option value="Milik Sendiri" {{ old('status_kepemilikan_rumah')=='Milik Sendiri'?'selected':'' }}>Milik Sendiri</option>
                                            <option value="Sewa" {{ old('status_kepemilikan_rumah')=='Sewa'?'selected':'' }}>Sewa</option>
                                            <option value="Ikut Orang Tua" {{ old('status_kepemilikan_rumah')=='Ikut Orang Tua'?'selected':'' }}>Ikut Orang Tua</option>
                                            <option value="Kontrak" {{ old('status_kepemilikan_rumah')=='Kontrak'?'selected':'' }}>Kontrak</option>
                                        </select>
                                        @error('status_kepemilikan_rumah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Step 3: Data Usaha --}}
                            <div class="form-step" data-step="3">
                                <h5 class="mb-4 font-weight-bold" style="color:#1a3a6e">
                                    <i class="fas fa-store mr-2"></i>Data Usaha
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Nama Usaha <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_usaha" class="form-control @error('nama_usaha') is-invalid @enderror" required value="{{ old('nama_usaha') }}" placeholder="Nama usaha Anda">
                                        @error('nama_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Bidang Usaha <span class="text-danger">*</span></label>
                                        <select name="bidang_usaha" class="form-control @error('bidang_usaha') is-invalid @enderror" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Pertanian" {{ old('bidang_usaha')=='Pertanian'?'selected':'' }}>Pertanian</option>
                                            <option value="Perdagangan" {{ old('bidang_usaha')=='Perdagangan'?'selected':'' }}>Perdagangan</option>
                                            <option value="Jasa" {{ old('bidang_usaha')=='Jasa'?'selected':'' }}>Jasa</option>
                                            <option value="Industri" {{ old('bidang_usaha')=='Industri'?'selected':'' }}>Industri</option>
                                            <option value="Lainnya" {{ old('bidang_usaha')=='Lainnya'?'selected':'' }}>Lainnya</option>
                                        </select>
                                        @error('bidang_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Lama Berdiri Usaha (Tahun)</label>
                                        <input type="number" name="lama_berdiri_usaha" class="form-control @error('lama_berdiri_usaha') is-invalid @enderror" value="{{ old('lama_berdiri_usaha', 0) }}" min="0" placeholder="0">
                                        @error('lama_berdiri_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Jumlah Karyawan</label>
                                        <input type="number" name="jumlah_karyawan" class="form-control @error('jumlah_karyawan') is-invalid @enderror" value="{{ old('jumlah_karyawan', 0) }}" min="0" placeholder="0">
                                        @error('jumlah_karyawan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Modal Usaha (Rp)</label>
                                        <input type="number" name="modal_usaha" class="form-control @error('modal_usaha') is-invalid @enderror" value="{{ old('modal_usaha', 0) }}" min="0" placeholder="0">
                                        @error('modal_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Omzet per Bulan (Rp)</label>
                                        <input type="number" name="omzet_per_bulan" class="form-control @error('omzet_per_bulan') is-invalid @enderror" value="{{ old('omzet_per_bulan', 0) }}" min="0" placeholder="0">
                                        @error('omzet_per_bulan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Alamat Tempat Usaha</label>
                                        <textarea name="alamat_tempat_usaha" class="form-control @error('alamat_tempat_usaha') is-invalid @enderror" rows="2" placeholder="Alamat lengkap lokasi usaha">{{ old('alamat_tempat_usaha') }}</textarea>
                                        @error('alamat_tempat_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Legalitas Usaha</label>
                                        <select name="legalitas_usaha" class="form-control @error('legalitas_usaha') is-invalid @enderror">
                                            <option value="">-- Pilih --</option>
                                            <option value="Belum Ada" {{ old('legalitas_usaha')=='Belum Ada'?'selected':'' }}>Belum Ada</option>
                                            <option value="SIUP" {{ old('legalitas_usaha')=='SIUP'?'selected':'' }}>SIUP</option>
                                            <option value="TDP" {{ old('legalitas_usaha')=='TDP'?'selected':'' }}>TDP</option>
                                            <option value="NIB" {{ old('legalitas_usaha')=='NIB'?'selected':'' }}>NIB</option>
                                            <option value="PIRT" {{ old('legalitas_usaha')=='PIRT'?'selected':'' }}>PIRT</option>
                                            <option value="Lainnya" {{ old('legalitas_usaha')=='Lainnya'?'selected':'' }}>Lainnya</option>
                                        </select>
                                        @error('legalitas_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <small class="text-muted">Nomor izin usaha (jika ada)</small>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Keterangan Usaha</label>
                                        <textarea name="keterangan_usaha" class="form-control @error('keterangan_usaha') is-invalid @enderror" rows="3" placeholder="Deskripsi singkat tentang usaha Anda">{{ old('keterangan_usaha') }}</textarea>
                                        @error('keterangan_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h6 class="font-weight-bold mb-3" style="color:#1a3a6e">
                                    <i class="fas fa-users mr-2"></i>Data Ahli Waris <span class="text-danger">*</span>
                                </h6>
                                <p class="text-muted mb-3" style="font-size:13px">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Ahli waris adalah orang yang berhak menerima hak dan kewajiban anggota di koperasi
                                </p>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Ahli Waris <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_ahli_waris" class="form-control @error('nama_ahli_waris') is-invalid @enderror" required value="{{ old('nama_ahli_waris') }}" placeholder="Nama lengkap ahli waris">
                                        @error('nama_ahli_waris')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Hubungan Keluarga <span class="text-danger">*</span></label>
                                        <select name="hubungan_ahli_waris" class="form-control @error('hubungan_ahli_waris') is-invalid @enderror" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Suami/Istri" {{ old('hubungan_ahli_waris')=='Suami/Istri'?'selected':'' }}>Suami/Istri</option>
                                            <option value="Anak" {{ old('hubungan_ahli_waris')=='Anak'?'selected':'' }}>Anak</option>
                                            <option value="Orang Tua" {{ old('hubungan_ahli_waris')=='Orang Tua'?'selected':'' }}>Orang Tua</option>
                                            <option value="Saudara" {{ old('hubungan_ahli_waris')=='Saudara'?'selected':'' }}>Saudara</option>
                                        </select>
                                        @error('hubungan_ahli_waris')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">No. HP Ahli Waris <span class="text-danger">*</span></label>
                                        <input type="text" name="no_hp_ahli_waris" class="form-control @error('no_hp_ahli_waris') is-invalid @enderror" required value="{{ old('no_hp_ahli_waris') }}" placeholder="Contoh: 081234567890">
                                        @error('no_hp_ahli_waris')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">NIK Ahli Waris (16 digit) <span class="text-danger">*</span></label>
                                        <input type="text" name="nik_ahli_waris" class="form-control @error('nik_ahli_waris') is-invalid @enderror" maxlength="16" required value="{{ old('nik_ahli_waris') }}" placeholder="16 digit NIK">
                                        @error('nik_ahli_waris')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Step 4: Upload Dokumen --}}
                            <div class="form-step" data-step="4">
                                <h5 class="mb-4 font-weight-bold" style="color:#1a3a6e">
                                    <i class="fas fa-file-upload mr-2"></i>Upload Foto Diri
                                </h5>
                                
                                <div class="row justify-content-center">
                                    <div class="col-md-8 mb-4">
                                        <div class="text-center mb-3">
                                            <div style="width:120px;height:120px;margin:0 auto 20px;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:50%;display:flex;align-items:center;justify-content:center">
                                                <i class="fas fa-camera fa-3x text-white"></i>
                                            </div>
                                        </div>
                                        <label class="form-label text-center d-block">Foto Diri (Opsional)</label>
                                        <input type="file" name="foto" class="form-control" accept="image/*" id="fotoInput">
                                        <small class="text-muted d-block text-center mt-2">Format: JPG, PNG | Max: 2MB | Bisa diupload nanti</small>
                                        
                                        <div id="fotoPreview" class="mt-3" style="display:none">
                                            <div class="text-center">
                                                <img id="fotoPreviewImg" src="" style="max-width:300px;max-height:300px;border-radius:12px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Navigation Buttons --}}
                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <div>
                                    <a href="{{ route('admin.anggota.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </a>
                                    <button type="button" class="btn btn-secondary ml-2" id="btnPrev" style="display:none">
                                        <i class="fas fa-chevron-left mr-2"></i>Sebelumnya
                                    </button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary" id="btnNext">
                                        Selanjutnya <i class="fas fa-chevron-right ml-2"></i>
                                    </button>
                                    <button type="submit" class="btn btn-success btn-lg" id="btnSubmit" style="display:none;font-weight:700;padding:12px 30px;border-radius:10px;">
                                        <i class="fas fa-save mr-2"></i>Simpan & Tambahkan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
let currentStep = 1;
const totalSteps = 4;

// Validasi untuk setiap step
const stepValidations = {
    1: ['nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'status_perkawinan', 'pendidikan_terakhir', 'agama', 'no_hp', 'email', 'password', 'password_confirmation'],
    2: ['distrik'],
    3: ['nama_usaha', 'bidang_usaha', 'nama_ahli_waris', 'hubungan_ahli_waris', 'no_hp_ahli_waris', 'nik_ahli_waris'],
    4: [] // Foto tidak wajib untuk admin
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, initializing form...');
    
    // Show step 1 by default
    showStep(1);
    
    // Auto-scroll to error summary if there are errors
    const errorSummary = document.getElementById('errorSummary');
    if (errorSummary) {
        setTimeout(() => {
            errorSummary.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
            // Find which step has errors and show that step
            const invalidFields = document.querySelectorAll('.is-invalid');
            if (invalidFields.length > 0) {
                const firstInvalidField = invalidFields[0];
                const stepElement = firstInvalidField.closest('.form-step');
                if (stepElement) {
                    const stepNumber = parseInt(stepElement.getAttribute('data-step'));
                    if (stepNumber) {
                        currentStep = stepNumber;
                        showStep(currentStep);
                    }
                }
            }
        }, 500);
    }
    
    // Add real-time validation on blur and input
    document.querySelectorAll('input, select, textarea').forEach(field => {
        field.addEventListener('blur', function() {
            if (this.name) {
                validateField(this.name);
            }
        });
        
        field.addEventListener('input', function() {
            // Remove error on input
            this.classList.remove('is-invalid');
            const errorDiv = this.closest('.form-group')?.querySelector('.invalid-feedback') || 
                            this.closest('.col-md-6')?.querySelector('.invalid-feedback') ||
                            this.closest('.col-md-4')?.querySelector('.invalid-feedback') ||
                            this.closest('.col-md-12')?.querySelector('.invalid-feedback');
            if (errorDiv) errorDiv.remove();
        });
    });
    
    // Prevent non-numeric input in number fields
    const numericFields = document.querySelectorAll('input[type="number"]');
    numericFields.forEach(field => {
        field.addEventListener('keypress', function(e) {
            // Allow: backspace, delete, tab, escape, enter, decimal point
            if ([46, 8, 9, 27, 13, 110, 190].indexOf(e.keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (e.keyCode === 65 && e.ctrlKey === true) ||
                (e.keyCode === 67 && e.ctrlKey === true) ||
                (e.keyCode === 86 && e.ctrlKey === true) ||
                (e.keyCode === 88 && e.ctrlKey === true)) {
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        
        // Sanitize on blur (when user leaves the field)
        field.addEventListener('blur', function() {
            let value = this.value;
            // Remove any non-numeric characters except decimal point
            value = value.replace(/[^0-9.]/g, '');
            // If empty, set to 0
            if (value === '' || value === '.') {
                value = '0';
            }
            this.value = value;
        });
    });
});

// Preview foto
const fotoInput = document.getElementById('fotoInput');
if (fotoInput) {
    fotoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('fotoPreviewImg').src = e.target.result;
                document.getElementById('fotoPreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
}

function clearFoto() {
    document.getElementById('fotoInput').value = '';
    document.getElementById('fotoPreview').style.display = 'none';
    document.getElementById('fotoPreviewImg').src = '';
}

function validateField(fieldName) {
    const field = document.querySelector(`[name="${fieldName}"]`);
    if (!field) return true;
    
    const value = field.value.trim();
    const fieldGroup = field.closest('.form-group') || field.closest('.col-md-6') || field.closest('.col-md-4') || field.closest('.col-md-12');
    
    // Remove existing error
    const existingError = fieldGroup?.querySelector('.invalid-feedback');
    if (existingError) existingError.remove();
    field.classList.remove('is-invalid', 'is-valid');
    
    // Check if required
    const isRequired = field.hasAttribute('required');
    if (isRequired && !value) {
        showFieldError(field, 'Field ini wajib diisi');
        return false;
    }
    
    // Validasi khusus
    if (fieldName === 'nik' && value) {
        if (value.length !== 16) {
            showFieldError(field, 'NIK harus 16 digit');
            return false;
        }
        if (!/^\d+$/.test(value)) {
            showFieldError(field, 'NIK hanya boleh angka');
            return false;
        }
    }
    
    if (fieldName === 'nik_ahli_waris' && value) {
        if (value.length !== 16) {
            showFieldError(field, 'NIK Ahli Waris harus 16 digit');
            return false;
        }
        if (!/^\d+$/.test(value)) {
            showFieldError(field, 'NIK hanya boleh angka');
            return false;
        }
    }
    
    if (fieldName === 'email' && value) {
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            showFieldError(field, 'Format email tidak valid');
            return false;
        }
    }
    
    if (fieldName === 'password' && value) {
        if (value.length < 6) {
            showFieldError(field, 'Password minimal 6 karakter');
            return false;
        }
    }
    
    if (fieldName === 'password_confirmation' && value) {
        const password = document.querySelector('[name="password"]').value;
        if (value !== password) {
            showFieldError(field, 'Konfirmasi password tidak cocok');
            return false;
        }
    }
    
    if (fieldName === 'no_hp' && value) {
        if (!/^[0-9+\-\s()]+$/.test(value)) {
            showFieldError(field, 'Format nomor HP tidak valid');
            return false;
        }
    }
    
    if (fieldName === 'npwp' && value) {
        if (value.length !== 15) {
            showFieldError(field, 'NPWP harus 15 digit');
            return false;
        }
    }
    
    if (field.type === 'file' && isRequired) {
        if (!field.files || field.files.length === 0) {
            showFieldError(field, 'File wajib diupload');
            return false;
        }
        
        const file = field.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB
        if (file.size > maxSize) {
            showFieldError(field, 'Ukuran file maksimal 2MB');
            return false;
        }
        
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            showFieldError(field, 'File harus berformat JPG, JPEG, atau PNG');
            return false;
        }
    }
    
    // If valid, show green checkmark
    if (value || field.type === 'file') {
        field.classList.add('is-valid');
    }
    
    return true;
}

function showFieldError(field, message) {
    field.classList.add('is-invalid');
    const fieldGroup = field.closest('.form-group') || field.closest('.col-md-6') || field.closest('.col-md-4') || field.closest('.col-md-12');
    if (fieldGroup) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback d-block';
        errorDiv.style.cssText = 'color:#dc3545;font-size:0.85rem;margin-top:5px';
        errorDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i>${message}`;
        fieldGroup.appendChild(errorDiv);
    }
}

function validateStep(step) {
    const fieldsToValidate = stepValidations[step] || [];
    let isValid = true;
    
    fieldsToValidate.forEach(fieldName => {
        if (!validateField(fieldName)) {
            isValid = false;
        }
    });
    
    return isValid;
}

function showStep(step) {
    console.log('Showing step:', step);
    
    // Hide all steps
    document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
    
    // Show current step
    const currentStepEl = document.querySelector(`.form-step[data-step="${step}"]`);
    if (currentStepEl) {
        currentStepEl.classList.add('active');
    }
    
    // Update step indicators
    document.querySelectorAll('.step-item').forEach((el, index) => {
        el.classList.remove('active', 'completed');
        if (index + 1 < step) el.classList.add('completed');
        if (index + 1 === step) el.classList.add('active');
    });
    
    // Update button visibility
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    const btnSubmit = document.getElementById('btnSubmit');
    
    if (btnPrev) btnPrev.style.display = step === 1 ? 'none' : 'inline-block';
    if (btnNext) btnNext.style.display = step === totalSteps ? 'none' : 'inline-block';
    if (btnSubmit) btnSubmit.style.display = step === totalSteps ? 'inline-block' : 'none';
    
    window.scrollTo({top: 0, behavior: 'smooth'});
}

// Next button with validation
const btnNext = document.getElementById('btnNext');
if (btnNext) {
    btnNext.addEventListener('click', function() {
        console.log('Next clicked, current step:', currentStep);
        if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        } else {
            // Scroll to first error
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });
}

// Previous button
const btnPrev = document.getElementById('btnPrev');
if (btnPrev) {
    btnPrev.addEventListener('click', function() {
        console.log('Previous clicked, current step:', currentStep);
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });
}

// Form submit with validation
const form = document.getElementById('formPendaftaran');
if (form) {
    form.addEventListener('submit', function(e) {
        console.log('Form submit event triggered');
        
        // Validate all steps before submit
        let allValid = true;
        for (let step = 1; step <= totalSteps; step++) {
            if (!validateStep(step)) {
                allValid = false;
                // Go to first invalid step
                currentStep = step;
                showStep(currentStep);
                
                // Scroll to first error
                setTimeout(() => {
                    const firstError = document.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }
                }, 300);
                
                e.preventDefault();
                return false;
            }
        }
        
        if (!allValid) {
            e.preventDefault();
            return false;
        }
        
        const submitBtn = document.getElementById('btnSubmit');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
        }
        
        // Show loading overlay
        const loadingOverlay = document.createElement('div');
        loadingOverlay.id = 'loadingOverlay';
        loadingOverlay.style.cssText = 'position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.7);z-index:9999;display:flex;align-items:center;justify-content:center';
        loadingOverlay.innerHTML = `
            <div style="background:white;padding:40px;border-radius:16px;text-align:center;max-width:400px">
                <div style="width:80px;height:80px;margin:0 auto 20px;background:linear-gradient(135deg,#10b981,#059669);border-radius:50%;display:flex;align-items:center;justify-content:center">
                    <i class="fas fa-spinner fa-spin fa-3x text-white"></i>
                </div>
                <h5 class="font-weight-bold mb-2" style="color:#1a3a6e">Memproses Pendaftaran...</h5>
                <p class="text-muted mb-0">Mohon tunggu, kami sedang membuat akun anggota</p>
            </div>
        `;
        document.body.appendChild(loadingOverlay);
        
        console.log('Form submitting to server...');
    });
}

// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field && icon) {
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
}
</script>
@endpush
@endsection
