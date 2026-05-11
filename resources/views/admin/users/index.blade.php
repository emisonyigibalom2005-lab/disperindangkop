@extends('layouts.app')
@section('title', 'Manajemen User')

@push('styles')
<style>
.page-header-modern {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 50%, #4a7bc8 100%);
    padding: 40px 0;
    margin-bottom: 30px;
    border-radius: 0 0 20px 20px;
    box-shadow: 0 4px 20px rgba(26, 58, 110, 0.15);
    position: relative;
    overflow: hidden;
}
.page-header-modern::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
}
.page-header-modern .container-fluid {
    position: relative;
    z-index: 1;
}
.page-header-icon-modern {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    backdrop-filter: blur(10px);
}
.page-header-icon-modern i {
    font-size: 32px;
    color: white;
}
.filter-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}
.content-card-modern {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    overflow: hidden;
}
.content-card-header-modern {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 20px 25px;
    border-bottom: 2px solid #dee2e6;
}
.content-card-header-modern h5 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #1a3a6e;
}
.table-modern {
    margin: 0;
}
.table-modern thead th {
    background: #f8f9fa;
    color: #1a3a6e;
    font-weight: 700;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #dee2e6;
    padding: 15px;
}
.table-modern tbody td {
    padding: 15px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f5;
}
.table-modern tbody tr:hover {
    background: #f8f9fa;
}
.badge-role {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.badge-role-admin {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}
.badge-role-petugas {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}
.badge-role-pimpinan {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}
.badge-role-koperasi {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}
.badge-role-anggota {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    color: white;
}
.status-badge-modern {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.status-active-modern {
    background: #d1fae5;
    color: #065f46;
}
.status-inactive-modern {
    background: #fee2e2;
    color: #991b1b;
}
.btn-action-modern {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    border: none;
    transition: all 0.3s ease;
    margin: 0 2px;
}
.btn-action-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.btn-detail-modern {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    color: white;
}
.btn-edit-modern {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}
.btn-delete-modern {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}
.btn-toggle-modern {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
}
.btn-toggle-active-modern {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}
.empty-state-modern {
    text-align: center;
    padding: 60px 20px;
}
.empty-state-modern i {
    font-size: 64px;
    color: #d1d5db;
    margin-bottom: 20px;
}
.empty-state-modern h5 {
    color: #6b7280;
    font-weight: 700;
    margin-bottom: 10px;
}
.empty-state-modern p {
    color: #9ca3af;
    margin-bottom: 20px;
}
.alert-modern {
    border-radius: 12px;
    border: none;
    padding: 15px 20px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.alert-success-modern {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    border-left: 4px solid #10b981;
}
.alert-error-modern {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
    border-left: 4px solid #ef4444;
}
.form-control-modern {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    padding: 10px 15px;
    transition: all 0.3s ease;
}
.form-control-modern:focus {
    border-color: #1a3a6e;
    box-shadow: 0 0 0 3px rgba(26, 58, 110, 0.1);
}
.btn-primary-modern {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 100%);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-primary-modern:hover {
    background: linear-gradient(135deg, #2d5aa0 0%, #4a7bc8 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(26, 58, 110, 0.3);
    color: white;
}
.btn-secondary-modern {
    background: #6b7280;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-secondary-modern:hover {
    background: #4b5563;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(107, 114, 128, 0.3);
    color: white;
}
.btn-add-modern {
    background: white;
    color: #1a3a6e;
    border: none;
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 700;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.btn-add-modern:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    color: #1a3a6e;
}
</style>
@endpush

@section('content')
<div class="page-header-modern">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between text-white">
            <div class="d-flex align-items-center">
                <div class="page-header-icon-modern">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div>
                    <h1 class="mb-2" style="font-size: 2rem; font-weight: 700;">Manajemen Pengguna</h1>
                    <p class="mb-0" style="font-size: 1rem; opacity: 0.9;">Kelola akun pengguna dan hak akses sistem</p>
                </div>
            </div>
            <div class="text-right d-none d-md-block">
                <a href="{{ route('admin.users.create') }}" class="btn btn-add-modern">
                    <i class="fas fa-user-plus mr-2"></i>Tambah User
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="alert-modern alert-success-modern">
        <i class="fas fa-check-circle" style="font-size: 20px;"></i>
        <span style="font-weight: 600;">{{ session('success') }}</span>
        <button type="button" class="close" data-dismiss="alert" style="margin-left: auto;">
            <span>&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert-modern alert-error-modern">
        <i class="fas fa-exclamation-circle" style="font-size: 20px;"></i>
        <span style="font-weight: 600;">{{ session('error') }}</span>
        <button type="button" class="close" data-dismiss="alert" style="margin-left: auto;">
            <span>&times;</span>
        </button>
    </div>
    @endif

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div class="row align-items-end">
                <div class="col-md-5 mb-3">
                    <label style="font-weight: 600; color: #374151; font-size: 13px; margin-bottom: 8px;">
                        <i class="fas fa-search mr-1"></i>Cari User
                    </label>
                    <input type="text" name="search" class="form-control form-control-modern" 
                           placeholder="Cari nama atau email..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label style="font-weight: 600; color: #374151; font-size: 13px; margin-bottom: 8px;">
                        <i class="fas fa-user-tag mr-1"></i>Role
                    </label>
                    <select name="role" class="form-control form-control-modern">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role')==='admin'?'selected':'' }}>Admin</option>
                        <option value="petugas" {{ request('role')==='petugas'?'selected':'' }}>Petugas</option>
                        <option value="pimpinan" {{ request('role')==='pimpinan'?'selected':'' }}>Pimpinan</option>
                        <option value="anggota" {{ request('role')==='anggota'?'selected':'' }}>Anggota</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <button type="submit" class="btn btn-primary-modern btn-block">
                        <i class="fas fa-filter mr-1"></i>Filter
                    </button>
                </div>
                <div class="col-md-2 mb-3">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary-modern btn-block">
                        <i class="fas fa-redo mr-1"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="content-card-modern">
        <div class="content-card-header-modern">
            <h5>
                <i class="fas fa-list mr-2"></i>Daftar User
                <span class="badge badge-role-admin ml-2" style="font-size: 12px;">{{ $users->total() }}</span>
            </h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="22%">Nama</th>
                        <th width="20%">Email</th>
                        <th width="13%">Role</th>
                        <th width="10%">Status</th>
                        <th width="12%">Terdaftar</th>
                        <th width="18%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $u)
                    <tr>
                        <td><strong style="color: #6b7280;">{{ $users->firstItem() + $i }}</strong></td>
                        <td>
                            <div style="font-weight: 700; color: #1a3a6e; margin-bottom: 2px;">{{ $u->name }}</div>
                            @if($u->phone)
                            <small class="text-muted">
                                <i class="fas fa-phone mr-1"></i>{{ $u->phone }}
                            </small>
                            @endif
                        </td>
                        <td>
                            <small style="color: #6b7280;">
                                <i class="fas fa-envelope mr-1"></i>{{ $u->email }}
                            </small>
                        </td>
                        <td>
                            @if($u->role === 'admin')
                                <span class="badge-role badge-role-admin">
                                    <i class="fas fa-user-shield"></i>Admin
                                </span>
                            @elseif($u->role === 'petugas')
                                <span class="badge-role badge-role-petugas">
                                    <i class="fas fa-user-tie"></i>Petugas
                                </span>
                            @elseif($u->role === 'pimpinan')
                                <span class="badge-role badge-role-pimpinan">
                                    <i class="fas fa-user-crown"></i>Pimpinan
                                </span>
                            @else
                                <span class="badge-role badge-role-anggota">
                                    <i class="fas fa-user"></i>{{ ucfirst($u->role) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($u->is_active)
                                <span class="status-badge-modern status-active-modern">
                                    <i class="fas fa-check-circle"></i>Aktif
                                </span>
                            @else
                                <span class="status-badge-modern status-inactive-modern">
                                    <i class="fas fa-times-circle"></i>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td>
                            <small style="color: #6b7280;">
                                <i class="far fa-calendar mr-1"></i>{{ $u->created_at->format('d M Y') }}
                            </small>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('admin.users.edit', $u) }}" 
                                   class="btn-action-modern btn-edit-modern" 
                                   title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form method="POST" 
                                      action="{{ route('admin.users.toggleActive', $u) }}" 
                                      style="display:inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn-action-modern {{ $u->is_active ? 'btn-toggle-modern' : 'btn-toggle-active-modern' }}" 
                                            title="{{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas fa-{{ $u->is_active ? 'ban' : 'check' }}"></i>
                                    </button>
                                </form>
                                
                                @if($u->id !== auth()->id())
                                <button type="button" 
                                        class="btn-action-modern btn-delete-modern" 
                                        onclick="deleteUser({{ $u->id }})"
                                        title="Hapus User">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state-modern">
                                <i class="fas fa-users-slash"></i>
                                <h5>Belum Ada User</h5>
                                <p>Mulai tambahkan user untuk mengelola sistem</p>
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary-modern">
                                    <i class="fas fa-user-plus mr-2"></i>Tambah User Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div style="padding: 20px 25px; background: #f8f9fa; border-top: 1px solid #dee2e6;">
            <div class="d-flex justify-content-between align-items-center">
                <small style="color: #6b7280; font-weight: 600;">
                    Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user
                </small>
                <div>
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Delete Form (Hidden) --}}
    <form id="deleteForm" method="POST" style="display:none">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function deleteUser(id) {
    Swal.fire({
        title: 'Hapus User?',
        text: "User akan dihapus permanen dari sistem!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
        customClass: {
            confirmButton: 'btn btn-danger px-4',
            cancelButton: 'btn btn-secondary px-4'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = '/admin/users/' + id;
            form.submit();
        }
    });
}

// Auto hide alerts
setTimeout(function() {
    $('.alert-modern').fadeOut('slow');
}, 5000);
</script>
@endpush
