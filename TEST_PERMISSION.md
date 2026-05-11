# 🧪 Test Permission System

## ✅ Permission Sudah Dibuat!

Seeder berhasil dijalankan dan permission default sudah tersimpan di database.

---

## 📊 Permission yang Sudah Dibuat

### **PETUGAS - Pengumuman:**
```
✅ View: ON (Bisa lihat daftar)
✅ Create: ON (Bisa buat baru)
✅ Edit: ON (Bisa edit)
✅ Delete: ON (Bisa hapus)
❌ Export: OFF
❌ Approve: OFF
```

**Artinya:**
- ✅ Menu "Pengumuman" tampil di sidebar
- ✅ Tombol "Buat Pengumuman" tampil
- ✅ Tombol "Detail" tampil
- ✅ Tombol "Edit" tampil
- ✅ Tombol "Hapus" tampil

---

## 🧪 Cara Test

### **1. Test dengan Login Petugas**

#### **Langkah:**
1. Buka browser
2. Logout jika sedang login
3. Login dengan akun **Petugas**
4. Buka menu **Pengumuman**

#### **Yang Harus Terlihat:**
```
✅ Menu "Pengumuman" tampil di sidebar
✅ Bisa buka halaman daftar pengumuman
✅ Tombol "Buat Pengumuman" tampil di header (warna putih)
✅ Tombol "Detail" (biru) tampil di setiap row
✅ Tombol "Edit" (kuning) tampil di setiap row (hanya untuk pengumuman dari Petugas)
✅ Tombol "Hapus" (merah) tampil di setiap row (hanya untuk pengumuman dari Petugas)
```

#### **Yang TIDAK Boleh Terlihat:**
```
❌ Tidak ada icon lock (🔒)
❌ Tidak ada tombol disabled
❌ Tidak ada pesan "Tidak ada izin"
```

---

### **2. Test Fungsi Create**

#### **Langkah:**
1. Login sebagai Petugas
2. Buka menu Pengumuman
3. Klik tombol "Buat Pengumuman"
4. Isi form pengumuman
5. Klik "Simpan"

#### **Expected Result:**
```
✅ Form create terbuka
✅ Bisa isi semua field
✅ Bisa simpan data
✅ Redirect ke halaman index
✅ Muncul notifikasi sukses
✅ Data baru muncul di tabel
```

---

### **3. Test Fungsi Edit**

#### **Langkah:**
1. Login sebagai Petugas
2. Buka menu Pengumuman
3. Cari pengumuman yang dibuat oleh Petugas
4. Klik tombol "Edit" (icon pensil kuning)
5. Ubah data
6. Klik "Simpan"

#### **Expected Result:**
```
✅ Form edit terbuka
✅ Data lama sudah terisi
✅ Bisa ubah data
✅ Bisa simpan perubahan
✅ Redirect ke halaman index
✅ Muncul notifikasi sukses
✅ Data terupdate di tabel
```

---

### **4. Test Fungsi Delete**

#### **Langkah:**
1. Login sebagai Petugas
2. Buka menu Pengumuman
3. Cari pengumuman yang dibuat oleh Petugas
4. Klik tombol "Hapus" (icon trash merah)
5. Konfirmasi di popup SweetAlert
6. Klik "Ya, Hapus!"

#### **Expected Result:**
```
✅ Popup konfirmasi muncul
✅ Popup modern dengan SweetAlert2
✅ Ada tombol "Ya, Hapus!" dan "Batal"
✅ Setelah klik "Ya, Hapus!" → Loading muncul
✅ Data terhapus dari database
✅ Redirect ke halaman index
✅ Muncul notifikasi sukses
✅ Data hilang dari tabel
```

---

### **5. Test dengan Login Pimpinan (View Only)**

#### **Langkah:**
1. Logout dari Petugas
2. Login dengan akun **Pimpinan**
3. Buka menu Pengumuman

#### **Expected Result:**
```
✅ Menu "Pengumuman" tampil di sidebar
✅ Bisa buka halaman daftar pengumuman
✅ Tombol "Detail" tampil
❌ Tombol "Buat Pengumuman" TIDAK TAMPIL
❌ Tombol "Edit" TIDAK TAMPIL
❌ Tombol "Hapus" TIDAK TAMPIL
```

---

### **6. Test Akses Langsung via URL**

#### **Test A: Petugas Akses Create**
```
URL: http://127.0.0.1:8000/petugas/pengumuman/create

Expected:
✅ Halaman form create terbuka
✅ Bisa isi form
✅ Bisa simpan
```

#### **Test B: Pimpinan Akses Create**
```
URL: http://127.0.0.1:8000/pimpinan/pengumuman/create
(Jika ada route untuk pimpinan)

Expected:
❌ Redirect ke dashboard
❌ Muncul pesan error:
   "Anda tidak memiliki izin untuk membuat pengumuman. 
    Hubungi Administrator untuk mendapatkan akses."
```

