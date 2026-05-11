<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Jadwal Kegiatan - PDF</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            font-size: 10px;
            line-height: 1.4;
        }

        .kop-surat {
            margin-bottom: 15px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }

        .kop-table {
            width: 100%;
            border: none;
        }

        .kop-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .logo-cell {
            width: 80px;
            text-align: center;
        }

        .logo-cell img {
            width: 65px;
            height: 65px;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h2 {
            font-size: 14px;
            font-weight: bold;
            margin: 3px 0;
            text-transform: uppercase;
            color: #1a3a6e;
        }

        .kop-text p {
            font-size: 9px;
            margin: 2px 0;
            color: #333;
        }

        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 15px 0;
            text-transform: uppercase;
            text-decoration: underline;
            color: #1a3a6e;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        table.data-table th {
            background: #22c55e;
            color: white;
            padding: 8px 5px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #000;
            font-size: 9px;
        }

        table.data-table td {
            padding: 6px 5px;
            border: 1px solid #000;
            vertical-align: top;
            font-size: 9px;
        }

        table.data-table tbody tr:nth-child(even) {
            background: #f0fdf4;
        }

        table.data-table tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        .text-center {
            text-align: center;
        }

        .summary-box {
            margin: 15px 0;
            padding: 10px;
            background: #dcfce7;
            border: 2px solid #22c55e;
            border-radius: 6px;
            display: inline-block;
        }

        .summary-box strong {
            font-size: 11px;
            color: #166534;
        }

        .signature {
            margin-top: 30px;
            text-align: right;
            padding-right: 30px;
        }

        .signature p {
            margin: 3px 0;
            font-size: 10px;
            line-height: 1.6;
        }

        .signature .jabatan {
            font-weight: bold;
            color: #1a3a6e;
        }

        .signature .name {
            margin-top: 50px;
            margin-bottom: 3px;
            font-weight: bold;
        }

        .signature .nip {
            font-weight: bold;
            color: #1a3a6e;
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <table class="kop-table">
            <tr>
                <td class="logo-cell">
                    @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="Logo Koperasi">
                    @endif
                </td>
                <td class="kop-text">
                    <h2>DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI</h2>
                    <h2>KABUPATEN TOLIKARA</h2>
                    <p>Jl. Pemuda No. 123, Karubaga, Tolikara, Papua Pegunungan</p>
                    <p>Telp: (0969) 12345 | Email: disperindagkop@tolikara.go.id</p>
                </td>
                <td style="width:80px"></td>
            </tr>
        </table>
    </div>

    <!-- Title -->
    <div class="title">LAPORAN JADWAL KEGIATAN</div>

    <!-- Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="8%">Hari</th>
                <th width="9%">Tanggal</th>
                <th width="9%">Waktu</th>
                <th width="25%">Judul & Deskripsi</th>
                <th width="12%">Jenis</th>
                <th width="15%">Lokasi</th>
                <th width="11%">Petugas</th>
                <th width="8%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jadwal as $index => $j)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center"><strong>{{ $j->hari }}</strong></td>
                <td class="text-center">{{ $j->tanggal->format('d/m/Y') }}</td>
                <td class="text-center">
                    {{ substr($j->jam_mulai, 0, 5) }}{{ $j->jam_selesai ? ' - ' . substr($j->jam_selesai, 0, 5) : '' }}
                </td>
                <td>
                    <strong>{{ $j->judul }}</strong>
                    @if($j->deskripsi)
                    <br><span style="font-size:8px;color:#666">{{ Str::limit($j->deskripsi, 70) }}</span>
                    @endif
                </td>
                <td>{{ $j->jenis_label }}</td>
                <td>{{ $j->lokasi ?? '-' }}</td>
                <td>{{ $j->petugas->name ?? '-' }}</td>
                <td class="text-center">{{ $j->status_label }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data jadwal</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary-box">
        <strong>Total Jadwal: {{ $jadwal->count() }} kegiatan</strong>
    </div>

    <!-- Signature -->
    <div class="signature">
        <p>Karubaga, {{ now()->format('d F Y') }}</p>
        <p class="jabatan">Kepala Dinas Perindustrian, Perdagangan dan Koperasi</p>
        <p class="jabatan">Kabupaten Tolikara</p>
        <p class="name">( Wugi Kogoya, S.P )</p>
        <p class="nip">NIP. 19850215 200604 1 008</p>
    </div>
</body>
</html>
