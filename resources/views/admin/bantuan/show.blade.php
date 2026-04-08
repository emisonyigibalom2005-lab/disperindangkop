{{-- resources/views/admin/bantuan/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Bantuan')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Detail Bantuan</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.bantuan.edit', $bantuan) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.bantuan.index') }}" class="btn btn-secondary">← Kembali</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Info Bantuan --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Informasi Program Bantuan</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th width="160">Kode Bantuan</th>
                            <td>{{ $bantuan->kode_bantuan }}</td>
                        </tr>
                        <tr>
                            <th>Nama Bantuan</th>
                            <td>{{ $bantuan->nama_bantuan }}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>{{ ucfirst($bantuan->jenis_bantuan) }}</td>
                        </tr>
                        <tr>
                            <th>Tahun</th>
                            <td>{{ $bantuan->tahun }}</td>
                        </tr>
                        <tr>
                            <th>Periode</th>
                            <td>{{ $bantuan->periode }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th width="160">Anggaran</th>
                            <td>Rp {{ number_format($bantuan->anggaran, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Kuota</th>
                            <td>{{ $bantuan->kuota }} Koperasi</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-{{ $bantuan->status === 'aktif' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($bantuan->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat Oleh</th>
                            <td>{{ $bantuan->createdBy?->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <td>{{ $bantuan->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    </table>
                </div>
                @if ($bantuan->deskripsi)
                <div class="col-12">
                    <hr>
                    <strong>Deskripsi:</strong>
                    <p class="mt-1 mb-0">{{ $bantuan->deskripsi }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Penerima Bantuan --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-bold">Penerima Bantuan ({{ $bantuan->penerima->count() }} / {{ $bantuan->kuota }})</span>
            @if ($bantuan->penerima->count() < $bantuan->kuota)
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPenerima">
                    + Tambah Penerima
                </button>
            @endif
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Koperasi</th>
                        <th>Pemilik</th>
                        <th>Status Penerimaan</th>
                        <th>Tanggal Ditambahkan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bantuan->penerima as $i => $penerima)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $penerima->koperasi?->nama_usaha ?? '-' }}</td>
                        <td>{{ $penerima->koperasi?->nama_pemilik ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ match($penerima->status ?? 'pending') {
                                'diterima' => 'success',
                                'ditolak'  => 'danger',
                                default    => 'warning'
                            } }}">
                                {{ ucfirst($penerima->status ?? 'pending') }}
                            </span>
                        </td>
                        <td>{{ $penerima->created_at?->format('d M Y') ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Belum ada penerima.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Jadwal Distribusi --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Jadwal Distribusi</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Petugas</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bantuan->jadwal as $i => $jadwal)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</td>
                        <td>{{ $jadwal->lokasi ?? '-' }}</td>
                        <td>{{ $jadwal->petugas?->name ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ match($jadwal->status ?? 'terjadwal') {
                                'selesai'   => 'success',
                                'batal'     => 'danger',
                                default     => 'info'
                            } }}">
                                {{ ucfirst($jadwal->status ?? 'terjadwal') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Belum ada jadwal distribusi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Modal Tambah Penerima --}}
@if ($bantuan->penerima->count() < $bantuan->kuota)
<div class="modal fade" id="modalTambahPenerima" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Penerima Bantuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.bantuan.tambahPenerima', $bantuan) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted">Pilih Koperasi yang sudah terverifikasi dan belum menjadi penerima.</p>
                    <div class="table-responsive" style="max-height: 350px; overflow-y:auto;">
                        <table class="table table-sm table-hover">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th></th>
                                    <th>Nama Usaha</th>
                                    <th>Pemilik</th>
                                    <th>Jenis Usaha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($koperasiTersedia as $koperasi)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="koperasi_ids[]" value="{{ $koperasi->id }}">
                                    </td>
                                    <td>{{ $koperasi->nama_usaha }}</td>
                                    <td>{{ $koperasi->nama_pemilik }}</td>
                                    <td>{{ $koperasi->jenis_usaha ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada Koperasi tersedia.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Penerima</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection