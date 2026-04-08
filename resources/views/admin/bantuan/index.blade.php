{{-- resources/views/admin/bantuan/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Daftar Bantuan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Daftar Bantuan</h1>
        <a href="{{ route('admin.bantuan.create') }}" class="btn btn-primary">
            + Tambah Bantuan
        </a>
    </div>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('admin.bantuan.index') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari nama / kode bantuan..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <input type="number" name="tahun" class="form-control"
                    placeholder="Tahun"
                    value="{{ request('tahun') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="aktif" @selected(request('status') == 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected(request('status') == 'nonaktif')>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Bantuan</th>
                        <th>Jenis</th>
                        <th>Tahun</th>
                        <th>Status</th>
                        <th>Dibuat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bantuan as $item)
                    <tr>
                        <td>{{ $bantuan->firstItem() + $loop->index }}</td>
                        <td>{{ $item->kode_bantuan }}</td>
                        <td>{{ $item->nama_bantuan }}</td>
                        <td>{{ ucfirst($item->jenis_bantuan) }}</td>
                        <td>{{ $item->tahun }}</td>
                        <td>
                            <span class="badge bg-{{ $item->status === 'aktif' ? 'success' : 'secondary' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->createdBy?->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.bantuan.show', $item) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('admin.bantuan.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('admin.bantuan.destroy', $item) }}" style="display:inline" onsubmit="return confirm('Hapus bantuan ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Tidak ada data bantuan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $bantuan->links() }}
    </div>
</div>
@endsection