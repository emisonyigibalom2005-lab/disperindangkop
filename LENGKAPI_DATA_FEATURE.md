# Fitur Lengkapi Data untuk Anggota yang Ditolak

## Deskripsi
Fitur ini memungkinkan anggota yang pendaftarannya ditolak oleh admin untuk memperbaiki dan melengkapi data mereka, kemudian mengirimkan ulang untuk verifikasi.

## Alur Kerja

### 1. Pendaftaran Anggota Baru
- Anggota baru mendaftar melalui form pendaftaran
- Setelah submit, anggota **OTOMATIS LOGIN** ke dashboard anggota
- Status awal: **Pending** (menunggu verifikasi admin)
- Anggota dapat mengakses dashboard meskipun status masih Pending

### 2. Verifikasi oleh Admin
Admin memiliki 2 pilihan:
- **TERIMA**: Status berubah menjadi "Aktif", anggota resmi terdaftar
- **TOLAK**: Status berubah menjadi "Ditolak", admin memberikan catatan alasan penolakan

### 3. Anggota yang Ditolak
Ketika status anggota "Ditolak":
- Anggota **TETAP BISA LOGIN** (akun tidak dihapus)
- Di dashboard muncul alert merah dengan alasan penolakan
- Di sidebar muncul menu **"Lengkapi Data"** dengan badge merah (!)
- Menu ini HANYA muncul jika status = 'Ditolak'

### 4. Lengkapi Data
Anggota yang ditolak dapat:
- Klik menu "Lengkapi Data" di sidebar
- Melihat form lengkap dengan semua field yang perlu diperbaiki
- Alert di atas form menampilkan alasan penolakan dari admin
- Mengisi/memperbaiki data sesuai catatan admin
- Submit untuk verifikasi ulang

### 5. Setelah Submit Lengkapi Data
- Status berubah kembali dari "Ditolak" ke **"Pending"**
- Catatan admin dihapus (reset)
- Tanggal verifikasi direset
- Menu "Lengkapi Data" hilang dari sidebar
- Admin akan menerima data baru untuk diverifikasi ulang

### 6. Verifikasi Ulang
- Admin melihat data yang sudah diperbaiki
- Admin dapat menerima atau menolak lagi
- Jika ditolak lagi, siklus berulang (anggota bisa lengkapi data lagi)

## Status Login
| Status | Bisa Login? | Akses Dashboard? | Menu Lengkapi Data? |
|--------|-------------|------------------|---------------------|
| Pending | ✅ Ya | ✅ Ya | ❌ Tidak |
| Aktif | ✅ Ya | ✅ Ya | ❌ Tidak |
| Ditolak | ✅ Ya | ✅ Ya | ✅ Ya |
| Nonaktif | ❌ Tidak | ❌ Tidak | ❌ Tidak |

## File yang Terlibat

### Controller
- `app/Http/Controllers/Anggota/PortalAnggotaController.php`
  - Method: `lengkapiData()` - Menampilkan form
  - Method: `lengkapiDataUpdate()` - Memproses submit

### Routes
- `routes/web.php`
  - GET `/anggota/lengkapi-data` → `lengkapiData()`
  - POST `/anggota/lengkapi-data` → `lengkapiDataUpdate()`

### Views
- `resources/views/anggota/lengkapi-data.blade.php` - Form lengkapi data
- `resources/views/layouts/anggota.blade.php` - Layout dengan menu sidebar
- `resources/views/anggota/dashboard.blade.php` - Dashboard dengan alert status

### Login Controller
- `app/Http/Controllers/Auth/LoginController.php`
  - Hanya memblokir status "Nonaktif"
  - Status Pending, Aktif, dan Ditolak bisa login

## Notifikasi
Ketika admin menolak pendaftaran:
- Notifikasi otomatis dikirim ke anggota
- Judul: "Pendaftaran Belum Disetujui"
- Pesan: Berisi alasan penolakan + instruksi untuk lengkapi data
- Jenis: "warning"

## Keamanan
- Validasi lengkap pada semua field
- NIK harus unik (kecuali milik anggota sendiri)
- Email harus valid
- File foto maksimal 2MB
- Hanya anggota yang login bisa akses form
- Data hanya bisa diubah oleh pemilik akun

## Catatan Penting
1. **Akun tidak dihapus** - Anggota yang ditolak tetap punya akun aktif
2. **Auto-login setelah daftar** - Anggota baru langsung masuk dashboard
3. **Menu dinamis** - Menu "Lengkapi Data" hanya muncul saat status Ditolak
4. **Siklus berulang** - Anggota bisa submit ulang berkali-kali sampai diterima
5. **Notifikasi real-time** - Hasil verifikasi muncul di dashboard (bukan email)

## Testing Flow
1. Daftar sebagai anggota baru → Otomatis login ke dashboard
2. Login sebagai admin → Tolak pendaftaran dengan catatan
3. Login kembali sebagai anggota → Lihat alert merah + menu "Lengkapi Data"
4. Klik "Lengkapi Data" → Perbaiki data → Submit
5. Login sebagai admin → Verifikasi ulang data yang sudah diperbaiki
6. Terima atau tolak lagi sesuai kebutuhan
