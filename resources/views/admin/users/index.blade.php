@extends('layouts.app')
@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')
@section('breadcrumb')
<li class="breadcrumb-item active">Users</li>
@endsection
@section('content')
<div class="card card-outline card-primary shadow-sm">
<div class="card-header">
<h3 class="card-title"><i class="fas fa-users mr-2"></i>Daftar User <span class="badge badge-primary ml-1">{{ $users->total() }}</span></h3>
<div class="card-tools"><a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus mr-1"></i>Tambah User</a></div>
</div>
<div class="card-body">
<form method="GET" class="mb-3">
<div class="row">
<div class="col-md-5"><input type="text" name="search" class="form-control" placeholder="Nama atau email..." value="{{ request('search') }}"></div>
<div class="col-md-3"><select name="role" class="form-control"><option value="">Semua Role</option><option value="admin" {{ request('role')==='admin'?'selected':'' }}>Admin</option><option value="petugas" {{ request('role')==='petugas'?'selected':'' }}>Petugas</option><option value="pimpinan" {{ request('role')==='pimpinan'?'selected':'' }}>Pimpinan</option><option value="koperasi" {{ request('role')==='koperasi'?'selected':'' }}>Koperasi</option></select></div>
<div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button></div>
<div class="col-md-2"><a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100">Reset</a></div>
</div>
</form>
<div class="table-responsive">
<table class="table table-hover table-sm">
<thead class="thead-light"><tr><th>#</th><th>Nama</th><th>Email</th><th>Role</th><th>Status</th><th>Terdaftar</th><th>Aksi</th></tr></thead>
<tbody>
@forelse($users as $i => $u)
<tr>
<td>{{ $users->firstItem() + $i }}</td>
<td><strong>{{ $u->name }}</strong></td>
<td>{{ $u->email }}</td>
<td><span class="badge badge-{{ $u->role==='admin'?'danger':($u->role==='petugas'?'warning':($u->role==='pimpinan'?'info':'success')) }}">{{ ucfirst($u->role) }}</span></td>
<td><span class="badge badge-{{ $u->is_active?'success':'secondary' }}">{{ $u->is_active?'Aktif':'Nonaktif' }}</span></td>
<td><small>{{ $u->created_at->format('d/m/Y') }}</small></td>
<td>
<div class="btn-group btn-group-sm">
<a href="{{ route('admin.users.edit', $u) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
<form method="POST" action="{{ route('admin.users.toggleActive', $u) }}" style="display:inline">@csrf
<button type="submit" class="btn btn-{{ $u->is_active?'secondary':'success' }}" title="{{ $u->is_active?'Nonaktifkan':'Aktifkan' }}"><i class="fas fa-{{ $u->is_active?'ban':'check' }}"></i></button>
</form>
@if($u->id !== auth()->id())
<form method="POST" action="{{ route('admin.users.destroy', $u) }}" style="display:inline">@csrf @method('DELETE')
<button type="submit" class="btn btn-danger" onclick="return confirm('Hapus user ini?')"><i class="fas fa-trash"></i></button>
</form>
@endif
</div>
</td>
</tr>
@empty
<tr><td colspan="7" class="text-center py-4 text-muted">Belum ada user</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
<div class="card-footer">{{ $users->links('pagination::bootstrap-4') }}</div>
</div>
@endsection
