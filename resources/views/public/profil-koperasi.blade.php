@extends('public.layouts.app')
@section('title', 'Profil Koperasi - DISPERINDAGKOP Tolikara')

@push('styles')
<style>
    .hero-koperasi {
        background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 100%);
        padding: 60px 0 50px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .hero-koperasi::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: rgba(245, 166, 35, 0.1);
        top: -150px;
        right: -100px;
        animation: float 6s ease-in-out infinite;
    }
    
    .hero-koperasi::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
        bottom: -100px;
        left: -80px;
        animation: float 8s ease-in-out infinite reverse;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    .hero-content {
        position: relative;
        z-index: 1;
    }
    
    .hero-badge {
        display: inline-block;
        padding: 6px 18px;
        background: rgba(245, 166, 35, 0.2);
        border-radius: 50px;
        color: #f5a623;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        margin-bottom: 16px;
        border: 2px solid rgba(245, 166, 35, 0.3);
    }
    
    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 14px;
        line-height: 1.2;
    }
    
    .hero-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        max-width: 650px;
        margin: 0 auto 30px;
        line-height: 1.6;
    }
    
    .stats-section {
        background: white;
        margin-top: -50px;
        position: relative;
        z-index: 10;
        border-radius: 16px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    
    .stat-box {
        text-align: center;
        padding: 24px 16px;
        border-radius: 14px;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    
    .stat-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #1a3a6e, #f5a623);
        transform: scaleX(0);
        transition: transform 0.3s;
    }
    
    .stat-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(26, 58, 110, 0.15);
    }
    
    .stat-box:hover::before {
        transform: scaleX(1);
    }
    
    .stat-icon {
        width: 56px;
        height: 56px;
        margin: 0 auto 16px;
        background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 18px rgba(26, 58, 110, 0.2);
    }
    
    .stat-icon i {
        font-size: 1.6rem;
        color: #f5a623;
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: #1a3a6e;
        margin-bottom: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .stat-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }
    
    .content-section {
        padding: 60px 0;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 45px;
    }
    
    .section-badge {
        display: inline-block;
        padding: 6px 16px;
        background: #eff6ff;
        border-radius: 50px;
        color: #1a3a6e;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        margin-bottom: 12px;
    }
    
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: #1a3a6e;
        margin-bottom: 12px;
    }
    
    .section-description {
        font-size: 1rem;
        color: #64748b;
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.7;
    }
    
    .info-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 3px 18px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
        transition: all 0.3s;
        border: 2px solid transparent;
        height: 100%;
    }
    
    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 35px rgba(26, 58, 110, 0.12);
        border-color: #f5a623;
    }
    
    .info-card-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #f5a623, #ffb800);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        box-shadow: 0 6px 18px rgba(245, 166, 35, 0.3);
    }
    
    .info-card-icon i {
        font-size: 1.5rem;
        color: white;
    }
    
    .info-card-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a3a6e;
        margin-bottom: 12px;
    }
    
    .info-card-text {
        color: #5a6475;
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 0;
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 1.75rem;
        }
        
        .hero-subtitle {
            font-size: 0.95rem;
        }
        
        .stats-section {
            padding: 24px 16px;
            margin-top: -35px;
        }
        
        .stat-box {
            margin-bottom: 16px;
        }
        
        .section-title {
            font-size: 1.75rem;
        }
        
        .info-card {
            padding: 24px 18px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-koperasi">
    <div class="container">
        <div class="hero-content text-center">
            <div class="hero-badge">
                <i class="fas fa-handshake mr-2"></i>Koperasi Tolikara
            </div>
            <h1 class="hero-title">
                Profil Koperasi<br>Kabupaten Tolikara
            </h1>
            <p class="hero-subtitle">
                Membangun ekonomi kerakyatan melalui pemberdayaan koperasi yang kuat, mandiri, 
                dan berdaya saing untuk kesejahteraan masyarakat Tolikara
            </p>
        </div>
    </div>
</section>

<!-- Stats Section -->
<div class="container">
    <div class="stats-section">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="stat-box">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">{{ $stats['total_anggota'] }}</div>
                    <div class="stat-label">Total Anggota Terdaftar</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="stat-box">
                    <div class="stat-icon">
                        <i class="fas fa-male"></i>
                    </div>
                    <div class="stat-number">{{ $stats['total_laki'] }}</div>
                    <div class="stat-label">Anggota Laki-Laki</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="stat-box">
                    <div class="stat-icon">
                        <i class="fas fa-female"></i>
                    </div>
                    <div class="stat-number">{{ $stats['total_perempuan'] }}</div>
                    <div class="stat-label">Anggota Perempuan</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-box">
                    <div class="stat-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="stat-number">{{ $stats['total_distrik'] }}</div>
                    <div class="stat-label">Distrik</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<section class="content-section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">
                <i class="fas fa-info-circle mr-2"></i>Tentang Koperasi
            </div>
            <h2 class="section-title">Apa Itu Koperasi?</h2>
            <p class="section-description">
                Koperasi adalah badan usaha yang beranggotakan orang-seorang atau badan hukum koperasi 
                dengan melandaskan kegiatannya berdasarkan prinsip koperasi sekaligus sebagai gerakan ekonomi rakyat 
                yang berdasarkan atas asas kekeluargaan
            </p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="info-card-title">Pengertian Koperasi</h3>
                    <p class="info-card-text">
                        Koperasi berasal dari kata "co" yang berarti bersama dan "operation" yang berarti bekerja. 
                        Jadi koperasi adalah kerja sama. Koperasi merupakan badan usaha yang beranggotakan 
                        orang-orang atau badan hukum yang melandaskan kegiatannya berdasarkan prinsip koperasi 
                        sekaligus sebagai gerakan ekonomi rakyat yang berdasarkan asas kekeluargaan.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-flag"></i>
                    </div>
                    <h3 class="info-card-title">Tujuan Koperasi</h3>
                    <p class="info-card-text">
                        Memajukan kesejahteraan anggota pada khususnya dan masyarakat pada umumnya. 
                        Ikut membangun tatanan perekonomian nasional dalam rangka mewujudkan masyarakat 
                        yang maju, adil, dan makmur berlandaskan Pancasila dan Undang-Undang Dasar 1945. 
                        Meningkatkan kualitas kehidupan manusia dan masyarakat melalui kegiatan ekonomi bersama.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h3 class="info-card-title">Prinsip Koperasi</h3>
                    <p class="info-card-text">
                        Keanggotaan bersifat sukarela dan terbuka. Pengelolaan dilakukan secara demokratis 
                        (satu anggota satu suara). Pembagian Sisa Hasil Usaha (SHU) dilakukan secara adil 
                        sebanding dengan besarnya jasa usaha masing-masing anggota. Pemberian balas jasa 
                        yang terbatas terhadap modal. Kemandirian dalam pengelolaan dan pengembangan usaha.
                    </p>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-4 mb-4">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3 class="info-card-title">Manfaat Koperasi</h3>
                    <p class="info-card-text">
                        Meningkatkan pendapatan dan kesejahteraan anggota. Menyediakan kebutuhan anggota 
                        dengan harga yang lebih terjangkau. Memberikan pinjaman modal usaha dengan bunga rendah. 
                        Menciptakan lapangan kerja bagi masyarakat. Melatih masyarakat untuk berhemat dan 
                        menabung secara teratur. Membangun jiwa kerjasama dan gotong royong.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <h3 class="info-card-title">Jenis-Jenis Koperasi</h3>
                    <p class="info-card-text">
                        Koperasi Konsumsi: menyediakan kebutuhan sehari-hari anggota. 
                        Koperasi Produksi: menghasilkan dan memasarkan barang. 
                        Koperasi Simpan Pinjam: mengelola simpanan dan memberikan pinjaman kepada anggota. 
                        Koperasi Serba Usaha: menjalankan berbagai jenis usaha sekaligus. 
                        Koperasi Jasa: memberikan pelayanan jasa kepada anggota dan masyarakat.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="info-card-title">Peran Koperasi</h3>
                    <p class="info-card-text">
                        Membangun dan mengembangkan potensi ekonomi anggota dan masyarakat. 
                        Berperan aktif dalam upaya mempertinggi kualitas kehidupan manusia dan masyarakat. 
                        Memperkokoh perekonomian rakyat sebagai dasar kekuatan dan ketahanan perekonomian nasional. 
                        Menciptakan dan mengembangkan lapangan kerja. Mewujudkan dan mengembangkan perekonomian 
                        nasional yang merupakan usaha bersama berdasarkan asas kekeluargaan dan demokrasi ekonomi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
