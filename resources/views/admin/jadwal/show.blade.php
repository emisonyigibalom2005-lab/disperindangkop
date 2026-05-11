@extends("layouts.app")
@section("title","Detail Jadwal")

@push('styles')
<style>
    /* Header Card */
    .detail-header-card {
        background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 20px rgba(26, 58, 110, 0.2);
        margin-bottom: 30px;
        overflow: hidden;
        position: relative;
    }

    .detail-header-card::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    /* Card Modern */
    .card-modern {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        border: none;
        margin-bottom: 24px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card-modern:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }

    .card-modern-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 20px 24px;
        border-bottom: 2px solid #e8ebf7;
    }

    .card-modern-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a3a6e;
        margin: 0;
    }

    .card-modern-title i {
        color: #f5a623;
        margin-right: 10px;
    }

    .card-modern-body {
        padding: 24px;
    }

    /* Info Item */
    .info-item {
        margin-bottom: 20px;
        padding: 16px;
        background: #f9fafb;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: #f0f9ff;
    }

    .info-item-label {
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .info-item-value {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
    }

    .info-item-value i {
        margin-right: 8px;
        color: #3b82f6;
    }

    /* Badge Modern */
    .badge-modern {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Button Modern */
    .btn-modern {
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .btn-back {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
    }

    .btn-back:hover {
        background: linear-gradient(135deg, #4b5563, #374151);
        color: white;
    }

    .btn-edit-modern {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: white;
    }

    .btn-edit-modern:hover {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .btn-delete-modern {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .btn-delete-modern:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
    }

    .btn-update-status {
        background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
        color: white;
    }

    .btn-update-status:hover {
        background: linear-gradient(135deg, #2d5aa0, #3b5bb8);
        color: white;
    }

    /* Alert Modern */
    .alert-modern {
        border-radius: 12px;
        border: none;
        padding: 16px 20px;
    }

    .alert-modern-warning {
        background: #fef3c7;
        color: #92400e;
    }

    /* Table Modern */
    .table-modern {
        margin-bottom: 0;
    }

    .table-modern thead th {
        background: #1a3a6e;
        color: white;
        font-weight: 700;
        border: 1px solid #1a3a6e;
        padding: 12px 15px;
        font-size: 13px;
        text-align: center;
    }

    .table-modern tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border: 1px solid #e5e7eb;
        font-size: 13px;
    }

    .table-modern tbody tr {
        background: white;
        transition: all 0.3s ease;
    }

    .table-modern tbody tr:nth-child(even) {
        background: #f9fafb;
    }

    .table-modern tbody tr:hover {
        background: #f0f9ff;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    /* Form Control Modern */
    .form-control-modern {
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        border-color: #1a3a6e;
        box-shadow: 0 0 0 3px rgba(26, 58, 110, 0.1);
    }
</style>
@endpush

@section("content")
<div class="container-fluid">
    {{-- Header --}}
    <div class="detail-header-card">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center text-white flex-wrap">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div style="width:60px;height:60px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-right:20px;position:relative;z-index:1">
                        <i class="fas fa-calendar-check fa-2x"></i>
                    </div>
                    <div style="position:relative;z-index:1">
                        <h3 class="mb-1 font-weight-bold">Detail Jadwal</h3>
                        <p class="mb-0" style="opacity:0.9;font-size:0.95rem">Informasi lengkap jadwal kegiatan</p>
                    </div>
                </div>
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-back btn-modern" style="position:relative;z-index:1">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
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

    <div class="row">
        {{-- Main Content --}}
        <div class="col-lg-8">
            {{-- Informasi Jadwal --}}
            <div class="card-modern">
                <div class="card-modern-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-modern-title">
                            <i class="fas fa-info-circle"></i>{{ $jadwal->judul }}
                        </h3>
                        <div>
                            <span class="badge-modern badge-{{ $jadwal->jenis_color }} mr-2">{{ $jadwal->jenis_label }}</span>
                            <span class="badge-modern badge-{{ $jadwal->status_color }}">{{ $jadwal->status_label }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-modern-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-item-label">
                                    <i class="fas fa-calendar-day"></i> Hari & Tanggal
                                </div>
                                <div class="info-item-value">
                                    <i class="fas fa-calendar"></i>{{ $jadwal->hari }}, {{ $jadwal->tanggal->format("d F Y") }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-item-label">
                                    <i class="fas fa-clock"></i> Waktu
                                </div>
                                <div class="info-item-value">
                                    <i class="fas fa-clock"></i>{{ substr($jadwal->jam_mulai,0,5) }}{{ $jadwal->jam_selesai ? " - ".substr($jadwal->jam_selesai,0,5) : "" }} WIT
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($jadwal->lokasi)
                    <div class="info-item">
                        <div class="info-item-label">
                            <i class="fas fa-map-marker-alt"></i> Lokasi
                        </div>
                        <div class="info-item-value">
                            <i class="fas fa-map-marker-alt text-danger"></i>{{ $jadwal->lokasi }}
                        </div>
                    </div>
                    @endif

                    @if($jadwal->deskripsi)
                    <div class="info-item">
                        <div class="info-item-label">
                            <i class="fas fa-align-left"></i> Deskripsi
                        </div>
                        <div class="info-item-value" style="font-weight:400;line-height:1.6">
                            {{ $jadwal->deskripsi }}
                        </div>
                    </div>
                    @endif

                    @if($jadwal->catatan)
                    <div class="alert-modern alert-modern-warning">
                        <div class="info-item-label mb-2">
                            <i class="fas fa-sticky-note"></i> Catatan
                        </div>
                        <div style="font-weight:500">{{ $jadwal->catatan }}</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Koperasi Terlibat --}}
            @if($jadwal->koperasiList->count())
            <div class="card-modern">
                <div class="card-modern-header">
                    <h3 class="card-modern-title">
                        <i class="fas fa-store"></i>Koperasi Terlibat ({{ $jadwal->koperasiList->count() }})
                    </h3>
                </div>
                <div class="card-modern-body p-0">
                    <div class="table-responsive">
                        <table class="table-modern table">
                            <thead>
                                <tr>
                                    <th width="40%">Nama Usaha</th>
                                    <th width="30%">Pemilik</th>
                                    <th width="30%">Status Hadir</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($jadwal->koperasiList as $u)
                            <tr>
                                <td><strong>{{ $u->nama_usaha }}</strong></td>
                                <td>{{ $u->pemilik }}</td>
                                <td>
                                    @php $h = $u->pivot->status_hadir @endphp
                                    <span class="badge-modern badge-{{ $h=="hadir"?"success":($h=="tidak_hadir"?"danger":"secondary") }}">
                                        {{ $h=="hadir"?"Hadir":($h=="tidak_hadir"?"Tidak Hadir":"Belum Konfirmasi") }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Info & Aksi --}}
            <div class="card-modern">
                <div class="card-modern-header">
                    <h3 class="card-modern-title">
                        <i class="fas fa-cog"></i>Info & Aksi
                    </h3>
                </div>
                <div class="card-modern-body">
                    <div class="info-item">
                        <div class="info-item-label">
                            <i class="fas fa-user"></i> Dibuat Oleh
                        </div>
                        <div class="info-item-value">
                            {{ $jadwal->pembuat->name ?? "-" }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-item-label">
                            <i class="fas fa-user-tie"></i> Petugas Pelaksana
                        </div>
                        <div class="info-item-value">
                            {{ $jadwal->petugas->name ?? "Belum ditugaskan" }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-item-label">
                            <i class="fas fa-eye"></i> Visibilitas
                        </div>
                        <div class="info-item-value">
                            @if($jadwal->is_publik)
                                <span class="badge-modern badge-success"><i class="fas fa-globe"></i> Publik</span>
                            @else
                                <span class="badge-modern badge-secondary"><i class="fas fa-lock"></i> Internal</span>
                            @endif
                        </div>
                    </div>

                    <hr style="border-top:2px solid #e5e7eb;margin:24px 0">

                    {{-- Update Status --}}
                    <form action="{{ route('admin.jadwal.updateStatus',$jadwal) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold" style="color:#1a3a6e">
                                <i class="fas fa-sync-alt mr-2"></i>Update Status
                            </label>
                            <select name="status" class="form-control form-control-modern">
                                <option value="dijadwalkan" {{ $jadwal->status=="dijadwalkan"?"selected":"" }}>Dijadwalkan</option>
                                <option value="berlangsung" {{ $jadwal->status=="berlangsung"?"selected":"" }}>Berlangsung</option>
                                <option value="selesai"     {{ $jadwal->status=="selesai"?"selected":"" }}>Selesai</option>
                                <option value="dibatalkan"  {{ $jadwal->status=="dibatalkan"?"selected":"" }}>Dibatalkan</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-update-status btn-modern w-100 mb-3">
                            <i class="fas fa-check mr-2"></i>Update Status
                        </button>
                    </form>

                    {{-- Edit Button --}}
                    <a href="{{ route('admin.jadwal.edit',$jadwal) }}" class="btn btn-edit-modern btn-modern w-100 mb-3">
                        <i class="fas fa-edit mr-2"></i>Edit Jadwal
                    </a>

                    {{-- Delete Button --}}
                    <button type="button" class="btn btn-delete-modern btn-modern w-100" onclick="confirmDelete()">
                        <i class="fas fa-trash mr-2"></i>Hapus Jadwal
                    </button>
                    <form id="delete-form" action="{{ route('admin.jadwal.destroy',$jadwal) }}" method="POST" style="display:none">
                        @csrf @method("DELETE")
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    Swal.fire({
        title: 'Hapus Jadwal?',
        html: `Apakah Anda yakin ingin menghapus jadwal:<br><strong>"{{ addslashes($jadwal->judul) }}"</strong>?<br><br><small class="text-muted">Data yang dihapus tidak dapat dikembalikan.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger btn-lg px-4',
            cancelButton: 'btn btn-secondary btn-lg px-4'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menghapus...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            document.getElementById('delete-form').submit();
        }
    });
}
</script>
@endsection
