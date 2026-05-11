<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | DISPERINDAGKOP</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @stack('styles')

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #2c4a6e;
            --sidebar-hover: #3d5a7e;
            --sidebar-active: #4a6a8f;
            --sidebar-text: #b8c5d6;
            --sidebar-text-active: #ffffff;
            --topbar-height: 60px;
            --primary: #3498db;
            --accent: #ffc107;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f5f7fa;
            color: #2c3e50;
            margin: 0;
        }

        /* ── SIDEBAR ─────────────────────────────────── */
        .sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #2c4a6e 0%, #1e3a5f 100%);
            display: flex;
            flex-direction: column;
            z-index: 1040;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #3d5a7e transparent;
            transition: transform .3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.15);
        }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #3d5a7e; border-radius: 2px; }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-decoration: none;
            background: rgba(0,0,0,0.1);
        }

        .sidebar-brand-icon {
            width: 50px; 
            height: 50px;
            background: white;
            border-radius: 10px;
            display: flex; 
            align-items: center; 
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }

        .sidebar-brand-icon i {
            color: #2c4a6e;
            font-size: 24px;
        }

        .sidebar-brand-text .title {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            letter-spacing: .3px;
            text-transform: uppercase;
        }

        .sidebar-brand-text .subtitle {
            font-size: 11px;
            color: #b8c5d6;
            line-height: 1.3;
        }

        /* Nav */
        .sidebar-nav { padding: 10px 0 20px; flex: 1; }

        .nav-section-label {
            padding: 14px 16px 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #7a92ab;
        }

        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            margin: 2px 12px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 8px;
            transition: all .2s;
            position: relative;
        }

        .nav-item-link:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text-active);
        }

        .nav-item-link.active {
            background: var(--sidebar-active);
            color: var(--sidebar-text-active);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .nav-item-link .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 15px;
            opacity: .9;
            flex-shrink: 0;
        }

        /* Submenu */
        .nav-submenu { 
            background: rgba(0,0,0,0.12);
            padding: 4px 0;
            margin: 0 12px;
            border-radius: 6px;
        }

        .nav-submenu-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px 8px 48px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 400;
            transition: all .2s;
        }

        .nav-submenu-link:hover { 
            color: #fff; 
            background: rgba(255,255,255,0.06);
        }
        
        .nav-submenu-link.active { 
            color: var(--accent); 
            font-weight: 600;
            background: rgba(255, 193, 7, 0.08);
        }

        .nav-submenu-link::before {
            content: '';
            width: 5px; height: 5px;
            background: currentColor;
            border-radius: 50%;
            opacity: .7;
            flex-shrink: 0;
        }

        /* Badge in sidebar */
        .sidebar-badge {
            margin-left: auto;
            background: #ffc107;
            color: #1e3a5f;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 12px;
            line-height: 1.2;
            box-shadow: 0 2px 6px rgba(255, 193, 7, 0.35);
        }

        /* Collapse toggle arrow */
        .nav-arrow {
            margin-left: auto;
            font-size: 10px;
            transition: transform .2s;
            color: var(--sidebar-text);
        }

        .nav-item-link[aria-expanded="true"] .nav-arrow { transform: rotate(90deg); }

        /* ── TOPBAR ──────────────────────────────────── */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: white;
            border-bottom: 1px solid #e8ecf1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 1030;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }

        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .topbar-right { display: flex; align-items: center; gap: 8px; }

        .topbar-toggle {
            background: none; border: none;
            padding: 8px 10px;
            border-radius: 8px;
            color: #7a92ab;
            cursor: pointer;
            font-size: 18px;
            display: none;
        }

        .topbar-toggle:hover { background: #f5f7fa; color: #2c4a6e; }

        .topbar-breadcrumb { font-size: 13px; color: #7a92ab; }
        .topbar-breadcrumb .current { color: #2c4a6e; font-weight: 600; }

        .topbar-btn {
            width: 38px; height: 38px;
            border-radius: 8px;
            border: none;
            background: #f5f7fa;
            color: #7a92ab;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            position: relative;
            text-decoration: none;
            transition: all .2s;
        }

        .topbar-btn:hover { 
            background: #2c4a6e; 
            color: white;
            box-shadow: 0 3px 10px rgba(44, 74, 110, 0.25);
        }

        .topbar-badge {
            position: absolute;
            top: -4px; right: -4px;
            background: #ffc107;
            color: #1e3a5f;
            font-size: 9px;
            font-weight: 700;
            width: 18px; height: 18px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid white;
            box-shadow: 0 2px 6px rgba(255, 193, 7, 0.35);
        }

        /* ── MAIN CONTENT ────────────────────────────── */
        .main-content {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            min-height: 100vh;
            background: #f5f7fa;
        }

        .content-wrapper { padding: 24px; }

        /* ── PAGE HEADER ─────────────────────────────── */
        .page-header {
            background: white;
            border-bottom: 1px solid #e8ecf1;
            padding: 16px 24px;
            margin-bottom: 24px;
            margin-left: -24px;
            margin-right: -24px;
            margin-top: -24px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }

        /* ── ALERTS ──────────────────────────────────── */
        .alert { border: none; border-radius: 10px; font-size: 13.5px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .alert-success { background: #d4edda; color: #155724; border-left: 3px solid #28a745; }
        .alert-danger  { background: #f8d7da; color: #721c24; border-left: 3px solid #dc3545; }
        .alert-warning { background: #fff3cd; color: #856404; border-left: 3px solid #ffc107; }
        .alert-info    { background: #d1ecf1; color: #0c5460; border-left: 3px solid #17a2b8; }

        /* ── CARDS ───────────────────────────────────── */
        .card { 
            border-radius: 12px; 
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        /* ── FOOTER ──────────────────────────────────── */
        .main-footer {
            padding: 16px 24px;
            font-size: 12px;
            color: #7a92ab;
            border-top: 1px solid #e8ecf1;
            margin-top: 20px;
            background: white;
        }

        /* ── MOBILE ──────────────────────────────────── */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .topbar { left: 0; }
            .topbar-toggle { display: flex; }
            .main-content { margin-left: 0; }
            .sidebar-overlay {
                display: none;
                position: fixed; inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1039;
            }
            .sidebar-overlay.show { display: block; }
        }
    </style>
</head>
<body>

{{-- ── SIDEBAR OVERLAY (mobile) ─── --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

{{-- ══════════════════════════════════════════════════════════
     SIDEBAR
══════════════════════════════════════════════════════════ --}}
<aside class="sidebar" id="sidebar">

    {{-- Brand --}}
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <i class="fas fa-building" style="color: #2c4a6e; font-size: 28px;"></i>
        </div>
        <div class="sidebar-brand-text">
            <div class="title">DISPERINDAGKOP</div>
            <div class="subtitle">Kab. Tolikara</div>
        </div>
    </a>

    {{-- Navigation --}}
    <nav class="sidebar-nav">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-th-large"></i></span>
            Dashboard
        </a>

        {{-- MANAJEMEN Koperasi --}}
        <div class="nav-section-label">Manajemen Koperasi</div>

        <a href="#menuKoperasi" class="nav-item-link {{ request()->routeIs('admin.koperasi.*') ? '' : 'collapsed' }}"
           data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('admin.koperasi.*') ? 'true' : 'false' }}">
            <span class="nav-icon"><i class="fas fa-store"></i></span>
            Data Koperasi
            @php $pendingCount = \App\Models\Koperasi::where('status_verifikasi','pending')->count() @endphp
            @if($pendingCount > 0)
                <span class="sidebar-badge">{{ $pendingCount }}</span>
            @endif
            <i class="fas fa-chevron-right nav-arrow"></i>
        </a>
        <div class="collapse nav-submenu {{ request()->routeIs('admin.koperasi.*') ? 'show' : '' }}" id="menuKoperasi">
            <a href="{{ route('admin.koperasi.index') }}"
               class="nav-submenu-link {{ request()->routeIs('admin.koperasi.index') ? 'active' : '' }}">
                Semua Koperasi
            </a>
            <a href="{{ route('admin.koperasi.create') }}"
               class="nav-submenu-link {{ request()->routeIs('admin.koperasi.create') ? 'active' : '' }}">
                Daftar Koperasi Baru
            </a>
            <a href="{{ route('admin.koperasi.index', ['status_verifikasi' => 'pending']) }}"
               class="nav-submenu-link">
                Menunggu Verifikasi
                @if($pendingCount > 0)
                    <span class="sidebar-badge ms-auto">{{ $pendingCount }}</span>
                @endif
            </a>
        </div>

        {{-- DISTRIBUSI BANTUAN --}}
        <div class="nav-section-label">Distribusi Bantuan</div>

        <a href="#menuBantuan" class="nav-item-link {{ request()->routeIs('admin.bantuan.*') ? '' : 'collapsed' }}"
           data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('admin.bantuan.*') ? 'true' : 'false' }}">
            <span class="nav-icon"><i class="fas fa-hand-holding-heart"></i></span>
            Bantuan
            <i class="fas fa-chevron-right nav-arrow"></i>
        </a>
        <div class="collapse nav-submenu {{ request()->routeIs('admin.bantuan.*') ? 'show' : '' }}" id="menuBantuan">
            <a href="{{ route('admin.bantuan.index') }}"
               class="nav-submenu-link {{ request()->routeIs('admin.bantuan.index') ? 'active' : '' }}">
                Daftar Program
            </a>
            <a href="{{ route('admin.bantuan.create') }}"
               class="nav-submenu-link {{ request()->routeIs('admin.bantuan.create') ? 'active' : '' }}">
                Tambah Program
            </a>
        </div>

        {{-- JADWAL KEGIATAN --}}
        <div class="nav-section-label">Jadwal Kegiatan</div>

        <a href="#menuJadwal" class="nav-item-link {{ request()->routeIs('admin.jadwal.*') ? '' : 'collapsed' }}"
           data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('admin.jadwal.*') ? 'true' : 'false' }}">
            <span class="nav-icon"><i class="fas fa-calendar-alt"></i></span>
            Jadwal Kegiatan
            <i class="fas fa-chevron-right nav-arrow"></i>
        </a>
        <div class="collapse nav-submenu {{ request()->routeIs('admin.jadwal.*') ? 'show' : '' }}" id="menuJadwal">
            <a href="#" class="nav-submenu-link">
                Semua Jadwal
            </a>
            <a href="#" class="nav-submenu-link">
                Tambah Jadwal
            </a>
        </div>

        {{-- KOMUNIKASI --}}
        <div class="nav-section-label">Komunikasi</div>

        <a href="{{ route('admin.chat.index') }}"
           class="nav-item-link {{ request()->routeIs('admin.chat.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-comments"></i></span>
            Chat & Pesan
        </a>

        {{-- KEANGGOTAAN --}}
        <div class="nav-section-label">Keanggotaan</div>

        <a href="{{ route('admin.anggota.verifikasi') }}"
           class="nav-item-link {{ request()->routeIs('admin.anggota.verifikasi') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-user-check"></i></span>
            Verifikasi Anggota
            @php $pendingAnggota = \App\Models\Anggota::where('status','Pending')->count() @endphp
            @if($pendingAnggota > 0)
                <span class="sidebar-badge">{{ $pendingAnggota }}</span>
            @endif
        </a>

        <a href="{{ route('admin.anggota.index') }}"
           class="nav-item-link {{ request()->routeIs('admin.anggota.index') || request()->routeIs('admin.anggota.show') || request()->routeIs('admin.anggota.edit') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-users"></i></span>
            Data Anggota
        </a>

        {{-- INFORMASI --}}
        <div class="nav-section-label">Informasi</div>

        {{-- Modul Informasi (Dropdown) --}}
        <a href="#menuModulInformasi" class="nav-item-link {{ request()->routeIs('admin.berita.*') || request()->routeIs('admin.pengumuman.*') || request()->routeIs('admin.kontak.*') || request()->routeIs('admin.visi-misi.*') ? '' : 'collapsed' }}"
           data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('admin.berita.*') || request()->routeIs('admin.pengumuman.*') || request()->routeIs('admin.kontak.*') || request()->routeIs('admin.visi-misi.*') ? 'true' : 'false' }}">
            <span class="nav-icon"><i class="fas fa-info-circle"></i></span>
            Modul Informasi
            <i class="fas fa-chevron-right nav-arrow"></i>
        </a>
        <div class="collapse nav-submenu {{ request()->routeIs('admin.berita.*') || request()->routeIs('admin.pengumuman.*') || request()->routeIs('admin.kontak.*') || request()->routeIs('admin.visi-misi.*') ? 'show' : '' }}" id="menuModulInformasi">
            <a href="{{ route('admin.berita.index') }}"
               class="nav-submenu-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                <i class="far fa-circle mr-2"></i> Berita
            </a>
            <a href="{{ route('admin.pengumuman.index') }}"
               class="nav-submenu-link {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn mr-2"></i> Pengumuman
            </a>
            <a href="{{ route('admin.kontak.index') }}"
               class="nav-submenu-link {{ request()->routeIs('admin.kontak.*') ? 'active' : '' }}">
                <i class="far fa-circle mr-2"></i> Pesan Masuk
            </a>
            <a href="{{ route('admin.visi-misi.index') }}"
               class="nav-submenu-link {{ request()->routeIs('admin.visi-misi.*') ? 'active' : '' }}">
                <i class="far fa-circle mr-2"></i> Visi & Misi
            </a>
        </div>

        <a href="#menuGaleri" class="nav-item-link {{ request()->routeIs('admin.galeri.*') ? 'active' : 'collapsed' }}"
           data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('admin.galeri.*') ? 'true' : 'false' }}">
            <span class="nav-icon"><i class="fas fa-images"></i></span>
            Galeri Kegiatan
            <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <div class="nav-submenu collapse {{ request()->routeIs('admin.galeri.*') ? 'show' : ''}}" id="menuGaleri">
            <a href="/admin/galeri/foto" class="nav-submenu-link {{ request()->is('admin/galeri/foto*') ? 'active' : '' }}">
                <i class="fas fa-camera mr-1"></i> Foto
            </a>
            <a href="/admin/galeri/video" class="nav-submenu-link {{ request()->is('admin/galeri/video*') ? 'active' : '' }}">
                <i class="fas fa-video mr-1"></i> Video
            </a>
        </div>

        <a href="{{ route('admin.halaman-statis.index') }}"
           class="nav-item-link {{ request()->routeIs('admin.halaman-statis.*') && !request()->get('filter') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-file-alt"></i></span>
            Profil
        </a>

        {{-- MONITORING --}}
        <div class="nav-section-label">Monitoring</div>

        <a href="#menuLaporan" class="nav-item-link {{ request()->routeIs('admin.laporan.*') ? '' : 'collapsed' }}"
           data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('admin.laporan.*') ? 'true' : 'false' }}">
            <span class="nav-icon"><i class="fas fa-chart-bar"></i></span>
            Laporan
            <i class="fas fa-chevron-right nav-arrow"></i>
        </a>
        <div class="collapse nav-submenu {{ request()->routeIs('admin.laporan.*') ? 'show' : '' }}" id="menuLaporan">
            <a href="{{ route('admin.laporan.koperasi') }}"
               class="nav-submenu-link {{ request()->routeIs('admin.laporan.koperasi') ? 'active' : '' }}">
                Rekap Koperasi
            </a>
            <a href="{{ route('admin.laporan.bantuan') }}"
               class="nav-submenu-link {{ request()->routeIs('admin.laporan.bantuan') ? 'active' : '' }}">
                Rekap Bantuan
            </a>
            <a href="{{ route('admin.laporan.sertifikat') }}"
               class="nav-submenu-link {{ request()->routeIs('admin.laporan.sertifikat*') ? 'active' : '' }}">
                Sertifikat Koperasi
            </a>
        </div>

        {{-- PENGATURAN --}}
        <div class="nav-section-label">Pengaturan</div>

        <a href="{{ route('admin.users.index') }}"
           class="nav-item-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-users-cog"></i></span>
            Manajemen Pengguna
        </a>

        <a href="{{ route('admin.users.activityLog') }}"
           class="nav-item-link {{ request()->routeIs('admin.users.activityLog') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-history"></i></span>
            Log Aktivitas
        </a>

        <a href="{{ route('admin.profile') }}"
           class="nav-item-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-user-circle"></i></span>
            Profil Saya
        </a>

        {{--
            ══════════════════════════════════════════════════
            MENU PENGATURAN SISTEM (footer, nama instansi, dll)
            Untuk mengubah isi footer, klik menu ini di browser:
            → http://127.0.0.1:8000/admin/settings
            ══════════════════════════════════════════════════
        --}}
        <a href="{{ route('admin.settings.index') }}"
           class="nav-item-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-cog"></i></span>
            Pengaturan Sistem
        </a>

        {{-- Logout --}}
        <div style="margin-top:8px; border-top:1px solid rgba(255,255,255,0.07); padding-top:8px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item-link w-100 border-0 text-start"
                        style="background:none; cursor:pointer; color:#f87171;">
                    <span class="nav-icon"><i class="fas fa-sign-out-alt"></i></span>
                    Keluar
                </button>
            </form>
        </div>

    </nav>
