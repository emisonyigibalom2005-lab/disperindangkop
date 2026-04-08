
@extends("layouts.app")
@section("title","Detail Jadwal")
@section("page-title","Detail Jadwal")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{ route('petugas.jadwal.index') }}">Jadwal</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection
@section("content")
@if(session("success"))
<div class="alert alert-success alert-dismissible fade show">{{ session("success") }}<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>
@endif
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header"><h3 class="card-title">{{ $jadwal->judul }}</h3></div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6"><small class="text-muted">Tanggal</small><div class="font-weight-bold">{{ $jadwal->tanggal->format("d F Y") }}</div></div>
                    <div class="col-6"><small class="text-muted">Waktu</small><div class="font-weight-bold">{{ substr($jadwal->jam_mulai,0,5) }}{{ $jadwal->jam_selesai?" - ".substr($jadwal->jam_selesai,0,5):"" }}</div></div>
                </div>
                @if($jadwal->lokasi)<div class="mb-3"><small class="text-muted">Lokasi</small><div><i class="fas fa-map-marker-alt mr-1 text-danger"></i>{{ $jadwal->lokasi }}</div></div>@endif
                @if($jadwal->deskripsi)<div class="mb-3"><small class="text-muted">Deskripsi</small><div>{{ $jadwal->deskripsi }}</div></div>@endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header"><h3 class="card-title">Update Status</h3></div>
            <div class="card-body">
                <form action="{{ route('petugas.jadwal.updateStatus',$jadwal) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="dijadwalkan" {{ $jadwal->status=="dijadwalkan"?"selected":"" }}>Dijadwalkan</option>
                            <option value="berlangsung" {{ $jadwal->status=="berlangsung"?"selected":"" }}>Berlangsung</option>
                            <option value="selesai"     {{ $jadwal->status=="selesai"?"selected":"" }}>Selesai</option>
                            <option value="dibatalkan"  {{ $jadwal->status=="dibatalkan"?"selected":"" }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Catatan Lapangan</label>
                        <textarea name="catatan" rows="3" class="form-control">{{ $jadwal->catatan }}</textarea>
                    </div>
                    <button class="btn btn-primary w-100">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
