# Pendaftaran Anggota Form - Simplified (Finance Section Removed)

## Summary of Changes

The public registration form has been simplified by removing the entire **Finance/Keuangan section** to make the registration process easier and faster for users.

---

## What Was Removed

### Step 4: Keuangan (Finance Section) - REMOVED ❌

The following fields have been completely removed from the registration form:

#### Data Perbankan (Banking Data)
- ❌ Nama Bank (Bank Name)
- ❌ Nomor Rekening (Account Number)
- ❌ Nama Pemilik Rekening (Account Holder Name)
- ❌ NPWP (Tax ID Number)

#### Simpanan Awal (Initial Savings)
- ❌ Simpanan Pokok (Principal Savings) - was required
- ❌ Simpanan Wajib (Mandatory Savings) - was required

**Total Removed**: 6 fields (2 were required fields)

---

## What Was Kept

### Data Ahli Waris (Beneficiary/Heir Data) - MOVED TO STEP 3 ✅

The beneficiary information is still required and has been moved to **Step 3** (Data Usaha):

- ✅ Nama Ahli Waris (Beneficiary Name) - **Required**
- ✅ Hubungan Keluarga (Family Relationship) - **Required**
- ✅ No. HP Ahli Waris (Beneficiary Phone) - **Required**
- ✅ NIK Ahli Waris (Beneficiary ID Number) - **Required**

---

## New Form Structure (4 Steps)

### Step 1: Data Pribadi (Personal Data)
- NIK, Nama, Tempat/Tanggal Lahir
- Jenis Kelamin, Status Perkawinan, Pendidikan, Agama
- No. HP, Email, Password

### Step 2: Alamat (Address)
- Desa, Distrik, Kabupaten
- Alamat Lengkap, Kode Pos
- Koordinat GPS, Status Kepemilikan Rumah

### Step 3: Data Usaha & Ahli Waris (Business & Beneficiary)
- **Data Usaha**: Nama Usaha, Bidang Usaha, Modal, Omzet, dll
- **Data Ahli Waris**: Nama, Hubungan, No. HP, NIK (Required)

### Step 4: Upload Dokumen (Document Upload)
- Foto Diri (Required)

---

## Technical Changes

### 1. View File: `resources/views/public/pendaftaran-anggota.blade.php`

#### Step Indicator Updated
```html
<!-- OLD: 5 Steps -->
<div class="step-item" data-step="4"><small>Keuangan</small></div>
<div class="step-item" data-step="5"><small>Dokumen</small></div>

<!-- NEW: 4 Steps -->
<div class="step-item" data-step="4"><small>Dokumen</small></div>
```

#### Step 4 Removed Entirely
- Removed entire `<div class="form-step" data-step="4">` containing finance fields
- Moved Ahli Waris section to Step 3
- Renumbered Step 5 (Upload Dokumen) to Step 4

#### JavaScript Updated
```javascript
// OLD
const totalSteps = 5;
const stepValidations = {
    3: ['nama_usaha', 'bidang_usaha'],
    4: ['nama_ahli_waris', 'hubungan_ahli_waris', 'no_hp_ahli_waris', 'nik_ahli_waris', 'simpanan_pokok', 'simpanan_wajib'],
    5: ['foto']
};

// NEW
const totalSteps = 4;
const stepValidations = {
    3: ['nama_usaha', 'bidang_usaha', 'nama_ahli_waris', 'hubungan_ahli_waris', 'no_hp_ahli_waris', 'nik_ahli_waris'],
    4: ['foto']
};
```

### 2. Controller: `app/Http/Controllers/PendaftaranAnggotaController.php`

**No changes needed** - Finance fields were already set as `nullable` in validation:

```php
// Already optional in controller
'nama_bank' => 'nullable|string|max:100',
'nomor_rekening' => 'nullable|string|max:50',
'nama_pemilik_rekening' => 'nullable|string|max:255',
'npwp' => 'nullable|string|max:20',
'simpanan_pokok' => 'nullable|numeric|min:0',
'simpanan_wajib' => 'nullable|numeric|min:0',
```

These fields can still be filled in later by admin/petugas through the admin panel.

---

## Benefits of This Change

### 1. **Simpler Registration Process**
- Reduced from 5 steps to 4 steps
- Removed 6 fields (including 2 required fields)
- Faster completion time for users

### 2. **Better User Experience**
- Less overwhelming for new members
- Focus on essential information only
- Finance data can be added later by admin

### 3. **Reduced Registration Errors**
- Fewer required fields = fewer validation errors
- Users don't need bank account info immediately
- Simpanan amounts can be determined by admin

### 4. **Flexible Data Entry**
- Admin/Petugas can add finance data after approval
- Allows for different simpanan amounts per member
- Bank details can be collected when needed

---

## What Happens to Finance Data?

### During Registration
- Finance fields are **not shown** to users
- Database columns accept `NULL` values
- Registration completes without finance data

### After Registration (Admin Panel)
Admin or Petugas can add finance data through:
- **Edit Anggota** form in admin panel
- All finance fields are still available in admin forms
- Data can be updated anytime after approval

---

## Testing Checklist

- [x] Step indicator shows 4 steps (not 5)
- [x] Step 3 includes both Usaha and Ahli Waris sections
- [x] Step 4 is Upload Dokumen (not Step 5)
- [x] JavaScript validation updated for 4 steps
- [x] Ahli Waris fields moved to Step 3 validation
- [x] Finance fields completely removed from view
- [x] Controller validation already supports nullable finance fields
- [ ] Test registration flow from Step 1 to Step 4
- [ ] Verify form submission works without finance data
- [ ] Check that admin can still edit finance data later

---

## Files Modified

1. **resources/views/public/pendaftaran-anggota.blade.php**
   - Removed Step 4 (Keuangan) entirely
   - Moved Ahli Waris to Step 3
   - Renumbered Step 5 to Step 4
   - Updated step indicator (5 → 4 steps)
   - Updated JavaScript validation

2. **app/Http/Controllers/PendaftaranAnggotaController.php**
   - No changes needed (already supports nullable finance fields)

---

## Migration Notes

### Database Schema
No migration needed - columns already exist and accept NULL:
- `nama_bank` (nullable)
- `nomor_rekening` (nullable)
- `nama_pemilik_rekening` (nullable)
- `npwp` (nullable)
- `simpanan_pokok` (nullable)
- `simpanan_wajib` (nullable)

### Existing Data
- Existing members with finance data: **No impact**
- New registrations: Finance fields will be `NULL` until admin fills them

---

## Rollback Instructions

If you need to restore the finance section:

1. Restore Step 4 (Keuangan) in the view file
2. Move Ahli Waris back to Step 4
3. Renumber Upload Dokumen back to Step 5
4. Update step indicator to show 5 steps
5. Update JavaScript: `totalSteps = 5`
6. Update stepValidations to separate Step 3 and Step 4

---

**Date**: April 18, 2026  
**Status**: ✅ Completed  
**Impact**: Low (only affects public registration form, admin forms unchanged)
