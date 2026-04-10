@extends('layouts.app')

@section('title', 'Daftar Berita')
@section('page-title', 'Manajemen Berita & Artikel')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Daftar Berita</li>
@endsection

@push('styles')
<style>
    .stats-card {
        border-radius: 8px;
        transition: all 0.3s ease;
        border-left: 4px solid;
    }
    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .filter-card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }
    .berita-card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .berita-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    .thumbnail-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }
    .thumbnail-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .thumbnail-wrapper:hover img {
        transform: scale(1.1);
    }
    .thumbnail-placeholder {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
    }
    .berita-item {
        border-bottom: 1px solid #e9ecef;
        padding: 15px;
        transition: all 0.2s ease;
    }
    .berita-item:last-child {
        border-bottom: none;
    }
    .berita-item:hover {
        background-color: rgba(26, 58, 110, 0.03);
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
    .empty-state {
        padding: 80px 20px;
        text-align: center;
    }
    .empty-state i {
        font-size: 80px;
        opacity: 0.2;
        margin-bottom: 20px;
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
                        <h6 class="text-muted mb-1">Total Berita</h6>
                        <h3 class="mb-0 font-weight-bold">{{ $berita->total() }}</h3>
                    </div>
                    <div class="text-primary" style="font-size: 40px; opacity: 0.3;">
                        <i class="fas fa-newspaper"></i>
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
                        <h6 class="text-muted mb-1">Dipublikasi</h6>
                        <h3 class="mb-0 font-weight-bold">{{ $berita->where('status', 'publish')->count() }}</h3>
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
                        <h6 class="text-muted mb-1">Draft</h6>
                        <h3 class="mb-0 font-weight-bold">{{ $berita->where('status', 'draft')->count() }}</h3>
                    </div>
                    <div class="text-warning" style="font-size: 40px; opacity: 0.3;">
                        <i class="fas fa-file-alt"></i>
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
                        <h6 class="text-muted mb-1">Bulan Ini</h6>
                        <h3 class="mb-0 font-weight-bold">{{ $berita->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                    </div>
                    <div class="text-info" style="font-size: 40px; opacity: 0.3;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Alert -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif

<!-- Filter Section -->
<div class="card filter-card mb-4">
    <div class="card-header bg-white border-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 font-weight-bold">
                <i class="fas fa-filter mr-2 text-primary"></i>Filter & Pencarian
            </h5>
            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i>Tulis Berita
            </a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.berita.index') }}">
            <div class="row">
                <div class="col-md-5 mb-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input type="text" name="search" class="form-control" 
                            placeholder="Cari judul berita..."
                            value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="publish" @selected(request('status') == 'publish')>
                            📢 Publish
                        </option>
                        <option value="draft" @selected(request('status') == 'draft')>
                            📝 Draft
                        </option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-search mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Berita List -->
<div class="card berita-card">
    <div class="card-header bg-white border-0">
        <h5 class="mb-0 font-weight-bold">
            <i class="fas fa-list mr-2 text-primary"></i>Daftar Berita & Artikel
        </h5>
    </div>
    <div class="card-body p-0">
        @forelse ($berita as $item)
        <div class="berita-item">
            <div class="row align-items-center">
                <div class="col-md-1 text-center">
                    <span class="badge badge-secondary">
                        #{{ $berita->firstItem() + $loop->index }}
                    </span>
                </div>
                
                <div class="col-md-2">
                    @if ($item->thumbnail)
                        <div class="thumbnail-wrapper">
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="Thumbnail">
                        </div>
                    @else
                        <div class="thumbnail-placeholder">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                </div>
                
                <div class="col-md-4">
                    <h6 class="mb-1 font-weight-bold">{{ Str::limit($item->judul, 60) }}</h6>
                    <div class="d-flex align-items-center text-muted small">
                        <span class="badge badge-info mr-2">{{ ucfirst($item->kategori) }}</span>
                        <i class="fas fa-user mr-1"></i>
                        <span class="mr-3">{{ $item->createdBy?->name ?? '-' }}</span>
                        <i class="far fa-calendar mr-1"></i>
                        <span>{{ $item->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                
                <div class="col-md-2 text-center">
                    <span class="badge badge-{{ $item->status === 'publish' ? 'success' : 'secondary' }}">
                        <i class="fas fa-circle mr-1" style="font-size: 8px;"></i>
                        {{ ucfirst($item->status) }}
                    </span>
                </div>
                
                <div class="col-md-3 text-right">
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('admin.berita.show', $item) }}" 
                           class="btn btn-info btn-action" 
                           title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.berita.edit', $item) }}" 
                           class="btn btn-warning btn-action"
                           title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.berita.destroy', $item) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-action" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-newspaper d-block text-muted"></i>
            <h5 class="text-muted">Belum ada berita</h5>
            <p class="text-muted mb-3">Mulai tulis berita atau artikel pertama Anda</p>
            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Tulis Berita Baru
            </a>
        </div>
        @endforelse
    </div>
    
    @if($berita->hasPages())
    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Menampilkan {{ $berita->firstItem() }} - {{ $berita->lastItem() }} dari {{ $berita->total() }} berita
            </div>
            <div>
                {{ $berita->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection