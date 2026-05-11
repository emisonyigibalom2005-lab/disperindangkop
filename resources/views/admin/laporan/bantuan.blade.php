@extends('layouts.app')
@section('title', 'Rekap Bantuan')

@push('styles')
<style>
/* Modern Card Styles */
.page-header-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    overflow: hidden;
    position: relative;
}

.page-header-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.page-header-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    margin-right: 20px;
    backdrop-filter: blur(10px);
}

.page-header-title {
    font-size: 32px;
    font-weight: 800;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.page-header-subtitle {
    font-size: 16px;
    margin: 5px 0 0 0;
    opacity: 0.95;
}

/* Filter Box */
.filter-box {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.filter-box label {
    font-weight: 700;
    color: #374151;
    font-size: 13px;
    margin-bottom: 8px;
}

.filter-box .form-control {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    padding: 10px 15px;
    font-size: 14px;
}

.filter-box .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Flexbox gap support */
.d-flex.gap-2 {
    display: flex;
    gap: 10px;
}

.flex-fill {
    flex: 1 1 0%;
}

/* Content Card */
.content-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 25px;
}

.content-card-header {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 100%);
    padding: 20px 25px;
    border-bottom: none;
}

.content-card-title {
    color: white;
    font-size: 18px;
    font-weight: 800;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.content-card-body {
    padding: 25px;
}

/* Table Modern */
.table-modern {
    margin: 0;
    font-size: 14px;
}

.table-modern thead th {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 100%);
    color: white !important;
    border: none;
    font-size: 13px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 16px 12px;
    text-align: center;
    white-space: nowrap;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.table-modern tbody td {
    padding: 16px 12px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
}

.table-modern tbody tr {
    transition: all 0.2s ease;
}

.table-modern tbody tr:hover {
    background: #f8f9fa;
    transform: scale(1.001);
}

/* Badges */
.badge-custom {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    display: inline-block;
}

.badge-blue {
    background: #dbeafe;
    color: #1e40af;
}

.badge-green {
    background: #d1fae5;
    color: #065f46;
}

.badge-purple {
    background: #e9d5ff;
    color: #6b21a8;
}

.badge-info-modern {
    background: #dbeafe;
    color: #1e40af;
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
}

.badge-success-modern {
    background: #d1fae5;
    color: #065f46;
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
}

.badge-danger-modern {
    background: #fee2e2;
    color: #991b1b;
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
}

/* Status Badge */
.status-badge {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.status-active {
    background: #d1fae5;
    color: #065f46;
}

.status-inactive {
    background: #e5e7eb;
    color: #374151;
}

.status-rejected {
    background: #fee2e2;
    color: #991b1b;
}

/* Buttons */
.btn-primary-modern {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    color: white;
    font-weight: 700;
    border-radius: 10px;
    padding: 10px 20px;
    transition: all 0.3s ease;
}

.btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-success-modern {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    color: white;
    font-weight: 700;
    border-radius: 10px;
    padding: 10px 20px;
    transition: all 0.3s ease;
}

.btn-success-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    color: white;
}

.btn-info-modern {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
    color: white;
    font-weight: 700;
    border-radius: 8px;
    padding: 8px 16px;
    transition: all 0.3s ease;
}

.btn-info-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
    color: white;
}

/* Export Buttons - White background with colored icons */
.btn-export-print {
    background: white;
    border: 2px solid #e5e7eb;
    color: #5b21b6;
    font-weight: 700;
    font-size: 13px;
    border-radius: 12px;
    padding: 10px 16px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.btn-export-print:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(91, 33, 182, 0.2);
    border-color: #5b21b6;
    color: #5b21b6;
}

.btn-export-print i {
    color: #5b21b6;
    font-size: 16px;
    margin-right: 6px;
}

.btn-export-excel {
    background: white;
    border: 2px solid #e5e7eb;
    color: #059669;
    font-weight: 700;
    font-size: 13px;
    border-radius: 12px;
    padding: 10px 16px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.btn-export-excel:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(5, 150, 105, 0.2);
    border-color: #059669;
    color: #059669;
    text-decoration: none;
}