---

## 🔍 Troubleshooting

### **Problem 1: Tombol Edit/Hapus Tidak Muncul**

#### **Kemungkinan Penyebab:**
1. Permission belum ada di database
2. Cache browser
3. Session lama

#### **Solusi:**
```bash
# 1. Cek permission di database
php artisan tinker
>>> App\Models\RolePermission::where('role', 'petugas')->where('module', 'pengumuman')->first()

# 2. Jika tidak ada, jalankan seeder lagi
php artisan db:seed --class=RolePermissionSeeder

# 3. Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 4. Logout dan login ulang
```

---

### **Problem 2: Muncul Pesan "Tidak Ada Izin"**

#### **Kemungkinan Penyebab:**
1. Permission di database salah
2. Module name tidak match
3. Helper function tidak load

#### **Solusi:**
```bash
# 1. Cek permission
php artisan tinker
>>> can_view('pengumuman')  # Harus return true untuk petugas

# 2. Regenerate autoload
composer dump-autoload

# 3. Restart server
php artisan serve
```

---

### **Problem 3: Tombol Tampil Tapi Tidak Bisa Diklik**

#### **Kemungkinan Penyebab:**
1. JavaScript error
2. CSS conflict
3. Form action salah

#### **Solusi:**
```
1. Buka Developer Tools (F12)
2. Cek Console untuk error
3. Cek Network tab saat klik tombol
4. Pastikan route sudah benar
```

---

## 📝 Checklist Test

Centang jika sudah test dan berhasil:

### **Login Petugas:**
- [ ] Menu Pengumuman tampil di sidebar
- [ ] Bisa buka halaman daftar
- [ ] Tombol "Buat Pengumuman" tampil
- [ ] Bisa klik tombol "Buat"
- [ ] Form create terbuka
- [ ] Bisa simpan data baru
- [ ] Tombol "Detail" tampil di tabel
- [ ] Tombol "Edit" tampil di tabel
- [ ] Tombol "Hapus" tampil di tabel
- [ ] Bisa edit pengumuman
- [ ] Bisa hapus pengumuman
- [ ] Popup delete muncul dengan SweetAlert
- [ ] Notifikasi sukses muncul

### **Login Pimpinan:**
- [ ] Menu Pengumuman tampil di sidebar
- [ ] Bisa buka halaman daftar
- [ ] Tombol "Buat" TIDAK tampil
- [ ] Tombol "Edit" TIDAK tampil
- [ ] Tombol "Hapus" TIDAK tampil
- [ ] Hanya tombol "Detail" yang tampil

### **Akses Langsung:**
- [ ] Petugas bisa akses /petugas/pengumuman/create
- [ ] Pimpinan tidak bisa akses create (redirect)

---

## 🎯 Expected Behavior Summary

| Role | View | Create | Edit | Delete | UI Behavior |
|------|------|--------|------|--------|-------------|
| **Admin** | ✅ | ✅ | ✅ | ✅ | Semua tombol tampil |
| **Petugas** | ✅ | ✅ | ✅ | ✅ | Semua tombol tampil |
| **Pimpinan** | ✅ | ❌ | ❌ | ❌ | Hanya tombol Detail |
| **Koperasi** | ❌ | ❌ | ❌ | ❌ | Menu tidak tampil |
| **Anggota** | ❌ | ❌ | ❌ | ❌ | Menu tidak tampil |

---

## 📞 Jika Masih Bermasalah

### **Langkah Debug:**

1. **Cek Permission di Database**
```sql
SELECT * FROM role_permissions 
WHERE role = 'petugas' 
AND module = 'pengumuman';
```

Expected Result:
```
role: petugas
module: pengumuman
can_view: 1
can_create: 1
can_edit: 1
can_delete: 1
can_export: 0
can_approve: 0
```

2. **Test Helper Function**
```bash
php artisan tinker
>>> auth()->user()->role
>>> can_view('pengumuman')
>>> can_create('pengumuman')
>>> can_edit('pengumuman')
>>> can_delete('pengumuman')
```

Semua harus return `true` untuk petugas.

3. **Cek View**
- Buka file: `resources/views/petugas/pengumuman/index-table.blade.php`
- Pastikan ada `@canCreate`, `@canEdit`, `@canDelete`
- Pastikan tidak ada `@else` dengan disabled button

4. **Cek Controller**
- Buka file: `app/Http/Controllers/Petugas/PengumumanController.php`
- Pastikan ada `can_view()`, `can_create()`, dll di setiap method

---

**Status:** ✅ Permission Sudah Dibuat dan Siap Ditest  
**Next:** Test dengan login sebagai Petugas dan Pimpinan
