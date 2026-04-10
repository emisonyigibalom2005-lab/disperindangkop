@extends('layouts.app')

@section('title', 'Daftar Bantuan')
@section('page-title', 'Daftar Program Bantuan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Daftar Bantuan</li>
@endsection

@push('styles')
<style>
    .filter-card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .filter-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    .table-card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }
    .table-hover tbody tr {
        transition: all 0.2s ease;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(26, 58, 110, 0.05);
        transform: scale(1.01);
    }
    .badge {
        padding: 5px 12px;
        font-weight: 600;
        border-radius: 6px;
    }
    .btn-action {
        padding: 4px 8px;
        font-size: 12px;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    .stats-card {
        border-radius: 8px;
        transition: all 0.3s ease;
        border-left: 4px solid;
    }
    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .empty-state {
        padding: 60px 20px;
    }
    .empty-state i {
        font-size: 64px;
        opacity: 0.3;
    }
</style>
@endpush

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card shadow-sm" style="border-left-color: #007bff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Bantuan</h6>
                        <h3 class="mb-0 font-weight-bold">{{ $bantuan->total() }}</h3>
                    </div>
                    <div class="text-primary" style="font-size: 40px; opacity: 0.3;">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card shadow-sm" style="border-left-color: #28a745;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Bantuan Aktif</h6>
                        <h3 class="mb-0 font-weight-bold">{{ $bantuan->where('status', 'aktif')->count() }}</h3>
                    </div>
                    <div class="text-success" style="font-size: 40px; opacity: 0.3;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card shadow-sm" style="border-left-color: #ffc107;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Tahun Ini</h6>
                        <h3 class="mb-0 font-weight-bold">{{ $bantuan->where('tahun', date('Y'))->count() }}</h3>
                    </div>
                    <div class="text-warning" style="font-size: 40px; opacity: 0.3;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card shadow-sm" style="border-left-color: #17a2b8;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Penerima</h6>
                        <h3 class="mb-0 font-weight-bold">{{ $bantuan->sum(fn($b) => $b->penerima->count()) }}</h3>
                    </div>
                    <div class="text-info" style="font-size: 40px; opacity: 0.3;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card filter-card mb-4">
    <div class="card-header bg-white border-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 font-weight-bold">
                <i class="fas fa-filter mr-2 text-primary"></i>Filter & Pencarian
            </h5>
            <a href="{{ route('admin.bantuan.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i>Tambah Bantuan
            </a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.bantuan.index') }}">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input type="text" name="search" class="form-control" 
                            placeholder="Cari nama / kode bantuan..."
                            value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2 mb-2">
                    <input type="number" name="tahun" class="form-control"
                        placeholder="Tahun"
                        value="{{ request('tahun') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="aktif" @selected(request('status') == 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(request('status') == 'nonaktif')>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-search mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.bantuan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Table Section -->
<div class="card table-card">
    <div class="card-header bg-white border-0">
        <h5 class="mb-0 font-weight-bold">
            <i class="fas fa-list mr-2 text-primary"></i>Daftar Program Bantuan
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="12%">Kode</th>
                        <th width="25%">Nama Bantuan</th>
                        <th width="12%">Jenis</th>
                        <th width="8%" class="text-center">Tahun</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="13%">Dibuat Oleh</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bantuan as $item)
                    <tr>
                        <td class="text-center font-weight-bold text-muted">
                            {{ $bantuan->firstItem() + $loop->index }}
                        </td>
                        <td>
                            <span class="badge badge-secondary">{{ $item->kode_bantuan }}</span>
                        </td>
                        <td>
                            <strong>{{ $item->nama_bantuan }}</strong>
                            @if($item->periode)
                            <br><small class="text-muted">
                                <i class="far fa-calendar mr-1"></i>{{ $item->periode }}
                            </small>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-info">
                                {{ ucfirst(str_replace('_', ' ', $item->jenis_bantuan)) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <strong>{{ $item->tahun }}</strong>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-{{ $item->status === 'aktif' ? 'success' : 'secondary' }}">
                                <i class="fas fa-circle mr-1" style="font-size: 8px;"></i>
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <small>
                                <i class="fas fa-user mr-1"></i>
                                {{ $item->createdBy?->name ?? '-' }}
                            </small>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.bantuan.show', $item) }}" 
                                   class="btn btn-info btn-action" 
                                   title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.bantuan.edit', $item) }}" 
                                   class="btn btn-warning btn-action"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" 
                                      action="{{ route('admin.bantuan.destroy', $item) }}" 
                                      style="display:inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus bantuan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-action" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state text-center text-muted">
                                <i class="fas fa-inbox d-block mb-3"></i>
                                <h5>Tidak ada data bantuan</h5>
                                <p class="mb-0">Silakan tambah program bantuan baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($bantuan->hasPages())
    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Menampilkan {{ $bantuan->firstItem() }} - {{ $bantuan->lastItem() }} dari {{ $bantuan->total() }} data
            </div>
            <div>
                {{ $bantuan->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection