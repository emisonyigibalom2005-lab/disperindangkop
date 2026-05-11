# 📢 HALAMAN PENGUMUMAN & JADWAL ANGGOTA

## 🎯 OVERVIEW

Saya telah membuat 2 halaman baru untuk dashboard anggota dengan desain yang menarik dan rapi, mirip dengan desain admin:

1. **Halaman Pengumuman** - `/anggota-portal/pengumuman`
2. **Halaman Jadwal Kegiatan** - `/anggota-portal/jadwal`

---

## ✅ FITUR YANG DIBUAT

### 1️⃣ **HALAMAN PENGUMUMAN**

**URL**: `/anggota-portal/pengumuman`

#### **Desain & Fitur**:
- ✅ **Header Card** dengan gradient biru (#1a3a6e → #2d5aa0)
- ✅ **3 Stats Cards**:
  - Total Pengumuman
  - Pengumuman Aktif
  - Pengumuman Bulan Ini
- ✅ **Card Grid Layout** (2 kolom responsive)
- ✅ **Announcement Cards** dengan:
  - Icon megaphone
  - Tanggal & status badge
  - Judul pengumuman
  - Excerpt (150 karakter)
  - Download lampiran (jika ada)
  - Tombol "Lihat Detail"
- ✅ **Modal Detail** untuk melihat pengumuman lengkap
- ✅ **Pagination** untuk navigasi halaman
- ✅ **Empty State** jika belum ada pengumuman
- ✅ **Hover Effects** & smooth transitions

#### **Color Scheme**:
- Primary: `#3b82f6` → `#2563eb` (Blue gradient)
- Success: `#10b981` → `#059669` (Green gradient)
- Warning: `#f59e0b` → `#d97706` (Orange gradient)

---

### 2️⃣ **HALAMAN JADWAL KEGIATAN**

**URL**: `/anggota-portal/jadwal`

#### **Desain & Fitur**:
- ✅ **Header Card** dengan gradient purple (#8b5cf6 → #7c3aed)
- ✅ **4 Stats Cards**:
  - Total Jadwal
  - Jadwal Aktif
  - Akan Datang
  - Bulan Ini
- ✅ **Card Grid Layout** (2 kolom responsive)
- ✅ **Schedule Cards** dengan:
  - Date box (tanggal, bulan, tahun)
  - Status badge (Selesai/Hari Ini/Akan Datang)
  - Judul kegiatan
  - Detail (waktu, tempat, penyelenggara)
  - Deskripsi singkat
  - Tombol "Detail Lengkap"
- ✅ **Border Left Color** untuk visual indicator
- ✅ **Past Events** dengan opacity 0.7
- ✅ **Modal Detail** untuk melihat jadwal lengkap
- ✅ **Pagination** untuk navigasi halaman
- ✅ **Empty State** jika belum ada jadwal
- ✅ **Hover Effects** & smooth transitions

#### **Color Scheme**:
- Primary: `#8b5cf6` → `#7c3aed` (Purple gradient)
- Success: `#10b981` → `#059669` (Green gradient)
- Info: `#3b82f6` → `#2563eb` (Blue gradient)
- Warning: `#f59e0b` → `#d97706` (Orange gradient)

---

## 📁 FILES CREATED/MODIFIED

### **1. Controller**
**File**: `app/Http/Controllers/Anggota/PortalAnggotaController.php`

**Methods Added**:
```php
public function pengumuman() {
    // Fetch pengumuman with pagination
    $pengumuman = Pengumuman::where('status', 'aktif')
        ->latest()
        ->paginate(10);
    
    return view('anggota.pengumuman', compact('anggota', 'pengumuman'));
}

public function jadwal() {
    // Fetch jadwal with pagination
    $jadwal = Jadwal::where('is_publik', true)
        ->where('status', 'aktif')
        ->orderBy('tanggal', 'desc')
        ->paginate(10);
    
    return view('anggota.jadwal', compact('anggota', 'jadwal'));
}
```

---

### **2. Routes**
**File**: `routes/web.php`

**Routes Added**:
```php
Route::middleware(['auth','role:anggota'])->prefix('anggota-portal')->name('anggota.')->group(function () {
    Route::get('/dashboard', [PortalAnggotaController::class, 'dashboard'])->name('dashboard');
    Route::get('/kartu', [PortalAnggotaController::class, 'kartu'])->name('kartu');
    Route::get('/profil', [PortalAnggotaController::class, 'profil'])->name('profil');
    Route::get('/pengumuman', [PortalAnggotaController::class, 'pengumuman'])->name('pengumuman'); // NEW
    Route::get('/jadwal', [PortalAnggotaController::class, 'jadwal'])->name('jadwal'); // NEW
});
```

---

### **3. Views**

#### **A. Pengumuman Page**
**File**: `resources/views/anggota/pengumuman.blade.php`

**Components**:
- Header card dengan gradient
- 3 stats cards (Total, Aktif, Bulan Ini)
- Announcement cards grid
- Modal detail pengumuman
- Pagination
- Empty state

**Key Features**:
```html
<!-- Stats Card -->
<div class="stats-card" style="background:linear-gradient(135deg,#3b82f6,#2563eb)">
    <div class="stats-icon"><i class="fas fa-bullhorn"></i></div>
    <div class="stats-content">
        <h3>{{ $pengumuman->total() }}</h3>
        <p>Total Pengumuman</p>
    </div>
</div>

<!-- Announcement Card -->
<div class="announcement-card">
    <div class="announcement-header">
        <div class="announcement-icon"><i class="fas fa-megaphone"></i></div>
        <div class="announcement-meta">
            <span class="badge badge-primary">{{ $item->created_at->format('d M Y') }}</span>
        </div>
    </div>
    <div class="announcement-body">
        <h5 class="announcement-title">{{ $item->judul }}</h5>
        <p class="announcement-excerpt">{{ Str::limit($item->isi, 150) }}</p>
    </div>
    <div class="announcement-footer">
        <button class="btn-detail" onclick="showDetail({{ $item->id }})">
            Lihat Detail
        </button>
    </div>
</div>
```

---

#### **B. Jadwal Page**
**File**: `resources/views/anggota/jadwal.blade.php`

**Components**:
- Header card dengan gradient purple
- 4 stats cards (Total, Aktif, Akan Datang, Bulan Ini)
- Schedule cards grid
- Modal detail jadwal
- Pagination
- Empty state

**Key Features**:
```html
<!-- Schedule Card -->
<div class="schedule-card">
    <div class="schedule-date">
        <div class="date-box">
            <span class="day">{{ $item->tanggal->format('d') }}</span>
            <span class="month">{{ $item->tanggal->format('M') }}</span>
            <span class="year">{{ $item->tanggal->format('Y') }}</span>
        </div>
        <div class="schedule-status">
            @if($item->tanggal->isToday())
            <span class="badge badge-danger">Hari Ini</span>
            @else
            <span class="badge badge-success">Akan Datang</span>
            @endif
        </div>
    </div>
    <div class="schedule-body">
        <h5 class="schedule-title">{{ $item->judul }}</h5>
        <div class="schedule-details">
            <div class="detail-item">
                <i class="fas fa-clock"></i>
                <span>{{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}</span>
            </div>
            <div class="detail-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>{{ $item->tempat }}</span>
            </div>
        </div>
    </div>
</div>
```

---

### **4. Sidebar Menu**
**File**: `resources/views/layouts/app.blade.php`

**Menu Updated**:
```html
<li class="nav-header">INFORMASI</li>
<li class="nav-item">
    <a href="{{ route('anggota.pengumuman') }}" class="nav-link">
        <i class="nav-icon fas fa-bullhorn"></i>
        <p>Pengumuman</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('anggota.jadwal') }}" class="nav-link">
        <i class="nav-icon fas fa-calendar-alt"></i>
        <p>Jadwal Kegiatan</p>
    </a>
</li>
```

---

## 🎨 DESIGN HIGHLIGHTS

### **Pengumuman Page**
1. **Header**: Gradient biru dengan icon bullhorn
2. **Stats**: 3 cards dengan gradient berbeda
3. **Cards**: White background dengan shadow & hover effect
4. **Icons**: Megaphone icon untuk setiap pengumuman
5. **Badges**: Primary (tanggal) & Success (status)
6. **Button**: Gradient biru dengan hover effect

### **Jadwal Page**
1. **Header**: Gradient purple dengan icon calendar
2. **Stats**: 4 cards dengan gradient berbeda
3. **Cards**: White background dengan left border color
4. **Date Box**: Gradient purple dengan tanggal besar
5. **Status**: Badge berbeda untuk Selesai/Hari Ini/Akan Datang
6. **Button**: Gradient purple dengan hover effect

---

## 📊 STATS CARDS BREAKDOWN

### **Pengumuman Stats**:
| Card | Color | Icon | Data |
|------|-------|------|------|
| Total Pengumuman | Blue | `fa-bullhorn` | `$pengumuman->total()` |
| Pengumuman Aktif | Green | `fa-check-circle` | `where('status', 'aktif')` |
| Bulan Ini | Orange | `fa-calendar-alt` | `where('created_at', '>=', now()->startOfMonth())` |

### **Jadwal Stats**:
| Card | Color | Icon | Data |
|------|-------|------|------|
| Total Jadwal | Purple | `fa-calendar-check` | `$jadwal->total()` |
| Jadwal Aktif | Green | `fa-check-circle` | `where('status', 'aktif')` |
| Akan Datang | Blue | `fa-clock` | `where('tanggal', '>=', now())` |
| Bulan Ini | Orange | `fa-calendar-day` | `where('tanggal', 'between', [start, end])` |

---

## 🔧 JAVASCRIPT FUNCTIONS

### **Pengumuman**:
```javascript
function showDetail(id) {
    $('#modalDetail').modal('show');
    // Fetch detail via AJAX
    $.get(`/admin/pengumuman/${id}`, function(response) {
        // Display detail in modal
    });
}
```

### **Jadwal**:
```javascript
function showScheduleDetail(id) {
    $('#modalScheduleDetail').modal('show');
    // Fetch detail via AJAX
    $.get(`/admin/jadwal/${id}`, function(response) {
        // Display detail in modal
    });
}
```

---

## 📱 RESPONSIVE DESIGN

### **Mobile Optimization**:
- Stats cards stack vertically
- Card grid becomes 1 column
- Date box & status stack vertically
- Buttons full width
- Reduced padding & font sizes

**Breakpoint**: `@media (max-width: 768px)`

---

## ✨ HOVER EFFECTS

### **Cards**:
```css
.announcement-card:hover,
.schedule-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}
```

### **Buttons**:
```css
.btn-detail:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59,130,246,0.3);
}
```

### **Stats Cards**:
```css
.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
```

---

## 🚀 CARA TESTING

### **1. Test Halaman Pengumuman**:
```bash
1. Login sebagai anggota
2. Klik menu "Pengumuman" di sidebar
3. URL: http://localhost:8000/anggota-portal/pengumuman
4. Cek: Stats cards muncul dengan data yang benar
5. Cek: Pengumuman cards tampil dalam grid 2 kolom
6. Klik "Lihat Detail" → Modal muncul
7. Cek pagination jika ada banyak data
```

### **2. Test Halaman Jadwal**:
```bash
1. Login sebagai anggota
2. Klik menu "Jadwal Kegiatan" di sidebar
3. URL: http://localhost:8000/anggota-portal/jadwal
4. Cek: Stats cards muncul dengan data yang benar
5. Cek: Jadwal cards tampil dengan date box
6. Cek: Status badge berbeda untuk past/today/future
7. Klik "Detail Lengkap" → Modal muncul
8. Cek pagination jika ada banyak data
```

### **3. Test Responsive**:
```bash
1. Buka halaman di mobile (atau resize browser)
2. Cek: Stats cards stack vertically
3. Cek: Card grid menjadi 1 kolom
4. Cek: Buttons full width
5. Cek: Semua elemen masih readable
```

---

## 🎯 BENEFITS

### **Untuk Anggota**:
✅ Mudah melihat pengumuman terbaru  
✅ Mudah cek jadwal kegiatan  
✅ Desain menarik & user-friendly  
✅ Informasi lengkap & terstruktur  
✅ Responsive untuk mobile  

### **Untuk Admin**:
✅ Data pengumuman & jadwal otomatis tampil  
✅ Tidak perlu maintenance khusus  
✅ Consistent design dengan admin panel  

---

## 📝 NOTES

1. **Modal Detail**: Menggunakan AJAX untuk fetch data detail
2. **Pagination**: Laravel pagination dengan custom styling
3. **Empty State**: Tampil jika belum ada data
4. **Status Badge**: Dynamic berdasarkan kondisi
5. **Hover Effects**: Smooth transitions untuk UX yang baik

---

## 🔗 NAVIGATION FLOW

```
Dashboard Anggota
    ├── Data Profil
    ├── Kartu Anggota
    ├── Pengumuman ← NEW
    └── Jadwal Kegiatan ← NEW
```

---

**Dibuat oleh**: Kiro AI Assistant  
**Tanggal**: 10 April 2026  
**Versi**: 1.0.0
