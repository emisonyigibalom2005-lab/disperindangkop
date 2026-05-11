# TECHNICAL DETAILS: FORM PENDAFTARAN VALIDATION

## OVERVIEW

Form pendaftaran anggota koperasi dengan:
- ✅ Multi-step form (4 steps)
- ✅ Client-side validation (JavaScript)
- ✅ Server-side validation (Laravel)
- ✅ Real-time validation feedback
- ✅ Data persistence on error
- ✅ Auto-scroll to errors
- ✅ Visual indicators (red/green borders)

---

## ARCHITECTURE

### **Frontend (Blade + JavaScript)**
```
resources/views/public/pendaftaran-anggota.blade.php
```

### **Backend (Laravel Controller)**
```
app/Http/Controllers/PendaftaranAnggotaController.php
```

### **Model**
```
app/Models/Anggota.php
app/Models/User.php
app/Models/PeriodePendaftaran.php
```

---

## CLIENT-SIDE VALIDATION

### **JavaScript Functions**

#### **1. validateField(fieldName)**
```javascript
// Validates a single field
// Returns: true if valid, false if invalid
// Side effects: Adds/removes .is-invalid and .is-valid classes

function validateField(fieldName) {
    const field = document.querySelector(`[name="${fieldName}"]`);
    if (!field) return true;
    
    const value = field.value.trim();
    const isRequired = field.hasAttribute('required');
    
    // Check required
    if (isRequired && !value) {
        showFieldError(field, 'Field ini wajib diisi');
        return false;
    }
    
    // Specific validations
    // - NIK: 16 digits, numeric only
    // - Email: valid email format
    // - Password: min 6 characters
    // - Password confirmation: must match password
    // - File: max 2MB, JPG/JPEG/PNG only
    
    return true;
}
```

#### **2. validateStep(step)**
```javascript
// Validates all fields in a specific step
// Returns: true if all valid, false if any invalid

const stepValidations = {
    1: ['nik', 'nama', 'tempat_lahir', ...],
    2: ['distrik'],
    3: ['nama_usaha', 'bidang_usaha', ...],
    4: ['foto']
};

function validateStep(step) {
    const fieldsToValidate = stepValidations[step] || [];
    let isValid = true;
    
    fieldsToValidate.forEach(fieldName => {
        if (!validateField(fieldName)) {
            isValid = false;
        }
    });
    
    return isValid;
}
```

