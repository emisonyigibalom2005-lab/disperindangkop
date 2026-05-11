@extends('public.layouts.app')
@section('title', 'Galeri Foto - DISPERINDAGKOP Tolikara')

@push('styles')
<style>
/* Hero Section */
.galeri-hero {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 50%, #3d6ab0 100%);
    padding: 65px 0 50px;
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

/* Gallery Grid */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 25px;
    margin-top: 40px;
}

.gallery-item {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    background: #fff;
}

.gallery-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 45px rgba(26,58,110,0.2);
    animation: shake 0.6s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateY(-10px) rotate(0deg); }
    10%, 30%, 50%, 70%, 90% { transform: translateY(-10px) rotate(-2deg); }
    20%, 40%, 60%, 80% { transform: translateY(-10px) rotate(2deg); }
}

.gallery-image {
    width: 100%;
    height: 280px;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.gallery-item:hover .gallery-image {
    transform: scale(1.15) rotate(2deg);
}

.gallery-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.9), rgba(0,0,0,0.5), transparent);
    padding: 25px 20px;
    transform: translateY(0);
    transition: all 0.4s;
}

.gallery-item:hover .gallery-overlay {
    background: linear-gradient(to top, rgba(26,58,110,0.95), rgba(26,58,110,0.7), transparent);
}

.gallery-title {
    color: white;
    font-size: 16px;
    font-weight: 700;
    margin: 0;
    line-height: 1.4;
    text-shadow: 0 2px 8px rgba(0,0,0,0.5);
}

.gallery-date {
    color: rgba(255,255,255,0.85);
    font-size: 13px;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Gallery Items Staggered Animation */
.gallery-item {
    animation: fadeInScale 0.5s ease-out backwards;
}

.gallery-item:nth-child(1) { animation-delay: 0.05s; }
.gallery-item:nth-child(2) { animation-delay: 0.1s; }
.gallery-item:nth-child(3) { animation-delay: 0.15s; }
.gallery-item:nth-child(4) { animation-delay: 0.2s; }
.gallery-item:nth-child(5) { animation-delay: 0.25s; }
.gallery-item:nth-child(6) { animation-delay: 0.3s; }
.gallery-item:nth-child(7) { animation-delay: 0.35s; }
.gallery-item:nth-child(8) { animation-delay: 0.4s; }
.gallery-item:nth-child(9) { animation-delay: 0.45s; }
.gallery-item:nth-child(10) { animation-delay: 0.5s; }
.gallery-item:nth-child(11) { animation-delay: 0.55s; }
.gallery-item:nth-child(12) { animation-delay: 0.6s; }

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
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
}

.empty-icon i {
    font-size: 50px;
    color: #9ca3af;
}

/* Modal */
.modal-modern .modal-content {
    border-radius: 20px;
    border: none;
    overflow: hidden;
}

.modal-modern .modal-header {
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    color: white;
    border: none;
    padding: 20px 30px;
}

.modal-modern .modal-body {
    padding: 0;
}

.modal-modern .modal-body img {
    width: 100%;
    max-height: 80vh;
    object-fit: contain;
    background: #000;
}

@media (max-width: 768px) {
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }
    
    .gallery-image {
        height: 240px;
    }
}
</style>
@endpush

@section('content')
{{-- Hero Section --}}
<div class="galeri-hero">
    <div class="container" style="position:relative;z-index:1">
        <div class="text-center">
            <div style="width:85px;height:85px;background:linear-gradient(135deg,rgba(245,166,35,0.3),rgba(251,191,36,0.25));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 22px;backdrop-filter:blur(15px);border:3px solid rgba(255,255,255,0.25);box-shadow:0 8px 30px rgba(0,0,0,0.2);animation:iconPulse 3s ease-in-out infinite">
                <i class="fas fa-camera" style="font-size:2.2rem;color:#f5a623;animation:iconRotate 4s ease-in-out infinite"></i>
            </div>
            <div style="display:inline-flex;align-items:center;gap:12px;background:rgba(245,166,35,0.2);padding:8px 22px;border-radius:50px;margin-bottom:18px;border:2px solid rgba(245,166,35,0.3);backdrop-filter:blur(10px)">
                <i class="fas fa-images" style="color:#f5a623;font-size:16px"></i>
                <span style="color:#f5a623;font-weight:700;font-size:13px;letter-spacing:1.5px;text-transform:uppercase">Dokumentasi Visual</span>
            </div>
            <h1 style="font-size:2.8rem;font-weight:900;margin-bottom:18px;text-shadow:0 4px 25px rgba(0,0,0,0.3);line-height:1.2;animation:titleSlideIn 0.8s ease-out">
                <span style="display:inline-block;background:linear-gradient(135deg,#fff,#f0f9ff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Galeri Foto</span>
            </h1>
            <p style="font-size:1.05rem;opacity:0.95;max-width:650px;margin:0 auto;line-height:1.7;font-weight:500;animation:subtitleFadeIn 1s ease-out 0.3s backwards">
                Dokumentasi visual kegiatan, program, dan pencapaian<br>
                <strong style="color:#f5a623">DISPERINDAGKOP Kabupaten Tolikara</strong>
            </p>
        </div>
    </div>
</div>

<style>
@keyframes iconPulse {
    0%, 100% { transform: scale(1); box-shadow: 0 8px 30px rgba(0,0,0,0.2); }
    50% { transform: scale(1.08); box-shadow: 0 12px 40px rgba(245,166,35,0.4); }
}

@keyframes iconRotate {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(-8deg); }
    75% { transform: rotate(8deg); }
}

@keyframes titleSlideIn {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes subtitleFadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 0.95;
        transform: translateY(0);
    }
}
</style>

{{-- Main Content --}}
<section style="padding:65px 0;background:linear-gradient(to bottom, #f8f9fa, #ffffff)">
    <div class="container-fluid" style="max-width:1400px;padding-left:35px;padding-right:35px">
        
        {{-- Gallery Grid --}}
        @if($galeri->count() > 0)
        <div class="gallery-grid">
            @foreach($galeri as $item)
            <div class="gallery-item" data-toggle="modal" data-target="#fotoModal{{ $item->id }}">
                <img src="{{ asset('storage/'.$item->foto) }}" 
                     alt="{{ $item->judul }}" 
                     class="gallery-image"
                     loading="lazy">
                <div class="gallery-overlay">
                    <h5 class="gallery-title">{{ $item->judul }}</h5>
                    <div class="gallery-date">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ $item->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Modal --}}
            <div class="modal fade modal-modern" id="fotoModal{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bold">
                                <i class="fas fa-image mr-2"></i>{{ $item->judul }}
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->judul }}">
                        </div>
                        @if($item->deskripsi)
                        <div class="modal-footer" style="background:#f8f9fa;border:none;padding:20px 30px">
                            <div style="width:100%;text-align:left">
                                <strong style="color:#1a3a6e">Deskripsi:</strong>
                                <p class="mb-0 mt-2" style="color:#64748b">{{ $item->deskripsi }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
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
                <i class="fas fa-camera"></i>
            </div>
            <h5 style="font-weight:700;color:#374151;margin-bottom:10px">Belum Ada Foto</h5>
            <p style="color:#6b7280;margin:0">Saat ini belum ada foto yang tersedia di galeri</p>
        </div>
        @endif
    </div>
</section>
@endsection
