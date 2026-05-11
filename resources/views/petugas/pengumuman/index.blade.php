@extends('layouts.app')
@section('title', 'Pengumuman')

@section('content')
<div class="container-fluid" style="max-width: 1500px;">
    {{-- Header Section --}}
    <div class="row mb-4 no-print">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 16px; border: none; box-shadow: 0 8px 24px rgba(30, 58, 138, 0.3);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between text-white">
                        <div class="d-flex align-items-center">
                            <div style="width: 70px; height: 70px; background: rgba(255,255,255,0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-right: 24px;">
                                <i class="fas fa-bullhorn" style="font-size: 32px;"></i>
                            </div>
                            <div>
                                <h2 class="mb-1" style="font-weight: 800; font-size: 32px;">📢 Pengumuman</h2>
                                <p class="mb-0" style="opacity: 0.95; font-size: 15px;">Informasi dan pengumuman penting</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @canCreate('pengumuman')
                            <a href="{{ route('petugas.pengumuman.create') }}" class="btn btn-light mb-2" style="border-radius: 12px; font-weight: 600; padding: 12px 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <i class="fas fa-plus mr-2"></i>Buat Pengumuman
                            </a>
                            @endcanCreate
                            <div>
                                <h2 class="mb-0 font-weight-bold">{{ $totalPengumuman }}</h2>
                                <small style="opacity: 0.9">Total Pengumuman</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Main Content - Detail Pengumuman --}}
        <div class="col-lg-8">
            <div id="pengumuman-detail">
                @if(isset($selectedPengumuman))
                {{-- Detail Pengumuman --}}
                <div class="card" style="border-radius: 16px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="card-body p-5">
                        {{-- Print Header (Hidden on screen, visible on print) --}}
                        <div class="print-header">
                            <img src="{{ asset('images/logo-tolikara.png') }}" alt="Logo" style="width: 80px; height: auto;">
                            <h2>PEMERINTAH KABUPATEN TOLIKARA</h2>
                            <h3>DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI</h3>
                            <p>Jl. Gatot Subroto, Karubaga, Kabupaten Tolikara, Papua Pegunungan</p>
                            <p>Email: disperindagkop@tolikarakab.go.id | Telp: (0969) 31XXX</p>
                        </div>

                        {{-- Print Title (Hidden on screen, visible on print) --}}
                        <div class="print-title">
                            <h1>PENGUMUMAN</h1>
                        </div>

                        {{-- Status Badge --}}
                        <div class="mb-4 no-print">
                            @if($selectedPengumuman->is_aktif)
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
                            {{ $selectedPengumuman->judul }}
                        </h2>

                        {{-- Print Meta Info - Tanggal di kanan (Hidden on screen, visible on print) --}}
                        <div class="print-date-right">
                            <p>Karubaga, {{ $selectedPengumuman->created_at->format('d F Y') }}</p>
                        </div>

                        {{-- Meta Info --}}
                        <div class="d-flex align-items-center flex-wrap mb-4 pb-4 no-print" style="gap: 24px; border-bottom: 3px solid #e5e7eb; font-size: 14px;">
                            <div class="d-flex align-items-center" style="background: #f9fafb; padding: 10px 16px; border-radius: 10px;">
                                <i class="fas fa-user mr-2" style="color: #1e3a8a; font-size: 16px;"></i>
                                <span style="color: #374151; font-weight: 600;">{{ $selectedPengumuman->user->name ?? 'Admin' }}</span>
                            </div>
                            <div class="d-flex align-items-center" style="background: #f9fafb; padding: 10px 16px; border-radius: 10px;">
                                <i class="fas fa-calendar mr-2" style="color: #1e3a8a; font-size: 16px;"></i>
                                <span style="color: #374151; font-weight: 600;">{{ $selectedPengumuman->created_at->format('d F Y, H:i') }} WIT</span>
                            </div>
                            @if($selectedPengumuman->updated_at != $selectedPengumuman->created_at)
                            <div class="d-flex align-items-center" style="background: #f9fafb; padding: 10px 16px; border-radius: 10px;">
                                <i class="fas fa-edit mr-2" style="color: #1e3a8a; font-size: 16px;"></i>
                                <span style="color: #374151; font-weight: 600;">Diupdate: {{ $selectedPengumuman->updated_at->format('d M Y') }}</span>
                            </div>
                            @endif
                        </div>

                        {{-- Isi Pengumuman --}}
                        <div class="pengumuman-content" style="font-size: 16px; line-height: 1.9; color: #374151;">
                            {!! nl2br(e($selectedPengumuman->isi)) !!}
                        </div>

                        {{-- Print Signature (Hidden on screen, visible on print) --}}
                        <div class="print-signature">
                            <div style="clear: both;"></div>
                            <div class="print-signature-box">
                                <p>Karubaga, {{ $selectedPengumuman->created_at->format('d F Y') }}</p>
                                <p style="font-weight: 600;">Pembuat Pengumuman,</p>
                                <p class="print-signature-name">{{ $selectedPengumuman->user->name ?? 'Admin' }}</p>
                            </div>
                            <div style="clear: both;"></div>
                        </div>

                        {{-- Lampiran jika ada --}}
                        @if($selectedPengumuman->lampiran)
                        <div class="mt-5 p-4 no-print" style="background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border-radius: 12px; border-left: 5px solid #1e3a8a;">
                            <h5 class="mb-3" style="font-weight: 700; color: #1a202c;">
                                <i class="fas fa-paperclip mr-2" style="color: #1e3a8a;"></i>Lampiran
                            </h5>
                            <a href="{{ asset('storage/'.$selectedPengumuman->lampiran) }}" 
                               target="_blank" 
                               class="btn" 
                               style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; border: none; border-radius: 10px; padding: 12px 24px; font-weight: 600; box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);">
                                <i class="fas fa-download mr-2"></i>Download Lampiran
                            </a>
                        </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="mt-4 no-print">
                            <div class="btn-group" role="group">
                                <button onclick="printPengumuman()" class="btn" style="background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; border-radius: 12px 0 0 12px; font-weight: 600; padding: 14px 24px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                                    <i class="fas fa-print mr-2"></i>Print
                                </button>
                                @canEdit('pengumuman')
                                <a href="{{ route('petugas.pengumuman.edit', $selectedPengumuman->id) }}" class="btn" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none; font-weight: 600; padding: 14px 24px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);">
                                    <i class="fas fa-edit mr-2"></i>Edit
                                </a>
                                @endcanEdit
                                @canDelete('pengumuman')
                                <button onclick="confirmDelete({{ $selectedPengumuman->id }})" class="btn" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border: none; border-radius: 0 12px 12px 0; font-weight: 600; padding: 14px 24px; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);">
                                    <i class="fas fa-trash mr-2"></i>Hapus
                                </button>
                                @endcanDelete
                            </div>
                        </div>
                    </div>
                </div>
                @else
                {{-- Empty State --}}
                <div class="card" style="border-radius: 16px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="card-body text-center py-5">
                        <div style="width: 150px; height: 150px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                            <i class="fas fa-hand-pointer" style="font-size: 64px; color: #d1d5db;"></i>
                        </div>
                        <h4 style="color: #374151; font-weight: 700; margin-bottom: 12px; font-size: 24px;">Pilih Pengumuman</h4>
                        <p class="text-muted mb-0" style="font-size: 16px;">Klik salah satu pengumuman dari daftar di sebelah kanan untuk melihat detailnya</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Sidebar - Daftar Pengumuman --}}
        <div class="col-lg-4">
            <div class="card" style="border-radius: 16px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08); position: sticky; top: 20px;">
                <div class="card-header" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius: 16px 16px 0 0; padding: 20px;">
                    <h5 class="mb-0" style="font-weight: 700; color: white; font-size: 17px;">
                        <i class="fas fa-list-ul mr-2"></i>Daftar Pengumuman
                    </h5>
                </div>
                <div class="card-body p-0" style="max-height: 700px; overflow-y: auto;">
                    @forelse($allPengumuman as $item)
                    <a href="{{ route('petugas.pengumuman.index', ['id' => $item->id]) }}" 
                       class="d-block pengumuman-item {{ isset($selectedPengumuman) && $selectedPengumuman->id == $item->id ? 'active' : '' }}" 
                       style="text-decoration: none; border-bottom: 1px solid #f3f4f6; padding: 18px 20px; transition: all 0.2s; {{ isset($selectedPengumuman) && $selectedPengumuman->id == $item->id ? 'background: #f0f9ff;' : '' }}" 
                       onmouseover="if(!this.classList.contains('active')) this.style.background='#f9fafb'" 
                       onmouseout="if(!this.classList.contains('active')) this.style.background='white'">
                        <div class="d-flex align-items-start">
                            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0; box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);">
                                <i class="fas fa-bullhorn" style="color: white; font-size: 18px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <h6 class="mb-2" style="font-weight: 600; font-size: 14px; color: #1a202c; line-height: 1.4; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                    {{ $item->judul }}
                                </h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div style="font-size: 12px; color: #6b7280;">
                                        <i class="fas fa-calendar mr-1"></i>{{ $item->created_at->format('d M Y') }}
                                    </div>
                                    @if($item->is_aktif)
                                    <span class="badge" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 3px 10px; border-radius: 6px; font-size: 10px; font-weight: 600;">
                                        <i class="fas fa-check-circle mr-1"></i>AKTIF
                                    </span>
                                    @else
                                    <span class="badge" style="background: linear-gradient(135deg, #6b7280, #4b5563); color: white; padding: 3px 10px; border-radius: 6px; font-size: 10px; font-weight: 600;">
                                        NONAKTIF
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-5" style="color: #9ca3af;">
                        <div style="width: 80px; height: 80px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                            <i class="fas fa-inbox" style="font-size: 36px; color: #d1d5db;"></i>
                        </div>
                        <p style="font-size: 14px; font-weight: 600; color: #6b7280;">Belum ada pengumuman</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Scrollbar */
