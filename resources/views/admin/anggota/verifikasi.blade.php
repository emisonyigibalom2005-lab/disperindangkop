@extends('layouts.app')
@section('title', 'Verifikasi Pendaftaran Anggota')

@section('content')

{{-- Stats Cards --}}
<div class="row mb-4">
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-0" style="border-radius: 12px; background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); box-shadow: 0 2px 10px rgba(251, 191, 36, 0.3);">
            <div class="card-body text-white p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-1 fw-bold">{{ $stats['pending'] }}</h2>
                        <p class="mb-0" style="font-size: 14px; opacity: 0.95;">Menunggu Verifikasi</p>
                    </div>
                    <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-0" style="border-radius: 12px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 2px 10px rgba(239, 68, 68, 0.3);">
            <div class="card-body text-white p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-1 fw-bold">{{ $stats['ditolak'] }}</h2>
                        <p class="mb-0" style="font-size: 14px; opacity: 0.95;">Ditolak (Perlu Perbaikan)</p>
                    </div>
                    <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-0" style="border-radius: 12px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 2px 10px rgba(16, 185, 129, 0.3);">
            <div class="card-body text-white p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-1 fw-bold">{{ $stats['aktif'] }}</h2>
                        <p class="mb-0" style="font-size: 14px; opacity: 0.95;">Sudah Diverifikasi</p>
                    </div>
                    <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filter & Search --}}
<div class="card mb-4" style="border-radius: 12px; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
    <div class="card-header bg-white" style="padding: 20px 24px; border-bottom: 2px solid #f0f0f0;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1 fw-semibold" style="color: #1e293b;">
                    <i class="fas fa-filter me-2" style="color: #667eea;"></i>Filter Data Belum Verifikasi
                </h5>
                <small class="text-muted" style="font-size: 12px;">
                    <i class="fas fa-info-circle mr-1"></i>Hanya menampilkan anggota dengan status: Pending atau Ditolak
                </small>
            </div>
            <a href="{{ route('admin.anggota.index') }}" class="btn btn-success" style="border-radius: 8px; font-weight: 600; padding: 8px 16px;">
                <i class="fas fa-check-circle mr-2"></i>Lihat Anggota Terverifikasi
            </a>
        </div>
    </div>
    <div class="card-body" style="padding: 24px;">
        <form method="GET" action="{{ route('admin.anggota.verifikasi') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="font-size: 13px; color: #374151;">Status</label>
                    <select name="status" class="form-select" style="border-radius: 8px; border: 1.5px solid #e5e7eb;">
                        <option value="">Semua Status (Belum Verifikasi)</option>
                        <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>⏳ Pending (Menunggu)</option>
                        <option value="Ditolak" {{ request('status')=='Ditolak'?'selected':'' }}>❌ Ditolak (Perlu Perbaikan)</option>
                    </select>
                    <small class="text-muted" style="font-size: 11px;">
                        <i class="fas fa-trash-alt mr-1"></i>Klik tombol merah untuk menghapus data anggota
                    </small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size: 13px; color: #374151;">Cari Anggota</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama atau No. Anggota" value="{{ request('search') }}" style="border-radius: 8px; border: 1.5px solid #e5e7eb;">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size: 13px; color: #374151;">&nbsp;</label>
                    <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Data Anggota dalam Tabel --}}
