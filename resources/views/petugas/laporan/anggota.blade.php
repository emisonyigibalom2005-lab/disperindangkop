@extends('layouts.app')
@section('title', 'Laporan Anggota Koperasi')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card page-header-card">
                <div class="card-body">
                    <div class="d-flex align-items-center text-white">
                        <div class="page-header-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h3 class="page-header-title">Laporan Anggota Koperasi</h3>
                            <p class="page-header-subtitle">Laporan dan statistik anggota koperasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="ml-3">
                            <h6 class="stats-label">Total Anggota</h6>
                            <h3 class="stats-value">{{ number_format($totalAnggota) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-success">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="ml-3">
                            <h6 class="stats-label">Anggota Aktif</h6>
                            <h3 class="stats-value">{{ number_format($anggotaAktif) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-warning">
                            <i class="fas fa-user-times"></i>
                        </div>
                        <div class="ml-3">
                            <h6 class="stats-label">Anggota Non-Aktif</h6>
                            <h3 class="stats-value">{{ number_format($anggotaNonAktif) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="filter-box">
                <form method="GET">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Koperasi</label>
                                <select name="koperasi_id" class="form-control">
                                    <option value="">Semua Koperasi</option>
                                    @foreach($koperasiList as $kop)
                                        <option value="{{ $kop->id }}" {{ request('koperasi_id') == $kop->id ? 'selected' : '' }}>
                                            {{ $kop->nama_usaha }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="non-aktif" {{ request('status') === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Tahun Bergabung</label>
                                <select name="tahun" class="form-control">
                                    <option value="">Semua Tahun</option>
                                    @for($y = date('Y'); $y >= 2020; $y--)
                                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Pencarian</label>
                                <input type="text" name="search" class="form-control" placeholder="Nama, No. KTP, No. Anggota..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary-modern btn-block">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list mr-2"></i>Daftar Anggota Koperasi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>No. Anggota</th>
                                    <th>Nama Lengkap</th>
                                    <th>No. KTP</th>
                                    <th>Koperasi</th>
                                    <th>Tanggal Bergabung</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($anggota as $item)
                                <tr>
                                    <td>{{ $anggota->firstItem() + $loop->index }}</td>
                                    <td><strong>{{ $item->no_anggota ?? '-' }}</strong></td>
                                    <td>{{ $item->nama_lengkap }}</td>
                                    <td>{{ $item->no_ktp }}</td>
                                    <td>{{ $item->koperasi->nama_usaha ?? '-' }}</td>
                                    <td>{{ $item->tanggal_bergabung ? \Carbon\Carbon::parse($item->tanggal_bergabung)->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        @if($item->status === 'aktif')
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Non-Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Tidak ada data anggota</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $anggota->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Anggota Per Koperasi --}}
    @if($anggotaPerKoperasi->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie mr-2"></i>Top 10 Koperasi Berdasarkan Jumlah Anggota
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Koperasi</th>
                                    <th width="150" class="text-center">Jumlah Anggota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($anggotaPerKoperasi as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->koperasi->nama_usaha ?? '-' }}</td>
                                    <td class="text-center"><strong>{{ number_format($item->total) }}</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
