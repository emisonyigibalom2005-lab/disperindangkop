<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Anggota Koperasi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 9px;
            line-height: 1.3;
            color: #000;
            padding: 12px;
        }
        
        /* KOP SURAT */
        .kop-surat {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #000;
        }
        
        .kop-surat img {
            width: 60px;
            height: 60px;
            margin-bottom: 8px;
        }
        
        .kop-surat h2 {
            font-size: 14px;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }
        
        .kop-surat h3 {
            font-size: 12px;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }
        
        .kop-surat p {
            font-size: 9px;
            margin: 2px 0;
        }
        
        /* JUDUL LAPORAN */
        .judul-laporan {
            text-align: center;
            margin: 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #000;
        }
        
        .judul-laporan h1 {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        
        .judul-laporan p {
            font-size: 9px;
            font-style: italic;
            color: #333;
        }
        
        /* INFO FILTER */
        .info-filter {
            background: #f5f5f5;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .info-filter p {
            margin: 3px 0;
            font-size: 10px;
        }
        
        .info-filter strong {
            color: #000;
        }
        
        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table thead {
            background: #1a3a6e;
            color: white;
        }
        
        table thead th {
            padding: 6px 4px;
            text-align: center;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #000;
            letter-spacing: 0px;
            white-space: nowrap;
        }
        
        table tbody td {
            padding: 5px 3px;
            font-size: 8px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }
        
        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        table tbody tr:nth-child(odd) {
            background: #ffffff;
        }
        
        /* BADGE STATUS */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
        }
        
        .badge-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #059669;
        }
        
        .badge-warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #f59e0b;
        }
        
        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #dc2626;
        }
        
        /* SUMMARY */
        .summary-box {
            background: transparent;
            border: none;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 10px;
            margin: 15px 0;
            text-align: center;
        }
        
        .summary-box h3 {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 6px;
            color: #000;
        }
        
        .summary-box p {
            font-size: 10px;
            margin: 2px 0;
        }
        
        .summary-box strong {
            font-size: 10px;
            color: #000;
        }
        
        /* SIGNATURE */
        .signature {
            margin-top: 30px;
            text-align: right;
        }
        
        .signature p {
            margin: 5px 0;
            font-size: 10px;
        }
        
        .signature .space {
            margin: 50px 0 10px 0;
        }
        
        .signature .name {
            font-weight: bold;
            text-decoration: underline;
        }
        
        /* UTILITIES */
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .font-bold {
            font-weight: bold;
        }
        
        .text-nowrap {
            white-space: nowrap;
        }
        
        /* PAGE BREAK */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    {{-- KOP SURAT --}}
    <div class="kop-surat">
        @if(file_exists(public_path('images/logo-tolikara.png')))
        <img src="{{ public_path('images/logo-tolikara.png') }}" alt="Logo Tolikara">
        @endif
        <h2>PEMERINTAH KABUPATEN TOLIKARA</h2>
        <h3>DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI</h3>
        <p>Jl. Raya Karubaga, Kab. Tolikara, Papua Pegunungan</p>
        <p>Telp. (0964) 123456 | Email: disperindagkop@tolikarakab.go.id</p>
    </div>
    
    {{-- JUDUL LAPORAN --}}
    <div class="judul-laporan">
        <h1>📊 LAPORAN DATA ANGGOTA KOPERASI</h1>
        <p>Per Tanggal: {{ date('d F Y') }}</p>
    </div>
    
    {{-- INFO FILTER --}}
    @if(isset($filters) && (isset($filters['distrik']) || isset($filters['status']) || isset($filters['periode'])))
    <div class="info-filter">
        <p><strong>📌 Filter yang Diterapkan:</strong></p>
        @if(isset($filters['distrik']) && $filters['distrik'])
        <p>• Distrik: <strong>{{ $filters['distrik'] }}</strong></p>
        @endif
        @if(isset($filters['status']) && $filters['status'])
        <p>• Status: <strong>{{ ucfirst($filters['status']) }}</strong></p>
        @endif
        @if(isset($filters['periode']) && $filters['periode'])
        @php
            $periode = \App\Models\PeriodePendaftaran::find($filters['periode']);
        @endphp
        @if($periode)
        <p>• Periode: <strong>{{ $periode->nama_periode }}</strong></p>
        @endif
        @endif
    </div>
    @endif
    
    {{-- TABEL DATA ANGGOTA - KOLOM PENTING SAJA (17 KOLOM) --}}
    <table>
        <thead>
            <tr>
                <th style="width: 2%;">No</th>
                <th style="width: 4%;">No. Anggota</th>
                <th style="width: 5%;">NIK</th>
                <th style="width: 8%;">Nama Lengkap</th>
                <th style="width: 7%;">Tempat, Tgl Lahir</th>
                <th style="width: 2%;">JK</th>
                <th style="width: 5%;">No. HP</th>
                <th style="width: 8%;">Alamat</th>
                <th style="width: 5%;">Distrik</th>
                <th style="width: 8%;">Nama Usaha</th>
                <th style="width: 7%;">Bidang Usaha</th>
                <th style="width: 7%;">Modal Usaha</th>
                <th style="width: 5%;">Bank</th>
                <th style="width: 6%;">No. Rekening</th>
                <th style="width: 7%;">Total Simpanan</th>
                <th style="width: 4%;">Status</th>
                <th style="width: 5%;">Tgl Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $anggota)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $anggota->no_anggota }}</td>
                <td>{{ $anggota->nik }}</td>
                <td class="font-bold">{{ $anggota->nama }}</td>
                <td>{{ $anggota->tempat_lahir }}, {{ \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d/m/Y') }}</td>
                <td class="text-center">{{ $anggota->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>
                <td>{{ $anggota->no_hp }}</td>
                <td>{{ $anggota->alamat_lengkap ?? '-' }}, {{ $anggota->desa ?? '' }}</td>
                <td>{{ $anggota->distrik }}</td>
                <td class="font-bold">{{ $anggota->nama_usaha }}</td>
                <td>{{ $anggota->bidang_usaha }}</td>
                <td class="text-right">Rp {{ number_format($anggota->modal_usaha ?? 0, 0, ',', '.') }}</td>
                <td>{{ $anggota->nama_bank ?? '-' }}</td>
                <td>{{ $anggota->nomor_rekening ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($anggota->total_simpanan ?? 0, 0, ',', '.') }}</td>
                <td class="text-center">
                    @if($anggota->status === 'Aktif')
                    <span class="badge badge-success">AKTIF</span>
                    @elseif($anggota->status === 'Pending')
                    <span class="badge badge-warning">PENDING</span>
                    @else
                    <span class="badge badge-danger">{{ strtoupper($anggota->status) }}</span>
                    @endif
                </td>
                <td class="text-center">{{ $anggota->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="17" class="text-center">
                    <strong>Tidak ada data anggota koperasi</strong>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    {{-- SUMMARY BOX --}}
    <div class="summary-box">
        <h3>📊 RINGKASAN DATA</h3>
        <p><strong>Total Anggota Koperasi:</strong> {{ $data->count() }} Orang</p>
        <p><strong>Total Modal Usaha:</strong> Rp {{ number_format($data->sum('modal_usaha'), 0, ',', '.') }}</p>
        <p><strong>Total Simpanan:</strong> Rp {{ number_format($data->sum(function($a) { return ($a->simpanan_pokok ?? 0) + ($a->simpanan_wajib ?? 0); }), 0, ',', '.') }}</p>
        @php
            $statusCounts = $data->groupBy('status')->map->count();
        @endphp
        <p>
            <strong>Status:</strong> 
            Aktif: {{ $statusCounts->get('Aktif', 0) }} | 
            Pending: {{ $statusCounts->get('Pending', 0) }} | 
            Ditolak: {{ $statusCounts->get('Ditolak', 0) }}
        </p>
    </div>
    
    {{-- SIGNATURE --}}
    <div class="signature">
        <p>Tolikara, {{ date('d F Y') }}</p>
        <p><strong>Kepala Dinas,</strong></p>
        <p class="space"></p>
        <p class="name">Wugi Kogoya, S.P</p>
        <p>NIP. 123456150890001</p>
    </div>
    
    {{-- FOOTER NOTE --}}
    <div style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #ddd; text-align: center; font-size: 8px; color: #666;">
        <p>Dokumen ini dicetak secara otomatis oleh sistem pada {{ date('d F Y H:i:s') }}</p>
        <p>Dinas Perindustrian, Perdagangan dan Koperasi Kabupaten Tolikara</p>
    </div>
</body>
</html>
