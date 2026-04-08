@extends('layouts.app')
@section('title','Detail Bantuan')
@section('page-title','Detail Bantuan')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('petugas.bantuan.index') }}">Bantuan</a></li>
<li class="breadcrumb-item active">{{ $bantuan->kode_bantuan }}</li>
@endsection
@section('content')
<div class="row">
<div class="col-lg-4">
<div class="card card-success card-outline shadow-sm">
<div class="card-body text-center pt-4">
<i class="fas fa-hand-holding-usd fa-4x text-success mb-3"></i>
<h4 class="font-weight-bold">{{ $bantuan->nama_bantuan }}</h4>
<p class="text-muted">{{ $bantuan->kode_bantuan }}</p>
</div>
<div class="card-footer p-0"><ul class="list-group list-group-flush">
<li class="list-group-item d-flex justify-content-between"><span class="text-muted">Anggaran</span><span>Rp {{ number_format($bantuan->anggaran,0,',','.') }}</span></li>
<li class="list-group-item d-flex justify-content-between"><span class="text-muted">Kuota</span><span>{{ $bantuan->kuota }}</span></li>
<li class="list-group-item d-flex justify-content-between"><span class="text-muted">Penerima</span><span class="badge badge-{{ $bantuan->jumlah_penerima>=$bantuan->kuota?'danger':'success' }}">{{ $bantuan->jumlah_penerima }}/{{ $bantuan->kuota }}</span></li>
</ul></div>
</div>
</div>
<div class="col-lg-8">
@if($bantuan->status==='aktif' && $bantuan->jumlah_penerima < $bantuan->kuota)
<div class="card card-success card-outline shadow-sm mb-3">
<div class="card-header"><h6 class="mb-0 font-weight-bold">Tambah Penerima</h6></div>
<div class="card-body">
<form method="POST" action="{{ route('petugas.bantuan.tambahPenerima',$bantuan) }}">@csrf
<div class="row">
<div class="col-md-5"><select name="koperasi_id" class="form-control select2" required><option value="">-- Pilih Koperasi --</option>@foreach($koperasiTersedia as $u)<option value="{{ $u->id }}">{{ $u->nama_usaha }} ({{ $u->nama_pemilik }})</option>@endforeach</select></div>
<div class="col-md-4"><input type="number" name="jumlah_bantuan" class="form-control" placeholder="Jumlah bantuan (Rp)" min="0" required></div>
<div class="col-md-3"><button type="submit" class="btn btn-success btn-block">Tambah</button></div>
</div></form>
</div>
</div>
@endif
<div class="card shadow-sm">
<div class="card-header bg-light"><h6 class="mb-0 font-weight-bold">Daftar Penerima</h6></div>
<div class="card-body p-0"><table class="table table-sm mb-0">
<thead class="thead-light"><tr><th>#</th><th>Nama Usaha</th><th>Distrik</th><th>Jumlah (Rp)</th><th>Status</th><th>Aksi</th></tr></thead>
<tbody>
@forelse($bantuan->penerima as $i => $p)
<tr><td>{{ $i+1 }}</td><td>{{ $p->koperasi->nama_usaha }}</td><td>{{ $p->koperasi->distrik }}</td><td>{{ number_format($p->jumlah_bantuan,0,',','.') }}</td>
<td><span class="badge badge-{{ $p->status==='diterima'?'success':($p->status==='ditolak'?'danger':'warning') }}">{{ ucfirst($p->status) }}</span></td>
<td>@if($p->status!=='diterima')<form method="POST" action="{{ route('petugas.bantuan.validasiPenerima',$p) }}" style="display:inline">@csrf<input type="hidden" name="status" value="diterima"><button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check"></i></button></form>@endif</td></tr>
@empty
<tr><td colspan="6" class="text-center py-3 text-muted">Belum ada penerima</td></tr>
@endforelse
</tbody></table>
</div>
</div>
</div>
</div>
@endsection