.btn-export-excel i {
    color: #059669;
    font-size: 16px;
    margin-right: 6px;
}

.btn-export-word {
    background: white;
    border: 2px solid #e5e7eb;
    color: #2563eb;
    font-weight: 700;
    font-size: 13px;
    border-radius: 12px;
    padding: 10px 16px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.btn-export-word:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.2);
    border-color: #2563eb;
    color: #2563eb;
    text-decoration: none;
}

.btn-export-word i {
    color: #2563eb;
    font-size: 16px;
    margin-right: 6px;
}

.btn-export-pdf {
    background: white;
    border: 2px solid #e5e7eb;
    color: #dc2626;
    font-weight: 700;
    font-size: 13px;
    border-radius: 12px;
    padding: 10px 16px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.btn-export-pdf:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(220, 38, 38, 0.2);
    border-color: #dc2626;
    color: #dc2626;
    text-decoration: none;
}

.btn-export-pdf i {
    color: #dc2626;
    font-size: 16px;
    margin-right: 6px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state i {
    font-size: 64px;
    color: #e5e7eb;
    margin-bottom: 20px;
}

.empty-state h5 {
    color: #374151;
    font-weight: 700;
    margin-bottom: 10px;
}

.empty-state p {
    color: #9ca3af;
    margin: 0;
}

/* Print Styles */
@media print {
    body {
        background: white;
        padding: 0;
        margin: 0;
    }
    
    .container-fluid {
        max-width: 100% !important;
        padding: 15px !important;
    }
    
    /* Hide elements */
    .filter-box,
    .page-header-card,
    .pagination,
    .btn,
    button,
    a[href*="export"],
    nav,
    .sidebar,
    .navbar,
    footer,
    .no-print {
        display: none !important;
    }
    
    /* Kop Surat */
    .print-header {
        display: block !important;
        text-align: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 3px solid #000;
        page-break-inside: avoid;
    }
    
    .print-header img {
        width: 60px;
        height: 60px;
        margin-bottom: 8px;
    }
    
    .print-header h3 {
        font-size: 13px;
        font-weight: bold;
        margin: 2px 0;
        color: #000;
        text-transform: uppercase;
    }
    
    .print-header p {
        font-size: 9px;
        margin: 2px 0;
        color: #333;
    }
    
    .print-title {
        display: block !important;
        text-align: center;
        font-size: 14px;
        font-weight: bold;
        margin: 12px 0;
        padding-bottom: 6px;
        border-bottom: 2px solid #000;
        text-transform: uppercase;
        page-break-inside: avoid;
    }
    
    .print-date {
        display: block !important;
        text-align: center;
        font-size: 9px;
        font-style: italic;
        margin-bottom: 12px;
        color: #666;
    }
    
    /* Content Card */
    .content-card {
        box-shadow: none !important;
        border: 1px solid #ddd;
        page-break-inside: avoid;
        margin-bottom: 12px;
    }
    
    .content-card-header {
        background: #1a3a6e !important;
        color: white !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        padding: 8px 10px !important;
    }
    
    .content-card-title {
        font-size: 11px !important;
    }
    
    .content-card-body {
        padding: 0 !important;
    }
    
    /* Table */
    .table-modern {
        font-size: 7px !important;
        width: 100%;
    }
    
    .table-modern thead th {
        background: #1a3a6e !important;
        color: white !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        padding: 6px 4px !important;
        font-size: 8px !important;
        border: 1px solid #000 !important;
        font-weight: 900 !important;
    }
    
    .table-modern tbody td {
        padding: 5px 4px !important;
        font-size: 7px !important;
        border: 1px solid #ddd !important;
        color: #000 !important;
    }
    
    .table-modern tbody tr {
        page-break-inside: avoid;
    }
    
    .table-modern tbody tr:nth-child(even) {
        background-color: #f9f9f9 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    /* Hide avatar circles completely */
    .table-modern tbody td > div > div[style*="width:40px"],
    .table-modern tbody td > div > div[style*="border-radius:50%"] {
        display: none !important;
    }
    
    /* Remove all badge colors */
    .badge-custom,
    .badge-info-modern,
    .badge-success-modern,
    .badge-danger-modern,
    .status-badge,
    .badge-blue,
    .badge-green,
    .badge-purple {
        background: transparent !important;
        color: #000 !important;
        border: 1px solid #333 !important;
        padding: 2px 5px !important;
        font-size: 7px !important;
        font-weight: bold !important;
    }
    
    /* Remove avatar background */
    .table-modern tbody td > div > div[style*="background"] {
        display: none !important;
    }
    
    /* Remove icon colors */
    .fas, .far {
        color: #000 !important;
        font-size: 7px !important;
    }
    
    /* Progress Bar - remove colors */
    .progress {
        border: 1px solid #333 !important;
        background: #f0f0f0 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    .progress-bar {
        background: #666 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    /* Summary Box */
    .print-summary {
        display: block !important;
        margin-top: 12px;
        padding: 8px;
        border: 2px solid #000;
        background: #f5f5f5 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        text-align: center;
        font-weight: bold;
        font-size: 9px;
        page-break-inside: avoid;
    }
    
    /* Signature */
    .print-signature {
        display: block !important;
        margin-top: 25px;
        text-align: right;
        font-size: 9px;
        page-break-inside: avoid;
    }
    
    .print-signature p {
        margin: 3px 0;
        color: #000;
    }
    
    .print-signature .signature-space {
        margin: 40px 0 6px 0;
    }
    
    /* Hide print-only elements on screen */
    .print-only {
        display: inline !important;
    }
    
    /* Page setup */
    @page {
        size: A4 landscape;
        margin: 10mm;
    }
}

.print-header,
.print-title,
.print-date,
.print-summary,
.print-signature {
    display: none;
}
</style>
@endpush

@section('content')
<div class="container-fluid" style="max-width:1600px;padding:30px 40px">
    {{-- Print Header (Hidden on screen, visible on print) --}}
    <div class="print-header">
        <img src="{{ asset('images/logo-tolikara.png') }}" alt="Logo Tolikara">
        <h3>PEMERINTAH KABUPATEN TOLIKARA</h3>
        <h3>DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI</h3>
        <p>Jl. Raya Karubaga, Kab. Tolikara, Papua Pegunungan | Telp. (0964) 123456</p>
    </div>
    
    <div class="print-title">LAPORAN PROGRAM BANTUAN KOPERASI</div>
    <div class="print-date">Per Tanggal: {{ date('d F Y') }}</div>

    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card page-header-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center text-white">
                        <div class="page-header-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div>
                            <h3 class="page-header-title">Rekap Bantuan</h3>
                            <p class="page-header-subtitle">Laporan dan statistik program bantuan koperasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="filter-box">
                <form method="GET">
                    <div class="row align-items-end">
                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <label><i class="fas fa-calendar mr-1"></i>Tahun</label>
                                <select name="tahun" class="form-control">
                                    <option value="">Semua Tahun</option>
                                    @for($y = date('Y'); $y >= 2020; $y--)
                                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <label><i class="fas fa-check-circle mr-1"></i>Status Pengajuan</label>
                                <select name="status_pengajuan" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status_pengajuan') === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="diproses" {{ request('status_pengajuan') === 'diproses' ? 'selected' : '' }}>⚙️ Diproses</option>
                                    <option value="disetujui" {{ request('status_pengajuan') === 'disetujui' ? 'selected' : '' }}>✅ Disetujui</option>
                                    <option value="ditolak" {{ request('status_pengajuan') === 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                                    <option value="selesai" {{ request('status_pengajuan') === 'selesai' ? 'selected' : '' }}>🏁 Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary-modern btn-block">
                                    <i class="fas fa-filter mr-1"></i>Filter
                                </button>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group mb-0">
                                <a href="{{ route('admin.laporan.bantuan') }}" class="btn btn-secondary btn-block" style="border-radius:10px;font-weight:700" title="Reset">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <div class="d-flex gap-2" style="gap:10px">
                                    <button type="button" onclick="window.print()" class="btn btn-export-print flex-fill" title="Print">
                                        <i class="fas fa-print"></i> Print
                                    </button>
                                    <a href="{{ route('admin.laporan.exportExcel', ['type'=>'bantuan'] + request()->all()) }}" class="btn btn-export-excel flex-fill" title="Excel">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </a>
                                    <a href="{{ route('admin.laporan.exportWord', ['type'=>'bantuan'] + request()->all()) }}" class="btn btn-export-word flex-fill" title="Word">
                                        <i class="fas fa-file-word"></i> Word
                                    </a>
                                    <a href="{{ route('admin.laporan.exportPdf', ['type'=>'bantuan'] + request()->all()) }}" class="btn btn-export-pdf flex-fill" title="PDF">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tren per Tahun --}}
    @if($bantuanPerTahun->count() > 0)
    <div class="content-card">
        <div class="content-card-header">
            <h5 class="content-card-title">
                <i class="fas fa-chart-line mr-2"></i>Tren Penerima Bantuan per Tahun
            </h5>
        </div>
        <div class="content-card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th width="15%">Tahun</th>
                            <th width="20%">Jumlah Penerima</th>
                            <th width="25%">Total Nilai Bantuan</th>
                            <th width="40%">Grafik</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bantuanPerTahun as $b)
                        <tr>
                            <td style="text-align:center">
                                <strong style="color:#1a3a6e;font-size:18px">{{ $b->tahun }}</strong>
                            </td>
                            <td style="text-align:center">
                                <span class="badge-custom badge-green">
                                    <i class="fas fa-users mr-1"></i>{{ $b->total }} orang
                                </span>
                            </td>
                            <td>
                                <strong style="color:#059669;font-size:15px">
                                    Rp {{ number_format($b->total_nilai, 0, ',', '.') }}
                                </strong>
                            </td>
                            <td>
                                <div class="progress" style="height:24px;border-radius:12px;background:#e5e7eb">
                                    <div class="progress-bar" 
                                         style="width:{{ $bantuanPerTahun->max('total') > 0 ? ($b->total / $bantuanPerTahun->max('total') * 100) : 0 }}%;background:linear-gradient(135deg,#10b981,#059669);border-radius:12px;display:flex;align-items:center;justify-content:center">
                                        <span style="font-size:12px;font-weight:700;color:white">
                                            {{ number_format($bantuanPerTahun->max('total') > 0 ? ($b->total / $bantuanPerTahun->max('total') * 100) : 0, 1) }}%
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Tabel Data Pengajuan Bantuan --}}
    @php
        $pengajuanQuery = \App\Models\PengajuanBantuan::with(['anggota', 'periodeBantuan']);
        
        if (request()->filled('tahun')) {
            $pengajuanQuery->whereHas('periodeBantuan', function($q) {
                $q->whereYear('tanggal_mulai', request('tahun'));
            });
        }
        
        if (request()->filled('status_pengajuan')) {
            $pengajuanQuery->where('status', request('status_pengajuan'));
        }
        
        $pengajuanBantuan = $pengajuanQuery->latest()->paginate(15, ['*'], 'pengajuan_page');
    @endphp

    <div class="content-card">
        <div class="content-card-header">
            <h5 class="content-card-title">
                <i class="fas fa-file-alt mr-2"></i>Data Pengajuan Bantuan
                <span class="badge-custom badge-blue ml-2" style="background:rgba(255,255,255,0.2);color:white">{{ $pengajuanBantuan->total() }}</span>
            </h5>
        </div>
        
        <div class="content-card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th width="4%">No</th>
                            <th width="12%">Tanggal</th>
                            <th width="15%">Nama Pemohon</th>
                            <th width="12%">Kontak</th>
                            <th width="15%">Nama Usaha</th>
                            <th width="12%">Jenis Bantuan</th>
                            <th width="12%">Jumlah</th>
                            <th width="10%">Periode</th>
                            <th width="8%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuanBantuan as $i => $p)
                        <tr>
                            <td style="text-align:center;font-weight:700;color:#6b7280">
                                {{ $pengajuanBantuan->firstItem() + $i }}
                            </td>
                            <td>
                                <div style="font-size:13px">
                                    <i class="far fa-calendar text-primary mr-1"></i>
                                    <strong>{{ $p->created_at->format('d M Y') }}</strong>
                                </div>
                                <small class="text-muted">{{ $p->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#667eea,#764ba2);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:16px">
                                        {{ strtoupper(substr($p->nama_pemohon, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong style="color:#1a3a6e;font-size:14px">{{ $p->nama_pemohon }}</strong>
                                        @if($p->anggota)
                                        <br><small class="text-muted">ID: {{ $p->anggota->id }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size:12px">
                                    <i class="fas fa-phone text-success mr-1"></i>{{ $p->no_hp }}
                                </div>
                                @if($p->email)
                                <div style="font-size:11px" class="text-muted mt-1">
                                    <i class="fas fa-envelope mr-1"></i>{{ Str::limit($p->email, 20) }}
                                </div>
                                @endif
                            </td>
                            <td>
                                <strong style="color:#374151;font-size:13px">{{ $p->nama_usaha }}</strong>
                            </td>
                            <td style="text-align:center">
                                <span class="badge-info-modern">
                                    {{ $p->jenis_bantuan }}
                                </span>
                            </td>
                            <td>
                                <strong style="color:#059669;font-size:14px">
                                    Rp {{ number_format($p->jumlah_diajukan, 0, ',', '.') }}
                                </strong>
                            </td>
                            <td style="text-align:center">
                                @if($p->periodeBantuan)
                                <span class="badge-custom badge-purple" style="font-size:11px">
                                    {{ $p->periodeBantuan->nama_periode }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td style="text-align:center">
                                @if($p->status === 'pending')
                                    <span class="status-badge" style="background:#fef3c7;color:#92400e">
                                        <i class="fas fa-clock"></i>Pending
                                    </span>
                                @elseif($p->status === 'diproses')
                                    <span class="status-badge" style="background:#dbeafe;color:#1e40af">
                                        <i class="fas fa-spinner"></i>Diproses
                                    </span>
                                @elseif($p->status === 'disetujui')
                                    <span class="status-badge status-active">
                                        <i class="fas fa-check-circle"></i>Disetujui
                                    </span>
                                @elseif($p->status === 'ditolak')
                                    <span class="status-badge status-rejected">
                                        <i class="fas fa-times-circle"></i>Ditolak
                                    </span>
                                @else
                                    <span class="status-badge status-inactive">
                                        <i class="fas fa-flag-checkered"></i>Selesai
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-file-alt"></i>
                                    <h5>Belum Ada Pengajuan Bantuan</h5>
                                    <p>Data pengajuan bantuan dari anggota akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($pengajuanBantuan->hasPages())
        <div class="content-card-body border-top">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted font-weight-600">
                    Menampilkan {{ $pengajuanBantuan->firstItem() }}–{{ $pengajuanBantuan->lastItem() }} dari {{ $pengajuanBantuan->total() }} pengajuan
                </small>
                <div>
                    {{ $pengajuanBantuan->appends(request()->except('pengajuan_page'))->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
    
    {{-- Print Summary (Hidden on screen, visible on print) --}}
    <div class="print-summary">
        Total Program: {{ $bantuan->total() }} | Total Anggaran: Rp {{ number_format($bantuan->sum('anggaran'), 0, ',', '.') }}
    </div>
    
    {{-- Print Signature (Hidden on screen, visible on print) --}}
    <div class="print-signature">
        <p>Tolikara, {{ date('d F Y') }}</p>
        <p>Kepala Dinas,</p>
        <p class="signature-space"></p>
        <p><strong>Wugi Kogoya, S.P</strong></p>
        <p>NIP. 123456150890001</p>
    </div>
</div>
@endsection
