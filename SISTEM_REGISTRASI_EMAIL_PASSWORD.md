# Sistem Registrasi dengan Email dan Password

## 📋 Ringkasan Perubahan

Sistem pendaftaran anggota koperasi telah diperbarui untuk menggunakan **Email dan Password** yang diinput oleh user sendiri, menggantikan sistem auto-generate dengan NIK.

## ✨ Fitur Baru

### 1. **Input Email dan Password di Form Pendaftaran**
- Email wajib diisi dan harus unique (tidak boleh duplikat)
- Password minimal 6 karakter dengan konfirmasi
- Password dapat ditampilkan/disembunyikan dengan tombol toggle (eye icon)
- Validasi real-time untuk email dan password

### 2. **Akun Login Otomatis**
- Setelah pendaftaran berhasil, akun user langsung dibuat
- User otomatis login dan diarahkan ke dashboard anggota
- Email yang diinput digunakan sebagai username login

### 3. **Validasi Lengkap**
- Email: Format valid dan unique
- Password: Minimal 6 karakter
- Password Confirmation: Harus sama dengan password
- Error message yang jelas dalam Bahasa Indonesia

## 📁 File yang Diubah

### 1. **Controller** - `app/Http/Controllers/PendaftaranAnggotaController.php`
```php
// Validasi email dan password
'email' => 'required|email|unique:users,email',
'password' => 'required|string|min:6|confirmed',

// Buat user dengan email dan password dari input
$user = User::create([
    'name' => $validated['nama'],
    'email' => $validated['email'],
    'password' => Hash::make($validated['password']),
    'role' => 'anggota',
]);

// Auto login
auth()->login($user);
```

### 2. **Form View** - `resources/views/public/pendaftaran-anggota.blade.php`

#### Tambahan di Step 1 (Data Pribadi):
```html
<!-- Section Data Akun Login -->
<h6>Data Akun Login</h6>

<!-- Email Field -->
<input type="email" name="email" required>

<!-- Password Field dengan Toggle -->
<div class="input-group">
    <input type="password" name="password" id="password" required>
    <button type="button" onclick="togglePassword('password')">
        <i class="fas fa-eye" id="password-icon"></i>
    </button>
</div>

<!-- Password Confirmation -->
<div class="input-group">
    <input type="password" name="password_confirmation" required>
    <button type="button" onclick="togglePassword('password_confirmation')">
        <i class="fas fa-eye" id="password_confirmation-icon"></i>
    </button>
</div>
```

#### JavaScript Validation:
```javascript
// Tambah email, password, password_confirmation ke validasi Step 1
const stepValidations = {
    1: ['nik', 'nama', ..., 'email', 'password', 'password_confirmation'],
    ...
};

// Validasi password
if (fieldName === 'password' && value) {
    if (value.length < 6) {
        showFieldError(field, 'Password minimal 6 karakter');
        return false;
    }
}

// Validasi konfirmasi password
if (fieldName === 'password_confirmation' && value) {
    const password = document.querySelector('[name="password"]').value;
    if (value !== password) {
        showFieldError(field, 'Konfirmasi password tidak cocok');
        return false;
    }
}

// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
```

### 3. **Dashboard View** - `resources/views/anggota/dashboard.blade.php`
```html
<!-- Welcome message setelah registrasi -->
<div class="col-md-6">
    <small>No. Anggota</small>
    <span>{{ session('no_anggota') }}</span>
</div>
<div class="col-md-6">
    <small>Email Login</small>
    <code>{{ session('email') }}</code>
</div>

<div class="alert alert-info">
    Status: Akun Anda sedang menunggu verifikasi dari admin.
</div>
```

## 🎨 Tampilan Form

### Step 1: Data Pribadi
```
┌─────────────────────────────────────────────┐
│ NIK (16 digit) *                            │
│ [________________]                          │
├─────────────────────────────────────────────┤
│ Nama Lengkap *                              │
│ [________________]                          │
├─────────────────────────────────────────────┤
│ ... (fields lainnya) ...                    │
├─────────────────────────────────────────────┤
│ 🔒 Data Akun Login                          │
│ ℹ️ Buat akun login untuk dashboard anggota  │
├─────────────────────────────────────────────┤
│ Email *                                     │
│ [________________]                          │
│ Email ini akan digunakan untuk login        │
├─────────────────────────────────────────────┤
│ Password *                    👁️            │
│ [________________] [Toggle]                 │
│ Minimal 6 karakter                          │
├─────────────────────────────────────────────┤
│ Konfirmasi Password *         👁️            │
│ [________________] [Toggle]                 │
│ Harus sama dengan password                  │
└─────────────────────────────────────────────┘
```

