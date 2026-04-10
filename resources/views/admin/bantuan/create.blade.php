@extends('layouts.app')

@section('title', 'Tambah Bantuan')
@section('page-title', 'Tambah Program Bantuan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.bantuan.index') }}">Daftar Bantuan</a></li>
    <li class="breadcrumb-item active">Tambah Bantuan</li>
@endsection

@push('styles')
<style>
    .form-card {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .form-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    .form-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid #007bff;
    }
    .form-section h5 {
        color: #007bff;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        border-radius: 6px;
        border: 1px solid #ced4da;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.15);
    }
    .required-badge {
        color: #dc3545;
        font-weight: bold;
    }
    .btn-action {
        padding: 10px 30px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .info-box {
        background: #e7f3ff;
        border-left: 4px solid #007bff;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }
    .input-group-text {
        background: #007bff;
        color: white;
        border: none;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Info Box -->
        <div class="info-box">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-2x text-primary mr-3"></i>
                <div>
                    <h6 class="mb-1 font-weight-bold">Informasi</h6>
                    <p class="mb-0 small">Lengkapi formulir di bawah ini untuk menambahkan program bantuan baru. Pastikan semua data yang diisi sudah benar.</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card form-card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle mr-2"></i>Form Tambah Bantuan
                </h5>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <h6 class="alert-heading">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Terdapat kesalahan!
                        </h6>
                        <ul class="mb-0 pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('admin.bantuan.store') }}" method="POST" id="formBantuan">
                    @csrf

                    <!-- Section 1: Informasi Dasar -->
                    <div class="form-section">
                        <h5>
                            <i class="fas fa-file-alt mr-2"></i>Informasi Dasar
                        </h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Nama Bantuan <span class="required-badge">*</span>
                                </label>
                                <input type="text" 
                                       name="nama_bantuan" 
                                       class="form-control @error('nama_bantuan') is-invalid @enderror"
                                       value="{{ old('nama_bantuan') }}" 
                                       placeholder="Contoh: Bantuan Modal Usaha"
                                       required>
                                @error('nama_bantuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Jenis Bantuan <span class="required-badge">*</span>
                                </label>
                                <select name="jenis_bantuan" 
                                        class="form-control @error('jenis_bantuan') is-invalid @enderror" 
                                        required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="tunai" @selected(old('jenis_bantuan') == 'tunai')>
                                        💰 Tunai
                                    </option>
                                    <option value="barang" @selected(old('jenis_bantuan') == 'barang')>
                                        📦 Barang
                                    </option>
                                    <option value="pelatihan" @selected(old('jenis_bantuan') == 'pelatihan')>
                                        🎓 Pelatihan
                                    </option>
                                    <option value="lainnya" @selected(old('jenis_bantuan') == 'lainnya')>
                                        📋 Lainnya
                                    </option>
                                </select>
                                @error('jenis_bantuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" 
                                          class="form-control @error('deskripsi') is-invalid @enderror"
                                          rows="4"
                                          placeholder="Jelaskan detail program bantuan ini...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Periode & Kuota -->
                    <div class="form-section" style="border-left-color: #28a745;">
                        <h5 style="color: #28a745;">
                            <i class="fas fa-calendar-alt mr-2"></i>Periode & Kuota
                        </h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    Tahun <span class="required-badge">*</span>
                                </label>
                                <input type="number" 
                                       name="tahun" 
                                       class="form-control @error('tahun') is-invalid @enderror"
                                       value="{{ old('tahun', date('Y')) }}" 
                                       min="2020" 
                                       max="2099" 
                                       required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    Periode <span class="required-badge">*</span>
                                </label>
                                <input type="text" 
                                       name="periode" 
                                       class="form-control @error('periode') is-invalid @enderror"
                                       value="{{ old('periode') }}" 
                                       placeholder="cth: Semester 1 / Triwulan I" 
                                       required>
                                @error('periode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    Kuota <span class="required-badge">*</span>
                                </label>
                                <input type="number" 
                                       name="kuota" 
                                       class="form-control @error('kuota') is-invalid @enderror"
                                       value="{{ old('kuota') }}" 
                                       min="1" 
                                       placeholder="Jumlah penerima"
                                       required>
                                @error('kuota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Anggaran -->
                    <div class="form-section" style="border-left-color: #ffc107;">
                        <h5 style="color: #ffc107;">
                            <i class="fas fa-money-bill-wave mr-2"></i>Anggaran
                        </h5>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">
                                    Total Anggaran <span class="required-badge">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" 
                                           name="anggaran" 
                                           class="form-control @error('anggaran') is-invalid @enderror"
                                           value="{{ old('anggaran') }}" 
                                           min="0" 
                                           step="1000"
                                           placeholder="0"
                                           required>
                                    @error('anggaran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Masukkan total anggaran dalam Rupiah
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ route('admin.bantuan.index') }}" class="btn btn-secondary btn-action">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <div>
                            <button type="reset" class="btn btn-outline-secondary btn-action mr-2">
                                <i class="fas fa-redo mr-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary btn-action">
                                <i class="fas fa-save mr-2"></i>Simpan Bantuan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Format input anggaran dengan thousand separator
    $('input[name="anggaran"]').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        $(this).val(value);
    });
    
    // Konfirmasi sebelum reset
    $('button[type="reset"]').on('click', function(e) {
        if (!confirm('Yakin ingin mereset semua input?')) {
            e.preventDefault();
        }
    });
    
    // Validasi form sebelum submit
    $('#formBantuan').on('submit', function(e) {
        let isValid = true;
        
        // Cek required fields
        $(this).find('[required]').each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
        }
    });
});
</script>
@endpush