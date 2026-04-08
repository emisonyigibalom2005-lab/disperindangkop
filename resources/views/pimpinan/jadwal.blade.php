
@extends("layouts.app")
@section("title","Jadwal Kegiatan")
@section("page-title","Jadwal Kegiatan")
@section("breadcrumb")
<li class="breadcrumb-item active">Jadwal</li>
@endsection
@section("content")
<div class="card shadow-sm">
    <div class="card-header"><h3 class="card-title"><i class="fas fa-calendar-alt mr-2 text-primary"></i>Semua Jadwal Kegiatan</h3></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr><th>Jadwal</th><th>Jenis</th><th>Tanggal</th><th>Petugas</th><th>Status</th></tr>
                </thead>
                <tbody>
                @forelse($jadwal as $j)
                <tr>
                    <td><strong>{{ $j->judul }}</strong><small class="d-block text-muted">{{ $j->lokasi }}</small></td>
                    <td><span class="badge badge-{{ $j->jenis_color }}">{{ $j->jenis_label }}</span></td>
                    <td>{{ $j->tanggal->format("d M Y") }}</td>
                    <td>{{ $j->petugas->name ?? "-" }}</td>
                    <td><span class="badge badge-{{ $j->status_color }}">{{ $j->status_label }}</span></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada jadwal</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">{{ $jadwal->links("pagination::bootstrap-4") }}</div>
</div>
@endsection
