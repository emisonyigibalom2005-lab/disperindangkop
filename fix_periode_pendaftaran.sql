-- Script untuk memperbaiki Periode Pendaftaran
-- Jalankan di database MySQL/MariaDB

-- 1. CEK STATUS PERIODE SAAT INI
SELECT 
    id,
    nama_periode,
    tahun_ajaran,
    tanggal_mulai,
    tanggal_selesai,
    status,
    kuota,
    jumlah_pendaftar,
    CASE 
        WHEN status = 'aktif' AND (kuota IS NULL OR jumlah_pendaftar < kuota) THEN 'BUKA'
        WHEN status = 'aktif' AND jumlah_pendaftar >= kuota THEN 'PENUH'
        ELSE 'TUTUP'
    END AS status_pendaftaran
FROM periode_pendaftaran
ORDER BY id DESC;

-- 2. AKTIFKAN PERIODE PENDAFTARAN (Ganti ID sesuai periode yang ingin diaktifkan)
-- Nonaktifkan semua periode dulu
UPDATE periode_pendaftaran SET status = 'nonaktif';

-- Aktifkan periode tertentu (ganti 1 dengan ID periode yang ingin diaktifkan)
UPDATE periode_pendaftaran 
SET status = 'aktif' 
WHERE id = 1;

-- 3. RESET JUMLAH PENDAFTAR (Jika ingin reset kuota)
-- UPDATE periode_pendaftaran SET jumlah_pendaftar = 0 WHERE id = 1;

-- 4. UBAH KUOTA (Jika ingin menambah kuota)
-- UPDATE periode_pendaftaran SET kuota = 50 WHERE id = 1;

-- 5. HAPUS KUOTA (Unlimited pendaftar)
-- UPDATE periode_pendaftaran SET kuota = NULL WHERE id = 1;

-- 6. CEK HASIL PERUBAHAN
SELECT 
    id,
    nama_periode,
    tahun_ajaran,
    tanggal_mulai,
    tanggal_selesai,
    status,
    kuota,
    jumlah_pendaftar,
    CASE 
        WHEN status = 'aktif' AND (kuota IS NULL OR jumlah_pendaftar < kuota) THEN '✅ BUKA'
        WHEN status = 'aktif' AND jumlah_pendaftar >= kuota THEN '⚠️ PENUH'
        ELSE '❌ TUTUP'
    END AS status_pendaftaran,
    CASE 
        WHEN kuota IS NULL THEN 'Unlimited'
        ELSE CONCAT(kuota - jumlah_pendaftar, ' tersisa')
    END AS sisa_kuota
FROM periode_pendaftaran
WHERE status = 'aktif';
