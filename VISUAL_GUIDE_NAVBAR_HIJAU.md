# 🎨 VISUAL GUIDE - NAVBAR HIJAU PORTAL ANGGOTA

## 🌟 TAMPILAN BARU

### 1. NAVBAR ATAS (Header)

```
╔═══════════════════════════════════════════════════════════════════╗
║ ▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ ║ ← Shimmer Line
╠═══════════════════════════════════════════════════════════════════╣
║                                                                   ║
║  ☰ Menu    📍 Portal Anggota Koperasi         🔔 (3)   👤 User  ║
║                                                                   ║
╚═══════════════════════════════════════════════════════════════════╝
```

**Warna**: Gradient Hijau Emerald (#10b981 → #059669 → #047857)
**Efek**: Shadow hijau + Shimmer animation di atas

---

### 2. HOVER EFFECTS

#### Menu Hover:
```
Normal:     [ ☰ Menu ]
Hover:      [ ☰ Menu ] ← Naik 2px + Background putih + Shadow
```

#### Notifikasi Badge:
```
Normal:     🔔 (3) ← Badge merah
Animated:   🔔 (3) ← Pulse effect (membesar-mengecil)
```

#### User Dropdown:
```
Normal:     [ 👤 Nama User ▼ ]
Hover:      [ 👤 Nama User ▼ ] ← Naik + Background + Avatar scale
```

---

### 3. DROPDOWN MENU

```
┌─────────────────────────────────────┐
│ ▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │ ← Header hijau
│  👤 Nama Lengkap                    │
│  ✓ Anggota                          │
├─────────────────────────────────────┤
│  ⚙️ Profil Saya                     │ ← Hover: Hijau muda
├─────────────────────────────────────┤
│  🚪 Keluar                          │
└─────────────────────────────────────┘
```

**Header**: Gradient hijau (#10b981 → #059669)
**Hover Item**: Gradient hijau muda (#d1fae5 → #a7f3d0)

---

### 4. NOTIFIKASI DROPDOWN

```
┌─────────────────────────────────────────────┐
│ 🔔 3 Notifikasi Belum Dibaca                │ ← Background hijau
├─────────────────────────────────────────────┤
│  ● Pendaftaran Lulus                        │
│    2 jam yang lalu                          │
├─────────────────────────────────────────────┤
│  ● Pengumuman Baru                          │
│    5 jam yang lalu                          │
├─────────────────────────────────────────────┤
│  ● Jadwal Kegiatan                          │
│    1 hari yang lalu                         │
├─────────────────────────────────────────────┤
│  Lihat Semua Notifikasi →                  │
└─────────────────────────────────────────────┘
```

---

### 5. SIDEBAR (Tetap Biru Navy)

```
╔═══════════════════════════╗
║ ▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ ║ ← Brand: Gradient hijau
║  🏛️  DISPERINDAGKOP      ║
║     Kab. Tolikara        ║
╠═══════════════════════════╣
║                           ║
║  📊 Dashboard             ║ ← Menu normal
║                           ║
║  PROFIL & DATA            ║ ← Header
║  👤 Profil Saya           ║
║  🎫 Kartu Anggota         ║
║                           ║
║  INFORMASI                ║
║  📢 Pengumuman            ║ ← Active (overlay putih)
║  📅 Jadwal Kegiatan       ║
║                           ║
║  KOMUNIKASI               ║
║  💬 Chat dengan Admin (2) ║
║                           ║
╚═══════════════════════════╝
```

**Sidebar**: Biru navy (#34495e)
**Brand Link**: Gradient hijau (#059669 → #047857)
**Menu Active**: Overlay putih transparan

---

## 🎬 ANIMASI

### 1. Shimmer Effect (Top Border)
```
Frame 1:  ▓░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
Frame 2:  ░░▓░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
Frame 3:  ░░░░▓░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
Frame 4:  ░░░░░░▓░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
...       (bergerak terus ke kanan)
```
**Durasi**: 3 detik
**Loop**: Infinite

### 2. Pulse Effect (Badge)
```
Frame 1:  🔔 (3)     ← Normal size
Frame 2:  🔔 (3)     ← Scale 1.04
Frame 3:  🔔 (3)     ← Scale 1.08 (max)
Frame 4:  🔔 (3)     ← Scale 1.04
Frame 5:  🔔 (3)     ← Back to normal
```
**Durasi**: 2 detik
**Loop**: Infinite

### 3. Hover Transform
```
Before:   [ Menu Item ]
Hover:    [ Menu Item ] ↑ 2px + Shadow
```
**Durasi**: 0.3 detik
**Easing**: ease

---

## 🎨 PALET WARNA

### Hijau (Navbar)
```
#10b981  ████████  Emerald 500 (Terang)
#059669  ████████  Emerald 600 (Medium)
#047857  ████████  Emerald 700 (Gelap)
#34d399  ████████  Emerald 400 (Shimmer)
```

### Hijau Muda (Hover)
```
#d1fae5  ████████  Emerald 100
#a7f3d0  ████████  Emerald 200
```

### Biru Navy (Sidebar)
```
#34495e  ████████  Sidebar background
#2c3e50  ████████  Darker shade
```

### Merah (Badge)
```
#ef4444  ████████  Red 500
#dc2626  ████████  Red 600
```

### Putih (Text & Overlay)
```
#ffffff  ████████  Text color
rgba(255,255,255,0.2)  ░░░░░░░░  Hover overlay
rgba(255,255,255,0.15) ░░░░░░░░  Active overlay
```

---

## 📐 SPACING & SIZING

### Navbar
- **Height**: Auto (padding 8px vertical)
- **Padding**: 8px 15px per item
- **Border Radius**: 8px (hover state)
- **Shadow**: 0 4px 15px rgba(16, 185, 129, 0.4)

### Dropdown
- **Border Radius**: 8px
- **Min Width**: 220px (user) / 320px (notifikasi)
- **Shadow**: 0 4px 20px rgba(0,0,0,0.15)

### Badge
- **Padding**: 4px 8px
- **Border Radius**: 50% (circle)
- **Border**: 2px solid rgba(255,255,255,0.3)
- **Font Weight**: 700

### Avatar
- **Size**: 32px × 32px
- **Border**: 3px solid rgba(255,255,255,0.5)
- **Border Radius**: 50% (circle)

---

## 🎯 INTERAKSI USER

### 1. Klik Menu (☰)
```
Action: Toggle sidebar
Effect: Sidebar slide in/out
```

### 2. Hover Menu Item
```
Action: Mouse over
Effect: Background + Transform + Shadow
Duration: 0.3s
```

### 3. Klik Notifikasi (🔔)
```
Action: Click bell icon
Effect: Dropdown muncul dengan list notifikasi
```

### 4. Klik User Avatar (👤)
```
Action: Click avatar/name
Effect: Dropdown menu (Profil, Keluar)
```

### 5. Hover Badge
```
Action: Mouse over badge
Effect: Pulse animation lebih cepat
```

---

## 💻 RESPONSIVE BEHAVIOR

### Desktop (> 1200px)
```
[ ☰ ]  Portal Anggota Koperasi    [ 🔔 (3) ]  [ 👤 Nama User ▼ ]
```

### Tablet (768px - 1200px)
```
[ ☰ ]  Portal Anggota    [ 🔔 (3) ]  [ 👤 User ▼ ]
```

### Mobile (< 768px)
```
[ ☰ ]  Portal    [ 🔔 (3) ]  [ 👤 ]
```

---

## ✨ TIPS VISUAL

1. **Shimmer Line**: Perhatikan garis tipis di atas navbar yang bergerak
2. **Badge Pulse**: Badge notifikasi berkedip halus untuk menarik perhatian
3. **Hover Smooth**: Semua hover effect smooth dengan transition 0.3s
4. **Shadow Depth**: Shadow memberikan kesan depth dan modern
5. **Gradient Flow**: Gradient hijau mengalir dari terang ke gelap
6. **Icon Animation**: Icon membesar sedikit saat hover

---

## 🔍 DETAIL KECIL YANG PENTING

- ✅ Border putih pada avatar saat hover
- ✅ Transform naik 2px saat hover (subtle tapi terasa)
- ✅ Shadow berubah intensitas saat hover
- ✅ Badge dengan border putih transparan
- ✅ Dropdown header dengan gradient hijau
- ✅ Hover item dropdown: hijau muda
- ✅ Transition smooth di semua element
- ✅ Icon scale up saat hover

---

**KESIMPULAN**: 
Navbar hijau dengan gradient, animasi shimmer, dan hover effects yang menarik. 
Terlihat modern, fresh, dan profesional! 🌿✨

**CARA LIHAT**: 
Hard refresh browser (Ctrl+Shift+R) di halaman portal anggota!
