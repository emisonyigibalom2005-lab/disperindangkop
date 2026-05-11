@extends('public.layouts.app')
@section('title', $anggota->nama . ' - DISPERINDAGKOP Tolikara')

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 100%);
    padding: 50px 0 35px;
    color: #fff;
}

.profile-hero {
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    border-radius: 20px;
    padding: 40px;
    text-align: center;
    color: #fff;
    box-shadow: 0 10px 40px rgba(26,58,110,0.3);
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
}

.profile-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 4s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.profile-avatar {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    font-size: 56px;
    color: #fff;
    font-weight: 900;
    box-shadow: 0 10px 30px rgba(245,158,11,0.5);
    border: 6px solid rgba(255,255,255,0.3);
    position: relative;
    z-index: 1;
    animation: avatarFloat 3s ease-in-out infinite;
}

@keyframes avatarFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.profile-name {
    font-size: 32px;
    font-weight: 900;
    margin-bottom: 10px;
    position: relative;
    z-index: 1;
}

.profile-id {
    font-size: 16px;
    opacity: 0.9;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
}

.badge-location {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    padding: 10px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 700;
    margin: 5px;
    border: 2px solid rgba(255,255,255,0.3);
    position: relative;
    z-index: 1;
}

.data-section {
    background: #fff;
    border-radius: 20px;
    padding: 35px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

.section-title {
    font-size: 22px;
    font-weight: 900;
    color: #1a3a6e;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.section-title i {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 18px;
}

.data-item {
    background: linear-gradient(135deg, #f8f9fa, #fff);
    border: 2px solid #e5e7eb;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.data-item:hover {
    border-color: #3b82f6;
    box-shadow: 0 6px 20px rgba(59,130,246,0.15);
    transform: translateX(5px);
}

.data-label {
    font-size: 11px;
    color: #6b7280;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.data-label .icon-box {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.data-value {
    font-size: 17px;
    color: #1a3a6e;
    font-weight: 800;
    line-height: 1.4;
}

.sidebar-anggota {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    position: sticky;
    top: 20px;
}

.sidebar-header {
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    padding: 25px 20px;
    color: #fff;
    text-align: center;
}

.sidebar-header i {
    font-size: 36px;
    margin-bottom: 10px;
    display: block;
}

.sidebar-header h5 {
    margin: 0;
    font-weight: 900;
    font-size: 18px;
}

.anggota-scroll {
    max-height: 500px;
    overflow-y: auto;
    padding: 15px;
}

.anggota-scroll::-webkit-scrollbar {
    width: 8px;
}

.anggota-scroll::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.anggota-scroll::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    border-radius: 4px;
}

.anggota-card-mini {
    background: #fff;
    border: 2px solid #e5e7eb;
    border-radius: 15px;
    padding: 15px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none;
    color: inherit;
}

.anggota-card-mini:hover {
    border-color: #3b82f6;
    box-shadow: 0 6px 20px rgba(59,130,246,0.2);
    transform: translateY(-3px);
    text-decoration: none;
}

.mini-avatar {
    position: relative;
    flex-shrink: 0;
}

.mini-avatar-circle {
    width: 65px;
    height: 65px;
    border-radius: 12px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: #fff;
    font-weight: 900;
    box-shadow: 0 4px 15px rgba(59,130,246,0.4);
}

.mini-number {
    position: absolute;
    top: -8px;
    left: -8px;
    width: 28px;
    height: 28px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 900;
    font-size: 12px;
    box-shadow: 0 3px 10px rgba(245,158,11,0.5);
    border: 3px solid #fff;
}

.mini-info {
    flex: 1;
    min-width: 0;
}

.mini-name {
    font-weight: 900;
    color: #1a3a6e;
    font-size: 15px;
    margin-bottom: 6px;
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.mini-usaha {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.mini-usaha i {
    color: #f59e0b;
    font-size: 11px;
}

.mini-location {
    font-size: 11px;
    color: #9ca3af;
    display: flex;
    align-items: center;
    gap: 6px;
}

.mini-location i {
    color: #10b981;
    font-size: 10px;
}

.sidebar-footer {
    padding: 20px;
    text-align: center;
    background: linear-gradient(to top, #f8f9fa, #fff);
    border-top: 2px solid #e5e7eb;
}

.btn-view-all {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    color: #fff;
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 800;
    text-decoration: none;
    font-size: 14px;
    box-shadow: 0 4px 15px rgba(26,58,110,0.3);
    transition: all 0.3s ease;
}

.btn-view-all:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(26,58,110,0.4);
    color: #fff;
    text-decoration: none;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    color: #fff;
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 800;
    text-decoration: none;
    font-size: 14px;
    box-shadow: 0 4px 15px rgba(26,58,110,0.3);
    transition: all 0.3s ease;
    margin-bottom: 25px;
}

.btn-back:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(26,58,110,0.4);
    color: #fff;
    text-decoration: none;
}

.fade-in {
    animation: fadeIn 0.6s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.slide-in-left {
    animation: slideInLeft 0.6s ease-out;
}

@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1; transform: translateX(0); }
}

.slide-in-right {
    animation: slideInRight 0.6s ease-out;
}

@keyframes slideInRight {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container">
        <h1><i class="fas fa-user-circle mr-3"></i>Detail Anggota Koperasi</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background:transparent;padding:0;margin-top:10px">
                <li class="breadcrumb-item"><a href="{{ route('public.home') }}" style="color:rgba(255,255,255,0.9)">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('public.koperasi') }}" style="color:rgba(255,255,255,0.9)">Direktori Koperasi</a></li>
                <li class="breadcrumb-item active" style="color:#fff">{{ $anggota->nama }}</li>
            </ol>
        </nav>
    </div>
