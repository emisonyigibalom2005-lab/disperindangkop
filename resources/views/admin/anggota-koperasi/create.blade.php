@extends('layouts.app')
@section('title', 'Tambah Anggota ke Koperasi')

@push('styles')
<style>
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }
    
    .form-card-header {
        padding-bottom: 20px;
        margin-bottom: 25px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .form-card-header h5 {
        margin: 0;
        color: #1f2937;
        font-weight: 800;
        font-size: 18px;
    }
    
    .form-card-header p {
        margin: 5px 0 0 0;
        color: #6b7280;
        font-size: 14px;
    }
    
    .form-group label {
        font-weight: 700;
        color: #374151;
        font-size: 14px;
        margin-bottom: 8px;
    }
    
    .form-control {
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .btn-primary {
        background: #3b82f6;
        border: none;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }
    
    .btn-secondary {
        background: #6b7280;
        border: none;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-2px);
    }
    
    .alert {
        border-radius: 12px;
        border: none;
        padding: 15px 20px;
        margin-bottom: 20px;
    }
    
    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .info-box {
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 25px;
    }
    
    .info-box i {
        color: #3b82f6;
        margin-right: 10px;
    }
    
    .info-box p {
        margin: 0;
        color: #1e40af;
        font-size: 14px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-card-header">
                    <h5><i class="fas fa-user-plus mr-2"></i>Tambah Anggota ke Koperasi</h5>
                    <p>Pilih koperasi dan anggota yang akan ditambahkan</p>
                </div>

                @if($errors->any())
                <div class="alert alert-danger">
                    <strong><i class="fas fa-exclamation-triangle mr-2"></i>Terjadi Kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="info-box">
                    <i class="fas fa-info-circle"></i>
                    <p>Pilih koperasi tujuan dan anggota yang belum tergabung di koperasi manapun untuk ditambahkan.</p>
                </div>

                <form action="{{ route('admin.anggota-koperasi.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="koperasi_id">
                            Pilih Koperasi <span class="text-danger">*</span>
                        </label>
                        <select name="koperasi_id" id="koperasi_id" class="form-control @error('koperasi_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Koperasi --</option>
                            @foreach($koperasiList as $koperasi)
                            <option value="{{ $koperasi->id }}" {{ old('koperasi_id') == $koperasi->id ? 'selected' : '' }}>
                                {{ $koperasi->nama_usaha }} ({{ $koperasi->no_registrasi }})
                            </option>
                            @endforeach
                        </select>
                        @error('koperasi_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($koperasiList->count() == 0)
                        <small class="text-danger">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            Belum ada koperasi yang aktif dan terverifikasi. Silakan tambahkan koperasi terlebih dahulu.
                        </small>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="anggota_id">
                            Pilih Anggota <span class="text-danger">*</span>
                        </label>
                        <select name="anggota_id" id="anggota_id" class="form-control @error('anggota_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($anggotaBelumTergabung as $anggota)
                            <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                {{ $anggota->nama }} - {{ $anggota->no_anggota }} ({{ $anggota->nik }})
                            </option>
                            @endforeach
                        </select>
                        @error('anggota_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($anggotaBelumTergabung->count() == 0)
                        <small class="text-danger">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            Tidak ada anggota yang belum tergabung di koperasi. Semua anggota aktif sudah tergabung dalam koperasi.
                        </small>
                        @endif
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary" {{ ($koperasiList->count() == 0 || $anggotaBelumTergabung->count() == 0) ? 'disabled' : '' }}>
                            <i class="fas fa-save mr-2"></i>Simpan
                        </button>
                        <a href="{{ route('admin.anggota-koperasi.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add search functionality to select boxes
    const koperasiSelect = document.getElementById('koperasi_id');
    const anggotaSelect = document.getElementById('anggota_id');
    
    // Simple filter for select options
    function filterSelect(selectElement, searchTerm) {
        const options = selectElement.querySelectorAll('option');
        searchTerm = searchTerm.toLowerCase();
        
        options.forEach(option => {
            if (option.value === '') return; // Skip placeholder
            const text = option.textContent.toLowerCase();
            option.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    }
    
    // You can add Select2 or similar library here for better UX
    // For now, basic functionality is provided
});
</script>
@endpush
