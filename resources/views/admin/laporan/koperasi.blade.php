@extends('layouts.app')
@section('title', 'Laporan Koperasi')
@section('content')
<div class="content-header"><div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6"><h1 class="m-0">Laporan Koperasi</h1></div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.laporan.index') }}">Laporan</a></li>
        <li class="breadcrumb-item active">Koperasi</li>
      </ol>
    </div>
  </div>
</div></div>
<section class="content"><div class="container-fluid">

  {{-- Statistik --}}
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card card-primary card-outline">
        <div class="card-body text-center">
          <h1 class="text-primary">{{ $koperasi->total() }}</h1>
          <p class="mb-0 font-weight-bold">Total Koperasi</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-success card-outline">
        <div class="card-body text-center">
          <h1 class="text-success">{{ $koperasiPerDistrik->count() }}</h1>
          <p class="mb-0 font-weight-bold">Distrik Terjangkau</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-warning card-outline">
        <div class="card-body text-center">
          <h1 class="text-warning">{{ $koperasiPerKategori->count() }}</h1>
          <p class="mb-0 font-weight-bold">Jenis Koperasi</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    {{-- Per Distrik --}}
    <div class="col-md-6 mb-4">
      <div class="card card-outline card-primary">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-map-marker-alt mr-2"></i>Per Distrik</h3></div>
        <div class="card-body p-0">
          <table class="table table-sm">
            <thead class="thead-light"><tr><th>Distrik</th><th class="text-center">Total</th></tr></thead>
            <tbody>
              @foreach($koperasiPerDistrik as $d)
              <tr>
                <td>{{ $d->distrik }}</td>
                <td class="text-center"><span class="badge badge-primary">{{ $d->total }}</span></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Per Kategori --}}
    <div class="col-md-6 mb-4">
      <div class="card card-outline card-success">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-tags mr-2"></i>Per Kategori</h3></div>
        <div class="card-body p-0">
          <table class="table table-sm">
            <thead class="thead-light"><tr><th>Kategori</th><th class="text-center">Total</th></tr></thead>
            <tbody>
              @foreach($koperasiPerKategori as $k)
              <tr>
                <td>{{ $k->kategori ?? 'Tidak ada kategori' }}</td>
                <td class="text-center"><span class="badge badge-success">{{ $k->total }}</span></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Tabel Data --}}
  <div class="card card-outline card-primary">
    <div class="card-header"><h3 class="card-title"><i class="fas fa-list mr-2"></i>Data Koperasi</h3></div>
    <div class="card-body p-0">
      <table class="table table-hover">
        <thead class="thead-light">
          <tr><th>#</th><th>Nama Koperasi</th><th>Distrik</th><th>Kategori</th><th>Status</th></tr>
        </thead>
        <tbody>
          @forelse($koperasi as $i => $k)
          <tr>
            <td>{{ $koperasi->firstItem() + $i }}</td>
            <td><strong>{{ $k->nama ?? $k->nama_koperasi ?? '-' }}</strong></td>
            <td>{{ $k->distrik ?? '-' }}</td>
            <td>{{ $k->kategori ?? '-' }}</td>
            <td>
              <span class="badge badge-{{ ($k->status ?? '') == 'aktif' ? 'success' : 'secondary' }}">
                {{ ucfirst($k->status ?? 'aktif') }}
              </span>
            </td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data koperasi</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">{{ $koperasi->links() }}</div>
  </div>

</div></section>
@endsection
