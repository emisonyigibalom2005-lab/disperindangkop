<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Program Bantuan Koperasi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            line-height: 1.3;
            color: #000;
            padding: 15px;
        }
        
        /* Kop Surat */
        .header {
            text-align: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 3px solid #000;
        }
        
        .header img {
            width: 55px;
            height: 55px;
            margin-bottom: 6px;
        }
        
        .header h2 {
            font-size: 12px;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }
        
        .header p {
            font-size: 8px;
            margin: 1px 0;
            color: #333;
        }
        
        .header .line-double {
            border-bottom: 1px solid #000;
            margin-top: 2px;
        }
        
        /* Title */
        .title {
            text-align: center;
            margin: 10px 0 8px 0;
            padding-bottom: 6px;
            border-bottom: 2px solid #000;
        }
        
        .title h1 {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .subtitle {
            text-align: center;
            font-size: 8px;
            font-style: italic;
            color: #666;
            margin-bottom: 12px;
        }
        
        /* Section Title */
        .section-title {
            font-size: 10px;
            margin: 15px 0 8px 0;
            font-weight: bold;
            color: #1a3a6e;
            border-bottom: 2px solid #1a3a6e;
            padding-bottom: 3px;
        }
        
        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        
        table th {
            background-color: #1a3a6e;
            color: white;
            font-weight: bold;
            font-size: 7px;
            padding: 6px 4px;
            text-align: center;
            border: 1px solid #000;
            text-transform: uppercase;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        table td {
            padding: 5px 4px;
            border: 1px solid #333;
            font-size: 7px;
            vertical-align: middle;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-bold {
            font-weight: bold;
        }
        
        /* Badge - No colors for print */
        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 7px;
            font-weight: bold;
            background-color: transparent;
            color: #000;
            border: 1px solid #333;
        }
        
        .badge-code,
        .badge-info,
        .badge-success,
        .badge-danger,
        .badge-warning {
            background-color: transparent;
            color: #000;
            border: 1px solid #333;
        }
        
        /* Summary Box */
        .summary-box {
            margin-top: 12px;
            padding: 8px;
            background-color: #f3f4f6;
            border: 2px solid #000;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        /* Signature */
        .signature {
            margin-top: 25px;
            text-align: right;
            font-size: 8px;
        }
        
        .signature p {
            margin: 3px 0;
        }
        
        .signature-space {
            margin: 40px 0 6px 0;
        }
        
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }
        
        /* No Data */
        .no-data {
            text-align: center;
            padding: 40px;
            font-size: 12px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    {{-- Kop Surat --}}
    <div class="header">
        @if(file_exists(public_path('images/logo-tolikara.png')))
            <img src="{{ public_path('images/logo-tolikara.png') }}" alt="Logo">
        @endif
        <h2>PEMERINTAH KABUPATEN TOLIKARA</h2>
        <h2>DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI</h2>
        <p>Jl. Raya Karubaga, Kab. Tolikara, Papua Pegunungan | Telp. (0964) 123456</p>
        <div class="line-double"></div>
    </div>
    
    {{-- Title --}}
    <div class="title">
        <h1>LAPORAN PROGRAM BANTUAN KOPERASI</h1>
    </div>
    
    <div class="subtitle">
        Per Tanggal: {{ $tanggalCetak ?? date('d F Y') }}
    </div>
    
    {{-- Tabel 1: Tren per Tahun --}}
    @if(isset($bantuanPerTahun) && $bantuanPerTahun->count() > 0)
    <div class="section-title">TREN PENERIMA BANTUAN PER TAHUN</div>
    <table>
        <thead>
            <tr>
                <th style="width: 10%">No</th>
                <th style="width: 20%">Tahun</th>
                <th style="width: 35%">Jumlah Penerima</th>
                <th style="width: 35%">Total Nilai Bantuan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bantuanPerTahun as $i => $b)
            <tr>
                <td class="text-center text-bold">{{ $i + 1 }}</td>
                <td class="text-center text-bold" style="font-size:9px">{{ $b->tahun }}</td>
                <td class="text-center">
                    <span class="badge">{{ $b->total }} orang</span>
                </td>
                <td class="text-right text-bold">
                    Rp {{ number_format($b->total_nilai, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- Tabel 2: Data Pengajuan Bantuan --}}
    @if(isset($pengajuanBantuan) && $pengajuanBantuan->count() > 0)
    <div class="section-title">DATA PENGAJUAN BANTUAN</div>
    <table>
        <thead>
            <tr>
                <th style="width: 4%">No</th>
                <th style="width: 10%">Tanggal</th>
                <th style="width: 18%">Nama Pemohon</th>
                <th style="width: 12%">Kontak</th>
                <th style="width: 15%">Nama Usaha</th>
                <th style="width: 10%">Jenis</th>
                <th style="width: 13%">Jumlah (Rp)</th>
                <th style="width: 10%">Periode</th>
                <th style="width: 8%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengajuanBantuan as $i => $p)
            <tr>
                <td class="text-center text-bold">{{ $i + 1 }}</td>
                <td class="text-center">
                    {{ $p->created_at->format('d/m/Y') }}
                    <br><small style="color:#666;font-size:6px">{{ $p->created_at->format('H:i') }}</small>
                </td>
                <td class="text-bold">
                    {{ $p->nama_pemohon }}
                    @if($p->anggota)
                    <br><small style="color:#666;font-size:6px">ID: {{ $p->anggota->id }}</small>
                    @endif
                </td>
                <td style="font-size:7px">
                    {{ $p->no_hp }}
                    @if($p->email)
                    <br><small style="color:#666;font-size:6px">{{ Str::limit($p->email, 18) }}</small>
                    @endif
                </td>
                <td class="text-bold">{{ $p->nama_usaha }}</td>
                <td class="text-center">
                    <span class="badge">{{ $p->jenis_bantuan }}</span>
                </td>
                <td class="text-right text-bold">
                    Rp {{ number_format($p->jumlah_diajukan, 0, ',', '.') }}
                </td>
                <td class="text-center">
                    @if($p->periodeBantuan)
                    <span style="font-size:7px;font-weight:bold">{{ $p->periodeBantuan->nama_periode }}</span>
                    @else
                    <span style="color:#999">-</span>
                    @endif
                </td>
                <td class="text-center">
                    @if($p->status === 'pending')
                        <span class="badge">Pending</span>
                    @elseif($p->status === 'diproses')
                        <span class="badge">Diproses</span>
                    @elseif($p->status === 'disetujui')
                        <span class="badge">Disetujui</span>
                    @elseif($p->status === 'ditolak')
                        <span class="badge">Ditolak</span>
                    @else
                        <span class="badge">Selesai</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{-- Summary --}}
    <div class="summary-box">
        Total Pengajuan: {{ $pengajuanBantuan->count() }} | 
        Total Nilai Diajukan: Rp {{ number_format($pengajuanBantuan->sum('jumlah_diajukan'), 0, ',', '.') }} |
        Disetujui: {{ $pengajuanBantuan->where('status', 'disetujui')->count() }} |
        Pending: {{ $pengajuanBantuan->where('status', 'pending')->count() }}
    </div>
    @else
    <div class="no-data">
        Belum ada data pengajuan bantuan yang tersedia
    </div>
    @endif
    
    {{-- Signature --}}
    <div class="signature">
        <p>Tolikara, {{ date('d F Y') }}</p>
        <p>Kepala Dinas,</p>
        <div class="signature-space"></div>
        <p class="signature-name">Wugi Kogoya, S.P</p>
        <p>NIP. 123456150890001</p>
    </div>
</body>
</html>
