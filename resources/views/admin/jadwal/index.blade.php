@extends("layouts.app")
@section("title","Manajemen Jadwal")
@section("page-title","Jadwal")
@section("breadcrumb")
<li class="breadcrumb-item active">Jadwal</li>
@endsection

@push('scripts')
<script>
function exportData(type) {
    // Get current filter values
    const jenis = document.querySelector('select[name="jenis"]').value;
    const status = document.querySelector('select[name="status"]').value;
    
    // Build query string
    let queryParams = [];
    if (jenis) queryParams.push('jenis=' + jenis);
    if (status) queryParams.push('status=' + status);
    const queryString = queryParams.length > 0 ? '?' + queryParams.join('&') : '';
    
    // Determine export URL
    let url = '';
    switch(type) {
        case 'print':
            url = '{{ route("admin.jadwal.export.print") }}' + queryString;
            window.open(url, '_blank');
            break;
        case 'pdf':
            url = '{{ route("admin.jadwal.export.pdf") }}' + queryString;
            window.open(url, '_blank');
            break;
        case 'excel':
            url = '{{ route("admin.jadwal.export.excel") }}' + queryString;
            window.location.href = url;
            break;
        case 'word':
            url = '{{ route("admin.jadwal.export.word") }}' + queryString;
            window.location.href = url;
            break;
    }
}
</script>
@endpush
@push('styles')
<style>
.jadwal-header-card {
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(26, 58, 110, 0.2);
    margin-bottom: 30px;
}

.filter-card {
    background: white;
    border-radius: 16px;
    border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}

.filter-select {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    padding: 10px 15px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.filter-select:focus {
    border-color: #1a3a6e;
    box-shadow: 0 0 0 3px rgba(26, 58, 110, 0.1);
}

.btn-filter {
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 10px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26, 58, 110, 0.3);
    color: white;
}

.btn-reset {
    background: #f3f4f6;
    color: #6b7280;
    border: none;
    border-radius: 10px;
    padding: 10px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-reset:hover {
    background: #e5e7eb;
    color: #374151;
}

.btn-create-jadwal {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 12px 28px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-create-jadwal:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    color: white;
}

.table-card {
    background: white;
    border-radius: 16px;
    border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    overflow: hidden;
}

.table-card .table {
    margin-bottom: 0;
}

.table-card thead th {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    color: #1a3a6e;
    font-weight: 700;
    border: none;
    padding: 15px;
    font-size: 0.9rem;
}

.table-card tbody td {
    padding: 15px;
    vertical-align: middle;
    border-top: 1px solid #f3f4f6;
    transition: all 0.3s ease;
}

.table-card tbody tr {
    transition: all 0.3s ease;
}

.table-card tbody tr:hover {
    background: #f0f9ff !important;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
}

.btn-group .btn {
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-group .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-group .btn-info {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-color: #3b82f6;
}

.btn-group .btn-info:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border-color: #2563eb;
}

.btn-group .btn-warning {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    border-color: #fbbf24;
    color: white;
}

.btn-group .btn-warning:hover {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border-color: #f59e0b;
    color: white;
}

.btn-group .btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border-color: #ef4444;
}

.btn-group .btn-danger:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    border-color: #dc2626;
}

