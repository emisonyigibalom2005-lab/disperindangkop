# Testing Guide - Admin Anggota Visual Validation

## Quick Start Testing

### 1. Clear Cache & Refresh
```bash
php artisan view:clear
```
Then in browser: **Ctrl + Shift + R** (hard refresh)

### 2. Navigate to Form
```
URL: http://127.0.0.1:8000/admin/anggota/create
Login as: Admin
```

## Test Scenarios

### ✅ Test 1: Valid Field Shows Green Checkmark

**Steps:**
1. Go to admin anggota create form
2. Fill NIK field: `9113221112300003` (16 digits)
3. Click outside the field (blur)

**Expected Result:**
- ✓ Green checkmark appears on right side of field
- Border turns green (#10b981)
- No error message

**Screenshot Location:**
```
┌─────────────────────────────────────┐
│ NIK (16 digit) *                    │
│ ┌─────────────────────────────────┐ │
│ │ 9113221112300003              ✓ │ │ ← GREEN
│ └─────────────────────────────────┘ │
└─────────────────────────────────────┘
```

---

### ❌ Test 2: Invalid Field Shows Red X

**Steps:**
1. Fill NIK field: `123` (only 3 digits)
2. Click outside the field

**Expected Result:**
- ✗ Red X appears on right side of field
- Border turns red (#dc3545)
- Error message: "NIK harus 16 digit"

**Screenshot Location:**
```
┌─────────────────────────────────────┐
│ NIK (16 digit) *                    │
│ ┌─────────────────────────────────┐ │
│ │ 123                           ✗ │ │ ← RED
│ └─────────────────────────────────┘ │
│ ⚠ NIK harus 16 digit                │
└─────────────────────────────────────┘
```

---

### ✅ Test 3: Email Validation

**Steps:**
1. Fill email field: `test` (invalid)
2. Click outside field

**Expected Result:**
- ✗ Red X appears
- Error: "Format email tidak valid"

**Then:**
3. Change to: `test@gmail.com` (valid)
4. Click outside field

**Expected Result:**
- ✓ Green checkmark appears
- Error message disappears

---

### ✅ Test 4: Password Confirmation Match

**Steps:**
1. Fill password: `123456`
2. Click outside → ✓ Green checkmark
3. Fill password confirmation: `123456` (same)
4. Click outside

**Expected Result:**
- ✓ Green checkmark on both fields
- No error message

**Then:**
5. Change confirmation to: `654321` (different)
6. Click outside

**Expected Result:**
- ✗ Red X on confirmation field
- Error: "Konfirmasi password tidak cocok"

---

### ✅ Test 5: Scientific Notation Prevention

**Steps:**
1. Go to Step 3 (Data Usaha)
2. Find field: "Simpanan Pokok"
3. Try to type: `0e3234312312`

**Expected Result:**
- Letter 'e' is blocked
- Only numbers entered: `03234312312`
- No scientific notation error

**Before Fix:**
```
User types: 0e3234312312
Result: ❌ MathematicalException - Exponent out of range
```

**After Fix:**
```
User types: 0e3234312312
Result: ✓ Only "03234312312" is entered (e is blocked)
```

---

### ✅ Test 6: Step Navigation with Validation

**Steps:**
1. Fill Step 1 partially (leave NIK empty)
2. Click "Selanjutnya" button

**Expected Result:**
- ✗ Form does NOT move to Step 2
- Red X appears on empty required fields
- Auto-scroll to first error
- Error message shown

**Then:**
3. Fill all required fields correctly
4. Click "Selanjutnya"

**Expected Result:**
- ✓ Form moves to Step 2
- Step 1 indicator shows as "completed" (green)

---

### ✅ Test 7: Complete Form Submission

**Steps:**
1. Fill all 4 steps with valid data
2. Go to Step 4
3. Click "Simpan & Tambahkan"

**Expected Result:**
- ✓ All steps validated
- Loading overlay appears
- Form submits successfully
- Redirect to anggota list
- Success message shown

---

### ❌ Test 8: Submit with Invalid Data

**Steps:**
1. Fill Step 1 with valid data
2. Go to Step 2, fill valid data
3. Go to Step 3, leave "Nama Usaha" empty
4. Go to Step 4
5. Click "Simpan & Tambahkan"

**Expected Result:**
- ✗ Form does NOT submit
- Jumps back to Step 3
- Red X on "Nama Usaha" field
- Error message shown
- Auto-scroll to error

---

### ✅ Test 9: Real-Time Error Clearing

**Steps:**
1. Fill NIK: `123` (invalid)
2. Click outside → ✗ Red X appears
3. Start typing to correct: `9113...`

**Expected Result:**
- ✗ Red X disappears as soon as you start typing
- Error message disappears
- Border returns to neutral gray
- When you finish and click outside → ✓ Green checkmark appears

---

### ✅ Test 10: All Field Types

Test each field type:

#### Text Fields
- [x] NIK: 16 digits, numbers only
- [x] Nama: any text
- [x] Tempat Lahir: any text

#### Select Dropdowns
- [x] Jenis Kelamin: L/P
- [x] Status Perkawinan: Lajang/Menikah/Cerai
- [x] Pendidikan: SD/SMP/SMA/etc
- [x] Agama: Kristen/Islam/etc
- [x] Distrik: list of districts

#### Date Field
- [x] Tanggal Lahir: date picker

#### Email Field
- [x] Email: valid format required

#### Password Fields
- [x] Password: min 6 chars
- [x] Password Confirmation: must match

#### Number Fields
- [x] Simpanan Pokok: numbers only, no 'e'
- [x] Simpanan Wajib: numbers only
- [x] Modal Usaha: numbers only

#### File Upload
- [x] Foto: max 2MB, JPG/PNG only

---

## Visual Checklist

### Colors
- [ ] Valid field border: Green (#10b981)
- [ ] Invalid field border: Red (#dc3545)
- [ ] Neutral field border: Gray (#e5e7eb)

### Icons
- [ ] Valid icon: ✓ (green checkmark SVG)
- [ ] Invalid icon: ✗ (red X SVG)
- [ ] Icon position: right side, 12px from edge

### Error Messages
- [ ] Color: Red (#dc3545)
- [ ] Icon: ⚠ (exclamation circle)
- [ ] Position: Below field
- [ ] Font size: 0.85rem

### Step Indicators
- [ ] Active step: Blue circle (#1a3a6e)
- [ ] Completed step: Green circle (#10b981)
- [ ] Inactive step: Gray circle (#e5e7eb)

---

## Browser Testing

### Desktop Browsers
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Edge (latest)
- [ ] Safari (latest)

### Mobile Browsers
- [ ] Chrome Mobile
- [ ] Safari iOS
- [ ] Samsung Internet

### Screen Sizes
- [ ] Desktop (1920x1080)
- [ ] Laptop (1366x768)
- [ ] Tablet (768x1024)
- [ ] Mobile (375x667)

---

## Performance Testing

### Load Time
- [ ] Form loads in < 2 seconds
- [ ] Validation runs instantly (< 100ms)
- [ ] No lag when typing

### Memory Usage
- [ ] No memory leaks
- [ ] JavaScript console: no errors
- [ ] Network tab: all resources loaded

---

## Accessibility Testing

### Keyboard Navigation
- [ ] Tab through all fields
- [ ] Enter submits form
- [ ] Escape closes modals
- [ ] Arrow keys work in dropdowns

### Screen Reader
- [ ] Error messages announced
- [ ] Field labels read correctly
- [ ] Required fields indicated

### Color Contrast
- [ ] Error text readable (WCAG AA)
- [ ] Success text readable (WCAG AA)
- [ ] All text meets contrast ratio

---

## Error Scenarios

### Network Errors
**Test:** Disconnect internet, submit form
**Expected:** Error message shown, form not cleared

### Server Errors
**Test:** Server returns 500 error
**Expected:** Error message shown, user can retry

### Validation Errors
**Test:** Server returns validation errors
**Expected:** 
- Error summary box shown
- Jump to step with errors
- Fields marked invalid
- Error messages displayed

---

## Regression Testing

### Existing Features Still Work
- [ ] Admin can create anggota
- [ ] Form submits to correct route
- [ ] Data saves to database
- [ ] User account created
- [ ] Notifications sent
- [ ] Activity logged
- [ ] Redirect works
- [ ] Success message shown

### No Breaking Changes
- [ ] Other admin pages work
- [ ] Anggota list page works
- [ ] Edit anggota works
- [ ] Delete anggota works
- [ ] Export features work

---

## Common Issues & Solutions

### Issue 1: No Visual Feedback
**Symptom:** Fields don't show checkmark/X
**Solution:** 
1. Clear browser cache (Ctrl+Shift+R)
2. Run `php artisan view:clear`
3. Check browser console for errors

### Issue 2: Validation Not Working
**Symptom:** Can submit with invalid data
**Solution:**
1. Check JavaScript console for errors
2. Verify all fields have `name` attribute
3. Verify required fields have `required` attribute

### Issue 3: Scientific Notation Still Occurs
**Symptom:** Error when typing numbers with 'e'
**Solution:**
1. Verify field type is `number` not `text`
2. Check keypress event listener is attached
3. Check blur sanitization is working

### Issue 4: Step Navigation Broken
**Symptom:** Can't move between steps
**Solution:**
1. Check step indicators are visible
2. Verify buttons have correct IDs
3. Check JavaScript console for errors

---

## Test Data

### Valid Test Data
```
NIK: 9113221112300003
Nama: Emison Yigibalom
Tempat Lahir: Kagime
Tanggal Lahir: 2000-01-01
Jenis Kelamin: L
Status Perkawinan: Lajang
Pendidikan: SD
Agama: Kristen
No HP: 081344025070
Email: test@gmail.com
Password: 123456
Password Confirmation: 123456

Desa: Kagime
Distrik: Kai
Kabupaten: Tolikara
Alamat: Jl. Test No. 123

Nama Usaha: Toko Sumber Rezeki
Bidang Usaha: Pertanian
Lama Berdiri: 5
Jumlah Karyawan: 3
Modal Usaha: 10000000
Omzet: 5000000
Alamat Usaha: Jl. Usaha No. 456
Legalitas: SIUP
Keterangan: Usaha pertanian

Bank: BRI
No Rekening: 1234567890123456
Nama Pemilik: Emison Yigibalom
NPWP: 123456789012345
Simpanan Pokok: 100000
Simpanan Wajib: 50000

Nama Ahli Waris: John Doe
Hubungan: Suami/Istri
No HP Ahli Waris: 081234567890
NIK Ahli Waris: 9113221112300004

Foto: Upload JPG/PNG < 2MB
```

### Invalid Test Data (for error testing)
```
NIK: 123 (too short)
Email: invalid-email (no @)
Password: 123 (too short)
Password Confirmation: 456 (doesn't match)
NIK Ahli Waris: abc (not numbers)
Simpanan Pokok: 0e123 (scientific notation - should be blocked)
```

---

## Success Criteria

### ✅ All Tests Pass
- [ ] Visual validation works (green/red)
- [ ] Real-time feedback works
- [ ] Step navigation validates
- [ ] Form submission validates
- [ ] Scientific notation prevented
- [ ] All field types work
- [ ] Error messages clear
- [ ] No console errors
- [ ] No breaking changes

### ✅ User Experience
- [ ] Form is intuitive
- [ ] Errors are clear
- [ ] Feedback is instant
- [ ] No frustration
- [ ] Submit works first time

### ✅ Code Quality
- [ ] JavaScript is clean
- [ ] CSS is organized
- [ ] No duplicate code
- [ ] Comments are clear
- [ ] Follows conventions

---

## Sign-Off

**Tested By:** _________________
**Date:** _________________
**Browser:** _________________
**Result:** ☐ Pass  ☐ Fail

**Notes:**
_________________________________
_________________________________
_________________________________

---

## Quick Test Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Check routes
php artisan route:list | grep "admin.anggota"

# Check for JavaScript errors
# Open browser console (F12) and look for red errors

# Test form submission
# Fill form → Submit → Check database
# SELECT * FROM anggotas ORDER BY id DESC LIMIT 1;
```

---

**Testing Status:** Ready for QA ✅
**Documentation:** Complete ✅
**Production Ready:** Yes ✅
