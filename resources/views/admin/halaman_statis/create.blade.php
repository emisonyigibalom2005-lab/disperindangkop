@extends('layouts.app')
@section('title', 'Tambah Halaman')
@section('content')
<div class="content-header"><div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6"><h1 class="m-0">Tambah Halaman</h1></div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.halaman-statis.index') }}">Halaman Statis</a></li>
        <li class="breadcrumb-item active">Tambah</li>
      </ol>
    </div>
  </div>
</div></div>
<section class="content"><div class="container-fluid">
  <div class="card card-primary card-outline">
    <div class="card-header"><h3 class="card-title"><i class="fas fa-plus mr-2"></i>Form Tambah Halaman</h3></div>
    <form method="POST" action="{{ route('admin.halaman-statis.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label>Slug <small class="text-muted">(URL halaman)</small></label>
          <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                 value="{{ old('slug') }}" placeholder="contoh: visi-misi">
          @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
          <small class="text-muted">Pilihan: visi-misi | perindustrian | perdagangan | koperasi-koperasi | nilai | komitmen | struktur-organisasi</small>
        </div>
        <div class="form-group">
          <label>Judul Halaman</label>
          <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                 value="{{ old('judul') }}" placeholder="contoh: Visi & Misi">
          @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label>Icon <small class="text-muted">(Font Awesome)</small></label>
          <input type="text" name="icon" class="form-control" value="{{ old('icon','fas fa-file-alt') }}"
                 placeholder="fas fa-bullseye">
          <small class="text-muted">fas fa-bullseye | fas fa-industry | fas fa-shopping-cart | fas fa-handshake | fas fa-star | fas fa-award | fas fa-sitemap</small>
        </div>
        <div class="form-group">
          <label>Konten</label>
          <textarea name="konten" class="form-control" rows="12"
                    placeholder="Tulis konten halaman di sini...">{{ old('konten') }}</textarea>
        </div>
        <div class="form-group">
          <label>Gambar Header</label>
          <div class="custom-file">
            <input type="file" name="gambar" class="custom-file-input" id="gambar" accept="image/*">
            <label class="custom-file-label" for="gambar">Pilih gambar...</label>
          </div>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-control">
            <option value="aktif" selected>Aktif</option>
            <option value="nonaktif">Nonaktif</option>
          </select>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
        <a href="{{ route('admin.halaman-statis.index') }}" class="btn btn-secondary ml-2">Batal</a>
      </div>
    </form>
  </div>
</div></section>
@push('scripts')
<script>
document.querySelector('.custom-file-input').addEventListener('change',function(e){
  document.querySelector('.custom-file-label').textContent = e.target.files[0]?e.target.files[0].name:'Pilih gambar...';
});
</script>
@endpush
@endsection