## 🔄 Alur Pendaftaran

```
1. User mengisi form pendaftaran (5 steps)
   ├─ Step 1: Data Pribadi + Email & Password
   ├─ Step 2: Alamat
   ├─ Step 3: Data Usaha
   ├─ Step 4: Keuangan & Ahli Waris
   └─ Step 5: Upload Foto

2. Submit Form
   ├─ Validasi semua field
   ├─ Generate No. Anggota (AGT2026XXXX)
   ├─ Upload foto ke storage
   └─ Simpan ke database

3. Buat User Account
   ├─ Email: dari input user
   ├─ Password: dari input user (di-hash)
   └─ Role: anggota

4. Buat Data Anggota
   ├─ Link ke user_id
   ├─ Status: Pending
   └─ Semua data pendaftaran

5. Auto Login
   └─ auth()->login($user)

6. Redirect ke Dashboard Anggota
   ├─ Tampilkan welcome message
   ├─ Tampilkan No. Anggota & Email
   └─ Info: Menunggu verifikasi admin
```

## 🔐 Keamanan

1. **Password Hashing**: Password di-hash menggunakan `Hash::make()` sebelum disimpan
2. **Email Unique**: Validasi unique untuk mencegah duplikasi email
3. **Password Confirmation**: User harus konfirmasi password untuk menghindari typo
4. **Validasi Server-Side**: Semua validasi dilakukan di server (controller)
5. **Validasi Client-Side**: JavaScript validation untuk UX yang lebih baik

## 📊 Validasi Error Messages

| Field | Validasi | Error Message |
|-------|----------|---------------|
| email | required | Email wajib diisi |
| email | email | Format email tidak valid |
| email | unique | Email sudah terdaftar dalam sistem |
| password | required | Password wajib diisi |
| password | min:6 | Password minimal 6 karakter |
| password | confirmed | Konfirmasi password tidak cocok |

## 🎯 Status Setelah Pendaftaran

### Status: **Pending** (Menunggu Verifikasi)
- User sudah bisa login
- Akses terbatas ke menu:
  - ✅ Dashboard (tampilan menunggu verifikasi)
  - ✅ Pengumuman
  - ✅ Jadwal
  - ❌ Menu lainnya (disabled)

### Status: **Aktif** (Setelah Disetujui Admin)
- Akses penuh ke semua menu dashboard anggota
- Dapat mengajukan bantuan
- Dapat melihat simpanan
- Dapat mengikuti pelatihan

### Status: **Ditolak** (Jika Ditolak Admin)
- Data dihapus dari database
- User tidak bisa login lagi

## 🧪 Testing

### Test Case 1: Registrasi Berhasil
```
1. Buka halaman pendaftaran
2. Isi semua field termasuk email dan password
3. Submit form
4. ✅ User otomatis login
5. ✅ Redirect ke dashboard anggota
6. ✅ Tampil welcome message dengan email
```

### Test Case 2: Email Duplikat
```
1. Registrasi dengan email yang sudah ada
2. ❌ Error: "Email sudah terdaftar dalam sistem"
3. Form tidak di-submit
```

### Test Case 3: Password Tidak Cocok
```
1. Isi password: "password123"
2. Isi konfirmasi: "password456"
3. ❌ Error: "Konfirmasi password tidak cocok"
4. Form tidak di-submit
```

### Test Case 4: Password Terlalu Pendek
```
1. Isi password: "12345" (5 karakter)
2. ❌ Error: "Password minimal 6 karakter"
3. Form tidak di-submit
```

## 📝 Catatan Penting

1. **Email sebagai Username**: Email yang diinput akan digunakan sebagai username untuk login
2. **Password User-Defined**: User membuat password sendiri, bukan auto-generate
3. **Auto-Login**: Setelah registrasi, user langsung login tanpa perlu login manual
4. **Verifikasi Admin**: Meskipun akun sudah dibuat, status masih "Pending" sampai admin approve
5. **Data Lengkap**: Semua data pendaftaran tetap tersimpan lengkap seperti sebelumnya

## 🔄 Migrasi dari Sistem Lama

Jika ada data lama dengan sistem NIK:
1. User lama tetap bisa login dengan email yang ada
2. Tidak perlu migrasi data
3. Sistem baru hanya berlaku untuk pendaftaran baru

## 📞 Support

Jika ada masalah:
1. Cek error message di form
2. Pastikan email belum terdaftar
3. Pastikan password minimal 6 karakter
4. Pastikan konfirmasi password sama
5. Hubungi admin jika masih ada masalah