#### **3. showFieldError(field, message)**
```javascript
// Shows error message below field
// Adds .is-invalid class to field
// Creates error div with icon and message

function showFieldError(field, message) {
    field.classList.add('is-invalid');
    const fieldGroup = field.closest('.col-md-6') || field.closest('.col-md-4');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback d-block';
    errorDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i>${message}`;
    
    fieldGroup.appendChild(errorDiv);
}
```

### **Event Listeners**

#### **Real-time Validation**
```javascript
// Validate on blur (when user leaves field)
document.querySelectorAll('input, select, textarea').forEach(field => {
    field.addEventListener('blur', function() {
        validateField(this.name);
    });
    
    // Remove error on input (when user starts typing)
    field.addEventListener('input', function() {
        this.classList.remove('is-invalid');
        // Remove error message
    });
});
```

#### **Step Navigation**
```javascript
// Next button
document.getElementById('btnNext').addEventListener('click', () => {
    if (validateStep(currentStep)) {
        currentStep++;
        showStep(currentStep);
    } else {
        // Scroll to first error
        const firstError = document.querySelector('.is-invalid');
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});

// Previous button
document.getElementById('btnPrev').addEventListener('click', () => {
    currentStep--;
    showStep(currentStep);
});
```

#### **Form Submit**
```javascript
document.getElementById('formPendaftaran').addEventListener('submit', function(e) {
    // Validate all steps
    let allValid = true;
    for (let step = 1; step <= totalSteps; step++) {
        if (!validateStep(step)) {
            allValid = false;
            // Go to first invalid step
            currentStep = step;
            showStep(currentStep);
            e.preventDefault();
            return false;
        }
    }
    
    // Show loading overlay
    const submitBtn = document.getElementById('btnSubmit');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
    
    // Create loading overlay
    // ...
});
```

### **Auto-scroll to Errors**
```javascript
document.addEventListener('DOMContentLoaded', function() {
    const errorSummary = document.getElementById('errorSummary');
    if (errorSummary) {
        setTimeout(() => {
            errorSummary.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
            // Find which step has errors
            const invalidFields = document.querySelectorAll('.is-invalid');
            if (invalidFields.length > 0) {
                const firstInvalidField = invalidFields[0];
                const stepElement = firstInvalidField.closest('.form-step');
                const stepNumber = parseInt(stepElement.getAttribute('data-step'));
                
                currentStep = stepNumber;
                showStep(currentStep);
            }
        }, 500);
    }
});
```

---

## SERVER-SIDE VALIDATION

### **Controller: PendaftaranAnggotaController.php**

#### **store() Method**

```php
public function store(Request $request)
{
    // 1. Check active period
    $periode = PeriodePendaftaran::aktif()->first();
    if (!$periode) {
        return redirect()->route('pendaftaran.index')
            ->with('error', 'Pendaftaran sedang ditutup.');
    }
    
    // 2. Check quota
    if ($periode->is_kuota_penuh) {
        return redirect()->route('pendaftaran.index')
            ->with('error', 'Kuota pendaftaran sudah penuh.');
    }
    
    // 3. Validate input
    $validated = $request->validate([
        // Validation rules
    ], [
        // Custom error messages
    ]);
    
    // 4. Create user and anggota
    DB::beginTransaction();
    try {
        // Generate unique no_anggota
        // Upload files
        // Create User
        // Create Anggota
        // Update periode counter
        
        DB::commit();
        
        // 5. Auto-login
        auth()->login($user);
        
        // 6. Redirect to dashboard
        return redirect()->route('anggota.dashboard')
            ->with('success', 'Pendaftaran berhasil!');
            
    } catch (\Exception $e) {
        DB::rollBack();
        
        // Handle errors
        return redirect()->back()
            ->withInput()  // IMPORTANT: Preserve form data
            ->with('error', $e->getMessage());
    }
}
```

### **Validation Rules**

```php
$validated = $request->validate([
    // Identitas Pribadi
    'nik' => 'required|string|size:16|unique:anggotas,nik',
    'nama' => 'required|string|max:255',
    'tempat_lahir' => 'required|string|max:100',
    'tanggal_lahir' => 'required|date|before:today',
    'jenis_kelamin' => 'required|in:L,P',
    'status_perkawinan' => 'required|in:Lajang,Menikah,Cerai',
    'pendidikan_terakhir' => 'required|string',
    'agama' => 'required|string',
    'no_hp' => 'required|string|max:15',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|string|min:6|confirmed',
    
    // Alamat
    'distrik' => 'required|string|max:100',
    'desa' => 'nullable|string|max:100',
    'kabupaten' => 'nullable|string|max:100',
    'alamat_lengkap' => 'nullable|string',
    
    // Usaha
    'nama_usaha' => 'required|string|max:255',
    'bidang_usaha' => 'required|string|max:100',
    
    // Ahli Waris
    'nama_ahli_waris' => 'required|string|max:255',
    'hubungan_ahli_waris' => 'required|string|max:50',
    'no_hp_ahli_waris' => 'required|string|max:15',
    'nik_ahli_waris' => 'required|string|size:16',
    
    // Files
    'foto' => 'required|image|mimes:jpeg,jpg,png|max:2048',
], [
    // Custom error messages
    'nik.required' => 'NIK wajib diisi',
    'nik.size' => 'NIK harus 16 digit',
    'nik.unique' => 'NIK sudah terdaftar',
    'email.required' => 'Email wajib diisi',
    'email.email' => 'Format email tidak valid',
    'email.unique' => 'Email sudah terdaftar',
    'password.min' => 'Password minimal 6 karakter',
    'password.confirmed' => 'Konfirmasi password tidak cocok',
    'foto.required' => 'Foto diri wajib diupload',
    'foto.max' => 'Ukuran foto maksimal 2MB',
    // ... more custom messages
]);
```

### **Error Handling**

```php
try {
    // Process registration
    
} catch (\Illuminate\Validation\ValidationException $e) {
    // Laravel handles this automatically
    // Redirects back with errors and old input
    throw $e;
    
} catch (\Illuminate\Database\QueryException $e) {
    DB::rollBack();
    
    // Handle duplicate entry errors
    if ($e->getCode() == 23000) {
        if (strpos($errorMessage, 'nik') !== false) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nik' => 'NIK sudah terdaftar']);
        }
        
        if (strpos($errorMessage, 'email') !== false) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['email' => 'Email sudah terdaftar']);
        }
    }
    
    return redirect()->back()
        ->withInput()
        ->with('error', 'Terjadi kesalahan database');
        
} catch (\Exception $e) {
    DB::rollBack();
    
    return redirect()->back()
        ->withInput()
        ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
}
```

---

## DATA PERSISTENCE

### **How It Works**

1. **Form Submission with Errors**
   ```php
   return redirect()->back()
       ->withInput()  // Preserve all input data
       ->withErrors($errors);  // Pass validation errors
   ```

2. **Blade Template**
   ```blade
   <input type="text" name="nik" value="{{ old('nik') }}">
   <input type="text" name="nama" value="{{ old('nama') }}">
   <select name="jenis_kelamin">
       <option value="L" {{ old('jenis_kelamin')=='L'?'selected':'' }}>Laki-laki</option>
       <option value="P" {{ old('jenis_kelamin')=='P'?'selected':'' }}>Perempuan</option>
   </select>
   <textarea name="alamat_lengkap">{{ old('alamat_lengkap') }}</textarea>
   ```

3. **Error Display**
   ```blade
   @error('nik')
   <div class="invalid-feedback d-block">
       <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
   </div>
   @enderror
   ```

### **All Fields with old() Helper**

Every input field in the form has `value="{{ old('field_name') }}"` or `{{ old('field_name') }}` to preserve data on validation errors.

---

## CSS STYLING

### **Form Control States**

```css
/* Normal state */
.form-control {
    border-radius: 8px;
    border: 2px solid #e5e7eb;
    padding: 10px 14px;
}