.card-body::-webkit-scrollbar {
    width: 6px;
}

.card-body::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 10px;
}

.card-body::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 10px;
}

.card-body::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}

/* Active Pengumuman Item */
.pengumuman-item.active {
    background: #f0f9ff !important;
    border-left: 4px solid #1e3a8a;
}

/* Print Styles */
@media print {
    .col-lg-4, .no-print {
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
    
    /* Hide elements not needed in print */
    .btn, .badge, .card-header, nav, .no-print {
        display: none !important;
    }
    
    /* Print Header - Kop Surat */
    .print-header {
        display: block !important;
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 3px solid #1e3a8a;
    }
    
    .print-header img {
        width: 80px;
        height: auto;
        margin-bottom: 10px;
    }
    
    .print-header h2 {
        font-size: 20px;
        font-weight: 800;
        color: #1a202c;
        margin: 5px 0;
        text-transform: uppercase;
    }
    
    .print-header h3 {
        font-size: 24px;
        font-weight: 800;
        color: #1e3a8a;
        margin: 5px 0;
        text-transform: uppercase;
    }
    
    .print-header p {
        font-size: 11px;
        color: #374151;
        margin: 2px 0;
    }
    
    /* Print Title */
    .print-title {
        text-align: center;
        margin: 30px 0 20px 0;
        padding: 15px;
        background: #f0f9ff;
        border-left: 5px solid #1e3a8a;
        border-right: 5px solid #1e3a8a;
    }
    
    .print-title h1 {
        font-size: 18px;
        font-weight: 800;
        color: #1a202c;
        margin: 0;
        text-transform: uppercase;
    }
    
    /* Hide screen title on print */
    .card-body > h2 {
        text-align: center;
        font-size: 16pt !important;
        margin: 20px 0 !important;
        text-transform: uppercase;
    }
    
    /* Print Date Right - Tanggal di kanan bawah judul */
    .print-date-right {
        display: block !important;
        text-align: right;
        margin: 20px 0 30px 0;
        font-size: 11pt;
    }
    
    .print-date-right p {
        margin: 0;
        font-weight: 600;
    }
    
    /* Print Content */
    .pengumuman-content {
        font-size: 12pt;
        line-height: 1.8;
        text-align: justify;
        margin: 20px 0;
    }
    
    /* Print Footer - Signature */
    .print-signature {
        display: block !important;
        margin-top: 50px;
        page-break-inside: avoid;
    }
    
    .print-signature-box {
        float: right;
        width: 250px;
        text-align: center;
    }
    
    .print-signature-box p {
        margin: 5px 0;
        font-size: 11pt;
    }
    
    .print-signature-name {
        font-weight: 800;
        text-decoration: underline;
        margin-top: 80px !important;
    }
    
    /* Page break */
    @page {
        margin: 2cm;
    }
}

/* Hide print elements on screen */
.print-header,
.print-signature,
.print-date-right,
.print-title {
    display: none;
}

.pengumuman-content {
    word-wrap: break-word;
}

.pengumuman-content p {
    margin-bottom: 1.2rem;
}
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function printPengumuman() {
    window.print();
}

function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Pengumuman?',
        text: 'Pengumuman yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus!',
        cancelButtonText: '<i class="fas fa-times mr-1"></i> Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'swal-btn-red'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menghapus...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => { Swal.showLoading(); }
            });
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/petugas/pengumuman/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif
</script>
@endpush
@endsection
