<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $type == 'kartu' ? 'Kartu Anggota' : 'Sertifikat Keanggotaan' }} - {{ $anggota->nama }}</title>
    <style>
        @page {
            margin: 0;
            size: {{ $type == 'kartu' ? '85.6mm 53.98mm landscape' : 'A4 portrait' }};
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }
        
        /* Print Button - Hidden saat print */
        .print-button-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            gap: 10px;
        }
        
        .print-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(59, 130, 246, 0.4);
        }
        
        .print-btn:active {
            transform: translateY(0);
        }
        
        .back-btn {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        }
        
        .back-btn:hover {
            box-shadow: 0 6px 12px rgba(100, 116, 139, 0.4);
        }

        /* KARTU ANGGOTA - IDENTITAS PENTING DENGAN LOGO */
        .kartu-container {
            width: 85.6mm;
            height: 53.98mm;
            position: relative;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            overflow: hidden;
            page-break-after: always;
            border-radius: 3mm;
            box-sizing: border-box;
        }

        .kartu-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.08;
            background-image: 
                repeating-linear-gradient(0deg, transparent, transparent 1.5mm, rgba(30,58,138,.1) 1.5mm, rgba(30,58,138,.1) 3mm);
        }

        .kartu-content {
            position: relative;
            z-index: 2;
            padding: 4mm 5mm;
            color: #1e293b;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }

        /* Header dengan Logo Tunggal */
        .kartu-header-with-logo {
            display: flex;
            align-items: center;
            gap: 3mm;
            margin-bottom: 3mm;
        }

        .kartu-logo-single {
            width: 16mm;
            height: 16mm;
            flex-shrink: 0;
        }

        .kartu-logo-single img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .kartu-header-text {
            flex: 1;
        }

        .kartu-header-text h3 {
            margin: 0;
            font-size: 8pt;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            line-height: 1.3;
        }

        .kartu-header-text h4 {
            margin: 1mm 0 0 0;
            font-size: 7.5pt;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            line-height: 1.2;
        }

        /* Body dengan Foto di Kanan */
        .kartu-body {
            display: flex;
            gap: 4mm;
            flex: 1;
        }

        /* Data Identitas Penting di Kiri */
        .kartu-data {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .kartu-data table {
            width: 100%;
            font-size: 6.5pt;
            line-height: 1.4;
            border-collapse: collapse;
        }

        .kartu-data td {
            padding: 1mm 0;
            vertical-align: top;
        }

        .kartu-data td:first-child {
            width: 18mm;
            color: #475569;
            font-weight: 600;
        }

        .kartu-data td:nth-child(2) {
            width: 2mm;
            color: #475569;
        }

        .kartu-data td:last-child {
            color: #1e293b;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Foto di Kanan */
        .kartu-foto {
            width: 24mm;
            height: 30mm;
            background: white;
            border: 0.5mm solid #94a3b8;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 1mm 3mm rgba(0,0,0,0.2);
            position: relative;
            display: flex;
            flex-direction: column;
            border-radius: 1mm;
        }

        .kartu-foto img {
            width: 100%;
            flex: 1;
            object-fit: cover;
        }

        /* Footer */
        .kartu-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2mm;
            padding-top: 2mm;
            border-top: 0.5mm solid rgba(30,58,138,0.3);
        }

        .kartu-no-anggota {
            font-size: 8pt;
            color: #1e293b;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .kartu-tanggal {
            font-size: 7pt;
            color: #475569;
            font-weight: 600;
        }

        /* SERTIFIKAT - DESAIN ELEGANT DENGAN SUDUT BULAT */
        .sertifikat-container {
            width: 210mm;
            height: 297mm;
            position: relative;
            background: #f8f9fa;
            padding: 0;
            box-sizing: border-box;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Border Luar Abu-abu */
        .sertifikat-border-outer {
            position: relative;
            width: 92%;
            height: 82%;
            border: 4px solid #d1d5db;
            background: white;
            box-shadow: 0 15px 50px rgba(0,0,0,0.2);
            padding: 18px;
        }

        /* Border Dalam Emas */
        .sertifikat-border-inner {
            width: 100%;
            height: 100%;
            background: white;
            border: 3px solid #d4af37;
            padding: 0;
            position: relative;
            overflow: visible;
        }

        /* Logo di Atas Tengah - OPTIMIZED */
        .sertifikat-logo-top {
            position: absolute;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            text-align: center;
        }

        .sertifikat-logo-top img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            filter: drop-shadow(0 2px 6px rgba(0,0,0,0.15));
        }

        /* Sudut Biru Gelap Kiri Atas */
        .corner-top-left {
            position: absolute;
            top: -2px;
            left: -2px;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 140px 140px 0 0;
            border-color: #1e3a8a transparent transparent transparent;
            z-index: 3;
        }

        /* Sudut Biru Gelap Kanan Bawah */
        .corner-bottom-right {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 0 140px 140px;
            border-color: transparent transparent #1e3a8a transparent;
            z-index: 3;
        }

        /* Strip Emas Kiri Atas */
        .gold-strip-top-left {
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 110px 110px 0 0;
            border-color: #eab308 transparent transparent transparent;
            z-index: 4;
        }

        /* Strip Emas Kanan Bawah */
        .gold-strip-bottom-right {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 0 110px 110px;
            border-color: transparent transparent #eab308 transparent;
            z-index: 4;
        }

        /* Ornamen Emas Kiri Atas */
        .ornament-top-left {
            position: absolute;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 32pt;
            color: #d4af37;
            z-index: 5;
            font-family: serif;
        }

        /* Ornamen Emas Kanan Atas */
        .ornament-top-right {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 28pt;
            color: #d4af37;
            z-index: 5;
        }

        /* Ornamen Emas Kiri Bawah */
        .ornament-bottom-left {
            position: absolute;
            bottom: 15px;
            left: 15px;
            font-size: 32pt;
            color: #eab308;
            z-index: 5;
        }

        /* Ornamen Emas Kanan Bawah (tambahan) */
        .ornament-bottom-right {
            position: absolute;
            bottom: 150px;
            right: 25px;
            font-size: 20pt;
            color: #eab308;
            z-index: 5;
        }

        /* Header Merah - Tidak digunakan */
        .sertifikat-header-red {
            display: none;
        }

        /* Footer Emas - Tidak digunakan */
        .sertifikat-footer-gold {
            display: none;
        }

        /* Kop Surat */
        .sertifikat-kop {
            display: none;
        }

        /* Watermark */
        .sertifikat-watermark {
            display: none;
        }

        /* Content - OPTIMIZED UNTUK MUAT 1 HALAMAN */
        .sertifikat-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 70px 100px 50px 100px;
        }

        .sertifikat-title {
            font-size: 38pt;
            font-weight: 800;
            color: #1e3a8a;
            margin: 0 auto 6px auto;
            text-transform: uppercase;
            letter-spacing: 4px;
            text-align: center;
            font-family: 'Georgia', serif;
            padding: 0 20px;
            max-width: 100%;
        }

        .sertifikat-subtitle {
            font-size: 20pt;
            color: #d4af37;
            margin-bottom: 20px;
            font-weight: 600;
            font-style: italic;
            text-align: center;
            font-family: 'Brush Script MT', 'Lucida Handwriting', cursive;
            padding: 0 20px;
        }

        .sertifikat-subtitle-small {
            font-size: 11pt;
            color: #1e3a8a;
            margin-bottom: 18px;
            font-weight: 600;
            text-align: center;
        }

        .sertifikat-text {
            font-size: 10pt;
            line-height: 1.6;
            color: #4b6cb7;
            margin: 20px auto;
            text-align: center;
            max-width: 100%;
            font-weight: 500;
            padding: 0 10px;
        }

        .sertifikat-text strong {
            color: #1e3a8a;
            font-weight: 700;
        }

        .sertifikat-text-line {
            margin: 6px 0;
        }
        
        /* Box NIK dan Kabupaten - OPTIMIZED TANPA BINTANG */
        .info-box-sertifikat {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 3px solid #3b82f6;
            border-radius: 12px;
            padding: 15px 25px;
            margin: 18px auto;
            max-width: 500px;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.25);
            position: relative;
        }
        
        /* HAPUS BINTANG DEKORASI */
        .info-box-sertifikat::before {
            display: none;
        }
        
        .info-box-sertifikat table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        
        .info-box-sertifikat td {
            padding: 8px 5px;
            font-size: 10pt;
            color: #1e3a8a;
        }
        
        .info-box-sertifikat td:first-child {
            font-weight: 700;
            width: 40%;
            text-align: left;
            letter-spacing: 0.5px;
        }
        
        .info-box-sertifikat td:nth-child(2) {
            font-weight: 700;
            width: 5%;
            text-align: center;
        }
        
        .info-box-sertifikat td:last-child {
            font-weight: 800;
            text-align: left;
            color: #1e40af;
            letter-spacing: 1px;
        }

        .sertifikat-text-paragraph {
            margin: 15px auto;
            font-size: 9pt;
            line-height: 1.5;
            color: #6b7280;
            max-width: 100%;
            text-align: justify;
            text-justify: inter-word;
            padding: 0 10px;
        }

        .sertifikat-nama {
            font-size: 32pt;
            font-weight: 700;
            color: #1e3a8a;
            margin: 18px auto;
            font-style: italic;
            text-align: center;
            font-family: 'Brush Script MT', 'Lucida Handwriting', cursive;
            letter-spacing: 2px;
            border-bottom: 3px solid #d4af37;
            padding-bottom: 6px;
            display: inline-block;
            max-width: 85%;
        }

        .sertifikat-nama-wrapper {
            text-align: center;
            margin: 18px 0;
        }

        /* Logo di Footer */
        .sertifikat-logo-footer {
            display: none;
        }

        /* Tanda Tangan Section - OPTIMIZED */
        .sertifikat-ttd-section {
            position: absolute;
            bottom: 35px;
            right: 80px;
            text-align: center;
            z-index: 10;
        }

        .sertifikat-ttd-label {
            font-size: 9pt;
            color: #4b6cb7;
            margin-bottom: 3px;
            font-weight: 600;
        }

        .sertifikat-ttd-tempat {
            font-size: 8.5pt;
            color: #6b7280;
            margin-bottom: 40px;
            font-style: italic;
        }

        .sertifikat-ttd-nama {
            font-size: 9pt;
            color: #1e3a8a;
            font-weight: 700;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 3px;
            min-width: 180px;
            display: inline-block;
        }

        .sertifikat-ttd-jabatan {
            font-size: 8pt;
            color: #6b7280;
            margin-top: 4px;
            font-weight: 500;
        }

        .sertifikat-detail {
            display: none;
        }

        .sertifikat-detail table {
            display: none;
        }

        .sertifikat-detail td {
            display: none;
        }

        /* Medal Emas */
        .sertifikat-medal {
            display: none;
        }

        .medal-circle {
            display: none;
        }

        .medal-star {
            display: none;
        }

        /* Footer Tanda Tangan */
        .sertifikat-footer {
            display: none;
        }

        .sertifikat-ttd {
            display: none;
        }

        .sertifikat-ttd p {
            display: none;
        }

        .sertifikat-ttd-line {
            display: none;
        }

        .sertifikat-date {
            display: none;
        }

        /* Dekorasi Sudut */
        .corner-decoration {
            display: none;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .print-button-container {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    {{-- Print Button --}}
    <div class="print-button-container">
        <button onclick="window.print()" class="print-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 9V2H18V9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6 18H4C3.46957 18 2.96086 17.7893 2.58579 17.4142C2.21071 17.0391 2 16.5304 2 16V11C2 10.4696 2.21071 9.96086 2.58579 9.58579C2.96086 9.21071 3.46957 9 4 9H20C20.5304 9 21.0391 9.21071 21.4142 9.58579C21.7893 9.96086 22 10.4696 22 11V16C22 16.5304 21.7893 17.0391 21.4142 17.4142C21.0391 17.7893 20.5304 18 20 18H18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M18 14H6V22H18V14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Print {{ $type == 'kartu' ? 'Kartu' : 'Sertifikat' }}
        </button>
        <button onclick="window.location.href='{{ route('admin.kartu-sertifikat') }}'" class="back-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali
        </button>
    </div>
    
    {{-- Auto Print on Load --}}
    <script>
        // Auto print saat halaman dimuat
        window.addEventListener('load', function() {
            // Delay sedikit untuk memastikan semua konten sudah dimuat
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
    @if($type == 'kartu')
        {{-- KARTU ANGGOTA - IDENTITAS PENTING DENGAN 1 LOGO --}}
        <div class="kartu-container">
            <div class="kartu-pattern"></div>
            <div class="kartu-content">
                {{-- Header dengan 1 Logo di Kiri --}}
                <div class="kartu-header-with-logo">
                    <div class="kartu-logo-single">
                        <img src="{{ asset('logo.png') }}" alt="Logo">
                    </div>
                    <div class="kartu-header-text">
                        <h3>PROVINSI PAPUA PEGUNUNGAN</h3>
                        <h4>KABUPATEN TOLIKARA</h4>
                    </div>
                </div>
                
                {{-- Body: Data Identitas Lengkap + Foto --}}
                <div class="kartu-body">
                    {{-- Data Identitas Lengkap di Kiri --}}
                    <div class="kartu-data">
                        <table>
                            <tr>
                                <td>NIK</td>
                                <td>:</td>
                                <td>{{ $anggota->nik }}</td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{ strtoupper($anggota->nama) }}</td>
                            </tr>
                            <tr>
                                <td>Tempat/Tgl Lahir</td>
                                <td>:</td>
                                <td>{{ strtoupper($anggota->tempat_lahir) }}, {{ $anggota->tanggal_lahir ? $anggota->tanggal_lahir->format('d-m-Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td>{{ strtoupper($anggota->alamat_lengkap ?? $anggota->desa) }}</td>
                            </tr>
                            <tr>
                                <td>Desa</td>
                                <td>:</td>
                                <td>{{ strtoupper($anggota->desa) }}</td>
                            </tr>
                            <tr>
                                <td>Distrik</td>
                                <td>:</td>
                                <td>{{ strtoupper($anggota->distrik) }}</td>
                            </tr>
                            <tr>
                                <td>Kota</td>
                                <td>:</td>
                                <td>{{ strtoupper($anggota->kabupaten ?? 'TOLIKARA') }}</td>
                            </tr>
                            <tr>
                                <td>Nama Usaha</td>
                                <td>:</td>
                                <td>{{ strtoupper($anggota->nama_usaha ?? '-') }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    {{-- Foto di Kanan --}}
                    <div class="kartu-foto">
                        <img src="{{ $anggota->foto_url }}" alt="Foto" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div style="display:none; width:100%; flex:1; background:#e5e7eb; align-items:center; justify-content:center; color:#9ca3af; font-size:8pt; flex-direction:column;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="8" r="4" fill="#9ca3af"/>
                                <path d="M6 21C6 17.134 8.686 14 12 14C15.314 14 18 17.134 18 21" stroke="#9ca3af" stroke-width="2"/>
                            </svg>
                            <span style="font-size:6pt; margin-top:1mm;">No Photo</span>
                        </div>
                    </div>
                </div>
                
                {{-- Footer dengan No. Anggota dan Tanggal --}}
                <div class="kartu-footer">
                    <div class="kartu-tanggal">
                        Terdaftar: {{ $anggota->created_at->format('d-m-Y') }}
                    </div>
                    <div class="kartu-no-anggota">
                        No. Anggota: {{ $anggota->no_anggota }}
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- SERTIFIKAT - DESAIN ELEGANT DENGAN SUDUT BULAT --}}
        <div class="sertifikat-container">
            {{-- Border Luar Abu-abu --}}
            <div class="sertifikat-border-outer">
                {{-- Border Dalam Emas --}}
                <div class="sertifikat-border-inner">
                    {{-- Logo di Atas Tengah --}}
                    <div class="sertifikat-logo-top">
                        <img src="{{ asset('logo.png') }}" alt="Logo Koperasi">
                    </div>
                    
                    {{-- Sudut Biru Gelap Kiri Atas --}}
                    <div class="corner-top-left"></div>
                    
                    {{-- Sudut Biru Gelap Kanan Bawah --}}
                    <div class="corner-bottom-right"></div>
                    
                    {{-- Strip Emas Kiri Atas --}}
                    <div class="gold-strip-top-left"></div>
                    
                    {{-- Strip Emas Kanan Bawah --}}
                    <div class="gold-strip-bottom-right"></div>
                    
                    {{-- Ornamen Emas Atas Tengah --}}
                    <div class="ornament-top-left">❦</div>
                    
                    {{-- Ornamen Emas Kanan Atas --}}
                    <div class="ornament-top-right">✦</div>
                    
                    {{-- Ornamen Emas Kiri Bawah --}}
                    <div class="ornament-bottom-left">✦</div>
                    
                    {{-- Content --}}
                    <div class="sertifikat-content">
                        {{-- Title --}}
                        <div class="sertifikat-title">SERTIFIKAT</div>
                        <div class="sertifikat-subtitle">Keanggotaan Koperasi</div>
                        
                        <div class="sertifikat-subtitle-small">Dengan Bangga Diberikan Kepada :</div>
                        
                        {{-- Nama Penerima dengan Garis Bawah --}}
                        <div class="sertifikat-nama-wrapper">
                            <div class="sertifikat-nama">{{ $anggota->nama }}</div>
                        </div>
                        
                        {{-- Box NIK dan Kabupaten - Lebih Menarik dengan Icon --}}
                        <div class="info-box-sertifikat">
                            <table>
                                <tr>
                                    <td>📋 NIK</td>
                                    <td>:</td>
                                    <td>{{ $anggota->nik }}</td>
                                </tr>
                                <tr>
                                    <td>🏛️ Kabupaten</td>
                                    <td>:</td>
                                    <td>{{ strtoupper($anggota->kabupaten ?? 'TOLIKARA') }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        {{-- Teks Deskripsi yang Menarik --}}
                        <div class="sertifikat-text">
                            <div class="sertifikat-text-line">Atas diraihnya status sebagai <strong>Anggota Resmi Koperasi</strong></div>
                            <div class="sertifikat-text-line">dengan No. Anggota <strong>{{ $anggota->no_anggota }}</strong></div>
                            <div class="sertifikat-text-line">sejak tanggal <strong>{{ $anggota->tanggal_bergabung ? \Carbon\Carbon::parse($anggota->tanggal_bergabung)->format('d F Y') : \Carbon\Carbon::now()->format('d F Y') }}</strong></div>
                            <div class="sertifikat-text-line">di <strong>{{ optional($anggota->koperasi)->nama_usaha ?? 'Koperasi Tolikara' }}</strong></div>
                        </div>
                        
                        {{-- Paragraf Singkat yang Menarik --}}
                        <div class="sertifikat-text-paragraph">
                            Dengan ini dinyatakan bahwa yang bersangkutan telah memenuhi seluruh persyaratan untuk menjadi anggota koperasi. 
                            Sertifikat ini sebagai bukti keanggotaan yang sah dan berhak atas segala fasilitas serta kewajiban sebagai anggota koperasi.
                        </div>
                    </div>
                    
                    {{-- Ornamen Emas Kanan Bawah (dekat tanda tangan) --}}
                    <div class="ornament-bottom-right">✦</div>
                    
                    {{-- Tanda Tangan Kepala Dinas --}}
                    <div class="sertifikat-ttd-section">
                        <div class="sertifikat-ttd-tempat">Tolikara, {{ \Carbon\Carbon::now()->format('d F Y') }}</div>
                        <div class="sertifikat-ttd-label">Kepala Dinas</div>
                        <div class="sertifikat-ttd-nama">Wugi Kogoya, S.P</div>
                        <div class="sertifikat-ttd-jabatan">NIP. 123456150890001</div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</body>
</html>
