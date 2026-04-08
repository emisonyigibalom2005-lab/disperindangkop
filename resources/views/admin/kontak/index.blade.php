@extends('layouts.app')
@section('title','Pesan Masuk')
@section('content')
<div class="content-header"><div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6"><h1 class="m-0">Pesan Masuk</h1></div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Pesan Masuk</li>
      </ol>
    </div>
  </div>
</div></div>
<section class="content"><div class="container-fluid">
  @if(session('success'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ session('success') }}
  </div>
  @endif
  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-envelope mr-2"></i>Daftar Pesan</h3>
      <div class="card-tools">
        <span class="badge badge-primary">{{ $pesanList->total() }} pesan</span>
      </div>
    </div>
    <div class="card-body p-0">
      <table class="table table-hover">
        <thead class="thead-light">
          <tr>
            <th width="40">#</th>
            <th>Pengirim</th>
            <th>Subjek</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th width="120">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pesanList as $i => $p)
          <tr class="{{ !$p->dibaca ? 'font-weight-bold' : '' }}">
            <td>{{ $pesanList->firstItem() + $i }}</td>
            <td>
              {{ $p->nama }}<br>
              <small class="text-muted">{{ $p->email }}</small>
            </td>
            <td>{{ $p->subjek }}</td>
            <td><small>{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y H:i') }}</small></td>
            <td>
              @if(!$p->dibaca)
                <span class="badge badge-warning">Baru</span>
              @else
                <span class="badge badge-secondary">Dibaca</span>
              @endif
            </td>
            <td>
              <a href="{{ route('admin.kontak.show', $p->id) }}" class="btn btn-xs btn-info">
                <i class="fas fa-eye"></i> Lihat
              </a>
              <form method="POST" action="{{ route('admin.kontak.destroy', $p->id) }}" style="display:inline"
                    onsubmit="return confirm('Hapus pesan ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada pesan masuk</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">{{ $pesanList->links() }}</div>
  </div>
</div></section>
@endsection
