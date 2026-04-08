@extends('layouts.app')
@section('title','Pengajuan Bantuan Modal')
@section('page-title','Pengajuan Bantuan Modal')
@section('breadcrumb')
    <li class="breadcrumb-item active">Pengajuan Bantuan Modal</li>
@endsection
@section('content')
@if(session('success'))<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ session('success') }}</div>@endif
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-hand-holding-usd mr-2"></i>Daftar Pengajuan Bantuan Modal</h3>
        <form method="GET" class="d-flex">
            <select name="status" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                @foreach(['menunggu'=>'Menunggu','diproses'=>'Diproses','disetujui'=>'Disetujui','ditolak'=>'Ditolak'] as $v=>$l)
                <option value="{{ $v }}" {{ request('status')==$v?'selected':'' }}>{{ $l }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr><th>#</th><th>Nama Pemohon</th><th>Usaha</th><th>Jenis Bantuan</th><th>Jumlah</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($pengajuan as $i=>$p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td><strong>{{ $p->nama_pemohon }}</strong><br><small class="text-muted">{{ $p->no_hp }}</small></td>
                <td>{{ $p->nama_usaha }}</td>
                <td><span class="badge badge-secondary">{{ ucfirst($p->jenis_bantuan) }}</span></td>
                <td>{{ $p->jumlah_diajukan ? 'Rp '.number_format($p->jumlah_diajukan,0,',','.') : '-' }}</td>
                <td><span class="badge badge-{{ $p->status==='disetujui'?'success':($p->status==='ditolak'?'danger':($p->status==='diproses'?'info':'warning')) }}">{{ ucfirst($p->status) }}</span></td>
                <td>
                    <a href="{{ route('admin.pengajuan-bantuan.show', $p) }}" class="btn btn-xs btn-primary"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.pengajuan-bantuan.show', $p) }}" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{ route('admin.pengajuan-bantuan.destroy', $p) }}" style="display:inline" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada pengajuan</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $pengajuan->links() }}</div>
</div>
@endsection