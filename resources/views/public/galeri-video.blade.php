@extends('public.layouts.app')
@section('title', 'Galeri Video - DISPERINDAGKOP Tolikara')

@push('styles')
<style>
/* Hero Section */
.galeri-hero {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 50%, #3d6ab0 100%);
    padding: 80px 0 60px;
    color: #fff;
    position: relative;
    overflow: hidden;
}

.galeri-hero::before {
    content: '';
    position: absolute;
    width: 500px;
    height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(245,166,35,0.15), transparent);
    top: -200px;
    right: -150px;
    animation: float 8s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

/* Video Grid */
.video-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.video-item {
    background: white;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    animation: fadeInScale 0.5s ease-out backwards;
}

.video-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 45px rgba(26,58,110,0.25);
    animation: shake 0.6s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateY(-10px) rotate(0deg); }
    10%, 30%, 50%, 70%, 90% { transform: translateY(-10px) rotate(-1.5deg); }
    20%, 40%, 60%, 80% { transform: translateY(-10px) rotate(1.5deg); }
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Video Embed Container */
.video-embed-container {
    position: relative;
    width: 100%;
    padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
    height: 0;
    overflow: hidden;
    background: #000;
}

.video-embed-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

/* Staggered Animation for Video Items */
.video-item:nth-child(1) { animation-delay: 0.05s; }
.video-item:nth-child(2) { animation-delay: 0.1s; }
.video-item:nth-child(3) { animation-delay: 0.15s; }
.video-item:nth-child(4) { animation-delay: 0.2s; }
.video-item:nth-child(5) { animation-delay: 0.25s; }
.video-item:nth-child(6) { animation-delay: 0.3s; }
.video-item:nth-child(7) { animation-delay: 0.35s; }
.video-item:nth-child(8) { animation-delay: 0.4s; }
.video-item:nth-child(9) { animation-delay: 0.45s; }

.video-content {
    padding: 25px;
}

.video-title {
    font-size: 18px;
    font-weight: 700;
    color: #1a3a6e;
    margin-bottom: 12px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.video-meta {
    display: flex;
    align-items: center;
    gap: 15px;
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 12px;
}

.video-meta i {
    color: #1a3a6e;
}

.video-description {
    font-size: 14px;
    color: #64748b;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Modal */
.modal-modern .modal-content {
    border-radius: 20px;
    border: none;
    overflow: hidden;
}

.modal-modern .modal-header {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border: none;
    padding: 20px 30px;
}

.modal-modern .modal-body {
    padding: 0;
}

.video-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
    background: #000;
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 100px 20px;
    background: linear-gradient(135deg, #ffffff, #f8f9fa);
    border-radius: 24px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.08);
}

.empty-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
}

.empty-icon i {
    font-size: 50px;
    color: #1a3a6e;
}

@media (max-width: 768px) {
    .video-grid {
        grid-template-columns: 1fr;
        gap: 25px;
    }
}
</style>
@endpush

@section('content')
{{-- Hero Section --}}
<div class="galeri-hero">
    <div class="container" style="position:relative;z-index:1">
        <div class="text-center">
            <div style="width:90px;height:90px;background:linear-gradient(135deg,rgba(255,255,255,0.2),rgba(255,255,255,0.1));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;backdrop-filter:blur(15px);border:3px solid rgba(255,255,255,0.3)">
                <i class="fas fa-video fa-2x" style="color:white"></i>
            </div>
            <h1 style="font-size:2.5rem;font-weight:900;margin-bottom:15px;text-shadow:0 4px 20px rgba(0,0,0,0.3)">
                🎥 Galeri Video
            </h1>
            <p style="font-size:1.1rem;opacity:0.95;max-width:600px;margin:0 auto">
                Dokumentasi video kegiatan dan program DISPERINDAGKOP Kabupaten Tolikara
            </p>
        </div>
    </div>
</div>

{{-- Main Content --}}
<section style="padding:80px 0;background:linear-gradient(to bottom, #f8f9fa, #ffffff)">
    <div class="container-fluid" style="max-width:1400px;padding-left:35px;padding-right:35px">
        
        {{-- Video Grid --}}
        @if($galeri->count() > 0)
        <div class="video-grid">
            @foreach($galeri as $item)
            <div class="video-item">
                {{-- Video Embed Langsung --}}
                <div class="video-embed-container">
                    @php
                        $videoId = '';
                        if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $item->video_url, $matches)) {
                            $videoId = $matches[1];
                        } elseif (preg_match('/youtu\.be\/([^?]+)/', $item->video_url, $matches)) {
                            $videoId = $matches[1];
                        }
                    @endphp
                    @if($videoId)
                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" 
                                allowfullscreen
                                loading="lazy"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    @endif
                </div>
                
                {{-- Video Info --}}
                <div class="video-content">
                    <h5 class="video-title">{{ $item->judul }}</h5>
                    <div class="video-meta">
                        <span>
                            <i class="fas fa-calendar-alt mr-1"></i>
                            {{ $item->created_at->format('d M Y') }}
                        </span>
                        <span>
                            <i class="fab fa-youtube mr-1"></i>
                            YouTube
                        </span>
                    </div>
                    @if($item->deskripsi)
                    <p class="video-description">{{ $item->deskripsi }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($galeri->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $galeri->links('pagination::bootstrap-4') }}
        </div>
        @endif
        @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-video"></i>
            </div>
            <h5 style="font-weight:700;color:#374151;margin-bottom:10px">Belum Ada Video</h5>
            <p style="color:#6b7280;margin:0">Saat ini belum ada video yang tersedia di galeri</p>
        </div>
        @endif
    </div>
</section>
@endsection
