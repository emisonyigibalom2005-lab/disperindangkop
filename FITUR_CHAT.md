# Fitur Chat & Pesan

## Deskripsi
Fitur chat memungkinkan komunikasi real-time antara Admin dan Anggota koperasi. Admin dapat membalas pertanyaan, memberikan bantuan, dan berkomunikasi langsung dengan anggota.

## Fitur Utama

### Untuk Admin:
1. **Daftar Percakapan** - Melihat semua anggota yang pernah chat
2. **Chat Baru** - Mencari dan memulai chat dengan anggota tertentu
3. **Notifikasi** - Badge notifikasi untuk pesan belum dibaca
4. **Kirim Pesan** - Mengirim teks dan file (gambar, PDF, dokumen)
5. **Status Baca** - Melihat apakah pesan sudah dibaca anggota
6. **Riwayat Chat** - Semua percakapan tersimpan dengan timestamp

### Untuk Anggota:
1. **Chat dengan Admin** - Berkomunikasi langsung dengan administrator
2. **Kirim Pesan** - Mengirim teks dan file lampiran
3. **Notifikasi** - Badge untuk pesan baru dari admin
4. **Riwayat Percakapan** - Melihat semua pesan sebelumnya

## Teknologi
- **Backend**: Laravel (PHP)
- **Frontend**: Blade Templates, jQuery, AJAX
- **Database**: MySQL (tabel `chats`)
- **Storage**: File upload ke `storage/app/public/chat-files`

## Struktur Database

### Tabel: `chats`
| Kolom | Tipe | Deskripsi |
|-------|------|-----------|
| id | bigint | Primary key |
| pengirim_id | bigint | Foreign key ke users |
| penerima_id | bigint | Foreign key ke users |
| pesan | text | Isi pesan |
| file | string | Path file lampiran (optional) |
| is_read | boolean | Status sudah dibaca |
| read_at | timestamp | Waktu dibaca |
| created_at | timestamp | Waktu kirim |
| updated_at | timestamp | Waktu update |

## Routes

### Admin Routes:
- `GET /admin/chat` - Daftar percakapan
- `GET /admin/chat/{userId}` - Chat dengan user tertentu
- `POST /admin/chat` - Kirim pesan
- `GET /admin/chat-search` - Cari anggota

### Anggota Routes:
- `GET /anggota-portal/chat` - Daftar admin
- `GET /anggota-portal/chat/{adminId}` - Chat dengan admin
- `POST /anggota-portal/chat` - Kirim pesan

## File yang Dibuat/Dimodifikasi

### Baru:
1. `database/migrations/2026_04_11_000000_create_chats_table.php`
2. `app/Models/Chat.php`
3. `app/Http/Controllers/Admin/ChatController.php`
4. `app/Http/Controllers/Anggota/ChatController.php`
5. `resources/views/admin/chat/index.blade.php`
6. `resources/views/admin/chat/show.blade.php`
7. `resources/views/anggota/chat/index.blade.php`
8. `resources/views/anggota/chat/show.blade.php`

### Dimodifikasi:
1. `routes/web.php` - Menambahkan routes chat
2. `resources/views/layouts/app.blade.php` - Menambahkan menu chat di sidebar

## Cara Penggunaan

### Admin:
1. Login sebagai admin
2. Klik menu "Chat & Pesan" di sidebar
3. Klik "Chat Baru" untuk mencari anggota
4. Atau klik percakapan yang sudah ada
5. Ketik pesan dan klik tombol kirim
6. Lampirkan file jika diperlukan

### Anggota:
1. Login sebagai anggota
2. Klik menu "Chat dengan Admin" di sidebar
3. Pilih admin yang ingin dihubungi
4. Ketik pesan dan kirim
5. Tunggu balasan dari admin

## Fitur Tambahan
- ✅ Real-time message display
- ✅ File attachment support (max 5MB)
- ✅ Read receipts (double check mark)
- ✅ Unread message counter
- ✅ Search users functionality
- ✅ Responsive design
- ✅ Smooth animations
- ✅ Auto-scroll to latest message
- ✅ Enter to send (Shift+Enter for new line)
- ✅ **Edit message** - Edit pesan yang sudah dikirim
- ✅ **Delete message** - Hapus pesan dengan konfirmasi
- ✅ **Edited badge** - Indikator pesan yang sudah diedit
- ✅ **Hover actions** - Tombol edit/hapus muncul saat hover
- ✅ **Toast notifications** - Notifikasi sukses/error yang menarik

## Keamanan
- CSRF protection pada semua form
- File validation (type & size)
- Authentication required
- Role-based access control
- SQL injection prevention (Eloquent ORM)

## Desain
- Modern gradient colors
- Glassmorphism effects
- Smooth transitions
- Mobile responsive
- Intuitive UI/UX
- Badge notifications
- Avatar placeholders

## Pengembangan Selanjutnya (Opsional)
- [ ] Real-time dengan WebSocket/Pusher
- [ ] Typing indicator
- [ ] Online/offline status
- [ ] Message reactions (emoji)
- [ ] Voice messages
- [ ] Image preview
- [ ] Delete/edit messages
- [ ] Group chat
- [ ] Chat export (PDF)
- [ ] Push notifications
