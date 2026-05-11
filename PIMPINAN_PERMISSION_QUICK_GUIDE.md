# PIMPINAN PERMISSION SYSTEM - QUICK REFERENCE GUIDE

## 🚀 QUICK START

### For Admin: How to Grant Permissions
1. Login as **Admin**
2. Go to **Admin → Sistem → Izin Akses**
3. Click **Edit** on **Pimpinan** role
4. Check the permissions you want to grant
5. Click **Simpan Perubahan**
6. Done! Changes take effect immediately

---

## 📋 AVAILABLE PERMISSIONS FOR PIMPINAN

| Module | View | Create | Edit | Delete | Export | Approve |
|--------|------|--------|------|--------|--------|---------|
| Dashboard | ✅ | - | - | - | - | - |
| Anggota Koperasi | ✅ | - | - | - | - | - |
| Koperasi | ✅ | - | - | - | - | - |
| Laporan | ✅ | - | - | - | ✅ | - |
| Jadwal | ✅ | - | - | - | - | - |
| Chat | ✅ | ✅ | ✅ | ✅ | - | - |
| Activity Log | ✅ | - | - | ✅ | - | - |

---

## 🔍 WHAT HAPPENS WHEN PERMISSION IS DENIED?

### Scenario 1: Accessing a Page (View Permission)
```
Pimpinan tries to access Dashboard without permission
→ Redirected to dashboard/login
→ Error message: "Anda tidak memiliki izin untuk mengakses Dashboard. Silakan hubungi Admin untuk mendapatkan akses."
```

### Scenario 2: Exporting Data (Export Permission)
```
Pimpinan tries to export laporan without permission
→ Redirected back to previous page
→ Error message: "Anda tidak memiliki izin untuk mengekspor laporan. Silakan hubungi Admin untuk mendapatkan akses."
```

### Scenario 3: Deleting Data (Delete Permission)
```
Pimpinan tries to delete activity log without permission
→ AJAX request returns error
→ JSON response: {"success": false, "message": "Anda tidak memiliki izin untuk menghapus log aktivitas."}
```

### Scenario 4: Sending Chat (Create Permission)
```
Pimpinan tries to send chat without permission
→ AJAX request returns error
→ JSON response: {"success": false, "message": "Anda tidak memiliki izin untuk mengirim pesan."}
```

---

## 🎯 COMMON USE CASES

### Use Case 1: Read-Only Access
**Goal**: Pimpinan can only view data, cannot modify anything

**Admin Action**:
- ✅ Check "View" for all modules
- ❌ Uncheck "Create", "Edit", "Delete", "Export"

**Result**: Pimpinan can see all data but cannot make changes

---

### Use Case 2: Full Access
**Goal**: Pimpinan has complete access to all features

**Admin Action**:
- ✅ Check ALL permissions for all modules

**Result**: Pimpinan can do everything (view, create, edit, delete, export)

---

### Use Case 3: Limited Access
**Goal**: Pimpinan can view and export reports only

**Admin Action**:
- ✅ Check "View" for Dashboard, Laporan
- ✅ Check "Export" for Laporan
- ❌ Uncheck everything else

**Result**: Pimpinan can view dashboard and export reports, nothing else

---

### Use Case 4: No Access (Locked Out)
**Goal**: Temporarily disable Pimpinan access

**Admin Action**:
- ❌ Uncheck ALL permissions

**Result**: Pimpinan cannot access any feature, redirected with error

---

## 🔐 IMPORTANT NOTES

### 1. Admin Always Has Access
- Admin role **bypasses all permission checks**
- Admin can always access everything
- This is hardcoded for security

### 2. Permissions Are Real-Time
- Changes take effect **immediately**
- No need to logout/login
- No cache to clear

### 3. Database-Driven
- Permissions stored in `role_permissions` table
- Can be modified through Admin UI
- No code changes needed

### 4. Consistent Error Messages
- All error messages in **Indonesian**
- User-friendly and clear
- Tells user to contact Admin

---

## 🛠️ TROUBLESHOOTING

### Problem: Pimpinan cannot access anything
**Solution**: 
1. Login as Admin
2. Go to Izin Akses
3. Check if Pimpinan has "View" permission for Dashboard
4. Grant necessary permissions

### Problem: Pimpinan can view but cannot export
**Solution**:
1. Login as Admin
2. Go to Izin Akses → Edit Pimpinan
3. Check "Export" permission for Laporan module
4. Save changes

### Problem: Permission changes not working
**Solution**:
1. Check database connection
2. Verify `role_permissions` table exists
3. Check if user role is exactly "pimpinan" (lowercase)
4. Clear browser cache

---

## 📞 SUPPORT

If you encounter issues:
1. Check this guide first
2. Review error messages carefully
3. Verify Admin has granted correct permissions
4. Check database `role_permissions` table
5. Contact system administrator

---

## ✅ CHECKLIST FOR ADMIN

Before granting Pimpinan access:
- [ ] Determine what features Pimpinan should access
- [ ] Login as Admin
- [ ] Navigate to Izin Akses
- [ ] Select Pimpinan role
- [ ] Check appropriate permissions
- [ ] Save changes
- [ ] Test with Pimpinan account
- [ ] Verify permissions work correctly

---

**Last Updated**: April 19, 2026  
**Version**: 1.0  
**Status**: Production Ready ✅
