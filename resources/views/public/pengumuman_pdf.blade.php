<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1a1a1a; }
.kop { border-bottom: 3px solid #0d2240; padding-bottom: 12px; margin-bottom: 20px; display: table; width: 100%; }
.kop-logo { display: table-cell; width: 80px; vertical-align: middle; }
.kop-logo img { width: 70px; height: 70px; object-fit: contain; }
.kop-teks { display: table-cell; vertical-align: middle; padding-left: 14px; }
.kop-teks .instansi { font-size: 17px; font-weight: 700; color: #0d2240; }
.kop-teks .sub { font-size: 11px; color: #444; margin-top: 2px; }
.kop-teks .alamat { font-size: 9.5px; color: #666; margin-top: 3px; }
.label-pengumuman { text-align: center; font-size: 13px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #0d2240; margin-bottom: 6px; }
.garis { border: none; border-top: 1.5px solid #0d2240; margin: 0 auto 18px; width: 60px; }
.badge { display: inline-block; padding: 3px 12px; border-radius: 20px; font-size: 10px; font-weight: 700; text-transform: uppercase; margin-bottom: 10px; }
.badge-info { background: #dbeafe; color: #1d4ed8; }
.badge-warning { background: #fef9c3; color: #a16207; }
.badge-success { background: #dcfce7; color: #15803d; }
.badge-danger { background: #ffe4e6; color: #be123c; }
.judul { font-size: 15px; font-weight: 700; color: #0d2240; margin-bottom: 6px; line-height: 1.4; }
.meta { font-size: 10px; color: #888; margin-bottom: 16px; }
.isi { font-size: 12px; line-height: 1.9; color: #333; text-align: justify; }
.link-box { margin-top: 16px; padding: 8px 12px; background: #f0f4ff; border-left: 3px solid #1d4ed8; font-size: 11px; color: #1d4ed8; word-break: break-all; }
.footer { position: fixed; bottom: 0; left: 0; right: 0; border-top: 1px solid #ddd; padding: 6px 20px; font-size: 9px; color: #aaa; text-align: center; }
</style>
</head>
<body>
<div class="kop">
    <div class="kop-logo">
        <img src="{{ public_path('images/logo-dinas.png') }}">
    </div>
    <div class="kop-teks">
        <div class="instansi">DINAS PERINDUSTRIAN, PERDAGANGAN DAN Koperasi</div>
        <div class="sub">KABUPATEN TOLIKARA</div>
        <div class="alamat">Karubaga, Tolikara, Papua Pegunungan &nbsp;|&nbsp; disperindagkop@tolikarakab.go.id</div>
    </div>
</div>

<div class="label-pengumuman">Pengumuman</div>
<hr class="garis">

@php
    $badgeClass = ['info'=>'badge-info','warning'=>'badge-warning','success'=>'badge-success','danger'=>'badge-danger'][$p->jenis] ?? 'badge-info';
@endphp
<span class="badge {{ $badgeClass }}">{{ ucfirst($p->jenis) }}</span>

<div class="judul">{{ $p->judul }}</div>
<div class="meta">
    Tanggal: {{ $p->created_at->format('d F Y') }}
    @if($p->mulai_tampil && $p->selesai_tampil)
        &nbsp;|&nbsp; Berlaku: {{ $p->mulai_tampil->format('d/m/Y') }} s/d {{ $p->selesai_tampil->format('d/m/Y') }}
    @endif
</div>

<div class="isi">{{ $p->isi }}</div>

@if($p->link)
<div class="link-box">Info lebih lanjut: {{ $p->link }}</div>
@endif

<div class="footer">
    Dokumen dicetak dari Sistem Informasi DISPERINDAGKOP Tolikara &nbsp;|&nbsp; {{ now()->format('d/m/Y H:i') }} WIT
</div>
</body>
</html>
