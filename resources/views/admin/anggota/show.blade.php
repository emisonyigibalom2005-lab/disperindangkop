@extends('layouts.app')
@section('title','Detail Anggota')
@section('page-title','Detail Anggota Koperasi')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.anggota.index') }}">Data Anggota</a></li>
    <li class="breadcrumb-item active">{{ $anggota->nama }}</li>
@endsection
@push('styles')
<style>
.profile-card { background:linear-gradient(135deg,#1a3a6e,#2d5aa0); border-radius:16px; padding:30px; color:white; text-align:center; }
.profile-avatar { width:110px; height:110px; border-radius:50%; border:4px solid rgba(255,255,255,.5); object-fit:cover; margin:0 auto 16px; display:block; }
.info-card { border-radius:16px; border:none; box-shadow:0 2px 15px rgba(0,0,0,.06); }
.info-card .card-header { background:white; border-bottom:2px solid #f0f4ff; border-radius:16px 16px 0 0!important; padding:16px 24px; }
.info-row { display:flex; padding:10px 0; border-bottom:1px solid #f5f7ff; font-size:13.5px; }
.info-row:last-child { border-bottom:none; }
.info-label { width:40%; color:#888; font-weight:600; }
.info-value { flex:1; color:#333; font-weight:500; }
.doc-card { border-radius:14px; padding:20px; text-align:center; border:2px solid #eef; cursor:pointer; transition:.25s; background:white; }
.doc-card:hover { border-color:#1a3a6e; transform:translateY(-4px); box-shadow:0 8px 24px rgba(26,58,110,.12); }
.doc-card i { font-size:32px; color:#1a3a6e; margin-bottom:10px; display:block; }
.doc-card .doc-title { font-weight:700; font-size:14px; color:#1a3a6e; }
.doc-card .doc-sub { font-size:11px; color:#888; margin-top:4px; }
</style>
@endpush
@section('content')
@if(session('success'))<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ session('success') }}</div>@endif

<div class="row">
    {{-- Left: Profile --}}
    <div class="col-md-4">
        <div class="profile-card mb-4">
            <img src="{{ $anggota->foto_url }}" class="profile-avatar">
            <h4 class="font-weight-bold mb-1">{{ $anggota->nama }}</h4>
            <p style="opacity:.75;font-size:14px;margin-bottom:12px">{{ $anggota->no_anggota }}</p>
            <span style="background:{{ $anggota->status==='Aktif'?'#d1fae5':'($anggota->status===\'Pending\'?\'#fef3c7\':\'#fee2e2\')' }};color:{{ $anggota->status==='Aktif'?'#065f46':'($anggota->status===\'Pending\'?\'#92400e\':\'#991b1b\')' }};padding:6px 20px;border-radius:20px;font-size:12px;font-weight:700;">
                {{ $anggota->status }}
            </span>
        </div>

        {{-- Update Status --}}
        <div class="card info-card mb-4">
            <div class="card-header"><h6 class="mb-0 font-weight-bold"><i class="fas fa-sync-alt mr-2 text-primary"></i>Update Status</h6></div>
            <div class="card-body p-3">
                <form method="POST" action="{{ route('admin.anggota.status', $anggota) }}">
                    @csrf @method('PUT')
                    <select name="status" class="form-control mb-2" style="border-radius:10px">
                        @foreach(['Aktif','Pending','Nonaktif'] as $s)
                        <option value="{{ $s }}" {{ $anggota->status==$s?'selected':'' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary btn-block" style="border-radius:10px"><i class="fas fa-save mr-1"></i>Update</button>
                </form>
            </div>
        </div>

        {{-- Actions --}}
        <div class="d-flex" style="gap:8px">
            <a href="{{ route('admin.anggota.edit', $anggota) }}" class="btn btn-warning flex-fill" style="border-radius:10px">
                <i class="fas fa-edit mr-1"></i>Edit Data
            </a>
            <form method="POST" action="{{ route('admin.anggota.destroy', $anggota) }}" onsubmit="return confirm('Hapus?')" class="flex-fill">
                @csrf @method('DELETE')
                <button class="btn btn-danger w-100" style="border-radius:10px"><i class="fas fa-trash mr-1"></i>Hapus</button>
            </form>
        </div>
    </div>

    {{-- Right: Info + Dokumen --}}
    <div class="col-md-8">
        {{-- Data Pribadi --}}
        <div class="card info-card mb-4">
            <div class="card-header"><h6 class="mb-0 font-weight-bold"><i class="fas fa-id-card mr-2 text-primary"></i>Data Pribadi</h6></div>
            <div class="card-body px-4 py-3">
                <div class="info-row"><div class="info-label">NIK</div><div class="info-value">{{ $anggota->nik }}</div></div>
                <div class="info-row"><div class="info-label">Tempat, Tgl Lahir</div><div class="info-value">{{ $anggota->tempat_lahir }}, {{ $anggota->tanggal_lahir->format('d M Y') }} ({{ $anggota->umur }} thn)</div></div>
                <div class="info-row"><div class="info-label">Jenis Kelamin</div><div class="info-value">{{ $anggota->jenis_kelamin==='L'?'Laki-laki':'Perempuan' }}</div></div>
                <div class="info-row"><div class="info-label">Agama</div><div class="info-value">{{ $anggota->agama }}</div></div>
                <div class="info-row"><div class="info-label">No HP</div><div class="info-value">{{ $anggota->no_hp }}</div></div>
                <div class="info-row"><div class="info-label">Email</div><div class="info-value">{{ $anggota->email ?? '-' }}</div></div>
                <div class="info-row"><div class="info-label">Distrik</div><div class="info-value">{{ $anggota->desa ? $anggota->desa.', ' : '' }}{{ $anggota->distrik }}, {{ $anggota->kabupaten }}</div></div>
            </div>
        </div>

        {{-- Data Usaha --}}
        <div class="card info-card mb-4">
            <div class="card-header"><h6 class="mb-0 font-weight-bold"><i class="fas fa-store mr-2 text-success"></i>Data Usaha</h6></div>
            <div class="card-body px-4 py-3">
                <div class="info-row"><div class="info-label">Nama Usaha</div><div class="info-value"><strong>{{ $anggota->nama_usaha }}</strong></div></div>
                <div class="info-row"><div class="info-label">Modal Usaha</div><div class="info-value text-success font-weight-bold">Rp {{ number_format($anggota->modal_usaha,0,',','.') }}</div></div>
                <div class="info-row"><div class="info-label">Omzet/Bulan</div><div class="info-value text-success font-weight-bold">Rp {{ number_format($anggota->omzet_per_bulan,0,',','.') }}</div></div>
                <div class="info-row"><div class="info-label">Total Simpanan</div><div class="info-value text-primary font-weight-bold">Rp {{ number_format($anggota->total_simpanan,0,',','.') }}</div></div>
                <div class="info-row"><div class="info-label">Keterangan</div><div class="info-value">{{ $anggota->keterangan_usaha ?? '-' }}</div></div>
            </div>
        </div>

        {{-- Pilih Dokumen --}}
        <div class="card info-card">
            <div class="card-header"><h6 class="mb-0 font-weight-bold"><i class="fas fa-print mr-2 text-info"></i>Pilih Dokumen yang akan Dicetak</h6></div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.anggota.sertifikat', $anggota) }}" target="_blank" class="text-decoration-none">
                            <div class="doc-card"><i class="fas fa-id-badge"></i><div class="doc-title">Kartu Anggota</div><div class="doc-sub">Kartu Resmi</div></div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.anggota.sertifikat', $anggota) }}?type=detail" target="_blank" class="text-decoration-none">
                            <div class="doc-card"><i class="fas fa-file-alt"></i><div class="doc-title">Detail Anggota</div><div class="doc-sub">Data Lengkap</div></div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.anggota.sertifikat', $anggota) }}?type=simpanan" target="_blank" class="text-decoration-none">
                            <div class="doc-card"><i class="fas fa-coins"></i><div class="doc-title">Laporan Simpanan</div><div class="doc-sub">Riwayat & Total</div></div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.anggota.sertifikat', $anggota) }}?type=premium" target="_blank" class="text-decoration-none">
                            <div class="doc-card" style="border-color:#f5a623"><i class="fas fa-award" style="color:#f5a623"></i><div class="doc-title" style="color:#f5a623">Sertifikat Premium</div><div class="doc-sub">Desain Emas</div></div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.anggota.sertifikat', $anggota) }}?type=biodata" target="_blank" class="text-decoration-none">
                            <div class="doc-card"><i class="fas fa-user-tie"></i><div class="doc-title">Biodata Lengkap</div><div class="doc-sub">Format Formal</div></div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.anggota.sertifikat', $anggota) }}?type=kontrak" target="_blank" class="text-decoration-none">
                            <div class="doc-card"><i class="fas fa-file-contract"></i><div class="doc-title">Kontrak</div><div class="doc-sub">Perjanjian</div></div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.anggota.sertifikat', $anggota) }}?type=semua" target="_blank" class="text-decoration-none">
                            <div class="doc-card"><i class="fas fa-print"></i><div class="doc-title">Semua Dokumen</div><div class="doc-sub">Cetak Semua</div></div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.anggota.sertifikat', $anggota) }}?type=halaman" target="_blank" class="text-decoration-none">
                            <div class="doc-card"><i class="fas fa-desktop"></i><div class="doc-title">Halaman Ini</div><div class="doc-sub">Tampilan Saat Ini</div></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection