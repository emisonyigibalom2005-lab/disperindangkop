<?php
// Script untuk update print view dengan 17 kolom saja

$file = 'resources/views/admin/laporan/koperasi_anggota.blade.php';
$content = file_get_contents($file);

// Cari dan replace bagian thead
$oldThead = '<thead style="background:linear-gradient(135deg,#fbbf24,#f59e0b);position:sticky;top:0;z-index:10;box-shadow:0 4px 12px rgba(251,191,36,0.4)">
                                <tr>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:center;width:50px;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">#</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">No. Anggota</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">NIK</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Nama Lengkap</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Email</th>';

$newThead = '<thead style="background:linear-gradient(135deg,#fbbf24,#f59e0b);position:sticky;top:0;z-index:10;box-shadow:0 4px 12px rgba(251,191,36,0.4)">
                                <tr>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:center;width:50px;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">#</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">No. Anggota</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">NIK</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Nama Lengkap</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Tempat, Tgl Lahir</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:center;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">JK</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">No. HP</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Alamat</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Distrik</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Nama Usaha</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Bidang Usaha</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:right;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Modal Usaha</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Bank</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">No. Rekening</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:right;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Total Simpanan</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:center;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Status</th>
                                    <th style="padding:12px 10px;color:#1a1a1a;border:none;text-align:center;font-weight:700;text-shadow:0 1px 2px rgba(255,255,255,0.3)">Tgl Daftar</th>';

echo "Script siap dijalankan\n";
echo "Tapi karena file terlalu besar, lebih baik edit manual atau buat file baru\n";
