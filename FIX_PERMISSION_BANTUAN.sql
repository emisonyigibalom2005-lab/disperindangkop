-- ============================================
-- FIX PERMISSION REKAP BANTUAN UNTUK PIMPINAN
-- ============================================
-- File: FIX_PERMISSION_BANTUAN.sql
-- Tujuan: Mengaktifkan semua permission (View, Create, Edit, Delete) untuk modul "laporan"
-- ============================================

-- STEP 1: Cek permission yang ada saat ini
SELECT 
    'BEFORE UPDATE' as status,
    role,
    module,
    can_view,
    can_create,
    can_edit,
    can_delete,
    can_export,
    can_approve
FROM role_permissions 
WHERE role = 'pimpinan' AND module = 'laporan';

-- STEP 2: Hapus permission lama (jika ada)
DELETE FROM role_permissions 
WHERE role = 'pimpinan' AND module = 'laporan';

-- STEP 3: Insert permission baru dengan SEMUA akses
INSERT INTO role_permissions 
(role, module, can_view, can_create, can_edit, can_delete, can_export, can_approve, created_at, updated_at)
VALUES 
('pimpinan', 'laporan', 1, 1, 1, 1, 1, 0, NOW(), NOW());

-- STEP 4: Verifikasi hasil
SELECT 
    'AFTER UPDATE' as status,
    role,
    module,
    CASE WHEN can_view = 1 THEN '✓ YES' ELSE '✗ NO' END as 'Lihat Detail',
    CASE WHEN can_create = 1 THEN '✓ YES' ELSE '✗ NO' END as 'Tambah Data',
    CASE WHEN can_edit = 1 THEN '✓ YES' ELSE '✗ NO' END as 'Edit Data',
    CASE WHEN can_delete = 1 THEN '✓ YES' ELSE '✗ NO' END as 'Hapus Data',
    CASE WHEN can_export = 1 THEN '✓ YES' ELSE '✗ NO' END as 'Export Data',
    CASE WHEN can_approve = 1 THEN '✓ YES' ELSE '✗ NO' END as 'Approve Data'
FROM role_permissions 
WHERE role = 'pimpinan' AND module = 'laporan';

-- ============================================
-- HASIL YANG DIHARAPKAN:
-- ============================================
-- status       | role     | module  | Lihat Detail | Tambah Data | Edit Data | Hapus Data | Export Data | Approve Data
-- -------------|----------|---------|--------------|-------------|-----------|------------|-------------|-------------
-- AFTER UPDATE | pimpinan | laporan | ✓ YES        | ✓ YES       | ✓ YES     | ✓ YES      | ✓ YES       | ✗ NO
-- ============================================

-- STEP 5: Cek semua permission untuk role pimpinan (optional)
SELECT 
    module,
    CASE WHEN can_view = 1 THEN '✓' ELSE '✗' END as 'V',
    CASE WHEN can_create = 1 THEN '✓' ELSE '✗' END as 'C',
    CASE WHEN can_edit = 1 THEN '✓' ELSE '✗' END as 'E',
    CASE WHEN can_delete = 1 THEN '✓' ELSE '✗' END as 'D',
    CASE WHEN can_export = 1 THEN '✓' ELSE '✗' END as 'X',
    CASE WHEN can_approve = 1 THEN '✓' ELSE '✗' END as 'A'
FROM role_permissions 
WHERE role = 'pimpinan'
ORDER BY module;

-- ============================================
-- CATATAN PENTING:
-- ============================================
-- 1. Setelah menjalankan query ini, jalankan command:
--    php artisan optimize:clear
--
-- 2. Logout dan login ulang sebagai Pimpinan
--
-- 3. Refresh halaman dengan Ctrl+F5
--
-- 4. Buka halaman: /pimpinan/laporan/bantuan
--
-- 5. Cek alert status - semua harus ✓ (hijau)
--
-- 6. Cek tombol di tabel - harus ada 3 tombol:
--    [👁️ Detail] [✏️ Edit] [🗑️ Hapus]
-- ============================================

-- ============================================
-- ROLLBACK (Jika Perlu Kembalikan ke Semula)
-- ============================================
-- Uncomment query di bawah jika ingin rollback

-- DELETE FROM role_permissions 
-- WHERE role = 'pimpinan' AND module = 'laporan';

-- INSERT INTO role_permissions 
-- (role, module, can_view, can_create, can_edit, can_delete, can_export, can_approve, created_at, updated_at)
-- VALUES 
-- ('pimpinan', 'laporan', 1, 0, 0, 0, 0, 0, NOW(), NOW());
-- ============================================
