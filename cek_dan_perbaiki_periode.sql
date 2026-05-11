-- ========================================
-- SCRIPT CEK DAN PERBAIKI PERIODE PENDAFTARAN
-- ========================================

-- 1. CEK STATUS PERIODE SAAT INI
SELECT 
    id,
    nama_periode,
    tahun_ajaran,
    DATE_FORMAT(tanggal_mulai, '%d %b %Y') as mulai,
    DATE_FORMAT(tanggal_selesai, '%d %b %Y') as selesai,
    status,
    kuota,
    jumlah_pendaftar,
    CASE 
        WHEN status = 'aktif' AND (kuota IS NULL OR jumlah_pendaftar < kuota) THEN '✅ BUKA - BISA DAFTAR'
        WHEN status = 'aktif' AND jumlah_pendaftar >= kuota THEN '⚠️ PENUH - TUNGGU GELOMBANG 2'
        WHEN status = 'nonaktif' THEN '❌ TUTUP'
        ELSE '❓ UNKNOWN'
    END as status_pendaftaran,
    CASE 
        WHEN kuota IS NULL THEN '∞ Unlimited'
        WHEN jumlah_pendaftar >= kuota THEN '0 (PENUH)'
        ELSE CONCAT(kuota - jumlah_pendaftar, ' tersisa')
    END as sisa_kuota
FROM periode_pendaftaran
ORDER BY id DESC;

-- ========================================
-- 2. PERBAIKAN: AKTIFKAN PERIODE
-- ========================================

-- Nonaktifkan semua periode dulu
UPDATE periode_pendaftaran SET status = 'nonaktif';

-- Aktifkan periode tertentu (GANTI 1 dengan ID periode yang ingin diaktifkan)
UPDATE periode_pendaftaran SET status = 'aktif' WHERE id = 1;

-- ========================================
-- 3. PERBAIKAN: TAMBAH KUOTA
-- ========================================

-- Tambah kuota menjadi 50 orang (GANTI 1 dengan ID periode)
UPDATE periode_pendaftaran SET kuota = 50 WHERE id = 1;

-- ========================================
-- 4. PERBAIKAN: HAPUS BATAS KUOTA (UNLIMITED)
-- ========================================

-- Set kuota menjadi NULL = unlimited (GANTI 1 dengan ID periode)
UPDATE periode_pendaftaran SET kuota = NULL WHERE id = 1;

-- ========================================
-- 5. PERBAIKAN: RESET JUMLAH PENDAFTAR
-- ========================================

-- HATI-HATI: Ini akan reset counter pendaftar ke 0
-- UPDATE periode_pendaftaran SET jumlah_pendaftar = 0 WHERE id = 1;

-- ========================================
-- 6. PERBAIKAN: SINKRONISASI JUMLAH PENDAFTAR
-- ========================================

-- Update jumlah pendaftar berdasarkan data real di tabel anggotas
UPDATE periode_pendaftaran pp
SET jumlah_pendaftar = (
    SELECT COUNT(*) 
    FROM anggotas a 
    WHERE a.periode_pendaftaran_id = pp.id
)
WHERE pp.id = 1; -- GANTI 1 dengan ID periode

-- ========================================
-- 7. CEK HASIL PERBAIKAN
-- ========================================

SELECT 
    id,
    nama_periode,
    status,
    kuota,
    jumlah_pendaftar,
    CASE 
        WHEN status = 'aktif' AND (kuota IS NULL OR jumlah_pendaftar < kuota) THEN '✅ BUKA - FORM PENDAFTARAN MUNCUL'
        WHEN status = 'aktif' AND jumlah_pendaftar >= kuota THEN '⚠️ PENUH - TUNGGU GELOMBANG BERIKUTNYA'
        WHEN status = 'nonaktif' THEN '❌ TUTUP - TIDAK ADA PERIODE AKTIF'
        ELSE '❓ UNKNOWN'
    END as hasil_perbaikan
FROM periode_pendaftaran
WHERE id = 1; -- GANTI 1 dengan ID periode

-- ========================================
-- 8. CONTOH KASUS LENGKAP
-- ========================================

-- KASUS 1: Buka pendaftaran dengan kuota 30 orang
UPDATE periode_pendaftaran 
SET status = 'aktif', kuota = 30, jumlah_pendaftar = 0 
WHERE id = 1;

-- KASUS 2: Buka pendaftaran unlimited (tanpa batas)
UPDATE periode_pendaftaran 
SET status = 'aktif', kuota = NULL, jumlah_pendaftar = 0 
WHERE id = 1;

-- KASUS 3: Tutup pendaftaran
UPDATE periode_pendaftaran 
SET status = 'nonaktif' 
WHERE id = 1;

-- ========================================
-- 9. MONITORING REAL-TIME
-- ========================================

-- Query untuk monitoring status pendaftaran
SELECT 
    pp.id,
    pp.nama_periode,
    pp.status,
    pp.kuota,
    pp.jumlah_pendaftar,
    COUNT(a.id) as real_pendaftar,
    CASE 
        WHEN pp.jumlah_pendaftar != COUNT(a.id) THEN '⚠️ TIDAK SINKRON'
        ELSE '✅ SINKRON'
    END as status_sinkron,
    CASE 
        WHEN pp.status = 'aktif' AND (pp.kuota IS NULL OR pp.jumlah_pendaftar < pp.kuota) THEN '✅ BUKA'
        WHEN pp.status = 'aktif' AND pp.jumlah_pendaftar >= pp.kuota THEN '⚠️ PENUH'
        ELSE '❌ TUTUP'
    END as status_pendaftaran
FROM periode_pendaftaran pp
LEFT JOIN anggotas a ON a.periode_pendaftaran_id = pp.id
GROUP BY pp.id
ORDER BY pp.id DESC;
