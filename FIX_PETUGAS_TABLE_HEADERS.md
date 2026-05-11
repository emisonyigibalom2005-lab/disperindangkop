# Fix Table Headers - Petugas Views

## Problem:
Beberapa table header di views Petugas memiliki teks yang gelap/hitam sehingga tidak terlihat jelas pada background yang gelap.

## Solution:
Tambahkan `color: #ffffff !important;` atau `color: #1f2937;` (untuk background terang) pada semua `<th>` di `<thead>`.

## Files yang Perlu Diperbaiki:

### ✅ SUDAH BAIK (Tidak Perlu Diubah):
1. ✅ `anggota-koperasi/index.blade.php` - Sudah putih
2. ✅ `anggota/index.blade.php` - Sudah putih
3. ✅ `berita/index-table.blade.php` - Sudah baik (background terang, text gelap)
4. ✅ `pengumuman/index-table.blade.php` - Sudah baik (background terang, text gelap)

### 🔧 PERLU DIPERBAIKI:

#### 1. jadwal/index.blade.php
**Current:**
```css
.table-card thead th {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    color: #1a3a6e;
}
```

**Fix:** Sudah baik, tapi pastikan warna kontras cukup.

#### 2. koperasi/index.blade.php
**Current:**
```css
.table-modern thead th {
    border: none;
    padding: 15px 12px;
}
```

**Fix:** Tambahkan:
```css
.table-modern thead th {
    background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%) !important;
    color: #ffffff !important;
    border: none;
    padding: 15px 12px;
    font-weight: 700;
    text-shadow: 0 1px 2px rgba(0,0,0,0.2);
}
```

#### 3. struktur/index.blade.php
**Current:**
```html
<thead class="thead-light">
```

**Fix:** Ganti dengan:
```html
<thead style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);">
    <th style="color: #ffffff !important; font-weight: 700;">
```

#### 4. pelatihan/index.blade.php
**Current:**
```html
<thead class="thead-light">
```

**Fix:** Ganti dengan:
```html
<thead style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);">
    <th style="color: #ffffff !important; font-weight: 700;">
```

#### 5. pelatihan/peserta.blade.php
**Current:**
```html
<thead class="thead-light">
```

**Fix:** Ganti dengan:
```html
<thead style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);">
    <th style="color: #ffffff !important; font-weight: 700;">
```

#### 6. jadwal/show.blade.php
**Current:**
```html
<thead class="thead-light">
```

**Fix:** Ganti dengan:
```html
<thead style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);">
    <th style="color: #ffffff !important; font-weight: 700;">
```

## Standard CSS untuk Table Header:

### Option 1: Dark Blue Gradient (Recommended)
```css
.table-modern thead th {
    background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%) !important;
    color: #ffffff !important;
    border: none;
    font-size: 13px !important;
    font-weight: 800 !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 12px;
    white-space: nowrap;
    text-align: center;
    text-shadow: 0 1px 2px rgba(0,0,0,0.2);
}
```

### Option 2: Light Gray (For Light Theme)
```css
.table-modern thead th {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    color: #1f2937 !important;
    border: none;
    font-size: 13px !important;
    font-weight: 800 !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 12px;
    white-space: nowrap;
    text-align: center;
}
```

### Option 3: Inline Style (Quick Fix)
```html
<thead style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);">
    <tr>
        <th style="color: #ffffff !important; font-weight: 700; padding: 14px 12px; border: none;">
            Column Name
        </th>
    </tr>
</thead>
```

## Implementation Priority:

### High Priority (User-facing tables):
1. 🔴 koperasi/index.blade.php
2. 🔴 struktur/index.blade.php
3. 🔴 pelatihan/index.blade.php
4. 🔴 jadwal/index.blade.php

### Medium Priority:
5. 🟡 pelatihan/peserta.blade.php
6. 🟡 jadwal/show.blade.php

## Testing Checklist:

After fixing each file, test:
- [ ] Text is clearly visible (white on dark, dark on light)
- [ ] Font weight is bold (700-800)
- [ ] Background gradient is smooth
- [ ] Icons are visible
- [ ] Responsive on mobile
- [ ] No text overflow

## Notes:

- Always use `!important` for color to override Bootstrap defaults
- Use `text-shadow` for better readability on dark backgrounds
- Keep font-weight at 700-800 for headers
- Use uppercase for better visual hierarchy
- Ensure sufficient contrast ratio (WCAG AA: 4.5:1 minimum)
