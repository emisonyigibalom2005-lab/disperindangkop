@extends('layouts.app')
@section('title', 'Edit Video Galeri')

@push('styles')
<style>
    .video-input-card {
        background: linear-gradient(135deg, #f9fafb, #ffffff);
        border: 3px solid #e5e7eb;
        border-radius: 16px;
        padding: 40px;
        transition: all 0.3s;
    }
    .video-input-card:hover {
        border-color: #1a3a6e;
        background: linear-gradient(135deg, #f0f4ff, #e0e7ff);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(26, 58, 110, 0.15);
    }
    .video-icon-header {
        width: 100px;
        height: 100px;
        margin: 0 auto 25px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: white;
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .video-preview-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        margin-top: 25px;
        background: #000;
    }
    .video-preview-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
    .form-control-modern {
        border-radius: 12px;
        border: 2px solid #e0e7ff;
        padding: 14px 18px;
        font-size: 15px;
        transition: all 0.3s;
    }
    .form-control-modern:focus {
        border-color: #1a3a6e;
        box-shadow: 0 0 0 3px rgba(26, 58, 110, 0.1);
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
                                <i class="fas fa-edit"></i>
                            </div>
                            <div>
                                <h3 class="page-header-title">✏️ Edit Video Galeri</h3>
                                <p class="page-header-subtitle">Perbarui video dokumentasi kegiatan</p>
                            </div>
                        </div>
                        <div class="text-right d-none d-md-block">
                            <a href="{{ route('admin.galeri.index') }}?tipe=video" class="btn btn-light btn-modern">
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

    <form action="{{ route('admin.galeri.update', $galeri) }}" method="POST" id="formVideo">
        @csrf
        @method('PUT')
        <input type="hidden" name="tipe" value="video">
        
        <div class="row justify-content-center">
            <div class="col-lg-9">
                {{-- Current Video --}}
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h5 class="content-card-title">
                            <i class="fas fa-video"></i> Video Saat Ini
                        </h5>
                    </div>
                    
                    <div class="content-card-body">
                        <div class="video-preview-container">
                            @php
                                $videoId = '';
                                if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $galeri->video_url, $matches)) {
                                    $videoId = $matches[1];
                                } elseif (preg_match('/youtu\.be\/([^?]+)/', $galeri->video_url, $matches)) {
                                    $videoId = $matches[1];
                                }
                            @endphp
                            @if($videoId)
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" allowfullscreen></iframe>
                            @endif
                        </div>
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-link mr-1"></i>
                                URL: <a href="{{ $galeri->video_url }}" target="_blank">{{ $galeri->video_url }}</a>
                            </small>
                        </div>
                    </div>
                </div>

                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="content-card-title">
                            <i class="fab fa-youtube"></i> Informasi Video
                        </h5>
                    </div>
                    
                    <div class="content-card-body">
                        {{-- Judul --}}
                        <div class="form-group mb-4">
                            <label class="font-weight-bold" style="color:#1a3a6e;font-size:15px">
                                <i class="fas fa-heading mr-2"></i>Judul Video <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="judul" 
                                   id="judulVideo"
                                   class="form-control form-control-modern" 
                                   placeholder="Contoh: Tutorial Pengelolaan Koperasi"
                                   value="{{ old('judul', $galeri->judul) }}"
                                   required>
                        </div>

                        {{-- URL Video --}}
                        <div class="form-group mb-4">
                            <label class="font-weight-bold" style="color:#1a3a6e;font-size:15px">
                                <i class="fab fa-youtube mr-2"></i>URL Video YouTube <span class="text-danger">*</span>
                            </label>
                            <input type="url" 
                                   name="video_url" 
                                   id="videoUrlInput"
                                   class="form-control form-control-modern" 
                                   placeholder="https://www.youtube.com/watch?v=..."
                                   value="{{ old('video_url', $galeri->video_url) }}"
                                   onchange="previewVideo(this.value)"
                                   required>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-info-circle mr-1"></i>
                                Salin URL lengkap dari address bar YouTube (contoh: https://www.youtube.com/watch?v=xxxxx)
                            </small>
                        </div>

                        {{-- Video Preview --}}
                        <div id="videoPreviewContainer" class="d-none">
                            <div class="video-preview-container">
                                <iframe id="videoPreview" 
                                        src="" 
                                        allowfullscreen></iframe>
                            </div>
                            <div class="text-center mt-3">
                                <span class="badge badge-success-modern" style="font-size:13px;padding:8px 16px">
                                    <i class="fas fa-check-circle mr-1"></i>Video baru berhasil dimuat
                                </span>
                            </div>
                        </div>

                        {{-- Info Box --}}
                        <div class="alert alert-info-modern mt-4">
                            <i class="fas fa-lightbulb"></i>
                            <div>
                                <strong>Cara Mendapatkan URL Video YouTube:</strong>
                                <ol class="mb-0 pl-3 mt-2" style="font-size:14px">
                                    <li>Buka video di YouTube</li>
                                    <li>Klik tombol "Share" atau "Bagikan"</li>
                                    <li>Salin URL yang muncul</li>
                                    <li>Paste URL di form di atas</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Optional Fields --}}
                <div class="content-card mt-4">
                    <div class="content-card-header">
                        <h5 class="content-card-title">
                            <i class="fas fa-cog"></i> Pengaturan Tambahan
                        </h5>
                    </div>
                    
                    <div class="content-card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold" style="color:#1a3a6e">
                                        <i class="fas fa-tag mr-2"></i>Kategori
                                    </label>
                                    <select name="kategori" class="form-control form-control-modern">
                                        <option value="kegiatan" {{ $galeri->kategori == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                        <option value="pelatihan" {{ $galeri->kategori == 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                        <option value="tutorial" {{ $galeri->kategori == 'tutorial' ? 'selected' : '' }}>Tutorial</option>
                                        <option value="dokumentasi" {{ $galeri->kategori == 'dokumentasi' ? 'selected' : '' }}>Dokumentasi</option>
                                        <option value="lainnya" {{ $galeri->kategori == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold" style="color:#1a3a6e">
                                        <i class="fas fa-align-left mr-2"></i>Deskripsi
                                    </label>
                                    <textarea name="deskripsi" class="form-control form-control-modern" rows="3" placeholder="Tambahkan deskripsi singkat...">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="content-card mt-4">
                    <div class="content-card-body" style="background:#f8f9ff;border-top:1px solid #eef;display:flex;justify-content:space-between;align-items:center;padding:25px 30px">
                        <a href="{{ route('admin.galeri.index') }}?tipe=video" class="btn btn-secondary btn-modern">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success-modern" id="btnSubmit">
                            <i class="fas fa-save"></i> Update Video
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
// Preview video
function previewVideo(url) {
    const previewContainer = document.getElementById('videoPreviewContainer');
    const preview = document.getElementById('videoPreview');
    
    let videoId = '';
    if (url.match(/youtube\.com\/watch\?v=([^&]+)/)) {
        videoId = url.match(/youtube\.com\/watch\?v=([^&]+)/)[1];
    } else if (url.match(/youtu\.be\/([^?]+)/)) {
        videoId = url.match(/youtu\.be\/([^?]+)/)[1];
    }
    
    if (videoId) {
        preview.src = 'https://www.youtube.com/embed/' + videoId;
        previewContainer.classList.remove('d-none');
    } else {
        previewContainer.classList.add('d-none');
        if (url) {
            alert('URL YouTube tidak valid! Pastikan URL dalam format:\nhttps://www.youtube.com/watch?v=xxxxx\natau\nhttps://youtu.be/xxxxx');
        }
    }
}

// Form validation
document.getElementById('formVideo').addEventListener('submit', function(e) {
    const videoUrl = document.getElementById('videoUrlInput').value;
    const judul = document.getElementById('judulVideo').value;
    
    if (!judul) {
        e.preventDefault();
        alert('Judul video harus diisi!');
        return false;
    }
    
    if (!videoUrl) {
        e.preventDefault();
        alert('URL video YouTube harus diisi!');
        return false;
    }
    
    // Validate YouTube URL
    let videoId = '';
    if (videoUrl.match(/youtube\.com\/watch\?v=([^&]+)/)) {
        videoId = videoUrl.match(/youtube\.com\/watch\?v=([^&]+)/)[1];
    } else if (videoUrl.match(/youtu\.be\/([^?]+)/)) {
        videoId = videoUrl.match(/youtu\.be\/([^?]+)/)[1];
    }
    
    if (!videoId) {
        e.preventDefault();
        alert('URL YouTube tidak valid! Pastikan URL dalam format:\nhttps://www.youtube.com/watch?v=xxxxx\natau\nhttps://youtu.be/xxxxx');
        return false;
    }
    
    const btnSubmit = document.getElementById('btnSubmit');
    btnSubmit.disabled = true;
    btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
});
</script>
@endpush