/* Focus state */
.form-control:focus {
    border-color: #1a3a6e;
    box-shadow: 0 0 0 3px rgba(26, 58, 110, 0.1);
}

/* Invalid state */
.form-control.is-invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,..."); /* Red X icon */
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 40px;
}

/* Valid state */
.form-control.is-valid {
    border-color: #10b981;
    background-image: url("data:image/svg+xml,..."); /* Green checkmark */
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 40px;
}
```

### **Error Message Styling**

```css
.invalid-feedback {
    display: block;
    color: #dc3545;
    font-size: 0.85rem;
    margin-top: 5px;
}
```

### **Step Indicator**

```css
.step-item.active .step-circle {
    background: #1a3a6e;
    border-color: #1a3a6e;
    color: white;
}

.step-item.completed .step-circle {
    background: #10b981;
    border-color: #10b981;
    color: white;
}
```

---

## ERROR SUMMARY BOX

### **Structure**

```blade
@if($errors->any())
<div class="alert alert-danger" id="errorSummary">
    <!-- Header with icon -->
    <div class="d-flex align-items-start mb-3">
        <div style="...">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div>
            <h5>Pendaftaran Belum Bisa Diproses</h5>
            <p>Terdapat {{ $errors->count() }} kesalahan</p>
        </div>
    </div>
    
    <!-- Error list -->
    <div class="error-list">
        @foreach($errors->all() as $index => $error)
        <div class="error-item">
            <div>{{ $index + 1 }}</div>
            <div>{{ $error }}</div>
        </div>
        @endforeach
    </div>
    
    <!-- Help text -->
    <div>
        <h6>Cara Memperbaiki:</h6>
        <ul>
            <li>Periksa field dengan border merah</li>
            <li>Data yang sudah diisi tetap tersimpan</li>
            <li>Perbaiki field yang error, lalu submit lagi</li>
        </ul>
    </div>
</div>
@endif
```

---

## TESTING

### **Unit Tests (Recommended)**

```php
// tests/Feature/PendaftaranAnggotaTest.php

public function test_form_validation_fails_with_empty_data()
{
    $response = $this->post(route('pendaftaran.store'), []);
    
    $response->assertSessionHasErrors([
        'nik', 'nama', 'email', 'password', 'distrik', 
        'nama_usaha', 'bidang_usaha', 'nama_ahli_waris', 'foto'
    ]);
}

public function test_form_validation_fails_with_invalid_nik()
{
    $response = $this->post(route('pendaftaran.store'), [
        'nik' => '123',  // Too short
        // ... other fields
    ]);
    
    $response->assertSessionHasErrors(['nik']);
}

