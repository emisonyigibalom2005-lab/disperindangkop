<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RolePermission;
use Illuminate\Support\Facades\DB;

class IzinAksesController extends Controller
{
    public function index()
    {
        $roles = RolePermission::$roles;
        $modules = RolePermission::$modules;
        
        // Get all permissions grouped by role
        $permissions = RolePermission::all()->groupBy('role');
        
        return view('admin.izin-akses.index', compact('roles', 'modules', 'permissions'));
    }

    public function edit($role)
    {
        if (!array_key_exists($role, RolePermission::$roles)) {
            return redirect()->route('admin.izin-akses.index')
                ->with('error', 'Role tidak ditemukan');
        }

        $roleName = RolePermission::$roles[$role];
        $modules = RolePermission::$modules;
        
        // Get permissions for this role
        $permissions = RolePermission::getPermissionsForRole($role);
        
        return view('admin.izin-akses.edit', compact('role', 'roleName', 'modules', 'permissions'));
    }

    public function update(Request $request, $role)
    {
        if (!array_key_exists($role, RolePermission::$roles)) {
            return redirect()->route('admin.izin-akses.index')
                ->with('error', 'Role tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            $modules = RolePermission::$modules;
            
            foreach ($modules as $moduleKey => $moduleName) {
                $permissionData = [
                    'role' => $role,
                    'module' => $moduleKey,
                    'can_view' => $request->has("permissions.{$moduleKey}.can_view"),
                    'can_create' => $request->has("permissions.{$moduleKey}.can_create"),
                    'can_edit' => $request->has("permissions.{$moduleKey}.can_edit"),
                    'can_delete' => $request->has("permissions.{$moduleKey}.can_delete"),
                    'can_export' => $request->has("permissions.{$moduleKey}.can_export"),
                    'can_approve' => $request->has("permissions.{$moduleKey}.can_approve"),
                    'description' => $moduleName
                ];

                RolePermission::updateOrCreate(
                    ['role' => $role, 'module' => $moduleKey],
                    $permissionData
                );
            }

            DB::commit();

            return redirect()->route('admin.izin-akses.index')
                ->with('success', 'Izin akses berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reset($role)
    {
        if (!array_key_exists($role, RolePermission::$roles)) {
            return redirect()->route('admin.izin-akses.index')
                ->with('error', 'Role tidak ditemukan');
        }

        try {
            // Delete all permissions for this role
            RolePermission::where('role', $role)->delete();

            return redirect()->route('admin.izin-akses.index')
                ->with('success', 'Izin akses berhasil direset');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function setDefault($role)
    {
        if (!array_key_exists($role, RolePermission::$roles)) {
            return redirect()->route('admin.izin-akses.index')
                ->with('error', 'Role tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            // Set default permissions based on role
            $defaultPermissions = $this->getDefaultPermissions($role);

            foreach ($defaultPermissions as $module => $permissions) {
                RolePermission::updateOrCreate(
                    ['role' => $role, 'module' => $module],
                    array_merge($permissions, [
                        'description' => RolePermission::$modules[$module] ?? $module
                    ])
                );
            }

            DB::commit();

            return redirect()->route('admin.izin-akses.edit', $role)
                ->with('success', 'Izin akses default berhasil diterapkan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function getDefaultPermissions($role)
    {
        $defaults = [
            'admin' => [
                'dashboard' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => true, 'can_approve' => false],
                'koperasi' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => true, 'can_approve' => true],
                'anggota' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => true, 'can_approve' => true],
                'bantuan' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => true, 'can_approve' => true],
                'periode_bantuan' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => false, 'can_approve' => false],
                'pengajuan_bantuan' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => true, 'can_approve' => true],
                'berita' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => true, 'can_approve' => true],
                'pengumuman' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => true, 'can_approve' => true],
                'galeri' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => true, 'can_approve' => true],
                'jadwal' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => true, 'can_approve' => true],
                'pelatihan' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => true, 'can_approve' => true],
                'periode_pendaftaran' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => false, 'can_approve' => false],
                'laporan' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => true, 'can_approve' => true],
                'user' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => true, 'can_approve' => true],
                'izin_akses' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => false, 'can_approve' => false],
                'setting' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => true, 'can_approve' => true],
                'chat' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => false, 'can_approve' => false],
                'kontak' => ['can_view' => true, 'can_create' => false, 'can_edit' => true, 'can_delete' => true, 'can_export' => true, 'can_approve' => false],
                'struktur' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => false, 'can_approve' => false],
                'halaman_statis' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true, 'can_export' => false, 'can_approve' => false],
                'activity_log' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => true, 'can_export' => true, 'can_approve' => false],
            ],
            'petugas' => [
                'dashboard' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'koperasi' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => false, 'can_export' => true, 'can_approve' => false],
                'anggota' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => false, 'can_export' => true, 'can_approve' => false],
                'bantuan' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => false, 'can_export' => true, 'can_approve' => false],
                'periode_bantuan' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'pengajuan_bantuan' => ['can_view' => true, 'can_create' => false, 'can_edit' => true, 'can_delete' => false, 'can_export' => true, 'can_approve' => false],
                'berita' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'pengumuman' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'galeri' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'jadwal' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => false, 'can_export' => true, 'can_approve' => false],
                'pelatihan' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => false, 'can_export' => true, 'can_approve' => false],
                'periode_pendaftaran' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'laporan' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => true, 'can_approve' => false],
                'user' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'chat' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'kontak' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => true, 'can_approve' => false],
                'struktur' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'halaman_statis' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'activity_log' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
            ],
            'pimpinan' => [
                'dashboard' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => true, 'can_approve' => false],
                'koperasi' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => true, 'can_approve' => true],
                'anggota' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => true, 'can_approve' => true],
                'bantuan' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => true, 'can_approve' => true],
                'pengajuan_bantuan' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => true, 'can_approve' => true],
                'berita' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'pengumuman' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'galeri' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'jadwal' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => true, 'can_approve' => false],
                'pelatihan' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => true, 'can_approve' => false],
                'laporan' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => true, 'can_approve' => false],
                'chat' => ['can_view' => true, 'can_create' => true, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'activity_log' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => true, 'can_approve' => false],
            ],
            'anggota' => [
                'dashboard' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'berita' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'pengumuman' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'galeri' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'jadwal' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'pelatihan' => ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
                'chat' => ['can_view' => true, 'can_create' => true, 'can_edit' => false, 'can_delete' => false, 'can_export' => false, 'can_approve' => false],
            ],
        ];

        return $defaults[$role] ?? [];
    }
}