</aside>

{{-- ══════════════════════════════════════════════════════════
     TOPBAR
══════════════════════════════════════════════════════════ --}}
<header class="topbar">
    <div class="topbar-left">
        <button class="topbar-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <nav aria-label="breadcrumb" class="d-none d-sm-block">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted" style="font-size:13px">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                @yield('breadcrumb')
                <li class="breadcrumb-item active" style="font-size:13px; font-weight:600">
                    @yield('title', 'Dashboard')
                </li>
            </ol>
        </nav>
    </div>

    <div class="topbar-right">
        {{-- Notifikasi --}}
        <div class="dropdown">
            <button class="topbar-btn" data-bs-toggle="dropdown">
                <i class="fas fa-bell" style="font-size:15px"></i>
                @php $unread = 0 @endphp
                @if($unread > 0)
                    <span class="topbar-badge">{{ $unread }}</span>
                @endif
            </button>
            <div class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3" style="width:300px; margin-top:8px">
                <div class="px-3 py-2 border-bottom d-flex align-items-center justify-content-between">
                    <span class="fw-semibold" style="font-size:13px">Notifikasi</span>
                    <span class="text-muted" style="font-size:11px">{{ $unread }} belum dibaca</span>
                </div>
                <div class="py-4 text-center text-muted">
                    <i class="fas fa-bell-slash fa-2x mb-2 opacity-25"></i>
                    <p class="mb-0" style="font-size:12px">Tidak ada notifikasi</p>
                </div>
            </div>
        </div>

        {{-- User Dropdown --}}
        <div class="dropdown ms-1">
            <button class="d-flex align-items-center gap-2 border-0 bg-transparent px-2 py-1 rounded-3"
                    style="cursor:pointer" data-bs-toggle="dropdown">
                <div style="width:32px;height:32px;background:var(--primary);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:12px;font-weight:700">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="d-none d-md-block text-start">
                    <div style="font-size:12.5px;font-weight:600;color:#1e293b;line-height:1.2">{{ auth()->user()->name }}</div>
                    <div style="font-size:10.5px;color:#94a3b8;text-transform:capitalize">{{ auth()->user()->role }}</div>
                </div>
                <i class="fas fa-chevron-down text-muted d-none d-md-block" style="font-size:10px"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3" style="min-width:180px; margin-top:8px">
                <a href="{{ route('admin.profile') }}" class="dropdown-item d-flex align-items-center gap-2" style="font-size:13px">
                    <i class="fas fa-user-circle text-muted" style="width:16px"></i> Profil Saya
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger" style="font-size:13px">
                        <i class="fas fa-sign-out-alt" style="width:16px"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

