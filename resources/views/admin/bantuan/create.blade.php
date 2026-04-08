{{-- resources/views/admin/bantuan/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Bantuan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Tambah Bantuan</h1>
        <a href="{{ route('admin.bantuan.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.bantuan.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Bantuan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_bantuan" class="form-control @error('nama_bantuan') is-invalid @enderror"
                            value="{{ old('nama_bantuan') }}" required>
                        @error('nama_bantuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Bantuan <span class="text-danger">*</span></label>
                        <select name="jenis_bantuan" class="form-control @error('jenis_bantuan') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis --</option>
                            @foreach (['tunai', 'barang', 'pelatihan', 'lainnya'] as $jenis)
                                <option value="{{ $jenis }}" @selected(old('jenis_bantuan') == $jenis)>
                                    {{ ucfirst($jenis) }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_bantuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror"
                            value="{{ old('tahun', date('Y')) }}" min="2020" max="2099" required>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Periode <span class="text-danger">*</span></label>
                        <input type="text" name="periode" class="form-control @error('periode') is-invalid @enderror"
                            value="{{ old('periode') }}" placeholder="cth: Semester 1 / Triwulan I" required>
                        @error('periode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kuota <span class="text-danger">*</span></label>
                        <input type="number" name="kuota" class="form-control @error('kuota') is-invalid @enderror"
                            value="{{ old('kuota') }}" min="1" required>
                        @error('kuota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Anggaran (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="anggaran" class="form-control @error('anggaran') is-invalid @enderror"
                            value="{{ old('anggaran') }}" min="0" step="1000" required>
                        @error('anggaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                            rows="4">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.bantuan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection