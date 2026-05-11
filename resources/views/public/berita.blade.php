@extends('public.layouts.app')
@section('title','Berita - DISPERINDAGKOP Tolikara')

@push('styles')
<style>
/* Hero Section */
.berita-hero {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 50%, #3d6ab0 100%);
    padding: 80px 0 60px;
    color: #fff;
    position: relative;
    overflow: hidden;
}

.berita-hero::before {
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

/* Search Box */
.search-box-modern {
    background: white;
    border-radius: 50px;
    padding: 8px 20px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 40px;
}

.search-box-modern input {
    border: none;
    outline: none;
    flex: 1;
    font-size: 15px;
    padding: 8px 0;
}

.search-box-modern button {
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    border: none;
    color: white;
    padding: 10px 30px;
    border-radius: 50px;
    font-weight: 700;
    transition: all 0.3s;
}

.search-box-modern button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(26,58,110,0.4);
}

/* Card Berita */
.card-berita {
    background: white;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 6px 25px rgba(0,0,0,0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(0,0,0,0.05);
}

.card-berita:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(26,58,110,0.18);
}

.card-berita-image {
    position: relative;
    height: 280px;
    overflow: hidden;
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
}

.card-berita-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.card-berita:hover .card-berita-image img {
    transform: scale(1.12);
}

.card-berita-badge {
    position: absolute;
    top: 18px;
    right: 18px;
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(26,58,110,0.4);
    z-index: 2;
}

.card-berita-body {
    padding: 28px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

@media (max-width: 768px) {
    .card-berita {
        flex-direction: column !important;
    }
    
    .card-berita-image {
        width: 100% !important;
        height: 220px !important;
        min-height: auto !important;
    }
    
    .card-berita-body {
        width: 100% !important;
    }
}

.card-berita-meta {
    display: flex;
    align-items: center;
    gap: 18px;
    margin-bottom: 16px;
    font-size: 14px;
    color: #6b7280;
    font-weight: 600;
}

.card-berita-meta i {
    color: #1a3a6e;
}

.card-berita-title {
    font-size: 20px;
    font-weight: 800;
    color: #1a3a6e;
    line-height: 1.5;
    margin-bottom: 14px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-berita-excerpt {
    color: #6b7280;
    font-size: 15px;
    line-height: 1.75;
    margin-bottom: 22px;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.btn-read-more {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    color: white;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s;
    align-self: flex-start;
    box-shadow: 0 4px 15px rgba(26,58,110,0.25);
}

.btn-read-more:hover {
    transform: translateX(6px);
    box-shadow: 0 8px 25px rgba(26,58,110,0.35);
    color: white;
    text-decoration: none;
}

.btn-read-more i {
    transition: transform 0.3s;
}

.btn-read-more:hover i {
    transform: translateX(4px);
}

/* Sidebar */
.sidebar-card {
    background: white;
    border-radius: 18px;
    box-shadow: 0 6px 25px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 30px;
    border: 1px solid rgba(0,0,0,0.05);
    position: sticky;
    top: 20px;
}

.sidebar-card-header {
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    color: white;
    padding: 22px 28px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.sidebar-card-header h6 {
    margin: 0;
    font-size: 18px;
    font-weight: 800;
}

.sidebar-card-header i {
    font-size: 20px;
    color: #f5a623;
}

.berita-populer-item {
    display: flex;
    gap: 18px;
    padding: 24px 28px;
    border-bottom: 1px solid #f3f4f6;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s;
}

.berita-populer-item:last-child {
    border-bottom: none;
}

.berita-populer-item:hover {
    background: #f8f9fa;
    transform: translateX(6px);
}

.berita-populer-thumb {
    width: 100px;
    height: 75px;
    border-radius: 14px;
    overflow: hidden;
    flex-shrink: 0;
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.berita-populer-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.berita-populer-content h6 {
    font-size: 15px;
    font-weight: 700;
    color: #1a3a6e;
    line-height: 1.5;
    margin-bottom: 10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.berita-populer-date {
    font-size: 13px;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
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

/* Pagination */
.pagination {
    gap: 8px;
}

.pagination .page-link {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    color: #1a3a6e;
    font-weight: 700;
    padding: 10px 18px;
    transition: all 0.3s;
}

.pagination .page-link:hover {
    background: linear-gradient(135deg, #f0f4ff, #e0e7ff);
    border-color: #1a3a6e;
    transform: translateY(-2px);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    border-color: #1a3a6e;
    box-shadow: 0 4px 15px rgba(26,58,110,0.3);
}

@media (max-width: 768px) {
    .card-berita-image {
        height: 220px;
    }
    
    .card-berita-title {
        font-size: 18px;
    }
    
    .card-berita-body {
        padding: 22px;
    }
    
    .berita-populer-thumb {
        width: 85px;
        height: 65px;
    }
    
    .sidebar-card {
        position: relative;
        top: 0;
    }
}
</style>
@endpush

@section('content')
{{-- Hero Section --}}
<div class="berita-hero">
    <div class="container" style="position:relative;z-index:1">
        <div class="text-center">
            <div style="width:80px;height:80px;background:linear-gradient(135deg,rgba(245,166,35,0.25),rgba(251,191,36,0.25));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;backdrop-filter:blur(15px);border:3px solid rgba(255,255,255,0.2)">
                <i class="fas fa-newspaper fa-2x" style="color:#f5a623"></i>
            </div>
            <h1 style="font-size:2.5rem;font-weight:900;margin-bottom:15px;text-shadow:0 4px 20px rgba(0,0,0,0.3)">
                📰 Berita & Informasi
            </h1>
            <p style="font-size:1.15rem;opacity:0.95;max-width:700px;margin:0 auto 10px;line-height:1.7">
                Dapatkan informasi terkini seputar program, kegiatan, dan perkembangan Dinas Perindustrian, Perdagangan, dan Koperasi Kabupaten Tolikara
            </p>
            <p style="font-size:1rem;opacity:0.85;max-width:650px;margin:0 auto;font-weight:500">
                Tetap update dengan berita terbaru untuk mendukung kemajuan industri, perdagangan, dan koperasi di Tolikara
            </p>
        </div>
    </div>
</div>

{{-- Main Content --}}
<section style="padding:90px 0;background:linear-gradient(to bottom, #f8f9fa, #ffffff)">
    <div class="container-fluid" style="max-width:1400px;padding-left:35px;padding-right:35px">
        <div class="row">
            {{-- Main Content - 2 Berita Terbaru --}}
            <div class="col-lg-8 mb-4">
                {{-- Search Box --}}
                <form method="GET" action="{{ route('public.berita') }}">
                    <div class="search-box-modern">
                        <i class="fas fa-search" style="color:#6b7280;font-size:18px"></i>
                        <input type="text" name="search" placeholder="Cari berita..." value="{{ request('search') }}">
                        <button type="submit">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                    </div>
                </form>

                {{-- Section Title --}}
                <div style="margin-bottom:35px">
                    <h3 style="font-size:28px;font-weight:900;color:#1a3a6e;margin-bottom:10px;display:flex;align-items:center;gap:12px">
                        <i class="fas fa-newspaper" style="color:#f5a623"></i>
                        <span>Berita Terbaru</span>
                    </h3>
                    <p style="color:#6b7280;font-size:15px;margin:0">Informasi dan berita terkini dari DISPERINDAGKOP Tolikara</p>
                </div>

                {{-- 2 Berita Terbaru --}}
                <div class="row" style="margin-left:-18px;margin-right:-18px">
                    @php
                        $beritaTerbaru = $berita->take(2);
                    @endphp
                    
                    @forelse($beritaTerbaru as $b)
                    <div class="col-md-6 mb-5" style="padding-left:18px;padding-right:18px">
                        <div class="card-berita">
                            <div class="card-berita-image">
                                @if($b->thumbnail)
                                <img src="{{ asset('storage/'.$b->thumbnail) }}" alt="{{ $b->judul }}">
                                @else
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center">
                                    <i class="fas fa-newspaper fa-3x" style="color:#9ca3af"></i>
                                </div>
                                @endif
                                <div class="card-berita-badge">
                                    <i class="fas fa-star mr-1"></i>Terbaru
                                </div>
                            </div>
                            <div class="card-berita-body">
                                <div class="card-berita-meta">
                                    <span>
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ $b->created_at->format('d M Y') }}
                                    </span>
                                    <span>
                                        <i class="fas fa-eye mr-1"></i>
                                        {{ $b->views ?? 0 }} views
                                    </span>
                                </div>
                                <h5 class="card-berita-title">{{ $b->judul }}</h5>
                                <p class="card-berita-excerpt">{{ Str::limit(strip_tags($b->konten), 150) }}</p>
                                <a href="{{ route('public.berita.detail', $b) }}" class="btn-read-more">
                                    <span>Baca Selengkapnya</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <h5 style="font-weight:700;color:#374151;margin-bottom:10px">Belum Ada Berita</h5>
                            <p style="color:#6b7280;margin:0">Saat ini belum ada berita yang tersedia</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Berita Populer --}}
                <div class="sidebar-card">
                    <div class="sidebar-card-header">
                        <i class="fas fa-fire"></i>
                        <h6>Berita Populer</h6>
                    </div>
                    <div>
                        @forelse($populer as $p)
                        <a href="{{ route('public.berita.detail', $p) }}" class="berita-populer-item">
                            <div class="berita-populer-thumb">
                                @if($p->thumbnail)
                                <img src="{{ asset('storage/'.$p->thumbnail) }}" alt="{{ $p->judul }}">
                                @else
                                <i class="fas fa-newspaper" style="color:#9ca3af;font-size:24px"></i>
                                @endif
                            </div>
                            <div class="berita-populer-content">
                                <h6>{{ Str::limit($p->judul, 60) }}</h6>
                                <div class="berita-populer-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>{{ $p->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            <small>Belum ada berita populer</small>
                        </div>
                        @endforelse
                    </div>
                    
                    {{-- Tombol Lihat Semua di Bawah Berita Populer --}}
                    @if($berita->count() > 2)
                    <div style="padding:20px;background:linear-gradient(to top,#f8f9fa,#fff);border-top:2px solid #e5e7eb">
                        <a href="{{ route('public.berita') }}" 
                           style="display:flex;align-items:center;justify-content:center;gap:10px;background:linear-gradient(135deg,#1a3a6e,#2d5aa0);color:#fff;padding:14px 24px;border-radius:12px;font-weight:800;text-decoration:none;font-size:14px;box-shadow:0 4px 15px rgba(26,58,110,0.3);transition:all 0.3s ease"
                           onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 6px 20px rgba(26,58,110,0.4)'"
                           onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 15px rgba(26,58,110,0.3)'">
                            <i class="fas fa-th-large"></i>
                            <span>Lihat Semua Berita ({{ $berita->total() }})</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
