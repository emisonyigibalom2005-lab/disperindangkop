@extends('layouts.app')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('breadcrumb')
<li class="breadcrumb-item active">Profil</li>
@endsection
@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
<i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif
<div class="row">
<div class="col-md-4 mb-4">
<div class="card shadow-sm text-center">
<div class="card-body pt-4">
<div class="position-relative d-inline-block mb-3">
@if($user->profile_photo)
<img src="{{ asset('storage/'.$user->profile_photo) }}" id="previewFoto" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;border:4px solid #1a3a6e;">
<div id="avatarInisial" class="rounded-circle d-flex align-items-center justify-content-center" style="width:120px;height:120px;background:#1a3a6e;font-size:45px;color:white;font-weight:bold;display:none;">{{ strtoupper(substr($user->name,0,1)) }}</div>
@else
<div id="avatarInisial" class="rounded-circle d-flex align-items-center justify-content-center" style="width:120px;height:120px;background:#1a3a6e;font-size:45px;color:white;font-weight:bold;">{{ strtoupper(substr($user->name,0,1)) }}</div>
<img src="" id="previewFoto" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;display:none;border:4px solid #1a3a6e;">
@endif
<label for="inputFoto" class="btn btn-sm btn-primary rounded-circle position-absolute" style="bottom:0;right:0;width:35px;height:35px;padding:0;cursor:pointer;" title="Ganti Foto">
<i class="fas fa-camera" style="line-height:35px;"></i>
</label>
</div>
<h5 class="font-weight-bold mb-1">{{ $user->name }}</h5>
<span class="badge badge-danger px-3 py-1 mb-2">{{ ucfirst($user->role) }}</span>
<p class="text-muted small mb-1"><i class="fas fa-envelope mr-1"></i>{{ $user->email }}</p>
@if($user->phone)<p class="text-muted small mb-0"><i class="fas fa-phone mr-1"></i>{{ $user->phone }}</p>@endif
<hr>
<p class="text-muted small mb-0"><i class="fas fa-calendar mr-1"></i>Bergabung {{ $user->created_at->format('d M Y') }}</p>
</div>
</div>
</div>
<div class="col-md-8 mb-4">
<div class="card shadow-sm">
<div class="card-header bg-white"><h5 class="mb-0 font-weight-bold"><i class="fas fa-edit mr-2 text-primary"></i>Edit Profil</h5></div>
<div class="card-body">
<form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="form-group">
<label class="font-weight-bold">Foto Profil</label>
<div class="custom-file">
<input type="file" class="custom-file-input d-none" id="inputFoto" name="profile_photo" accept="image/jpeg,image/jpg,image/png" onchange="previewGambar(this)">
<label class="custom-file-label" id="labelFoto" for="inputFoto">Pilih foto (JPG/PNG, maks 2MB)</label>
</div>
<small class="text-muted d-block mt-1">Klik icon kamera pada foto atau pilih file di sini</small>
@error('profile_photo')<small class="text-danger">{{ $message }}</small>@enderror
</div>
<div class="form-group">
<label class="font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="form-group">
<label class="font-weight-bold">Email <span class="text-danger">*</span></label>
<input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="form-group">
<label class="font-weight-bold">No. Telepon</label>
<input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
</div>
<hr>
<p class="font-weight-bold text-muted small mb-2">GANTI PASSWORD</p>
<div class="form-group">
<label>Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter">
@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="form-group">
<label>Konfirmasi Password Baru</label>
<input type="password" name="password_confirmation" class="form-control">
</div>
<button type="submit" class="btn btn-primary btn-block py-2 font-weight-bold"><i class="fas fa-save mr-2"></i>Simpan Perubahan</button>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
@push('scripts')
<script>
function previewGambar(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB
        
        // Validasi ukuran file
        if (file.size > maxSize) {
            alert('Ukuran file terlalu besar! Maksimal 2MB');
            input.value = '';
            return;
        }
        
        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung! Gunakan JPG atau PNG');
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
            document.getElementById('labelFoto').textContent = file.name;
        };
        reader.readAsDataURL(file);
    }
}

// Trigger file input saat klik icon kamera
document.addEventListener('DOMContentLoaded', function() {
    const cameraBtn = document.querySelector('label[for="inputFoto"]');
    if (cameraBtn) {
        cameraBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('inputFoto').click();
        });
    }
});
</script>
@endpush
