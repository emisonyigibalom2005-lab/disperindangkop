@extends('layouts.app')

@section('title', 'Data Koperasi')
@section('page-title', 'Menunggu verifikasi')
@section('breadcrumb')
    <li class="breadcrumb-item active">Data Koperasi</li>
@endsection

@section('content')
{{-- Filter & Search --}}
<div class="card card-outline card-primary shadow-sm mb-3">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-filter mr-2"></i>Filter & Pencarian</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.koperasi.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <input type="text" name="search" class="form-control"
                               placeholder="Nama, No. KTP, No. Reg..." value="{{ $filters['search'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="status_verifikasi" class="form-control">
                        <option value="">Semua Status Verifikasi</option>
                        <option value="pending" {{ ($filters['status_verifikasi'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diverifikasi" {{ ($filters['status_verifikasi'] ?? '') === 'diverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="ditolak" {{ ($filters['status_verifikasi'] ?? '') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status_usaha" class="form-control">
                        <option value="">Semua Status Usaha</option>
                        <option value="aktif" {{ ($filters['status_usaha'] ?? '') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ ($filters['status_usaha'] ?? '') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="distrik" class="form-control select2">
                        <option value="">Semua Distrik</option>
                        @foreach($distrik as $d)
                            <option value="{{ $d }}" {{ ($filters['distrik'] ?? '') === $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="kategori" class="form-control">
                        <option value="">Semua Kategori</option>
                        <option value="mikro" {{ ($filters['kategori'] ?? '') === 'mikro' ? 'selected' : '' }}>Usaha Mikro</option>
                        <option value="kecil" {{ ($filters['kategori'] ?? '') === 'kecil' ? 'selected' : '' }}>Usaha Kecil</option>
                        <option value="menengah" {{ ($filters['kategori'] ?? '') === 'menengah' ? 'selected' : '' }}>Usaha Menengah</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
                </div>
            </div>
            @if(array_filter($filters ?? []))
                <div class="mt-2">
                    <a href="{{ route('admin.koperasi.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-times mr-1"></i>Reset Filter
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>

{{-- Tabel Data --}}
<div class="card card-outline card-primary shadow-sm">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-store mr-2"></i>Daftar Koperasi
            <span class="badge badge-primary ml-1">{{ $koperasi->total() }}</span>
        </h3>
        <div class="card-tools">
            <a href="{{ route('admin.koperasi.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus mr-1"></i>Daftar Koperasi Baru
            </a>
            <a href="{{ route('admin.laporan.exportExcel', ['type'=>'koperasi']) }}" class="btn btn-sm btn-info ml-1">
                <i class="fas fa-file-excel mr-1"></i>Export Excel
            </a>
            <a href="{{ route('admin.laporan.exportPdf', ['type'=>'koperasi']) }}" class="btn btn-sm btn-danger ml-1">
                <i class="fas fa-file-pdf mr-1"></i>Export PDF
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>No. Registrasi</th>
                        <th>Nama Usaha / Pemilik</th>
                        <th>Jenis Usaha</th>
                        <th>Distrik</th>
                        <th>Kategori</th>
                        <th>Status Verifikasi</th>
                        <th>Status Usaha</th>
                        <th>Tanggal</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($koperasi as $i => $u)
                    <tr>
                        <td>{{ $koperasi->firstItem() + $i }}</td>
                        <td>
                            <small class="text-primary font-weight-bold">{{ $u->no_registrasi }}</small>
                        </td>
                        <td>
                            <strong>{{ $u->nama_usaha }}</strong><br>
                            <small class="text-muted"><i class="fas fa-user mr-1"></i>{{ $u->nama_pemilik }}</small>
                        </td>
                        <td><small>{{ $u->jenis_usaha }}</small></td>
                        <td><span class="badge badge-secondary">{{ $u->distrik }}</span></td>
                        <td>
                            @if($u->kategori === 'mikro')
                                <span class="badge badge-primary">Mikro</span>
                            @elseif($u->kategori === 'kecil')
                                <span class="badge badge-success">Kecil</span>
                            @else
                                <span class="badge badge-warning">Menengah</span>
                            @endif
                        </td>
                        <td>{!! $u->status_verifikasi_label !!}</td>
                        <td>{!! $u->status_usaha_label !!}</td>
                        <td><small>{{ $u->created_at->format('d/m/Y') }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.koperasi.show', $u) }}" class="btn btn-primary" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.koperasi.edit', $u) }}" class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.koperasi.destroy', $u) }}" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-delete" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                            Tidak ada data Koperasi yang ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Menampilkan {{ $koperasi->firstItem() }}–{{ $koperasi->lastItem() }} dari {{ $koperasi->total() }} data
            </small>
            {{ $koperasi->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection