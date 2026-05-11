# 🔄 FLOWCHART SISTEM VERIFIKASI ANGGOTA

## 📊 DIAGRAM ALUR LENGKAP

```
┌─────────────────────────────────────────────────────────────────────┐
│                    SISTEM VERIFIKASI ANGGOTA KOPERASI                │
└─────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────┐
│                         1. PENDAFTARAN ANGGOTA                       │
└─────────────────────────────────────────────────────────────────────┘

    [User Buka Website]
            │
            ▼
    [/pendaftaran-anggota]
            │
            ▼
    ┌───────────────────┐
    │ Landing Page      │
    │ - Login Form      │
    │ - Register Button │
    └───────────────────┘
            │
            ├─────────────┐
            │             │
    [Sudah Punya]   [Belum Punya]
    [Akun: Login]   [Akun: Daftar]
            │             │
            │             ▼
            │     [Form 5 Step]
            │             │
            │     ┌───────┴───────┐
            │     │ Step 1: Data  │
            │     │ Pribadi       │
            │     └───────┬───────┘
            │             │
            │     ┌───────┴───────┐
            │     │ Step 2: Alamat│
            │     └───────┬───────┘
            │             │
            │     ┌───────┴───────┐
            │     │ Step 3: Usaha │
            │     └───────┬───────┘
            │             │
            │     ┌───────┴───────┐
            │     │ Step 4: Bank  │
            │     │ & Ahli Waris  │
            │     └───────┬───────┘
            │             │
            │     ┌───────┴───────┐
            │     │ Step 5: Upload│
            │     │ Foto          │
            │     └───────┬───────┘
            │             │
            │     [Validasi Real-time]
            │             │
            │     ┌───────┴───────┐
            │     │ Submit Form   │
            │     └───────┬───────┘
            │             │
            │     ┌───────┴───────────────────────┐
            │     │ PROSES BACKEND:               │
            │     │ 1. Generate No. Anggota       │
            │     │ 2. Upload Foto → Storage      │
            │     │ 3. Create User Account:       │
            │     │    - Username: NIK            │
            │     │    - Password: NIK            │
            │     │    - Role: anggota            │
            │     │ 4. Create Anggota Record:     │
            │     │    - Status: Pending          │
            │     │    - Link to User             │
            │     │ 5. Auto Login User            │
            │     └───────┬───────────────────────┘
            │             │
            └─────────────┤
                          ▼
            [Redirect: /anggota-portal/dashboard]


┌─────────────────────────────────────────────────────────────────────┐
│                      2. DASHBOARD ANGGOTA (PENDING)                  │
└─────────────────────────────────────────────────────────────────────┘

    [Anggota Login]
            │
            ▼
    [Check Status Anggota]
            │
            ├──────────────┬──────────────┐
            │              │              │
    [Status: Pending] [Status: Aktif] [Status: Ditolak]
            │              │              │
            ▼              ▼              ▼
    ┌───────────────┐ ┌──────────────┐ ┌─────────────┐
    │ Halaman       │ │ Dashboard    │ │ Data Sudah  │
    │ "Menunggu     │ │ Lengkap:     │ │ Dihapus     │
    │ Verifikasi"   │ │ - Welcome    │ │ (Redirect   │
    │               │ │ - No. Anggota│ │ ke Login)   │
    │ Konten:       │ │ - Kartu      │ └─────────────┘
    │ - Timeline    │ │ - Pengumuman │
    │ - Info Admin  │ │ - Jadwal     │
    │ - Tips        │ │ - Menu Full  │
    └───────────────┘ └──────────────┘


┌─────────────────────────────────────────────────────────────────────┐
│                      3. VERIFIKASI ADMIN                             │
└─────────────────────────────────────────────────────────────────────┘

    [Admin Login]
            │
            ▼
    [/admin/anggota-verifikasi]
            │
            ▼
    ┌─────────────────────────────┐
    │ Dashboard Verifikasi        │
    │                             │
    │ Stats:                      │
    │ - Menunggu: 5               │
    │ - Disetujui: 120            │
    │ - Total: 125                │
    │                             │
    │ Filter & Search             │
    └─────────────────────────────┘
            │
            ▼
    ┌─────────────────────────────┐
    │ Card Grid Pendaftar         │
    │                             │
    │ [Card 1] [Card 2] [Card 3]  │
    │ [Card 4] [Card 5] [Card 6]  │
    └─────────────────────────────┘
            │
            ▼
    [Admin Pilih Aksi]
            │
            ├──────────────┬──────────────┐
            │              │              │
    [Lihat Detail]  [Terima]      [Tolak]
            │              │              │
            ▼              ▼              ▼
    ┌───────────┐  ┌──────────┐  ┌──────────┐
    │ Modal     │  │ Modal    │  │ Modal    │
    │ Detail    │  │ Konfirm  │  │ Konfirm  │
    │ Lengkap   │  │ Terima   │  │ Tolak    │
    └───────────┘  └──────────┘  └──────────┘
                          │              │
                          ▼              ▼
                   [Admin Submit] [Admin Submit]
                          │              │
                          ▼              ▼
                   ┌──────────┐  ┌──────────┐
                   │ TERIMA   │  │ TOLAK    │
                   └──────────┘  └──────────┘


┌─────────────────────────────────────────────────────────────────────┐
│                      4A. PROSES TERIMA (APPROVE)                     │
└─────────────────────────────────────────────────────────────────────┘

    [Admin Klik "Terima"]
            │
            ▼
    [Modal Konfirmasi]
            │
            ▼
    [Admin Isi Catatan (Opsional)]
            │
            ▼
    [Submit Form]
            │
            ▼
    ┌─────────────────────────────────┐
    │ BACKEND PROCESS:                │
    │                                 │
    │ 1. Update Anggota:              │
    │    - status: "Aktif"            │
    │    - catatan_admin: [text]      │
    │    - tanggal_verifikasi: now()  │
    │                                 │
    │ 2. Create Notifikasi:           │
    │    - user_id: [anggota]         │
    │    - judul: "Disetujui ✅"      │
    │    - pesan: "Selamat! ..."      │
    │    - tipe: "success"            │
    │                                 │
    │ 3. DATA TERSIMPAN ✅            │
    └─────────────────────────────────┘
            │
            ▼
    [Redirect dengan Pesan Sukses]
            │
            ▼
    ┌─────────────────────────────────┐
    │ "Pendaftaran disetujui!         │
    │  No. Anggota: AGT2026XXXX"      │
    └─────────────────────────────────┘
            │
            ▼
    [Anggota Terima Notifikasi]
            │
            ▼
    [Anggota Login → Dashboard Lengkap]


┌─────────────────────────────────────────────────────────────────────┐
│                      4B. PROSES TOLAK (REJECT)                       │
└─────────────────────────────────────────────────────────────────────┘

    [Admin Klik "Tolak"]
            │
            ▼
    [Modal Konfirmasi]
            │
            ▼
    [Admin Isi Alasan (WAJIB)]
            │
            ▼
    [Submit Form]
            │
            ▼
    ┌─────────────────────────────────┐
    │ BACKEND PROCESS:                │
    │                                 │
    │ 1. Create Notifikasi:           │
    │    - user_id: [anggota]         │
    │    - judul: "Ditolak ❌"        │
    │    - pesan: "Alasan: ..."       │
    │    - tipe: "danger"             │
    │                                 │
    │ 2. Delete Files:                │
    │    - foto                       │
    │    - foto_kk                    │
    │    - foto_tanda_tangan          │
    │    - foto_lokasi_usaha          │
    │    - foto_selfie_ktp            │
    │                                 │
    │ 3. Delete Anggota Record ❌     │
    │                                 │
    │ 4. Delete User Account ❌       │
    │                                 │
    │ 5. DATA DIHAPUS SEMUA ❌        │
    └─────────────────────────────────┘
            │
            ▼
    [Redirect dengan Pesan Sukses]
            │
            ▼
    ┌─────────────────────────────────┐
    │ "Pendaftaran ditolak.           │
    │  Data dan akun telah dihapus.   │
    │  Anggota dapat daftar ulang."   │
    └─────────────────────────────────┘
            │
            ▼
    [Anggota Terima Notifikasi]
            │
            ▼
    [Anggota Tidak Bisa Login]
            │
            ▼
    [Anggota Bisa Daftar Ulang]


┌─────────────────────────────────────────────────────────────────────┐
│                      5. NOTIFIKASI SYSTEM                            │
└─────────────────────────────────────────────────────────────────────┘

    ┌─────────────────────────────────┐
    │ NOTIFIKASI DISETUJUI ✅         │
    ├─────────────────────────────────┤
    │ Judul:                          │
    │ "Pendaftaran Anggota Disetujui" │
    │                                 │
    │ Pesan:                          │
    │ "Selamat! Pendaftaran Anda      │
    │  disetujui. No. Anggota:        │
    │  AGT2026XXXX. Silakan akses     │
    │  menu untuk melihat kartu."     │
    │                                 │
    │ Tipe: success (hijau)           │
    │ Icon: ✅                        │
    └─────────────────────────────────┘

    ┌─────────────────────────────────┐
    │ NOTIFIKASI DITOLAK ❌           │
    ├─────────────────────────────────┤
    │ Judul:                          │
    │ "Pendaftaran Anggota Ditolak"   │
    │                                 │
    │ Pesan:                          │
    │ "Mohon maaf, pendaftaran        │
    │  ditolak. Alasan: [catatan      │
    │  admin]. Silakan perbaiki dan   │
    │  daftar ulang."                 │
    │                                 │
    │ Tipe: danger (merah)            │
    │ Icon: ❌                        │
    └─────────────────────────────────┘


┌─────────────────────────────────────────────────────────────────────┐
│                      6. DATABASE FLOW                                │
└─────────────────────────────────────────────────────────────────────┘

    PENDAFTARAN:
    ┌──────────┐     ┌──────────┐     ┌──────────┐
    │  users   │────▶│ anggotas │────▶│ periode_ │
    │          │     │          │     │ pendaft. │
    │ id       │     │ user_id  │     │          │
    │ email=NIK│     │ status=  │     │ id       │
    │ pass=NIK │     │ Pending  │     │ is_buka  │
    │ role=    │     │ no_angg. │     └──────────┘
    │ anggota  │     │ ...data  │
    └──────────┘     └──────────┘

    TERIMA (APPROVE):
    ┌──────────┐     ┌──────────┐     ┌──────────┐
    │  users   │────▶│ anggotas │────▶│notifikasi│
    │          │     │          │     │          │
    │ TETAP    │     │ status=  │     │ judul    │
    │ ADA ✅   │     │ Aktif ✅ │     │ pesan    │
    │          │     │ tgl_veri │     │ tipe=    │
    │          │     │ catatan  │     │ success  │
    └──────────┘     └──────────┘     └──────────┘

    TOLAK (REJECT):
    ┌──────────┐     ┌──────────┐     ┌──────────┐
    │  users   │  X  │ anggotas │────▶│notifikasi│
    │          │     │          │     │          │
    │ DIHAPUS  │     │ DIHAPUS  │     │ judul    │
    │ ❌       │     │ ❌       │     │ pesan    │
    │          │     │          │     │ tipe=    │
    │          │     │          │     │ danger   │
    └──────────┘     └──────────┘     └──────────┘
                                              │
                                              ▼
                                      [Notif Terkirim]
                                              │
                                              ▼
                                      [Data Dihapus]


┌─────────────────────────────────────────────────────────────────────┐
│                      7. DECISION TREE                                │
└─────────────────────────────────────────────────────────────────────┘

                    [Pendaftaran Masuk]
                            │
                            ▼
                    [Admin Review Data]
                            │
                ┌───────────┴───────────┐
                │                       │
        [Data Lengkap &           [Data Tidak
         Sesuai?]                  Sesuai?]
                │                       │
                ▼                       ▼
        ┌───────────────┐       ┌───────────────┐
        │ TERIMA ✅     │       │ TOLAK ❌      │
        ├───────────────┤       ├───────────────┤
        │ • Status Aktif│       │ • Kirim Notif │
        │ • Data Simpan │       │ • Hapus Foto  │
        │ • Kirim Notif │       │ • Hapus Data  │
        │ • Akses Full  │       │ • Hapus User  │
        └───────────────┘       └───────────────┘
                │                       │
                ▼                       ▼
        [Anggota Aktif]         [Bisa Daftar Ulang]


┌─────────────────────────────────────────────────────────────────────┐
│                      8. STATUS LIFECYCLE                             │
└─────────────────────────────────────────────────────────────────────┘

    [Daftar] ──────▶ [Pending] ──────┬──────▶ [Aktif]
                         │            │          │
                         │            │          ▼
                         │            │    [Anggota Resmi]
                         │            │          │
                         │            │          ▼
                         │            │    [Akses Penuh]
                         │            │
                         │            │
                         ▼            │
                    [Ditolak]         │
                         │            │
                         ▼            │
                  [Data Dihapus]      │
                         │            │
                         ▼            │
                  [Bisa Daftar ◀──────┘
                   Ulang]


┌─────────────────────────────────────────────────────────────────────┐
│                      9. FILE UPLOAD FLOW                             │
└─────────────────────────────────────────────────────────────────────┘

    [User Upload Foto]
            │
            ▼
    [Validasi: max 2MB, image]
            │
            ▼
    [Store ke: storage/app/public/anggota/]
            │
            ▼
    [Simpan Path di Database]
            │
            ├──────────────┬──────────────┐
            │              │              │
    [Status: Pending] [Terima]      [Tolak]
            │              │              │
            ▼              ▼              ▼
    [Foto Tetap]   [Foto Tetap]   [Foto Dihapus]
                                          │
                                          ▼
                                   [Storage::delete()]


┌─────────────────────────────────────────────────────────────────────┐
│                      10. SECURITY FLOW                               │
└─────────────────────────────────────────────────────────────────────┘

    [User Register]
            │
            ▼
    ┌─────────────────────────────┐
    │ Auto-Generated Credentials: │
    │                             │
    │ Username: NIK (16 digit)    │
    │ Password: NIK (16 digit)    │
    │ Role: anggota               │
    └─────────────────────────────┘
            │
            ▼
    [Password Hash: bcrypt]
            │
            ▼
    [Store di Table: users]
            │
            ▼
    [Auto Login]
            │
            ▼
    [Session Created]
            │
            ▼
    [Middleware: auth, role:anggota]
            │
            ▼
    [Access Dashboard]


┌─────────────────────────────────────────────────────────────────────┐
│                      LEGEND                                          │
└─────────────────────────────────────────────────────────────────────┘

    [Box]       = Process / Action
    ┌─────┐     = Decision Point
    │     │     = Container / Group
    └─────┘
    ──────▶     = Flow Direction
    ├─────       = Branch / Split
    ✅          = Success / Saved
    ❌          = Failed / Deleted
    ⏳          = Pending / Waiting
    👁️          = View / Read
    📊          = Stats / Dashboard
    🔍          = Search / Filter
```

---

**Dibuat oleh**: Kiro AI Assistant  
**Tanggal**: 10 April 2026  
**Versi**: 1.0.0
