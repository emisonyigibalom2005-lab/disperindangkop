<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | DISPERINDAGKOP Tolikara</title>

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.css">

    @stack('styles')

    <style>
        .brand-link { background: #1a3a6e !important; }
        @php
    $role = auth()->user()->role ?? "admin";
    $themes = [
        "admin"    => ["sidebar"=>"#1e3a5f", "header"=>"#1a3a6e", "accent"=>"#f5a623", "label"=>"Administrator"],
        "pimpinan" => ["sidebar"=>"#145a32", "header"=>"#1e8449", "accent"=>"#58d68d", "label"=>"Pimpinan"],
        "petugas"  => ["sidebar"=>"#0e6655", "header"=>"#117a65", "accent"=>"#48c9b0", "label"=>"Petugas"],
        "koperasi"     => ["sidebar"=>"#6e2f1a", "header"=>"#a04000", "accent"=>"#f39c12", "label"=>"Pelaku Koperasi"],
    ];
    $theme = $themes[$role] ?? $themes["admin"];
@endphp
        .main-sidebar { background: {{ $theme["sidebar"] }} !important; }
        .nav-sidebar .nav-link { color: rgba(255,255,255,.8) !important; }
        .nav-sidebar .nav-link.active,
        .nav-sidebar .nav-link:hover { background: rgba(255,255,255,.15) !important; color: #fff !important; border-radius: 6px; }
        .nav-sidebar .nav-treeview { background: rgba(0,0,0,.15) !important; }
        .main-header.navbar { background: {{ $theme["header"] }} !important; }
        .brand-link { background: {{ $theme["sidebar"] }} !important; border-bottom: 1px solid rgba(255,255,255,.1) !important; }
        .role-badge { background: {{ $theme["accent"] }}; color: #ffffff; padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .nav-header { color: rgba(255,255,255,.4) !important; font-size: 10px !important; font-weight: 700 !important; letter-spacing: 1px; }
        .content-wrapper { background: #f4f6f9 !important; }
        .main-header { border-bottom: 1px solid #dee2e6; }
        .card { border-radius: 8px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,.08); }
        .card-header { border-radius: 8px 8px 0 0 !important; font-weight: 600; }
        .btn { border-radius: 6px; font-size: 13px; }
        .badge { font-size: 11px; }
        .small-box { border-radius: 8px; }
        .small-box .icon { overflow: hidden; border-radius: 0 8px 0 0; }
        .table thead th { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; }
        .table tbody td { font-size: 13px; vertical-align: middle; }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-treeview { background: rgba(0,0,0,.15); }
        .user-panel .info a, .user-panel .info span { color: #ffffff !important; }
        .user-panel .info { color: #ffffff !important; }
        .brand-link .brand-text { color: #ffffff !important; }
        p.text-muted, .user-panel p { color: rgba(255,255,255,0.7) !important; }
        .user-panel { border-bottom: 1px solid rgba(255,255,255,.1) !important; }
        .user-panel .info a { color: rgba(255,255,255,.9) !important; font-size: 13px; font-weight: 600; }
        .brand-text { color: #fff !important; font-size: 14px !important; }
        /* Fix dropdown notifikasi tampil di depan sidebar */
        .main-header .dropdown-menu {
            z-index: 9999 !important;
            position: absolute !important;
        }
        .main-header .navbar-nav {
            z-index: 9999 !important;
        }
        .main-header {
            z-index: 1040 !important;
        }
        .main-sidebar {
            z-index: 1035 !important;
        }
        /* Fix semua teks & icon di header dan sidebar jadi putih */
        .main-header .nav-link { color: #ffffff !important; }
        .main-header .nav-link:hover { color: #ffffff !important; }
        .main-header .navbar-nav .nav-link { color: #ffffff !important; }
        .main-header .navbar-badge { background: #e74c3c !important; color: #fff !important; }
        .user-panel .info a { color: #ffffff !important; }
        .user-panel .info span { color: rgba(255,255,255,0.75) !important; }
        .user-panel > .info { color: #ffffff !important; }
        .sidebar-dark-primary .user-panel .info a { color: #ffffff !important; }
        /* Teks role/label di bawah nama user */
        .user-panel .info p { color: rgba(255,255,255,0.75) !important; }
        /* Icon di header (notif, dsb) */
        .main-header .fas, .main-header .far, .main-header .fab { color: #ffffff !important; }
        /* Teks dropdown user di kanan atas */
        .main-header .nav-item .nav-link p { color: #ffffff !important; }
        /* Kab. Tolikara */
        .navbar-nav .nav-link span, .main-header span { color: #ffffff !important; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #1a3a6e; border-radius: 3px; }
        .alert { border-radius: 8px; font-size: 13px; }
        .breadcrumb { background: transparent; padding: 0; font-size: 13px; }
        .content-header h1 { font-size: 20px; font-weight: 700; color: #1a3a6e; }
        .info-box { border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,.08); }
        .info-box-icon { border-radius: 8px 0 0 8px; }
        .pagination { font-size: 13px; }
        .select2-container { width: 100% !important; }
        .dropdown-menu { font-size: 13px; border-radius: 8px; box-shadow: 0 5px 20px rgba(0,0,0,.15); }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- ═══════════════════════════════════════════
         NAVBAR
    ═══════════════════════════════════════════ -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Kiri: Toggle + Judul -->
        <ul class="navbar-nav">
            
    {{-- ── NOTIFIKASI BELL ──────────────────────────── --}}
    <li class="nav-item dropdown" id="notifDropdown">
        <a class="nav-link" href="#" data-toggle="dropdown" id="notifBell">
            <i class="far fa-bell"></i>
            <span class="badge badge-danger navbar-badge" id="notifCount" style="display:none;">0</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow border-0 p-0" style="width:340px;max-height:420px;overflow:hidden;">
            <div style="background:linear-gradient(135deg,#0d2240,#1a3a6e);padding:14px 18px;" class="d-flex justify-content-between align-items-center">
                <span style="color:#fff;font-weight:700;font-size:14px;"><i class="fas fa-bell mr-2"></i>Notifikasi</span>
                <button onclick="bacaSemua()" class="btn btn-sm" style="background:rgba(255,255,255,.15);color:#fff;font-size:11px;border:none;">
                    Tandai semua dibaca
                </button>
            </div>
            <div id="notifList" style="max-height:320px;overflow-y:auto;">
                <div class="text-center py-4 text-muted" id="notifEmpty">
                    <i class="fas fa-bell-slash fa-2x d-block mb-2" style="opacity:.3"></i>
                    Tidak ada notifikasi baru
                </div>
            </div>
            <div style="border-top:1px solid #eee;padding:10px;text-align:center;">
                <a href="{{ route('notifikasi.index') }}" style="font-size:12px;color:#1a3a6e;font-weight:600;">
                    Lihat semua notifikasi
                </a>
            </div>
        </div>
    </li>
<li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-inline-block">
                <span class="nav-link text-muted" style="font-size:12px">
                    <i class="fas fa-map-marker-alt mr-1 text-danger"></i>
                    Kabupaten Tolikara, Papua Pegunungan
                </span>
            </li>
        </ul>

        <!-- Kanan: Notifikasi + User -->
        <ul class="navbar-nav ml-auto">

            <!-- Notifikasi Bell -->
            @php
                $unreadCount = auth()->user()->unreadNotifikasi()->count();
            @endphp
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button">
                    <i class="far fa-bell"></i>
                    @if($unreadCount > 0)
                        <span class="badge badge-danger navbar-badge">{{ $unreadCount }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width:320px">
                    <span class="dropdown-item dropdown-header bg-light font-weight-bold">
                        <i class="fas fa-bell mr-1 text-warning"></i>
                        {{ $unreadCount }} Notifikasi Belum Dibaca
                    </span>
                    <div class="dropdown-divider"></div>
                    @forelse(auth()->user()->notifikasi()->limit(5)->get() as $notif)
                        <a href="{{ $notif->url ?? '#' }}" class="dropdown-item py-2">
                            <div class="d-flex align-items-start">
                                <span class="mr-2 mt-1">
                                    <i class="fas fa-circle fa-xs text-{{ $notif->jenis ?? 'info' }}"></i>
                                </span>
                                <div>
                                    <p class="mb-0 font-weight-bold" style="font-size:13px">{{ $notif->judul }}</p>
                                    <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                    @empty
                        <span class="dropdown-item text-muted text-center py-3">
                            <i class="fas fa-check-circle text-success mr-1"></i> Tidak ada notifikasi
                        </span>
                        <div class="dropdown-divider"></div>
                    @endforelse
                    <a href="#" class="dropdown-item dropdown-footer text-center text-primary">
                        Lihat Semua Notifikasi
                    </a>
                </div>
            </li>

            <!-- Profil User -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown" href="#" role="button">
                    <img src="{{ auth()->user()->profile_photo_url }}"
                         class="img-circle elevation-1 mr-2"
                         style="width:30px; height:30px; object-fit:cover"
                         alt="User">
                    <span class="d-none d-md-inline" style="font-size:13px; font-weight:600">
                        {{ Str::limit(auth()->user()->name, 18) }}
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" style="min-width:220px">
                    <div class="px-3 py-2 bg-light" style="border-radius:8px 8px 0 0">
                        <p class="mb-0 font-weight-bold" style="font-size:13px">{{ auth()->user()->name }}</p>
                        <span class="badge badge-primary" style="font-size:11px">{{ auth()->user()->role_label }}</span>
                    </div>
                    <div class="dropdown-divider mt-0"></div>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.profile') }}" class="dropdown-item">
                            <i class="fas fa-user-cog mr-2 text-primary"></i> Profil Saya
                        </a>
                    @elseif(auth()->user()->isPetugas())
                        <a href="{{ route('petugas.profile') }}" class="dropdown-item">
                            <i class="fas fa-user-cog mr-2 text-primary"></i> Profil Saya
                        </a>
                    @elseif(auth()->user()->isPimpinan())
                        <a href="{{ route('pimpinan.profile') }}" class="dropdown-item">
                            <i class="fas fa-user-cog mr-2 text-primary"></i> Profil Saya
                        </a>
                    @else
                        <a href="{{ route('koperasi.profile') }}" class="dropdown-item">
                            <i class="fas fa-user-cog mr-2 text-primary"></i> Profil Saya
                        </a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- ═══════════════════════════════════════════
         SIDEBAR
    ═══════════════════════════════════════════ -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand -->
        <a href="{{ route('dashboard') }}" class="brand-link px-3">
            <i class="fas fa-building mr-2" style="font-size:20px; color:#fff; opacity:.9"></i>
            <span class="brand-text font-weight-bold" style="font-size:13px; line-height:1.2">
                DISPERINDAGKOP<br>
                <small style="font-size:10px; opacity:.75; font-weight:400">Kab. Tolikara</small>
            </span>
        </a>

        <div class="sidebar">
            <!-- User Panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ auth()->user()->profile_photo_url }}"
                         class="img-circle elevation-2"
                         style="width:34px; height:34px; object-fit:cover"
                         alt="User">
                </div>
                <div class="info">
                    <span class="d-block text-white font-weight-bold" style="font-size:13px">
                        {{ Str::limit(auth()->user()->name, 18) }}
                    </span>
                    <small class="text-muted" style="font-size:11px">{{ auth()->user()->role_label }}</small>
                </div>
            </div>

            <!-- Menu Navigasi -->
            <nav class="mt-1">
                <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent"
                    data-widget="treeview" role="menu" data-accordion="false">

                    {{-- ═══════════ ADMIN MENU ═══════════ --}}
                    @if(auth()->user()->isAdmin())

                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">MANAJEMEN KOPERASI</li>
                    <li class="nav-item {{ request()->routeIs('admin.koperasi*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.koperasi*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-store"></i>
                            <p>Data Koperasi
                                @php $pendingCount = \App\Models\Koperasi::where('status_verifikasi','pending')->count(); @endphp
                                @if($pendingCount > 0)
                                    <span class="badge badge-warning right">{{ $pendingCount }}</span>
                                @endif
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.koperasi.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.koperasi.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Semua Koperasi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.koperasi.create') }}"
                                   class="nav-link {{ request()->routeIs('admin.koperasi.create') ? 'active' : '' }}">
                                    <i class="far fa-plus-square nav-icon"></i><p>Daftar Koperasi Baru</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.koperasi.index', ['status_verifikasi'=>'pending']) }}"
                                   class="nav-link">
                                    <i class="far fa-clock nav-icon"></i>
                                    <p>Menunggu Verifikasi
                                        @if($pendingCount > 0)
                                            <span class="badge badge-warning right">{{ $pendingCount }}</span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">DISTRIBUSI BANTUAN</li>
                    <li class="nav-item {{ request()->routeIs('admin.bantuan*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.bantuan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>Bantuan <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.bantuan.index') }}" class="nav-link {{ request()->routeIs('admin.bantuan.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Daftar Program</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.bantuan.create') }}" class="nav-link {{ request()->routeIs('admin.bantuan.create') ? 'active' : '' }}">
                                    <i class="far fa-plus-square nav-icon"></i><p>Tambah Program</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">JADWAL KEGIATAN</li>
                    <li class="nav-item {{ request()->routeIs('admin.jadwal*') || request()->routeIs('admin.struktur*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.jadwal*') || request()->routeIs('admin.struktur*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Jadwal Kegiatan <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.jadwal.index') }}" class="nav-link {{ request()->routeIs('admin.jadwal*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Jadwal Kegiatan</p>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.struktur*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ request()->routeIs('admin.struktur*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Struktur Organisasi <i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.struktur.index') }}" class="nav-link {{ request()->routeIs('admin.struktur.index') ? 'active' : '' }}">
                                            <i class="far fa-dot-circle nav-icon"></i><p>Daftar Pegawai</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.struktur.create') }}" class="nav-link {{ request()->routeIs('admin.struktur.create') ? 'active' : '' }}">
                                            <i class="far fa-dot-circle nav-icon"></i><p>Tambah Pegawai</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.struktur.bagan') }}" class="nav-link {{ request()->routeIs('admin.struktur.bagan') ? 'active' : '' }}">
                                            <i class="far fa-dot-circle nav-icon"></i><p>Upload Bagan</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">INFORMASI</li>
                    <li class="nav-item {{ request()->routeIs('admin.berita*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.berita*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>Berita & Pengumuman <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.berita.index') }}" class="nav-link {{ request()->routeIs('admin.berita.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Semua Berita</p>
                                </a>
                            </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pengumuman.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.pengumuman*') ? 'active' : '' }}">
                            <i class="fas fa-bullhorn nav-icon text-warning"></i>
                            <p>Pengumuman</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.jadwal.index') }}"
                           class="nav-link {{ request()->routeIs('admin.jadwal*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt nav-icon text-primary"></i>
                            <p>Jadwal Kegiatan</p>
                        </a>
                    </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.berita.create') }}" class="nav-link {{ request()->routeIs('admin.berita.create') ? 'active' : '' }}">
                                    <i class="far fa-plus-square nav-icon"></i><p>Tulis Berita</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.galeri.index') }}" class="nav-link {{ request()->routeIs('admin.galeri*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-images"></i><p>Galeri Kegiatan</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.kontak*') || request()->routeIs('admin.halaman-statis*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.kontak*') || request()->routeIs('admin.halaman-statis*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-address-book"></i>
                            <p>Kontak <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.kontak.index') }}" class="nav-link {{ request()->routeIs('admin.kontak*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Pesan Masuk</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.halaman-statis.index') }}" class="nav-link {{ request()->routeIs('admin.halaman-statis*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Profil</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    
                    
                    <li class="nav-header">KOPERASI</li>
                    <li class="nav-item {{ request()->routeIs('admin.anggota*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.anggota*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Dokumen & Kartu Anggota <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.anggota.index') }}" class="nav-link {{ request()->routeIs('admin.anggota.index') ? 'active' : '' }}">
                                    <i class="fas fa-list nav-icon"></i><p>Daftar Anggota</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.anggota.create') }}" class="nav-link {{ request()->routeIs('admin.anggota.create') ? 'active' : '' }}">
                                    <i class="fas fa-user-plus nav-icon"></i><p>Tambah Anggota</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.anggota.dokumen') }}" class="nav-link {{ request()->routeIs('admin.anggota*') && request()->get('dokumen') ? 'active' : '' }}">
                                    <i class="fas fa-file-alt nav-icon"></i><p>📄 Dokumen Anggota</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.anggota.dokumen') }}?status=Aktif" class="nav-link">
                                    <i class="fas fa-id-card nav-icon"></i><p>🪪 Kartu & Sertifikat</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-header">LAYANAN</li>
                    <li class="nav-item {{ request()->routeIs('admin.pelatihan*') || request()->routeIs('admin.pengajuan*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.pelatihan*') || request()->routeIs('admin.pengajuan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-concierge-bell"></i>
                            <p>Layanan <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.pelatihan.index') }}" class="nav-link {{ request()->routeIs('admin.pelatihan*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Pelatihan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.pengajuan-bantuan.index') }}" class="nav-link {{ request()->routeIs('admin.pengajuan-bantuan*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Pengajuan Bantuan Modal</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-header">MONITORING</li>
                    <li class="nav-item {{ request()->routeIs('admin.laporan*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Laporan <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.laporan.koperasi') }}" class="nav-link {{ request()->routeIs('admin.laporan.koperasi') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Rekap Koperasi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.laporan.bantuan') }}" class="nav-link {{ request()->routeIs('admin.laporan.bantuan') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Rekap Bantuan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.laporan.sertifikat') }}" class="nav-link {{ request()->routeIs('admin.laporan.sertifikat*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Sertifikat Koperasi</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">PENGATURAN</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i><p>Manajemen Pengguna</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.activityLog') }}" class="nav-link {{ request()->routeIs('admin.users.activityLog') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i><p>Log Aktivitas</p>
                        </a>
                    </li>

                    {{-- ═══════════ PETUGAS MENU ═══════════ --}}
                    @elseif(auth()->user()->isPetugas())

                    <li class="nav-item">
                        <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-header">MANAJEMEN KOPERASI</li>
                    <li class="nav-item">
                        <a href="{{ route('petugas.koperasi.index') }}" class="nav-link {{ request()->routeIs('petugas.koperasi.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-store"></i><p>Semua Koperasi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('petugas.koperasi.create') }}" class="nav-link {{ request()->routeIs('petugas.koperasi.create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-plus-circle"></i><p>Daftar Koperasi Baru</p>
                        </a>
                    </li>
                    <li class="nav-header">DISTRIBUSI BANTUAN</li>
                    <li class="nav-item">
                        <a href="{{ route('petugas.bantuan.index') }}" class="nav-link {{ request()->routeIs('petugas.bantuan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-hand-holding-usd"></i><p>Distribusi Bantuan</p>
                        </a>
                    </li>
                    <li class="nav-header">JADWAL</li>
                    <li class="nav-item">
                        <a href="{{ route('petugas.jadwal.index') }}" class="nav-link {{ request()->routeIs('petugas.jadwal*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i><p>Jadwal Saya</p>
                        </a>
                    </li>

                    <li class="nav-header">AKUN</li>
                    <li class="nav-item">
                        <a href="{{ route('petugas.profile') }}" class="nav-link {{ request()->routeIs('petugas.profile') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-cog"></i><p>Profil Saya</p>
                        </a>
                    </li>

                    {{-- ═══════════ PIMPINAN MENU ═══════════ --}}
                    @elseif(auth()->user()->isPimpinan())

                    <li class="nav-item">
                        <a href="{{ route('pimpinan.dashboard') }}" class="nav-link {{ request()->routeIs('pimpinan.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-header">DATA Koperasi</li>
                    <li class="nav-item">
                        <a href="{{ route('pimpinan.koperasi') }}" class="nav-link {{ request()->routeIs('pimpinan.koperasi*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-store"></i><p>Data Koperasi</p>
                        </a>
                    </li>
                    <li class="nav-header">LAPORAN</li>
                    <li class="nav-item {{ request()->routeIs('pimpinan.laporan*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('pimpinan.laporan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Rekap & Laporan <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('pimpinan.laporan.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i><p>Rekap Koperasi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pimpinan.laporan.bantuan') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i><p>Rekap Bantuan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-header">JADWAL</li>
                    <li class="nav-item">
                        <a href="{{ route('pimpinan.jadwal.index') }}" class="nav-link {{ request()->routeIs('pimpinan.jadwal*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i><p>Jadwal Kegiatan</p>
                        </a>
                    </li>

                    <li class="nav-header">AKUN</li>
                    <li class="nav-item">
                        <a href="{{ route('pimpinan.profile') }}" class="nav-link {{ request()->routeIs('pimpinan.profile') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-cog"></i><p>Profil Saya</p>
                        </a>
                    </li>

                    {{-- ═══════════ Koperasi MENU ═══════════ --}}
                    @else

                    <li class="nav-item">
                        <a href="{{ route('koperasi.dashboard') }}" class="nav-link {{ request()->routeIs('koperasi.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-header">USAHA SAYA</li>
                    <li class="nav-item">
                        <a href="{{ route('koperasi.profile') }}" class="nav-link {{ request()->routeIs('koperasi.profile') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-store"></i><p>Profil Usaha</p>
                        </a>
                    </li>
                    <li class="nav-header">BANTUAN</li>
                    <li class="nav-item">
                        <a href="{{ route('koperasi.bantuan.index') }}" class="nav-link {{ request()->routeIs('koperasi.bantuan.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-gift"></i><p>Program Bantuan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('koperasi.bantuan.riwayat') }}" class="nav-link {{ request()->routeIs('koperasi.bantuan.riwayat') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i><p>Riwayat Bantuan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('koperasi.bantuan.jadwal') }}" class="nav-link {{ request()->routeIs('koperasi.bantuan.jadwal') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i><p>Jadwal Distribusi</p>
                        </a>
                    </li>
                    <li class="nav-header">NOTIFIKASI</li>
                    <li class="nav-item">
                        <a href="{{ route('koperasi.notifikasi') }}" class="nav-link {{ request()->routeIs('koperasi.notifikasi') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bell"></i>
                            <p>Notifikasi
                                @if($unreadCount > 0)
                                    <span class="badge badge-danger right">{{ $unreadCount }}</span>
                                @endif
                            </p>
                        </a>
                    </li>

                    @endif

                </ul>
            </nav>
        </div>
    </aside>

    <!-- ═══════════════════════════════════════════
         CONTENT WRAPPER
    ═══════════════════════════════════════════ -->
    <div class="content-wrapper">
        <!-- Content Header / Breadcrumb -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}"><i class="fas fa-home mr-1"></i>Home</a>
                            </li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show shadow-sm">
                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('warning') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Terdapat kesalahan input:</strong>
                        <ul class="mb-0 mt-1 pl-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>
            &copy; {{ date('Y') }}
            <a href="#" class="text-primary">DISPERINDAGKOP Kabupaten Tolikara</a>.
        </strong>
        Sistem Informasi Perindustrian, Perdagangan, Koperasi dan UMKM.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0
        </div>
    </footer>
</div>

<!-- ═══════════════════════════════════════════
     SCRIPTS
═══════════════════════════════════════════ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

<script>
$(function () {
    // DataTable otomatis
    if ($('.datatable').length) {
        $('.datatable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data tidak ditemukan",
                paginate: { first:"Pertama", last:"Terakhir", next:"&raquo;", previous:"&laquo;" }
            }
        });
    }

    // Select2 otomatis
    if ($('.select2').length) {
        $('.select2').select2({ theme: 'bootstrap', width: '100%' });
    }

    // Toastr config
    toastr.options = { positionClass: 'toast-top-right', timeOut: 4000, progressBar: true };

    @if(session('toastr_success'))
        toastr.success('{{ session('toastr_success') }}');
    @endif
    @if(session('toastr_error'))
        toastr.error('{{ session('toastr_error') }}');
    @endif

    // Konfirmasi hapus universal
    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Hapus Data?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });

    // Auto hide alert setelah 5 detik
    setTimeout(function () {
        $('.alert-dismissible').fadeOut('slow');
    }, 5000);
});
</script>
@stack('scripts')
</body>
</html>