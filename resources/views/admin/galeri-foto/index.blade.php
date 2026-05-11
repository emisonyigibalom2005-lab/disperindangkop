@extends('layouts.app')
@section('title', 'Galeri Foto')

@push('styles')
<style>
    .foto-thumbnail {
        width: 160px;
        height: 120px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.12);
        cursor: pointer;
        transition: all 0.3s;
    }
    .foto-thumbnail:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(0,0,0,0.25);
    }
    .foto-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .table-modern tbody tr {
        transition: all 0.2s;
    }
    .table-modern tbody tr:hover {
        background: #f8f9ff;
        transform: translateX(2px);
    }
    
    .btn-action-group {
        display: flex;
        gap: 5px;
        justify-content: center;
    }
    
    .btn-action {
        padding: 6px 12px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .btn-action i {
        font-size: 13px;
    }
    
    .btn-detail {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        color: white;
    }
    .btn-detail:hover {
        background: linear-gradient(135deg, #0891b2, #0e7490);
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }
    .btn-edit:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
    .btn-delete:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card page-header-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between text-white">
                        <div class="d-flex align-items-center">
                            <div class="page-header-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                            <div>
                                <h3 class="page-header-title">📷 Galeri Foto</h3>
                                <p class="page-header-subtitle">Kelola foto kegiatan dan dokumentasi program</p>
                            </div>
                        </div>
                        <div class="text-right d-none d-md-block">
                            <a href="{{ route('admin.galeri-foto.create') }}" class="btn btn-light btn-modern">
                                <i class="fas fa-plus"></i> Tambah Foto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="alert alert-success-modern alert-dismissible fade show">
        <i class="fas fa-check-circle"></i>
        <div>
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    {{-- Error Alert --}}
    @if(session('error'))
    <div class="alert alert-danger-modern alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            <strong>Error!</strong> {{ session('error') }}
        </div>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    {{-- Table Galeri Foto --}}
    <div class="content-card">
        <div class="content-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="content-card-title mb-0">
                    <i class="fas fa-list"></i> Daftar Foto
                </h5>
                <div>
                    <span class="badge" style="background:linear-gradient(135deg,#667eea,#764ba2);color:white;padding:10px 18px;border-radius:10px;font-size:14px;font-weight:700;">
                        <i class="fas fa-camera mr-2"></i>Total: {{ $galeri->total() }} Foto
                    </span>
                </div>
            </div>
        </div>
        
        <div class="content-card-body p-0">
            @if($galeri->count() > 0)
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th width="6%" style="padding: 15px;">No</th>
                            <th width="20%" style="padding: 15px;">Preview</th>
                            <th width="30%" style="padding: 15px;">Judul</th>
                            <th width="14%" style="padding: 15px;">Kategori</th>
                            <th width="17%" style="padding: 15px;">Tanggal</th>
                            <th width="13%" class="text-center" style="padding: 15px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($galeri as $index => $item)
                        <tr>
                            <td style="padding: 15px; vertical-align: middle;">
                                <strong style="color: #1a3a6e;">{{ $galeri->firstItem() + $index }}</strong>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <div class="foto-thumbnail">
                                    <img src="{{ asset('storage/' . $item->foto) }}" 
                                         alt="{{ $item->judul }}"
                                         loading="lazy">
                                </div>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <div style="font-weight:600;color:#1a3a6e;font-size:14px;margin-bottom:4px;">
                                    {{ Str::limit($item->judul, 50) }}
                                </div>
                                @if($item->deskripsi)
                                <small class="text-muted" style="font-size:12px;">
                                    {{ Str::limit($item->deskripsi, 60) }}
                                </small>
                                @endif
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <span class="badge" style="background:#e0e7ff;color:#4338ca;padding:6px 12px;border-radius:6px;font-size:11px;font-weight:600;">
                                    <i class="fas fa-tag mr-1"></i>{{ ucfirst($item->kategori ?? 'kegiatan') }}
                                </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <small class="text-muted" style="font-size: 13px;">
                                    <i class="far fa-calendar mr-1"></i>
                                    {{ $item->created_at->format('d M Y') }}
                                    <br>
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $item->created_at->format('H:i') }} WIB
                                </small>
                            </td>
                            <td class="text-center" style="padding: 15px; vertical-align: middle;">
                                <div class="btn-action-group">
                                    <a href="{{ asset('storage/' . $item->foto) }}" 
                                       target="_blank"
                                       class="btn-action btn-detail"
                                       title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.galeri-foto.edit', $item->id) }}" 
                                       class="btn-action btn-edit"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.galeri-foto.destroy', $item->id) }}" 
                                          method="POST" 
                                          style="display:inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn-action btn-delete"
                                                title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-camera"></i>
                <h5>Belum Ada Foto</h5>
                <p>Mulai tambahkan foto kegiatan dan dokumentasi program Anda</p>
                <a href="{{ route('admin.galeri-foto.create') }}" class="btn btn-primary-modern">
                    <i class="fas fa-camera"></i> Tambah Foto Pertama
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Pagination --}}
    @if($galeri->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $galeri->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
