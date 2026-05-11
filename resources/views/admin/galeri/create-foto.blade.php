@extends('layouts.app')
@section('title', 'Tambah Foto Galeri')

@push('styles')
<style>
    .upload-area {
        border: 3px dashed #e5e7eb;
        border-radius: 16px;
        padding: 80px 40px;
        text-align: center;
        transition: all 0.3s;
        background: linear-gradient(135deg, #f9fafb, #ffffff);
        cursor: pointer;
        position: relative;
    }
    .upload-area:hover {
        border-color: #1a3a6e;
        background: linear-gradient(135deg, #f0f4ff, #e0e7ff);
        transform: translateY(-2px);
    }
    .upload-area.dragover {
        border-color: #1a3a6e;
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        transform: scale(1.02);
    }
    .upload-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 25px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 56px;
        color: white;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .preview-container {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        margin-top: 30px;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }
    .preview-image {
        width: 100%;
        max-height: 600px;
        object-fit: contain;
        background: #f3f4f6;
    }
    .preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .preview-container:hover .preview-overlay {
        opacity: 1;
    }
    .btn-remove-preview {
        background: white;
        color: #ef4444;
        border: none;
        border-radius: 50%;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .btn-remove-preview:hover {
        transform: scale(1.15) rotate(90deg);
        background: #ef4444;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card page-header-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between text-white">
                        <div class="d-flex align-items-center">
                            <div class="page-header-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                            <div>
                                <h3 class="page-header-title">📷 Tambah Foto Galeri</h3>
                                <p class="page-header-subtitle">Upload foto kegiatan dan dokumentasi program</p>
                            </div>
                        </div>
                        <div class="text-right d-none d-md-block">
                            <a href="{{ route('admin.galeri.index') }}" class="btn btn-light btn-modern">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Error Alert --}}
    @if ($errors->any())
    <div class="alert alert-danger-modern alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            <strong>Terdapat kesalahan:</strong>
            <ul class="mb-0 pl-3 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" id="formFoto">
        @csrf
        <input type="hidden" name="tipe" value="foto">
        
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="content-card-title">
                            <i class="fas fa-cloud-upload-alt"></i> Upload Foto
                        </h5>
                    </div>
                    
                    <div class="content-card-body">
                        {{-- Upload Area --}}
                        <div class="upload-area" onclick="document.getElementById('fotoInput').click()">
                            <div class="upload-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                            <h4 class="font-weight-bold mb-3" style="color:#1a3a6e">Klik untuk upload foto</h4>
                            <p class="text-muted mb-3" style="font-size:16px">atau drag & drop file di sini</p>
                            <div style="display:inline-block;background:#e0e7ff;padding:10px 20px;border-radius:10px;margin-top:10px">
                                <small class="font-weight-bold" style="color:#4338ca">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Format: JPG, PNG, GIF • Maksimal: 2MB
                                </small>
                            </div>
                        </div>
                        <input type="file" 
                               name="foto" 
                               id="fotoInput"
                               accept="image/*"
                               class="d-none"
                               onchange="previewImage(this)"
                               required>
                        
                        {{-- Preview --}}
                        <div id="previewContainer" class="preview-container d-none">
                            <img id="preview" src="#" class="preview-image">
                            <div class="preview-overlay">
                                <button type="button" class="btn-remove-preview" onclick="removePreview()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Info Box --}}
                        <div class="alert alert-info-modern mt-4">
                            <i class="fas fa-lightbulb"></i>
                            <div>
                                <strong>Tips Upload Foto:</strong>
                                <ul class="mb-0 pl-3 mt-2" style="font-size:14px">
                                    <li>Judul foto akan otomatis diambil dari nama file</li>
                                    <li>Gunakan foto dengan resolusi tinggi untuk hasil terbaik</li>
                                    <li>Pastikan foto tidak blur dan pencahayaan cukup</li>
                                    <li>Ukuran file maksimal 2MB</li>
                                    <li>Format yang didukung: JPG, JPEG, PNG, GIF</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Optional Fields --}}
                <div class="content-card mt-4">
                    <div class="content-card-header">
                        <h5 class="content-card-title">
                            <i class="fas fa-cog"></i> Pengaturan Tambahan (Opsional)
                        </h5>
                    </div>
                    
                    <div class="content-card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold" style="color:#1a3a6e">
                                        <i class="fas fa-tag mr-2"></i>Kategori
                                    </label>
                                    <select name="kategori" class="form-control form-control-lg" style="border-radius:10px;border:2px solid #e0e7ff">
                                        <option value="kegiatan">Kegiatan</option>
                                        <option value="pelatihan">Pelatihan</option>
                                        <option value="dokumentasi">Dokumentasi</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold" style="color:#1a3a6e">
                                        <i class="fas fa-align-left mr-2"></i>Deskripsi
                                    </label>
                                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tambahkan deskripsi singkat..." style="border-radius:10px;border:2px solid #e0e7ff"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="content-card mt-4">
                    <div class="content-card-body" style="background:#f8f9ff;border-top:1px solid #eef;display:flex;justify-content:space-between;align-items:center;padding:25px 30px">
                        <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary btn-modern">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success-modern" id="btnSubmit">
                            <i class="fas fa-save"></i> Simpan Foto
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Preview image
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('previewContainer');
    
    if (input.files && input.files[0]) {
        if (input.files[0].size > 2097152) {
            alert('Ukuran file terlalu besar! Maksimal 2MB');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove preview
function removePreview() {
    document.getElementById('preview').src = '#';
    document.getElementById('previewContainer').classList.add('d-none');
    document.getElementById('fotoInput').value = '';
}

// Drag and drop
const uploadArea = document.querySelector('.upload-area');

uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('dragover');
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('dragover');
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        const fotoInput = document.getElementById('fotoInput');
        fotoInput.files = files;
        previewImage(fotoInput);
    }
});

// Form validation
document.getElementById('formFoto').addEventListener('submit', function(e) {
    const fotoInput = document.getElementById('fotoInput');
    
    if (!fotoInput.files || fotoInput.files.length === 0) {
        e.preventDefault();
        alert('Silakan pilih foto terlebih dahulu!');
        return false;
    }
    
    const btnSubmit = document.getElementById('btnSubmit');
    btnSubmit.disabled = true;
    btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
});
</script>
@endpush