</div>

<section class="section" style="padding:40px 0 60px">
<div class="container">
    <a href="{{ route('public.koperasi') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Direktori</span>
    </a>
    
    <div class="row">
        {{-- Kolom Kiri: Detail Anggota --}}
        <div class="col-lg-8">
            {{-- Profile Hero --}}
            <div class="profile-hero fade-in">
                <div class="profile-avatar">
                    {{ strtoupper(substr($anggota->nama, 0, 1)) }}
                </div>
                <h2 class="profile-name">{{ $anggota->nama }}</h2>
                <p class="profile-id">{{ $anggota->no_anggota }}</p>
                <div>
                    <span class="badge-location">
                        <i class="fas fa-map-marked-alt"></i>
                        <span>{{ $anggota->distrik }}</span>
                    </span>
                    @if($anggota->desa && $anggota->desa != '-')
                    <span class="badge-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $anggota->desa }}</span>
                    </span>
                    @endif
                    <span class="badge-location">
                        <i class="fas fa-check-circle"></i>
                        <span>Terverifikasi</span>
                    </span>
                </div>
            </div>
            
            {{-- Data Usaha --}}
            <div class="data-section slide-in-left">
                <div class="section-title">
                    <i class="fas fa-store"></i>
                    <span>Informasi Usaha</span>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="data-item">
                            <div class="data-label">
                                <div class="icon-box" style="background:#fef3c7">
                                    <i class="fas fa-store" style="color:#d97706"></i>
                                </div>
                                <span>Nama Usaha</span>
                            </div>
                            <div class="data-value">{{ $anggota->nama_usaha }}</div>
                        </div>
                    </div>
                    
                    @if($anggota->bidang_usaha)
                    <div class="col-md-6">
                        <div class="data-item">
                            <div class="data-label">
                                <div class="icon-box" style="background:#dbeafe">
                                    <i class="fas fa-briefcase" style="color:#1e40af"></i>
                                </div>
                                <span>Bidang Usaha</span>
                            </div>
                            <div class="data-value">{{ $anggota->bidang_usaha }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($anggota->lama_berdiri_usaha)
                    <div class="col-md-6">
                        <div class="data-item">
                            <div class="data-label">
                                <div class="icon-box" style="background:#d1fae5">
                                    <i class="fas fa-calendar-alt" style="color:#047857"></i>
                                </div>
                                <span>Lama Berdiri</span>
                            </div>
                            <div class="data-value">{{ $anggota->lama_berdiri_usaha }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($anggota->jumlah_karyawan)
                    <div class="col-md-6">
                        <div class="data-item">
                            <div class="data-label">
                                <div class="icon-box" style="background:#ede9fe">
                                    <i class="fas fa-users" style="color:#6d28d9"></i>
                                </div>
                                <span>Jumlah Karyawan</span>
                            </div>
                            <div class="data-value">{{ $anggota->jumlah_karyawan }} orang</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($anggota->alamat_tempat_usaha)
                    <div class="col-md-12">
                        <div class="data-item">
                            <div class="data-label">
                                <div class="icon-box" style="background:#fce7f3">
                                    <i class="fas fa-map-marker-alt" style="color:#be185d"></i>
                                </div>
                                <span>Alamat Tempat Usaha</span>
                            </div>
                            <div class="data-value">{{ $anggota->alamat_tempat_usaha }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($anggota->keterangan_usaha)
                    <div class="col-md-12">
                        <div class="data-item">
                            <div class="data-label">
                                <div class="icon-box" style="background:#e0e7ff">
                                    <i class="fas fa-info-circle" style="color:#3730a3"></i>
                                </div>
                                <span>Keterangan Usaha</span>
                            </div>
                            <div class="data-value">{{ $anggota->keterangan_usaha }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            {{-- Data Lokasi --}}
            <div class="data-section slide-in-left" style="animation-delay: 0.1s">
                <div class="section-title">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>Informasi Lokasi</span>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="data-item">
                            <div class="data-label">
                                <div class="icon-box" style="background:#dbeafe">
                                    <i class="fas fa-map-marked-alt" style="color:#1e40af"></i>
                                </div>
                                <span>Distrik</span>
                            </div>
                            <div class="data-value">{{ $anggota->distrik }}</div>
                        </div>
                    </div>
                    
                    @if($anggota->desa && $anggota->desa != '-')
                    <div class="col-md-6">
                        <div class="data-item">
                            <div class="data-label">
                                <div class="icon-box" style="background:#d1fae5">
                                    <i class="fas fa-map-marker-alt" style="color:#047857"></i>
                                </div>
                                <span>Desa/Kelurahan</span>
                            </div>
                            <div class="data-value">{{ $anggota->desa }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Kolom Kanan: Sidebar Anggota --}}
        <div class="col-lg-4">
            <div class="sidebar-anggota slide-in-right">
                <div class="sidebar-header">
                    <i class="fas fa-users"></i>
                    <h5>Anggota Terdaftar</h5>
                    <small style="opacity:0.9;font-size:13px">Semua anggota koperasi aktif</small>
                </div>
                
                @php
                    $semuaAnggota = \App\Models\Anggota::where('status', 'Aktif')
                        ->where('id', '!=', $anggota->id)
                        ->orderBy('nama', 'asc')
                        ->get();
                    $counter = 1;
                @endphp
                
                @if($semuaAnggota->count() > 0)
                <div class="anggota-scroll">
                    @foreach($semuaAnggota as $a)
                    <a href="{{ route('public.koperasi.detail', $a->id) }}" class="anggota-card-mini">
                        <div class="mini-avatar">
                            <div class="mini-avatar-circle">
                                {{ strtoupper(substr($a->nama, 0, 1)) }}
                            </div>
                            <div class="mini-number">{{ $counter++ }}</div>
                        </div>
                        
                        <div class="mini-info">
                            <div class="mini-name">{{ $a->nama }}</div>
                            <div class="mini-usaha">
                                <i class="fas fa-store"></i>
                                <span style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $a->nama_usaha }}</span>
                            </div>
                            <div class="mini-location">
                                <i class="fas fa-map-marker-alt"></i>
                                <span style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                    {{ $a->distrik }}@if($a->desa && $a->desa != '-'), {{ $a->desa }}@endif
                                </span>
                            </div>
                        </div>
                        
                        <div style="flex-shrink:0">
                            <i class="fas fa-chevron-right" style="color:#cbd5e0;font-size:14px"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
                
                <div class="sidebar-footer">
                    <a href="{{ route('public.koperasi') }}" class="btn-view-all">
                        <i class="fas fa-th-large"></i>
                        <span>Lihat Semua di Direktori</span>
                    </a>
                </div>
                @else
                <div style="padding:60px 30px;text-align:center;color:#9ca3af">
                    <div style="width:90px;height:90px;background:linear-gradient(135deg,#e5e7eb,#d1d5db);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
                        <i class="fas fa-users fa-3x" style="opacity:0.5"></i>
                    </div>
                    <p style="margin:0;font-size:15px;font-weight:700;color:#6b7280">Belum ada anggota terdaftar</p>
                    <p style="margin:8px 0 0 0;font-size:13px">Tidak ada anggota aktif lainnya</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</section>

@push('scripts')
<script>
// Smooth scroll animation
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Add animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.querySelectorAll('.data-item').forEach(item => {
    item.style.opacity = '0';
    item.style.transform = 'translateY(20px)';
    item.style.transition = 'all 0.6s ease';
    observer.observe(item);
});

// Hover effect for data items
document.querySelectorAll('.data-item').forEach(item => {
    item.addEventListener('mouseenter', function() {
        this.style.transform = 'translateX(8px) scale(1.02)';
    });
    
    item.addEventListener('mouseleave', function() {
        this.style.transform = 'translateX(0) scale(1)';
    });
});

// Counter animation for sidebar numbers
const counters = document.querySelectorAll('.mini-number');
counters.forEach((counter, index) => {
    setTimeout(() => {
        counter.style.animation = 'bounceIn 0.6s ease';
    }, index * 50);
});

// Add bounce animation
const style = document.createElement('style');
style.textContent = `
    @keyframes bounceIn {
        0% { transform: scale(0); opacity: 0; }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); opacity: 1; }
    }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection
