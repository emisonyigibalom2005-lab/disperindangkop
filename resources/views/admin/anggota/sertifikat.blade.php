<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dokumen Anggota - {{ $anggota->nama }}</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background:#f5f5f5; }

@media print {
    body { background:white; }
    .no-print { display:none!important; }
    .page-break { page-break-before:always; }
}

/* TOOLBAR */
.toolbar { background:white; padding:15px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.1); position:sticky; top:0; z-index:100; }
.toolbar button { padding:12px 28px; background:linear-gradient(135deg,#667eea,#764ba2); color:white; border:none; border-radius:8px; cursor:pointer; font-size:14px; font-weight:700; margin:0 6px; transition:all 0.3s; }
.toolbar button:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(102,126,234,0.4); }
.toolbar button.secondary { background:linear-gradient(135deg,#6b7280,#4b5563); }

.container { max-width:900px; margin:30px auto; padding:0 20px; }

/* COVER PAGE */
.cover-page { background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); min-height:100vh; display:flex; flex-direction:column; justify-content:center; align-items:center; color:white; text-align:center; position:relative; overflow:hidden; }
.cover-page::before { content:''; position:absolute; top:-100px; right:-100px; width:400px; height:400px; background:rgba(255,255,255,0.1); border-radius:50%; }
.cover-page::after { content:''; position:absolute; bottom:-150px; left:-150px; width:500px; height:500px; background:rgba(255,255,255,0.08); border-radius:50%; }
.cover-logo { width:150px; height:150px; background:rgba(255,255,255,0.2); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:30px; backdrop-filter:blur(10px); border:4px solid rgba(255,255,255,0.3); position:relative; z-index:1; }
.cover-logo i { font-size:70px; }
.cover-title { font-size:42px; font-weight:800; letter-spacing:2px; margin-bottom:15px; position:relative; z-index:1; text-shadow:0 2px 10px rgba(0,0,0,0.2); }
.cover-subtitle { font-size:18px; opacity:0.95; margin-bottom:10px; position:relative; z-index:1; }
.cover-divider { width:120px; height:4px; background:rgba(255,255,255,0.5); margin:25px auto; border-radius:2px; position:relative; z-index:1; }
.cover-info { font-size:16px; font-weight:600; position:relative; z-index:1; }
.cover-footer { position:absolute; bottom:40px; font-size:13px; opacity:0.8; }

/* KARTU ANGGOTA */
.kartu-wrapper { background:white; border-radius:20px; padding:40px; box-shadow:0 8px 30px rgba(0,0,0,0.12); margin-bottom:40px; }
.doc-header { text-align:center; border-bottom:3px solid #667eea; padding-bottom:25px; margin-bottom:30px; }
.doc-logo-container { display:flex; align-items:center; justify-content:center; gap:20px; margin-bottom:20px; }
.doc-logo { width:80px; height:80px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:35px; box-shadow:0 4px 15px rgba(102,126,234,0.3); }
.doc-title { flex:1; text-align:left; }
.doc-title h1 { font-size:24px; font-weight:800; color:#1f2937; margin-bottom:5px; letter-spacing:1px; }
.doc-title p { font-size:14px; color:#6b7280; }
.doc-subtitle { font-size:16px; color:#667eea; font-weight:700; letter-spacing:3px; margin-top:15px; }

.kartu-content { display:flex; gap:35px; margin-bottom:30px; }
.kartu-foto-section { flex-shrink:0; text-align:center; }
.kartu-foto { width:140px; height:180px; object-fit:cover; border:4px solid #667eea; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
.no-anggota-badge { background:linear-gradient(135deg,#667eea,#764ba2); color:white; padding:8px 16px; border-radius:8px; font-size:16px; font-weight:800; letter-spacing:2px; margin-top:12px; display:inline-block; }

.kartu-data { flex:1; }
.data-table { width:100%; }
.data-table tr { border-bottom:1px solid #f3f4f6; }
.data-table td { padding:12px 0; font-size:14px; }
.data-table td:first-child { color:#6b7280; font-weight:600; width:40%; }
.data-table td:last-child { color:#1f2937; font-weight:700; }
.status-badge { display:inline-block; padding:6px 16px; border-radius:20px; font-size:12px; font-weight:700; }
.status-aktif { background:#d1fae5; color:#065f46; }
.status-pending { background:#fef3c7; color:#92400e; }

.kartu-footer { border-top:2px solid #f3f4f6; padding-top:25px; display:flex; justify-content:space-between; align-items:end; }
.footer-info { font-size:13px; color:#6b7280; line-height:1.8; }
.footer-info strong { color:#1f2937; display:block; margin-bottom:4px; }
.ttd-section { text-align:center; min-width:200px; }
.ttd-label { font-size:13px; color:#6b7280; margin-bottom:60px; }
.ttd-line { border-top:2px solid #1f2937; padding-top:8px; font-size:14px; font-weight:700; color:#1f2937; }
.ttd-jabatan { font-size:12px; color:#6b7280; margin-top:4px; }

/* SERTIFIKAT - DESAIN BARU SESUAI GAMBAR */
.sertifikat-wrapper { 
    background:white; 
    border:12px solid #d4af37; 
    border-radius:0; 
    padding:0; 
    position:relative; 
    overflow:hidden; 
    margin-bottom:40px; 
    box-shadow:0 8px 30px rgba(0,0,0,0.15); 
    min-height:297mm;
}
.sertifikat-wrapper::before { 
    content:''; 
    position:absolute; 
    inset:8px; 
    border:2px solid #8b7355; 
    pointer-events:none; 
}
.sertifikat-wrapper::after { 
    content:''; 
    position:absolute; 
    inset:12px; 
    border:2px solid #d4af37; 
    pointer-events:none; 
}

/* Dekorasi Sudut Emas */
.corner-gold { 
    position:absolute; 
    width:50px; 
    height:50px; 
    border:3px solid #d4af37; 
    z-index:10; 
}
.corner-gold.top-left { top:20px; left:20px; border-right:none; border-bottom:none; }
.corner-gold.top-right { top:20px; right:20px; border-left:none; border-bottom:none; }
.corner-gold.bottom-left { bottom:20px; left:20px; border-right:none; border-top:none; }
.corner-gold.bottom-right { bottom:20px; right:20px; border-left:none; border-top:none; }

.sertifikat-content { 
    position:relative; 
    z-index:1; 
    text-align:center; 
    padding:40px 60px;
}

/* Logo di Atas */
.sertifikat-logo { 
    width:80px; 
    height:80px; 
    margin:0 auto 20px; 
    background:linear-gradient(135deg,#1a3a6e,#2563eb); 
    border-radius:50%; 
    display:flex; 
    align-items:center; 
    justify-content:center; 
    color:white; 
    font-size:40px; 
    box-shadow:0 4px 15px rgba(26,58,110,0.3);
}

/* Kop Surat */
.sertifikat-kop { 
    text-align:center; 
    border-bottom:3px solid #1a3a6e; 
    padding-bottom:15px; 
    margin-bottom:30px;
}
.sertifikat-kop h2 { 
    font-size:16px; 
    font-weight:800; 
    color:#1a3a6e; 
    margin:0 0 5px 0; 
    letter-spacing:1px;
}
.sertifikat-kop h3 { 
    font-size:14px; 
    font-weight:700; 
    color:#2563eb; 
    margin:0 0 8px 0;
}
.sertifikat-kop p { 
    font-size:11px; 
    color:#6b7280; 
    margin:0;
}

/* Judul SERTIFIKAT */
.sertifikat-title { 
    font-size:48px; 
    font-weight:800; 
    color:#1a3a6e; 
    letter-spacing:12px; 
    margin:30px 0 10px 0;
}

.sertifikat-subtitle { 
    font-size:18px; 
    color:#2563eb; 
    margin-bottom:25px; 
    font-weight:700; 
    letter-spacing:2px;
}

.sertifikat-text { 
    font-size:14px; 
    color:#6b7280; 
    margin:20px 0;
}

/* Nama Penerima */
.sertifikat-nama { 
    font-size:36px; 
    font-weight:800; 
    color:#d4af37; 
    margin:25px 0; 
    font-style:italic;
}

/* Box Data Biru */
.sertifikat-data-box { 
    background:linear-gradient(135deg,#dbeafe 0%,#bfdbfe 100%); 
    border:3px solid #2563eb; 
    border-radius:15px; 
    padding:25px 40px; 
    margin:30px auto; 
    max-width:600px; 
    box-shadow:0 4px 15px rgba(37,99,235,0.2);
}

.sertifikat-table { 
    width:100%; 
    font-size:13px;
}
.sertifikat-table td { 
    padding:10px 0; 
    line-height:1.6;
}
.sertifikat-table td:first-child { 
    color:#1e40af; 
    font-weight:700; 
    width:40%; 
    text-align:left;
}
.sertifikat-table td:nth-child(2) { 
    width:5%; 
    color:#6b7280;
}
.sertifikat-table td:last-child { 
    font-weight:700; 
    color:#1e293b; 
    text-align:left;
}

/* Medal Emas */
.sertifikat-medal { 
    width:70px; 
    height:70px; 
    margin:25px auto; 
    background:linear-gradient(135deg,#fbbf24,#f59e0b); 
    border-radius:50%; 
    display:flex; 
    align-items:center; 
    justify-content:center; 
    box-shadow:0 6px 20px rgba(245,158,11,0.4); 
    position:relative;
}
.sertifikat-medal::before { 
    content:'★'; 
    font-size:36px; 
    color:white;
}

/* Footer TTD */
.sertifikat-footer { 
    display:flex; 
    justify-content:space-between; 
    margin-top:40px; 
    padding:0 60px;
}
.sertifikat-ttd { 
    text-align:center; 
    min-width:200px;
}
.sertifikat-ttd p { 
    font-size:13px; 
    color:#6b7280; 
    margin-bottom:60px;
}
.sertifikat-ttd-line { 
    border-top:2px solid #1a3a6e; 
    padding-top:8px; 
    font-weight:700; 
    font-size:14px; 
    color:#1a3a6e;
}
.sertifikat-date { 
    text-align:right; 
    font-size:13px; 
    color:#6b7280; 
    margin-top:15px; 
    font-style:italic;
}

/* SURAT KETERANGAN */
.surat-wrapper { background:white; padding:50px; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1); margin-bottom:40px; }
.surat-kop { text-align:center; border-bottom:4px double #1f2937; padding-bottom:20px; margin-bottom:30px; }
.surat-kop-logo { width:70px; height:70px; margin:0 auto 15px; }
.surat-kop h2 { font-size:22px; font-weight:800; color:#1f2937; margin-bottom:5px; letter-spacing:1px; }
.surat-kop p { font-size:13px; color:#6b7280; line-height:1.6; }
.surat-nomor { text-align:center; margin-bottom:30px; }
.surat-nomor h3 { font-size:18px; font-weight:800; color:#1f2937; text-decoration:underline; margin-bottom:8px; }
.surat-nomor p { font-size:13px; color:#6b7280; }
.surat-body { font-size:14px; line-height:1.9; color:#374151; text-align:justify; }
.surat-body p { margin-bottom:15px; }
.surat-data { background:#f9fafb; padding:20px; border-left:4px solid #667eea; border-radius:8px; margin:20px 0; }
.surat-data table { width:100%; font-size:14px; }
.surat-data td { padding:8px 0; }
.surat-data td:first-child { width:35%; color:#6b7280; }
.surat-data td:last-child { font-weight:700; color:#1f2937; }
.surat-ttd { margin-top:40px; display:flex; justify-content:flex-end; }
.surat-ttd-box { text-align:center; min-width:250px; }
.surat-ttd-box p { font-size:14px; color:#374151; margin-bottom:70px; }
.surat-ttd-nama { border-top:2px solid #1f2937; padding-top:8px; font-weight:700; font-size:15px; color:#1f2937; }
.surat-ttd-nip { font-size:12px; color:#6b7280; margin-top:4px; }

@media print {
    .kartu-wrapper, .sertifikat-wrapper, .surat-wrapper { box-shadow:none; }
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

{{-- TOOLBAR --}}
<div class="toolbar no-print">
    <button onclick="window.print()"><i class="fas fa-print"></i> Cetak Dokumen</button>
    <button class="secondary" onclick="window.close()"><i class="fas fa-times"></i> Tutup</button>
</div>

<div class="container">
    @php $type = request('type', 'kartu'); @endphp

    {{-- COVER PAGE --}}
    @if($type === 'semua')
    <div class="cover-page page-break">
        <div class="cover-logo">
            <i class="fas fa-certificate"></i>
        </div>
        <h1 class="cover-title">DOKUMEN ANGGOTA</h1>
        <p class="cover-subtitle">Dinas Perindustrian, Perdagangan dan Koperasi</p>
        <p class="cover-subtitle">Kabupaten Tolikara, Papua Pegunungan</p>
        <div class="cover-divider"></div>
        <div class="cover-info">
            <p style="font-size:20px;margin-bottom:8px;">{{ strtoupper($anggota->nama) }}</p>
            <p>No. Anggota: {{ $anggota->no_anggota }}</p>
        </div>
        <p class="cover-footer">Diterbitkan: {{ now()->format('d F Y') }}</p>
    </div>
    @endif

    {{-- KARTU ANGGOTA --}}
    @if(in_array($type, ['kartu', 'semua']))
    <div class="kartu-wrapper {{ $type === 'semua' ? 'page-break' : '' }}">
        <div class="doc-header">
            <div class="doc-logo-container">
                <div class="doc-logo">
                    <i class="fas fa-building"></i>
                </div>
                <div class="doc-title">
                    <h1>DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI</h1>
                    <p>Kabupaten Tolikara, Provinsi Papua Pegunungan</p>
                    <p style="font-size:12px;margin-top:4px;">Jl. Raya Karubaga, Tolikara - Papua Pegunungan</p>
                </div>
            </div>
            <div class="doc-subtitle">KARTU ANGGOTA KOPERASI</div>
        </div>

        <div class="kartu-content">
            <div class="kartu-foto-section">
                <img src="{{ $anggota->foto_url }}" class="kartu-foto" alt="Foto {{ $anggota->nama }}">
                <div class="no-anggota-badge">{{ $anggota->no_anggota }}</div>
            </div>

            <div class="kartu-data">
                <table class="data-table">
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>: {{ strtoupper($anggota->nama) }}</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>: {{ $anggota->nik }}</td>
                    </tr>
                    <tr>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>: {{ $anggota->tempat_lahir }}, {{ $anggota->tanggal_lahir->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>: {{ $anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $anggota->alamat }}</td>
                    </tr>
                    <tr>
                        <td>Distrik / Kabupaten</td>
                        <td>: {{ $anggota->distrik }}, {{ $anggota->kabupaten }}</td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>: {{ $anggota->no_hp }}</td>
                    </tr>
                    <tr>
                        <td>Nama Usaha</td>
                        <td>: {{ $anggota->nama_usaha }}</td>
                    </tr>
                    <tr>
                        <td>Status Keanggotaan</td>
                        <td>: <span class="status-badge status-{{ strtolower($anggota->status) }}">{{ strtoupper($anggota->status) }}</span></td>
                    </tr>
                    <tr>
                        <td>Tanggal Terdaftar</td>
                        <td>: {{ $anggota->created_at->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="kartu-footer">
            <div class="footer-info">
                <strong>DISPERINDAGKOP Kabupaten Tolikara</strong>
                Jl. Raya Karubaga, Papua Pegunungan<br>
                Telp: (0969) 12345 | Email: disperindagkop@tolikara.go.id
            </div>
            <div class="ttd-section">
                <div class="ttd-label">Karubaga, {{ now()->format('d F Y') }}</div>
                <div class="ttd-line">KEPALA DINAS</div>
                <div class="ttd-jabatan">DISPERINDAGKOP Kab. Tolikara</div>
            </div>
        </div>
    </div>
    @endif

    {{-- SERTIFIKAT --}}
    @if(in_array($type, ['sertifikat', 'semua']))
    <div class="sertifikat-wrapper {{ $type === 'semua' ? 'page-break' : '' }}">
        {{-- Dekorasi Sudut --}}
        <div class="corner-gold top-left"></div>
        <div class="corner-gold top-right"></div>
        <div class="corner-gold bottom-left"></div>
        <div class="corner-gold bottom-right"></div>

        <div class="sertifikat-content">
            {{-- Logo --}}
            <div class="sertifikat-logo">
                <i class="fas fa-building"></i>
            </div>

            {{-- Kop Surat --}}
            <div class="sertifikat-kop">
                <h2>PEMERINTAH KABUPATEN TOLIKARA</h2>
                <h3>DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI</h3>
                <p>Jl. Raya Karubaga, Tolikara, Papua Pegunungan | Email: disperindagkop@tolikara.go.id | Telp: (0969) 123456</p>
            </div>

            {{-- Judul --}}
            <h1 class="sertifikat-title">SERTIFIKAT</h1>
            <p class="sertifikat-subtitle">KEANGGOTAAN KOPERASI</p>

            <p class="sertifikat-text">Dengan bangga dipersembahkan kepada:</p>

            {{-- Nama --}}
            <div class="sertifikat-nama">{{ $anggota->nama }}</div>

            {{-- Box Data --}}
            <div class="sertifikat-data-box">
                <table class="sertifikat-table">
                    <tr>
                        <td>No. Anggota</td>
                        <td>:</td>
                        <td>{{ $anggota->no_anggota }}</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td>{{ $anggota->nik }}</td>
                    </tr>
                    <tr>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>:</td>
                        <td>{{ $anggota->tempat_lahir }}, {{ $anggota->tanggal_lahir->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $anggota->alamat }}, {{ $anggota->distrik }}</td>
                    </tr>
                    <tr>
                        <td>Koperasi</td>
                        <td>:</td>
                        <td>{{ $anggota->nama_usaha }}</td>
                    </tr>
                </table>
            </div>

            <p class="sertifikat-text">
                Telah terdaftar sebagai <strong>Anggota Resmi Koperasi</strong><br>
                sejak tanggal <strong>{{ $anggota->created_at->format('d F Y') }}</strong><br>
                dan berhak atas segala fasilitas dan kewajiban sebagai anggota koperasi.
            </p>

            {{-- Medal --}}
            <div class="sertifikat-medal"></div>

            {{-- Footer TTD --}}
            <div class="sertifikat-footer">
                <div class="sertifikat-ttd">
                    <p>Ketua Koperasi</p>
                    <div class="sertifikat-ttd-line">(...........................)</div>
                </div>
                <div class="sertifikat-ttd">
                    <p>Kepala Dinas</p>
                    <div class="sertifikat-ttd-line">(...........................)</div>
                </div>
            </div>

            <div class="sertifikat-date">
                Tolikara, {{ now()->format('d F Y') }}
            </div>
        </div>
    </div>
    @endif

    {{-- SURAT KETERANGAN --}}
    @if(in_array($type, ['surat', 'semua']) || request('surat'))
    <div class="surat-wrapper {{ $type === 'semua' ? 'page-break' : '' }}">
        <div class="surat-kop">
            <div style="display:flex;align-items:center;justify-content:center;gap:20px;margin-bottom:15px;">
                <div style="width:70px;height:70px;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:32px;">
                    <i class="fas fa-building"></i>
                </div>
                <div style="text-align:left;">
                    <h2>PEMERINTAH KABUPATEN TOLIKARA</h2>
                    <h2>DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI</h2>
                </div>
            </div>
            <p>Jl. Raya Karubaga, Tolikara - Papua Pegunungan</p>
            <p>Telp: (0969) 12345 | Email: disperindagkop@tolikara.go.id</p>
        </div>

        <div class="surat-nomor">
            <h3>SURAT KETERANGAN ANGGOTA KOPERASI</h3>
            <p>Nomor: {{ $anggota->no_anggota }}/SK-ANGGOTA/DISPERIN DAGKOP/{{ now()->format('Y') }}</p>
        </div>

        <div class="surat-body">
            <p>Yang bertanda tangan di bawah ini, Kepala Dinas Perindustrian, Perdagangan dan Koperasi Kabupaten Tolikara, dengan ini menerangkan bahwa:</p>

            <div class="surat-data">
                <table>
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>: <strong>{{ strtoupper($anggota->nama) }}</strong></td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>: {{ $anggota->nik }}</td>
                    </tr>
                    <tr>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>: {{ $anggota->tempat_lahir }}, {{ $anggota->tanggal_lahir->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>: {{ $anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $anggota->alamat }}, {{ $anggota->distrik }}, {{ $anggota->kabupaten }}</td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>: {{ $anggota->no_hp }}</td>
                    </tr>
                    <tr>
                        <td>Nama Usaha</td>
                        <td>: {{ $anggota->nama_usaha }}</td>
                    </tr>
                    <tr>
                        <td>No. Anggota</td>
                        <td>: <strong>{{ $anggota->no_anggota }}</strong></td>
                    </tr>
                    <tr>
                        <td>Status Keanggotaan</td>
                        <td>: <strong>{{ strtoupper($anggota->status) }}</strong></td>
                    </tr>
                    <tr>
                        <td>Tanggal Terdaftar</td>
                        <td>: {{ $anggota->created_at->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Total Simpanan</td>
                        <td>: Rp {{ number_format($anggota->total_simpanan, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <p>Adalah benar terdaftar sebagai <strong>Anggota Koperasi</strong> yang terdaftar di Dinas Perindustrian, Perdagangan dan Koperasi Kabupaten Tolikara.</p>

            <p>Surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>

            <p style="margin-top:25px;">Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
        </div>

        <div class="surat-ttd">
            <div class="surat-ttd-box">
                <p>Karubaga, {{ now()->format('d F Y') }}<br>Kepala Dinas PERINDAGKOP<br>Kabupaten Tolikara</p>
                <div class="surat-ttd-nama">_______________________</div>
                <div class="surat-ttd-nip">NIP. __________________</div>
            </div>
        </div>
    </div>
    @endif
</div>

</body>
</html>
