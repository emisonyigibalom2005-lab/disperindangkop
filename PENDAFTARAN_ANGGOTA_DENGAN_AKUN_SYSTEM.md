# 🎯 Sistem Pendaftaran Anggota dengan Pembuatan Akun

## 📋 Ringkasan

Sistem pendaftaran anggota koperasi oleh petugas yang **otomatis membuat akun login** untuk anggota. Saat petugas mendaftarkan anggota baru, sistem akan:
1. Menyimpan data anggota
2. Membuat akun user dengan role "anggota"
3. Anggota bisa login ke sistem dengan email & password yang didaftarkan

---

## ✨ Fitur Utama

### 1. **Multi-Step Form** (5 Langkah)
1. **Data Pribadi** - NIK, Nama, TTL, Jenis Kelamin, dll
2. **Alamat** - Alamat lengkap, Desa, Distrik, Kabupaten
3. **Data Usaha** - Koperasi, Nama Usaha, Modal, Omzet
4. **Keanggotaan** - Simpanan Pokok & Wajib
5. **Dokumen** - Upload KTP, Selfie KTP, KK

### 2. **Data Akun Login**
- Email (unique, untuk login)
- Password (min 6 karakter)
- Konfirmasi Password
- Role otomatis: "anggota"
- Status otomatis: aktif

### 3. **Validasi Periode**
- Cek periode pendaftaran aktif
- Cek kuota pendaftaran
- Redirect jika ditutup/penuh

---

## 📊 Struktur Form

### Step 1: Data Pribadi
```
┌─────────────────────────────────────────┐
│  📋 Data Pribadi                        │
├─────────────────────────────────────────┤
│  NIK (16 digit) *                       │
│  Nama Lengkap *                         │
│  Tempat Lahir *                         │
│  Tanggal Lahir *                        │
│  Jenis Kelamin * (L/P)                  │
│  Status Perkawinan                      │
│  Pendidikan Terakhir                    │
│  Agama                                  │
│  No. HP/WhatsApp *                      │
└─────────────────────────────────────────┘
```

### Step 2: Alamat
```
┌─────────────────────────────────────────┐
│  📍 Alamat                              │
├─────────────────────────────────────────┤
│  Alamat Lengkap *                       │
│  Desa/Kelurahan                         │
│  Distrik                                │
│  Kabupaten                              │
│  Kode Pos                               │
└─────────────────────────────────────────┘
```

### Step 3: Data Usaha
```
┌─────────────────────────────────────────┐
│  🏪 Data Usaha                          │
├─────────────────────────────────────────┤
│  Pilih Koperasi *                       │
│  Nama Usaha                             │
│  Bidang Usaha                           │
│  Modal Usaha (Rp)                       │
│  Omzet per Bulan (Rp)                   │
│  Alamat Tempat Usaha                    │
└─────────────────────────────────────────┘
```

### Step 4: Keanggotaan
```
┌─────────────────────────────────────────┐
│  💰 Keanggotaan                         │
├─────────────────────────────────────────┤
│  Simpanan Pokok (Rp)                    │
│  Simpanan Wajib (Rp)                    │
└─────────────────────────────────────────┘
```

### Step 5: Dokumen & Akun Login
```
┌─────────────────────────────────────────┐
│  📄 Dokumen                             │
├─────────────────────────────────────────┤
│  Upload Foto KTP                        │
│  Upload Foto Selfie + KTP               │
│  Upload Foto Kartu Keluarga             │
├─────────────────────────────────────────┤
│  🔐 Data Akun Login                     │
├─────────────────────────────────────────┤
│  ℹ️ Buat akun login Anda untuk          │
│     mengakses dashboard anggota         │
│                                         │
│  Email * (untuk login)                  │
│  Password * (min 6 karakter)            │
│  Konfirmasi Password *                  │
└─────────────────────────────────────────┘
```

---

## 🔧 Implementasi Controller

### Method Store (Update)

```php
public function store(Request $request)
{
    // 1. Cek periode pendaftaran
    $periodeAktif = PeriodePendaftaran::getPeriodeAktif();
    
    if (!$periodeAktif) {
        return back()->with('error', 'Pendaftaran ditutup')->withInput();
    }
    
    if ($periodeAktif->isKuotaPenuh()) {
        return back()->with('error', 'Kuota penuh')->withInput();
    }
    
    // 2. Validasi semua data
    $validated = $request->validate([
        // Data Pribadi
        'no_ktp' => 'required|string|size:16|unique:anggotas,no_ktp',
        'nama_lengkap' => 'required|string|max:255',
        'tempat_lahir' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:L,P',
        'status_perkawinan' => 'nullable|in:belum_kawin,kawin,cerai_hidup,cerai_mati',
        'pendidikan_terakhir' => 'nullable|string|max:255',
        'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
        'no_hp' => 'required|string|max:20',
        
        // Alamat
        'alamat' => 'required|string',
        'desa' => 'nullable|string|max:255',
        'distrik' => 'nullable|string|max:255',
        'kabupaten' => 'nullable|string|max:255',
        'kode_pos' => 'nullable|string|max:10',
        
        // Data Usaha
        'koperasi_id' => 'required|exists:koperasi,id',
        'nama_usaha' => 'nullable|string|max:255',
        'bidang_usaha' => 'nullable|string|max:255',
        'modal_usaha' => 'nullable|numeric|min:0',
        'omzet_per_bulan' => 'nullable|numeric|min:0',
        'alamat_tempat_usaha' => 'nullable|string',
        
        // Keanggotaan
        'simpanan_pokok' => 'nullable|numeric|min:0',
        'simpanan_wajib' => 'nullable|numeric|min:0',
        
        // Dokumen
        'foto_ktp' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        'foto_selfie_ktp' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        'foto_kk' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        
        // Data Akun Login
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);
    
    // 3. Upload dokumen
    if ($request->hasFile('foto_ktp')) {
        $validated['foto_ktp'] = $request->file('foto_ktp')
            ->store('anggota/ktp', 'public');
    }
    
    if ($request->hasFile('foto_selfie_ktp')) {
        $validated['foto_selfie_ktp'] = $request->file('foto_selfie_ktp')
            ->store('anggota/selfie', 'public');
    }
    
    if ($request->hasFile('foto_kk')) {
        $validated['foto_kk'] = $request->file('foto_kk')
            ->store('anggota/kk', 'public');
    }
    
    // 4. Generate nomor anggota
    $noAnggota = Anggota::generateNoAnggota();
    
    // 5. Buat akun user untuk anggota
    $user = User::create([
        'name' => $validated['nama_lengkap'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'anggota',
        'is_active' => true,
        'phone' => $validated['no_hp'],
    ]);
    
    // 6. Buat data anggota
    $anggota = Anggota::create(array_merge($validated, [
        'user_id' => $user->id,
        'no_anggota' => $noAnggota,
        'nik' => $validated['no_ktp'],
        'nama' => $validated['nama_lengkap'],
        'alamat_lengkap' => $validated['alamat'],
        'periode_pendaftaran_id' => $periodeAktif->id,
        'tanggal_bergabung' => now(),
        'status_verifikasi' => 'menunggu_verifikasi',
        'status_keanggotaan' => 'aktif',
        'status' => 'menunggu_verifikasi',
        'created_by' => auth()->id(),
    ]));
    
    // 7. Log aktivitas
    ActivityLog::create([
        'user_id' => auth()->id(),
        'action' => 'create',
        'module' => 'ANGGOTA',
        'description' => 'Mendaftarkan anggota baru: ' . $anggota->nama_lengkap . 
                        ' (' . $noAnggota . ') dengan akun login',
        'ip_address' => $request->ip(),
    ]);
    
    // 8. Redirect dengan pesan sukses
    return redirect()->route('petugas.dashboard')
        ->with('success', 'Anggota berhasil didaftarkan!<br>' .
                         'No Anggota: ' . $noAnggota . '<br>' .
                         'Email Login: ' . $validated['email']);
}
```

---

## 📝 Validasi Form

### Field Wajib (*)
- NIK (16 digit, unique)
- Nama Lengkap
- Tempat Lahir
- Tanggal Lahir
- Jenis Kelamin
- No HP
- Alamat
- Koperasi
- **Email** (unique, untuk login)
- **Password** (min 6 karakter)
- **Konfirmasi Password**

### Field Optional
- Status Perkawinan
- Pendidikan Terakhir
- Agama
- Desa, Distrik, Kabupaten, Kode Pos
- Nama Usaha, Bidang Usaha
- Modal Usaha, Omzet
- Simpanan Pokok & Wajib
- Foto KTP, Selfie KTP, KK

---

## 🗄️ Data yang Tersimpan

### Tabel: `users`
```
id: 123
name: "John Doe"
email: "john@example.com"
password: "$2y$10$..." (hashed)
role: "anggota"
is_active: true
phone: "081234567890"
created_at: "2026-04-16 14:30:00"
```

