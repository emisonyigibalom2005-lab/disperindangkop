@extends('layouts.app')
@section('title','Laporan Bantuan')
@section('page-title','Laporan Bantuan')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('pimpinan.laporan.index') }}">Laporan</a></li>
<li class="breadcrumb-item active">Bantuan</li>
@endsection
@section('content')
<div class="card shadow-sm">
<div class="card-header"><h3 class="card-title">Data Bantuan</h3></div>
<div class="card-body p-0"><table class="table table-sm mb-0">
<thead class="thead-light"><tr><th>#</th><th>Kode</th><th>Nama Program</th><th>Tahun</th><th>Anggaran</th><th>Penerima</th><th>Status</th></tr></thead>
<tbody>
@forelse($bantuan as $i => $b)
<tr><td>{{ $bantuan->firstItem()+$i }}</td><td>{{ $b->kode_bantuan }}</td><td>{{ $b->nama_bantuan }}</td><td>{{ $b->tahun }}</td><td>Rp {{ number_format($b->anggaran,0,',','.') }}</td>
<td>{{ $b->jumlah_penerima }}/{{ $b->kuota }}</td><td>{{ ucfirst($b->status) }}</td></tr>
@empty
<tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada data</td></tr>
@endforelse
</tbody></table></div>
<div class="card-footer">{{ $bantuan->links('pagination::bootstrap-4') }}</div>
</div>
@endsection
