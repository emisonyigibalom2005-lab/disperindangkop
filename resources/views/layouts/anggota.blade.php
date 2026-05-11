<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Anggota') | DISPERINDAGKOP Tolikara</title>

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @stack('styles')

    <style>
        :root {
            --primary-color: #1e3a5f;
            --secondary-color: #2c5282;
            --accent-color: #3b6ba8;
            --success-color: #10b981;
            --info-color: #3b82f6;
            --warning-color: #f59e0b;
        }

        body {
            font-family: 'Source Sans Pro', sans-serif;
            background: #f5f7fa;
        }

        /* Navbar */
        .main-header.navbar {
            background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%) !important;
            border-bottom: none;
            box-shadow: 0 2px 8px rgba(30, 58, 95, 0.3);
            position: relative;
        }

        .main-header .nav-link {
            color: #ffffff !important;
            transition: all 0.3s ease;
            position: relative;
            padding: 8px 15px;
            border-radius: 6px;
            margin: 0 3px;
        }

        .main-header .nav-link:hover {
            background: rgba(255,255,255,0.15);
        }

        .main-header .nav-link i {
            transition: all 0.3s ease;
        }

        .main-header .navbar-badge {
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
            color: #fff !important;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
            font-weight: 700;
            border: 2px solid rgba(255,255,255,0.3);
        }

        /* User Dropdown */
        .main-header .nav-link.dropdown-toggle {
            color: #ffffff !important;
        }

        .main-header .nav-link.dropdown-toggle span,
        .main-header .nav-link.dropdown-toggle i {
            color: #ffffff !important;
        }

        .main-header .nav-link.dropdown-toggle::after {
            display: none !important;
        }

        .user-dropdown-menu {
            border: none !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }

        /* Sidebar */
        .main-sidebar {
            background: linear-gradient(180deg, #1e3a5f 0%, #2c5282 100%) !important;
            box-shadow: 2px 0 8px rgba(0,0,0,0.15);
        }

        .brand-link {
            background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%) !important;
            border-bottom: 1px solid rgba(255,255,255,0.1) !important;
            padding: 1rem;
        }

        .brand-text {
            color: #fff !important;
            font-weight: 700;
            font-size: 14px !important;
        }

        .nav-sidebar .nav-link {
            color: rgba(255,255,255,0.8) !important;
            border-radius: 6px;
            margin: 3px 10px;
            transition: all 0.3s ease;
            padding: 10px 15px;
        }

        .nav-sidebar .nav-link:hover {
            background: rgba(255,255,255,0.08) !important;
            color: #fff !important;
        }

        .nav-sidebar .nav-link.active {
            background: rgba(255,255,255,0.2) !important;
            color: #fff !important;
            font-weight: 600;
            border-left: 4px solid #f59e0b;
            padding-left: 11px;
        }

        .nav-sidebar .nav-link i {
            color: rgba(255,255,255,0.8);
            margin-right: 10px;
        }

        .nav-sidebar .nav-link.active i,
        .nav-sidebar .nav-link:hover i {
            color: #fff;
        }

        .nav-header {
            color: rgba(255,255,255,0.35) !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            letter-spacing: 1.5px;
            margin-top: 15px;
            padding: 8px 15px 5px;
            text-transform: uppercase;
        }

        /* Content */
        .content-wrapper {
            background: #f5f7fa !important;
            min-height: 100vh;
        }

        .content-header {
            padding: 20px 1.5rem;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 20px;
        }

        .content-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1e3a5f;
            margin-bottom: 8px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            font-size: 13px;
        }

        .breadcrumb-item {
            color: #6b7280;
        }

        .breadcrumb-item.active {
            color: #1e3a5f;
            font-weight: 600;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            color: #9ca3af;
            font-size: 16px;
        }

        .breadcrumb-item a {
            color: #2c5282;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: #1e3a5f;
            text-decoration: underline;
        }

        /* Cards */
        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        .card-header {
            background: linear-gradient(135deg, #2c5282, #1e3a5f);
            color: white;
            border-bottom: none;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }

        /* Buttons */
        .btn {
            border-radius: 6px;
            font-weight: 600;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2c5282, #1e3a5f);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3b6ba8, #2c5282);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.3);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #2c5282, #1e3a5f);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-track {
            background: #f5f7fa;
        }

        .main-header .dropdown-toggle {
            background: rgba(255,255,255,0.1);
            border-radius: 50px;
            padding: 6px 15px 6px 6px !important;
            transition: all 0.3s ease;
        }

        .main-header .dropdown-toggle:hover {
            background: rgba(255,255,255,0.15);
        }

        .main-header .dropdown-toggle img {
            border: 2px solid rgba(255,255,255,0.5);
            transition: all 0.3s ease;
        }
        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .dropdown-menu .dropdown-header {
            background: linear-gradient(135deg, #2c5282, #1e3a5f);
            color: white;
            border-bottom: 2px solid rgba(255,255,255,0.2);
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: #1e3a5f;
        }

        /* Logo */
        .brand-link {
            display: flex;
            align-items: center;
            padding: 18px 15px;
            background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%) !important;
            border-bottom: 1px solid rgba(255,255,255,0.1) !important;
            transition: all 0.3s ease;
        }

        .brand-link:hover {
            background: linear-gradient(135deg, #2c5282 0%, #3b6ba8 100%) !important;
        }

        .brand-image {
            float: none !important;
            margin: 0 !important;
            border-radius: 8px;
        }

        .brand-text-wrapper {
            line-height: 1.3;
            margin-left: 0;
        }

        .brand-text {
            color: #fff !important;
            font-size: 15px !important;
            display: block;
            letter-spacing: 0.5px;
        }

        .brand-subtitle {
            font-size: 11px;
            opacity: 0.85;
            color: #fff;
            font-weight: 400;
        }

        /* Footer */
        .main-footer {
            background: #fff;
            border-top: 1px solid #dee2e6;
            padding: 15px;
            font-size: 13px;
        }
        
        /* Pulse animation for badge */
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.7;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .content-header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <span class="nav-link" style="padding: 8px 15px;">
                    <i class="fas fa-map-marker-alt mr-2" style="font-size: 14px;"></i>
                    <span style="font-size: 13px; font-weight: 500;">Kabupaten Tolikara, Papua Pegunungan</span>
                </span>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications -->
            @php
                $unreadCount = auth()->user()->unreadNotifikasi()->count();
            @endphp
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button">
                    <i class="far fa-bell" style="font-size: 18px;"></i>
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
                        <a href="javascript:void(0)" onclick="readAndDeleteNotif({{ $notif->id }}, '{{ $notif->link ?? '#' }}')" class="dropdown-item py-2 {{ $notif->is_read ? '' : 'bg-light' }}">
                            <div class="d-flex align-items-start">
                                <span class="mr-2 mt-1">
                                    @if($notif->tipe == 'success')
                                        <i class="fas fa-check-circle text-success"></i>
                                    @elseif($notif->tipe == 'warning')
                                        <i class="fas fa-exclamation-triangle text-warning"></i>
                                    @elseif($notif->tipe == 'danger')
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @else
                                        <i class="fas fa-info-circle text-info"></i>
                                    @endif
                                </span>
                                <div style="flex: 1;">
                                    <p class="mb-1 font-weight-bold" style="font-size:13px">{{ $notif->judul }}</p>
                                    <small class="text-muted d-block" style="font-size:11px; line-height: 1.4;">{{ Str::limit($notif->pesan, 80) }}</small>
                                    <small class="text-muted" style="font-size:10px;">{{ $notif->created_at->diffForHumans() }}</small>
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

            <!-- User Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown" href="#" role="button" style="padding: 8px 15px; text-decoration: none;">
                    @php
                        $anggota = auth()->user()->anggota;
                        $profilePhoto = null;
                        if ($anggota && $anggota->foto) {
                            $profilePhoto = asset('storage/' . $anggota->foto);
                        }
                    @endphp
                    @if($profilePhoto)
                        <img src="{{ $profilePhoto }}" 
                             class="img-circle elevation-1 mr-2" 
                             style="width: 35px; height: 35px; object-fit: cover; border: 2px solid rgba(255,255,255,0.3);" 
                             alt="{{ auth()->user()->name }}"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="rounded-circle mr-2 d-none align-items-center justify-content-center" 
                             style="width: 35px; height: 35px; background: linear-gradient(135deg, #10b981, #059669); color: white; font-weight: 700; font-size: 16px; border: 2px solid rgba(255,255,255,0.3);">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @else
                        <div class="rounded-circle mr-2 d-flex align-items-center justify-content-center" 
                             style="width: 35px; height: 35px; background: linear-gradient(135deg, #10b981, #059669); color: white; font-weight: 700; font-size: 16px; border: 2px solid rgba(255,255,255,0.3);">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="d-none d-md-inline" style="font-size: 14px; font-weight: 500; color: #ffffff;">
                        {{ Str::limit(auth()->user()->name, 20) }}
                    </span>
                    <i class="fas fa-chevron-down ml-2" style="font-size: 11px; opacity: 0.7; color: #ffffff;"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right user-dropdown-menu" style="min-width: 280px; border-radius: 12px; border: none;">
                    <div class="px-4 py-3" style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%); border-radius: 12px 12px 0 0;">
                        <div class="d-flex align-items-center">
                            @if($profilePhoto)
                                <img src="{{ $profilePhoto }}" 
                                     class="img-circle elevation-2 mr-3" 
                                     style="width: 50px; height: 50px; object-fit: cover; border: 3px solid white;" 
                                     alt="{{ auth()->user()->name }}"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="rounded-circle mr-3 d-none align-items-center justify-content-center elevation-2" 
                                     style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981, #059669); color: white; font-weight: 700; font-size: 22px; border: 3px solid white;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @else
                                <div class="rounded-circle mr-3 d-flex align-items-center justify-content-center elevation-2" 
                                     style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981, #059669); color: white; font-weight: 700; font-size: 22px; border: 3px solid white;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <p class="mb-0 font-weight-bold text-white" style="font-size: 14px;">{{ auth()->user()->name }}</p>
                                <span class="badge badge-light mt-1" style="font-size: 11px;">
                                    <i class="fas fa-user-check mr-1"></i>Anggota Koperasi
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="py-2">
                        <a href="{{ route('anggota.profil') }}" class="dropdown-item py-2">
                            <i class="fas fa-user-cog fa-fw mr-2 text-primary"></i> 
                            <span style="font-weight: 500;">Profil Saya</span>
                        </a>
                        <a href="{{ route('anggota.kartu') }}" class="dropdown-item py-2">
                            <i class="fas fa-id-card fa-fw mr-2 text-success"></i> 
                            <span style="font-weight: 500;">Kartu Anggota</span>
                        </a>
                    </div>
                    
                    <div class="dropdown-divider my-0"></div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger py-2">
                            <i class="fas fa-sign-out-alt fa-fw mr-2"></i> 
                            <span style="font-weight: 500;">Keluar</span>
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('anggota.dashboard') }}" class="brand-link">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="brand-image" style="width: 45px; height: 45px; margin-right: 12px;">
            <div class="brand-text-wrapper">
                <span class="brand-text font-weight-bold" style="font-size: 15px; letter-spacing: 0.5px;">DISPERINDAGKOP</span>
                <br>
                <small class="brand-subtitle" style="font-size: 11px; opacity: 0.85;">Kab. Tolikara</small>
            </div>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('anggota.dashboard') }}" class="nav-link {{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- PROFIL & DATA -->
                    <li class="nav-header">PROFIL SAYA</li>
                    <li class="nav-item">
                        <a href="{{ route('anggota.profil') }}" class="nav-link {{ request()->routeIs('anggota.profil') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Data Profil</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('anggota.kartu') }}" class="nav-link {{ request()->routeIs('anggota.kartu') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-id-card"></i>
                            <p>Kartu Anggota</p>
                        </a>
                    </li>
                    
                    {{-- Menu Lengkapi Data --}}
                    <li class="nav-item">
                        <a href="{{ route('anggota.lengkapi-data') }}" class="nav-link {{ request()->routeIs('anggota.lengkapi-data*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Lengkapi Data</p>
                        </a>
                    </li>

                    <!-- INFORMASI -->
                    <li class="nav-header">INFORMASI</li>
                    <li class="nav-item">
                        <a href="{{ route('anggota.pengumuman') }}" class="nav-link {{ request()->routeIs('anggota.pengumuman') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bullhorn"></i>
                            <p>Pengumuman</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('anggota.jadwal') }}" class="nav-link {{ request()->routeIs('anggota.jadwal') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Jadwal Kegiatan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('anggota.kebutuhan-bantuan') }}" class="nav-link {{ request()->routeIs('anggota.kebutuhan-bantuan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>List Kebutuhan Bantuan</p>
                        </a>
                    </li>
                    
                    <!-- KOMUNIKASI -->
                    <li class="nav-header">KOMUNIKASI</li>
                    <li class="nav-item">
                        <a href="{{ route('anggota.chat.index') }}" class="nav-link {{ request()->routeIs('anggota.chat*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>Chat dengan Admin
                                @php 
                                    $unreadChats = \App\Models\Chat::where('penerima_id', auth()->id())->where('is_read', false)->count();
                                @endphp
                                @if($unreadChats > 0)
                                    <span class="badge badge-warning right">{{ $unreadChats }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer text-center">
        <strong>Copyright &copy; {{ date('Y') }} <a href="#">DISPERINDAGKOP Tolikara</a>.</strong>
        All rights reserved.
    </footer>
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@stack('scripts')

<script>
// Function untuk membaca dan menghapus notifikasi
function readAndDeleteNotif(notifId, link) {
    // Hapus notifikasi via AJAX
    fetch(`/notifikasi/${notifId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.ok) {
            // Redirect ke link jika ada
            if(link && link !== '#') {
                window.location.href = link;
            } else {
                // Reload halaman untuk update counter
                window.location.reload();
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Tetap redirect meskipun error
        if(link && link !== '#') {
            window.location.href = link;
        }
    });
}
</script>

<script>
    // Toastr configuration
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };

    // Show success message
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    // Show error message
    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    // Show info message
    @if(session('info'))
        toastr.info("{{ session('info') }}");
    @endif

    // Show warning message
    @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif
</script>

</body>
</html>
