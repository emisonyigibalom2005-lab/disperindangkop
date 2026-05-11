@extends('layouts.app')
@section('title', 'Data Anggota Koperasi')

@push('styles')
<style>
    /* Hide print-only table on screen */
    .table-print-only {
        display: none;
    }
    
    /* FORCE RED COLOR FOR DELETE BUTTON - HIGHEST PRIORITY */
    table button.btn-danger,
    table button[type="submit"].btn-danger,
    .table button.btn-danger,
    .table-modern button.btn-danger,
    .action-btn-group button.btn-danger,
    form button.btn-danger {
        background: #dc2626 !important;
        background-color: #dc2626 !important;
        border: 2px solid #dc2626 !important;
        color: #ffffff !important;
    }
    
    table button.btn-danger:hover,
    table button[type="submit"].btn-danger:hover,
    .table button.btn-danger:hover,
    .table-modern button.btn-danger:hover,
    .action-btn-group button.btn-danger:hover,
    form button.btn-danger:hover {
        background: #b91c1c !important;
        background-color: #b91c1c !important;
        border-color: #b91c1c !important;
        color: #ffffff !important;
    }

    /* Stats Cards Modern */
    .stats-card-modern {
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
    }
    
    .stats-card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .stats-card-body {
        padding: 25px;
        color: white;
        position: relative;
        min-height: 120px;
    }
    
    .stats-icon-wrapper {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stats-number {
        font-size: 36px;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 8px;
    }
    
    .stats-label {
        font-size: 14px;
        opacity: 0.95;
        font-weight: 500;
    }
    
    /* Filter Box */
    .filter-box-modern {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }
    
    /* Table Modern */
    .table-modern-wrapper {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .table-modern-header {
        padding: 20px 25px;
        border-bottom: 2px solid #f0f0f0;
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
    }
    
    .table-modern-header h5 {
        margin: 0;
        color: #ffffff !important;
        font-weight: 800 !important;
        font-size: 17px !important;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .table-modern-header h5 i {
        color: #ffffff !important;
    }
    
    .table-modern {
        margin: 0;
        font-size: 14px;
    }
    
    .table-modern thead th {
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%) !important;
        color: #ffffff !important;
        border: none;
        font-size: 12px !important;
        font-weight: 800 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 12px;
        white-space: nowrap;
        text-align: center;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }
    
    .table-modern tbody td {
        padding: 16px 14px;
        vertical-align: middle;
        font-size: 15px;
        border-bottom: 1px solid #f0f0f0;
        color: #111827;
        font-weight: 600;
        line-height: 1.6;
    }
    
    .table-modern tbody td strong {
        font-weight: 800;
        color: #000000;
    }
    
    .table-modern tbody td small {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }
    
    .table-modern tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-modern tbody tr:hover {
        background: #f0fdf4;
    }
    
    /* Action Buttons */
    .action-btn-group {
        display: flex;
        gap: 6px;
        justify-content: center;
    }
    
    .action-btn-group .btn {
        padding: 10px 14px;
        font-size: 14px;
        border-radius: 8px;
        border: none !important;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    
    .action-btn-group .btn-info {
        background: #3b82f6 !important;
        background-color: #3b82f6 !important;
        color: white !important;
    }
    
    .action-btn-group .btn-info:hover {
        background: #2563eb !important;
        background-color: #2563eb !important;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }
    
    .action-btn-group .btn-warning {
        background: #f59e0b !important;
        background-color: #f59e0b !important;
        color: white !important;
    }
    
    .action-btn-group .btn-warning:hover {
        background: #d97706 !important;
        background-color: #d97706 !important;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
    }
    
    .action-btn-group .btn-danger,
    .action-btn-group button.btn-danger,
    .action-btn-group .btn.btn-danger {
        background: #dc2626 !important;
        background-color: #dc2626 !important;
        color: white !important;
        border-color: #dc2626 !important;
    }
    
    .action-btn-group .btn-danger:hover,
    .action-btn-group button.btn-danger:hover,
    .action-btn-group .btn.btn-danger:hover {
        background: #b91c1c !important;
        background-color: #b91c1c !important;
        color: white !important;
        border-color: #b91c1c !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.5);
    }
    
    /* Force red color for delete button */
    button[type="submit"].btn-danger,
    form button.btn-danger {
        background: #dc2626 !important;
        background-color: #dc2626 !important;
        border: none !important;
        color: white !important;
    }
    
    button[type="submit"].btn-danger:hover,
    form button.btn-danger:hover {
        background: #b91c1c !important;
        background-color: #b91c1c !important;
        color: white !important;
    }
    
    /* Badge Modern */
    .badge-modern {
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 600;
        display: inline-block;
    }
    
    .status-badge {
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 600;
        display: inline-block;
    }
    
    .status-active {
        background: #10b981;
        color: white;
    }
    
    .status-pending {
        background: #f59e0b;
        color: white;
    }
    
    .status-inactive {
        background: #ef4444;
        color: white;
    }
    
    .badge-custom {
        padding: 4px 10px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 600;
    }
    
    .badge-blue {
        background: #3b82f6;
        color: white;
    }
    
    .badge-purple {
        background: #a855f7;
        color: white;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state i {
        font-size: 60px;
        color: #e5e7eb;
        margin-bottom: 15px;
    }
    
    .empty-state h5 {
        color: #374151;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .empty-state p {
        color: #9ca3af;
        margin-bottom: 15px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-card-modern {
            margin-bottom: 15px;
        }
        
        .stats-number {
            font-size: 28px;
        }
        
        .stats-icon-wrapper {
            width: 50px;
            height: 50px;
        }
        
        .filter-box-modern {
            padding: 20px;
        }
        
        .table-modern thead th,
        .table-modern tbody td {
            padding: 10px 8px;
            font-size: 11px;
        }
    }
    
    /* PRINT STYLES - OPTIMIZED TO FIT 1 PAGE LANDSCAPE */
    @media print {
        /* Hide elements that shouldn't print */
        .no-print, .filter-box-modern, .stats-card-modern, .btn-group, .action-btn-group, .pagination, .row.mb-4, .table-modern-header, .screen-only {
            display: none !important;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif !important;
            font-size: 7px !important;
            line-height: 1.2 !important;
            color: #000 !important;
            background: white !important;
            padding: 0 !important;
            margin: 0 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        .container-fluid {
            max-width: 100% !important;
            padding: 8px !important;
            margin: 0 !important;
        }
        
        /* KOP SURAT - LOGO KIRI, TEXT KANAN */
        .print-header {
            display: block !important;
        }
        
        .kop-surat {
            display: flex !important;
            align-items: flex-start !important;
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 2px solid #000;
            page-break-inside: avoid;
        }
        
        .kop-logo {
            flex-shrink: 0;
            margin-right: 10px;
        }
        
        .kop-logo img {
            width: 50px !important;
            height: 50px !important;
            display: block;
        }
        
        .kop-text {
            flex: 1;
            text-align: center;
        }
        
        .kop-surat h2 {
            font-size: 10px !important;
            font-weight: bold !important;
            margin: 1px 0 !important;
            text-transform: uppercase;
            color: #000 !important;
            letter-spacing: 0.3px;
        }
        
        .kop-surat h3 {
            font-size: 9px !important;
            font-weight: bold !important;
            margin: 1px 0 !important;
            text-transform: uppercase;
            color: #000 !important;
        }
        
        .kop-surat p {
            font-size: 7px !important;
            margin: 0 !important;
            color: #000 !important;
        }
        
        /* JUDUL LAPORAN - COMPACT */
        .print-title {
            display: block !important;
        }
        
        .judul-laporan {
            text-align: center;
            margin: 6px 0;
            padding-bottom: 4px;
            border-bottom: 1px solid #000;
            page-break-inside: avoid;
        }
        
        .judul-laporan h1 {
            font-size: 10px !important;
            font-weight: bold !important;
            text-transform: uppercase;
            margin-bottom: 2px !important;
            color: #000 !important;
            letter-spacing: 0.2px;
        }
        
        .judul-laporan p {
            font-size: 7px !important;
            font-style: italic;
            color: #333 !important;
            margin: 0 !important;
        }
        
        /* TABLE WRAPPER */
        .table-modern-wrapper {
            box-shadow: none !important;
            border-radius: 0 !important;
            margin-top: 0 !important;
            page-break-inside: auto;
            background: transparent !important;
        }
        
        /* TABLE STYLING - COMPACT */
        .table-responsive {
            overflow: visible !important;
        }
        
        /* HIDE SCREEN TABLE, SHOW PRINT TABLE */
        .table-print-only {
            display: table !important;
            width: 100% !important;
            border-collapse: collapse !important;
            margin-bottom: 6px !important;
            font-size: 6px !important;
            page-break-inside: auto;
        }
        
        .table-print-only thead {
            background: #1e3a5f !important;
            color: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        .table-print-only thead th {
            padding: 3px 2px !important;
            text-align: center !important;
            font-size: 6px !important;
            font-weight: bold !important;
            text-transform: uppercase;
            border: 1px solid #0f1f3d !important;
            letter-spacing: 0px;
            white-space: nowrap;
            background: #1e3a5f !important;
            color: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            line-height: 1.1;
            vertical-align: middle;
        }
        
        .table-print-only tbody td {
            padding: 2px 2px !important;
            font-size: 6px !important;
            border: 1px solid #ccc !important;
            vertical-align: middle !important;
            page-break-inside: avoid;
            line-height: 1.2;
            color: #000 !important;
            background: white !important;
        }
        
        .table-print-only tbody td small {
            font-size: 6px !important;
            display: inline;
        }
        
        .table-print-only tbody td strong {
            font-size: 6px !important;
            font-weight: bold !important;
            color: #000 !important;
        }
        
        .table-print-only tbody tr {
            background: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            page-break-inside: avoid;
            page-break-after: auto;
        }
        
        /* Badge status DENGAN WARNA di print */
        .status-badge {
            display: inline-block !important;
            padding: 1px 4px !important;
            border-radius: 2px !important;
            font-size: 6px !important;
            font-weight: bold !important;
            text-align: center;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        .status-active {
            background: #4ade80 !important;
            color: #fff !important;
            border: none !important;
        }
        
        .status-pending {
            background: #fbbf24 !important;
            color: #fff !important;
            border: none !important;
        }
        
        .status-inactive {
            background: #ef4444 !important;
            color: #fff !important;
            border: none !important;
        }
        
        /* SUMMARY BOX - COMPACT */
        .print-summary-box {
            display: block !important;
        }
        
        .summary-box {
            background: transparent !important;
            border: none !important;
            border-top: 1px solid #000 !important;
            border-bottom: 1px solid #000 !important;
            padding: 4px !important;
            margin: 6px 0 !important;
            text-align: center;
            page-break-inside: avoid;
        }
        
        .summary-box h3 {
            font-size: 8px !important;
            font-weight: bold !important;
            margin-bottom: 2px !important;
            color: #000 !important;
        }
        
        .summary-box p {
            font-size: 7px !important;
            margin: 1px 0 !important;
            color: #000 !important;
        }
        
        .summary-box strong {
            font-size: 7px !important;
            color: #000 !important;
            font-weight: bold !important;
        }
        
        /* SIGNATURE - COMPACT */
        .print-signature {
            display: block !important;
        }
        
        .signature {
            margin-top: 8px;
            text-align: right;
            page-break-inside: avoid;
        }
        
        .signature p {
            margin: 2px 0 !important;
            font-size: 7px !important;
            color: #000 !important;
        }
        
        .signature .space {
            margin: 25px 0 4px 0 !important;
        }
        
        .signature .name {
            font-weight: bold !important;
            text-decoration: underline;
        }
        
        /* FOOTER NOTE - COMPACT */
        .print-footer-note {
            display: block !important;
            margin-top: 6px;
            padding-top: 4px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 6px;
            color: #666;
            page-break-inside: avoid;
        }
        
        .print-footer-note p {
            margin: 0 !important;
            font-size: 6px !important;
            color: #666 !important;
        }
        
        /* TEXT UTILITIES */
        .text-center {
            text-align: center !important;
        }
        
        .text-right {
            text-align: right !important;
        }
        
        .font-bold {
            font-weight: bold !important;
        }
        
        /* PAGE SETTINGS - MINIMAL MARGINS */
        @page {
            size: A4 landscape;
            margin: 10mm 8mm;
        }
        
        /* Ensure no page breaks in header/title */
        .kop-surat, .judul-laporan {
            page-break-after: avoid;
        }
        
        /* Ensure signature stays together */
        .signature {
            page-break-before: avoid;
        }
        
        /* Ensure table doesn't break awkwardly */
        .table-modern-wrapper {
            page-break-inside: auto;
        }
    }
    
    .print-header, .print-title, .print-filter-info, .print-summary-box, .print-signature, .print-footer-note {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Print Header (only visible when printing) --}}
    <div class="print-header">
        <div class="kop-surat">
            <div class="kop-logo">
                @if(file_exists(public_path('images/logo-tolikara.png')))
                <img src="{{ asset('images/logo-tolikara.png') }}" alt="Logo Tolikara">
                @endif
            </div>
            <div class="kop-text">
                <h2>PEMERINTAH KABUPATEN TOLIKARA</h2>
                <h3>DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI</h3>
                <p>Jl. Raya Karubaga, Kab. Tolikara, Papua Pegunungan</p>
                <p>Telp. (0964) 123456 | Email: disperindagkop@tolikarakab.go.id</p>
            </div>
        </div>
    </div>

    {{-- Print Title (only visible when printing) --}}
    <div class="print-title">
        <div class="judul-laporan">
            <h1>📊 LAPORAN DATA ANGGOTA KOPERASI</h1>
            <p>Per Tanggal: {{ date('d F Y') }}</p>
        </div>
    </div>
    
    {{-- Print Filter Info (only visible when printing) --}}
    @if(request()->has('distrik') || request()->has('status'))
    <div class="print-filter-info">
        <div class="info-filter">
            <p><strong>📌 Filter yang Diterapkan:</strong></p>
            @if(request()->has('distrik') && request('distrik'))
            <p>• Distrik: <strong>{{ request('distrik') }}</strong></p>
            @endif
            @if(request()->has('status') && request('status'))
            <p>• Status: <strong>{{ ucfirst(request('status')) }}</strong></p>
            @endif
        </div>
    </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card-modern" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                <div class="stats-card-body">
                    <div class="stats-number">{{ $stats['total'] }}</div>
                    <div class="stats-label">Total Anggota</div>
                    <div class="stats-icon-wrapper">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card-modern" style="background: linear-gradient(135deg, #10b981, #059669);">
                <div class="stats-card-body">
                    <div class="stats-number">{{ $stats['aktif'] }}</div>
                    <div class="stats-label">Anggota Aktif</div>
                    <div class="stats-icon-wrapper">
                        <i class="fas fa-user-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card-modern" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                <div class="stats-card-body">
                    <div class="stats-number">{{ $stats['nonaktif'] }}</div>
                    <div class="stats-label">Anggota Nonaktif</div>
                    <div class="stats-icon-wrapper">
                        <i class="fas fa-user-times fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card-modern" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <div class="stats-card-body">
                    <div class="stats-number">{{ $stats['pending'] }}</div>
                    <div class="stats-label">Menunggu Verifikasi</div>
                    <div class="stats-icon-wrapper">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Box --}}
    <div class="filter-box-modern">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="mb-1" style="font-weight: 700; color: #1f2937;">
                    <i class="fas fa-filter mr-2"></i>Filter & Export Data
                </h5>
                <p class="text-muted mb-0" style="font-size: 13px;">Cari dan filter data anggota sesuai kebutuhan</p>
            </div>
            <div class="btn-group">
                <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary" style="border-radius:8px 0 0 8px;font-weight:600;">
                    <i class="fas fa-plus mr-1"></i>Tambah Anggota
                </a>
                <button type="button" class="btn" onclick="window.print()" style="border-radius:0;font-weight:600;background:#a855f7;color:white;" title="Print">
                    <i class="fas fa-print mr-1"></i>Print
                </button>
                <a href="{{ route('admin.anggota.export-excel', request()->all()) }}" class="btn" style="border-radius:0;font-weight:600;background:#10b981;color:white;" title="Export Excel">
                    <i class="fas fa-file-excel mr-1"></i>Excel
                </a>
                <a href="{{ route('admin.anggota.export-word', request()->all()) }}" class="btn" style="border-radius:0;font-weight:600;background:#2563eb;color:white;" title="Export Word">
                    <i class="fas fa-file-word mr-1"></i>Word
                </a>
                <a href="{{ route('admin.anggota.export-pdf', request()->all()) }}" class="btn" style="border-radius:0 8px 8px 0;font-weight:600;background:#ef4444;color:white;" title="Export PDF">
                    <i class="fas fa-file-pdf mr-1"></i>PDF
                </a>
            </div>
        </div>
        <form method="GET" action="{{ route('admin.anggota.index') }}" id="filterForm">
            <div class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold" style="font-size: 13px; color: #495057;">
                        <i class="fas fa-search mr-1"></i>Pencarian
                    </label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari nama, NIK, atau nomor anggota..." 
                           value="{{ request('search') }}"
                           style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 10px 15px;">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="font-weight-bold" style="font-size: 13px; color: #495057;">
                        <i class="fas fa-info-circle mr-1"></i>Status
                    </label>
                    <select name="status" class="form-control" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 10px 15px;">
                        <option value="">Semua Status</option>
                        @foreach(['Aktif','Pending','Nonaktif','Ditolak'] as $s)
                        <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="font-weight-bold" style="font-size: 13px; color: #495057;">
                        <i class="fas fa-map-marker-alt mr-1"></i>Distrik
                    </label>
                    <select name="distrik" class="form-control" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 10px 15px;">
                        <option value="">Semua Distrik</option>
                        <option value="Airgaram" {{ request('distrik')=='Airgaram'?'selected':'' }}>Airgaram</option>
                        <option value="Anawi" {{ request('distrik')=='Anawi'?'selected':'' }}>Anawi</option>
                        <option value="Aweku" {{ request('distrik')=='Aweku'?'selected':'' }}>Aweku</option>
                        <option value="Bewani" {{ request('distrik')=='Bewani'?'selected':'' }}>Bewani</option>
                        <option value="Biandoga" {{ request('distrik')=='Biandoga'?'selected':'' }}>Biandoga</option>
                        <option value="Biuk" {{ request('distrik')=='Biuk'?'selected':'' }}>Biuk</option>
                        <option value="Bogonuk" {{ request('distrik')=='Bogonuk'?'selected':'' }}>Bogonuk</option>
                        <option value="Bokondini" {{ request('distrik')=='Bokondini'?'selected':'' }}>Bokondini</option>
                        <option value="Bokoneri" {{ request('distrik')=='Bokoneri'?'selected':'' }}>Bokoneri</option>
                        <option value="Danime" {{ request('distrik')=='Danime'?'selected':'' }}>Danime</option>
                        <option value="Dow" {{ request('distrik')=='Dow'?'selected':'' }}>Dow</option>
                        <option value="Dundu" {{ request('distrik')=='Dundu'?'selected':'' }}>Dundu</option>
                        <option value="Egiam" {{ request('distrik')=='Egiam'?'selected':'' }}>Egiam</option>
                        <option value="Geya" {{ request('distrik')=='Geya'?'selected':'' }}>Geya</option>
                        <option value="Gika" {{ request('distrik')=='Gika'?'selected':'' }}>Gika</option>
                        <option value="Goyage" {{ request('distrik')=='Goyage'?'selected':'' }}>Goyage</option>
                        <option value="Gundagi" {{ request('distrik')=='Gundagi'?'selected':'' }}>Gundagi</option>
                        <option value="Kai" {{ request('distrik')=='Kai'?'selected':'' }}>Kai</option>
                        <option value="Kamboneri" {{ request('distrik')=='Kamboneri'?'selected':'' }}>Kamboneri</option>
                        <option value="Kanggime" {{ request('distrik')=='Kanggime'?'selected':'' }}>Kanggime</option>
                        <option value="Karubaga" {{ request('distrik')=='Karubaga'?'selected':'' }}>Karubaga</option>
                        <option value="Kembu" {{ request('distrik')=='Kembu'?'selected':'' }}>Kembu</option>
                        <option value="Kondaga" {{ request('distrik')=='Kondaga'?'selected':'' }}>Kondaga</option>
                        <option value="Kuari" {{ request('distrik')=='Kuari'?'selected':'' }}>Kuari</option>
                        <option value="Kubu" {{ request('distrik')=='Kubu'?'selected':'' }}>Kubu</option>
                        <option value="Li Anogomma" {{ request('distrik')=='Li Anogomma'?'selected':'' }}>Li Anogomma</option>
                        <option value="Nabunage" {{ request('distrik')=='Nabunage'?'selected':'' }}>Nabunage</option>
                        <option value="Nelawi" {{ request('distrik')=='Nelawi'?'selected':'' }}>Nelawi</option>
                        <option value="Numba" {{ request('distrik')=='Numba'?'selected':'' }}>Numba</option>
                        <option value="Nunggawi" {{ request('distrik')=='Nunggawi'?'selected':'' }}>Nunggawi</option>
                        <option value="Panaga" {{ request('distrik')=='Panaga'?'selected':'' }}>Panaga</option>
                        <option value="Poganeri" {{ request('distrik')=='Poganeri'?'selected':'' }}>Poganeri</option>
                        <option value="Tagime" {{ request('distrik')=='Tagime'?'selected':'' }}>Tagime</option>
                        <option value="Tagineri" {{ request('distrik')=='Tagineri'?'selected':'' }}>Tagineri</option>
                        <option value="Telenggeme" {{ request('distrik')=='Telenggeme'?'selected':'' }}>Telenggeme</option>
                        <option value="Timori" {{ request('distrik')=='Timori'?'selected':'' }}>Timori</option>
                        <option value="Tiom" {{ request('distrik')=='Tiom'?'selected':'' }}>Tiom</option>
                        <option value="Umagi" {{ request('distrik')=='Umagi'?'selected':'' }}>Umagi</option>
                        <option value="Wakuwo" {{ request('distrik')=='Wakuwo'?'selected':'' }}>Wakuwo</option>
                        <option value="Wari/Taiyeve II" {{ request('distrik')=='Wari/Taiyeve II'?'selected':'' }}>Wari/Taiyeve II</option>
                        <option value="Wenam" {{ request('distrik')=='Wenam'?'selected':'' }}>Wenam</option>
                        <option value="Wina" {{ request('distrik')=='Wina'?'selected':'' }}>Wina</option>
                        <option value="Wollo" {{ request('distrik')=='Wollo'?'selected':'' }}>Wollo</option>
                        <option value="Woniki" {{ request('distrik')=='Woniki'?'selected':'' }}>Woniki</option>
                        <option value="Wugi" {{ request('distrik')=='Wugi'?'selected':'' }}>Wugi</option>
                        <option value="Yuko" {{ request('distrik')=='Yuko'?'selected':'' }}>Yuko</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <button type="submit" class="btn btn-primary btn-block" style="border-radius: 10px; font-weight: 600; padding: 10px;">
                        <i class="fas fa-search mr-1"></i> Filter
                    </button>
                </div>
                <div class="col-md-2 mb-3">
                    <a href="{{ route('admin.anggota.index') }}" class="btn btn-secondary btn-block" style="border-radius: 10px; font-weight: 600; padding: 10px;">
                        <i class="fas fa-redo mr-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="table-modern-wrapper">
        <div class="table-modern-header">
            <h5><i class="fas fa-list mr-2"></i>Daftar Anggota Koperasi</h5>
        </div>
        <div class="table-responsive">
            {{-- TABEL UNTUK SCREEN (SEMUA KOLOM) --}}
            <table class="table table-modern table-hover mb-0 screen-only">
                <thead>
                    <tr>
                        <th style="width:100px;">No. Anggota</th>
                        <th style="width:60px;">Foto</th>
                        <th style="width:180px;">Data Pribadi</th>
                        <th style="width:120px;">Tempat, Tgl Lahir</th>
                        <th style="width:80px;">JK</th>
                        <th style="width:100px;">Status Kawin</th>
                        <th style="width:100px;">Pendidikan</th>
                        <th style="width:80px;">Agama</th>
                        <th style="width:120px;">Kontak</th>
                        <th style="width:120px;">Alamat</th>
                        <th style="width:150px;">Koperasi</th>
                        <th style="width:150px;">Usaha</th>
                        <th style="width:120px;">Bidang Usaha</th>
                        <th style="width:150px;">Ahli Waris</th>
                        <th style="width:120px;">Simpanan Pokok</th>
                        <th style="width:120px;">Simpanan Wajib</th>
                        <th style="width:120px;">Total Simpanan</th>
                        <th style="width:100px;">Tgl Bergabung</th>
                        <th style="width:80px;">Status</th>
                        <th style="width:120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($anggota as $a)
                <tr>
                    <td><strong class="text-primary" style="font-size:11px;">{{ $a->no_anggota }}</strong></td>
                    <td class="text-center">
                        <img src="{{ $a->foto_url }}" class="img-circle" width="40" height="40" style="object-fit:cover;border:2px solid #e0e6ff;">
                    </td>
                    <td>
                        <strong style="font-size:12px;">{{ $a->nama }}</strong><br>
                        <small class="text-muted" style="font-size:10px;"><i class="fas fa-id-card mr-1"></i>{{ $a->nik }}</small>
                    </td>
                    <td>
                        <small style="font-size:11px;">{{ $a->tempat_lahir }}</small><br>
                        <small class="text-muted" style="font-size:10px;">{{ $a->tanggal_lahir ? \Carbon\Carbon::parse($a->tanggal_lahir)->format('d M Y') : '-' }}</small><br>
                        <small class="text-info" style="font-size:10px;">({{ $a->umur }} thn)</small>
                    </td>
                    <td class="text-center">
                        @if($a->jenis_kelamin === 'L')
                        <span class="badge badge-custom badge-blue" style="font-size:9px;"><i class="fas fa-mars"></i> L</span>
                        @else
                        <span class="badge badge-custom badge-purple" style="font-size:9px;"><i class="fas fa-venus"></i> P</span>
                        @endif
                    </td>
                    <td>
                        <small style="font-size:10px;">
                            @if($a->status_perkawinan === 'Lajang')
                            <span class="badge badge-info" style="font-size:9px;">Lajang</span>
                            @elseif($a->status_perkawinan === 'Menikah')
                            <span class="badge badge-success" style="font-size:9px;">Menikah</span>
                            @elseif($a->status_perkawinan === 'Cerai')
                            <span class="badge badge-warning" style="font-size:9px;">Cerai</span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </small>
                    </td>
                    <td>
                        <small style="font-size:10px;">
                            @if($a->pendidikan_terakhir)
                            <span class="badge badge-primary" style="font-size:9px;"><i class="fas fa-graduation-cap mr-1"></i>{{ $a->pendidikan_terakhir }}</span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </small>
                    </td>
                    <td><small style="font-size:10px;">{{ $a->agama ?? '-' }}</small></td>
                    <td>
                        <small style="font-size:10px;"><i class="fab fa-whatsapp text-success mr-1"></i>{{ $a->no_hp }}</small><br>
                        @if($a->user && $a->user->email)
                        <small class="text-muted" style="font-size:9px;"><i class="fas fa-envelope mr-1"></i>{{ Str::limit($a->user->email, 20) }}</small>
                        @endif
                    </td>
                    <td>
                        <small style="font-size:10px;">
                            @if($a->desa)<i class="fas fa-map-marker-alt text-danger mr-1"></i>{{ $a->desa }}<br>@endif
                            <strong>{{ $a->distrik ?? '-' }}</strong><br>
                            <span class="text-muted">{{ $a->kabupaten ?? 'Tolikara' }}</span>
                        </small>
                    </td>
                    <td>
                        <small style="font-size:10px;">
                            @if($a->koperasi)
                            <i class="fas fa-building text-primary mr-1"></i><strong>{{ Str::limit($a->koperasi->nama_usaha, 25) }}</strong>
                            @else
                            <span class="text-muted">Belum terdaftar</span>
                            @endif
                        </small>
                    </td>
                    <td>
                        <small style="font-size:10px;">
                            @if($a->nama_usaha)
                            <i class="fas fa-store text-success mr-1"></i>{{ Str::limit($a->nama_usaha, 25) }}
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </small>
                    </td>
                    <td>
                        <small style="font-size:10px;">
                            @if($a->bidang_usaha)
                            <span class="badge badge-secondary" style="font-size:9px;">{{ $a->bidang_usaha }}</span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </small>
                    </td>
                    <td>
                        <small style="font-size:10px;">
                            @if($a->nama_ahli_waris)
                            <i class="fas fa-user-friends text-info mr-1"></i><strong>{{ Str::limit($a->nama_ahli_waris, 20) }}</strong><br>
                            <span class="text-muted">({{ $a->hubungan_ahli_waris }})</span><br>
                            <span class="text-muted">{{ $a->no_hp_ahli_waris }}</span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </small>
                    </td>
                    <td class="text-right">
                        <small class="text-success font-weight-bold" style="font-size:11px;">
                            Rp {{ number_format($a->simpanan_pokok ?? 0, 0, ',', '.') }}
                        </small>
                    </td>
                    <td class="text-right">
                        <small class="text-warning font-weight-bold" style="font-size:11px;">
                            Rp {{ number_format($a->simpanan_wajib ?? 0, 0, ',', '.') }}
                        </small>
                    </td>
                    <td class="text-right">
                        <small class="text-primary font-weight-bold" style="font-size:11px;">
                            Rp {{ number_format($a->total_simpanan ?? 0, 0, ',', '.') }}
                        </small>
                    </td>
                    <td>
                        <small style="font-size:10px;">
                            @if($a->tanggal_bergabung)
                            <i class="fas fa-calendar-alt text-muted mr-1"></i>{{ \Carbon\Carbon::parse($a->tanggal_bergabung)->format('d M Y') }}
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </small>
                    </td>
                    <td class="text-center">
                        @if($a->status === 'Aktif')
                        <span class="status-badge status-active">Aktif</span>
                        @elseif($a->status === 'Pending')
                        <span class="status-badge status-pending">Pending</span>
                        @else
                        <span class="status-badge status-inactive">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-btn-group">
                            <a href="{{ route('admin.anggota.show', $a) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.anggota.edit', $a) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.anggota.destroy', $a) }}" method="POST" style="display:inline" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" style="background: #dc2626 !important; background-color: #dc2626 !important; border-color: #dc2626 !important; color: white !important;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="20">
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h5>Tidak Ada Data</h5>
                            <p>Belum ada anggota koperasi yang tersedia</p>
                            <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary" style="border-radius:8px;">
                                <i class="fas fa-plus"></i> Tambah Anggota Pertama
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
                </tbody>
                @if($anggota->count() > 0)
                <tfoot style="background: #f8f9fa;">
                    <tr>
                        <td colspan="14" class="text-right font-weight-bold" style="padding: 15px 12px; font-size:12px;">TOTAL</td>
                        <td class="font-weight-bold text-success text-right" style="padding: 15px 12px; font-size:12px;">
                            Rp {{ number_format($anggota->sum('simpanan_pokok'),0,',','.') }}
                        </td>
                        <td class="font-weight-bold text-warning text-right" style="padding: 15px 12px; font-size:12px;">
                            Rp {{ number_format($anggota->sum('simpanan_wajib'),0,',','.') }}
                        </td>
                        <td class="font-weight-bold text-primary text-right" style="padding: 15px 12px; font-size:12px;">
                            Rp {{ number_format($anggota->sum('total_simpanan'),0,',','.') }}
                        </td>
                        <td colspan="3" style="padding: 15px 12px;"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
            
            {{-- TABEL UNTUK PRINT (HANYA 17 KOLOM PENTING) --}}
            <table class="table-print-only">
                <thead>
                    <tr>
                        <th>NO. ANGGOTA</th>
                        <th>DATA PRIBADI</th>
                        <th>TEMPAT, TGL LAHIR</th>
                        <th>JK</th>
                        <th>KONTAK</th>
                        <th>ALAMAT</th>
                        <th>USAHA</th>
                        <th>BIDANG USAHA</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($anggota as $a)
                <tr>
                    <td class="text-center">{{ $a->no_anggota }}</td>
                    <td>
                        <strong>{{ $a->nama }}</strong><br>
                        <small>{{ $a->nik }}</small>
                    </td>
                    <td>{{ $a->tempat_lahir }}, {{ $a->tanggal_lahir ? \Carbon\Carbon::parse($a->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                    <td class="text-center">{{ $a->jenis_kelamin === 'L' ? 'L' : 'P' }}</td>
                    <td>{{ $a->no_hp }}</td>
                    <td>{{ $a->desa ? $a->desa.', ' : '' }}{{ $a->distrik ?? '-' }}</td>
                    <td>{{ $a->nama_usaha ?? '-' }}</td>
                    <td>{{ $a->bidang_usaha ?? '-' }}</td>
                    <td class="text-center">
                        @if($a->status === 'Aktif')
                        <span class="status-badge status-active">AKTIF</span>
                        @elseif($a->status === 'Pending')
                        <span class="status-badge status-pending">PENDING</span>
                        @else
                        <span class="status-badge status-inactive">{{ strtoupper($a->status) }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($anggota->hasPages())
    <div class="row mt-4 no-print">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $anggota->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    @endif
    
    {{-- Print Summary Box (only visible when printing) --}}
    <div class="print-summary-box">
        <div class="summary-box">
            <h3>📊 RINGKASAN DATA</h3>
            <p><strong>Total Anggota Koperasi:</strong> {{ $anggota->total() }} Orang</p>
            <p>
                <strong>Status:</strong> 
                Aktif: {{ $stats['aktif'] }} | 
                Pending: {{ $stats['pending'] }} | 
                Nonaktif: {{ $stats['nonaktif'] }}
            </p>
        </div>
    </div>
    
    {{-- Print Signature (only visible when printing) --}}
    <div class="print-signature">
        <div class="signature">
            <p>Tolikara, {{ date('d F Y') }}</p>
            <p><strong>Kepala Dinas,</strong></p>
            <p class="space"></p>
            <p class="name">Wugi Kogoya, S.P</p>
            <p>NIP. 123456150890001</p>
        </div>
    </div>
    
    {{-- Print Footer Note (only visible when printing) --}}
    <div class="print-footer-note">
        <p>Dokumen ini dicetak secara otomatis oleh sistem pada {{ date('d F Y H:i:s') }}</p>
        <p>Dinas Perindustrian, Perdagangan dan Koperasi Kabupaten Tolikara</p>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Show success message if exists
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    showConfirmButton: true,
    confirmButtonColor: '#10b981',
    timer: 5000,
    timerProgressBar: true
});
@endif

// Show error message if exists
@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '{{ session('error') }}',
    showConfirmButton: true,
    confirmButtonColor: '#ef4444'
});
@endif

function confirmDelete(event) {
    event.preventDefault();
    const form = event.target;
    
    Swal.fire({
        title: 'Hapus Anggota?',
        text: "Data anggota akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
    
    return false;
}
</script>
@endpush