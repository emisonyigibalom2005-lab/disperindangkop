@extends('layouts.app')
@section('title', 'Anggota Koperasi')

@push('styles')
<style>
    .stats-card-modern {
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
    }
    
    .stats-card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .stats-card-body {
        padding: 25px;
        color: white;
        position: relative;
        min-height: 120px;
    }
    
    .stats-icon-wrapper {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stats-number {
        font-size: 36px;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 8px;
    }
    
    .stats-label {
        font-size: 14px;
        opacity: 0.95;
        font-weight: 500;
    }
    
    .filter-box-modern {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }
    
    .table-modern-wrapper {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .table-modern-header {
        padding: 20px 25px;
        border-bottom: 2px solid #f0f0f0;
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
    }
    
    .table-modern-header h5 {
        margin: 0;
        color: #ffffff !important;
        font-weight: 800 !important;
        font-size: 17px !important;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .table-modern {
        margin: 0;
        font-size: 14px;
    }
    
    .table-modern thead th {
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%) !important;
        color: #ffffff !important;
        border: none;
        font-size: 12px !important;
        font-weight: 800 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 12px;
        white-space: nowrap;
        text-align: center;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }
    
    .table-modern tbody td {
        padding: 16px 14px;
        vertical-align: middle;
        font-size: 15px;
        border-bottom: 1px solid #f0f0f0;
        color: #111827;
        font-weight: 600;
        line-height: 1.6;
    }
    
    .table-modern tbody tr:hover {
        background: #f0fdf4;
    }
    
    .action-btn-group {
        display: flex;
        gap: 6px;
        justify-content: center;
    }
    
    .action-btn-group .btn {
        padding: 10px 14px;
        font-size: 14px;
        border-radius: 8px;
        border: none !important;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    
    .action-btn-group .btn-danger {
        background: #dc2626 !important;
        color: white !important;
    }
    
    .action-btn-group .btn-danger:hover {
        background: #b91c1c !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.5);
    }
    
    .status-badge {
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 600;
        display: inline-block;
    }
    
    .status-active {
        background: #10b981;
        color: white;
    }
    
    .status-pending {
        background: #f59e0b;
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state i {
        font-size: 60px;
        color: #e5e7eb;
        margin-bottom: 15px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stats-card-modern" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                <div class="stats-card-body">
                    <div class="stats-number">{{ $stats['total'] }}</div>
                    <div class="stats-label">Total Anggota Koperasi</div>
                    <div class="stats-icon-wrapper">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stats-card-modern" style="background: linear-gradient(135deg, #10b981, #059669);">
                <div class="stats-card-body">
                    <div class="stats-number">{{ $stats['aktif'] }}</div>
                    <div class="stats-label">Anggota Aktif</div>
                    <div class="stats-icon-wrapper">
                        <i class="fas fa-user-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stats-card-modern" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <div class="stats-card-body">
                    <div class="stats-number">{{ $stats['pending'] }}</div>
                    <div class="stats-label">Menunggu Verifikasi</div>
                    <div class="stats-icon-wrapper">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Box --}}
    <div class="filter-box-modern">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="mb-1" style="font-weight: 700; color: #1f2937;">
                    Filter & Cari Data
                </h5>
                <p class="text-muted mb-0" style="font-size: 13px;">Cari dan filter anggota koperasi sesuai kebutuhan</p>
            </div>
            <a href="{{ route('admin.anggota-koperasi.create') }}" class="btn btn-primary" style="border-radius:8px;font-weight:600;">
                <i class="fas fa-plus mr-1"></i>Tambah Anggota ke Koperasi
            </a>
        </div>
        <form method="GET" action="{{ route('admin.anggota-koperasi.index') }}">
            <div class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold" style="font-size: 13px; color: #495057;">Pencarian</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari nama, NIK, atau nomor anggota..." 
                           value="{{ request('search') }}"
                           style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 10px 15px;">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="font-weight-bold" style="font-size: 13px; color: #495057;">Koperasi</label>
                    <select name="koperasi_id" class="form-control" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 10px 15px;">
                        <option value="">Semua Koperasi</option>
                        @foreach($koperasiList as $kop)
                        <option value="{{ $kop->id }}" {{ request('koperasi_id')==$kop->id?'selected':'' }}>
                            {{ $kop->nama_usaha }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="font-weight-bold" style="font-size: 13px; color: #495057;">Status</label>
                    <select name="status" class="form-control" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 10px 15px;">
                        <option value="">Semua Status</option>
                        <option value="Aktif" {{ request('status')=='Aktif'?'selected':'' }}>Aktif</option>
                        <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <button type="submit" class="btn btn-primary btn-block" style="border-radius: 10px; padding: 10px; font-weight: 600;">
                        <i class="fas fa-search mr-1"></i>Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-modern-wrapper">
        <div class="table-modern-header">
            <h5><i class="fas fa-list mr-2"></i>Daftar Anggota Koperasi</h5>
        </div>
        <div class="table-responsive">
            @if($anggotaKoperasi->count() > 0)
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Anggota</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Koperasi</th>
                        <th>Distrik</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($anggotaKoperasi as $index => $anggota)
                    <tr>
                        <td class="text-center">{{ $anggotaKoperasi->firstItem() + $index }}</td>
                        <td><strong>{{ $anggota->no_anggota }}</strong></td>
                        <td>
                            <strong>{{ $anggota->nama }}</strong><br>
                            <small>{{ $anggota->email }}</small>
                        </td>
                        <td>{{ $anggota->nik }}</td>
                        <td>
                            @if($anggota->koperasi)
                            <strong>{{ $anggota->koperasi->nama_usaha }}</strong><br>
                            <small>{{ $anggota->koperasi->no_registrasi }}</small>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $anggota->distrik }}</td>
                        <td>
                            <span class="status-badge {{ $anggota->status == 'Aktif' ? 'status-active' : 'status-pending' }}">
                                {{ $anggota->status }}
                            </span>
                        </td>
                        <td>
                            <div class="action-btn-group">
                                <form action="{{ route('admin.anggota-koperasi.destroy', $anggota->id) }}" 
                                      method="POST" 
                                      class="delete-form"
                                      data-anggota-nama="{{ $anggota->nama }}"
                                      data-koperasi-nama="{{ $anggota->koperasi ? $anggota->koperasi->nama_usaha : '' }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-times mr-1"></i>Keluarkan
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h5>Belum Ada Data</h5>
                <p>Belum ada anggota yang tergabung dalam koperasi</p>
                <a href="{{ route('admin.anggota-koperasi.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i>Tambah Anggota ke Koperasi
                </a>
            </div>
            @endif
        </div>
        @if($anggotaKoperasi->hasPages())
        <div class="p-3">
            {{ $anggotaKoperasi->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const anggotaNama = this.dataset.anggotaNama;
            const koperasiNama = this.dataset.koperasiNama;
            
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                html: `Apakah Anda yakin ingin mengeluarkan:<br><strong>${anggotaNama}</strong><br>dari koperasi <strong>${koperasiNama}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#3b82f6',
                confirmButtonText: 'Ya, Keluarkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
});
</script>
@endpush
