<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $p->judul }}</title>
    <style>
        @page {
            margin: 1.5cm 2cm;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1a3a6e;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo {
            width: 70px;
            height: 70px;
        }
        .header h4 {
            margin: 3px 0;
            font-size: 10pt;
            font-weight: normal;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1a3a6e;
        }
        .header h3 {
            margin: 3px 0;
            font-size: 12pt;
            font-weight: bold;
            color: #1a3a6e;
        }
        .header p {
            margin: 2px 0;
            font-size: 9pt;
            color: #555;
        }
        .pengumuman-label {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #1a3a6e;
            margin: 15px 0 10px;
            padding: 5px 0;
        }
        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            color: #1a3a6e;
            margin: 12px 0;
            line-height: 1.4;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-left: 8px;
        }
        .badge-info { background: #3b82f6; color: white; }
        .badge-penting { background: #fbbf24; color: white; }
        .badge-urgent { background: #ef4444; color: white; }
        .date-info {
            text-align: center;
            background: #f0f4ff;
            padding: 8px 12px;
            margin: 12px 0;
            font-size: 10pt;
            color: #1a3a6e;
            font-weight: 600;
        }
        .content {
            padding: 15px 0;
            margin: 15px 0;
            text-align: justify;
            line-height: 1.6;
            font-size: 11pt;
        }
        .link-box {
            background: #f0f9ff;
            padding: 10px;
            margin: 12px 0;
            border-left: 3px solid #0284c7;
        }
        .link-box strong {
            color: #0369a1;
            font-size: 10pt;
        }
        .link-box span {
            color: #0284c7;
            word-break: break-all;
            font-size: 9pt;
        }
        .pembuat {
            text-align: right;
            margin-top: 30px;
        }
        .pembuat .label {
            font-size: 10pt;
            color: #666;
            font-style: italic;
            margin-bottom: 25px;
        }
        .pembuat .nama {
            font-size: 11pt;
            font-weight: bold;
            color: #1a3a6e;
            text-decoration: underline;
        }
        .footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 9pt;
            color: #666;
        }
    </style>
</head>
<body>
    {{-- Header Surat dengan Logo --}}
    <div class="header">
        <div class="logo-container">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo" class="logo">
        </div>
        <h4>Pemerintah Kabupaten Tolikara</h4>
        <h3>DINAS PERINDUSTRIAN, PERDAGANGAN & KOPERASI</h3>
        <p>Jl. Raya Karubaga, Kabupaten Tolikara, Papua Pegunungan</p>
        <p>Telp: (0969) 31XXX | Email: disperindagkop@tolikara.go.id</p>
    </div>

    {{-- Pengumuman Label --}}
    <div class="pengumuman-label">PENGUMUMAN</div>

    {{-- Judul --}}
    <div class="title">
        {{ $p->judul }}
        @if($p->jenis)
        <span class="badge badge-{{ $p->jenis }}">{{ strtoupper($p->jenis) }}</span>
        @endif
    </div>

    {{-- Tanggal --}}
    @if($p->tanggal && $p->hari && $p->jam && $p->tahun)
    <div class="date-info">
        {{ $p->hari }}, {{ \Carbon\Carbon::parse($p->tanggal)->isoFormat('D MMMM') }} {{ $p->tahun }} | {{ $p->jam }} WIT
    </div>
    @else
    <div class="date-info">
        {{ $p->created_at->isoFormat('dddd, D MMMM Y') }}
    </div>
    @endif

    {{-- Isi Pengumuman --}}
    <div class="content">
        {!! nl2br(e($p->isi)) !!}
    </div>

    {{-- Link --}}
    @if($p->link)
    <div class="link-box">
        <strong>Link Terkait:</strong><br>
        <span>{{ $p->link }}</span>
    </div>
    @endif

    {{-- Pembuat --}}
    @if($p->pembuat)
    <div class="pembuat">
        <div class="label">Hormat kami,</div>
        <div class="nama">{{ $p->pembuat }}</div>
    </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        <p>Dokumen resmi DISPERINDAGKOP Kabupaten Tolikara | Dicetak: {{ now()->isoFormat('D MMMM Y HH:mm') }} WIT</p>
    </div>
</body>
</html>
