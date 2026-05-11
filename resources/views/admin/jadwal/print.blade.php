<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Jadwal Kegiatan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            font-size: 12px;
            line-height: 1.6;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
        }

        .kop-surat table {
            width: 100%;
            border: none;
        }

        .kop-surat table td {
            border: none;
            padding: 0;
        }

        .kop-surat h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }

        .kop-surat p {
            font-size: 11px;
            margin: 3px 0;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 25px 0;
            text-transform: uppercase;
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th {
            background: #22c55e;
            color: white;
            padding: 10px 8px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #000;
            font-size: 11px;
        }

        table td {
            padding: 8px;
            border: 1px solid #000;
            vertical-align: top;
            font-size: 11px;
        }

        table tbody tr:nth-child(even) {
            background: #f0fdf4;
        }

        table tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        .text-center {
            text-align: center;
        }

        .summary-box {
            margin: 20px 0;
            padding: 12px;
            background: #dcfce7;
            border: 2px solid #22c55e;
            border-radius: 8px;
            display: inline-block;
        }

        .summary-box strong {
            font-size: 13px;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
            padding-right: 50px;
        }

        .signature p {
            margin: 5px 0;
            line-height: 1.8;
        }

        .signature .name {
            margin-top: 60px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }

            @page {
                margin: 1.5cm;
            }
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #22c55e;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
            z-index: 1000;
        }

        .print-button:hover {
            background: #16a34a;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button no-print">
        <i class="fas fa-print"></i> Cetak Dokumen
    </button>

    <!-- Kop Surat -->
    <div class="kop-surat">
        <table style="width:100%;border:none">
            <tr>
                <td class="logo-cell">
                    <img src="{{ asset('logo.png') }}" alt="Logo Tolikara" style="width:80px;height:80px">
                </td>
                <td style="text-align:center;vertical-align:middle;border:none">
                    <h2>DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI</h2>
                    <h2>KABUPATEN TOLIKARA</h2>
                    <p>Jl. Pemuda No. 123, Karubaga, Tolikara, Papua Pegunungan</p>
                    <p>Telp: (0969) 12345 | Email: disperindagkop@tolikara.go.id</p>
                </td>
                <td style="width:100px;border:none"></td>
            </tr>
        </table>
    </div>

    <!-- Title -->
    <div class="title">LAPORAN JADWAL KEGIATAN</div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="10%">Hari</th>
                <th width="10%">Tanggal</th>
                <th width="10%">Waktu</th>
                <th width="22%">Judul & Deskripsi</th>
                <th width="12%">Jenis</th>
                <th width="15%">Lokasi</th>
                <th width="11%">Petugas</th>
                <th width="9%">Status</th>
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
                    <br><small style="color:#666">{{ Str::limit($j->deskripsi, 80) }}</small>
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
        <p><strong>Kepala Dinas Perindustrian, Perdagangan dan Koperasi</strong></p>
        <p><strong>Kabupaten Tolikara</strong></p>
        <p class="name">( Wugi Kogoya, S.P )</p>
        <p><strong>NIP. 19850215 200604 1 008</strong></p>
    </div>

    <script>
        // Auto print on load (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
