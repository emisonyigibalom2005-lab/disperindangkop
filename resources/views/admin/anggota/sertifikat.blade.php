<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>{{ request('type','kartu') === 'premium' ? 'Sertifikat Premium' : 'Kartu Anggota' }} - {{ $anggota->nama }}</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: Arial, sans-serif; background:#f5f5f5; }
@media print {
    body { background:white; }
    .no-print { display:none!important; }
    .page-break { page-break-before:always; }
}
.container { max-width:800px; margin:30px auto; }
.no-print { text-align:center; margin-bottom:20px; }
.no-print button { padding:10px 24px; background:#1a3a6e; color:white; border:none; border-radius:8px; cursor:pointer; font-size:14px; font-weight:700; margin:0 5px; }
.no-print button:hover { background:#2d5aa0; }

/* KARTU ANGGOTA */
.kartu { background:white; border:12px solid #1a3a6e; border-radius:16px; padding:30px; position:relative; margin-bottom:30px; }
.kartu::before { content:''; position:absolute; inset:6px; border:2px solid #f5a623; border-radius:10px; pointer-events:none; }
.kartu-header { display:flex; align-items:center; justify-content:center; gap:16px; border-bottom:2px solid #1a3a6e; padding-bottom:16px; margin-bottom:20px; }
.kartu-logo { width:55px; height:55px; background:#1a3a6e; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:22px; }
.kartu-title h3 { color:#1a3a6e; font-size:17px; font-weight:800; margin:0; }
.kartu-title p { color:#666; font-size:12px; margin:2px 0 0; }
.kartu-body { display:flex; gap:24px; }
.kartu-foto { flex-shrink:0; }
.kartu-foto img { width:100px; height:130px; object-fit:cover; border:3px solid #1a3a6e; border-radius:8px; }
.kartu-info table { width:100%; font-size:13px; }
.kartu-info tr td:first-child { color:#666; width:40%; padding:5px 0; }
.kartu-info tr td:last-child { font-weight:600; }
.no-anggota { font-size:20px; font-weight:800; color:#1a3a6e; letter-spacing:2px; margin-top:12px; }
.status-badge { display:inline-block; padding:4px 16px; border-radius:20px; font-size:11px; font-weight:700; }
.status-aktif { background:#d1fae5; color:#065f46; }
.status-pending { background:#fef3c7; color:#92400e; }
.kartu-footer { border-top:1px solid #e0e0e0; padding-top:16px; margin-top:20px; display:flex; justify-content:space-between; font-size:12px; }
.ttd { text-align:center; }
.ttd-line { border-top:1px solid #1a3a6e; padding-top:4px; margin-top:50px; font-size:11px; color:#1a3a6e; font-weight:700; }

/* SERTIFIKAT PREMIUM */
.sertifikat-premium { background:white; border:15px solid #1a3a6e; border-radius:20px; padding:40px; position:relative; margin-bottom:30px; overflow:hidden; }
.premium-bg { position:absolute; inset:0; background:linear-gradient(135deg,rgba(26,58,110,.03),rgba(245,166,35,.05)); }
.premium-border { position:absolute; inset:8px; border:3px solid #f5a623; border-radius:12px; pointer-events:none; }
.premium-content { position:relative; z-index:1; text-align:center; }
.premium-ornament { color:#f5a623; font-size:30px; margin-bottom:10px; }
.premium-title { font-size:28px; font-weight:800; color:#1a3a6e; letter-spacing:4px; margin-bottom:5px; }
.premium-subtitle { font-size:14px; color:#888; margin-bottom:24px; }
.premium-divider { width:100px; height:3px; background:linear-gradient(90deg,#f5a623,#ffb800); margin:0 auto 24px; border-radius:2px; }
.premium-body { display:flex; align-items:center; gap:30px; text-align:left; }
.premium-foto img { width:120px; height:150px; object-fit:cover; border:4px solid #f5a623; border-radius:12px; }
.premium-info { flex:1; }
.premium-info .nama { font-size:22px; font-weight:800; color:#1a3a6e; }
.premium-info .no { font-size:16px; color:#888; margin:4px 0 12px; }
.premium-footer { display:flex; justify-content:space-between; margin-top:24px; padding-top:20px; border-top:1px solid #e0e0e0; font-size:12px; }

/* KONTRAK */
.kontrak { background:white; padding:40px; border-radius:12px; margin-bottom:30px; }
.kontrak h2 { text-align:center; color:#1a3a6e; font-size:18px; margin-bottom:24px; }
.kontrak-pasal { margin-bottom:16px; }
.kontrak-pasal h6 { color:#1a3a6e; font-weight:700; }
.kontrak-pasal p { font-size:13px; line-height:1.8; color:#444; }
</style>
</head>
<body>

<div class="container">
    <div class="no-print">
        <button onclick="window.print()">🖨️ Cetak</button>
        <button onclick="window.close()">✕ Tutup</button>
    </div>

    @php $type = request('type','kartu'); @endphp

    @if(in_array($type, ['kartu','semua','halaman']))
    {{-- KARTU ANGGOTA --}}
    <div class="kartu {{ $type==='semua'?'page-break':'' }}">
        <div class="kartu-header">
            <img src="{{ asset('images/logo-tolikara.png') }}" style="width:60px;height:60px;object-fit:contain;">
            <div class="kartu-title">
                <h3>DINAS PERINDAGKOP</h3>
                <p>KABUPATEN TOLIKARA, PAPUA PEGUNUNGAN</p>
            </div>
        </div>
        <div style="text-align:center;margin-bottom:16px">
            <div style="font-size:13px;color:#888;font-weight:700;letter-spacing:2px">KARTU ANGGOTA Koperasi</div>
            <div class="no-anggota">{{ $anggota->no_anggota }}</div>
        </div>
        <div class="kartu-body">
            <div class="kartu-foto"><img src="{{ $anggota->foto_url }}"></div>
            <div class="kartu-info">
                <table>
                    <tr><td>Nama</td><td>: {{ strtoupper($anggota->nama) }}</td></tr>
                    <tr><td>NIK</td><td>: {{ $anggota->nik }}</td></tr>
                    <tr><td>Tgl Lahir</td><td>: {{ $anggota->tempat_lahir }}, {{ $anggota->tanggal_lahir->format('d M Y') }}</td></tr>
                    <tr><td>Jenis Kelamin</td><td>: {{ $anggota->jenis_kelamin==='L'?'Laki-laki':'Perempuan' }}</td></tr>
                    <tr><td>Distrik</td><td>: {{ $anggota->distrik }}, {{ $anggota->kabupaten }}</td></tr>
                    <tr><td>Nama Usaha</td><td>: {{ $anggota->nama_usaha }}</td></tr>
                    <tr><td>Status</td><td>: <span class="status-badge status-{{ strtolower($anggota->status) }}">{{ $anggota->status }}</span></td></tr>
                    <tr><td>Terdaftar</td><td>: {{ $anggota->created_at->format('d M Y') }}</td></tr>
                </table>
            </div>
        </div>
        <div class="kartu-footer">
            <div><b>DISPERINDAGKOP Kab. Tolikara</b><br>Jl. Raya Karubaga, Papua Pegunungan</div>
            <div class="ttd"><div class="ttd-line">Kepala Dinas</div></div>
        </div>
    </div>
    @endif

    @if(in_array($type, ['premium','semua']))
    {{-- SERTIFIKAT PREMIUM --}}
    <div class="sertifikat-premium {{ $type==='semua'?'page-break':'' }}">
        <div class="premium-bg"></div>
        <div class="premium-border"></div>
        <div class="premium-content">
            <div class="premium-ornament">✦ ✦ ✦</div>
            <div class="premium-title">SERTIFIKAT ANGGOTA</div>
            <div class="premium-subtitle">Koperasi DISPERINDAGKOP Kabupaten Tolikara</div>
            <div class="premium-divider"></div>
            <p style="font-size:13px;color:#666;margin-bottom:20px">Dengan ini menerangkan bahwa:</p>
            <div class="premium-body">
                <div class="premium-foto"><img src="{{ $anggota->foto_url }}"></div>
                <div class="premium-info">
                    <div class="nama">{{ strtoupper($anggota->nama) }}</div>
                    <div class="no">No. Anggota: {{ $anggota->no_anggota }}</div>
                    <table style="font-size:13px;width:100%">
                        <tr><td style="color:#888;width:35%;padding:4px 0">NIK</td><td>: {{ $anggota->nik }}</td></tr>
                        <tr><td style="color:#888">Usaha</td><td>: {{ $anggota->nama_usaha }}</td></tr>
                        <tr><td style="color:#888">Distrik</td><td>: {{ $anggota->distrik }}</td></tr>
                        <tr><td style="color:#888">Status</td><td>: <strong style="color:#1a3a6e">{{ $anggota->status }}</strong></td></tr>
                        <tr><td style="color:#888">Simpanan</td><td>: Rp {{ number_format($anggota->total_simpanan,0,',','.') }}</td></tr>
                    </table>
                </div>
            </div>
            <p style="font-size:12px;color:#888;margin-top:20px;font-style:italic">Sertifikat ini diterbitkan sebagai bukti keanggotaan yang sah</p>
            <div class="premium-footer">
                <div><b>Karubaga, {{ now()->format('d M Y') }}</b><br><span style="color:#888">Tanggal Terbit</span></div>
                <div style="text-align:center"><div style="margin-top:50px;border-top:1px solid #1a3a6e;padding-top:4px;font-weight:700;color:#1a3a6e">Kepala Dinas PERINDAGKOP</div></div>
            </div>
        </div>
    </div>
    @endif

    @if(in_array($type, ['kontrak','semua']))
    {{-- KONTRAK --}}
    <div class="kontrak {{ $type==='semua'?'page-break':'' }}">
        <h2>SURAT PERJANJIAN KEANGGOTAAN Koperasi<br><span style="font-size:14px;color:#888">DISPERINDAGKOP KABUPATEN TOLIKARA</span></h2>
        <div class="kontrak-pasal">
            <h6>PASAL 1 — IDENTITAS ANGGOTA</h6>
            <p>Nama: <strong>{{ $anggota->nama }}</strong>, NIK: {{ $anggota->nik }}, Tempat/Tgl Lahir: {{ $anggota->tempat_lahir }}, {{ $anggota->tanggal_lahir->format('d M Y') }}, Distrik: {{ $anggota->distrik }}, Kabupaten Tolikara.</p>
        </div>
        <div class="kontrak-pasal">
            <h6>PASAL 2 — HAK ANGGOTA</h6>
            <p>Anggota berhak mendapatkan layanan koperasi, mendapat keuntungan/SHU sesuai kontribusi, mendapat bantuan modal usaha sesuai program, dan hak-hak lain yang diatur dalam Anggaran Dasar Koperasi.</p>
        </div>
        <div class="kontrak-pasal">
            <h6>PASAL 3 — KEWAJIBAN ANGGOTA</h6>
            <p>Anggota wajib membayar simpanan pokok sebesar yang telah ditetapkan, membayar simpanan wajib setiap bulan, mematuhi peraturan dan ketentuan koperasi, serta berpartisipasi aktif dalam kegiatan koperasi.</p>
        </div>
        <div class="kontrak-pasal">
            <h6>PASAL 4 — DATA USAHA</h6>
            <p>Nama Usaha: <strong>{{ $anggota->nama_usaha }}</strong>, Modal Usaha: Rp {{ number_format($anggota->modal_usaha,0,',','.') }}, Omzet/Bulan: Rp {{ number_format($anggota->omzet_per_bulan,0,',','.') }}, Total Simpanan: Rp {{ number_format($anggota->total_simpanan,0,',','.') }}</p>
        </div>
        <div style="display:flex;justify-content:space-between;margin-top:40px;font-size:13px">
            <div style="text-align:center">
                <p>Anggota Koperasi,</p>
                <div style="margin-top:60px;border-top:1px solid #333;padding-top:4px;font-weight:700">{{ $anggota->nama }}</div>
            </div>
            <div style="text-align:center">
                <p>Karubaga, {{ now()->format('d M Y') }}</p>
                <div style="margin-top:60px;border-top:1px solid #333;padding-top:4px;font-weight:700">Kepala Dinas PERINDAGKOP</div>
            </div>
        </div>
    </div>
    @endif

</div>
</body>
</html>