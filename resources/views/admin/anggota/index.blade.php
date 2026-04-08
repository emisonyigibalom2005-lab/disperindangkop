@extends('layouts.app')
@section('title','Membuat Kartu,Dokumen & Dll ')
@section('page-title','Data Anggota Koperasi')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Koperasi</a></li>
    <li class="breadcrumb-item active">Data Anggota</li>
@endsection
@push('styles')
<style>
.stat-card { border-radius:16px; padding:24px; color:white; position:relative; overflow:hidden; transition:.3s; }
.stat-card:hover { transform:translateY(-4px); box-shadow:0 12px 30px rgba(0,0,0,.2); }
.stat-card .icon { position:absolute; right:16px; top:16px; font-size:48px; opacity:.2; }
.stat-card .number { font-size:2.2rem; font-weight:800; line-height:1; }
.stat-card .label { font-size:12px; opacity:.85; font-weight:600; letter-spacing:.5px; text-transform:uppercase; margin-top:6px; }
.stat-card .sub { font-size:12px; opacity:.75; margin-top:8px; }
.table-anggota thead th { background:#1a3a6e; color:white; font-size:12px; font-weight:600; letter-spacing:.3px; padding:12px 10px; border:none; }
.table-anggota tbody tr { transition:.2s; }
.table-anggota tbody tr:hover { background:#f0f4ff; }
.badge-status { padding:5px 12px; border-radius:20px; font-size:11px; font-weight:700; }
.btn-action { width:30px; height:30px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; border:none; cursor:pointer; transition:.2s; font-size:13px; }
.btn-action:hover { transform:scale(1.1); }
.search-box { border-radius:50px; border:2px solid #e0e6ff; padding:8px 20px; font-size:14px; transition:.3s; }
.search-box:focus { border-color:#1a3a6e; box-shadow:0 0 0 3px rgba(26,58,110,.1); }
</style>
@endpush
@section('content')
@if(session('success'))<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ session('success') }}</div>@endif

{{-- Stats Cards --}}
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#1a3a6e,#2d5aa0)">
            <i class="fas fa-users icon"></i>
            <div class="number">{{ $stats['total'] }}</div>
            <div class="label">Total Anggota</div>
            <div class="sub"><i class="fas fa-arrow-up mr-1"></i>+{{ $stats['pending'] }} anggota baru</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#1e8449,#27ae60)">
            <i class="fas fa-user-check icon"></i>
            <div class="number">{{ $stats['aktif'] }}</div>
            <div class="label">Anggota Aktif</div>
            <div class="sub"><i class="fas fa-chart-line mr-1"></i>{{ $stats['total']>0 ? round($stats['aktif']/$stats['total']*100) : 0 }}% dari total</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#c0392b,#e74c3c)">
            <i class="fas fa-user-times icon"></i>
            <div class="number">{{ $stats['nonaktif'] }}</div>
            <div class="label">Anggota Nonaktif</div>
            <div class="sub"><i class="fas fa-chart-line mr-1"></i>{{ $stats['total']>0 ? round($stats['nonaktif']/$stats['total']*100) : 0 }}% dari total</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#d35400,#e67e22)">
            <i class="fas fa-clock icon"></i>
            <div class="number">{{ $stats['pending'] }}</div>
            <div class="label">Menunggu Verifikasi</div>
            <div class="sub"><i class="fas fa-info-circle mr-1"></i>Perlu diproses</div>
        </div>
    </div>
</div>

{{-- Table Card --}}
<div class="card border-0 shadow-sm" style="border-radius:16px;overflow:hidden;">
    <div class="card-header d-flex justify-content-between align-items-center" style="background:white;border-bottom:2px solid #f0f4ff;padding:20px 24px;">
        <div>
            <h5 class="mb-0 font-weight-bold" style="color:#1a3a6e;"><i class="fas fa-users mr-2"></i>Data Anggota Koperasi</h5>
            <small class="text-muted">Kelola data anggota koperasi dengan mudah dan efisien</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary btn-sm mr-2" style="border-radius:8px;padding:8px 18px;">
                <i class="fas fa-plus mr-1"></i>Tambah Anggota
            </a>
        </div>
    </div>
    <div class="card-header" style="background:#f8f9ff;border-bottom:1px solid #eef;">
        <form method="GET" class="d-flex flex-wrap align-items-center" style="gap:10px">
            <div class="input-group" style="width:300px;">
                <input type="text" name="search" class="form-control search-box" placeholder="Cari nama, NIK, atau nomor anggota..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" style="border-radius:0 50px 50px 0"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <select name="status" class="form-control form-control-sm" style="width:150px;border-radius:8px" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                @foreach(['Aktif','Pending','Nonaktif'] as $s)
                <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ $s }}</option>
                @endforeach
            </select>
            <select name="distrik" class="form-control form-control-sm" style="width:160px;border-radius:8px" onchange="this.form.submit()">
                <option value="">Semua Distrik</option>
                @foreach($distrik as $d)
                <option value="{{ $d }}" {{ request('distrik')==$d?'selected':'' }}>{{ $d }}</option>
                @endforeach
            </select>
            @if(request('search') || request('status') || request('distrik'))
            <a href="{{ route('admin.anggota.index') }}" class="btn btn-sm btn-light" style="border-radius:8px">Reset</a>
            @endif
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-anggota mb-0">
            <thead>
                <tr>
                    <th>No. Anggota</th>
                    <th>Foto</th>
                    <th>Nama Lengkap</th>
                    <th>Tempat, Tgl Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Kontak</th>
                    <th>Desa</th>
                    <th>Nama Usaha</th>
                    <th>Modal Usaha</th>
                    <th>Total Simpanan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($anggota as $a)
            <tr>
                <td><strong class="text-primary">{{ $a->no_anggota }}</strong></td>
                <td><img src="{{ $a->foto_url }}" class="img-circle" width="38" height="38" style="object-fit:cover;border:2px solid #e0e6ff;"></td>
                <td>
                    <strong>{{ $a->nama }}</strong><br>
                    <small class="text-muted">NIK: {{ $a->nik }}</small>
                </td>
                <td>
                    <small>{{ $a->tempat_lahir }}</small><br>
                    <small class="text-muted">{{ $a->tanggal_lahir->format('d M Y') }}</small>
                </td>
                <td>
                    @if($a->jenis_kelamin === 'L')
                    <span class="badge" style="background:#dbeafe;color:#1d4ed8;padding:5px 10px;border-radius:20px;font-size:11px;"><i class="fas fa-mars mr-1"></i>Laki-laki</span>
                    @else
                    <span class="badge" style="background:#fce7f3;color:#be185d;padding:5px 10px;border-radius:20px;font-size:11px;"><i class="fas fa-venus mr-1"></i>Perempuan</span>
                    @endif
                </td>
                <td>
                    <small><i class="fab fa-whatsapp text-success mr-1"></i>{{ $a->no_hp }}</small>
                </td>
                <td><small>{{ $a->desa ?? '-' }}</small></td>
                <td>
                    <small><i class="fas fa-store mr-1 text-muted"></i>{{ Str::limit($a->nama_usaha,20) }}</small>
                </td>
                <td><small class="text-success font-weight-bold">Rp {{ number_format($a->modal_usaha,0,',','.') }}</small></td>
                <td><small class="text-primary font-weight-bold">Rp {{ number_format($a->total_simpanan,0,',','.') }}</small></td>
                <td>
                    @if($a->status === 'Aktif')
                    <span class="badge-status" style="background:#d1fae5;color:#065f46;">● Aktif</span>
                    @elseif($a->status === 'Pending')
                    <span class="badge-status" style="background:#fef3c7;color:#92400e;">● Pending</span>
                    @else
                    <span class="badge-status" style="background:#fee2e2;color:#991b1b;">● Nonaktif</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex" style="gap:4px">
                        <a href="{{ route('admin.anggota.show', $a) }}" class="btn-action" style="background:#dbeafe;color:#1d4ed8;" title="Detail"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.anggota.sertifikat', $a) }}" class="btn-action" style="background:#d1fae5;color:#065f46;" title="Sertifikat"><i class="fas fa-certificate"></i></a>
                        <a href="{{ route('admin.anggota.edit', $a) }}" class="btn-action" style="background:#fef3c7;color:#92400e;" title="Edit"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.anggota.destroy', $a) }}" style="display:inline" onsubmit="return confirm('Hapus anggota ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-action" style="background:#fee2e2;color:#991b1b;" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="12" class="text-center py-5 text-muted">
                <i class="fas fa-users fa-3x mb-3 d-block" style="opacity:.2"></i>
                Belum ada anggota koperasi
            </td></tr>
            @endforelse
            </tbody>
            @if($anggota->count() > 0)
            <tfoot>
                <tr style="background:#f0f4ff;">
                    <td colspan="8" class="text-right font-weight-bold" style="padding:12px 10px;">TOTAL</td>
                    <td class="font-weight-bold text-success">Rp {{ number_format($anggota->sum('modal_usaha'),0,',','.') }}</td>
                    <td class="font-weight-bold text-primary">Rp {{ number_format($anggota->sum('total_simpanan'),0,',','.') }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
    <div class="card-footer" style="background:#f8f9ff;">{{ $anggota->links() }}</div>
</div>
@endsection