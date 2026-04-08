@extends('layouts.app')
@section('title','Detail Pesan')
@section('content')
<div class="content-header"><div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6"><h1 class="m-0">Detail Pesan</h1></div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
     <a href="{{ route('admin.kontak.index') }}">Pesan Masuk</a>        <li class="breadcrumb-item active">Detail</li>
      </ol>
    </div>
  </div>
</div></div>
<section class="content"><div class="container-fluid">
  <div class="card card-primary card-outline">
    <div class="card-header"><h3 class="card-title"><i class="fas fa-envelope-open mr-2"></i>{{ $pesan->subjek }}</h3></div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-6">
          <table class="table table-sm table-borderless">
            <tr><th width="120">Dari</th><td>{{ $pesan->nama }}</td></tr>
            <tr><th>Email</th><td><a href="mailto:{{ $pesan->email }}">{{ $pesan->email }}</a></td></tr>
            <tr><th>Telepon</th><td>{{ $pesan->telepon ?? '-' }}</td></tr>
            <tr><th>Tanggal</th><td>{{ \Carbon\Carbon::parse($pesan->created_at)->format('d M Y H:i') }}</td></tr>
          </table>
        </div>
      </div>
      <div class="form-group">
        <label class="font-weight-bold">Pesan:</label>
        <div class="p-3 bg-light rounded" style="white-space:pre-wrap;line-height:1.8">{{ $pesan->pesan }}</div>
      </div>
    </div>
    <div class="card-footer">
      <a href="mailto:{{ $pesan->email }}?subject=Re: {{ $pesan->subjek }}" class="btn btn-primary">
        <i class="fas fa-reply mr-1"></i> Balas via Email
      </a>
      <a href="{{ route('admin.kontak.index') }}" class="btn btn-secondary ml-2">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
      </a>
      <form method="POST" action="{{ route('admin.kontak.destroy', $pesan->id) }}" style="display:inline"
            onsubmit="return confirm('Hapus pesan ini?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger ml-2"><i class="fas fa-trash mr-1"></i> Hapus</button>
      </form>
    </div>
  </div>
</div></section>
@endsection
