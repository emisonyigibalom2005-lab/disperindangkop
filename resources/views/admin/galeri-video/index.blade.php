@extends('layouts.app')
@section('title', 'Galeri Video')

@push('styles')
<style>
    .video-thumbnail {
        width: 200px;
        height: 112px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.12);
        cursor: pointer;
        transition: all 0.3s;
    }
    .video-thumbnail:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(0,0,0,0.25);
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
                                <i class="fas fa-video"></i>
                            </div>
                            <div>
                                <h3 class="page-header-title">🎥 Galeri Video</h3>
                                <p class="page-header-subtitle">Kelola dokumentasi video kegiatan dan program</p>
                            </div>
                        </div>
                        <div class="text-right d-none d-md-block">
                            <a href="{{ route('admin.galeri-video.create') }}" class="btn btn-light btn-modern">
                                <i class="fas fa-video"></i> Tambah Video
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success-modern alert-dismissible fade show">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger-modern alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    {{-- Table Galeri Video --}}
    <div class="content-card">
        <div class="content-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="content-card-title mb-0">
                    <i class="fas fa-list"></i> Daftar Video
                </h5>
                <div>
                    <span class="badge" style="background:linear-gradient(135deg,#ef4444,#dc2626);color:white;padding:10px 18px;border-radius:10px;font-size:14px;font-weight:700;">
                        <i class="fas fa-video mr-2"></i>Total: {{ $galeri->total() }} Video
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
                            <th width="25%" style="padding: 15px;">Preview</th>
                            <th width="30%" style="padding: 15px;">Judul</th>
                            <th width="14%" style="padding: 15px;">Kategori</th>
                            <th width="12%" style="padding: 15px;">Tanggal</th>
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
                                <div class="video-thumbnail">
                                    @php
                                        $videoId = '';
                                        if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $item->video_url, $matches)) {
                                            $videoId = $matches[1];
                                        } elseif (preg_match('/youtu\.be\/([^?]+)/', $item->video_url, $matches)) {
                                            $videoId = $matches[1];
                                        }
                                    @endphp
                                    @if($videoId)
                                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" 
                                                style="width:100%;height:100%;border:none;"
                                                allowfullscreen
                                                loading="lazy"></iframe>
                                    @else
                                        <div style="width:100%;height:100%;background:#000;display:flex;align-items:center;justify-content:center;color:white;">
                                            <i class="fas fa-video fa-2x"></i>
                                        </div>
                                    @endif
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
                                    <button type="button" 
                                            class="btn-action btn-detail"
                                            data-toggle="modal" 
                                            data-target="#viewModal{{ $item->id }}"
                                            title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.galeri-video.edit', $item) }}" 
                                       class="btn-action btn-edit"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.galeri-video.destroy', $item->id) }}" 
                                          method="POST" 
                                          style="display:inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?')">
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
                        
                        {{-- View Modal --}}
                        <div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content modal-modern">
                                    <div class="modal-header" style="background:linear-gradient(135deg,#1a3a6e,#2d5aa0);color:white;border-radius:16px 16px 0 0">
                                        <h5 class="modal-title font-weight-bold">
                                            <i class="fas fa-video mr-2"></i>{{ $item->judul }}
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="padding:30px">
                                        <div class="video-container" style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:12px;margin-bottom:20px;">
                                            @php
                                                $videoId = '';
                                                if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $item->video_url, $matches)) {
                                                    $videoId = $matches[1];
                                                } elseif (preg_match('/youtu\.be\/([^?]+)/', $item->video_url, $matches)) {
                                                    $videoId = $matches[1];
                                                }
                                            @endphp
                                            @if($videoId)
                                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" 
                                                        style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;"
                                                        allowfullscreen></iframe>
                                            @else
                                                <video controls style="width:100%;border-radius:12px;">
                                                    <source src="{{ $item->video_url }}" type="video/mp4">
                                                    Browser Anda tidak mendukung video.
                                                </video>
                                            @endif
                                        </div>
                                        
                                        @if($item->deskripsi)
                                        <div class="mb-3">
                                            <h6 class="font-weight-bold" style="color:#1a3a6e">
                                                <i class="fas fa-align-left mr-2"></i>Deskripsi:
                                            </h6>
                                            <p class="text-muted">{{ $item->deskripsi }}</p>
                                        </div>
                                        @endif
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <small class="text-muted">Kategori:</small><br>
                                                    <span class="badge badge-info-modern">
                                                        {{ ucfirst($item->kategori ?? 'kegiatan') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <small class="text-muted">Status:</small><br>
                                                    <span class="badge badge-success-modern">
                                                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <small class="text-muted">URL Video:</small><br>
                                            <a href="{{ $item->video_url }}" target="_blank" class="text-primary" style="font-size:13px;word-break:break-all;">
                                                {{ $item->video_url }}
                                            </a>
                                        </div>
                                        
                                        <hr>
                                        
                                        <div class="d-flex justify-content-between text-muted" style="font-size:13px">
                                            <span>
                                                <i class="far fa-calendar mr-1"></i>
                                                {{ $item->created_at->format('d F Y, H:i') }}
                                            </span>
                                            <span>
                                                <i class="far fa-user mr-1"></i>
                                                {{ $item->createdBy?->name ?? 'Admin' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="border-top:1px solid #eef;background:#f8f9ff">
                                        <a href="{{ route('admin.galeri-video.edit', $item) }}" class="btn btn-warning-modern">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-secondary btn-modern" data-dismiss="modal">
                                            <i class="fas fa-times"></i> Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-video"></i>
                <h5>Belum Ada Video</h5>
                <p>Mulai tambahkan video kegiatan dan dokumentasi program Anda</p>
                <a href="{{ route('admin.galeri-video.create') }}" class="btn btn-primary-modern">
                    <i class="fas fa-video"></i> Tambah Video Pertama
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