.badge-custom {
    padding: 8px 14px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
    letter-spacing: 0.3px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.badge-custom:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.badge-custom i {
    margin-right: 4px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state i {
    font-size: 64px;
    color: #d1d5db;
    margin-bottom: 20px;
}

.empty-state h5 {
    color: #1f2937;
    font-weight: 700;
    margin-bottom: 10px;
}

.empty-state p {
    color: #6b7280;
    margin: 0;
}

/* Animations */
@keyframes slideInDown {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.table-card {
    animation: fadeIn 0.5s ease;
}

/* Responsive */
@media (max-width: 768px) {
    .btn-group {
        display: flex;
        flex-direction: column;
    }
    
    .btn-group .btn {
        border-radius: 6px !important;
        margin-bottom: 4px;
    }
}
</style>
@endpush

@section("content")
<div class="container-fluid">
    {{-- Header --}}
    <div class="jadwal-header-card">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center text-white flex-wrap">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div style="width:60px;height:60px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-right:20px">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="mb-1 font-weight-bold">Manajemen Jadwal</h3>
                        <p class="mb-0" style="opacity:0.9;font-size:0.95rem">Kelola jadwal kegiatan dan acara koperasi</p>
                    </div>
                </div>
                <a href="{{ route('admin.jadwal.create') }}" class="btn btn-create-jadwal">
                    <i class="fas fa-plus mr-2"></i>Buat Jadwal Baru
                </a>
            </div>
        </div>
    </div>

    @if(session("success"))
    <div class="alert alert-success alert-dismissible fade show" style="border-radius:12px;border:none;box-shadow:0 2px 8px rgba(16,185,129,0.2);animation:slideInDown 0.5s ease">
        <i class="fas fa-check-circle mr-2"></i>{{ session("success") }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif

    {{-- Filter Card --}}
    <div class="filter-card">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 font-weight-bold" style="color:#1a3a6e">
                    <i class="fas fa-filter mr-2"></i>Filter & Export
                </h6>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm" style="background:linear-gradient(135deg,#3b82f6,#2563eb);color:white;border-radius:8px 0 0 8px;padding:8px 16px;font-weight:600" onclick="exportData('print')">
                        <i class="fas fa-print mr-1"></i>Print
                    </button>
                    <button type="button" class="btn btn-sm" style="background:linear-gradient(135deg,#ef4444,#dc2626);color:white;padding:8px 16px;font-weight:600" onclick="exportData('pdf')">
                        <i class="fas fa-file-pdf mr-1"></i>PDF
                    </button>
                    <button type="button" class="btn btn-sm" style="background:linear-gradient(135deg,#10b981,#059669);color:white;padding:8px 16px;font-weight:600" onclick="exportData('excel')">
                        <i class="fas fa-file-excel mr-1"></i>Excel
                    </button>
                    <button type="button" class="btn btn-sm" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);color:white;border-radius:0 8px 8px 0;padding:8px 16px;font-weight:600" onclick="exportData('word')">
                        <i class="fas fa-file-word mr-1"></i>Word
                    </button>
                </div>
            </div>
            <form class="row align-items-end" id="filterForm">
                <div class="col-md-4 mb-2">
                    <label class="font-weight-600 mb-2" style="color:#1a3a6e;font-size:0.9rem">
                        <i class="fas fa-tag mr-1"></i>Jenis Kegiatan
                    </label>
                    <select name="jenis" class="form-control filter-select">
                        <option value="">Semua Jenis</option>
                        <option value="verifikasi" {{ request("jenis")=="verifikasi"?"selected":"" }}>Verifikasi Lapangan</option>
                        <option value="pelatihan" {{ request("jenis")=="pelatihan"?"selected":"" }}>Pelatihan/Pembinaan</option>
                        <option value="penilaian_bantuan" {{ request("jenis")=="penilaian_bantuan"?"selected":"" }}>Penilaian Bantuan</option>
                        <option value="rapat" {{ request("jenis")=="rapat"?"selected":"" }}>Rapat/Pertemuan</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="font-weight-600 mb-2" style="color:#1a3a6e;font-size:0.9rem">
                        <i class="fas fa-info-circle mr-1"></i>Status
                    </label>
                    <select name="status" class="form-control filter-select">
                        <option value="">Semua Status</option>
                        <option value="dijadwalkan" {{ request("status")=="dijadwalkan"?"selected":"" }}>Dijadwalkan</option>
                        <option value="berlangsung" {{ request("status")=="berlangsung"?"selected":"" }}>Berlangsung</option>
                        <option value="selesai" {{ request("status")=="selesai"?"selected":"" }}>Selesai</option>
                        <option value="dibatalkan" {{ request("status")=="dibatalkan"?"selected":"" }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <button type="submit" class="btn btn-filter mr-2">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-reset">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="table-card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="150">Hari & Tanggal</th>
                        <th>Jadwal</th>
                        <th width="150">Jenis</th>
                        <th width="120">Petugas</th>
                        <th width="120">Status</th>
                        <th width="100">Publik</th>
                        <th width="180" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($jadwal as $j)
                <tr>
                    <td>
                        <div class="font-weight-bold" style="color:#1a3a6e">{{ $j->hari }}</div>
                        <small class="text-muted">{{ $j->tanggal->format("d M Y") }}</small>
                        <br>
                        <small class="text-muted"><i class="fas fa-clock mr-1"></i>{{ substr($j->jam_mulai,0,5) }}{{ $j->jam_selesai ? " - ".substr($j->jam_selesai,0,5) : "" }}</small>
                    </td>
                    <td>
                        <div class="font-weight-bold" style="color:#1a3a6e">{{ $j->judul }}</div>
                        @if($j->deskripsi)
                        <small class="text-muted d-block" style="max-width:400px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            <i class="fas fa-info-circle mr-1"></i>{{ $j->deskripsi }}
                        </small>
                        @endif
                        @if($j->lokasi)
                        <small class="text-muted d-block">
                            <i class="fas fa-map-marker-alt mr-1"></i>{{ $j->lokasi }}
                        </small>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-custom badge-{{ $j->jenis_color }}">
                            {{ $j->jenis_label }}
                        </span>
                    </td>
                    <td>
                        <small>{{ $j->petugas->name ?? "-" }}</small>
                    </td>
                    <td>
                        <span class="badge badge-custom badge-{{ $j->status_color }}">
                            {{ $j->status_label }}
                        </span>
                    </td>
                    <td>
                        @if($j->is_publik)
                            <span class="badge badge-custom badge-success">
                                <i class="fas fa-globe"></i> Ya
                            </span>
                        @else
                            <span class="badge badge-custom badge-secondary">Internal</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.jadwal.show',$j) }}" 
                               class="btn btn-sm btn-info" 
                               data-toggle="tooltip" 
                               data-placement="top" 
                               title="Lihat Detail Jadwal"
                               style="border-radius:6px 0 0 6px;padding:6px 12px">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.jadwal.edit',$j) }}" 
                               class="btn btn-sm btn-warning" 
                               data-toggle="tooltip" 
                               data-placement="top" 
                               title="Edit Jadwal"
                               style="border-radius:0;padding:6px 12px">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button"
                                    class="btn btn-sm btn-danger" 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="Hapus Jadwal"
                                    style="border-radius:0 6px 6px 0;padding:6px 12px"
                                    onclick="confirmDelete({{ $j->id }}, '{{ addslashes($j->judul) }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <form id="delete-form-{{ $j->id }}" 
                              action="{{ route('admin.jadwal.destroy',$j) }}" 
                              method="POST" 
                              style="display:none">
                            @csrf @method("DELETE")
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h5>Belum Ada Jadwal</h5>
                            <p>Klik tombol "Buat Jadwal Baru" untuk menambahkan jadwal kegiatan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        
        @if($jadwal->hasPages())
        <div class="card-footer bg-white border-top">
            <div class="d-flex justify-content-center">
                {{ $jadwal->links("pagination::bootstrap-4") }}
            </div>
        </div>
        @endif
    </div>
</div>

<script>
// Initialize tooltips
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});

function confirmDelete(id, judul) {
    Swal.fire({
        title: 'Hapus Jadwal?',
        html: `Apakah Anda yakin ingin menghapus jadwal:<br><strong>"${judul}"</strong>?<br><br><small class="text-muted">Data yang dihapus tidak dapat dikembalikan.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#007bff',
        confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger btn-lg px-4',
            cancelButton: 'btn btn-primary btn-lg px-4'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Submit form
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection
