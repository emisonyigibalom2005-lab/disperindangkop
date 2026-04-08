@extends('layouts.app')
@section('title', 'Halaman Statis')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1 class="m-0">Halaman Statis</h1></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Halaman Statis</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<section class="content">
<div class="container-fluid">
  @if(session('success'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ session('success') }}
  </div>
  @endif
  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i>Daftar Halaman Profil</h3>
      <div class="card-tools">
        <a href="{{ route('admin.halaman-statis.create') }}" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah Halaman
        </a>
      </div>
    </div>
    <div class="card-body p-0">
      <table class="table table-hover">
        <thead class="thead-light">
          <tr>
            <th width="40">#</th>
            <th>Slug</th>
            <th>Judul</th>
            <th>Icon</th>
            <th>Status</th>
            <th width="160">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($halamanList as $i => $h)
          <tr>
            <td>{{ $i+1 }}</td>
            <td><code>{{ $h->slug }}</code></td>
            <td>{{ $h->judul }}</td>
            <td><i class="{{ $h->icon }}"></i> <small>{{ $h->icon }}</small></td>
            <td>
              @if($h->status === 'aktif')
                <span class="badge badge-success">Aktif</span>
              @else
                <span class="badge badge-secondary">Nonaktif</span>
              @endif
            </td>
            <td>
              <a href="{{ route('admin.halaman-statis.edit', $h) }}" class="btn btn-xs btn-warning">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form method="POST" action="{{ route('admin.halaman-statis.destroy', $h) }}" style="display:inline"
                    onsubmit="return confirm('Hapus?')">
                @csrf @method('DELETE')
                <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
              </form>
              <a href="{{ route('public.halaman', $h->slug) }}" target="_blank" class="btn btn-xs btn-info">
                <i class="fas fa-eye"></i>
              </a>
            </td>
          </tr>
          @empty

          <tr>
            <td colspan="6" class="text-center text-muted py-4">
              Belum ada halaman.
              <a href="{{ route('admin.halaman-statis.create') }}">Tambah sekarang</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
</section>
@endsection