<div class="card" style="border-radius: 12px; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
    <div class="card-header bg-white" style="padding: 20px 24px; border-bottom: 2px solid #f0f0f0;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1 fw-semibold" style="color: #1e293b;">
                    <i class="fas fa-list me-2" style="color: #667eea;"></i>Daftar Anggota Belum Verifikasi
                </h5>
                <small class="text-muted" style="font-size: 12px;">
                    <i class="fas fa-eye mr-1"></i>Lihat detail atau <i class="fas fa-trash-alt ml-2 mr-1"></i>hapus data anggota
                </small>
            </div>
            <span class="badge" style="background: linear-gradient(135deg, #fbbf24, #f59e0b); color: white; font-size: 13px; padding: 8px 16px; border-radius: 8px;">
                <i class="fas fa-hourglass-half mr-2"></i>{{ $anggota->total() }} Belum Verifikasi
            </span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" style="font-size: 13px;">
                <thead style="background: #f8f9fa; border-bottom: 2px solid #e5e7eb;">
                    <tr>
                        <th style="padding: 14px 16px; font-weight: 600; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">NO. ANGGOTA</th>
                        <th style="padding: 14px 16px; font-weight: 600; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">FOTO</th>
                        <th style="padding: 14px 16px; font-weight: 600; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">NAMA LENGKAP</th>
                        <th style="padding: 14px 16px; font-weight: 600; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">TEMPAT, TGL LAHIR</th>
                        <th style="padding: 14px 16px; font-weight: 600; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">JENIS KELAMIN</th>
                        <th style="padding: 14px 16px; font-weight: 600; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">KONTAK</th>
                        <th style="padding: 14px 16px; font-weight: 600; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">DESA</th>
                        <th style="padding: 14px 16px; font-weight: 600; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">NAMA USAHA</th>
                        <th style="padding: 14px 16px; font-weight: 600; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">MODAL USAHA</th>
                        <th style="padding: 14px 16px; font-weight: 600; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">TOTAL SIMPANAN</th>
                        <th style="padding: 14px 16px; font-weight: 600; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">STATUS</th>
                        <th style="padding: 14px 16px; font-weight: 600; color: #374151; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggota as $a)
                    <tr style="border-bottom: 1px solid #f0f0f0; transition: all 0.2s;">
                        <td style="padding: 14px 16px;">
                            <span class="badge" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; font-size: 11px; font-weight: 600; padding: 6px 12px; border-radius: 6px;">
                                {{ $a->no_anggota }}
                            </span>
                        </td>
                        <td style="padding: 14px 16px;">
                            <img src="{{ $a->foto_url }}" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 3px solid #e0e6ff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        </td>
                        <td style="padding: 14px 16px;">
                            <div style="font-weight: 600; color: #1e293b; font-size: 13px;">{{ $a->nama }}</div>
                            <small class="text-muted" style="font-size: 11px;">NIK: {{ $a->nik }}</small>
                        </td>
                        <td style="padding: 14px 16px;">
                            <div style="font-size: 12px; color: #475569;">{{ $a->tempat_lahir }}</div>
                            <small class="text-muted" style="font-size: 11px;">{{ $a->tanggal_lahir ? \Carbon\Carbon::parse($a->tanggal_lahir)->format('d M Y') : '-' }}</small>
                        </td>
                        <td style="padding: 14px 16px;">
                            @if($a->jenis_kelamin == 'L')
                            <span class="badge" style="background: #dbeafe; color: #1e40af; font-size: 11px; font-weight: 600; padding: 6px 12px; border-radius: 6px;">
                                <i class="fas fa-mars" style="font-size: 10px;"></i> Laki-laki
                            </span>
                            @else
                            <span class="badge" style="background: #fce7f3; color: #be185d; font-size: 11px; font-weight: 600; padding: 6px 12px; border-radius: 6px;">
                                <i class="fas fa-venus" style="font-size: 10px;"></i> Perempuan
                            </span>
                            @endif
                        </td>
                        <td style="padding: 14px 16px;">
                            <div style="font-size: 12px; color: #475569;">
                                <i class="fab fa-whatsapp text-success" style="font-size: 11px;"></i> {{ $a->no_hp }}
                            </div>
                            @if($a->email)
                            <small class="text-muted" style="font-size: 11px;">
                                <i class="fas fa-envelope" style="font-size: 10px;"></i> {{ Str::limit($a->email, 20) }}
                            </small>
                            @endif
                        </td>
                        <td style="padding: 14px 16px;">
                            <small style="font-size: 12px; color: #475569;">{{ $a->desa ?? '-' }}</small>
                        </td>
                        <td style="padding: 14px 16px;">
                            <div style="font-size: 12px; color: #475569;">
                                <i class="fas fa-store text-muted" style="font-size: 10px;"></i> {{ Str::limit($a->nama_usaha, 20) }}
                            </div>
                        </td>
                        <td style="padding: 14px 16px;">
                            <span class="text-success" style="font-weight: 600; font-size: 12px;">
                                Rp {{ number_format($a->modal_usaha ?? 0, 0, ',', '.') }}
                            </span>
                        </td>
                        <td style="padding: 14px 16px;">
                            <span class="text-primary" style="font-weight: 600; font-size: 12px;">
                                Rp {{ number_format($a->total_simpanan ?? 0, 0, ',', '.') }}
                            </span>
                        </td>
                        <td style="padding: 14px 16px;">
                            @if($a->status == 'Pending')
                            <span class="badge bg-warning text-dark" style="font-size: 11px; font-weight: 600; padding: 6px 12px; border-radius: 6px;">
                                <i class="fas fa-clock" style="font-size: 10px;"></i> Pending
                            </span>
                            @elseif($a->status == 'Aktif')
                            <span class="badge bg-success" style="font-size: 11px; font-weight: 600; padding: 6px 12px; border-radius: 6px;">
                                <i class="fas fa-check-circle" style="font-size: 10px;"></i> Aktif
                            </span>
                            @elseif($a->status == 'Ditolak')
                            <span class="badge bg-danger" style="font-size: 11px; font-weight: 600; padding: 6px 12px; border-radius: 6px;">
                                <i class="fas fa-times-circle" style="font-size: 10px;"></i> Nonaktif
                            </span>
                            @endif
                        </td>
                        <td style="padding: 14px 16px; text-align: center;">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.anggota.show', $a) }}" 
                                   class="btn btn-sm" 
                                   style="font-size: 11px; padding: 6px 12px; border-radius: 6px 0 0 6px; background: #06b6d4; color: white; border: none;"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <button type="button"
                                        class="btn btn-sm" 
                                        style="font-size: 11px; padding: 6px 12px; border-radius: 0 6px 6px 0; background: #dc2626; color: white; border: none;"
                                        onclick="confirmDelete({{ $a->id }}, '{{ $a->nama }}')"
                                        title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center" style="padding: 60px 20px;">
                            <i class="fas fa-check-circle fa-4x mb-3" style="opacity: 0.3; color: #10b981;"></i>
                            <h5 style="color: #64748b; font-weight: 600;">Tidak ada pendaftaran yang perlu diverifikasi</h5>
                            <p class="text-muted mb-3" style="font-size: 14px;">
                                Semua pendaftaran sudah diverifikasi atau belum ada anggota yang mendaftar.
                            </p>
                            <div class="alert alert-success d-inline-block" style="border-radius: 12px; padding: 15px 25px;">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Anggota yang sudah diterima</strong> otomatis pindah ke halaman <strong>"Data Anggota Koperasi"</strong>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('admin.anggota.index') }}" class="btn btn-primary" style="border-radius: 8px; padding: 10px 24px;">
                                    <i class="fas fa-users mr-2"></i>Lihat Data Anggota Koperasi
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($anggota->hasPages())
    <div class="card-footer bg-white" style="padding: 20px 24px; border-top: 2px solid #f0f0f0;">
        <div class="d-flex justify-content-center">
            {{ $anggota->links() }}
        </div>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id, nama) {
    Swal.fire({
        title: 'Hapus Data Anggota?',
        html: `Apakah Anda yakin ingin menghapus anggota:<br><strong>"${nama}"</strong>?<br><br><small class="text-danger">Data yang dihapus tidak dapat dikembalikan!</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> Ya, Hapus!',
        cancelButtonText: '<i class="fas fa-times mr-1"></i> Batal',
        reverseButtons: true,
        customClass: {
            popup: 'swal-modern',
            confirmButton: 'btn-modern',
            cancelButton: 'btn-modern'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Submit delete form
            const form = document.getElementById('deleteForm');
            form.action = `/admin/anggota/${id}`;
            form.submit();
        }
    });
}

// Success message
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false,
        customClass: {
            popup: 'swal-modern'
        }
    });
@endif

// Error message
@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        confirmButtonText: 'OK',
        customClass: {
            popup: 'swal-modern'
        }
    });
@endif
</script>

<style>
.swal-modern {
    border-radius: 16px;
    padding: 20px;
}
.swal2-title {
    color: #1a3a6e;
    font-size: 22px;
    font-weight: 700;
}
.swal2-html-container {
    font-size: 14px;
    color: #64748b;
}
.btn-modern {
    border-radius: 8px;
    padding: 10px 24px;
    font-weight: 600;
    font-size: 14px;
}
</style>

{{-- Delete Form (Hidden) --}}
<form id="deleteForm" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>
@endpush
