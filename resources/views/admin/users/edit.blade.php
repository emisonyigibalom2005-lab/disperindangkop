@extends('layouts.app')
@section('title', 'Edit User')

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
.section-divider {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 12px 20px;
    border-radius: 10px;
    margin: 30px 0 20px 0;
    border-left: 4px solid #1a3a6e;
}
.section-divider h6 {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #1a3a6e;
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
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-left: 4px solid #f59e0b;
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}
.info-box-modern i {
    color: #d97706;
    font-size: 16px;
    margin-right: 8px;
}
.info-box-modern p {
    margin: 0;
    font-size: 13px;
    color: #78350f;
    font-weight: 600;
}
.custom-switch-modern {
    padding-left: 3rem;
}
.custom-switch-modern .custom-control-label {
    font-weight: 600;
    color: #374151;
    font-size: 14px;
}
.custom-switch-modern .custom-control-label::before {
    width: 3rem;
    height: 1.5rem;
    border-radius: 1rem;
    background-color: #e5e7eb;
    border: none;
}
.custom-switch-modern .custom-control-input:checked ~ .custom-control-label::before {
    background-color: #10b981;
}
.custom-switch-modern .custom-control-label::after {
    width: 1.25rem;
    height: 1.25rem;
    border-radius: 50%;
    top: 0.125rem;
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
.btn-save-modern {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}
.btn-save-modern:hover {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(245, 158, 11, 0.3);
    color: white;
}
.btn-back-modern {
    background: #6b7280;
    color: white;
}
.btn-back-modern:hover {
    background: #4b5563;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(107, 114, 128, 0.3);
    color: white;
}
.alert-modern {
    border-radius: 12px;
    border: none;
    padding: 15px 20px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.alert-success-modern {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    border-left: 4px solid #10b981;
}
.alert-error-modern {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
    border-left: 4px solid #ef4444;
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
                <li class="breadcrumb-item active">Edit User</li>
            </ol>
        </nav>
        <h1 class="text-white mb-0" style="font-size: 1.8rem; font-weight: 700;">
            <i class="fas fa-user-edit mr-2"></i>Edit User: {{ $user->name }}
        </h1>
    </div>
</div>

<div class="container-fluid">
    @if(session('success'))
    <div class="alert-modern alert-success-modern">
        <i class="fas fa-check-circle" style="font-size: 20px;"></i>
        <span style="font-weight: 600;">{{ session('success') }}</span>
        <button type="button" class="close" data-dismiss="alert" style="margin-left: auto;">
            <span>&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert-modern alert-error-modern">
        <i class="fas fa-exclamation-circle" style="font-size: 20px;"></i>
        <span style="font-weight: 600;">{{ session('error') }}</span>
        <button type="button" class="close" data-dismiss="alert" style="margin-left: auto;">
            <span>&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card card-modern">
                <div class="card-header-modern">
                    <h4><i class="fas fa-edit mr-2"></i>Form Edit User</h4>
                </div>
                
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf 
                    @method('PUT')
                    
                    <div class="card-body" style="padding: 30px;">
                        {{-- Informasi User --}}
                        <div class="section-divider">
                            <h6><i class="fas fa-user-circle mr-2"></i>Informasi User</h6>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern mb-4">
                                    <label>
                                        <i class="fas fa-user"></i>Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           class="form-control form-control-modern @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $user->name) }}" 
                                           placeholder="Masukkan nama lengkap"
                                           required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-modern mb-4">
                                    <label>
                                        <i class="fas fa-envelope"></i>Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           name="email" 
                                           class="form-control form-control-modern @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $user->email) }}" 
                                           placeholder="contoh@email.com"
                                           required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern mb-4">
                                    <label>
                                        <i class="fas fa-user-tag"></i>Role <span class="text-danger">*</span>
                                    </label>
                                    <select name="role" 
                                            class="form-control form-control-modern @error('role') is-invalid @enderror" 
                                            required>
                                        <option value="">-- Pilih Role --</option>
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                            Admin - Akses Penuh Sistem
                                        </option>
                                        <option value="petugas" {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}>
                                            Petugas - Kelola Data Operasional
                                        </option>
                                        <option value="pimpinan" {{ old('role', $user->role) === 'pimpinan' ? 'selected' : '' }}>
                                            Pimpinan - Lihat Laporan & Dashboard
                                        </option>
                                        <option value="anggota" {{ old('role', $user->role) === 'anggota' ? 'selected' : '' }}>
                                            Anggota - Akses Portal Anggota
                                        </option>
                                    </select>
                                    @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-modern mb-4">
                                    <label>
                                        <i class="fas fa-phone"></i>No. Telepon
                                    </label>
                                    <input type="text" 
                                           name="phone" 
                                           class="form-control form-control-modern @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone', $user->phone) }}" 
                                           placeholder="08xxxxxxxxxx">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted" style="font-size: 11px; font-weight: 500;">
                                        <i class="fas fa-info-circle mr-1"></i>Format: 08xxxxxxxxxx
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Ubah Password --}}
                        <div class="section-divider">
                            <h6><i class="fas fa-key mr-2"></i>Ubah Password</h6>
                        </div>

                        <div class="info-box-modern">
                            <i class="fas fa-info-circle"></i>
                            <p><strong>Catatan:</strong> Kosongkan field password jika tidak ingin mengubah password user.</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern mb-4">
                                    <label>
                                        <i class="fas fa-lock"></i>Password Baru
                                    </label>
                                    <input type="password" 
                                           name="password" 
                                           class="form-control form-control-modern @error('password') is-invalid @enderror" 
                                           placeholder="Minimal 6 karakter">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted" style="font-size: 11px; font-weight: 500;">
                                        <i class="fas fa-shield-alt mr-1"></i>Minimal 6 karakter
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-modern mb-4">
                                    <label>
                                        <i class="fas fa-lock"></i>Konfirmasi Password Baru
                                    </label>
                                    <input type="password" 
                                           name="password_confirmation" 
                                           class="form-control form-control-modern" 
                                           placeholder="Ulangi password baru">
                                    <small class="text-muted" style="font-size: 11px; font-weight: 500;">
                                        <i class="fas fa-check-double mr-1"></i>Harus sama dengan password baru
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Status Akun --}}
                        <div class="section-divider">
                            <h6><i class="fas fa-toggle-on mr-2"></i>Status Akun</h6>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group-modern">
                                    <div class="custom-control custom-switch custom-switch-modern">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1"
                                               {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">
                                            Akun Aktif
                                        </label>
                                    </div>
                                    <small class="text-muted ml-5" style="font-size: 11px; font-weight: 500; display: block; margin-top: 5px;">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Nonaktifkan untuk melarang user login ke sistem
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer" style="background: #f8f9fa; padding: 20px 30px;">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <button type="submit" class="btn btn-save-modern btn-modern btn-block">
                                    <i class="fas fa-save"></i>
                                    <span>Simpan Perubahan</span>
                                </button>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="{{ url()->previous() }}" class="btn btn-back-modern btn-modern btn-block">
                                    <i class="fas fa-arrow-left"></i>
                                    <span>Kembali</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
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
                        <i class="fas fa-exclamation-triangle mr-2"></i>Perhatian
                    </h6>
                    <ul class="mb-0" style="padding-left: 20px; color: #78350f;">
                        <li class="mb-2">
                            <small style="font-weight: 600;">Perubahan role akan mempengaruhi hak akses user</small>
                        </li>
                        <li class="mb-2">
                            <small style="font-weight: 600;">Pastikan email yang digunakan valid dan aktif</small>
                        </li>
                        <li class="mb-0">
                            <small style="font-weight: 600;">Password minimal 6 karakter untuk keamanan</small>
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
// Auto dismiss alerts
setTimeout(function() {
    $('.alert-modern').fadeOut('slow');
}, 5000);

// Form validation
$('form').on('submit', function(e) {
    var password = $('input[name="password"]').val();
    var passwordConfirm = $('input[name="password_confirmation"]').val();
    
    if (password && password !== passwordConfirm) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Password Tidak Cocok!',
            text: 'Password dan Konfirmasi Password harus sama.',
            confirmButtonColor: '#ef4444'
        });
        return false;
    }
});
</script>
@endpush
