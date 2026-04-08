@extends('layouts.app')

@section('title', 'Rekap Koperasi')
@section('page-title', 'Rekap Data Koperasi')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.laporan.index') }}">Laporan</a></li>
    <li class="breadcrumb-item active">Rekap Koperasi</li>
@endsection

@section('content')

{{-- Filter --}}
<div class="card card-outline card-primary shadow-sm mb-3">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-filter mr-2"></i>Filter Laporan</h3>
    </div>
    <div class="card-body">
        <form method="GET">
            <div class="row">
                <div class="col-md-3">
                    <select name="distrik" class="form-control select2">
                        <option value="">Semua Distrik</option>
                        @foreach(\App\Models\Koperasi::listDistrik() as $d)
                            <option value="{{ $d }}" {{ request('distrik') === $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="kategori" class="form-control">
                        <option value="">Semua Kategori</option>
                        <option value="mikro"    {{ request('kategori') === 'mikro'    ? 'selected' : '' }}>Mikro</option>
                        <option value="kecil"    {{ request('kategori') === 'kecil'    ? 'selected' : '' }}>Kecil</option>
                        <option value="menengah" {{ request('kategori') === 'menengah' ? 'selected' : '' }}>Menengah</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status_verifikasi" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="pending"      {{ request('status_verifikasi') === 'pending'      ? 'selected' : '' }}>Pending</option>
                        <option value="diverifikasi" {{ request('status_verifikasi') === 'diverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="ditolak"      {{ request('status_verifikasi') === 'ditolak'      ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="tahun" class="form-control">
                        <option value="">Semua Tahun</option>
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.laporan.koperasi') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Ringkasan per Distrik --}}
<div class="row mb-3">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0 font-weight-bold"><i class="fas fa-map-marker-alt mr-2 text-primary"></i>Koperasi per Distrik</h6>
            </div>
            <div class="card-body p-0" style="max-height:250px; overflow-y:auto">
                <table class="table table-sm mb-0">
                    @foreach($koperasiPerDistrik as $d)
                    <tr>
                        <td>{{ $d->distrik }}</td>
                        <td>
                            <div class="progress" style="height:14px">
                                <div class="progress-bar bg-primary" style="width:{{ $koperasiPerDistrik->max('total') > 0 ? ($d->total / $koperasiPerDistrik->max('total') * 100) : 0 }}%"></div>
                            </div>
                        </td>
                        <td width="40"><span class="badge badge-primary">{{ $d->total }}</span></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0 font-weight-bold"><i class="fas fa-chart-pie mr-2 text-success"></i>Koperasi per Kategori</h6>
            </div>
            <div class="card-body">
                @foreach($koperasiPerKategori as $k)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="font-weight-bold text-capitalize">{{ $k->kategori }}</span>
                    <div class="d-flex align-items-center">
                        <div class="progress mr-2" style="width:120px; height:14px">
                            @php $pct = \App\Models\Koperasi::count() > 0 ? ($k->total / \App\Models\Koperasi::count() * 100) : 0; @endphp
                            <div class="progress-bar bg-{{ $k->kategori === 'mikro' ? 'primary' : ($k->kategori === 'kecil' ? 'success' : 'warning') }}"
                                 style="width:{{ $pct }}%"></div>
                        </div>
                        <span class="badge badge-{{ $k->kategori === 'mikro' ? 'primary' : ($k->kategori === 'kecil' ? 'success' : 'warning') }}">
                            {{ $k->total }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Tabel Data --}}
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-store mr-2"></i>Data Koperasi
            <span class="badge badge-primary ml-1">{{ $koperasi->total() }}</span>
        </h3>
        <div class="card-tools">
            <a href="{{ route('admin.laporan.exportExcel', array_merge(request()->query(), ['type'=>'koperasi'])) }}"
               class="btn btn-sm btn-success">
                <i class="fas fa-file-excel mr-1"></i> Export Excel
            </a>
            <a href="{{ route('admin.laporan.exportPdf', array_merge(request()->query(), ['type'=>'koperasi'])) }}"
               class="btn btn-sm btn-danger ml-1">
                <i class="fas fa-file-pdf mr-1"></i> Export PDF
            </a>
        </div>
    </div>
    <div class="card-tools">
    <a href="{{ route('admin.laporan.exportExcel', array_merge(request()->query(), ['type'=>'koperasi'])) }}"
       class="btn btn-sm btn-success">
        <i class="fas fa-file-excel mr-1"></i> Export Excel
    </a>
    <a href="{{ route('admin.laporan.exportPdf', array_merge(request()->query(), ['type'=>'koperasi'])) }}"
       class="btn btn-sm btn-danger ml-1">
        <i class="fas fa-file-pdf mr-1"></i> Export PDF
    </a>
    {{-- Tombol Word yang baru ditambah --}}
    <a href="{{ route('admin.laporan.exportWord', array_merge(request()->query(), ['type'=>'koperasi'])) }}"
       class="btn btn-sm btn-primary ml-1">
        <i class="fas fa-file-word mr-1"></i> Export Word
    </a>
</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>No. Registrasi</th>
                        <th>Nama Usaha</th>
                        <th>Pemilik</th>
                        <th>Distrik</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Modal (Rp)</th>
                        <th>Omset/Bln (Rp)</th>
                        <th>Terdaftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($koperasi as $i => $u)
                    <tr>
                        <td>{{ $koperasi->firstItem() + $i }}</td>
                        <td><small class="text-primary font-weight-bold">{{ $u->no_registrasi }}</small></td>
                        <td><strong>{{ $u->nama_usaha }}</strong><br><small class="text-muted">{{ $u->jenis_usaha }}</small></td>
                        <td><small>{{ $u->nama_pemilik }}</small></td>
                        <td><span class="badge badge-secondary">{{ $u->distrik }}</span></td>
                        <td><span class="badge badge-{{ $u->kategori === 'mikro' ? 'primary' : ($u->kategori === 'kecil' ? 'success' : 'warning') }}">{{ ucfirst($u->kategori) }}</span></td>
                        <td>{!! $u->status_verifikasi_label !!}</td>
                        <td><small>{{ number_format($u->modal_usaha, 0, ',', '.') }}</small></td>
                        <td><small>{{ number_format($u->omset_per_bulan, 0, ',', '.') }}</small></td>
                        <td><small>{{ $u->created_at->format('d/m/Y') }}</small></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">Tidak ada data ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $koperasi->links('pagination::bootstrap-4') }}
    </div>
</div>

@endsection