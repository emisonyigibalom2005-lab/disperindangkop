
@extends("layouts.app")
@section("title","Manajemen Jadwal")
@section("page-title","Jadwal")
@section("breadcrumb")
<li class="breadcrumb-item active">Jadwal</li>
@endsection
@section("content")
@if(session("success"))
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle mr-2"></i>{{ session("success") }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-calendar-alt mr-2 text-primary"></i>Daftar Jadwal</h3>
        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Buat Jadwal
        </a>
    </div>
    <div class="card-body border-bottom py-2">
        <form class="form-inline">
            <select name="jenis" class="form-control form-control-sm mr-2">
                <option value="">Semua Jenis</option>
                <option value="verifikasi" {{ request("jenis")=="verifikasi"?"selected":"" }}>Verifikasi Lapangan</option>
                <option value="pelatihan" {{ request("jenis")=="pelatihan"?"selected":"" }}>Pelatihan/Pembinaan</option>
                <option value="penilaian_bantuan" {{ request("jenis")=="penilaian_bantuan"?"selected":"" }}>Penilaian Bantuan</option>
                <option value="rapat" {{ request("jenis")=="rapat"?"selected":"" }}>Rapat/Pertemuan</option>
            </select>
            <select name="status" class="form-control form-control-sm mr-2">
                <option value="">Semua Status</option>
                <option value="dijadwalkan" {{ request("status")=="dijadwalkan"?"selected":"" }}>Dijadwalkan</option>
                <option value="berlangsung" {{ request("status")=="berlangsung"?"selected":"" }}>Berlangsung</option>
                <option value="selesai" {{ request("status")=="selesai"?"selected":"" }}>Selesai</option>
                <option value="dibatalkan" {{ request("status")=="dibatalkan"?"selected":"" }}>Dibatalkan</option>
            </select>
            <button class="btn btn-secondary btn-sm"><i class="fas fa-filter mr-1"></i>Filter</button>
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-link btn-sm">Reset</a>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Jadwal</th><th>Jenis</th><th>Tanggal</th>
                        <th>Petugas</th><th>Status</th><th>Publik</th><th width="110">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($jadwal as $j)
                <tr>
                    <td>
                        <strong>{{ $j->judul }}</strong>
                        @if($j->lokasi)<small class="d-block text-muted"><i class="fas fa-map-marker-alt mr-1"></i>{{ $j->lokasi }}</small>@endif
                    </td>
                    <td><span class="badge badge-{{ $j->jenis_color }}">{{ $j->jenis_label }}</span></td>
                    <td>
                        <strong>{{ $j->tanggal->format("d M Y") }}</strong>
                        <small class="d-block text-muted">{{ substr($j->jam_mulai,0,5) }}{{ $j->jam_selesai ? " - ".substr($j->jam_selesai,0,5) : "" }}</small>
                    </td>
                    <td>{{ $j->petugas->name ?? "-" }}</td>
                    <td><span class="badge badge-{{ $j->status_color }}">{{ $j->status_label }}</span></td>
                    <td>
                        @if($j->is_publik)
                            <span class="badge badge-success"><i class="fas fa-globe"></i> Ya</span>
                        @else
                            <span class="badge badge-secondary">Internal</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.jadwal.show',$j) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.jadwal.edit',$j) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.jadwal.destroy',$j) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf @method("DELETE")
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-5 text-muted">
                    <i class="fas fa-calendar-times fa-3x d-block mb-2" style="opacity:.2"></i>Belum ada jadwal
                </td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">{{ $jadwal->links("pagination::bootstrap-4") }}</div>
</div>
@endsection
