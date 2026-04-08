@extends('layouts.app')
@section('title','Peserta Pelatihan')
@section('page-title','Peserta Pelatihan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.pelatihan.index') }}">Pelatihan</a></li>
    <li class="breadcrumb-item active">Peserta</li>
@endsection
@section('content')
@if(session('success'))<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ session('success') }}</div>@endif
<div class="card card-info card-outline">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users mr-2"></i>Peserta: {{ $pelatihan->judul }}</h3>
        <div class="card-tools">
            <span class="badge badge-info">{{ $peserta->count() }} / {{ $pelatihan->kuota }} peserta</span>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr><th>#</th><th>Nama</th><th>No HP</th><th>Usaha</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($peserta as $i=>$p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td><strong>{{ $p->nama_peserta }}</strong><br><small class="text-muted">{{ $p->email }}</small></td>
                <td>{{ $p->no_hp }}</td>
                <td>{{ $p->nama_usaha ?? '-' }}</td>
                <td>
                    <span class="badge badge-{{ $p->status==='diterima'?'success':($p->status==='ditolak'?'danger':'warning') }}">{{ ucfirst($p->status) }}</span>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.pelatihan.peserta.status', $p) }}" class="d-flex gap-1">
                        @csrf @method('PUT')
                        <select name="status" class="form-control form-control-sm" style="width:120px">
                            <option value="menunggu" {{ $p->status==='menunggu'?'selected':'' }}>Menunggu</option>
                            <option value="diterima" {{ $p->status==='diterima'?'selected':'' }}>Diterima</option>
                            <option value="ditolak" {{ $p->status==='ditolak'?'selected':'' }}>Ditolak</option>
                        </select>
                        <button class="btn btn-xs btn-primary ml-1">Simpan</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada peserta</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection