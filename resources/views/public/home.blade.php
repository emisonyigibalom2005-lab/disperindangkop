@extends('public.layouts.app')
@section('title','Beranda - DISPERINDAGKOP Tolikara')

@section('content')

{{-- ═══════════════════════════════════════════════
     CUSTOM STYLES — hanya untuk halaman beranda
════════════════════════════════════════════════ --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

/* ── FONT & BASE ────────────────────────────────── */
body {
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    font-size: 15px;           /* ← lebih besar untuk mata */
    line-height: 1.8;
    color: #1e293b;
}

/* ── HERO ──────────────────────────────────────── */
.hero {
    min-height: 620px;
    padding: 130px 0 90px;
    position: relative;
}
.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(245,166,35,.12);
    border: 1px solid rgba(245,166,35,.35);
    color: var(--accent);
    font-size: 12px;           /* ← lebih besar */
    font-weight: 700;
    letter-spacing: 1.8px;
    text-transform: uppercase;
    padding: 7px 18px;
    border-radius: 100px;
    margin-bottom: 22px;
}
.hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: 3.4rem;
    font-weight: 800;
    line-height: 1.15;
    color: #fff;
    margin-bottom: 18px;
}
.hero h1 em { font-style: italic; color: var(--accent); }
.hero-desc {
    font-size: 1.1rem;         /* ← lebih besar */
    color: rgba(255,255,255,.80); /* ← lebih terang */
    line-height: 1.85;
    margin-bottom: 38px;
    max-width: 490px;
}
.btn-hero-primary {
    background: var(--accent);
    color: #1a1a1a !important;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 14.5px;         /* ← lebih besar */
    padding: 15px 32px;
    border-radius: 8px;
    border: none;
    letter-spacing: .2px;
    transition: all .25s;
    box-shadow: 0 4px 20px rgba(245,166,35,.38);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.btn-hero-primary:hover {
    background: #ffb800;
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(245,166,35,.48);
}
.btn-hero-secondary {
    background: rgba(255,255,255,.08);
    color: rgba(255,255,255,.95) !important; /* ← lebih terang */
    border: 1.5px solid rgba(255,255,255,.35);
    padding: 15px 32px;
    border-radius: 8px;
    font-size: 14.5px;
    font-weight: 600;
    transition: all .25s;
    margin-left: 12px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.btn-hero-secondary:hover {
    background: rgba(255,255,255,.18);
    border-color: rgba(255,255,255,.55);
}

/* Hero info card kanan */
.hero-info-card {
    background: rgba(255,255,255,.08);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,.16);
    border-radius: 24px;
    padding: 36px 30px;
}
.hero-info-card .card-logo {
    width: 72px; height: 72px;
    background: linear-gradient(135deg, var(--accent), #ffb800);
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 18px;
    box-shadow: 0 8px 24px rgba(245,166,35,.4);
}
.hero-info-card .card-logo i { font-size: 30px; color: #1a1a1a; }
.hero-info-card h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.18rem;
    color: #fff;
    margin-bottom: 22px;
    line-height: 1.55;
}
.hero-stat-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1px;
    background: rgba(255,255,255,.12);
    border-radius: 14px;
    overflow: hidden;
}
.hero-stat-cell {
    background: rgba(255,255,255,.07);
    padding: 18px 10px;
    text-align: center;
}
.hero-stat-cell strong {
    display: block;
    font-size: 2rem;           /* ← lebih besar */
    font-weight: 800;
    color: var(--accent);
    line-height: 1;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.hero-stat-cell span {
    font-size: 11px;           /* ← lebih besar */
    color: rgba(255,255,255,.65); /* ← lebih terang */
    margin-top: 6px;
    display: block;
    font-weight: 500;
}

/* ── STATS BAR ─────────────────────────────────── */
.stats-bar {
    background: #fff;
    padding: 0;
    border-top: 4px solid var(--accent);
    box-shadow: 0 6px 30px rgba(0,0,0,.08);
}
.stat-item {
    padding: 30px 16px;
    text-align: center;
    border-right: 1px solid #f0f2f7;
    transition: background .2s;
}
.stat-item:last-child { border-right: none; }
.stat-item:hover { background: #fafbff; }
.stat-item i { font-size: 1.6rem; color: var(--accent); margin-bottom: 8px; display: block; }
.stat-item .stat-num {
    font-size: 2.1rem;         /* ← lebih besar */
    font-weight: 800;
    color: var(--primary);
    display: block;
    line-height: 1;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.stat-item .stat-label {
    font-size: 12.5px;         /* ← lebih besar */
    color: #667;
    margin-top: 7px;
    font-weight: 600;
    letter-spacing: .3px;
}

/* ── SECTION GENERIC ───────────────────────────── */
.section { padding: 88px 0; }
.section-alt { background: #f5f7fc; }

.section-title { text-align: center; margin-bottom: 58px; }
.section-title .eyebrow {
    display: inline-block;
    font-size: 11px;           /* ← lebih besar */
    font-weight: 700;
    letter-spacing: 2.2px;
    text-transform: uppercase;
    color: var(--accent);
    margin-bottom: 10px;
}
.section-title h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.4rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 14px;
    line-height: 1.22;
}
.section-title p {
    color: #5a6475;            /* ← lebih gelap = lebih mudah dibaca */
    font-size: 1rem;
    max-width: 480px;
    margin: 0 auto;
    line-height: 1.8;
}
.title-line {
    width: 48px; height: 3px;
    background: linear-gradient(90deg, var(--accent), #ffb800);
    margin: 16px auto 0;
    border-radius: 2px;
}

/* ── LAYANAN ───────────────────────────────────── */
.layanan-item {
    padding: 36px 30px;
    border-radius: 18px;
    background: #fff;
    border: 1.5px solid #eaecf3;
    transition: all .3s cubic-bezier(.22,.61,.36,1);
    height: 100%;
    position: relative;
    overflow: hidden;
}
.layanan-item::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform .35s;
}
.layanan-item:hover {
    transform: translateY(-7px);
    box-shadow: 0 20px 50px rgba(26,58,110,.1);
    border-color: transparent;
}
.layanan-item:hover::after { transform: scaleX(1); }
.layanan-item .icon-wrap {
    width: 60px; height: 60px;
    border-radius: 15px;
    margin: 0 0 22px;
    display: flex; align-items: center; justify-content: center;
}
.layanan-item h5 {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 12px;
    font-size: 1.1rem;         /* ← lebih besar */
}
.layanan-item p {
    font-size: 14px;           /* ← lebih besar */
    color: #5a6475;            /* ← lebih gelap */
    line-height: 1.8;
    margin: 0;
}

/* ── Koperasi CARD ─────────────────────────────────── */
.card-koperasi {
    border: none;
    border-radius: 18px;
    box-shadow: 0 2px 18px rgba(0,0,0,.07);
    transition: all .32s cubic-bezier(.22,.61,.36,1);
    overflow: hidden;
    height: 100%;
    background: #fff;
    display: flex;
    flex-direction: column;
}
.card-koperasi:hover {
    transform: translateY(-7px);
    box-shadow: 0 20px 50px rgba(26,58,110,.13);
}
.card-koperasi .card-thumb {
    height: 180px;
    background: linear-gradient(135deg, var(--primary) 0%, #2a5aad 100%);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
    position: relative;
}
.card-koperasi .card-thumb::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0; right: 0;
    height: 28px;
    background: #fff;
    clip-path: ellipse(55% 100% at 50% 100%);
}
.card-koperasi .card-thumb i { font-size: 3.5rem; color: rgba(255,255,255,.2); }
.card-koperasi .card-thumb img { width: 100%; height: 100%; object-fit: cover; }
.card-koperasi .card-body { padding: 20px 24px 26px; display: flex; flex-direction: column; flex: 1; }

.badge-kat {
    display: inline-block;
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: .8px;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 100px;
    margin-bottom: 10px;
    align-self: flex-start;
}
.badge-kat.mikro    { background: #eff6ff; color: #1d4ed8; }
.badge-kat.kecil    { background: #f0fdf4; color: #15803d; }
.badge-kat.menengah { background: #fffbeb; color: #a16207; }

.card-koperasi h5 {
    font-family: 'Playfair Display', serif;
    font-size: 1.07rem;        /* ← lebih besar */
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 7px;
    line-height: 1.4;
}
.card-koperasi .koperasi-distrik {
    font-size: 12.5px;         /* ← lebih besar */
    color: #7a8394;
    margin-bottom: 7px;
}
.card-koperasi .koperasi-jenis {
    font-size: 13.5px;         /* ← lebih besar */
    color: #4a5568;            /* ← lebih gelap */
    flex: 1;
    margin-bottom: 18px;
    line-height: 1.6;
}
.btn-detail {
    display: block;
    width: 100%;
    padding: 11px;
    border-radius: 9px;
    border: 1.5px solid var(--primary);
    color: var(--primary) !important;
    font-size: 13.5px;         /* ← lebih besar */
    font-weight: 700;
    background: transparent;
    transition: all .22s;
    text-align: center;
    text-decoration: none;
    letter-spacing: .2px;
}
.btn-detail:hover {
    background: var(--primary);
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(26,58,110,.25);
}

/* ── BERITA CARD ───────────────────────────────── */
.card-news {
    border: none;
    border-radius: 18px;
    box-shadow: 0 2px 18px rgba(0,0,0,.07);
    transition: all .32s cubic-bezier(.22,.61,.36,1);
    overflow: hidden;
    height: 100%;
    background: #fff;
    display: flex;
    flex-direction: column;
}
.card-news:hover { transform: translateY(-7px); box-shadow: 0 20px 50px rgba(26,58,110,.13); }
.card-news .news-thumb {
    height: 210px;
    overflow: hidden;
    position: relative;
    flex-shrink: 0;
}
.card-news .news-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .45s; }
.card-news:hover .news-thumb img { transform: scale(1.06); }
.card-news .news-thumb .thumb-placeholder {
    height: 100%;
    background: linear-gradient(135deg, var(--primary), #2a5aad);
    display: flex; align-items: center; justify-content: center;
}
.card-news .news-body {
    padding: 22px 24px 26px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.card-news .news-meta {
    font-size: 12px;           /* ← lebih besar */
    color: #7a8a9a;
    margin-bottom: 10px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card-news .news-meta .dot { width: 3px; height: 3px; background: #ccd2de; border-radius: 50%; }
.card-news h5 {
    font-family: 'Playfair Display', serif;
    font-size: 1.06rem;        /* ← lebih besar */
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 9px;
    line-height: 1.5;
}
.card-news p {
    font-size: 13.5px;         /* ← lebih besar */
    color: #4a5568;            /* ← lebih gelap */
    line-height: 1.75;
    flex: 1;
    margin-bottom: 18px;
}
.btn-baca {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--primary);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    letter-spacing: .2px;
    transition: gap .2s, color .2s;
}
.btn-baca i { font-size: 10px; }
.btn-baca:hover { color: var(--accent); gap: 12px; text-decoration: none; }

/* ── GALERI ────────────────────────────────────── */
.galeri-item { border-radius: 14px; overflow: hidden; position: relative; height: 215px; cursor: pointer; }
.galeri-item img { width: 100%; height: 100%; object-fit: cover; transition: transform .45s; }
.galeri-item:hover img { transform: scale(1.08); }
.galeri-item .overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(26,58,110,.88) 0%, rgba(26,58,110,.1) 55%, transparent 100%);
    opacity: 0;
    transition: opacity .35s;
    display: flex;
    align-items: flex-end;
    padding: 18px;
    color: #fff;
    font-size: 13.5px;         /* ← lebih besar */
    font-weight: 600;
    line-height: 1.45;
}
.galeri-item:hover .overlay { opacity: 1; }

/* ── Kontak ───────────────────────────────────────── */
.kontak-item { border-radius: 12px; border: 1.5px solid #e0e6f0; overflow: hidden; margin-bottom: 12px; }
.kontak-question {
    padding: 18px 24px;        /* ← lebih lega */
    cursor: pointer;
    font-weight: 600;
    color: var(--primary);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
    font-size: 14.5px;         /* ← lebih besar */
    transition: background .2s;
    gap: 16px;
    line-height: 1.6;
}
.kontak-question:hover { background: #f7f9ff; }
.kontak-icon { flex-shrink: 0; font-size: 12px; transition: transform .3s; }
.kontak-answer {
    padding: 18px 24px;        /* ← lebih lega */
    background: #f7f9ff;
    border-top: 1.5px solid #e0e6f0;
    font-size: 14px;           /* ← lebih besar */
    color: #4a5568;            /* ← lebih gelap */
    line-height: 1.85;
    display: none;
}
.kontak-answer.show { display: block; }
.kontak-item.open .kontak-icon { transform: rotate(180deg); }

/* ── CTA — NAVY ────────────────────────────────── */
.cta-wrap {
    background: linear-gradient(135deg, #0d2240 0%, #1a3a6e 100%); /* ← navy bukan merah */
    padding: 92px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.cta-wrap::before,
.cta-wrap::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,.04);
}
.cta-wrap::before { width: 360px; height: 360px; top: -100px; right: -80px; }
.cta-wrap::after  { width: 260px; height: 260px; bottom: -80px; left: -50px; }
.cta-wrap .inner { position: relative; z-index: 1; }
.cta-wrap h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.55rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 18px;
    line-height: 1.22;
}
.cta-wrap p {
    color: rgba(255,255,255,.82); /* ← lebih terang */
    font-size: 1.08rem;          /* ← lebih besar */
    margin-bottom: 40px;
    max-width: 520px;
    margin-left: auto; margin-right: auto;
    line-height: 1.8;
}
.btn-cta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 48px;
    background: var(--accent);
    color: #1a1a1a !important;
    border-radius: 9px;
    font-weight: 700;
    font-size: 15px;
    text-decoration: none;
    transition: all .25s;
    box-shadow: 0 6px 28px rgba(245,166,35,.45);
}
.btn-cta:hover { background: #ffb800; transform: translateY(-2px); text-decoration: none; }

/* ── BUTTON UTAMA ──────────────────────────────── */
.btn-main {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 38px;
    background: var(--primary);
    color: #fff !important;
    border-radius: 9px;
    font-weight: 700;
    font-size: 14.5px;         /* ← lebih besar */
    text-decoration: none;
    transition: all .25s;
    box-shadow: 0 4px 18px rgba(26,58,110,.25);
    letter-spacing: .2px;
}
.btn-main:hover { background: #15306a; transform: translateY(-2px); box-shadow: 0 8px 28px rgba(26,58,110,.32); text-decoration: none; }

/* ── RESPONSIVE ────────────────────────────────── */
@media(max-width:992px){ .hero h1 { font-size: 2.4rem; } }
@media(max-width:768px){
    .hero { padding: 90px 0 64px; min-height: auto; }
    .hero h1 { font-size: 2rem; }
    .hero-desc { max-width: 100%; }
    .section { padding: 64px 0; }
    .section-title h2 { font-size: 1.8rem; }
    .cta-wrap h2 { font-size: 1.85rem; }
    .btn-hero-secondary { margin-left: 0; margin-top: 10px; }
    .stat-item { border-right: none; border-bottom: 1px solid #f0f2f7; }
}
</style>

{{-- ═══════════════════════ HERO ═══════════════════════ --}}
<section class="hero">
<div class="container">
<div class="row align-items-center">
    <div class="col-lg-7 mb-5 mb-lg-0">
        <div class="hero-eyebrow">
            <i class="fas fa-star" style="font-size:9px"></i>
            Portal Resmi DISPERINDAGKOP
        </div>
        <h1>Dinas Perindagkop<br>& Koperasi <em>Tolikara</em></h1>
        <p class="hero-desc">Platform digital untuk mendukung pertumbuhan industri, perdagangan, koperasi dan Koperasi di Kabupaten Tolikara, Papua Pegunungan.</p>
        <div style="display:flex;flex-wrap:wrap;gap:4px">
            <a href="{{ route('public.koperasi') }}" class="btn-hero-primary">
                <i class="fas fa-store"></i> Direktori Koperasi
            </a>
            <a href="{{ route('login') }}" class="btn-hero-secondary">
                <i class="fas fa-sign-in-alt"></i> Portal Login
            </a>
        </div>
    </div>
    <div class="col-lg-5 d-none d-lg-block">
        <div class="hero-info-card">
            <div class="card-logo"><i class="fas fa-store"></i></div>
            <h3 class="text-center">Membangun Ekonomi Lokal<br>yang Berdaya Saing</h3>
            <div class="hero-stat-grid">
                <div class="hero-stat-cell">
                    <strong>{{ $stats['total_koperasi'] }}+</strong>
                    <span>Koperasi Aktif</span>
                </div>
                <div class="hero-stat-cell">
                    <strong>{{ $stats['total_distrik'] }}</strong>
                    <span>Distrik</span>
                </div>
                <div class="hero-stat-cell">
                    <strong>{{ $stats['total_bantuan'] }}</strong>
                    <span>Program Bantuan</span>
                </div>
                <div class="hero-stat-cell">
                    <strong>{{ number_format($stats['total_tenaga']) }}</strong>
                    <span>Tenaga Kerja</span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>

{{-- ════════════════════ STATS BAR ════════════════════ --}}
<section class="stats-bar">
<div class="container">
<div class="row">
    <div class="col-6 col-md-3">
        <div class="stat-item">
            <i class="fas fa-store"></i>
            <span class="stat-num">{{ $stats['total_koperasi'] }}</span>
            <div class="stat-label">Koperasi Terverifikasi</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-item">
            <i class="fas fa-hand-holding-usd"></i>
            <span class="stat-num">{{ $stats['total_bantuan'] }}</span>
            <div class="stat-label">Program Bantuan</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-item">
            <i class="fas fa-map-marked-alt"></i>
            <span class="stat-num">{{ $stats['total_distrik'] }}</span>
            <div class="stat-label">Distrik Terjangkau</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-item">
            <i class="fas fa-users"></i>
            <span class="stat-num">{{ number_format($stats['total_tenaga']) }}</span>
            <div class="stat-label">Tenaga Kerja</div>
        </div>
    </div>
</div>
</div>
</section>

{{-- ═════════════════════ LAYANAN ═════════════════════ --}}
<section class="section">
<div class="container">
    <div class="section-title">
        <span class="eyebrow">Apa yang Kami Tawarkan</span>
        <h2>Layanan Kami</h2>
        <p>Berbagai layanan untuk mendukung pertumbuhan Koperasi di Tolikara</p>
        <div class="title-line"></div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="layanan-item">
                <div class="icon-wrap" style="background:#eff6ff">
                    <i class="fas fa-file-alt fa-lg" style="color:#1d4ed8"></i>
                </div>
                <h5>Pendaftaran Koperasi</h5>
                <p>Daftarkan usaha Anda secara online dan dapatkan nomor registrasi resmi dari dinas.</p>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="layanan-item">
                <div class="icon-wrap" style="background:#fff7ed">
                    <i class="fas fa-hand-holding-usd fa-lg" style="color:#ea580c"></i>
                </div>
                <h5>Bantuan Usaha</h5>
                <p>Program bantuan modal, peralatan, dan pelatihan untuk mendukung perkembangan usaha.</p>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="layanan-item">
                <div class="icon-wrap" style="background:#f0fdf4">
                    <i class="fas fa-graduation-cap fa-lg" style="color:#15803d"></i>
                </div>
                <h5>Pelatihan & Pembinaan</h5>
                <p>Pelatihan kewirausahaan, manajemen usaha, dan pemasaran produk lokal.</p>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="layanan-item">
                <div class="icon-wrap" style="background:#fff1f2">
                    <i class="fas fa-certificate fa-lg" style="color:#be123c"></i>
                </div>
                <h5>Sertifikasi Produk</h5>
                <p>Pendampingan proses sertifikasi halal, PIRT, dan izin usaha lainnya.</p>
            </div>
        </div>
    </div>
</div>
</section>

{{-- ══════════════════ Koperasi UNGGULAN ══════════════════ --}}
<section class="section section-alt">
<div class="container">
    <div class="section-title">
        <span class="eyebrow">Pelaku Usaha Terpilih</span>
        <h2>Koperasi Unggulan</h2>
        <p>Pelaku usaha terdaftar dan terverifikasi di Kabupaten Tolikara</p>
        <div class="title-line"></div>
    </div>
    <div class="row">
    @forelse($koperasi_unggulan as $u)
        <div class="col-lg-4 col-md-6 mb-4 d-flex">
            <div class="card-koperasi w-100">
                <div class="card-thumb">
                    @if($u->foto_usaha)
                        <img src="{{ asset('storage/'.$u->foto_usaha) }}" alt="{{ $u->nama_usaha }}">
                    @else
                        <i class="fas fa-store"></i>
                    @endif
                </div>
                <div class="card-body">
                    <span class="badge-kat {{ strtolower($u->kategori) }}">{{ ucfirst($u->kategori) }}</span>
                    <h5>{{ $u->nama_usaha }}</h5>
                    <p class="koperasi-distrik">
                        <i class="fas fa-map-marker-alt mr-1" style="color:var(--secondary)"></i>{{ $u->distrik }}
                    </p>
                    <p class="koperasi-jenis">{{ Str::limit($u->jenis_usaha, 60) }}</p>
                    <a href="{{ route('public.koperasi.detail', $u) }}" class="btn-detail">Lihat Detail</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-store fa-3x mb-3 d-block" style="opacity:.18"></i>
            Belum ada Koperasi terdaftar
        </div>
    @endforelse
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('public.koperasi') }}" class="btn-main">
            <i class="fas fa-arrow-right"></i> Lihat Semua Koperasi
        </a>
    </div>
</div>
</section>

{{-- ══════════════════ BERITA TERBARU ══════════════════ --}}
@if($berita_terbaru->count())
<section class="section">
<div class="container">
    <div class="section-title">
        <span class="eyebrow">Informasi Terkini</span>
        <h2>Berita Terbaru</h2>
        <p>Informasi dan kegiatan terkini dari DISPERINDAGKOP Tolikara</p>
        <div class="title-line"></div>
    </div>
    <div class="row">
    @foreach($berita_terbaru as $b)
        <div class="col-lg-4 col-md-6 mb-4 d-flex">
            <div class="card-news w-100">
                <div class="news-thumb">
                    @if($b->thumbnail)
                        <img src="{{ asset('storage/'.$b->thumbnail) }}" alt="{{ $b->judul }}">
                    @else
                        <div class="thumb-placeholder">
                            <i class="fas fa-newspaper fa-3x" style="color:rgba(255,255,255,.25)"></i>
                        </div>
                    @endif
                </div>
                <div class="news-body">
                    <div class="news-meta">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $b->created_at->format('d M Y') }}
                        <span class="dot"></span>
                        {{ ucfirst($b->kategori ?? 'Umum') }}
                    </div>
                    <h5>{{ Str::limit($b->judul, 65) }}</h5>
                    <p>{{ Str::limit(strip_tags($b->konten), 110) }}</p>
                    <a href="{{ route('public.berita.detail', $b) }}" class="btn-baca">
                        Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('public.berita') }}" class="btn-main">
            <i class="fas fa-newspaper"></i> Lihat Semua Berita
        </a>
    </div>
</div>
</section>
@endif

{{-- ═══════════════════ GALERI KEGIATAN ═══════════════ --}}
@if($galeri->count())
<section class="section section-alt">
<div class="container">
    <div class="section-title">
        <span class="eyebrow">Dokumentasi</span>
        <h2>Galeri Kegiatan</h2>
        <p>Dokumentasi kegiatan dan program DISPERINDAGKOP Tolikara</p>
        <div class="title-line"></div>
    </div>
    <div class="row">
    @foreach($galeri as $g)
        <div class="col-lg-4 col-sm-6 mb-3">
            <div class="galeri-item">
                <img src="{{ asset('storage/'.$g->foto) }}"
                     alt="{{ $g->judul }}"
                     onerror="this.src='https://via.placeholder.com/500x215?text=Galeri'">
                <div class="overlay">{{ $g->judul }}</div>
            </div>
        </div>
    @endforeach
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('public.galeri') }}" class="btn-main">
            <i class="fas fa-images"></i> Lihat Semua Galeri
        </a>
    </div>
</div>
</section>
@endif

{{-- ════════════════════ KONTAK ════════════════════════ --}}
<section class="section section-alt">
<div class="container">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <span style="display:inline-block;font-size:11px;font-weight:700;letter-spacing:2.2px;text-transform:uppercase;color:var(--accent);margin-bottom:12px">Hubungi Kami</span>
            <h2 style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;color:var(--primary);margin-bottom:16px;line-height:1.28">Kami Siap Melayani Anda</h2>
            <div style="width:48px;height:3px;background:linear-gradient(90deg,var(--accent),#ffb800);border-radius:2px;margin:0 auto"></div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-6 mb-4">
            <div style="background:#fff;border-radius:16px;padding:28px 20px;box-shadow:0 2px 16px rgba(0,0,0,.07);text-align:center;height:100%">
                <div style="width:56px;height:56px;background:#eff6ff;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                    <i class="fas fa-map-marker-alt fa-lg" style="color:#1a3a6e"></i>
                </div>
                <h6 style="font-weight:700;color:#1a3a6e;margin-bottom:8px">Alamat</h6>
                <p style="font-size:13.5px;color:#4a5568;margin:0">Jl. Raya Karubaga, Kab. Tolikara, Papua Pegunungan</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div style="background:#fff;border-radius:16px;padding:28px 20px;box-shadow:0 2px 16px rgba(0,0,0,.07);text-align:center;height:100%">
                <div style="width:56px;height:56px;background:#fff7ed;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                    <i class="fas fa-phone fa-lg" style="color:#ea580c"></i>
                </div>
                <h6 style="font-weight:700;color:#1a3a6e;margin-bottom:8px">Telepon</h6>
                <p style="font-size:13.5px;color:#4a5568;margin:0">(0964) 123456</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div style="background:#fff;border-radius:16px;padding:28px 20px;box-shadow:0 2px 16px rgba(0,0,0,.07);text-align:center;height:100%">
                <div style="width:56px;height:56px;background:#f0fdf4;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                    <i class="fas fa-envelope fa-lg" style="color:#15803d"></i>
                </div>
                <h6 style="font-weight:700;color:#1a3a6e;margin-bottom:8px">Email</h6>
                <p style="font-size:13.5px;color:#4a5568;margin:0">info@disperindagkop.tolikara.go.id</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div style="background:#fff;border-radius:16px;padding:28px 20px;box-shadow:0 2px 16px rgba(0,0,0,.07);text-align:center;height:100%">
                <div style="width:56px;height:56px;background:#fff1f2;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                    <i class="fas fa-clock fa-lg" style="color:#be123c"></i>
                </div>
                <h6 style="font-weight:700;color:#1a3a6e;margin-bottom:8px">Jam Kerja</h6>
                <p style="font-size:13.5px;color:#4a5568;margin:0">Senin–Jumat<br>08.00–16.00 WIT</p>
            </div>
        </div>
    </div>
    <div class="text-center mt-3">
        <a href="{{ route('public.kontak') }}" class="btn-main">
            <i class="fas fa-envelope mr-2"></i> Kirim Pesan ke Kami
        </a>
    </div>
</div>
</section>

{{-- ══════════════════════ CTA ═════════════════════════ --}}
<section class="cta-wrap">
<div class="container inner">
    <h2>Daftarkan Usaha Anda<br>Sekarang</h2>
    <p>Bergabunglah bersama pelaku Koperasi Tolikara yang telah terdata dan mendapat akses bantuan langsung dari pemerintah.</p>
    <a href="{{ route('daftar-anggota') }}" class="btn-cta">
        <i class="fas fa-user-plus"></i> Daftar Sekarang
    </a>
</div>
</section>

{{-- ═══════════ LOKASI & PETA ═══════════ --}}
<section class="section section-alt">
    <div class="container">
        <div class="section-title">
            <span class="eyebrow">Lokasi Kami</span>
            <h2>Temukan Kantor DISPERINDAGKOP</h2>
            <p>Jl. Raya Karubaga, Kabupaten Tolikara, Papua Pegunungan</p>
        </div>
    </div>
</section>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<section style="padding:30px 0;background:#1a2942;">
<div id="peta-disperindagkop" style="height:420px;width:100%;z-index:1"></div>
</section>
{{-- ════════════ SCRIPTS — hanya 1x @push ════════════ --}}
@push('scripts')
<script>
// ── Kontak accordion ────────────────────────────────
document.querySelectorAll('.kontak-question').forEach(function(q){
    q.addEventListener('click', function(){
        var item   = this.closest('.kontak-item');
        var ans    = this.nextElementSibling;
        var isOpen = ans.classList.contains('show');
        document.querySelectorAll('.kontak-answer').forEach(function(a){ a.classList.remove('show'); });
        document.querySelectorAll('.kontak-item').forEach(function(i){ i.classList.remove('open'); });
        if(!isOpen){ ans.classList.add('show'); item.classList.add('open'); }
    });
});

// ── Jam real-time di topbar ───────────────────────
var _hari = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
var _bln  = ["Januari","Februari","Maret","April","Mei","Juni",
             "Juli","Agustus","September","Oktober","November","Desember"];
function updateJam(){
    var d  = new Date();
    var el = document.getElementById("jamTopbar");
    if(!el) return;
    el.innerHTML = _hari[d.getDay()] + ", "
                 + String(d.getDate()).padStart(2,"0") + " "
                 + _bln[d.getMonth()] + " "
                 + d.getFullYear()
                 + " &nbsp;|&nbsp; "
                 + String(d.getHours()).padStart(2,"0") + ":"
                 + String(d.getMinutes()).padStart(2,"0") + ":"
                 + String(d.getSeconds()).padStart(2,"0") + " WIT";
}
updateJam();
setInterval(updateJam, 1000);
</script>

{{-- ═══════════ PETA LEAFLET ═══════════ --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Koordinat Kantor DISPERINDAGKOP Tolikara (Karubaga)
    var kantorLat = -3.610, kantorLng = 138.462;

    var map = L.map('peta-disperindagkop').setView([kantorLat, kantorLng], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 18
    }).addTo(map);

    // Icon kantor (biru)
    var iconKantor = L.divIcon({
        className: '',
        html: '<div style="background:#1a3a6e;color:#fff;padding:6px 10px;border-radius:8px;font-size:11px;font-weight:700;white-space:nowrap;box-shadow:0 2px 8px rgba(0,0,0,0.3)"><i class="fas fa-building"></i> DISPERINDAGKOP</div>',
        iconAnchor: [75, 30]
    });

    // Icon Koperasi (kuning)
    var iconKoperasi = L.divIcon({
        className: '',
        html: '<div style="background:#f5a623;color:#fff;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;box-shadow:0 2px 6px rgba(0,0,0,0.3);border:2px solid #fff"><i class="fas fa-store"></i></div>',
        iconAnchor: [14, 14]
    });

    // Marker Kantor
    L.marker([kantorLat, kantorLng], {icon: iconKantor})
        .addTo(map)
        .bindPopup('<b>Kantor DISPERINDAGKOP</b><br>Jl. Raya Karubaga, Kab. Tolikara<br>Papua Pegunungan<br><small>Senin-Jumat: 08.00-16.00 WIT</small>');

    // Sebaran Koperasi per distrik Tolikara
    var distrikKoperasi = [
        {nama:'Bokondini',      lat:-3.648, lng:138.672, jml:5},
        {nama:'Karubaga',       lat:-3.610, lng:138.462, jml:4},
        {nama:'Kembu',          lat:-3.580, lng:138.520, jml:2},
        {nama:'Bewani',         lat:-3.700, lng:138.395, jml:1},
        {nama:'Kanggime',       lat:-3.540, lng:138.340, jml:1},
        {nama:'Bokoneri',       lat:-3.670, lng:138.500, jml:1},
        {nama:'Nunggawi',       lat:-3.625, lng:138.580, jml:1},
        {nama:'Goyage',         lat:-3.590, lng:138.430, jml:1},
    ];

    distrikKoperasi.forEach(function(d) {
        var marker = L.marker([d.lat, d.lng], {icon: iconKoperasi}).addTo(map);
        marker.bindPopup(
            '<b>Distrik ' + d.nama + '</b><br>' +
            '<i class="fas fa-store mr-1"></i><b>' + d.jml + ' Koperasi</b> terdaftar<br>' +
            '<small>Kabupaten Tolikara</small>'
        );
    });

    // Legenda
    var legenda = L.control({position: 'bottomright'});
    legenda.onAdd = function() {
        var div = L.DomUtil.create('div');
        div.style.cssText = 'background:#fff;padding:10px 14px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.2);font-size:12px;line-height:1.8';
        div.innerHTML = '<b style="color:#1a3a6e">Keterangan</b><br>' +
            '<span style="background:#1a3a6e;color:#fff;padding:2px 7px;border-radius:4px;font-size:11px">&#9632;</span> Kantor DISPERINDAGKOP<br>' +
            '<span style="background:#f5a623;color:#fff;padding:2px 7px;border-radius:4px;font-size:11px">&#9632;</span> Sebaran Koperasi';
        return div;
    };
    legenda.addTo(map);
});
</script>
@endpush

@endsection