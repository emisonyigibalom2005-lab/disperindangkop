@extends('layouts.app')
@section('title','Bantuan')
@section('page-title','Data Bantuan')
@section('breadcrumb')<li class="breadcrumb-item active">Bantuan</li>@endsection
@section('content')
<div class="card shadow-sm">
<div class="card-header"><h3 class="card-title"><i class="fas fa-hand-holding-usd mr-2"></i>Daftar Program Bantuan</h3></div>
<div class="card-body p-0"><table class="table table-hover table-sm mb-0">
<thead class="thead-light"><tr><th>#</th><th>Kode</th><th>Nama Program</th><th>Tahun</th><th>Kuota</th><th>Penerima</th><th>Status</th><th>Aksi</th></tr></thead>
<tbody>
@forelse($bantuan as $i => $b)
<tr><td>{{ $bantuan->firstItem()+$i }}</td><td><small class="text-success font-weight-bold">{{ $b->kode_bantuan }}</small></td><td>{{ $b->nama_bantuan }}</td><td>{{ $b->tahun }}</td><td>{{ $b->kuota }}</td>
<td><span class="badge badge-{{ $b->jumlah_penerima>=$b->kuota?'danger':'success' }}">{{ $b->jumlah_penerima }}/{{ $b->kuota }}</span></td>
<td><span class="badge badge-{{ $b->status==='aktif'?'success':($b->status==='selesai'?'secondary':'danger') }}">{{ ucfirst($b->status) }}</span></td>
<td><a href="{{ route('petugas.bantuan.show',$b) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a></td></tr>
@empty
<tr><td colspan="8" class="text-center py-4 text-muted">Belum ada bantuan</td></tr>
@endforelse
</tbody></table></div>
<div class="card-footer">{{ $bantuan->links('pagination::bootstrap-4') }}</div>
</div>
@endsection