### Tabel: `anggotas`
```
id: 456
user_id: 123 (foreign key ke users)
no_anggota: "AG202604001"
nik: "9401234567890123"
nama: "John Doe"
nama_lengkap: "John Doe"
tempat_lahir: "Jayapura"
tanggal_lahir: "1990-01-15"
jenis_kelamin: "L"
no_hp: "081234567890"
alamat: "Jl. Contoh No. 123"
alamat_lengkap: "Jl. Contoh No. 123"
koperasi_id: 5
periode_pendaftaran_id: 2
status_verifikasi: "menunggu_verifikasi"
status_keanggotaan: "aktif"
created_by: 2 (ID petugas)
tanggal_bergabung: "2026-04-16"
```

---

## 🎯 Alur Lengkap

### 1. Petugas Mendaftar Anggota
```
1. Login sebagai petugas
2. Dashboard → Klik "Pendaftaran Anggota Baru"
3. Cek periode aktif (otomatis)
4. Isi form 5 langkah:
   - Step 1: Data Pribadi
   - Step 2: Alamat
   - Step 3: Data Usaha
   - Step 4: Keanggotaan
   - Step 5: Dokumen & Akun Login
5. Submit form
6. Sistem buat:
   - Akun user (tabel users)
   - Data anggota (tabel anggotas)
7. Redirect ke dashboard dengan pesan sukses
```

### 2. Anggota Login
```
1. Buka halaman login
2. Masukkan email & password yang didaftarkan
3. Login berhasil
4. Redirect ke dashboard anggota
5. Anggota bisa:
   - Lihat profil
   - Lihat simpanan
   - Ajukan bantuan
   - dll
```

### 3. Admin Verifikasi
```
1. Login sebagai admin
2. Menu "Data Anggota"
3. Filter: Status = "Menunggu Verifikasi"
4. Klik detail anggota
5. Verifikasi atau tolak
6. Status berubah menjadi "Diverifikasi" atau "Ditolak"
```

---

## 🔒 Keamanan

### Password
- ✅ Hashed menggunakan `Hash::make()`
- ✅ Minimal 6 karakter
- ✅ Harus konfirmasi password
- ✅ Tidak disimpan plain text

### Email
- ✅ Unique (tidak boleh duplikat)
- ✅ Validasi format email
- ✅ Digunakan untuk login

### Upload File
- ✅ Validasi: image only (jpeg, jpg, png)
- ✅ Max size: 2MB
- ✅ Disimpan di storage/app/public/anggota/

### Authorization
- ✅ Hanya petugas yang bisa daftar anggota
- ✅ Middleware: `auth`, `role:petugas`
- ✅ Activity log semua aksi

---

## 📱 Responsive Design

Form multi-step responsive untuk:
- ✅ Desktop (full width)
- ✅ Tablet (2 kolom)
- ✅ Mobile (1 kolom, stack vertical)

---

## 🎨 UI/UX

### Progress Indicator
```
[1] ━━━ [2] ─── [3] ─── [4] ─── [5]
Data    Alamat  Usaha   Anggota Dokumen
Pribadi
```

### Step Navigation
- **Selanjutnya** → Pindah ke step berikutnya
- **Sebelumnya** → Kembali ke step sebelumnya
- **Simpan** → Submit form (step terakhir)

### Validation Feedback
- ✅ Real-time validation
- ✅ Error message di bawah field
- ✅ Border merah untuk field error
- ✅ Icon check hijau untuk field valid

---

## 📊 Pesan Sukses

```
┌─────────────────────────────────────────┐
│  ✅ Anggota Berhasil Didaftarkan!       │
├─────────────────────────────────────────┤
│  No Anggota: AG202604001                │
│  Nama: John Doe                         │
│  Email Login: john@example.com          │
│                                         │
│  Akun login telah dibuat. Anggota bisa  │
│  login menggunakan email dan password   │
│  yang telah didaftarkan.                │
└─────────────────────────────────────────┘
```

---

## 🎉 Keuntungan Sistem

1. **Efisiensi**: 1 form untuk 2 tujuan (data anggota + akun login)
2. **User Friendly**: Anggota langsung bisa login
3. **Tracking**: Tahu siapa yang mendaftarkan (created_by)
4. **Keamanan**: Password ter-hash, email unique
5. **Validasi**: Data tervalidasi sebelum disimpan

---

**Dibuat pada**: 16 April 2026  
**Status**: ✅ Konsep Lengkap  
**Next**: Buat view form multi-step
