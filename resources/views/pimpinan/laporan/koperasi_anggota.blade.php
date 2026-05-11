@extends('layouts.app')
@section('title','Rekap Anggota Koperasi')
@section('page-title','Rekap Anggota Koperasi')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('pimpinan.laporan.index') }}">Laporan</a></li>
<li class="breadcrumb-item active">Rekap Anggota</li>
@endsection

@push('styles')
<style>
.card-modern {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
.table-modern {
    font-size: 13px;
}
.table-modern thead th {
    white-space: nowrap;
    vertical-align: middle;
    font-size: 12px;
    font-weight: 700;
}
.table-modern tbody td {
    vertical-align: middle;
    padding: 12px 10px;
}
.table-modern tbody tr {
    border-bottom: 1px solid #e5e7eb;
    transition: all 0.2s ease;
}
.table-modern tbody tr:hover {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    transform: scale(1.002);
    box-shadow: 0 2px 8px rgba(251,191,36,0.15);
}
.download-btn {
    transition: all 0.3s ease;
}
.download-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
.badge-no-anggota {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
    white-space: nowrap;
}
.badge-status {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
    white-space: nowrap;
}
.badge-aktif {
    background: #d1fae5;
    color: #065f46;
    border: 2px solid #10b981;
}
.badge-pending {
    background: #fef3c7;
    color: #92400e;
    border: 2px solid #f59e0b;
}
.badge-ditolak {
    background: #fee2e2;
    color: #991b1b;
    border: 2px solid #ef4444;
}
.row-hidden {
    display: none !important;
}
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white;
        padding: 0;
        margin: 0;
    }
    
    .container-fluid {
        max-width: 100% !important;
        padding: 15px !important;
    }
    
    /* TABLE STYLING */
    .table-modern {
        font-size: 7px !important;
        page-break-inside: auto;
        border-collapse: collapse !important;
        width: 100% !important;
        table-layout: auto !important;
    }
    
    .table-modern thead th {
        padding: 4px 3px !important;
        font-size: 7px !important;
        background: #1a3a6e !important;
        background-color: #1a3a6e !important;
        color: #ffffff !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        border: 0.5px solid #000 !important;
        font-weight: 900 !important;
        text-transform: uppercase;
        letter-spacing: 0px;
        line-height: 1.2;
        vertical-align: middle;
        white-space: nowrap;
    }
    
    .table-modern tbody td {
        padding: 3px 2px !important;
        font-size: 7px !important;
        border: 0.5px solid #999 !important;
        page-break-inside: avoid;
        line-height: 1.3;
        vertical-align: middle;
        word-wrap: break-word;
    }
    
    .table-modern tbody td small {
        font-size: 7px !important;
    }
    
    .table-modern tbody td strong {
        font-size: 7px !important;
        font-weight: bold !important;
    }
    
    /* HIDE KOLOM YANG TIDAK PENTING SAAT PRINT - HANYA TAMPILKAN 17 KOLOM */
    /* Hide: Email, Tempat Lahir (terpisah), Agama, Status Nikah, Pendidikan, Desa (terpisah), Kabupaten, Kode Pos, Status Rumah, Lama Usaha, Jumlah Karyawan, Omzet, Alamat Usaha, Legalitas, Nama Pemilik Rek, NPWP, Ahli Waris, Hubungan, No HP Waris, NIK Waris, Simpanan Pokok, Simpanan Wajib */
    
    .table-modern thead th:nth-child(5),  /* Email */
    .table-modern thead th:nth-child(6),  /* Tempat Lahir */
    .table-modern thead th:nth-child(7),  /* Tanggal Lahir */
    .table-modern thead th:nth-child(9),  /* Agama */
    .table-modern thead th:nth-child(10), /* Status Nikah */
    .table-modern thead th:nth-child(11), /* Pendidikan */
    .table-modern thead th:nth-child(13), /* Alamat Lengkap */
    .table-modern thead th:nth-child(14), /* Desa */
    .table-modern thead th:nth-child(16), /* Kabupaten */
    .table-modern thead th:nth-child(17), /* Kode Pos */
    .table-modern thead th:nth-child(18), /* Status Rumah */
    .table-modern thead th:nth-child(21), /* Lama Usaha */
    .table-modern thead th:nth-child(22), /* Jumlah Karyawan */
    .table-modern thead th:nth-child(24), /* Omzet */
    .table-modern thead th:nth-child(25), /* Alamat Usaha */
    .table-modern thead th:nth-child(26), /* Legalitas */
    .table-modern thead th:nth-child(29), /* Nama Pemilik Rek */
    .table-modern thead th:nth-child(30), /* NPWP */
    .table-modern thead th:nth-child(31), /* Ahli Waris */
    .table-modern thead th:nth-child(32), /* Hubungan */
    .table-modern thead th:nth-child(33), /* No HP Waris */
    .table-modern thead th:nth-child(34), /* NIK Waris */
    .table-modern thead th:nth-child(35), /* Simpanan Pokok */
    .table-modern thead th:nth-child(36), /* Simpanan Wajib */
    .table-modern tbody td:nth-child(5),
    .table-modern tbody td:nth-child(6),
    .table-modern tbody td:nth-child(7),
    .table-modern tbody td:nth-child(9),
    .table-modern tbody td:nth-child(10),
    .table-modern tbody td:nth-child(11),
    .table-modern tbody td:nth-child(13),
    .table-modern tbody td:nth-child(14),
    .table-modern tbody td:nth-child(16),
    .table-modern tbody td:nth-child(17),
    .table-modern tbody td:nth-child(18),
    .table-modern tbody td:nth-child(21),
    .table-modern tbody td:nth-child(22),
    .table-modern tbody td:nth-child(24),
    .table-modern tbody td:nth-child(25),
    .table-modern tbody td:nth-child(26),
    .table-modern tbody td:nth-child(29),
    .table-modern tbody td:nth-child(30),
    .table-modern tbody td:nth-child(31),
    .table-modern tbody td:nth-child(32),
    .table-modern tbody td:nth-child(33),
    .table-modern tbody td:nth-child(34),
    .table-modern tbody td:nth-child(35),
    .table-modern tbody td:nth-child(36) {
        display: none !important;
    }
    
    /* TEXT ALIGNMENT BY COLUMN (untuk kolom yang ditampilkan) */
    .table-modern tbody td:nth-child(1) { text-align: center !important; } /* # */
    .table-modern tbody td:nth-child(2) { text-align: center !important; } /* No Anggota */
    .table-modern tbody td:nth-child(8) { text-align: center !important; } /* JK */
    .table-modern tbody td:nth-child(23) { text-align: right !important; } /* Modal Usaha */
    .table-modern tbody td:nth-child(37) { text-align: right !important; } /* Total Simpanan */
    .table-modern tbody td:nth-child(38) { text-align: center !important; } /* Status */
    .table-modern tbody td:nth-child(39) { text-align: center !important; } /* Tgl Daftar */
    
    .table-modern tbody tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    
    .table-modern tbody tr:nth-child(even) {
        background-color: #f9fafb !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    .table-modern tbody tr:nth-child(odd) {
        background-color: #ffffff !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    /* KOP SURAT */
    .print-header {
        display: block !important;
        text-align: center;
        margin-bottom: 8px;
        padding-bottom: 6px;
        border-bottom: 0.5px solid #000;
        page-break-inside: avoid;
    }
    
    .print-header table {
        width: 100%;
        border: none;
        margin-bottom: 0;
    }
    
    .print-header table td {
        border: none !important;
        padding: 0 !important;
    }
    
    .print-header img {
        width: 55px;
        height: 55px;
        display: inline-block;
    }
    
    .print-header h2 {
        font-size: 13px;
        margin: 2px 0;
        color: #000;
        font-weight: bold;
        text-transform: uppercase;
    }
    
    .print-header h3 {
        font-size: 11px;
        margin: 2px 0;
        color: #000;
        font-weight: bold;
        text-transform: uppercase;
    }
    
    .print-header p {
        font-size: 8px;
        color: #333;
        margin: 1px 0;
    }
    
    /* JUDUL LAPORAN */
    .print-title {
        display: block !important;
        text-align: center;
        background: transparent !important;
        padding: 5px 0;
        margin: 6px 0;
        border: none;
        border-bottom: 0.5px solid #000;
        page-break-inside: avoid;
    }
    
    .print-title h1 {
        font-size: 12px;
        color: #000;
        margin: 0 0 3px 0;
        font-weight: bold;
        text-transform: uppercase;
    }
    
    .print-title p {
        font-size: 9px;
        color: #333;
        margin: 2px 0;
    }
    
    /* SUMMARY BOX */
    .print-summary {
        display: block !important;
        margin-top: 10px;
        margin-bottom: 10px;
        padding: 6px;
        border: none;
        border-top: 0.5px solid #000;
        border-bottom: 0.5px solid #000;
        background: transparent !important;
        text-align: center;
        font-weight: bold;
        font-size: 9px;
        page-break-inside: avoid;
    }
    
    /* SIGNATURE */
    .print-signature {
        display: block !important;
        margin-top: 30px;
        text-align: right;
        font-size: 10px;
        page-break-inside: avoid;
    }
    
    .print-signature p {
        margin: 4px 0;
    }
    
    .print-signature .signature-space {
        margin: 50px 0 8px 0;
    }
    
    .print-signature .signature-name {
        font-weight: bold;
        text-decoration: underline;
    }
    
    /* BADGES */
    .badge-no-anggota,
    .badge-status {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        padding: 3px 6px !important;
        font-size: 7px !important;
    }
    
    /* Badge No Anggota - hilangkan warna di print, tampilkan text biasa */
    .badge-no-anggota {
        background: transparent !important;
        color: #000 !important;
        border: none !important;
        padding: 0 !important;
        font-weight: normal !important;
        display: none !important; /* Hide badge version */
    }
    
    /* Show plain text version for No Anggota */
    .print-only {
        display: inline !important;
        font-size: 7px !important;
        color: #000 !important;
    }
    
    .badge-secondary {
        background: transparent !important;
        color: #000 !important;
        border: none !important;
        padding: 0 !important;
        font-weight: normal !important;
    }
    
    /* Badge status dengan warna di print */
    .badge-aktif {
        background: #d1fae5 !important;
        color: #065f46 !important;
        border: 2px solid #10b981 !important;
        font-weight: bold !important;
    }
    
    .badge-pending {
        background: #fef3c7 !important;
        color: #92400e !important;
        border: 2px solid #f59e0b !important;
        font-weight: bold !important;
    }
    
    .badge-ditolak {
        background: #fee2e2 !important;
        color: #991b1b !important;
        border: 2px solid #ef4444 !important;
        font-weight: bold !important;
    }
    
    /* CARD */
    .card-modern {
        box-shadow: none !important;
        border: 1px solid #ddd;
        border-radius: 0 !important;
    }
    
    .card-header {
        background: #fbbf24 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        padding: 10px !important;
        border-radius: 0 !important;
    }
    
    .card-body {
        padding: 0 !important;
    }
    
    /* ICONS */
    .fas, .far {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    /* PAGE BREAKS */
    @page {
        size: A4 landscape;
        margin: 10mm;
    }
    
    /* HIDE ROW HIDDEN */
    .row-hidden {
        display: none !important;
    }
    
    /* SHOW PRINT ONLY ELEMENTS */
    .print-only {
        display: inline !important;
    }
}
.print-header {
    display: none;
}
.print-title {
    display: none;
}
.print-summary {
    display: none;
}
.print-signature {
    display: none;
}
.print-only {
    display: none;
}
</style>
@endpush

@push('scripts')
<script>
// Real-time filter untuk distrik
document.getElementById('distrikFilter').addEventListener('change', function() {
    const selectedDistrik = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('.table-modern tbody tr');
    let visibleCount = 0;
    
    tableRows.forEach(row => {
        // Skip empty state row
        if (row.querySelector('td[colspan]')) {
            return;
        }
        
        // Get distrik cell (column 15 - index 14)
        const distrikCell = row.cells[14];
        if (!distrikCell) return;
        
        const distrikText = distrikCell.textContent.trim().toLowerCase();
        
        if (selectedDistrik === '' || distrikText.includes(selectedDistrik)) {
            row.classList.remove('row-hidden');
            visibleCount++;
        } else {
            row.classList.add('row-hidden');
        }
    });
    
    // Update counter
    updateCounter(visibleCount);
});

function updateCounter(count) {
    const badge = document.querySelector('.card-header .badge');
    const footerText = document.querySelector('.card-footer strong');
    
    if (badge) {
        badge.innerHTML = '<i class="fas fa-database mr-1"></i>' + count + ' Anggota';
    }
    
    if (footerText) {
        footerText.innerHTML = 'Total: ' + count + ' Anggota';
    }
}
</script>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Print Header (only visible when printing) --}}
    <div class="print-header">
        <table style="width:100%;border:none">
            <tr>
                <td style="width:80px;text-align:center;border:none;vertical-align:middle">
                    @if(file_exists(public_path('images/logo-tolikara.png')))
                    <img src="{{ asset('images/logo-tolikara.png') }}" style="width:70px;height:70px">
                    @else
                    <div style="width:70px;height:70px;background:#e5e7eb;border-radius:50%;display:inline-block;line-height:70px;font-size:24px;font-weight:bold;color:#1a1a1a">T</div>
                    @endif
                </td>
                <td style="text-align:center;border:none;vertical-align:middle">
                    <h2>PEMERINTAH KABUPATEN TOLIKARA</h2>
                    <h3>DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI</h3>
                    <p>Jl. Raya Karubaga, Kab. Tolikara, Papua Pegunungan | Telp. (0964) 123456</p>
                </td>
                <td style="width:80px;border:none"></td>
            </tr>
        </table>
    </div>

    {{-- Print Title (only visible when printing) --}}
    <div class="print-title">
        <h1>📊 LAPORAN DATA ANGGOTA KOPERASI</h1>
        <p>Per Tanggal: {{ date('d F Y') }}</p>
        @if(request()->has('distrik') && request('distrik'))
            <p>Filter Distrik: {{ request('distrik') }}</p>
        @endif
        @if(request()->has('status') && request('status'))
            <p>Filter Status: {{ ucfirst(request('status')) }}</p>
        @endif
    </div>

    {{-- Filter Card --}}
    <div class="row mb-4 no-print">
        <div class="col-12">
            <div class="card card-modern" style="background:linear-gradient(135deg,#667eea,#764ba2)">
                <div class="card-body p-4">
                    <h5 class="text-white mb-3 font-weight-bold">
                        <i class="fas fa-filter mr-2"></i>Filter Rekap
                    </h5>
                    <form method="GET" action="{{ route('pimpinan.laporan.koperasi') }}">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="text-white mb-2 font-weight-600">
                                    <i class="fas fa-map-marker-alt mr-1"></i>Distrik
                                </label>
                                <select name="distrik" id="distrikFilter" class="form-control" style="border-radius:10px">
                                    <option value="">Semua Distrik</option>
                                    <option value="Airgaram" {{ request('distrik') == 'Airgaram' ? 'selected' : '' }}>Airgaram</option>
                                    <option value="Anawi" {{ request('distrik') == 'Anawi' ? 'selected' : '' }}>Anawi</option>
                                    <option value="Aweku" {{ request('distrik') == 'Aweku' ? 'selected' : '' }}>Aweku</option>
                                    <option value="Bewani" {{ request('distrik') == 'Bewani' ? 'selected' : '' }}>Bewani</option>
                                    <option value="Biandoga" {{ request('distrik') == 'Biandoga' ? 'selected' : '' }}>Biandoga</option>
                                    <option value="Biuk" {{ request('distrik') == 'Biuk' ? 'selected' : '' }}>Biuk</option>
                                    <option value="Bogonuk" {{ request('distrik') == 'Bogonuk' ? 'selected' : '' }}>Bogonuk</option>
                                    <option value="Bokondini" {{ request('distrik') == 'Bokondini' ? 'selected' : '' }}>Bokondini</option>
                                    <option value="Bokoneri" {{ request('distrik') == 'Bokoneri' ? 'selected' : '' }}>Bokoneri</option>
                                    <option value="Danime" {{ request('distrik') == 'Danime' ? 'selected' : '' }}>Danime</option>
                                    <option value="Dow" {{ request('distrik') == 'Dow' ? 'selected' : '' }}>Dow</option>
                                    <option value="Dundu" {{ request('distrik') == 'Dundu' ? 'selected' : '' }}>Dundu</option>
                                    <option value="Egiam" {{ request('distrik') == 'Egiam' ? 'selected' : '' }}>Egiam</option>
                                    <option value="Geya" {{ request('distrik') == 'Geya' ? 'selected' : '' }}>Geya</option>
                                    <option value="Gika" {{ request('distrik') == 'Gika' ? 'selected' : '' }}>Gika</option>
                                    <option value="Goyage" {{ request('distrik') == 'Goyage' ? 'selected' : '' }}>Goyage</option>
                                    <option value="Gundagi" {{ request('distrik') == 'Gundagi' ? 'selected' : '' }}>Gundagi</option>
                                    <option value="Kai" {{ request('distrik') == 'Kai' ? 'selected' : '' }}>Kai</option>
                                    <option value="Kamboneri" {{ request('distrik') == 'Kamboneri' ? 'selected' : '' }}>Kamboneri</option>
                                    <option value="Kanggime" {{ request('distrik') == 'Kanggime' ? 'selected' : '' }}>Kanggime</option>
                                    <option value="Karubaga" {{ request('distrik') == 'Karubaga' ? 'selected' : '' }}>Karubaga</option>
                                    <option value="Kembu" {{ request('distrik') == 'Kembu' ? 'selected' : '' }}>Kembu</option>
                                    <option value="Kondaga" {{ request('distrik') == 'Kondaga' ? 'selected' : '' }}>Kondaga</option>
                                    <option value="Kuari" {{ request('distrik') == 'Kuari' ? 'selected' : '' }}>Kuari</option>
                                    <option value="Kubu" {{ request('distrik') == 'Kubu' ? 'selected' : '' }}>Kubu</option>
                                    <option value="Li Anogomma" {{ request('distrik') == 'Li Anogomma' ? 'selected' : '' }}>Li Anogomma</option>
                                    <option value="Nabunage" {{ request('distrik') == 'Nabunage' ? 'selected' : '' }}>Nabunage</option>
                                    <option value="Nelawi" {{ request('distrik') == 'Nelawi' ? 'selected' : '' }}>Nelawi</option>
                                    <option value="Numba" {{ request('distrik') == 'Numba' ? 'selected' : '' }}>Numba</option>
                                    <option value="Nunggawi" {{ request('distrik') == 'Nunggawi' ? 'selected' : '' }}>Nunggawi</option>
                                    <option value="Panaga" {{ request('distrik') == 'Panaga' ? 'selected' : '' }}>Panaga</option>
                                    <option value="Poganeri" {{ request('distrik') == 'Poganeri' ? 'selected' : '' }}>Poganeri</option>
                                    <option value="Tagime" {{ request('distrik') == 'Tagime' ? 'selected' : '' }}>Tagime</option>
                                    <option value="Tagineri" {{ request('distrik') == 'Tagineri' ? 'selected' : '' }}>Tagineri</option>
                                    <option value="Telenggeme" {{ request('distrik') == 'Telenggeme' ? 'selected' : '' }}>Telenggeme</option>
                                    <option value="Timori" {{ request('distrik') == 'Timori' ? 'selected' : '' }}>Timori</option>
                                    <option value="Tiom" {{ request('distrik') == 'Tiom' ? 'selected' : '' }}>Tiom</option>
                                    <option value="Umagi" {{ request('distrik') == 'Umagi' ? 'selected' : '' }}>Umagi</option>
                                    <option value="Wakuwo" {{ request('distrik') == 'Wakuwo' ? 'selected' : '' }}>Wakuwo</option>
                                    <option value="Wari/Taiyeve II" {{ request('distrik') == 'Wari/Taiyeve II' ? 'selected' : '' }}>Wari/Taiyeve II</option>
                                    <option value="Wenam" {{ request('distrik') == 'Wenam' ? 'selected' : '' }}>Wenam</option>
                                    <option value="Wina" {{ request('distrik') == 'Wina' ? 'selected' : '' }}>Wina</option>
                                    <option value="Wollo" {{ request('distrik') == 'Wollo' ? 'selected' : '' }}>Wollo</option>
                                    <option value="Woniki" {{ request('distrik') == 'Woniki' ? 'selected' : '' }}>Woniki</option>
                                    <option value="Wugi" {{ request('distrik') == 'Wugi' ? 'selected' : '' }}>Wugi</option>
                                    <option value="Yuko" {{ request('distrik') == 'Yuko' ? 'selected' : '' }}>Yuko</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="text-white mb-2 font-weight-600">
                                    <i class="fas fa-search mr-1"></i>Cari Nama/NIK
                                </label>
                                <input type="text" name="search" class="form-control" placeholder="Ketik nama atau NIK..." style="border-radius:10px" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="text-white mb-2 font-weight-600">
                                    <i class="fas fa-check-circle mr-1"></i>Status
                                </label>
                                <select name="status" class="form-control" style="border-radius:10px">
                                    <option value="">Semua Status</option>
                                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="text-white mb-2 font-weight-600">
                                    <i class="fas fa-calendar mr-1"></i>Periode
                                </label>
                                <select name="periode" class="form-control" style="border-radius:10px">
                                    <option value="">Semua Periode</option>
                                    @foreach(\App\Models\PeriodePendaftaran::orderBy('tahun_ajaran', 'desc')->get() as $p)
                                    <option value="{{ $p->id }}" {{ request('periode') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_periode }} ({{ $p->tahun_ajaran }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="text-white mb-2 font-weight-600" style="opacity:0">Action</label>
                                <div class="d-flex" style="gap:8px">
                                    <button type="submit" class="btn btn-light flex-fill" style="border-radius:10px;font-weight:700">
                                        <i class="fas fa-search mr-1"></i>Cari
                                    </button>
                                    @if(request()->hasAny(['distrik', 'search', 'status', 'periode']))
                                    <a href="{{ route('pimpinan.laporan.koperasi') }}" class="btn btn-secondary" style="border-radius:10px;font-weight:700" title="Reset">
                                        <i class="fas fa-redo"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="row mb-3 no-print">
        <div class="col-12">
            <div class="card card-modern" style="background:linear-gradient(135deg,#059669,#10b981);border:none">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <h6 class="text-white mb-0 font-weight-bold" style="text-shadow:0 2px 4px rgba(0,0,0,0.2)">
                                <i class="fas fa-download mr-2"></i>Export & Print Data
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-md-end flex-wrap" style="gap:8px">
                                <button onclick="window.print()" class="btn btn-light btn-sm download-btn" style="border-radius:10px;font-weight:600">
                                    <i class="fas fa-print mr-1" style="color:#6366f1"></i>Print
                                </button>
                                <a href="{{ route('pimpinan.laporan.exportExcel', ['type' => 'anggota'] + request()->all()) }}" 
                                   class="btn btn-light btn-sm download-btn" 
                                   style="border-radius:10px;font-weight:600">
                                    <i class="fas fa-file-excel mr-1" style="color:#10b981"></i>Excel
                                </a>
                                <a href="{{ route('pimpinan.laporan.exportWord', ['type' => 'anggota'] + request()->all()) }}" 
                                   class="btn btn-light btn-sm download-btn" 
                                   style="border-radius:10px;font-weight:600">
                                    <i class="fas fa-file-word mr-1" style="color:#2563eb"></i>Word
                                </a>
                                <a href="{{ route('pimpinan.laporan.exportPdf', ['type' => 'anggota'] + request()->all()) }}" 
                                   class="btn btn-light btn-sm download-btn" 
                                   style="border-radius:10px;font-weight:600">
                                    <i class="fas fa-file-pdf mr-1" style="color:#ef4444"></i>PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-modern">
                <div class="card-header" style="background:linear-gradient(135deg,#fbbf24,#f59e0b);border-radius:16px 16px 0 0;padding:20px;box-shadow:0 4px 12px rgba(251,191,36,0.4)">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold" style="color:#1a1a1a;text-shadow:0 2px 4px rgba(0,0,0,0.1)">
                            <i class="fas fa-users mr-2"></i>Data Anggota Koperasi
                        </h5>
                        <span class="badge" style="font-size:14px;padding:8px 15px;background:#fff;color:#d97706;font-weight:700;box-shadow:0 2px 8px rgba(0,0,0,0.15)">
                            <i class="fas fa-database mr-1"></i>{{ $koperasi->count() }} Anggota
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern table-hover mb-0">
                            <thead style="background:linear-gradient(135deg,#fbbf24,#f59e0b);position:sticky;top:0;z-index:10;box-shadow:0 4px 12px rgba(251,191,36,0.4)">
                                <tr>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:center;width:50px;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">#</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">No. Anggota</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">NIK</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Nama Lengkap</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Email</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Tempat Lahir</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Tanggal Lahir</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:center;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">JK</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Agama</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Status Nikah</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Pendidikan</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">No. HP</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Alamat Lengkap</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Desa</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Distrik</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Kabupaten</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Kode Pos</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Status Rumah</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Nama Usaha</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Bidang Usaha</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Lama Usaha</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Jumlah Karyawan</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:right;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Modal Usaha</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:right;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Omzet/Bulan</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Alamat Usaha</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Legalitas</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Bank</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">No. Rekening</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Nama Pemilik Rek</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">NPWP</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Ahli Waris</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Hubungan</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">No. HP Waris</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">NIK Waris</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:right;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Simpanan Pokok</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:right;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Simpanan Wajib</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:right;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Total Simpanan</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:center;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Status</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:center;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Tgl Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($koperasi as $i => $k)
                                <tr>
                                    <td style="text-align:center;font-weight:600;color:#6b7280">{{ $i+1 }}</td>
                                    <td>
                                        <span class="badge-no-anggota">{{ $k->no_anggota }}</span>
                                        <span class="print-only" style="display:none">{{ $k->no_anggota }}</span>
                                    </td>
                                    <td><small style="font-family:monospace;font-size:11px">{{ $k->nik }}</small></td>
                                    <td><strong style="white-space:nowrap">{{ $k->nama }}</strong></td>
                                    <td><small>{{ $k->user->email ?? '-' }}</small></td>
                                    <td><small>{{ $k->tempat_lahir }}</small></td>
                                    <td><small style="white-space:nowrap">{{ $k->tanggal_lahir->format('d/m/Y') }}</small></td>
                                    <td style="text-align:center">
                                        @if($k->jenis_kelamin == 'L')
                                            <span class="no-print"><i class="fas fa-mars" style="color:#3b82f6" title="Laki-laki"></i></span>
                                            <span class="print-only" style="display:none">L</span>
                                        @else
                                            <span class="no-print"><i class="fas fa-venus" style="color:#ef4444" title="Perempuan"></i></span>
                                            <span class="print-only" style="display:none">P</span>
                                        @endif
                                    </td>
                                    <td><small>{{ $k->agama ?? '-' }}</small></td>
                                    <td><small>{{ $k->status_perkawinan ?? '-' }}</small></td>
                                    <td><small>{{ $k->pendidikan_terakhir ?? '-' }}</small></td>
                                    <td><small style="white-space:nowrap">
                                        <span class="no-print"><i class="fas fa-phone mr-1" style="color:#10b981"></i></span>{{ $k->no_hp }}
                                    </small></td>
                                    <td style="max-width:200px"><small>{{ $k->alamat_lengkap ?? '-' }}</small></td>
                                    <td><small>{{ $k->desa ?? '-' }}</small></td>
                                    <td>
                                        <span class="badge badge-secondary no-print">{{ $k->distrik }}</span>
                                        <span class="print-only" style="display:none">{{ $k->distrik }}</span>
                                    </td>
                                    <td><small>{{ $k->kabupaten ?? '-' }}</small></td>
                                    <td><small>{{ $k->kode_pos ?? '-' }}</small></td>
                                    <td><small>{{ $k->status_kepemilikan_rumah ?? '-' }}</small></td>
                                    <td><strong>{{ $k->nama_usaha }}</strong></td>
                                    <td><small>{{ $k->bidang_usaha }}</small></td>
                                    <td style="text-align:center"><small>{{ $k->lama_berdiri_usaha ?? 0 }} th</small></td>
                                    <td style="text-align:center"><small>{{ $k->jumlah_karyawan ?? 0 }}</small></td>
                                    <td style="text-align:right"><small>Rp {{ number_format($k->modal_usaha ?? 0, 0, ',', '.') }}</small></td>
                                    <td style="text-align:right"><small>Rp {{ number_format($k->omzet_per_bulan ?? 0, 0, ',', '.') }}</small></td>
                                    <td style="max-width:200px"><small>{{ $k->alamat_tempat_usaha ?? '-' }}</small></td>
                                    <td><small>{{ $k->legalitas_usaha ?? '-' }}</small></td>
                                    <td><small>{{ $k->nama_bank ?? '-' }}</small></td>
                                    <td><small style="font-family:monospace">{{ $k->nomor_rekening ?? '-' }}</small></td>
                                    <td><small>{{ $k->nama_pemilik_rekening ?? '-' }}</small></td>
                                    <td><small style="font-family:monospace">{{ $k->npwp ?? '-' }}</small></td>
                                    <td><strong>{{ $k->nama_ahli_waris ?? '-' }}</strong></td>
                                    <td><small>{{ $k->hubungan_ahli_waris ?? '-' }}</small></td>
                                    <td><small style="white-space:nowrap">{{ $k->no_hp_ahli_waris ?? '-' }}</small></td>
                                    <td><small style="font-family:monospace">{{ $k->nik_ahli_waris ?? '-' }}</small></td>
                                    <td style="text-align:right"><small>Rp {{ number_format($k->simpanan_pokok ?? 0, 0, ',', '.') }}</small></td>
                                    <td style="text-align:right"><small>Rp {{ number_format($k->simpanan_wajib ?? 0, 0, ',', '.') }}</small></td>
                                    <td style="text-align:right"><strong style="color:#10b981">Rp {{ number_format($k->total_simpanan ?? 0, 0, ',', '.') }}</strong></td>
                                    <td style="text-align:center">
                                        @if($k->status === 'Aktif')
                                            <span class="badge-status badge-aktif">
                                                <i class="fas fa-check-circle mr-1"></i>Aktif
                                            </span>
                                        @elseif($k->status === 'Pending')
                                            <span class="badge-status badge-pending">
                                                <i class="fas fa-clock mr-1"></i>Pending
                                            </span>
                                        @else
                                            <span class="badge-status badge-ditolak">
                                                <i class="fas fa-times-circle mr-1"></i>Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td style="text-align:center">
                                        <small style="white-space:nowrap"><i class="far fa-calendar mr-1"></i>{{ $k->created_at->format('d/m/Y') }}</small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="17" class="text-center py-5">
                                        <i class="fas fa-inbox fa-4x mb-3 d-block" style="color:#e5e7eb"></i>
                                        <h5 style="color:#6b7280">Tidak Ada Data</h5>
                                        <p style="color:#9ca3af">Belum ada data anggota yang tersedia</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer no-print" style="background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:0 0 16px 16px;padding:15px;border-top:3px solid #f59e0b">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-info-circle mr-2" style="color:#d97706"></i>
                            <strong style="color:#92400e">Total: {{ $koperasi->count() }} Anggota</strong>
                            <span style="color:#78350f"> | Saat print akan menampilkan 17 kolom penting saja</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Print Summary (Hidden on screen, visible on print) --}}
    <div class="print-summary">
        TOTAL ANGGOTA KOPERASI: {{ $koperasi->count() }} ORANG
    </div>
    
    {{-- Print Signature (Hidden on screen, visible on print) --}}
    <div class="print-signature">
        <p>Tolikara, {{ date('d F Y') }}</p>
        <p>Kepala Dinas,</p>
        <div class="signature-space"></div>
        <p class="signature-name">Wugi Kogoya, S.P</p>
        <p>NIP. 123456150890001</p>
    </div>
</div>
@endsection
