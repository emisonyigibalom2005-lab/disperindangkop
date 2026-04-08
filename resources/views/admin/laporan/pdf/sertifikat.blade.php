<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
@page { margin: 0; size: A4 landscape; }
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Times New Roman', serif; background: #fff; width:297mm; height:210mm; position:relative; overflow:hidden; }

/* BORDER ORNAMENT */
.outer-border { position:absolute; top:8mm; left:8mm; right:8mm; bottom:8mm; border:4px solid #1a3a6e; }
.inner-border { position:absolute; top:11mm; left:11mm; right:11mm; bottom:11mm; border:1.5px solid #f5a623; }

/* CORNER ORNAMENTS */
.corner { position:absolute; width:20mm; height:20mm; }
.corner svg { width:100%; height:100%; }
.tl { top:6mm; left:6mm; }
.tr { top:6mm; right:6mm; transform:scaleX(-1); }
.bl { bottom:6mm; left:6mm; transform:scaleY(-1); }
.br { bottom:6mm; right:6mm; transform:scale(-1); }

/* WATERMARK */
.watermark { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%) rotate(-30deg); font-size:80px; color:rgba(26,58,110,.05); font-weight:900; white-space:nowrap; letter-spacing:10px; z-index:0; }

/* CONTENT */
.content { position:absolute; top:0; left:0; right:0; bottom:0; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:20mm 25mm; z-index:1; text-align:center; }

.header-logos { display:flex; align-items:center; justify-content:center; gap:20px; margin-bottom:6mm; }
.logo-circle { width:18mm; height:18mm; background:linear-gradient(135deg,#1a3a6e,#2451a3); border-radius:50%; display:flex; align-items:center; justify-content:center; border:2px solid #f5a623; }
.logo-circle span { font-size:22px; color:#f5a623; font-weight:900; }

.instansi { text-align:center; }
.instansi .dinas { font-size:11pt; font-weight:700; color:#1a3a6e; letter-spacing:1px; text-transform:uppercase; }
.instansi .kabupaten { font-size:9pt; color:#555; }

.divider-gold { width:120mm; height:3px; background:linear-gradient(90deg,transparent,#f5a623,#1a3a6e,#f5a623,transparent); margin:4mm auto; }

.judul-sertifikat { font-size:28pt; font-weight:900; color:#1a3a6e; letter-spacing:4px; text-transform:uppercase; margin-bottom:2mm; }
.sub-judul { font-size:10pt; color:#888; letter-spacing:3px; text-transform:uppercase; margin-bottom:6mm; }

.nomor { font-size:9pt; color:#555; margin-bottom:6mm; }
.nomor span { color:#1a3a6e; font-weight:700; }

.diberikan-kepada { font-size:10pt; color:#555; margin-bottom:2mm; }
.nama-usaha { font-size:22pt; font-weight:900; color:#1a3a6e; margin-bottom:1mm; font-style:italic; }
.nama-pemilik { font-size:11pt; color:#444; margin-bottom:1mm; }
.alamat-usaha { font-size:9pt; color:#777; margin-bottom:5mm; }

.divider-thin { width:80mm; height:1px; background:linear-gradient(90deg,transparent,#ccc,transparent); margin:3mm auto; }

.info-row { display:flex; justify-content:center; gap:30mm; margin-bottom:6mm; }
.info-item { text-align:center; }
.info-item .label { font-size:7.5pt; color:#999; text-transform:uppercase; letter-spacing:1px; }
.info-item .value { font-size:9.5pt; font-weight:700; color:#1a3a6e; }
.badge-kategori { display:inline-block; background:#1a3a6e; color:#fff; padding:2px 12px; border-radius:20px; font-size:8pt; font-weight:700; letter-spacing:1px; }

.footer-sertifikat { display:flex; justify-content:space-between; align-items:flex-end; width:100%; margin-top:4mm; }
.ttd-box { text-align:center; width:60mm; }
.ttd-box .ttd-title { font-size:8.5pt; color:#555; margin-bottom:18mm; }
.ttd-box .ttd-name { font-weight:700; color:#1a3a6e; font-size:9pt; border-top:1.5px solid #333; padding-top:4px; }
.ttd-box .ttd-nip { font-size:7.5pt; color:#777; }

.qr-box { text-align:center; width:30mm; }
.qr-placeholder { width:22mm; height:22mm; border:1.5px solid #ccc; margin:0 auto 3px; display:flex; align-items:center; justify-content:center; }
.qr-placeholder span { font-size:7pt; color:#ccc; }
.qr-label { font-size:6.5pt; color:#999; }

.stamp-area { width:60mm; text-align:center; }
.stamp-circle { width:35mm; height:35mm; border:2px dashed #1a3a6e; border-radius:50%; margin:0 auto; display:flex; align-items:center; justify-content:center; }
.stamp-circle span { font-size:7pt; color:#1a3a6e; }

.valid-date { font-size:8pt; color:#888; }
.valid-date strong { color:#1a3a6e; }
</style>
</head>
<body>

<div class="watermark">DISPERINDAGKOP</div>
<div class="outer-border"></div>
<div class="inner-border"></div>

<div class="content">
    <!-- HEADER -->
    <div class="header-logos">
        <div class="logo-circle" style="background:white;padding:2px;"><img src="http://127.0.0.1:8000/images/logo-tolikara.png" style="width:14mm;height:14mm;object-fit:contain;"></div>
        <div class="instansi">
            <div class="dinas">Dinas Perindustrian, Perdagangan, Koperasi </div>
            <div class="kabupaten">Kabupaten Tolikara — Papua Pegunungan</div>
        </div>
        <div class="logo-circle" style="background:white;padding:2px;"><img src="http://127.0.0.1:8000/images/logo-dinas.png" style="width:14mm;height:14mm;object-fit:contain;"></div>
    </div>

    <div class="divider-gold"></div>

    <div class="judul-sertifikat">Sertifikat</div>
    <div class="sub-judul">Nomor Induk Berusaha Koperasi</div>
    <div class="nomor">Nomor: <span>{{ $koperasi->no_registrasi }}</span></div>

    <div class="diberikan-kepada">Diberikan kepada:</div>
    <div class="nama-usaha">{{ $koperasi->nama_usaha }}</div>
    <div class="nama-pemilik">Pemilik: <strong>{{ $koperasi->nama_pemilik }}</strong></div>
    <div class="alamat-usaha">{{ $koperasi->alamat }}, {{ $koperasi->kelurahan }}, Distrik {{ $koperasi->distrik }}</div>

    <div class="divider-thin"></div>

    <div class="info-row">
        <div class="info-item">
            <div class="label">Jenis Usaha</div>
            <div class="value">{{ $koperasi->jenis_usaha }}</div>
        </div>
        <div class="info-item">
            <div class="label">Kategori</div>
            <div class="value"><span class="badge-kategori">{{ strtoupper($koperasi->kategori) }}</span></div>
        </div>
        <div class="info-item">
            <div class="label">Tgl. Verifikasi</div>
            <div class="value">{{ $koperasi->verified_at ? \Carbon\Carbon::parse($koperasi->verified_at)->format('d F Y') : \Carbon\Carbon::parse($koperasi->created_at)->format('d F Y') }}</div>
        </div>
        <div class="info-item">
            <div class="label">Berlaku Hingga</div>
            <div class="value">{{ \Carbon\Carbon::now()->addYears(3)->format('d F Y') }}</div>
        </div>
    </div>

    <!-- FOOTER TTD -->
    <div class="footer-sertifikat">
        <div class="ttd-box">
            <div class="ttd-title">Kepala Dinas,</div>
            <div class="ttd-name">.............................</div>
            <div class="ttd-nip">NIP. .........................</div>
        </div>
        <div class="qr-box">
            <div class="qr-placeholder"><span>QR</span></div>
            <div class="qr-label">Scan untuk verifikasi</div>
        </div>
        <div class="stamp-area">
            <div class="stamp-circle"><span>CAP DINAS</span></div>
        </div>
    </div>
</div>

</body>
</html>
