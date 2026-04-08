@extends('layouts.admin')
@section('title', 'Daftar Berita')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Daftar Berita</h1>
        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">+ Tulis Berita</a>
    </div>

    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari judul..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="publish" @selected(request('status') == 'publish')>Publish</option>
                    <option value="draft" @selected(request('status') == 'draft')>Draft</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
            </div>
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Thumbnail</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Penulis</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($berita as $item)
                    <tr>
                        <td>{{ $berita->firstItem() + $loop->index }}</td>
                        <td>
                            @if ($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                    width="60" height="40" style="object-fit:cover; border-radius:4px;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($item->judul, 50) }}</td>
                        <td>{{ ucfirst($item->kategori) }}</td>
                        <td>
                            <span class="badge bg-{{ $item->status === 'publish' ? 'success' : 'secondary' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->createdBy?->name ?? '-' }}</td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.berita.show', $item) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('admin.berita.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.berita.destroy', $item) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus berita ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Belum ada berita.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $berita->links() }}</div>
</div>
@endsection