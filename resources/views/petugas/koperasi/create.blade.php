@extends('layouts.app')

@section('title', 'Daftar Koperasi Baru')
@section('page-title', 'Daftar Koperasi Baru')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('petugas.koperasi.index') }}">Data Koperasi</a></li>
    <li class="breadcrumb-item active">Daftar Baru</li>
@endsection

@section('content')
<form action="{{ route('petugas.koperasi.store') }}" method="POST">
@csrf

<div class="row">
    {{-- Kolom Kiri --}}
    <div class="col-lg-6">

        {{-- Data Pemilik --}}
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user mr-2"></i>Data Pemilik Usaha
                </h3>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label>Nama Lengkap Pemilik <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pemilik"
                           class="form-control @error('nama_pemilik') is-invalid @enderror"
                           placeholder="Nama lengkap sesuai KTP"
                           value="{{ old('nama_pemilik') }}" required>
                    @error('nama_pemilik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nomor KTP <span class="text-danger">*</span></label>
                    <input type="text" name="no_ktp"
                           class="form-control @error('no_ktp') is-invalid @enderror"
                           placeholder="16 digit nomor KTP"
                           value="{{ old('no_ktp') }}" maxlength="20" required>
                    @error('no_ktp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="no_telp"
                           class="form-control @error('no_telp') is-invalid @enderror"
                           placeholder="Contoh: 081234567890"
                           value="{{ old('no_telp') }}">
                    @error('no_telp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="email@example.com"
                           value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea name="alamat" rows="3"
                              class="form-control @error('alamat') is-invalid @enderror"
                              placeholder="Alamat lengkap tempat tinggal" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Distrik <span class="text-danger">*</span></label>
                            <select name="distrik" class="form-control select2 @error('distrik') is-invalid @enderror" required>
                                <option value="">-- Pilih Distrik --</option>
                                @foreach($distrik as $d)
                                    <option value="{{ $d }}" {{ old('distrik') === $d ? 'selected' : '' }}>
                                        {{ $d }}
                                    </option>
                                @endforeach
                            </select>
                            @error('distrik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kelurahan/Kampung <span class="text-danger">*</span></label>
                            <input type="text" name="kelurahan"
                                   class="form-control @error('kelurahan') is-invalid @enderror"
                                   placeholder="Nama kelurahan/kampung"
                                   value="{{ old('kelurahan') }}" required>
                            @error('kelurahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- Kolom Kanan --}}
    <div class="col-lg-6">

        {{-- Data Usaha --}}
        <div class="card card-success card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-store mr-2"></i>Data Usaha
                </h3>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label>Nama Usaha <span class="text-danger">*</span></label>
                    <input type="text" name="nama_usaha"
                           class="form-control @error('nama_usaha') is-invalid @enderror"
                           placeholder="Nama usaha/toko"
                           value="{{ old('nama_usaha') }}" required>
                    @error('nama_usaha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Jenis Usaha <span class="text-danger">*</span></label>
                    <input type="text" name="jenis_usaha"
                           class="form-control @error('jenis_usaha') is-invalid @enderror"
                           placeholder="Contoh: Kuliner, Perdagangan, Kerajinan..."
                           value="{{ old('jenis_usaha') }}" required>
                    @error('jenis_usaha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Kategori Usaha <span class="text-danger">*</span></label>
                    <select name="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="mikro"    {{ old('kategori') === 'mikro'    ? 'selected' : '' }}>Usaha Mikro (Omset &lt; 300 Juta/Tahun)</option>
                        <option value="kecil"    {{ old('kategori') === 'kecil'    ? 'selected' : '' }}>Usaha Kecil (Omset 300Jt - 2.5 M/Tahun)</option>
                        <option value="menengah" {{ old('kategori') === 'menengah' ? 'selected' : '' }}>Usaha Menengah (Omset 2.5M - 50M/Tahun)</option>
                    </select>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Modal Usaha (Rp)</label>
                            <input type="number" name="modal_usaha"
                                   class="form-control @error('modal_usaha') is-invalid @enderror"
                                   placeholder="0"
                                   value="{{ old('modal_usaha', 0) }}" min="0">
                            @error('modal_usaha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Omset per Bulan (Rp)</label>
                            <input type="number" name="omset_per_bulan"
                                   class="form-control @error('omset_per_bulan') is-invalid @enderror"
                                   placeholder="0"
                                   value="{{ old('omset_per_bulan', 0) }}" min="0">
                            @error('omset_per_bulan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Jumlah Karyawan</label>
                    <input type="number" name="jumlah_karyawan"
                           class="form-control @error('jumlah_karyawan') is-invalid @enderror"
                           placeholder="0"
                           value="{{ old('jumlah_karyawan', 0) }}" min="0">
                    @error('jumlah_karyawan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Info --}}
        <div class="card card-info card-outline shadow-sm">
            <div class="card-body py-3">
                <p class="mb-1" style="font-size:13px">
                    <i class="fas fa-info-circle text-info mr-2"></i>
                    Nomor registrasi akan digenerate otomatis oleh sistem.
                </p>
                <p class="mb-0" style="font-size:13px">
                    <i class="fas fa-info-circle text-info mr-2"></i>
                    Status verifikasi awal adalah <strong>Pending</strong> — perlu diverifikasi oleh petugas.
                </p>
            </div>
        </div>

        {{-- Tombol --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <button type="submit" class="btn btn-success btn-block py-2">
                    <i class="fas fa-save mr-2"></i> Simpan Data Koperasi
                </button>
                <a href="{{ route('petugas.koperasi.index') }}" class="btn btn-secondary btn-block py-2">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

    </div>
</div>

</form>
@endsection