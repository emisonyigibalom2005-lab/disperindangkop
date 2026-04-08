@extends('layouts.app')
@section('title','Edit Anggota')
@section('page-title','Edit Anggota Koperasi')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.anggota.index') }}">Anggota</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')
<div class="card card-warning card-outline">
    <div class="card-header"><h3 class="card-title"><i class="fas fa-edit mr-2"></i>Edit: {{ $anggota->nama }}</h3></div>
    <form method="POST" action="{{ route('admin.anggota.update', $anggota) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="font-weight-bold text-primary mb-3">Data Pribadi</h6>
                    <div class="form-group">
                        <label>No. Anggota</label>
                        <input type="text" class="form-control bg-light" value="{{ $anggota->no_anggota }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik',$anggota->nik) }}" maxlength="16" required>
                        @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama',$anggota->nama) }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir',$anggota->tempat_lahir) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir',$anggota->tanggal_lahir->format('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="L" {{ old('jenis_kelamin',$anggota->jenis_kelamin)=='L'?'selected':'' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin',$anggota->jenis_kelamin)=='P'?'selected':'' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Agama</label>
                                <select name="agama" class="form-control">
                                    @foreach(['Kristen','Islam','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                                    <option value="{{ $ag }}" {{ old('agama',$anggota->agama)==$ag?'selected':'' }}>{{ $ag }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp',$anggota->no_hp) }}">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email',$anggota->email) }}">
                    </div>
                    <div class="form-group">
                        <label>Foto</label>
                        @if($anggota->foto)
                        <div class="mb-2"><img src="{{ $anggota->foto_url }}" class="img-circle" width="60" height="60" style="object-fit:cover;"><small class="text-muted ml-2">Foto saat ini</small></div>
                        @endif
                        <div class="custom-file">
                            <input type="file" name="foto" class="custom-file-input" id="foto" accept="image/*">
                            <label class="custom-file-label" for="foto">Ganti foto...</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="font-weight-bold text-success mb-3">Alamat</h6>
                    <div class="form-group">
                        <label>Desa</label>
                        <input type="text" name="desa" class="form-control" value="{{ old('desa',$anggota->desa) }}">
                    </div>
                    <div class="form-group">
                        <label>Distrik</label>
                        <select name="distrik" class="form-control">
                            @foreach(['Karubaga','Bokondini','Tiom','Kembu','Bewani','Bokoneri','Geya','Nabunage','Kanggime','Wugi','Kagime','Lainnya'] as $d)
                            <option value="{{ $d }}" {{ old('distrik',$anggota->distrik)==$d?'selected':'' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kabupaten</label>
                        <input type="text" name="kabupaten" class="form-control" value="{{ old('kabupaten',$anggota->kabupaten) }}">
                    </div>
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" class="form-control" rows="2">{{ old('alamat_lengkap',$anggota->alamat_lengkap) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Nama Komplek/Dekat Desa</label>
                        <input type="text" name="nama_komplek_dekat_desa" class="form-control" value="{{ old('nama_komplek_dekat_desa',$anggota->nama_komplek_dekat_desa) }}">
                    </div>
                    <h6 class="font-weight-bold text-warning mb-3 mt-3">Data Usaha</h6>
                    <div class="form-group">
                        <label>Nama Usaha</label>
                        <input type="text" name="nama_usaha" class="form-control" value="{{ old('nama_usaha',$anggota->nama_usaha) }}">
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Modal (Rp)</label>
                                <input type="number" name="modal_usaha" class="form-control" value="{{ old('modal_usaha',$anggota->modal_usaha) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Omzet (Rp)</label>
                                <input type="number" name="omzet_per_bulan" class="form-control" value="{{ old('omzet_per_bulan',$anggota->omzet_per_bulan) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Simpanan (Rp)</label>
                                <input type="number" name="total_simpanan" class="form-control" value="{{ old('total_simpanan',$anggota->total_simpanan) }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Keterangan Usaha</label>
                        <textarea name="keterangan_usaha" class="form-control" rows="3">{{ old('keterangan_usaha',$anggota->keterangan_usaha) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            @foreach(['Aktif','Pending','Nonaktif'] as $s)
                            <option value="{{ $s }}" {{ old('status',$anggota->status)==$s?'selected':'' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i>Perbarui</button>
            <a href="{{ route('admin.anggota.index') }}" class="btn btn-secondary ml-2">Batal</a>
        </div>
    </form>
</div>
@endsection