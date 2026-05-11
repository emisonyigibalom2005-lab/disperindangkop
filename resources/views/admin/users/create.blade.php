@extends('layouts.app')
@section('title', 'Tambah User Baru')

@push('styles')
<style>
.page-header-modern {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 50%, #4a7bc8 100%);
    padding: 30px 0;
    margin-bottom: 30px;
    border-radius: 0 0 20px 20px;
    box-shadow: 0 4px 20px rgba(26, 58, 110, 0.15);
}
.breadcrumb-modern {
    background: transparent;
    padding: 0;
    margin: 0;
}
.breadcrumb-modern .breadcrumb-item {
    font-size: 13px;
    font-weight: 600;
}
.breadcrumb-modern .breadcrumb-item a {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
}
.breadcrumb-modern .breadcrumb-item a:hover {
    color: white;
}
.breadcrumb-modern .breadcrumb-item.active {
    color: white;
}
.breadcrumb-modern .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,0.6);
}
.card-modern {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}
.card-header-modern {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 25px 30px;
    border-bottom: 3px solid #dee2e6;
}
.card-header-modern h4 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: #1a3a6e;
}
.card-header-modern p {
    margin: 5px 0 0 0;
    font-size: 13px;
    color: #6b7280;
    font-weight: 500;
}
.form-group-modern label {
    font-weight: 700;
    font-size: 13px;
    color: #374151;
    margin-bottom: 8px;
    display: block;
}
.form-group-modern label i {
    margin-right: 6px;
    color: #1a3a6e;
}
.form-control-modern {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    padding: 12px 16px;
    font-size: 14px;
    transition: all 0.3s ease;
    font-weight: 500;
}
.form-control-modern:focus {
    border-color: #1a3a6e;
    box-shadow: 0 0 0 4px rgba(26, 58, 110, 0.1);
    outline: none;
}
.form-control-modern.is-invalid {
    border-color: #ef4444;
}
.form-control-modern.is-invalid:focus {
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
}
select.form-control-modern {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%231a3a6e' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 15px center;
    padding-right: 40px;
}
.info-box-modern {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border-left: 4px solid #3b82f6;
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 25px;
}
.info-box-modern i {
    color: #1e40af;
    font-size: 16px;
    margin-right: 8px;
}
.info-box-modern p {
    margin: 0;
    font-size: 13px;
    color: #1e3a8a;
    font-weight: 600;
}
.btn-modern {
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 700;
    border-radius: 10px;
    border: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.btn-primary-modern {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 100%);
    color: white;
}
.btn-primary-modern:hover {
    background: linear-gradient(135deg, #2d5aa0 0%, #4a7bc8 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(26, 58, 110, 0.3);
    color: white;
}
.btn-secondary-modern {
    background: #6b7280;
    color: white;
}
.btn-secondary-modern:hover {
    background: #4b5563;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(107, 114, 128, 0.3);
    color: white;
}
.role-info-card {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border-radius: 12px;
    padding: 20px;
    border-left: 4px solid #3b82f6;
}
.role-info-card h6 {
    color: #1e40af;
    font-weight: 700;
    margin-bottom: 15px;
    font-size: 14px;
}
.role-info-card ul {
    margin: 0;
    padding-left: 20px;
}
.role-info-card ul li {
    color: #1e3a8a;
    font-size: 12px;
    margin-bottom: 8px;
    font-weight: 500;
}
</style>
@endpush

@section('content')
<div class="page-header-modern">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-modern">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> Manajemen Pengguna</a></li>
                <li class="breadcrumb-item active">Tambah User Baru</li>
            </ol>
        </nav>
        <h1 class="text-white mb-0" style="font-size: 1.8rem; font-weight: 700;">
            <i class="fas fa-user-plus mr-2"></i>Tambah User Baru
        </h1>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            {{-- Info Box --}}
            <div class="info-box-modern">
                <i class="fas fa-info-circle"></i>
                <p><strong>Informasi:</strong> Isi formulir di bawah ini untuk menambahkan pengguna baru ke sistem. Pastikan semua data yang diisi sudah benar.</p>
            </div>

            {{-- Form Card --}}
            <div class="card card-modern">
                <div class="card-header-modern">
                    <h4><i class="fas fa-user-plus mr-2"></i>Form Tambah User Baru</h4>
                    <p>Lengkapi semua informasi pengguna yang diperlukan</p>
                </div>
                <div class="card-body" style="padding: 30px;">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        
                        {{-- Nama Lengkap --}}
                        <div class="form-group-modern mb-4">
                            <label>
                                <i class="fas fa-user"></i>Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control form-control-modern @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" 
                                   placeholder="Masukkan nama lengkap pengguna"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group-modern mb-4">
                            <label>
                                <i class="fas fa-envelope"></i>Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control form-control-modern @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" 
                                   placeholder="contoh@email.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div class="form-group-modern mb-4">
                            <label>
                                <i class="fas fa-user-tag"></i>Role / Peran <span class="text-danger">*</span>
                            </label>
                            <select name="role" 
                                    class="form-control form-control-modern @error('role') is-invalid @enderror" 
                                    required>
                                <option value="">-- Pilih Role Pengguna --</option>
                                <option value="admin" {{ old('role')==='admin'?'selected':'' }}>Admin - Akses Penuh Sistem</option>
                                <option value="petugas" {{ old('role')==='petugas'?'selected':'' }}>Petugas - Kelola Data Operasional</option>
                                <option value="pimpinan" {{ old('role')==='pimpinan'?'selected':'' }}>Pimpinan - Lihat Laporan & Dashboard</option>
                                <option value="anggota" {{ old('role')==='anggota'?'selected':'' }}>Anggota - Akses Portal Anggota</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- No. Telepon --}}
                        <div class="form-group-modern mb-4">
                            <label>
                                <i class="fas fa-phone"></i>No. Telepon
                            </label>
                            <input type="text" 
                                   name="phone" 
                                   class="form-control form-control-modern" 
                                   value="{{ old('phone') }}"
                                   placeholder="08xxxxxxxxxx">
                            <small class="text-muted" style="font-size: 11px; font-weight: 500; display: block; margin-top: 5px;">
                                <i class="fas fa-info-circle mr-1"></i>Opsional - Format: 08xxxxxxxxxx
                            </small>
                        </div>

                        {{-- Password --}}
                        <div class="form-group-modern mb-4">
                            <label>
                                <i class="fas fa-lock"></i>Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   name="password" 
                                   class="form-control form-control-modern @error('password') is-invalid @enderror" 
                                   placeholder="Minimal 8 karakter"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted" style="font-size: 11px; font-weight: 500; display: block; margin-top: 5px;">
                                <i class="fas fa-shield-alt mr-1"></i>Gunakan kombinasi huruf, angka, dan simbol untuk keamanan
                            </small>
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="form-group-modern mb-4">
                            <label>
                                <i class="fas fa-lock"></i>Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="form-control form-control-modern" 
                                   placeholder="Ketik ulang password"
                                   required>
                        </div>

                        {{-- Buttons --}}
                        <div class="row mt-4">
                            <div class="col-md-6 mb-2">
                                <button type="submit" class="btn btn-primary-modern btn-modern btn-block">
                                    <i class="fas fa-save"></i>
                                    <span>Simpan User</span>
                                </button>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary-modern btn-modern btn-block">
                                    <i class="fas fa-arrow-left"></i>
                                    <span>Kembali</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Info Card --}}
        <div class="col-lg-4">
            <div class="role-info-card">
                <h6><i class="fas fa-info-circle mr-2"></i>Informasi Role</h6>
                <ul>
                    <li><strong>Admin:</strong> Memiliki akses penuh ke semua fitur sistem</li>
                    <li><strong>Petugas:</strong> Dapat mengelola data koperasi dan anggota</li>
                    <li><strong>Pimpinan:</strong> Dapat melihat laporan dan statistik</li>
                    <li><strong>Anggota:</strong> Akses untuk anggota koperasi</li>
                </ul>
            </div>

            <div class="card card-modern mt-3" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                <div class="card-body" style="padding: 20px;">
                    <h6 style="color: #78350f; font-weight: 700; margin-bottom: 12px;">
                        <i class="fas fa-shield-alt mr-2"></i>Tips Keamanan
                    </h6>
                    <ul class="mb-0" style="padding-left: 20px; color: #78350f;">
                        <li class="mb-2">
                            <small style="font-weight: 600;">Password minimal 8 karakter</small>
                        </li>
                        <li class="mb-2">
                            <small style="font-weight: 600;">Gunakan kombinasi huruf besar, kecil, angka</small>
                        </li>
                        <li class="mb-0">
                            <small style="font-weight: 600;">Tambahkan simbol untuk keamanan ekstra</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Show validation errors if any
@if($errors->any())
Swal.fire({
    icon: 'error',
    title: 'Validasi Gagal!',
    html: '<ul style="text-align: left; padding-left: 20px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
    confirmButtonColor: '#ef4444'
});
@endif
</script>
@endpush
