
@extends("layouts.app")
@section("title","Jadwal Saya")
@section("page-title","Jadwal Saya")
@section("breadcrumb")
<li class="breadcrumb-item active">Jadwal</li>
@endsection
@section("content")
<div class="card shadow-sm">
    <div class="card-header"><h3 class="card-title"><i class="fas fa-calendar-check mr-2 text-success"></i>Jadwal Tugas Saya</h3></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr><th>Jadwal</th><th>Jenis</th><th>Tanggal</th><th>Lokasi</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                @forelse($jadwal as $j)
                <tr>
                    <td><strong>{{ $j->judul }}</strong></td>
                    <td><span class="badge badge-{{ $j->jenis_color }}">{{ $j->jenis_label }}</span></td>
                    <td>{{ $j->tanggal->format("d M Y") }}<small class="d-block text-muted">{{ substr($j->jam_mulai,0,5) }}</small></td>
                    <td>{{ $j->lokasi ?? "-" }}</td>
                    <td><span class="badge badge-{{ $j->status_color }}">{{ $j->status_label }}</span></td>
                    <td>
    <a href="{{ route('petugas.jadwal.show',$j) }}" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-5 text-muted">
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
