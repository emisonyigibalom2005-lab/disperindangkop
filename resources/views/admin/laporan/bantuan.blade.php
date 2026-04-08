@extends('layouts.app')

@section('title', 'Rekap Bantuan')
@section('page-title', 'Rekap Distribusi Bantuan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.laporan.index') }}">Laporan</a></li>
    <li class="breadcrumb-item active">Rekap Bantuan</li>
@endsection

@section('content')

{{-- Filter --}}
<div class="card card-outline card-success shadow-sm mb-3">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-filter mr-2"></i>Filter Laporan</h3>
    </div>
    <div class="card-body">
        <form method="GET">
            <div class="row">
                <div class="col-md-3">
                    <select name="tahun" class="form-control">
                        <option value="">Semua Tahun</option>
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="aktif"      {{ request('status') === 'aktif'      ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai"    {{ request('status') === 'selesai'    ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100"><i class="fas fa-search mr-1"></i>Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.laporan.bantuan') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
                <div class="col-md-3 text-right">
                    <a href="{{ route('admin.laporan.exportExcel', ['type'=>'bantuan']) }}" class="btn btn-success">
                        <i class="fas fa-file-excel mr-1"></i> Excel
                    </a>
                    <a href="{{ route('admin.laporan.exportPdf', ['type'=>'bantuan']) }}" class="btn btn-danger ml-1">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Tren per Tahun --}}
@if($bantuanPerTahun->count() > 0)
<div class="card shadow-sm mb-3">
    <div class="card-header bg-light">
        <h6 class="mb-0 font-weight-bold"><i class="fas fa-chart-line mr-2 text-success"></i>Tren Penerima Bantuan per Tahun</h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-sm mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Tahun</th>
                    <th>Jumlah Penerima</th>
                    <th>Total Nilai Bantuan (Rp)</th>
                    <th>Grafik</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bantuanPerTahun as $b)
                <tr>
                    <td><strong>{{ $b->tahun }}</strong></td>
                    <td><span class="badge badge-success">{{ $b->total }} orang</span></td>
                    <td>{{ number_format($b->total_nilai, 0, ',', '.') }}</td>
                    <td>
                        <div class="progress" style="height:14px; min-width:150px">
                            <div class="progress-bar bg-success"
                                 style="width:{{ $bantuanPerTahun->max('total') > 0 ? ($b->total / $bantuanPerTahun->max('total') * 100) : 0 }}%">
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Tabel Program Bantuan --}}
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-hand-holding-usd mr-2"></i>Daftar Program Bantuan
            <span class="badge badge-success ml-1">{{ $bantuan->total() }}</span>
        </h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Program</th>
                        <th>Jenis</th>
                        <th>Tahun</th>
                        <th>Anggaran (Rp)</th>
                        <th>Kuota</th>
                        <th>Penerima</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bantuan as $i => $b)
                    <tr>
                        <td>{{ $bantuan->firstItem() + $i }}</td>
                        <td><small class="text-success font-weight-bold">{{ $b->kode_bantuan }}</small></td>
                        <td><strong>{{ $b->nama_bantuan }}</strong><br><small class="text-muted">{{ $b->periode }}</small></td>
                        <td><span class="badge badge-info">{{ ucfirst($b->jenis_bantuan) }}</span></td>
                        <td>{{ $b->tahun }}</td>
                        <td><small>{{ number_format($b->anggaran, 0, ',', '.') }}</small></td>
                        <td>{{ $b->kuota }}</td>
                        <td>
                            <span class="badge badge-{{ $b->jumlah_penerima >= $b->kuota ? 'danger' : 'success' }}">
                                {{ $b->jumlah_penerima }} / {{ $b->kuota }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $b->status === 'aktif' ? 'success' : ($b->status === 'selesai' ? 'secondary' : 'danger') }}">
                                {{ ucfirst($b->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">Tidak ada data bantuan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $bantuan->links('pagination::bootstrap-4') }}
    </div>
</div>

@endsection