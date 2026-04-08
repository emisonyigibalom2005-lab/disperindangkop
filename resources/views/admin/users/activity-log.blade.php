@extends('layouts.app')
@section('title', 'Activity Log')
@section('page-title', 'Log Aktivitas Sistem')
@section('breadcrumb')
<li class="breadcrumb-item active">Activity Log</li>
@endsection
@section('content')
<div class="card card-outline card-dark shadow-sm mb-3">
<div class="card-header"><h3 class="card-title"><i class="fas fa-filter mr-2"></i>Filter</h3></div>
<div class="card-body">
<form method="GET"><div class="row">
<div class="col-md-3"><select name="user_id" class="form-control"><option value="">Semua User</option>@foreach($users as $u)<option value="{{ $u->id }}" {{ request('user_id')==$u->id?'selected':'' }}>{{ $u->name }}</option>@endforeach</select></div>
<div class="col-md-3"><select name="module" class="form-control"><option value="">Semua Module</option>@foreach($modules as $m)<option value="{{ $m }}" {{ request('module')===$m?'selected':'' }}>{{ $m }}</option>@endforeach</select></div>
<div class="col-md-3"><input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}"></div>
<div class="col-md-1"><button type="submit" class="btn btn-dark w-100"><i class="fas fa-search"></i></button></div>
<div class="col-md-2"><a href="{{ route('admin.users.activityLog') }}" class="btn btn-secondary w-100">Reset</a></div>
</div></form>
</div>
</div>
<div class="card card-outline card-dark shadow-sm">
<div class="card-header"><h3 class="card-title"><i class="fas fa-history mr-2"></i>Log Aktivitas <span class="badge badge-dark ml-1">{{ $logs->total() }}</span></h3></div>
<div class="card-body p-0">
<table class="table table-hover table-sm mb-0">
<thead class="thead-dark"><tr><th>#</th><th>Waktu</th><th>User</th><th>Aksi</th><th>Module</th><th>Keterangan</th><th>IP</th></tr></thead>
<tbody>
@forelse($logs as $i => $l)
<tr>
<td>{{ $logs->firstItem() + $i }}</td>
<td><small>{{ $l->created_at->format('d/m/Y H:i') }}</small></td>
<td><small class="font-weight-bold">{{ $l->user->name ?? '-' }}</small><br><small class="text-muted">{{ $l->user->role ?? '' }}</small></td>
<td><span class="badge badge-{{ $l->action==='create'?'success':($l->action==='update'?'warning':($l->action==='delete'?'danger':'info')) }}">{{ strtoupper($l->action) }}</span></td>
<td><span class="badge badge-secondary">{{ $l->module }}</span></td>
<td><small>{{ $l->description }}</small></td>
<td><small class="text-muted">{{ $l->ip_address }}</small></td>
</tr>
@empty
<tr><td colspan="7" class="text-center py-4 text-muted">Belum ada log aktivitas</td></tr>
@endforelse
</tbody>
</table>
</div>
<div class="card-footer">{{ $logs->links('pagination::bootstrap-4') }}</div>
</div>
@endsection
