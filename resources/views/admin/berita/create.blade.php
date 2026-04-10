@extends('layouts.app')

@section('title', 'Tulis Berita')
@section('page-title', 'Tulis Berita Baru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.berita.index') }}">Daftar Berita</a></li>
    <li class="breadcrumb-item active">Tulis Berita</li>
@endsection

@push('styles')
<style>
    .form-card {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
    .thumbnail-preview {
        position: relative;
        width: 100%;
        max-width: 300px;
        height: 200px;
        border: 2px dashed #ced4da;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .thumbnail-preview:hover {
        border-color: #007bff;
        background: #e7f3ff;
    }
    .thumbnail-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .thumbnail-placeholder {
        text-align: center;
        color: #6c757d;
    }
    .thumbnail-placeholder i {
        font-size: 48px;
        margin-bottom: 10px;
        opacity: 0.5;
    }
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    .upload-btn {
        border: 2px solid #007bff;
        color: #007bff;
        background-color: white;
        padding: 8px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .upload-btn:hover {
        background-color: #007bff;
        color: white;
    }
    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        cursor: pointer;
    }
    textarea {
        min-height: 300px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Info Box -->
        <div class="info-box">
            <div class="d-flex align-items-center">
                <i class="fas fa-pen-fancy fa-2x text-primary mr-3"></i>
                <div>
                    <h6 class="mb-1 font-weight-bold">Tips Menulis Berita</h6>
                    <p class="mb-0 small">Tulis judul yang menarik, gunakan bahasa yang mudah dipahami, dan sertakan gambar yang relevan untuk meningkatkan engagement pembaca.</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card form-card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-newspaper mr-2"></i>Form Tulis Berita
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

                <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" id="formBerita">
                    @csrf

                    <!-- Section 1: Informasi Berita -->
                    <div class="form-section">
                        <h5>
                            <i class="fas fa-info-circle mr-2"></i>Informasi Berita
                        </h5>
                        
                        <div class="mb-3">
                            <label class="form-label">
                                Judul Berita <span class="required-badge">*</span>
                            </label>
                            <input type="text" 
                                   name="judul"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   value="{{ old('judul') }}" 
                                   placeholder="Masukkan judul berita yang menarik..."
                                   required>
                            @error('judul') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Judul yang baik: singkat, jelas, dan menarik perhatian
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Kategori <span class="required-badge">*</span>
                                </label>
                                <select name="kategori" 
                                        class="form-control @error('kategori') is-invalid @enderror" 
                                        required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="umum" @selected(old('kategori') == 'umum')>
                                        📰 Berita Umum
                                    </option>
                                    <option value="program" @selected(old('kategori') == 'program')>
                                        🎯 Program & Kegiatan
                                    </option>
                                    <option value="pengumuman" @selected(old('kategori') == 'pengumuman')>
                                        📢 Pengumuman
                                    </option>
                                    <option value="prestasi" @selected(old('kategori') == 'prestasi')>
                                        🏆 Prestasi
                                    </option>
                                    <option value="lainnya" @selected(old('kategori') == 'lainnya')>
                                        📋 Lainnya
                                    </option>
                                </select>
                                @error('kategori') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Status Publikasi <span class="required-badge">*</span>
                                </label>
                                <select name="status" 
                                        class="form-control @error('status') is-invalid @enderror" 
                                        required>
                                    <option value="draft" @selected(old('status') == 'draft')>
                                        📝 Draft (Belum Dipublikasi)
                                    </option>
                                    <option value="publish" @selected(old('status') == 'publish')>
                                        ✅ Publish (Tampilkan ke Publik)
                                    </option>
                                </select>
                                @error('status') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Thumbnail -->
                    <div class="form-section" style="border-left-color: #28a745;">
                        <h5 style="color: #28a745;">
                            <i class="fas fa-image mr-2"></i>Gambar Thumbnail
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="thumbnail-preview" id="thumbnailPreview">
                                    <div class="thumbnail-placeholder">
                                        <i class="fas fa-cloud-upload-alt d-block"></i>
                                        <p class="mb-0">Belum ada gambar</p>
                                        <small class="text-muted">Klik tombol untuk upload</small>
                                    </div>
                                    <img id="preview" src="#" alt="Preview" class="d-none">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="upload-btn-wrapper mb-3">
                                    <button class="upload-btn" type="button">
                                        <i class="fas fa-upload mr-2"></i>Pilih Gambar
                                    </button>
                                    <input type="file" 
                                           name="thumbnail" 
                                           accept="image/jpeg,image/jpg,image/png"
                                           class="@error('thumbnail') is-invalid @enderror"
                                           onchange="previewImage(this)">
                                </div>
                                @error('thumbnail') 
                                    <div class="text-danger small">{{ $message }}</div> 
                                @enderror
                                <div class="alert alert-info small mb-0">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    <strong>Ketentuan:</strong>
                                    <ul class="mb-0 mt-2 pl-3">
                                        <li>Format: JPG, JPEG, PNG</li>
                                        <li>Ukuran maksimal: 2MB</li>
                                        <li>Resolusi disarankan: 1200x630px</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Konten -->
                    <div class="form-section" style="border-left-color: #ffc107;">
                        <h5 style="color: #ffc107;">
                            <i class="fas fa-file-alt mr-2"></i>Konten Berita
                        </h5>
                        
                        <div class="mb-3">
                            <label class="form-label">
                                Isi Berita <span class="required-badge">*</span>
                            </label>
                            <textarea name="konten" 
                                      id="konten"
                                      class="form-control @error('konten') is-invalid @enderror"
                                      placeholder="Tulis konten berita di sini..."
                                      required>{{ old('konten') }}</textarea>
                            @error('konten') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-keyboard mr-1"></i>
                                Gunakan paragraf yang jelas dan mudah dibaca
                            </small>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary btn-action">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <div>
                            <button type="reset" class="btn btn-outline-secondary btn-action mr-2">
                                <i class="fas fa-redo mr-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary btn-action">
                                <i class="fas fa-save mr-2"></i>Simpan Berita
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
function previewImage(input) {
    const preview = document.getElementById('preview');
    const placeholder = document.querySelector('.thumbnail-placeholder');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB
        
        // Validasi ukuran
        if (file.size > maxSize) {
            alert('Ukuran file terlalu besar! Maksimal 2MB');
            input.value = '';
            return;
        }
        
        // Validasi tipe
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung! Gunakan JPG atau PNG');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            if (placeholder) {
                placeholder.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    }
}

$(document).ready(function() {
    // Konfirmasi sebelum reset
    $('button[type="reset"]').on('click', function(e) {
        if (!confirm('Yakin ingin mereset semua input?')) {
            e.preventDefault();
        } else {
            // Reset preview
            $('#preview').addClass('d-none');
            $('.thumbnail-placeholder').show();
        }
    });
    
    // Validasi form
    $('#formBerita').on('submit', function(e) {
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
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
        }
    });
});
</script>
@endpush