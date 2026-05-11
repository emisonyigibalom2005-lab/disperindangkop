@extends('layouts.app')
@section('title', 'Detail Pengumuman')

@section('content')
<div class="container-fluid" style="max-width: 1400px;">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 16px; border: none; box-shadow: 0 8px 24px rgba(30, 58, 138, 0.3);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between text-white">
                        <div class="d-flex align-items-center">
                            <div style="width: 70px; height: 70px; background: rgba(255,255,255,0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-right: 24px;">
                                <i class="fas fa-bullhorn" style="font-size: 32px;"></i>
                            </div>
                            <div>
                                <h2 class="mb-1" style="font-weight: 800; font-size: 30px;">Detail Pengumuman</h2>
                                <p class="mb-0" style="opacity: 0.95; font-size: 15px;">Informasi lengkap pengumuman</p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('pimpinan.pengumuman.index') }}" class="btn btn-light" style="border-radius: 12px; font-weight: 600; padding: 12px 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card" style="border-radius: 16px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                <div class="card-body p-5">
                    {{-- Status Badge --}}
                    <div class="mb-4">
                        @if($pengumuman->is_aktif)
                        <span class="badge" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 8px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                            <i class="fas fa-check-circle mr-1"></i>AKTIF
                        </span>
                        @else
                        <span class="badge" style="background: linear-gradient(135deg, #6b7280, #4b5563); color: white; padding: 8px 18px; border-radius: 10px; font-size: 13px; font-weight: 600;">
                            <i class="fas fa-times-circle mr-1"></i>NONAKTIF
                        </span>
                        @endif
                    </div>

                    {{-- Judul --}}
                    <h2 class="mb-4" style="font-weight: 800; color: #1a202c; line-height: 1.3; font-size: 32px;">
                        {{ $pengumuman->judul }}
                    </h2>

                    {{-- Meta Info --}}
                    <div class="d-flex align-items-center flex-wrap mb-4 pb-4" style="gap: 24px; border-bottom: 3px solid #e5e7eb; font-size: 14px;">
                        <div class="d-flex align-items-center" style="background: #f9fafb; padding: 10px 16px; border-radius: 10px;">
                            <i class="fas fa-user mr-2" style="color: #1e3a8a; font-size: 16px;"></i>
                            <span style="color: #374151; font-weight: 600;">{{ $pengumuman->user->name ?? 'Admin' }}</span>
                        </div>
                        <div class="d-flex align-items-center" style="background: #f9fafb; padding: 10px 16px; border-radius: 10px;">
                            <i class="fas fa-calendar mr-2" style="color: #1e3a8a; font-size: 16px;"></i>
                            <span style="color: #374151; font-weight: 600;">{{ $pengumuman->created_at->format('d F Y, H:i') }} WIT</span>
                        </div>
                        @if($pengumuman->updated_at != $pengumuman->created_at)
                        <div class="d-flex align-items-center" style="background: #f9fafb; padding: 10px 16px; border-radius: 10px;">
                            <i class="fas fa-edit mr-2" style="color: #1e3a8a; font-size: 16px;"></i>
                            <span style="color: #374151; font-weight: 600;">Diupdate: {{ $pengumuman->updated_at->format('d M Y') }}</span>
                        </div>
                        @endif
                    </div>

                    {{-- Isi Pengumuman --}}
                    <div class="pengumuman-content" style="font-size: 16px; line-height: 1.9; color: #374151;">
                        {!! nl2br(e($pengumuman->isi)) !!}
                    </div>

                    {{-- Lampiran jika ada --}}
                    @if($pengumuman->lampiran)
                    <div class="mt-5 p-4" style="background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border-radius: 12px; border-left: 5px solid #1e3a8a;">
                        <h5 class="mb-3" style="font-weight: 700; color: #1a202c;">
                            <i class="fas fa-paperclip mr-2" style="color: #1e3a8a;"></i>Lampiran
                        </h5>
                        <a href="{{ asset('storage/'.$pengumuman->lampiran) }}" 
                           target="_blank" 
                           class="btn" 
                           style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; border: none; border-radius: 10px; padding: 12px 24px; font-weight: 600; box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);">
                            <i class="fas fa-download mr-2"></i>Download Lampiran
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Info Card --}}
            <div class="card mb-4" style="border-radius: 16px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; border-radius: 16px 16px 0 0; padding: 18px 20px;">
                    <h5 class="mb-0" style="font-weight: 700; font-size: 17px;">
                        <i class="fas fa-info-circle mr-2"></i>Informasi
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <div style="background: #f8f9fa; padding: 16px 18px; border-radius: 10px; border-left: 4px solid #1e3a8a;">
                            <label class="text-muted mb-2" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Dibuat Oleh</label>
                            <div class="font-weight-bold" style="font-size: 15px; color: #1a202c;">
                                <i class="fas fa-user mr-2" style="color: #1e3a8a;"></i>{{ $pengumuman->user->name ?? 'Admin' }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div style="background: #f8f9fa; padding: 16px 18px; border-radius: 10px; border-left: 4px solid #1e3a8a;">
                            <label class="text-muted mb-2" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Dibuat</label>
                            <div class="font-weight-bold" style="font-size: 15px; color: #1a202c;">
                                <i class="fas fa-calendar mr-2" style="color: #1e3a8a;"></i>{{ $pengumuman->created_at->format('d F Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div style="background: #f8f9fa; padding: 16px 18px; border-radius: 10px; border-left: 4px solid #1e3a8a;">
                            <label class="text-muted mb-2" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Status</label>
                            <div class="font-weight-bold" style="font-size: 15px; color: #1a202c;">
                                @if($pengumuman->is_aktif)
                                <span class="badge" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 6px 14px; border-radius: 8px; font-size: 12px;">
                                    <i class="fas fa-check-circle mr-1"></i>Aktif
                                </span>
                                @else
                                <span class="badge" style="background: linear-gradient(135deg, #6b7280, #4b5563); color: white; padding: 6px 14px; border-radius: 8px; font-size: 12px;">
                                    <i class="fas fa-times-circle mr-1"></i>Nonaktif
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Card --}}
            <div class="card" style="border-radius: 16px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                <div class="card-body p-4">
                    <button onclick="window.print()" class="btn btn-block mb-3" style="background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; border-radius: 12px; font-weight: 600; padding: 14px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                        <i class="fas fa-print mr-2"></i>Print Pengumuman
                    </button>
                    <a href="{{ route('pimpinan.pengumuman.index') }}" class="btn btn-block" style="background: #f3f4f6; color: #374151; border: none; border-radius: 12px; font-weight: 600; padding: 14px;">
                        <i class="fas fa-list mr-2"></i>Lihat Semua Pengumuman
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print, .btn, .card-header, .sidebar, .col-lg-4 {
        display: none !important;
    }
    
    .col-lg-8 {
        width: 100% !important;
        max-width: 100% !important;
    }
    
    .card {
        box-shadow: none !important;
        border: none !important;
    }
    
    body {
        background: white !important;
    }
}

.pengumuman-content {
    word-wrap: break-word;
}

.pengumuman-content p {
    margin-bottom: 1.2rem;
}
</style>
@endsection
