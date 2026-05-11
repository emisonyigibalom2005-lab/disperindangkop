<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | {{ app_name() }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ app_favicon() }}">

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
    <!-- Admin Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    
    <!-- Petugas Custom Style -->
    @if(auth()->check() && auth()->user()->isPetugas())
    <link rel="stylesheet" href="{{ asset('css/petugas-style.css') }}">
    @endif

    @stack('styles')

    <!-- Dynamic Theme Colors from Settings -->
    <style>
        :root {
            --color-primary: {{ theme_color('primary') }};
            --color-secondary: {{ theme_color('secondary') }};
            --color-sidebar: {{ theme_color('sidebar') }};
            --color-success: {{ theme_color('success') }};
            --color-warning: {{ theme_color('warning') }};
            --color-danger: {{ theme_color('danger') }};
        }
        
        /* Apply theme colors */
        .brand-link { 
            background: var(--color-sidebar) !important; 
        }
        
        @php
            $role = auth()->user()->role ?? "admin";
            
            // Navbar theme colors for petugas
            $navbarThemes = [
                'dark-blue' => '#1a3a6e',
                'navy' => '#1e3a8a',
                'teal' => '#0d9488',
                'purple' => '#7c3aed',
                'dark-gray' => '#374151',
                'green' => '#059669',
            ];
            
            $petugasNavbarColor = '#1a3a6e'; // default
            if ($role === 'petugas' && auth()->user()->navbar_theme) {
                $petugasNavbarColor = $navbarThemes[auth()->user()->navbar_theme] ?? '#1a3a6e';
            }
            
            // Get Pimpinan custom theme
            $pimpinanTheme = null;
            if ($role === 'pimpinan') {
                $pimpinanTheme = get_pimpinan_theme();
            }
            
            $themes = [
                "admin"    => ["sidebar"=>"var(--color-sidebar)", "header"=>"var(--color-primary)", "accent"=>"var(--color-warning)", "label"=>"Administrator"],
                "pimpinan" => [
                    "sidebar" => $pimpinanTheme ? $pimpinanTheme['sidebar_color'] : "var(--color-sidebar)", 
                    "header" => $pimpinanTheme ? $pimpinanTheme['navbar_color'] : "var(--color-primary)", 
                    "accent" => $pimpinanTheme ? $pimpinanTheme['accent_color'] : "var(--color-warning)", 
                    "primary" => $pimpinanTheme ? $pimpinanTheme['primary_color'] : "#3498db",
                    "hover" => $pimpinanTheme ? $pimpinanTheme['hover_color'] : "#1abc9c",
                    "text" => $pimpinanTheme ? $pimpinanTheme['text_color'] : "#ffffff",
                    "label" => "Pimpinan"
                ],
                "petugas"  => ["sidebar"=>$petugasNavbarColor, "header"=>$petugasNavbarColor, "accent"=>"#2c5282", "label"=>"Petugas"],
                "koperasi" => ["sidebar"=>"#6e2f1a", "header"=>"#a04000", "accent"=>"#f39c12", "label"=>"Pelaku Koperasi"],
                "anggota"  => ["sidebar"=>"#2c5282", "header"=>"#2c5282", "accent"=>"#1e3a8a", "label"=>"Anggota Koperasi"],
            ];
            $theme = $themes[$role] ?? $themes["admin"];
        @endphp
        
        .main-sidebar { 
            background: {{ $theme["sidebar"] }} !important; 
        }
        
        @if($role === 'pimpinan' && $pimpinanTheme)
        /* Pimpinan Custom Theme */
        .main-sidebar {
            background: {{ $pimpinanTheme['sidebar_color'] }} !important;
        }
        
        .main-header.navbar {
            background: linear-gradient(135deg, {{ $pimpinanTheme['navbar_color'] }} 0%, {{ $pimpinanTheme['navbar_color'] }}dd 100%) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background-color: {{ $pimpinanTheme['primary_color'] }} !important;
            border-color: {{ $pimpinanTheme['primary_color'] }} !important;
        }
        
        .btn-primary:hover {
            background-color: {{ $pimpinanTheme['hover_color'] }} !important;
            border-color: {{ $pimpinanTheme['hover_color'] }} !important;
        }
        
        .badge-primary,
        .bg-primary {
            background-color: {{ $pimpinanTheme['primary_color'] }} !important;
        }
        
        .text-primary {
            color: {{ $pimpinanTheme['primary_color'] }} !important;
        }
        
        .nav-sidebar .nav-link {
            color: {{ $pimpinanTheme['text_color'] }} !important;
        }
        
        .nav-sidebar .nav-link.active,
        .nav-sidebar .nav-link:hover {
            background: {{ $pimpinanTheme['hover_color'] }} !important;
            color: {{ $pimpinanTheme['text_color'] }} !important;
        }
        
        .brand-link {
            background: {{ $pimpinanTheme['sidebar_color'] }} !important;
            color: {{ $pimpinanTheme['text_color'] }} !important;
        }
        
        a {
            color: {{ $pimpinanTheme['primary_color'] }};
        }
        
        a:hover {
            color: {{ $pimpinanTheme['hover_color'] }};
        }
        
        /* Navbar items untuk Pimpinan */
        .main-header .nav-link[data-widget="pushmenu"] {
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .main-header .nav-link[data-widget="pushmenu"]:hover {
            background: rgba(255,255,255,0.2);
        }
        @endif
        
        @if($role === 'anggota')
        /* Anggota Custom Theme - Dark Blue Theme (Sesuai Gambar) */
        .main-sidebar {
            background: #2c5282 !important;
        }
        
        .main-header.navbar {
            background: linear-gradient(135deg, #2c5282 0%, #1e3a8a 100%) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        /* Ensure ALL nav-links have consistent styling */
        .nav-sidebar .nav-link {
            color: rgba(255,255,255,0.9) !important;
            background: transparent !important;
            transition: all 0.2s ease;
        }
        
        /* Hover state - same for all menu items */
        .nav-sidebar .nav-link:hover {
            background: rgba(255,255,255,0.15) !important;
            color: #ffffff !important;
            transform: translateX(3px);
        }
        
        /* Active state - SAME background for ALL menu items including Chat */
        .nav-sidebar .nav-link.active {
            background: rgba(255,255,255,0.2) !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            font-weight: 600;
        }
        
        /* Ensure Chat menu has EXACTLY the same styling as other menus */
        .nav-sidebar .nav-item a[href*="chat"] {
            background: transparent !important;
        }
        
        .nav-sidebar .nav-item a[href*="chat"]:hover {
            background: rgba(255,255,255,0.15) !important;
        }
        
        .nav-sidebar .nav-item a[href*="chat"].active {
            background: rgba(255,255,255,0.2) !important;
        }
        
        /* Brand link */
        .brand-link {
            background: #2c5282 !important;
            color: #ffffff !important;
        }
        
        /* Primary buttons - tetap biru gelap */
        .btn-primary {
            background-color: #2c5282 !important;
            border-color: #2c5282 !important;
        }
        
        .btn-primary:hover {
            background-color: #1e3a8a !important;
            border-color: #1e3a8a !important;
        }
        
        /* Badge colors */
        .badge-primary,
        .bg-primary {
            background-color: #2c5282 !important;
        }
        
        .text-primary {
            color: #2c5282 !important;
        }
        
        /* Links */
        a {
            color: #2c5282;
        }
        
        a:hover {
            color: #1e3a8a;
        }
        
        /* Navbar toggle button */
        .main-header .nav-link[data-widget="pushmenu"] {
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .main-header .nav-link[data-widget="pushmenu"]:hover {
            background: rgba(255,255,255,0.2);
        }
        @endif
        
        /* Primary color applications */
        .btn-primary,
        .badge-primary,
        .bg-primary {
            background-color: var(--color-primary) !important;
            border-color: var(--color-primary) !important;
        }
        
        .text-primary {
            color: var(--color-primary) !important;
        }
        
        /* Secondary color */
        .btn-secondary,
        .badge-secondary,
        .bg-secondary {
            background-color: var(--color-secondary) !important;
            border-color: var(--color-secondary) !important;
        }
        
        /* Success color */
        .btn-success,
        .badge-success,
        .bg-success {
            background-color: var(--color-success) !important;
            border-color: var(--color-success) !important;
        }
        
        /* Warning color */
        .btn-warning,
        .badge-warning,
        .bg-warning {
            background-color: var(--color-warning) !important;
            border-color: var(--color-warning) !important;
        }
        
        /* Danger color */
        .btn-danger,
        .badge-danger,
        .bg-danger {
            background-color: var(--color-danger) !important;
            border-color: var(--color-danger) !important;
        }
        
        /* Links */
        a {
            color: var(--color-primary);
        }
        
        a:hover {
            color: var(--color-secondary);
        }
        
        /* Active nav items */
        .nav-pills .nav-link.active,
        .nav-sidebar .nav-link.active {
            background-color: var(--color-primary) !important;
        }

        .nav-sidebar .nav-link { color: rgba(255,255,255,.8) !important; }
        .nav-sidebar .nav-link.active,
        .nav-sidebar .nav-link:hover { background: rgba(255,255,255,.15) !important; color: #fff !important; border-radius: 6px; }
        
        /* Logout button styling - Make it more visible */
        .nav-sidebar .nav-link.text-danger {
            color: #ffffff !important;
            background: rgba(220, 53, 69, 0.2) !important;
            font-weight: 700 !important;
            border: 2px solid rgba(220, 53, 69, 0.5) !important;
            border-radius: 8px !important;
        }
        
        .nav-sidebar .nav-link.text-danger:hover {
            background: rgba(220, 53, 69, 0.4) !important;
            border-color: rgba(220, 53, 69, 0.8) !important;
            color: #ffffff !important;
            transform: translateX(5px) !important;
        }
        
        .nav-sidebar .nav-link.text-danger .nav-icon {
            color: #ffffff !important;
        }
        
        .nav-sidebar .nav-link.text-danger p {
            color: #ffffff !important;
            font-weight: 700 !important;
        }
        .nav-sidebar .nav-treeview { background: rgba(0,0,0,.15) !important; }
        .main-header.navbar { background: {{ $theme["header"] }} !important; }
        .brand-link { background: {{ $theme["sidebar"] }} !important; border-bottom: 1px solid rgba(255,255,255,.1) !important; }
        .role-badge { background: {{ $theme["accent"] }}; color: #ffffff; padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .nav-header { color: rgba(255,255,255,.4) !important; font-size: 10px !important; font-weight: 700 !important; letter-spacing: 1px; }
        .content-wrapper { background: #f4f6f9 !important; }
        .main-header { border-bottom: 1px solid #dee2e6; }
        .card { border-radius: 8px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,.08); }
        
        /* Home Button Hover Effect */
        .content-header .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4) !important;
        }
        
        /* Breadcrumb Styling */
        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            font-size: 18px;
            color: #64748b;
            font-weight: 700;
        }
        
        .breadcrumb-item a {
            color: #3b82f6;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .breadcrumb-item a:hover {
            color: #2563eb;
            text-decoration: underline;
        }
        
        .breadcrumb-item.active {
            color: #475569;
            font-weight: 700;
        }
        .card-header { border-radius: 8px 8px 0 0 !important; font-weight: 600; }
        .btn { border-radius: 6px; font-size: 13px; }
        .badge { font-size: 11px; }
        .small-box { border-radius: 8px; }
        .small-box .icon { overflow: hidden; border-radius: 0 8px 0 0; }
        .table thead th { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; }
        .table tbody td { font-size: 13px; vertical-align: middle; }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-treeview { background: rgba(0,0,0,.15); }
        .brand-link .brand-text { color: #ffffff !important; }
        .brand-text { color: #fff !important; font-size: 14px !important; }
        
        /* Fix dropdown notifikasi tampil di depan sidebar */
        .main-header .dropdown-menu { z-index: 9999 !important; position: absolute !important; }
        .main-header .navbar-nav { z-index: 9999 !important; }
        .main-header { z-index: 1040 !important; }
        .main-sidebar { z-index: 1035 !important; }
        
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
        
        .logo-img { height: 40px; margin-right: 8px; }
        .brand-link { display: flex; align-items: center; }
        .logo-text-wrapper { line-height: 1.2; }
        .logo-text { font-weight: 700; font-size: 13px; display: block; }

        /* ===== STYLE NAVBAR YANG DIPERBAIKI ===== */
        .main-header.navbar {
            background: linear-gradient(135deg, {{ $theme["header"] }} 0%, {{ $theme["header"] }}dd 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0 1rem;
        }

        /* Navbar item styling */
        .main-header .nav-item {
            transition: all 0.3s ease;
        }

        /* Tombol toggle menu */
        .main-header .nav-link[data-widget="pushmenu"] {
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            margin: 8px 0;
            transition: all 0.3s;
        }

        .main-header .nav-link[data-widget="pushmenu"]:hover {
            background: rgba(255,255,255,0.2);
            transform: scale(1.05);
        }

        /* Lokasi badge */
        .location-badge {
            background: rgba(255,255,255,0.15);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin-left: 15px;
            transition: all 0.3s;
        }

        /* ===== SIDEBAR COMPACT & RAPI ===== */
        /* Kurangi padding sidebar */
        .main-sidebar {
            padding-top: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            width: 250px;
        }

        /* Brand link lebih compact dan menarik */
        .brand-link {
            padding: 12px 15px !important;
            height: auto !important;
            border-bottom: 2px solid rgba(255,255,255,0.15) !important;
            transition: all 0.3s;
        }
        
        .brand-link:hover {
            background: rgba(255,255,255,0.05) !important;
        }

        /* User panel lebih compact dan menarik */
        .user-panel {
            padding: 12px 15px !important;
            margin-bottom: 0 !important;
            border-bottom: 2px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.1);
        }

        .user-panel .image {
            margin-right: 10px;
        }
        
        .user-panel .image img {
            width: 35px !important;
            height: 35px !important;
            border: 2px solid rgba(255,255,255,0.3);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .user-panel .info {
            padding: 0;
        }

        .user-panel .info a {
            font-size: 13.5px;
            font-weight: 700;
            line-height: 1.3;
            letter-spacing: 0.3px;
        }

        .user-panel .info p {
            font-size: 10.5px;
            margin: 2px 0 0 0;
            line-height: 1.2;
            opacity: 0.85;
        }

        /* Nav header lebih menarik */
        .nav-header {
            padding: 10px 15px 5px 15px !important;
            margin-top: 10px !important;
            font-size: 9px !important;
            letter-spacing: 2px !important;
            color: rgba(255,255,255,0.45) !important;
            font-weight: 800 !important;
            text-transform: uppercase;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 5px !important;
        }

        /* Nav item lebih rapi dengan spacing yang baik */
        .nav-sidebar > .nav-item {
            margin-bottom: 2px;
        }

        .nav-sidebar .nav-link {
            padding: 8px 12px !important;
            border-radius: 6px;
            margin: 1px 8px;
            transition: all 0.3s ease;
            font-weight: 600;
            position: relative;
            overflow: hidden;
        }
        
        /* Parent menu dengan submenu - BISA DIKLIK */
        .nav-sidebar > .nav-item.menu-open > .nav-link {
            cursor: pointer !important;
            background: rgba(255,255,255,0.05) !important;
            opacity: 0.95;
            margin-bottom: 3px;
            padding: 7px 12px !important;
        }
        
        .nav-sidebar > .nav-item.menu-open > .nav-link:hover {
            background: rgba(255,255,255,0.12) !important;
            transform: translateX(3px) !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15) !important;
        }
        
        /* Efek hover yang menarik - hanya untuk menu yang bisa diklik */
        .nav-sidebar .nav-link:not(.menu-open > .nav-link)::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: rgba(255,255,255,0.1);
            transition: width 0.3s ease;
        }

        .nav-sidebar .nav-link:not(.menu-open > .nav-link):hover::before {
            width: 100%;
        }

        .nav-sidebar .nav-link:not(.menu-open > .nav-link):hover {
            background: rgba(255,255,255,0.15) !important;
            transform: translateX(5px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }

        .nav-sidebar .nav-link.active {
            background: linear-gradient(135deg, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0.15) 100%) !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            border-left: 4px solid rgba(255,255,255,0.5);
            font-weight: 700;
        }

        /* Icon dan text spacing yang lebih baik */
        .nav-sidebar .nav-link .nav-icon {
            margin-right: 10px;
            font-size: 14px;
            width: 20px;
            text-align: center;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .nav-sidebar .nav-link:not(.menu-open > .nav-link):hover .nav-icon {
            transform: scale(1.15);
        }

        .nav-sidebar .nav-link p {
            font-size: 12.5px;
            margin: 0;
            font-weight: 600;
            display: inline-block;
            vertical-align: middle;
            letter-spacing: 0.2px;
        }

        /* Badge di menu lebih menarik */
        .nav-sidebar .badge {
            font-size: 8.5px;
            padding: 2px 6px;
            border-radius: 8px;
            font-weight: 800;
            margin-left: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            animation: pulse-badge 2s infinite;
        }
        
        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* Treeview lebih rapi - SELALU TERLIHAT */
        .nav-treeview {
            padding: 6px 0 !important;
            margin: 3px 8px 8px 8px !important;
            border-radius: 8px;
            background: rgba(0,0,0,0.25) !important;
            border: 1px solid rgba(255,255,255,0.05);
        }

        .nav-treeview > .nav-item > .nav-link {
            padding: 7px 12px 7px 38px !important;
            font-size: 12px;
            border-radius: 5px;
            margin: 2px 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        /* Icon di dropdown/treeview */
        .nav-treeview .nav-icon {
            font-size: 12px !important;
            width: 18px !important;
            margin-right: 10px !important;
            text-align: center;
            display: inline-block;
            transition: all 0.3s;
        }

        /* Icon solid (fas) di dropdown */
        .nav-treeview .fas.nav-icon {
            font-size: 12px !important;
        }

        /* Icon regular (far) di dropdown */
        .nav-treeview .far.nav-icon {
            font-size: 12px !important;
        }

        /* Arrow icon di dropdown parent */
        .nav-sidebar > .nav-item > .nav-link > p > .right {
            transition: transform 0.3s ease;
        }

        .nav-sidebar > .nav-item.menu-open > .nav-link > p > .right {
            transform: rotate(-90deg);
        }

        /* Animasi smooth untuk dropdown */
        .nav-treeview {
            transition: all 0.3s ease-in-out;
        }

        /* ===== STYLING KHUSUS UNTUK PETUGAS DROPDOWN ===== */
        /* Override untuk dropdown Petugas agar lebih jelas */
        .petugas-theme .nav-treeview {
            padding: 10px 0 !important;
            margin: 5px 10px 12px 10px !important;
            border-radius: 10px !important;
            background: rgba(0,0,0,0.4) !important;
            border: 2px solid rgba(255,255,255,0.15) !important;
            box-shadow: inset 0 2px 8px rgba(0,0,0,0.3);
        }

        .petugas-theme .nav-treeview > .nav-item > .nav-link {
            padding: 12px 15px 12px 50px !important;
            font-size: 13.5px !important;
            border-radius: 8px !important;
            margin: 4px 12px !important;
            font-weight: 600 !important;
            background: transparent !important;
            color: rgba(255,255,255,0.95) !important;
        }

        .petugas-theme .nav-treeview > .nav-item > .nav-link:hover {
            background: rgba(255,255,255,0.2) !important;
            color: #ffffff !important;
            transform: translateX(5px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.25);
        }

        .petugas-theme .nav-treeview > .nav-item > .nav-link.active {
            background: rgba(255,255,255,0.3) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            border-left: 4px solid rgba(255,255,255,0.8);
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .petugas-theme .nav-treeview .nav-icon {
            font-size: 15px !important;
            width: 24px !important;
            margin-right: 14px !important;
        }

        /* Styling untuk semua role - Dropdown yang jelas */
        .nav-sidebar .nav-treeview {
            background: rgba(0,0,0,0.35) !important;
            border: 1px solid rgba(255,255,255,0.12) !important;
            border-radius: 8px !important;
            padding: 8px 0 !important;
            margin: 4px 10px 10px 10px !important;
            box-shadow: inset 0 1px 4px rgba(0,0,0,0.2);
        }

        .nav-sidebar .nav-treeview > .nav-item > .nav-link {
            padding: 10px 15px 10px 45px !important;
            margin: 3px 10px !important;
            border-radius: 6px !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            transition: all 0.3s ease;
        }

        .nav-sidebar .nav-treeview > .nav-item > .nav-link:hover {
            background: rgba(255,255,255,0.18) !important;
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .nav-sidebar .nav-treeview > .nav-item > .nav-link.active {
            background: rgba(255,255,255,0.25) !important;
            font-weight: 700 !important;
            border-left: 3px solid rgba(255,255,255,0.7);
        }

        /* Icon di submenu dropdown - lebih jelas dan menonjol */
        .nav-sidebar .nav-treeview .nav-icon {
            font-size: 14px !important;
            width: 22px !important;
            margin-right: 12px !important;
            display: inline-block !important;
            text-align: center !important;
            opacity: 1 !important;
            filter: brightness(1.2) !important;
        }

        /* Arrow icon di parent dropdown - lebih besar dan jelas */
        .nav-sidebar > .nav-item > .nav-link > p > .right {
            font-size: 14px !important;
            margin-left: auto !important;
            opacity: 0.9 !important;
            transition: transform 0.3s ease, opacity 0.3s ease !important;
        }

        .nav-sidebar > .nav-item > .nav-link:hover > p > .right {
            opacity: 1 !important;
        }

        .nav-sidebar > .nav-item.menu-open > .nav-link > p > .right {
            transform: rotate(-90deg) !important;
            opacity: 1 !important;
        }

        /* ===== STYLING KHUSUS DROPDOWN PARENT ===== */
        /* Menu parent dropdown - SELALU TERBUKA */
        .nav-sidebar > .nav-item.menu-is-opening > .nav-link,
        .nav-sidebar > .nav-item.menu-open > .nav-link {
            background: rgba(255,255,255,0.08) !important;
            border-left: none !important;
        }

        /* Sub-menu (treeview) - SELALU TERLIHAT */
        .nav-treeview {
            background: rgba(0,0,0,0.2) !important;
            padding: 6px 0 !important;
            margin: 3px 8px 8px 8px !important;
            border-radius: 6px;
        }

        /* Sub-menu item normal state */
        .nav-treeview > .nav-item > .nav-link {
            background: transparent !important;
            color: rgba(255,255,255,0.9) !important;
            padding: 7px 12px 7px 38px !important;
            font-weight: 500;
        }

        /* Sub-menu item hover state */
        .nav-treeview > .nav-item > .nav-link:hover {
            background: rgba(255,255,255,0.2) !important;
            color: #ffffff !important;
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        .nav-treeview > .nav-item > .nav-link:hover .nav-icon {
            transform: scale(1.12);
        }

        /* Sub-menu item active state */
        .nav-treeview > .nav-item > .nav-link.active {
            background: linear-gradient(135deg, rgba(255,255,255,0.28) 0%, rgba(255,255,255,0.2) 100%) !important;
            color: #ffffff !important;
            font-weight: 700;
            border-left: 3px solid rgba(255,255,255,0.8);
            box-shadow: 0 3px 10px rgba(0,0,0,0.25);
        }

        /* Badge notifikasi di sub-menu */
        .nav-treeview .badge {
            background: #f59e0b !important;
            color: #ffffff !important;
            font-size: 8.5px;
            padding: 2px 6px;
            border-radius: 8px;
            font-weight: 800;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }

        /* Badge warning khusus */
        .nav-treeview .badge-warning {
            background: #f59e0b !important;
            animation: pulse-warning 2s infinite;
        }

        @keyframes pulse-warning {
            0%, 100% { opacity: 1; box-shadow: 0 2px 5px rgba(245, 158, 11, 0.5); }
            50% { opacity: 0.8; box-shadow: 0 2px 10px rgba(245, 158, 11, 0.8); }
        }

        /* Icon di parent dropdown */
        .nav-sidebar > .nav-item > .nav-link > .nav-icon {
            font-size: 15px !important;
        }

        /* Spacing untuk dropdown yang selalu terbuka */
        .nav-sidebar > .nav-item.menu-open {
            margin-bottom: 6px;
        }

        /* Hapus semua border di menu */
        .nav-sidebar .nav-link {
            border: none !important;
            border-right: none !important;
        }

        /* Pastikan tidak ada border saat active kecuali border-left */
        .nav-sidebar .nav-link.active {
            border-right: none !important;
            border-top: none !important;
            border-bottom: none !important;
        }
        
        .nav-treeview .far.nav-icon {
            font-size: 11px !important;
        }

        /* Sub-treeview (nested dropdown) */
        .nav-treeview .nav-treeview .nav-icon {
            font-size: 10px !important;
            width: 16px !important;
        }

        /* Hilangkan spacing berlebih */
        .sidebar {
            padding-bottom: 15px;
        }

        /* Scrollbar sidebar lebih menarik */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }

        /* Logo lebih menarik */
        .logo-img {
            height: 35px;
            margin-right: 8px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }

        .logo-text {
            font-size: 12px;
            line-height: 1.3;
            font-weight: 700;
            letter-spacing: 0.4px;
        }

        /* Hapus margin berlebih */
        .nav-sidebar {
            margin-top: 0;
            padding-top: 3px;
        }

        /* Compact untuk mobile */
        @media (max-width: 768px) {
            .nav-sidebar .nav-link {
                padding: 7px 10px !important;
                margin: 1px 6px;
            }
            
            .nav-header {
                padding: 8px 10px 4px 10px !important;
            }
            
            .nav-sidebar .nav-link .nav-icon {
                font-size: 13px;
                width: 18px;
            }
        }
        }

        .location-badge:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-1px);
        }

        .location-badge i {
            margin-right: 6px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 0.7; }
            50% { opacity: 1; }
            100% { opacity: 0.7; }
        }

        /* Notifikasi bell */
        .nav-link .fa-bell, .nav-link .fa-envelope {
            font-size: 18px;
            transition: all 0.3s;
        }

        .nav-link:hover .fa-bell,
        .nav-link:hover .fa-envelope {
            transform: scale(1.1) rotate(5deg);
        }

        .navbar-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 9px;
            padding: 2px 5px;
            animation: bounce 1s ease infinite;
            font-weight: 700;
            border-radius: 10px;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }

        /* Dropdown menu styling */
        .main-header .dropdown-menu {
            margin-top: 8px;
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            animation: slideDown 0.3s ease;
            border-radius: 10px;
            background: #ffffff !important;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px 10px 0 0;
            font-weight: 700;
            font-size: 12px;
            padding: 10px 15px;
        }

        .dropdown-item {
            transition: all 0.2s;
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 500;
            color: #2c3e50 !important;
        }

        .dropdown-item i {
            font-size: 13px;
            width: 20px;
            text-align: center;
            margin-right: 8px;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }
        
        .dropdown-item.text-danger {
            color: #dc3545 !important;
            font-weight: 600;
        }
        
        .dropdown-item.text-danger:hover {
            background: #fee;
            color: #c82333 !important;
        }
        
        .dropdown-item.text-danger i {
            color: #dc3545 !important;
        }
        
        /* Logout button styling */
        button.dropdown-item {
            width: 100%;
            text-align: left;
            border: none;
            background: transparent;
            cursor: pointer;
        }
        
        button.dropdown-item.text-danger {
            color: #dc3545 !important;
            font-weight: 700;
        }
        
        button.dropdown-item.text-danger:hover {
            background: linear-gradient(135deg, #fee2e2, #fecaca) !important;
            color: #b91c1c !important;
        }

        .dropdown-divider {
            margin: 5px 0;
        }

        /* User profile section */
        .user-dropdown-toggle {
            background: rgba(255,255,255,0.1);
            border-radius: 30px;
            padding: 5px 12px 5px 5px !important;
            transition: all 0.3s;
            margin: 5px 0;
        }

        .user-dropdown-toggle:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-1px);
        }

        .user-dropdown-toggle img {
            border: 2px solid rgba(255,255,255,0.5);
            transition: all 0.3s;
            width: 32px;
            height: 32px;
            object-fit: cover;
        }

        .user-dropdown-toggle:hover img {
            border-color: #fff;
            transform: scale(1.05);
        }

        .user-name {
            font-weight: 600;
            font-size: 13px;
            color: #ffffff !important;
        }

        /* User dropdown chevron */
        .user-dropdown-toggle .fa-chevron-down {
            color: #ffffff !important;
            opacity: 0.7;
        }

        /* Hide default dropdown arrow */
        .user-dropdown-toggle::after {
            display: none !important;
        }

        /* User dropdown menu */
        .user-dropdown-menu {
            border: none !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
            background: #ffffff !important;
        }

        /* User dropdown menu items */
        .user-dropdown-menu .dropdown-item {
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 14px 20px !important;
            transition: all 0.3s ease !important;
            font-size: 15px !important;
            display: flex !important;
            align-items: center !important;
        }

        .user-dropdown-menu .dropdown-item:hover {
            background: #f3f4f6 !important;
            color: #1e3a5f !important;
            transform: translateX(3px);
        }

        .user-dropdown-menu .dropdown-item i {
            font-size: 18px !important;
            width: 28px !important;
            text-align: center !important;
            margin-right: 10px !important;
            flex-shrink: 0 !important;
        }

        .user-dropdown-menu .dropdown-item i.text-primary {
            color: #3b82f6 !important;
        }

        .user-dropdown-menu .dropdown-item i.text-success {
            color: #10b981 !important;
        }

        .user-dropdown-menu .dropdown-item span {
            color: #374151 !important;
            font-weight: 600 !important;
            font-size: 15px !important;
        }

        .user-dropdown-menu .dropdown-item:hover span {
            color: #1e3a5f !important;
        }

        .user-dropdown-menu .dropdown-item.text-danger {
            color: #dc2626 !important;
        }

        .user-dropdown-menu .dropdown-item.text-danger:hover {
            background: #fee2e2 !important;
            color: #b91c1c !important;
        }

        .user-dropdown-menu .dropdown-item.text-danger i {
            color: #dc2626 !important;
        }

        .user-dropdown-menu .dropdown-item.text-danger:hover i {
            color: #b91c1c !important;
        }

        .user-dropdown-menu .dropdown-item.text-danger span {
            color: #dc2626 !important;
            font-weight: 600 !important;
        }

        .user-dropdown-menu .dropdown-item.text-danger:hover span {
            color: #b91c1c !important;
        }

        /* Search box styling (optional) */
        .search-box {
            background: rgba(255,255,255,0.1);
            border-radius: 30px;
            padding: 6px 15px;
            margin-left: 15px;
            transition: all 0.3s;
        }

        .search-box:hover {
            background: rgba(255,255,255,0.2);
        }

        .search-box input {
            background: transparent;
            border: none;
            color: white;
            font-size: 13px;
            width: 180px;
        }

        .search-box input::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .search-box input:focus {
            outline: none;
        }

        .search-box button {
            background: transparent;
            border: none;
            color: white;
            padding: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .location-badge {
                display: none;
            }
            .search-box {
                display: none;
            }
            .user-name {
                display: none;
            }
        }
        
        /* ===== HAPUS BULLET POINTS DI DROPDOWN PETUGAS ===== */
        /* Sembunyikan bullet default AdminLTE */
        .petugas-theme .nav-treeview > .nav-item > .nav-link::before {
            display: none !important;
        }
        
        /* Pastikan icon tidak ada bullet */
        .petugas-theme .nav-treeview .nav-icon::before {
            content: none !important;
            display: none !important;
        }
        
        /* Adjust padding untuk sub-menu tanpa bullet */
        .petugas-theme .nav-treeview > .nav-item > .nav-link {
            padding-left: 50px !important;
        }
        
        /* Icon di sub-menu lebih besar dan jelas */
        .petugas-theme .nav-treeview .nav-icon {
            font-size: 15px !important;
            width: 24px !important;
            margin-right: 12px !important;
            text-align: center !important;
            display: inline-block !important;
        }
        
        /* Text di sub-menu lebih jelas dan rapi */
        .petugas-theme .nav-treeview .nav-link p {
            font-size: 14px !important;
            font-weight: 600 !important;
            letter-spacing: 0.3px !important;
        }
        
        /* Hover effect untuk sub-menu */
        .petugas-theme .nav-treeview .nav-link:hover {
            background: rgba(255,255,255,0.15) !important;
            padding-left: 52px !important;
            transition: all 0.2s ease !important;
        }
        
        /* Active state untuk sub-menu */
        .petugas-theme .nav-treeview .nav-link.active {
            background: rgba(255,255,255,0.2) !important;
            font-weight: 700 !important;
        }
        
        /* Parent menu text lebih jelas */
        .petugas-theme .nav-sidebar > .nav-item > .nav-link p {
            font-size: 14px !important;
            font-weight: 700 !important;
            letter-spacing: 0.3px !important;
        }
        
        /* Icon parent menu lebih besar */
        .petugas-theme .nav-sidebar > .nav-item > .nav-link .nav-icon {
            font-size: 17px !important;
            width: 26px !important;
            margin-right: 12px !important;
        }

        /* ===== FORCE PETUGAS SUBMENU ICONS TO DISPLAY ===== */
        /* Critical fix: Force all submenu icons in Petugas menu to be visible */
        body.petugas-theme .nav-sidebar .nav-treeview .nav-link i.nav-icon {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
            width: 20px !important;
            min-width: 20px !important;
            font-size: 13px !important;
            margin-right: 12px !important;
            text-align: center !important;
            font-weight: 900 !important;
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
        }

        /* Force FontAwesome solid icons to display */
        body.petugas-theme .nav-sidebar .nav-treeview .nav-link i.fas {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }

        /* Force FontAwesome regular icons to display */
        body.petugas-theme .nav-sidebar .nav-treeview .nav-link i.far {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 400 !important;
        }

        /* Specific color overrides for Petugas submenu icons */
        body.petugas-theme .nav-sidebar .nav-treeview .nav-link i.nav-icon[style*="color"] {
            filter: brightness(1.2) saturate(1.3) !important;
        }

        /* Ensure icon container has proper layout */
        body.petugas-theme .nav-sidebar .nav-treeview .nav-link {
            display: flex !important;
            align-items: center !important;
        }

        /* Make sure icon doesn't get hidden by overflow */
        body.petugas-theme .nav-sidebar .nav-treeview {
            overflow: visible !important;
        }

        /* Additional specificity for all icon types */
        body.petugas-theme .nav-sidebar .nav-treeview .nav-item .nav-link .fas.nav-icon,
        body.petugas-theme .nav-sidebar .nav-treeview .nav-item .nav-link .far.nav-icon,
        body.petugas-theme .nav-sidebar .nav-treeview .nav-item .nav-link .fab.nav-icon {
            display: inline-block !important;
            width: 20px !important;
            font-size: 13px !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        /* FALLBACK: Force icons to display even without petugas-theme class */
        /* This ensures icons show regardless of body class */
        .main-sidebar .nav-sidebar .nav-treeview .nav-link i.nav-icon.fas,
        .main-sidebar .nav-sidebar .nav-treeview .nav-link i.nav-icon.far,
        .main-sidebar .nav-sidebar .nav-treeview .nav-link i.nav-icon.fab {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
            width: 20px !important;
            min-width: 20px !important;
            font-size: 13px !important;
            margin-right: 12px !important;
            text-align: center !important;
        }

        /* Ensure FontAwesome is loaded properly */
        .main-sidebar .nav-sidebar .nav-treeview i.fas::before,
        .main-sidebar .nav-sidebar .nav-treeview i.far::before,
        .main-sidebar .nav-sidebar .nav-treeview i.fab::before {
            display: inline-block !important;
            font-style: normal !important;
            font-variant: normal !important;
            text-rendering: auto !important;
            -webkit-font-smoothing: antialiased !important;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed @if(auth()->check() && auth()->user()->isPetugas()) petugas-theme @endif">
<div class="wrapper">

    <!-- ═══════════════════════════════════════════
         NAVBAR YANG SUDAH DIRAPIKAN
    ═══════════════════════════════════════════ -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Bagian Kiri: Toggle Menu & Info Lokasi -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-inline-block">
                <div class="location-badge">
                    <i class="fas fa-map-marker-alt text-danger"></i>
                    <span>Kabupaten Tolikara, Papua Pegunungan</span>
                </div>
            </li>
        </ul>

        <!-- Bagian Kanan: Notifikasi, Pesan, & User Profile -->
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
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width:350px">
                    <div class="dropdown-header bg-light py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 font-weight-bold">
                                <i class="fas fa-bell text-warning mr-2"></i>
                                Notifikasi
                            </h6>
                            <span class="badge badge-primary">{{ $unreadCount }} Baru</span>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div style="max-height: 400px; overflow-y: auto;">
                        @forelse(auth()->user()->notifikasi()->limit(5)->get() as $notif)
                            <a href="{{ $notif->url ?? '#' }}" class="dropdown-item py-3 notif-item" data-notif-id="{{ $notif->id }}">
                                <div class="d-flex align-items-start">
                                    <div class="mr-3">
                                        <div class="rounded-circle bg-{{ $notif->jenis ?? 'info' }} p-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-{{ $notif->icon ?? 'bell' }} fa-sm text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1 font-weight-bold" style="font-size:13px">{{ $notif->judul }}</p>
                                        <small class="text-muted">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ $notif->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    @if(!$notif->is_read)
                                        <span class="badge badge-success ml-2">Baru</span>
                                    @endif
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                                <p class="mb-0 text-muted">Tidak ada notifikasi</p>
                                <small class="text-muted">Semua sudah dibaca</small>
                            </div>
                            <div class="dropdown-divider"></div>
                        @endforelse
                    </div>
                    <div class="dropdown-footer text-center p-3">
                        <a href="#" class="text-primary font-weight-bold">
                            Lihat Semua Notifikasi
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </li>

            <!-- Pesan (Optional) -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button">
                    <i class="far fa-envelope"></i>
                    <span class="badge badge-info navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="dropdown-header bg-light">
                        <h6 class="mb-0 font-weight-bold">
                            <i class="fas fa-comments text-info mr-2"></i>
                            Pesan Masuk
                        </h6>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?background=random&name=Admin" class="rounded-circle mr-3" width="40" height="40">
                            <div>
                                <p class="mb-0 font-weight-bold">Admin System</p>
                                <small class="text-muted">Sistem berjalan normal</small>
                            </div>
                            <small class="ml-auto text-muted">2 menit</small>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-footer text-center">
                        <a href="#" class="text-primary">Lihat semua pesan</a>
                    </div>
                </div>
            </li>

            <!-- User Profile Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle user-dropdown-toggle d-flex align-items-center" data-toggle="dropdown" href="#" role="button" style="text-decoration: none;">
                    @php
                        // Cek role dan ambil foto yang sesuai
                        $profilePhoto = null;
                        $userName = auth()->user()->name;
                        $userRole = auth()->user()->role;
                        
                        if (auth()->user()->isAnggota()) {
                            $anggota = auth()->user()->anggota;
                            if ($anggota && $anggota->foto) {
                                $profilePhoto = asset('storage/' . $anggota->foto);
                            }
                        } elseif (method_exists(auth()->user(), 'profile_photo_url')) {
                            $profilePhoto = auth()->user()->profile_photo_url;
                        }
                    @endphp
                    
                    @if($profilePhoto)
                        <img src="{{ $profilePhoto }}"
                             class="img-circle elevation-1 mr-2"
                             style="width: 35px; height: 35px; object-fit: cover; border: 2px solid rgba(255,255,255,0.3);"
                             alt="{{ $userName }}"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="rounded-circle mr-2 d-none align-items-center justify-content-center" 
                             style="width: 35px; height: 35px; background: linear-gradient(135deg, #10b981, #059669); color: white; font-weight: 700; font-size: 16px; border: 2px solid rgba(255,255,255,0.3);">
                            {{ strtoupper(substr($userName, 0, 1)) }}
                        </div>
                    @else
                        <div class="rounded-circle mr-2 d-flex align-items-center justify-content-center" 
                             style="width: 35px; height: 35px; background: linear-gradient(135deg, #10b981, #059669); color: white; font-weight: 700; font-size: 16px; border: 2px solid rgba(255,255,255,0.3);">
                            {{ strtoupper(substr($userName, 0, 1)) }}
                        </div>
                    @endif
                    
                    <span class="user-name d-none d-md-inline-block" style="font-weight: 500;">
                        {{ Str::limit($userName, 20) }}
                    </span>
                    <i class="fas fa-chevron-down ml-2" style="font-size: 11px; opacity: 0.7;"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right user-dropdown-menu" style="min-width: 280px; border-radius: 12px; border: none;">
                    <div class="px-4 py-3" style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%); border-radius: 12px 12px 0 0;">
                        <div class="d-flex align-items-center">
                            @if($profilePhoto)
                                <img src="{{ $profilePhoto }}"
                                     class="img-circle elevation-2 mr-3"
                                     style="width: 50px; height: 50px; object-fit: cover; border: 3px solid white;"
                                     alt="{{ $userName }}"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="rounded-circle mr-3 d-none align-items-center justify-content-center elevation-2" 
                                     style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981, #059669); color: white; font-weight: 700; font-size: 22px; border: 3px solid white;">
                                    {{ strtoupper(substr($userName, 0, 1)) }}
                                </div>
                            @else
                                <div class="rounded-circle mr-3 d-flex align-items-center justify-content-center elevation-2" 
                                     style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981, #059669); color: white; font-weight: 700; font-size: 22px; border: 3px solid white;">
                                    {{ strtoupper(substr($userName, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <p class="mb-0 font-weight-bold text-white" style="font-size: 14px;">{{ $userName }}</p>
                                <span class="badge badge-light mt-1" style="font-size: 11px;">
                                    <i class="fas fa-user-shield mr-1"></i>
                                    {{ auth()->user()->role_label ?? ucfirst($userRole) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="py-2">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.profile') }}" class="dropdown-item py-2">
                                <i class="fas fa-user-cog fa-fw mr-2 text-primary"></i> 
                                <span>Profil Saya</span>
                            </a>
                        @elseif(auth()->user()->isPetugas())
                            <a href="{{ route('petugas.profile') }}" class="dropdown-item py-2">
                                <i class="fas fa-user-cog fa-fw mr-2 text-primary"></i> 
                                <span>Profil Saya</span>
                            </a>
                        @elseif(auth()->user()->isPimpinan())
                            <a href="{{ route('pimpinan.profile') }}" class="dropdown-item py-2">
                                <i class="fas fa-user-cog fa-fw mr-2 text-primary"></i> 
                                <span>Profil Saya</span>
                            </a>
                        @elseif(auth()->user()->isAnggota())
                            <a href="{{ route('anggota.profil') }}" class="dropdown-item py-2">
                                <i class="fas fa-user-cog fa-fw mr-2 text-primary"></i> 
                                <span>Profil Saya</span>
                            </a>
                            <a href="{{ route('anggota.kartu') }}" class="dropdown-item py-2">
                                <i class="fas fa-id-card fa-fw mr-2 text-success"></i> 
                                <span>Kartu Anggota</span>
                            </a>
                        @else
                            <a href="{{ route('koperasi.profile') }}" class="dropdown-item py-2">
                                <i class="fas fa-user-cog fa-fw mr-2 text-primary"></i> 
                                <span>Profil Saya</span>
                            </a>
                        @endif
                    </div>
                    
                    <div class="dropdown-divider my-0"></div>
                    
                    <form method="POST" action="{{ route('logout') }}" id="logout-form-navbar">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger py-2">
                            <i class="fas fa-sign-out-alt fa-fw mr-2"></i> 
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- ═══════════════════════════════════════════
         SIDEBAR (Sama seperti sebelumnya)
    ═══════════════════════════════════════════ -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('dashboard') }}" class="brand-link px-3 d-flex align-items-center">
            <img src="{{ app_logo() }}" alt="Logo {{ app_name() }}" class="logo-img" style="height: 40px; margin-right: 8px;">
            <div class="logo-text-wrapper d-none d-md-block">
                <span class="logo-text" style="font-weight: 700; font-size: 13px; display: block;">{{ app_name() }}</span>
                <small style="font-size:10px; opacity:.75; font-weight:400">{{ setting('app_short_name', 'Kab. Tolikara') }}</small>
            </div>
        </a>

        <div class="sidebar">
            <!-- Menu Navigasi -->
            <nav class="mt-3">
                <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent"
                    data-widget="treeview" role="menu" data-accordion="false">

                    {{-- ═══════════ ADMIN MENU ═══════════ --}}
                    @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; padding: 12px 15px 6px 15px; margin-top: 12px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 5px;">MANAJEMEN KOPERASI</li>
                    <li class="nav-item {{ request()->routeIs('admin.anggota*') || request()->routeIs('admin.periode-pendaftaran*') || request()->routeIs('admin.kartu-sertifikat') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.anggota*') || request()->routeIs('admin.periode-pendaftaran*') || request()->routeIs('admin.kartu-sertifikat') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600;">
                            <i class="nav-icon fas fa-building" style="color: #4299e1; font-size: 17px;"></i>
                            <p style="font-weight: 600;">Manajemen Data Koperasi
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="padding-left: 15px;">
                            <li class="nav-item">
                                <a href="{{ route('admin.anggota.index') }}" class="nav-link {{ request()->routeIs('admin.anggota.index') || request()->routeIs('admin.anggota.show') || request()->routeIs('admin.anggota.edit') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-users nav-icon" style="font-size: 13px; color: #60a5fa;"></i>
                                    <p style="font-size: 13px;">Data Anggota Koperasi
                                        @php 
                                            $pendingAnggotaCount = \App\Models\Anggota::where('status', 'Pending')->count();
                                        @endphp
                                        @if($pendingAnggotaCount > 0)
                                            <span class="badge badge-warning right" style="border-radius: 10px; font-size: 10px;">{{ $pendingAnggotaCount }}</span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.anggota.create') }}" class="nav-link {{ request()->routeIs('admin.anggota.create') || request()->routeIs('admin.anggota.store') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-user-plus nav-icon" style="font-size: 13px; color: #34d399;"></i>
                                    <p style="font-size: 13px;">Daftar Anggota Baru</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.anggota-koperasi.index') }}" class="nav-link {{ request()->routeIs('admin.anggota-koperasi*') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-user-friends nav-icon" style="font-size: 13px; color: #f472b6;"></i>
                                    <p style="font-size: 13px;">Anggota Koperasi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.anggota.verifikasi') }}" class="nav-link {{ request()->routeIs('admin.anggota.verifikasi') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-user-check nav-icon" style="font-size: 13px; color: #fbbf24;"></i>
                                    <p style="font-size: 13px;">Verifikasi Pendaftaran</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.kartu-sertifikat') }}" class="nav-link {{ request()->routeIs('admin.kartu-sertifikat') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-id-card nav-icon" style="font-size: 13px; color: #a78bfa;"></i>
                                    <p style="font-size: 13px;">Kartu & Sertifikat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.periode-pendaftaran.index') }}" class="nav-link {{ request()->routeIs('admin.periode-pendaftaran*') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-calendar-check nav-icon" style="font-size: 13px; color: #fb923c;"></i>
                                    <p style="font-size: 13px;">Periode Pendaftaran</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; padding: 12px 15px 6px 15px; margin-top: 12px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 5px;">DISTRIBUSI BANTUAN</li>
                    <li class="nav-item {{ request()->routeIs('admin.bantuan*') || request()->routeIs('admin.penerima-bantuan*') || request()->routeIs('admin.pengajuan-bantuan*') || request()->routeIs('admin.periode-bantuan*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.pengajuan-bantuan*') || request()->routeIs('admin.periode-bantuan*') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600;">
                            <i class="nav-icon fas fa-hand-holding-usd" style="color: #48bb78; font-size: 17px;"></i>
                            <p style="font-weight: 600;">Bantuan
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="padding-left: 15px;">
                             <li class="nav-item">
                                <a href="{{ route('admin.pengajuan-bantuan.index') }}" class="nav-link {{ request()->routeIs('admin.pengajuan-bantuan*') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-file-alt nav-icon" style="font-size: 13px; color: #fbbf24;"></i><p style="font-size: 13px;">Data Pengajuan bantuan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.periode-bantuan.index') }}" class="nav-link {{ request()->routeIs('admin.periode-bantuan*') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-calendar-check nav-icon" style="font-size: 13px; color: #fb923c;"></i><p style="font-size: 13px;">Periode Bantuan</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; padding: 12px 15px 6px 15px; margin-top: 12px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 5px;">JADWAL KEGIATAN</li>
                    <li class="nav-item {{ request()->routeIs('admin.jadwal*') || request()->routeIs('admin.struktur*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.jadwal*') || request()->routeIs('admin.struktur*') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600;">
                            <i class="nav-icon fas fa-calendar-alt" style="color: #ed8936; font-size: 17px;"></i>
                            <p style="font-weight: 600;">Jadwal Kegiatan
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="padding-left: 15px;">
                            <li class="nav-item">
                                <a href="{{ route('admin.jadwal.index') }}" class="nav-link {{ request()->routeIs('admin.jadwal*') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-calendar-alt nav-icon" style="font-size: 13px; color: #60a5fa;"></i><p style="font-size: 13px;">Jadwal Kegiatan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.struktur.index') }}" class="nav-link {{ request()->routeIs('admin.struktur.index') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-user-tie nav-icon" style="font-size: 13px; color: #34d399;"></i><p style="font-size: 13px;">Struktur Organisasi</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; padding: 12px 15px 6px 15px; margin-top: 12px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 5px;">KOMUNIKASI</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.chat.index') }}" class="nav-link {{ request()->routeIs('admin.chat*') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600;">
                            <i class="nav-icon fas fa-comments" style="color: #9f7aea; font-size: 17px;"></i>
                            <p style="font-weight: 600;">Chat & Pesan
                                @php 
                                    $unreadChats = \App\Models\Chat::where('penerima_id', auth()->id())->where('is_read', false)->count();
                                @endphp
                                @if($unreadChats > 0)
                                    <span class="badge badge-warning right" style="border-radius: 10px; font-size: 10px;">{{ $unreadChats }}</span>
                                @endif
                            </p>
                        </a>
                    </li>

                    <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; padding: 12px 15px 6px 15px; margin-top: 12px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 5px;">INFORMASI</li>
                    <li class="nav-item {{ request()->routeIs('admin.berita*') || request()->routeIs('admin.pengumuman*') || request()->routeIs('admin.kontak*') || request()->routeIs('admin.visi-misi*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.berita*') || request()->routeIs('admin.pengumuman*') || request()->routeIs('admin.kontak*') || request()->routeIs('admin.visi-misi*') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600;">
                            <i class="nav-icon fas fa-newspaper" style="color: #667eea; font-size: 17px;"></i>
                            <p style="font-weight: 600;">Modul Informasi
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="padding-left: 15px;">
                            <li class="nav-item">
                                <a href="{{ route('admin.berita.index') }}" class="nav-link {{ request()->routeIs('admin.berita.index') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-newspaper nav-icon" style="font-size: 13px; color: #60a5fa;"></i><p style="font-size: 13px;">Berita</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.pengumuman.index') }}" class="nav-link {{ request()->routeIs('admin.pengumuman*') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-bullhorn nav-icon" style="font-size: 13px; color: #fbbf24;"></i><p style="font-size: 13px;">Pengumuman</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.kontak.index') }}" class="nav-link {{ request()->routeIs('admin.kontak*') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-envelope nav-icon" style="font-size: 13px; color: #34d399;"></i><p style="font-size: 13px;">Pesan Masuk</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.visi-misi.index') }}" class="nav-link {{ request()->routeIs('admin.visi-misi*') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-bullseye nav-icon" style="font-size: 13px; color: #a78bfa;"></i><p style="font-size: 13px;">Visi & Misi</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-item {{ request()->routeIs('admin.galeri-foto*') || request()->routeIs('admin.galeri-video*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.galeri-foto*') || request()->routeIs('admin.galeri-video*') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600;">
                            <i class="nav-icon fas fa-images" style="color: #f687b3; font-size: 17px;"></i>
                            <p style="font-weight: 600;">Galeri
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="padding-left: 15px;">
                            <li class="nav-item">
                                <a href="{{ route('admin.galeri-foto.index') }}" class="nav-link {{ request()->routeIs('admin.galeri-foto*') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-image nav-icon" style="font-size: 13px; color: #60a5fa;"></i>
                                    <p style="font-size: 13px;">Daftar Foto</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.galeri-video.index') }}" class="nav-link {{ request()->routeIs('admin.galeri-video*') ? 'active' : '' }}" style="border-radius: 6px; margin: 2px 8px;">
                                    <i class="fas fa-video nav-icon" style="font-size: 13px; color: #f472b6;"></i>
                                    <p style="font-size: 13px;">Daftar Video</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    {{-- <li class="nav-item {{ request()->routeIs('admin.kontak*') || request()->routeIs('admin.halaman-statis*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.kontak*') || request()->routeIs('admin.halaman-statis*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-address-book"></i>
                            <p>Kontak <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                {{-- <a href="{{ route('admin.kontak.index') }}" class="nav-link {{ request()->routeIs('admin.kontak*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Pesan Masuk</p>
                                </a> --}}
                            {{-- </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.halaman-statis.index') }}" class="nav-link {{ request()->routeIs('admin.halaman-statis*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Profil</p>
                                </a>
                            </li>
                        </ul>
                    </li> --}} 

                    <li class="nav-header"></li>
                    <li class="nav-item {{ request()->routeIs('admin.anggota*') || request()->routeIs('admin.periode-pendaftaran*') ? 'menu-open' : '' }}">
                        {{-- <a href="#" class="nav-link {{ request()->routeIs('admin.anggota*') || request()->routeIs('admin.periode-pendaftaran*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Manajemen Data Anggota <i class="fas fa-angle-left right"></i></p>
                        </a> --}}
                        <ul class="nav nav-treeview">
                            {{-- <li class="nav-item">
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
                                <a href="{{ route('admin.anggota.verifikasi') }}" class="nav-link {{ request()->routeIs('admin.anggota.verifikasi') ? 'active' : '' }}">
                                    <i class="fas fa-user-check nav-icon"></i><p>Verifikasi Pendaftaran</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                {{-- <a href="{{ route('admin.anggota.dokumen') }}" class="nav-link {{ request()->routeIs('admin.anggota.dokumen') ? 'active' : '' }}">
                                    <i class="fas fa-file-alt nav-icon"></i><p>Dokumen Anggota</p>
                                </a> --}}
                            {{-- </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.kartu-sertifikat') }}" class="nav-link {{ request()->routeIs('admin.kartu-sertifikat') ? 'active' : '' }}">
                                    <i class="fas fa-id-card nav-icon"></i><p> Dokumen Kartu & Sertifikat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.periode-pendaftaran.index') }}" class="nav-link {{ request()->routeIs('admin.periode-pendaftaran*') ? 'active' : '' }}">
                                    <i class="fas fa-calendar-check nav-icon"></i><p>Periode Pendaftaran</p>
                                </a>
                            </li> --}} 
                        </ul>
                    </li>

                    {{-- <li class="nav-header">Modul LAYANAN</li>
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
                    </li> --}}

                    <li class="nav-header">MONITORING</li>
                    <li class="nav-item {{ request()->routeIs('admin.laporan*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p> Modul Monitorin & Laporan <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.laporan.koperasi') }}" class="nav-link {{ request()->routeIs('admin.laporan.koperasi') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Rekap Data Anggota Koperasi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.laporan.bantuan') }}" class="nav-link {{ request()->routeIs('admin.laporan.bantuan') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Rekap Data Bantuan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                {{-- <a href="{{ route('admin.laporan.sertifikat') }}" class="nav-link {{ request()->routeIs('admin.laporan.sertifikat*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Sertifikat Koperasi</p>
                                </a> --}}
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
                        <a href="{{ route('admin.izin-akses.index') }}" class="nav-link {{ request()->routeIs('admin.izin-akses*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shield-alt"></i><p>Izin Akses</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i><p>Pengaturan Sistem</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.activityLog') }}" class="nav-link {{ request()->routeIs('admin.users.activityLog') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i><p>Log Aktivitas</p>
                        </a>
                    </li>

                    <li class="nav-header">AKUN</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-circle"></i><p>Profil Saya</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar-admin">
                            @csrf
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar-admin').submit();" 
                               class="nav-link text-danger">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Keluar</p>
                            </a>
                        </form>
                    </li>

                    {{-- ═══════════ PETUGAS MENU ═══════════ --}}
                    @elseif(auth()->user()->isPetugas())
                    <li class="nav-item">
                        <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px;">
                            <i class="nav-icon fas fa-tachometer-alt" style="color: #60a5fa; font-size: 17px;"></i>
                            <p style="font-weight: 600;">Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; padding: 12px 15px 6px 15px; margin-top: 12px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 5px;">MANAJEMEN KOPERASI</li>
                    
                    <li class="nav-item {{ request()->routeIs('petugas.anggota-koperasi*') || request()->routeIs('petugas.anggota*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('petugas.anggota-koperasi*') || request()->routeIs('petugas.anggota*') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center;">
                                <i class="nav-icon fas fa-users" style="color: #4299e1; font-size: 17px; margin-right: 10px;"></i>
                                <span style="font-weight: 600;">Data Anggota Koperasi</span>
                            </div>
                            <i class="fas fa-chevron-down" style="font-size: 14px; color: rgba(255,255,255,0.8); transition: transform 0.3s;"></i>
                        </a>
                        <ul class="nav nav-treeview" style="padding-left: 0; background: rgba(0,0,0,0.3); margin: 5px 10px; border-radius: 8px; padding: 8px 0;">
                            <li class="nav-item">
                                <a href="{{ route('petugas.anggota-koperasi.index') }}" class="nav-link {{ request()->routeIs('petugas.anggota-koperasi*') ? 'active' : '' }}" style="border-radius: 6px; margin: 3px 10px; padding: 10px 15px; display: flex; align-items: center;">
                                    <span style="font-size: 16px; margin-right: 12px; width: 20px; text-align: center;">📋</span>
                                    <p style="font-size: 13px; margin: 0; font-weight: 500;">Daftar Anggota Koperasi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('petugas.anggota.create') }}" class="nav-link {{ request()->routeIs('petugas.anggota.create') || request()->routeIs('petugas.anggota.store') ? 'active' : '' }}" style="border-radius: 6px; margin: 3px 10px; padding: 10px 15px; display: flex; align-items: center;">
                                    <span style="font-size: 16px; margin-right: 12px; width: 20px; text-align: center;">➕</span>
                                    <p style="font-size: 13px; margin: 0; font-weight: 500;">Daftar Anggota Baru</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; padding: 12px 15px 6px 15px; margin-top: 12px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 5px;">BANTUAN</li>
                    <li class="nav-item">
                        <a href="{{ route('petugas.bantuan.index') }}" class="nav-link {{ request()->routeIs('petugas.bantuan*') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600;">
                            <i class="nav-icon fas fa-hand-holding-usd" style="color: #48bb78; font-size: 17px;"></i>
                            <p style="font-weight: 600;">Distribusi Bantuan</p>
                        </a>
                    </li>
                    
                    <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; padding: 12px 15px 6px 15px; margin-top: 12px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 5px;">JADWAL</li>
                    <li class="nav-item">
                        <a href="{{ route('petugas.jadwal.index') }}" class="nav-link {{ request()->routeIs('petugas.jadwal*') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600;">
                            <i class="nav-icon fas fa-calendar-check" style="color: #ed8936; font-size: 17px;"></i>
                            <p style="font-weight: 600;">Jadwal Kegiatan</p>
                        </a>
                    </li>
                    
                    <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; padding: 12px 15px 6px 15px; margin-top: 12px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 5px;">PUBLIKASI</li>
                    <li class="nav-item {{ request()->routeIs('petugas.pengumuman*') || request()->routeIs('petugas.berita*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('petugas.pengumuman*') || request()->routeIs('petugas.berita*') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center;">
                                <i class="nav-icon fas fa-newspaper" style="color: #667eea; font-size: 17px; margin-right: 10px;"></i>
                                <span style="font-weight: 600;">Modul Informasi</span>
                            </div>
                            <i class="fas fa-chevron-down" style="font-size: 14px; color: rgba(255,255,255,0.8); transition: transform 0.3s;"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="padding-left: 0; background: rgba(0,0,0,0.3); margin: 5px 10px; border-radius: 8px; padding: 8px 0;">
                            <li class="nav-item">
                                <a href="{{ route('petugas.pengumuman.index') }}" class="nav-link {{ request()->routeIs('petugas.pengumuman*') ? 'active' : '' }}" style="border-radius: 6px; margin: 3px 10px; padding: 10px 15px; display: flex; align-items: center;">
                                    <span style="font-size: 16px; margin-right: 12px; width: 20px; text-align: center;">📢</span>
                                    <p style="font-size: 13px; margin: 0; font-weight: 500;">Pengumuman</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('petugas.berita.index') }}" class="nav-link {{ request()->routeIs('petugas.berita*') ? 'active' : '' }}" style="border-radius: 6px; margin: 3px 10px; padding: 10px 15px; display: flex; align-items: center;">
                                    <span style="font-size: 16px; margin-right: 12px; width: 20px; text-align: center;">📰</span>
                                    <p style="font-size: 13px; margin: 0; font-weight: 500;">Berita</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; padding: 12px 15px 6px 15px; margin-top: 12px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 5px;">KOMUNIKASI</li>
                    <li class="nav-item">
                        <a href="{{ route('petugas.chat.index') }}" class="nav-link {{ request()->routeIs('petugas.chat*') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600;">
                            <i class="nav-icon fas fa-comments" style="color: #9f7aea; font-size: 17px;"></i>
                            <p style="font-weight: 600;">Chat & Pesan
                                @php 
                                    $unreadPetugasChats = \App\Models\Chat::where('penerima_id', auth()->id())->where('is_read', false)->count();
                                @endphp
                                @if($unreadPetugasChats > 0)
                                    <span class="badge badge-warning right" style="border-radius: 10px; font-size: 10px;">{{ $unreadPetugasChats }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('petugas.kontak.index') }}" class="nav-link {{ request()->routeIs('petugas.kontak*') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600;">
                            <i class="nav-icon fas fa-envelope" style="color: #9f7aea; font-size: 17px;"></i>
                            <p style="font-weight: 600;">Pesan Kontak</p>
                        </a>
                    </li>
                    
                    <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; padding: 12px 15px 6px 15px; margin-top: 12px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 5px;">PENGATURAN</li>
                    <li class="nav-item">
                        <a href="{{ route('petugas.settings.index') }}" class="nav-link {{ request()->routeIs('petugas.settings*') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600;">
                            <i class="nav-icon fas fa-cog" style="color: #718096; font-size: 17px;"></i>
                            <p style="font-weight: 600;">Pengaturan Sistem</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('petugas.activity-log.index') }}" class="nav-link {{ request()->routeIs('petugas.activity-log*') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600;">
                            <i class="nav-icon fas fa-history" style="color: #718096; font-size: 17px;"></i>
                            <p style="font-weight: 600;">Log Aktivitas</p>
                        </a>
                    </li>

                    <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; padding: 12px 15px 6px 15px; margin-top: 12px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 5px;">AKUN</li>
                    <li class="nav-item">
                        <a href="{{ route('petugas.profile') }}" class="nav-link {{ request()->routeIs('petugas.profile') ? 'active' : '' }}" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600;">
                            <i class="nav-icon fas fa-user-circle" style="color: #805ad5; font-size: 17px;"></i>
                            <p style="font-weight: 600;">Profil Saya</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar-petugas">
                            @csrf
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar-petugas').submit();" 
                               class="nav-link" style="border-radius: 8px; margin: 2px 10px; padding: 10px 15px; font-weight: 600; background: rgba(220, 53, 69, 0.15); color: #ffffff !important;">
                                <i class="nav-icon fas fa-sign-out-alt" style="color: #fc8181; font-size: 17px;"></i>
                                <p style="font-weight: 600;">Keluar</p>
                            </a>
                        </form>
                    </li>

                    {{-- ═══════════ PIMPINAN MENU ═══════════ --}}
                    @elseif(auth()->user()->isPimpinan())
                    <li class="nav-item">
                        <a href="{{ route('pimpinan.dashboard') }}" class="nav-link {{ request()->routeIs('pimpinan.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                        </a>
                    </li>
                    
                    @if(can_view('anggota'))
                    <li class="nav-header">DATA KOPERASI</li>
                    <li class="nav-item">
                        <a href="{{ route('pimpinan.anggota-koperasi.index') }}" class="nav-link {{ request()->routeIs('pimpinan.anggota-koperasi*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i><p>Data Anggota Koperasi</p>
                        </a>
                    </li>
                    @endif
                    
                    @if(can_view('laporan'))
                    <li class="nav-header">LAPORAN</li>
                    <li class="nav-item {{ request()->routeIs('pimpinan.laporan*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('pimpinan.laporan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Rekap & Laporan <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('pimpinan.laporan.koperasi') }}" class="nav-link {{ request()->routeIs('pimpinan.laporan.koperasi') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Rekap Anggota Koperasi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pimpinan.laporan.bantuan') }}" class="nav-link {{ request()->routeIs('pimpinan.laporan.bantuan') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i><p>Rekap Bantuan</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    
                    @if(can_view('jadwal'))
                    <li class="nav-header">JADWAL</li>
                    <li class="nav-item">
                        <a href="{{ route('pimpinan.jadwal.index') }}" class="nav-link {{ request()->routeIs('pimpinan.jadwal*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i><p>Jadwal Kegiatan</p>
                        </a>
                    </li>
                    @endif
                    
                    @if(can_view('chat'))
                    <li class="nav-header">KOMUNIKASI</li>
                    <li class="nav-item">
                        <a href="{{ route('pimpinan.chat.index') }}" class="nav-link {{ request()->routeIs('pimpinan.chat*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>Chat & Pesan</p>
                        </a>
                    </li>
                    @endif
                    
                    <li class="nav-header">AKSES</li>
                    <li class="nav-item">
                        <a href="{{ route('pimpinan.pengumuman.index') }}" class="nav-link {{ request()->routeIs('pimpinan.pengumuman*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bullhorn"></i>
                            <p>Pengumuman</p>
                        </a>
                    </li>
                    
                    @if(can_view('laporan'))
                    <li class="nav-header">MONITORING</li>
                    <li class="nav-item">
                        <a href="{{ route('pimpinan.activity.log') }}" class="nav-link {{ request()->routeIs('pimpinan.activity.log') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Log Aktivitas</p>
                        </a>
                    </li>
                    @endif
                    
                    <li class="nav-header">AKUN</li>
                    <li class="nav-item">
                        <a href="{{ route('pimpinan.profile') }}" class="nav-link {{ request()->routeIs('pimpinan.profile') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-cog"></i><p>Profil Saya</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pimpinan.settings.index') }}" class="nav-link {{ request()->routeIs('pimpinan.settings.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i><p>Pengaturan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar-pimpinan">
                            @csrf
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar-pimpinan').submit();" 
                               class="nav-link text-danger">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Keluar</p>
                            </a>
                        </form>
                    </li>

                    {{-- ═══════════ KOPERASI MENU ═══════════ --}}
                    @elseif(auth()->user()->isKoperasi())
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
                        <a href="{{ route('koperasi.bantuan.pengajuan') }}" class="nav-link {{ request()->routeIs('koperasi.bantuan.pengajuan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-paper-plane"></i><p>Ajukan Bantuan</p>
                        </a>
                    </li>
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

                    <li class="nav-header">AKUN</li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar-koperasi">
                            @csrf
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar-koperasi').submit();" 
                               class="nav-link text-danger">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Keluar</p>
                            </a>
                        </form>
                    </li>

                    {{-- ═══════════ ANGGOTA MENU ═══════════ --}}
                    @elseif(auth()->user()->isAnggota())
                    <li class="nav-item">
                        <a href="{{ route('anggota.dashboard') }}" class="nav-link {{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-header">PROFIL SAYA</li>
                    <li class="nav-item">
                        <a href="{{ route('anggota.profil') }}" class="nav-link {{ request()->routeIs('anggota.profil') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i><p>Data Profil</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('anggota.kartu') }}" class="nav-link {{ request()->routeIs('anggota.kartu') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-id-card"></i><p>Kartu Anggota</p>
                        </a>
                    </li>
                    <li class="nav-header">INFORMASI</li>
                    <li class="nav-item">
                        <a href="{{ route('anggota.pengumuman') }}" class="nav-link {{ request()->routeIs('anggota.pengumuman') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bullhorn"></i><p>Pengumuman</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('anggota.jadwal') }}" class="nav-link {{ request()->routeIs('anggota.jadwal') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i><p>Jadwal Kegiatan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('anggota.kebutuhan-bantuan') }}" class="nav-link {{ request()->routeIs('anggota.kebutuhan-bantuan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i><p>List Kebutuhan Bantuan</p>
                        </a>
                    </li>
                    {{-- Updated: {{ now()->format('Y-m-d H:i:s') }} --}}
                    <li class="nav-header">KOMUNIKASI</li>
                    <li class="nav-item">
                        <a href="{{ route('anggota.chat.index') }}" class="nav-link {{ request()->routeIs('anggota.chat*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>Chat dengan Admin
                                @php 
                                    $unreadAnggotaChats = \App\Models\Chat::where('penerima_id', auth()->id())->where('is_read', false)->count();
                                @endphp
                                @if($unreadAnggotaChats > 0)
                                    <span class="badge badge-warning right">{{ $unreadAnggotaChats }}</span>
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
        <div class="content-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e8f0fe 100%); border-bottom: 2px solid #e2e8f0; padding: 20px 0;">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-12">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="d-flex align-items-center mb-2 mb-sm-0">
                                <a href="{{ route('dashboard') }}" class="btn btn-sm mr-3" style="background: linear-gradient(135deg, #60a5fa, #3b82f6); color: #ffffff; border: none; border-radius: 10px; padding: 10px 20px; font-weight: 700; font-size: 14px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); transition: all 0.3s ease; display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-home" style="font-size: 16px;"></i>
                                    <span>Home</span>
                                </a>
                                <h1 class="m-0" style="font-size: 24px; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-tachometer-alt" style="color: #3b82f6; font-size: 22px;"></i>
                                    @yield('page-title', 'Dashboard')
                                </h1>
                            </div>
                            <div>
                                <ol class="breadcrumb mb-0" style="background: transparent; padding: 8px 16px; border-radius: 8px; background: rgba(255, 255, 255, 0.7); box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);">
                                    @yield('breadcrumb')
                                </ol>
                            </div>
                        </div>
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
        <strong>{{ setting('app_footer', '© ' . date('Y') . ' DISPERINDAGKOP Kabupaten Tolikara. All rights reserved.') }}</strong>
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

    // ═══════════════════════════════════════════
    // MENU SIDEBAR - SEMUA SUBMENU SELALU TERBUKA
    // ═══════════════════════════════════════════
    
    // Tambahkan ID unik ke setiap menu item dengan submenu
    $('.nav-sidebar > .nav-item').each(function(index) {
        if ($(this).find('.nav-treeview').length > 0 && !$(this).attr('id')) {
            const menuText = $(this).find('> .nav-link p').first().text().trim().toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^a-z0-9-]/g, '');
            $(this).attr('id', 'menu-' + menuText + '-' + index);
        }
    });
    
    // ═══════════════════════════════════════════
    // DROPDOWN TOGGLE - KLIK UNTUK BUKA/TUTUP
    // ═══════════════════════════════════════════
    
    // Handle klik pada parent menu untuk toggle dropdown
    $('.nav-sidebar > .nav-item > .nav-link').on('click', function(e) {
        const $parentItem = $(this).parent('.nav-item');
        const $treeview = $parentItem.find('> .nav-treeview');
        
        // Jika menu ini punya submenu (treeview)
        if ($treeview.length > 0) {
            e.preventDefault();
            e.stopPropagation();
            
            // Toggle class menu-open
            $parentItem.toggleClass('menu-open');
            
            // Toggle tampilan treeview dengan animasi
            if ($parentItem.hasClass('menu-open')) {
                $treeview.slideDown(300);
                $(this).attr('aria-expanded', 'true');
            } else {
                $treeview.slideUp(300);
                $(this).attr('aria-expanded', 'false');
            }
            
            return false;
        }
    });
    
    // Pastikan menu yang aktif (berdasarkan route) tetap terbuka
    $('.nav-sidebar > .nav-item.menu-open').each(function() {
        $(this).find('> .nav-treeview').show();
        $(this).find('> .nav-link').attr('aria-expanded', 'true');
    });
    
    // Handle klik pada submenu item (biarkan berfungsi normal)
    $('.nav-sidebar .nav-treeview .nav-link').on('click', function(e) {
        // Biarkan link berfungsi normal
        // Hanya update active state
        $('.nav-sidebar .nav-treeview .nav-link').removeClass('active');
        $(this).addClass('active');
    });
    
    // Tandai menu aktif berdasarkan URL saat ini
    const currentPath = window.location.pathname;
    $('.nav-sidebar .nav-link').each(function() {
        const linkHref = $(this).attr('href');
        if (linkHref && linkHref !== '#' && currentPath.includes(linkHref)) {
            $(this).addClass('active');
        }
    });
});
</script>

{{-- Auto-hide read notifications after 5 minutes --}}
<script>
$(document).ready(function() {
    // Function to auto-hide read notifications after 5 minutes
    function autoHideReadNotifications() {
        @if(auth()->check())
            $.ajax({
                url: '/api/notifications/auto-hide',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: {{ auth()->id() }}
                },
                success: function(response) {
                    if (response.hidden_count > 0) {
                        console.log('Auto-hidden ' + response.hidden_count + ' read notifications');
                        // Update badge count without full reload
                        var currentBadge = $('.navbar-badge').first();
                        if (currentBadge.length) {
                            var currentCount = parseInt(currentBadge.text()) || 0;
                            var newCount = Math.max(0, currentCount - response.hidden_count);
                            if (newCount > 0) {
                                currentBadge.text(newCount);
                            } else {
                                currentBadge.remove();
                            }
                        }
                    }
                }
            });
        @endif
    }
    
    // Run every 1 minute to check for notifications to hide
    setInterval(autoHideReadNotifications, 60000);
    
    // Mark notification as read when clicked
    $('.notif-item').on('click', function(e) {
        var notifId = $(this).data('notif-id');
        if (notifId) {
            $.ajax({
                url: '/api/notifications/' + notifId + '/read',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    console.log('Notification marked as read');
                }
            });
        }
    });

    // Dropdown icon rotation animation for Petugas menu
    $('.nav-item').on('expanded.lte.treeview', function() {
        $(this).find('.fa-chevron-down').first().css('transform', 'rotate(180deg)');
    });
    
    $('.nav-item').on('collapsed.lte.treeview', function() {
        $(this).find('.fa-chevron-down').first().css('transform', 'rotate(0deg)');
    });

    // Set initial state for open menus
    $('.nav-item.menu-open').each(function() {
        $(this).find('.fa-chevron-down').first().css('transform', 'rotate(180deg)');
    });
});
</script>

@stack('scripts')
</body>
</html>