public function test_form_validation_fails_with_duplicate_nik()
{
    // Create existing anggota
    Anggota::factory()->create(['nik' => '1234567890123456']);
    
    $response = $this->post(route('pendaftaran.store'), [
        'nik' => '1234567890123456',  // Duplicate
        // ... other fields
    ]);
    
    $response->assertSessionHasErrors(['nik']);
}

public function test_successful_registration()
{
    $periode = PeriodePendaftaran::factory()->create(['status' => 'aktif']);
    
    $response = $this->post(route('pendaftaran.store'), [
        'nik' => '1234567890123456',
        'nama' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        // ... all required fields
        'foto' => UploadedFile::fake()->image('foto.jpg'),
    ]);
    
    $response->assertRedirect(route('anggota.dashboard'));
    $this->assertAuthenticated();
}
```

### **Manual Testing Checklist**

- [ ] Submit empty form → Should show all required field errors
- [ ] Submit with invalid NIK (< 16 digits) → Should show NIK error
- [ ] Submit with duplicate NIK → Should show "NIK sudah terdaftar"
- [ ] Submit with duplicate email → Should show "Email sudah terdaftar"
- [ ] Submit with mismatched passwords → Should show password confirmation error
- [ ] Submit with large file (> 2MB) → Should show file size error
- [ ] Submit with wrong file format → Should show file format error
- [ ] Submit with all valid data → Should redirect to dashboard and auto-login
- [ ] Check data persistence → Fill form, submit with error, check if data still there
- [ ] Check auto-scroll → Submit with error, should scroll to error summary
- [ ] Check step navigation → Error in step 1, should show step 1

---

## PERFORMANCE CONSIDERATIONS

### **Client-side**
- Validation runs on blur (not on every keystroke)
- Debouncing for real-time validation
- Minimal DOM manipulation

### **Server-side**
- Database transaction for atomicity
- Unique constraint on NIK and email
- File upload validation before processing
- Proper error handling to prevent data corruption

---

## SECURITY

### **CSRF Protection**
```blade
<form method="POST">
    @csrf
    <!-- form fields -->
</form>
```

### **Input Sanitization**
- Laravel automatically sanitizes input
- XSS protection via Blade escaping
- SQL injection protection via Eloquent ORM

### **File Upload Security**
- Validate file type (image only)
- Validate file size (max 2MB)
- Store in secure location (`storage/app/public`)
- Generate unique filename

### **Password Security**
- Minimum 6 characters (can be increased)
- Hashed using bcrypt via `Hash::make()`
- Never stored in plain text

---

## BROWSER COMPATIBILITY

Tested on:
- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+

Required JavaScript features:
- ES6 (arrow functions, const/let)
- querySelector/querySelectorAll
- addEventListener
- classList API
- FileReader API (for image preview)

---

## FUTURE IMPROVEMENTS

### **Potential Enhancements**

1. **AJAX Form Submission**
   - Submit without page reload
   - Show errors inline without refresh
   - Better UX

2. **Progressive Form Saving**
   - Auto-save to localStorage
   - Resume form if user leaves page
   - Prevent data loss

3. **Image Compression**
   - Client-side image compression
   - Reduce file size before upload
   - Faster upload

4. **OTP Verification**
   - Verify phone number via SMS
   - Verify email via link
   - Prevent fake registrations

5. **Captcha**
   - Add reCAPTCHA
   - Prevent bot submissions

6. **Multi-language Support**
   - Indonesian and English
   - Bahasa Papua (if needed)

---

## CHANGELOG

### **Version 2.0 (Current)**
- ✅ Enhanced error summary box
- ✅ Auto-scroll to errors
- ✅ Auto-navigate to error step
- ✅ All fields have error handling
- ✅ Data persistence on all fields
- ✅ Visual indicators (red/green borders)
- ✅ Real-time validation
- ✅ Loading overlay on submit

### **Version 1.0 (Previous)**
- Basic form with validation
- Multi-step form
- Server-side validation
- File upload

---

## SUPPORT

For technical issues:
1. Check browser console for JavaScript errors
2. Check Laravel logs: `storage/logs/laravel.log`
3. Check database for duplicate entries
4. Verify periode pendaftaran is active
5. Verify kuota is not full

---

**Last Updated:** 6 Mei 2026
**Maintained By:** Development Team
