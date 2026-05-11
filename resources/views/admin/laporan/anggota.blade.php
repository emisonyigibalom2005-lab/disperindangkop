@extends('layouts.app')
@section('title','Laporan Data Anggota Koperasi')
@section('page-title','Laporan Data Anggota Koperasi')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.laporan.index') }}">Laporan</a></li>
<li class="breadcrumb-item active">Data Anggota</li>
@endsection

@push('styles')
<style>
.card-modern {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
.table-modern {
    border-collapse: separate;
    border-spacing: 0;
}
.table-modern thead {
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    position: sticky;
    top: 0;
    z-index: 10;
}
.table-modern thead th {
    padding: 15px;
    color: #fff;
    border: none;
    font-weight: 600;
}
.table-modern tbody tr {
    border-bottom: 2px solid #e5e7eb;
    transition: all 0.3s ease;
}
.table-modern tbody tr:hover {
    background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
    transform: scale(1.01);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.badge-status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Filter Card --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-modern" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <div class="card-body p-4">
                    <h5 class="text-white mb-3 font-weight-bold">
                        <i class="fas fa-filter mr-2"></i>Filter Laporan
                    </h5>
                    <form method="GET" action="{{ route('admin.laporan.anggota') }}">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="text-white mb-2 font-weight-600">
                                    <i class="fas fa-map-marker-alt mr-1"></i>Distrik
                                </label>
                                <select name="distrik" class="form-control" style="border-radius: 10px;">
                                    <option value="">Semua Distrik</option>
                                    @foreach($distrikList as $d)
                                    <option value="{{ $d }}" {{ request('distrik') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="text-white mb-2 font-weight-600">
                                    <i class="fas fa-check-circle mr-1"></i>Status
                                </label>
                                <select name="status" class="form-control" style="border-radius: 10px;">
                                    <option value="">Semua Status</option>
                                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="text-white mb-2 font-weight-600">
                                    <i class="fas fa-calendar mr-1"></i>Periode
                                </label>
                                <select name="periode" class="form-control" style="border-radius: 10px;">
                                    <option value="">Semua Periode</option>
                                    @foreach($periodeList as $p)
                                    <option value="{{ $p->id }}" {{ request('periode') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_periode }} ({{ $p->tahun_ajaran }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="text-white mb-2 font-weight-600" style="opacity: 0;">Action</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-light flex-fill" style="border-radius: 10px;">
                                        <i class="fas fa-search mr-1"></i>Tampilkan
                                    </button>
                                    @if(request()->hasAny(['distrik', 'status', 'periode']))
                                    <a href="{{ route('admin.laporan.anggota') }}" class="btn btn-secondary" style="border-radius: 10px;">
                                        <i class="fas fa-redo"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Preview Table --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-modern">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 16px 16px 0 0; padding: 20px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold text-white">
                            <i class="fas fa-users mr-2"></i>Preview Data Anggota Koperasi
                        </h5>
                        <span class="badge badge-light" style="font-size: 14px; padding: 8px 15px;">
                            <i class="fas fa-database mr-1"></i>{{ $anggota->count() }} Anggota
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 50px;">#</th>
                                    <th>No. Anggota</th>
                                    <th>NIK</th>
                                    <th>Nama Lengkap</th>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>No. HP</th>
                                    <th>Distrik</th>
                                    <th>Nama Usaha</th>
                                    <th>Bidang Usaha</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center;">Tanggal Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($anggota->take(100) as $i => $a)
                                <tr>
                                    <td style="text-align: center; font-weight: 600; color: #6b7280;">{{ $i+1 }}</td>
                                    <td>
                                        <span class="badge" style="background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; padding: 6px 12px; border-radius: 8px; font-size: 11px;">
                                            {{ $a->no_anggota }}
                                        </span>
                                    </td>
                                    <td><small>{{ $a->nik }}</small></td>
                                    <td>
                                        <div style="font-weight: 700; color: #1a1a1a;">{{ $a->nama }}</div>
                                        <small class="text-muted">{{ $a->user->email ?? '-' }}</small>
                                    </td>
                                    <td><small>{{ $a->tempat_lahir }}, {{ $a->tanggal_lahir->format('d/m/Y') }}</small></td>
                                    <td style="text-align: center;">
                                        @if($a->jenis_kelamin == 'L')
                                            <i class="fas fa-mars text-primary"></i>
                                        @else
                                            <i class="fas fa-venus text-danger"></i>
                                        @endif
                                    </td>
                                    <td><small><i class="fas fa-phone mr-1"></i>{{ $a->no_hp }}</small></td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $a->distrik }}</span>
                                    </td>
                                    <td><strong>{{ $a->nama_usaha }}</strong></td>
                                    <td><small>{{ $a->bidang_usaha }}</small></td>
                                    <td style="text-align: center;">
                                        @if($a->status === 'Aktif')
                                            <span class="badge-status" style="background: #d1fae5; color: #065f46; border: 2px solid #10b981;">
                                                <i class="fas fa-check-circle mr-1"></i>Aktif
                                            </span>
                                        @elseif($a->status === 'Pending')
                                            <span class="badge-status" style="background: #fef3c7; color: #92400e; border: 2px solid #f59e0b;">
                                                <i class="fas fa-clock mr-1"></i>Pending
                                            </span>
                                        @else
                                            <span class="badge-status" style="background: #fee2e2; color: #991b1b; border: 2px solid #ef4444;">
                                                <i class="fas fa-times-circle mr-1"></i>Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <small><i class="far fa-calendar mr-1"></i>{{ $a->created_at->format('d/m/Y') }}</small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="12" class="text-center py-5">
                                        <i class="fas fa-inbox fa-4x mb-3 d-block" style="color: #e5e7eb;"></i>
                                        <h5 style="color: #6b7280;">Tidak Ada Data</h5>
                                        <p style="color: #9ca3af;">Belum ada data anggota yang tersedia</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($anggota->count() > 100)
                <div class="card-footer" style="background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border-radius: 0 0 16px 16px; padding: 20px;">
                    <div class="alert mb-0" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); border: 2px solid #3b82f6; border-radius: 12px; padding: 15px;">
                        <i class="fas fa-info-circle mr-2" style="color: #2563eb;"></i>
                        <strong style="color: #1e40af;">Informasi Preview:</strong>
                        <span style="color: #1e3a8a;">Menampilkan 100 dari {{ $anggota->count() }} data.</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto dismiss alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
@endpush
