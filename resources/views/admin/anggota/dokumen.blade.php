@extends('layouts.app')
@section('page-title','Dokumen & Kartu Anggota')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">📄 Dokumen & Kartu Anggota</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Dokumen Anggota</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
<div class="container-fluid">

    {{-- Search --}}
    <div class="card shadow mb-3">
        <div class="card-body">
            <form method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama atau no. anggota..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="Aktif" {{ request('status')=='Aktif'?'selected':'' }}>Aktif</option>
                            <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
                            <option value="Nonaktif" {{ request('status')=='Nonaktif'?'selected':'' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-block"><i class="fas fa-search"></i> Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Dokumen --}}
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i>Daftar Dokumen Anggota</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th>No. Anggota</th>
                        <th>Nama</th>
                        <th>Usaha</th>
                        <th>Status</th>
                        <th width="30%" class="text-center">Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($anggota as $i => $a)
                <tr>
                    <td>{{ $anggota->firstItem() + $i }}</td>
                    <td><span class="badge badge-primary">{{ $a->no_anggota }}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ $a->foto_url }}" width="35" height="35" class="rounded-circle mr-2" style="object-fit:cover">
                            <div>
                                <strong>{{ $a->nama }}</strong><br>
                                <small class="text-muted">{{ $a->distrik }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $a->nama_usaha }}</td>
                    <td>
                        <span class="badge badge-{{ $a->status === 'Aktif' ? 'success' : ($a->status === 'Pending' ? 'warning' : 'danger') }}">
                            {{ $a->status }}
                        </span>
                    </td>
                    <td class="text-center">
                        {{-- Kartu Anggota --}}
                        <a href="{{ route('admin.anggota.sertifikat', $a) }}" target="_blank"
                           class="btn btn-sm btn-info mb-1" title="Kartu Anggota">
                            <i class="fas fa-id-card mr-1"></i> Kartu
                        </a>
                        {{-- Sertifikat --}}
                        <a href="{{ route('anggota.print', $a) }}" target="_blank"
                           class="btn btn-sm btn-success mb-1" title="Sertifikat">
                            <i class="fas fa-certificate mr-1"></i> Sertifikat
                        </a>
                        {{-- Surat Keterangan --}}
                        <a href="{{ route('admin.anggota.sertifikat', $a) }}?surat=1" target="_blank"
                           class="btn btn-sm btn-warning mb-1" title="Surat Keterangan">
                            <i class="fas fa-file-signature mr-1"></i> Surat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <i class="fas fa-folder-open fa-2x text-muted mb-2 d-block"></i>
                        Belum ada data anggota
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($anggota->hasPages())
        <div class="card-footer">
            {{ $anggota->links() }}
        </div>
        @endif
    </div>

</div>
</section>
@endsection