{{-- ══════════════════════════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════════════════════════ --}}
<main class="main-content">
    <div class="content-wrapper">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 d-flex align-items-center gap-2" role="alert">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 d-flex align-items-center gap-2" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show mb-4 d-flex align-items-center gap-2" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <span>{{ session('warning') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show mb-4 d-flex align-items-center gap-2" role="alert">
                <i class="fas fa-info-circle"></i>
                <span>{{ session('info') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Terdapat kesalahan:</strong>
                </div>
                <ul class="mb-0 ps-3 mt-1" style="font-size:13px">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Page Content --}}
        @yield('content')

    </div>

    {{--
        ══════════════════════════════════════════════════════
        FOOTER — Teks di sini diambil dari tabel "settings" di database.
        Untuk mengubah isi footer tanpa edit file ini:
          1. Login sebagai admin
          2. Klik menu "Pengaturan Sistem" di sidebar
          3. Ubah teks yang diinginkan → Simpan

        Atau via terminal (php artisan tinker):
          App\Models\Setting::set('site_name', 'Nama Baru');
          App\Models\Setting::set('footer_address', 'Alamat Baru');
          App\Models\Setting::set('footer_phone', '08xxxxxxx');
          App\Models\Setting::set('footer_email', 'email@domain.go.id');
          App\Models\Setting::set('footer_website', 'www.domain.go.id');
          App\Models\Setting::set('footer_copyright', '© 2025 Nama Instansi');

        Penjelasan setiap baris:
          \App\Models\Setting::get('key')
          → Fungsi ini membaca nilai dari database berdasarkan "key" (nama setting).
          → Jika tidak ada datanya, akan tampil kosong.
        ══════════════════════════════════════════════════════
    --}}
    <footer class="main-footer">

        {{-- Kanan: Tampil website (hanya di layar besar) --}}
        <span class="float-end d-none d-sm-inline text-muted">
            <i class="fas fa-globe me-1"></i>
            {{ \App\Models\Setting::get('footer_website', 'www.disperindagkop-tolikara.go.id') }}
        </span>

        {{-- Kiri: Nama instansi + alamat + telepon --}}
        <strong>{{ \App\Models\Setting::get('site_name', 'DISPERINDAGKOP Kab. Tolikara') }}</strong>
        —
        <i class="fas fa-map-marker-alt me-1"></i>
        {{ \App\Models\Setting::get('footer_address', 'Karubaga, Tolikara, Papua Pegunungan') }}
        &nbsp;|&nbsp;
        <i class="fas fa-phone me-1"></i>
        {{ \App\Models\Setting::get('footer_phone', '-') }}
        &nbsp;|&nbsp;
        <i class="fas fa-envelope me-1"></i>
        {{ \App\Models\Setting::get('footer_email', '-') }}

        {{-- Baris kedua: Copyright --}}
        <br>
        <small class="text-muted">
            {{ \App\Models\Setting::get('footer_copyright', '© ' . date('Y') . ' DISPERINDAGKOP Kabupaten Tolikara. All rights reserved.') }}
        </small>

    </footer>
    {{-- ══ AKHIR FOOTER ══ --}}

</main>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }

    // Auto-dismiss alerts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(el);
            bsAlert.close();
        });
    }, 5000);
</script>

@stack('scripts')
</body>
</html>