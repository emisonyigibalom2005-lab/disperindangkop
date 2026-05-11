@extends('layouts.app')
@section('title', 'Profil Saya')

@push('styles')
<style>
.page-header-profile {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 50%, #4a7bc8 100%);
    padding: 30px 0;
    margin-bottom: 30px;
    border-radius: 0 0 20px 20px;
    box-shadow: 0 4px 20px rgba(26, 58, 110, 0.15);
    position: relative;
    overflow: hidden;
}
.page-header-profile::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
}
.profile-card-modern {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 24px;
}
.profile-header-gradient {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 100%);
    padding: 40px 30px 80px;
    position: relative;
    text-align: center;
}
.profile-header-gradient::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,101.3C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
    background-size: cover;
    opacity: 0.3;
}
.profile-avatar-wrapper {
    position: relative;
    display: inline-block;
    margin-top: -60px;
    z-index: 10;
}
.profile-avatar-modern {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 6px solid white;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    object-fit: cover;
    background: white;
}
.avatar-initial-modern {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 6px solid white;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 60px;
    font-weight: 800;
    color: white;
}
.camera-btn-modern {
    position: absolute;
    bottom: 8px;
    right: 8px;
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    border: 4px solid white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
}
.camera-btn-modern:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(245, 158, 11, 0.6);
}
.camera-btn-modern i {
    color: white;
    font-size: 18px;
}
.profile-info-modern {
    padding: 30px;
    text-align: center;
}
.profile-name-modern {
    font-size: 28px;
    font-weight: 800;
    color: #1a3a6e;
    margin-bottom: 10px;
}
.profile-role-badge {
    display: inline-block;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 20px;
}
.role-admin {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}
.role-petugas {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}
.role-pimpinan {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}
.role-anggota {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    color: white;
}
.profile-meta-modern {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
    padding: 20px 0;
    border-top: 2px solid #f3f4f6;
    margin-top: 20px;
}
.meta-item-modern {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: #f9fafb;
    border-radius: 10px;
}
.meta-item-modern i {
    font-size: 20px;
    color: #1a3a6e;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border-radius: 8px;
}
.meta-item-modern .content {
    flex: 1;
    text-align: left;
}
.meta-item-modern .label {
    font-size: 11px;
    color: #6b7280;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}
.meta-item-modern .value {
    font-size: 14px;
    color: #1a3a6e;
    font-weight: 700;
}
.form-card-modern {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}
.form-header-modern {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 24px 30px;
    border-bottom: 3px solid #dee2e6;
}
.form-header-modern h5 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: #1a3a6e;
    display: flex;
    align-items: center;
    gap: 12px;
}
.form-body-modern {
    padding: 35px;
}
.form-group-modern {
    margin-bottom: 24px;
}
.form-label-modern {
    font-size: 13px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 8px;
    display: block;
}
.form-label-modern i {
    color: #1a3a6e;
}
.form-control-modern {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: white;
    font-weight: 500;
}
.form-control-modern:focus {
    outline: none;
    border-color: #1a3a6e;
    background: white;
    box-shadow: 0 0 0 4px rgba(26, 58, 110, 0.1);
}
.form-control-modern.is-invalid {
    border-color: #ef4444;
}
.section-divider-modern {
    margin: 35px 0;
    border: 0;
    border-top: 2px solid #e5e7eb;
    position: relative;
}
.section-divider-modern::after {
    content: 'UBAH PASSWORD';
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    padding: 0 15px;
    font-size: 11px;
    font-weight: 700;
    color: #6b7280;
    letter-spacing: 1px;
}
.btn-save-modern {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 100%);
    border: none;
    border-radius: 12px;
    color: white;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(26, 58, 110, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.btn-save-modern:hover {
    background: linear-gradient(135deg, #2d5aa0 0%, #4a7bc8 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(26, 58, 110, 0.4);
    color: white;
}
.alert-modern {
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    animation: slideDown 0.3s ease;
    border: none;
}
.alert-success-modern {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border-left: 4px solid #10b981;
    color: #065f46;
}
.alert-success-modern i {
    color: #10b981;
    font-size: 20px;
}
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.file-upload-modern {
    position: relative;
    display: block;
    padding: 20px;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f9fafb;
}
.file-upload-modern:hover {
    border-color: #1a3a6e;
    background: white;
}
.file-upload-modern input[type="file"] {
    display: none;
}
.file-upload-label {
    font-size: 14px;
    color: #1a3a6e;
    font-weight: 700;
}
.file-upload-hint {
    font-size: 12px;
    color: #6b7280;
    margin-top: 6px;
    font-weight: 500;
}
.info-box-profile {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-left: 4px solid #f59e0b;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
}
.info-box-profile i {
    color: #d97706;
    font-size: 16px;
    margin-right: 8px;
}
.info-box-profile p {
    margin: 0;
    font-size: 13px;
    color: #78350f;
    font-weight: 600;
}
@media (max-width: 768px) {
    .profile-header-gradient {
        padding: 30px 20px 70px;
    }
    .profile-avatar-modern,
    .avatar-initial-modern {
        width: 120px;
        height: 120px;
    }
    .avatar-initial-modern {
        font-size: 48px;
    }
    .profile-name-modern {
        font-size: 22px;
    }
    .form-body-modern {
        padding: 25px 20px;
    }
}
</style>
@endpush

@section('content')
<div class="page-header-profile">
    <div class="container-fluid">
        <h1 class="text-white mb-0" style="font-size: 1.8rem; font-weight: 700; position: relative; z-index: 1;">
            <i class="fas fa-user-circle mr-2"></i>Profil Saya
        </h1>
    </div>
</div>

<div class="container-fluid">
    @if(session('success'))
    <div class="alert-modern alert-success-modern">
        <i class="fas fa-check-circle"></i>
        <span style="font-weight: 600;">{{ session('success') }}</span>
    </div>
    @endif

    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4 mb-4">
            <div class="profile-card-modern">
                <div class="profile-header-gradient"></div>
                
                <div class="profile-info-modern">
                    <div class="profile-avatar-wrapper">
                        @if($user->profile_photo)
                        <img src="{{ asset('storage/'.$user->profile_photo) }}" 
                             id="previewFoto" 
                             class="profile-avatar-modern" 
                             alt="{{ $user->name }}">
                        <div id="avatarInisial" class="avatar-initial-modern" style="display:none;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        @else
                        <div id="avatarInisial" class="avatar-initial-modern">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <img src="" 
                             id="previewFoto" 
                             class="profile-avatar-modern" 
                             style="display:none;" 
                             alt="{{ $user->name }}">
                        @endif
                        
                        <label for="inputFoto" class="camera-btn-modern" title="Ganti Foto">
                            <i class="fas fa-camera"></i>
                        </label>
                    </div>

                    <h3 class="profile-name-modern">{{ $user->name }}</h3>
                    
                    <span class="profile-role-badge role-{{ $user->role }}">
                        @if($user->role === 'admin')
                            <i class="fas fa-user-shield mr-1"></i>Admin
                        @elseif($user->role === 'petugas')
                            <i class="fas fa-user-tie mr-1"></i>Petugas
                        @elseif($user->role === 'pimpinan')
                            <i class="fas fa-user-crown mr-1"></i>Pimpinan
                        @else
                            <i class="fas fa-user mr-1"></i>{{ ucfirst($user->role) }}
                        @endif
                    </span>

                    <div class="profile-meta-modern">
                        <div class="meta-item-modern">
                            <i class="fas fa-envelope"></i>
                            <div class="content">
                                <div class="label">Email</div>
                                <div class="value">{{ $user->email }}</div>
                            </div>
                        </div>
                        
                        <div class="meta-item-modern">
                            <i class="fas fa-phone"></i>
                            <div class="content">
                                <div class="label">Telepon</div>
                                <div class="value">{{ $user->phone ?: 'Belum diisi' }}</div>
                            </div>
                        </div>

                        <div class="meta-item-modern">
                            <i class="fas fa-calendar-alt"></i>
                            <div class="content">
                                <div class="label">Bergabung Sejak</div>
                                <div class="value">{{ $user->created_at->format('d F Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Edit Profile -->
        <div class="col-lg-8 mb-4">
            <div class="form-card-modern">
                <div class="form-header-modern">
                    <h5>
                        <i class="fas fa-user-edit"></i>
                        Edit Profil
                    </h5>
                </div>

                <div class="form-body-modern">
                    <div class="info-box-profile">
                        <i class="fas fa-info-circle"></i>
                        <p><strong>Informasi:</strong> Perbarui data profil Anda di bawah ini. Pastikan email yang digunakan masih aktif.</p>
                    </div>

                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        @method('PUT')

                        <!-- Upload Foto -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-image mr-2"></i>Foto Profil
                            </label>
                            <label for="inputFoto" class="file-upload-modern">
                                <input type="file" 
                                       id="inputFoto" 
                                       name="profile_photo" 
                                       accept="image/jpeg,image/jpg,image/png" 
                                       onchange="previewGambar(this)">
                                <div class="file-upload-label" id="labelFoto">
                                    <i class="fas fa-cloud-upload-alt mr-2"></i>
                                    Klik untuk upload foto profil
                                </div>
                                <div class="file-upload-hint">Format: JPG, PNG • Maksimal: 2MB</div>
                            </label>
                            @error('profile_photo')
                            <small class="text-danger d-block mt-2" style="font-weight: 600;">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </small>
                            @enderror
                        </div>

                        <!-- Nama -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-user mr-2"></i>Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control-modern @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" 
                                   required 
                                   placeholder="Masukkan nama lengkap">
                            @error('name')
                            <small class="text-danger d-block mt-2" style="font-weight: 600;">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </small>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-envelope mr-2"></i>Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control-modern @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" 
                                   required 
                                   placeholder="email@example.com">
                            @error('email')
                            <small class="text-danger d-block mt-2" style="font-weight: 600;">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </small>
                            @enderror
                        </div>

                        <!-- Telepon -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-phone mr-2"></i>No. Telepon
                            </label>
                            <input type="text" 
                                   name="phone" 
                                   class="form-control-modern" 
                                   value="{{ old('phone', $user->phone) }}" 
                                   placeholder="08xxxxxxxxxx">
                            <small class="text-muted" style="font-size: 11px; font-weight: 500; display: block; margin-top: 5px;">
                                <i class="fas fa-info-circle mr-1"></i>Format: 08xxxxxxxxxx
                            </small>
                        </div>

                        <!-- Divider -->
                        <hr class="section-divider-modern">

                        <!-- Password Baru -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-lock mr-2"></i>Password Baru
                            </label>
                            <input type="password" 
                                   name="password" 
                                   class="form-control-modern @error('password') is-invalid @enderror" 
                                   placeholder="Minimal 8 karakter">
                            @error('password')
                            <small class="text-danger d-block mt-2" style="font-weight: 600;">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </small>
                            @enderror
                            <small class="text-muted" style="font-size: 11px; font-weight: 500; display: block; margin-top: 5px;">
                                <i class="fas fa-shield-alt mr-1"></i>Kosongkan jika tidak ingin mengubah password
                            </small>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-lock mr-2"></i>Konfirmasi Password Baru
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="form-control-modern" 
                                   placeholder="Ulangi password baru">
                            <small class="text-muted" style="font-size: 11px; font-weight: 500; display: block; margin-top: 5px;">
                                <i class="fas fa-check-double mr-1"></i>Harus sama dengan password baru
                            </small>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-save-modern">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function previewGambar(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB
        
        // Validasi ukuran file
        if (file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'File Terlalu Besar!',
                text: 'Ukuran file maksimal 2MB',
                confirmButtonColor: '#ef4444'
            });
            input.value = '';
            return;
        }
        
        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Format Tidak Didukung!',
                text: 'Gunakan format JPG atau PNG',
                confirmButtonColor: '#ef4444'
            });
            input.value = '';
            return;
        }
        
        // Preview gambar
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('previewFoto');
            const inisial = document.getElementById('avatarInisial');
            
            preview.src = e.target.result;
            preview.style.display = 'inline-block';
            if (inisial) {
                inisial.style.display = 'none';
            }
            
            // Update label dengan nama file
            document.getElementById('labelFoto').innerHTML = 
                '<i class="fas fa-check-circle mr-2"></i>' + file.name;
        };
        reader.readAsDataURL(file);
    }
}

// Auto-hide alert after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-modern');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});
</script>
@endpush
