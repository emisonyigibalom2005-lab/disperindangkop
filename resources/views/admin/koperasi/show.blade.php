@extends('layouts.app')

@section('title', 'Detail Koperasi - ' . $koperasi->nama_usaha)
@section('page-title', 'Detail Data Koperasi')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.koperasi.index') }}">Data Koperasi</a></li>
    <li class="breadcrumb-item active">{{ $koperasi->nama_usaha }}</li>
@endsection

@section('content')
<div class="row">
    {{-- Kolom Kiri --}}
    <div class="col-lg-4">
        {{-- Info Singkat --}}
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-body text-center pt-4">
                <i class="fas fa-store fa-4x text-primary mb-3"></i>
                <h4 class="font-weight-bold mb-1">{{ $koperasi->nama_usaha }}</h4>
                <p class="text-muted mb-2">{{ $koperasi->jenis_usaha }}</p>
                <span class="badge badge-lg p-2 mb-3
                    {{ $koperasi->kategori === 'mikro' ? 'badge-primary' : ($koperasi->kategori === 'kecil' ? 'badge-success' : 'badge-warning') }}">
                    {{ strtoupper($koperasi->kategori) }}
                </span>
                <br>
                {!! $koperasi->status_verifikasi_label !!}
                {!! $koperasi->status_usaha_label !!}
            </div>
            <div class="card-footer p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">No. Registrasi</span>
                        <span class="font-weight-bold text-primary">{{ $koperasi->no_registrasi }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">No. KTP</span>
                        <span>{{ $koperasi->no_ktp }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Distrik</span>
                        <span><span class="badge badge-secondary">{{ $koperasi->distrik }}</span></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Kelurahan</span>
                        <span>{{ $koperasi->kelurahan }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Terdaftar</span>
                        <span>{{ $koperasi->created_at->format('d M Y') }}</span>
                    </li>
                    @if($koperasi->verified_at)
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Diverifikasi</span>
                        <span>{{ $koperasi->verified_at->format('d M Y') }}</span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- Aksi --}}
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0 font-weight-bold"><i class="fas fa-cogs mr-2"></i>Aksi</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.koperasi.edit', $koperasi) }}" class="btn btn-warning btn-block mb-2">
                    <i class="fas fa-edit mr-2"></i>Edit Data Koperasi
                </a>
                <a href="{{ route('admin.koperasi.dokumen', $koperasi) }}" class="btn btn-info btn-block mb-2">
                    <i class="fas fa-folder-open mr-2"></i>Kelola Dokumen
                </a>
                <form method="POST" action="{{ route('admin.koperasi.toggleStatus', $koperasi) }}">
                    @csrf
                    <button type="submit" class="btn btn-{{ $koperasi->status_usaha === 'aktif' ? 'secondary' : 'success' }} btn-block mb-2">
                        <i class="fas fa-{{ $koperasi->status_usaha === 'aktif' ? 'ban' : 'check' }} mr-2"></i>
                        {{ $koperasi->status_usaha === 'aktif' ? 'Nonaktifkan Usaha' : 'Aktifkan Usaha' }}
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.koperasi.destroy', $koperasi) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block btn-delete">
                        <i class="fas fa-trash mr-2"></i>Hapus Data
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan --}}
    <div class="col-lg-8">
        {{-- Verifikasi --}}
        @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
        <div class="card card-warning card-outline shadow-sm mb-3">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-clipboard-check mr-2"></i>Verifikasi Koperasi</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.koperasi.verifikasi', $koperasi) }}">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold">Keputusan Verifikasi</label>
                        <div class="d-flex gap-3">
                            <div class="custom-control custom-radio mr-4">
                                <input type="radio" id="verif_setuju" name="status" value="diverifikasi" class="custom-control-input" required>
                                <label class="custom-control-label text-success font-weight-bold" for="verif_setuju">
                                    <i class="fas fa-check-circle mr-1"></i>Setujui & Verifikasi
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="verif_tolak" name="status" value="ditolak" class="custom-control-input" required>
                                <label class="custom-control-label text-danger font-weight-bold" for="verif_tolak">
                                    <i class="fas fa-times-circle mr-1"></i>Tolak
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Catatan (opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3"
                                  placeholder="Catatan verifikasi atau alasan penolakan..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane mr-2"></i>Simpan Keputusan
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- Detail Pemilik --}}
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0 font-weight-bold"><i class="fas fa-user mr-2"></i>Data Pemilik Usaha</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr><th width="40%">Nama Pemilik</th><td>{{ $koperasi->nama_pemilik }}</td></tr>
                            <tr><th>No. KTP</th><td>{{ $koperasi->no_ktp }}</td></tr>
                            <tr><th>Telepon</th><td>{{ $koperasi->no_telp ?? '-' }}</td></tr>
                            <tr><th>Email</th><td>{{ $koperasi->email ?? '-' }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr><th width="40%">Alamat</th><td>{{ $koperasi->alamat }}</td></tr>
                            <tr><th>Distrik</th><td>{{ $koperasi->distrik }}</td></tr>
                            <tr><th>Kelurahan</th><td>{{ $koperasi->kelurahan }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Usaha --}}
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0 font-weight-bold"><i class="fas fa-chart-line mr-2"></i>Data Usaha</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr><th width="50%">Nama Usaha</th><td>{{ $koperasi->nama_usaha }}</td></tr>
                            <tr><th>Jenis Usaha</th><td>{{ $koperasi->jenis_usaha }}</td></tr>
                            <tr><th>Kategori</th><td>{{ $koperasi->kategori_label }}</td></tr>
                            <tr><th>Jumlah Karyawan</th><td>{{ $koperasi->jumlah_karyawan }} orang</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr><th width="50%">Modal Usaha</th><td>Rp {{ number_format($koperasi->modal_usaha, 0, ',', '.') }}</td></tr>
                            <tr><th>Omset/Bulan</th><td>Rp {{ number_format($koperasi->omset_per_bulan, 0, ',', '.') }}</td></tr>
                        </table>
                    </div>
                </div>
                @if($koperasi->catatan_verifikasi)
                <div class="alert alert-{{ $koperasi->status_verifikasi === 'ditolak' ? 'danger' : 'info' }} mt-2">
                    <strong>Catatan Verifikasi:</strong> {{ $koperasi->catatan_verifikasi }}
                </div>
                @endif
            </div>
        </div>

        {{-- Riwayat Bantuan --}}
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0 font-weight-bold"><i class="fas fa-history mr-2"></i>Riwayat Bantuan</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Program Bantuan</th>
                            <th>Tahun</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($koperasi->penerimaBantuan as $pb)
                        <tr>
                            <td>{{ $pb->bantuan->nama_bantuan }}</td>
                            <td>{{ $pb->bantuan->tahun }}</td>
                            <td>
                                @if($pb->jumlah_bantuan > 0)
                                    Rp {{ number_format($pb->jumlah_bantuan, 0, ',', '.') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $pb->status === 'diterima' ? 'success' : ($pb->status === 'divalidasi' ? 'info' : ($pb->status === 'ditolak' ? 'danger' : 'warning')) }}">
                                    {{ ucfirst($pb->status) }}
                                </span>
                            </td>
                            <td>
                                <small>{{ $pb->tanggal_penerimaan ? $pb->tanggal_penerimaan->format('d M Y') : '-' }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">Belum ada riwayat bantuan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection