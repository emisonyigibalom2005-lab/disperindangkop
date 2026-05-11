@extends('layouts.app')
@section('title', 'Tambah Visi & Misi')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-plus-circle mr-2"></i>Tambah Visi & Misi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.visi-misi.index') }}">Visi & Misi</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <form method="POST" action="{{ route('admin.visi-misi.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Informasi Visi & Misi</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="visi">Visi <span class="text-danger">*</span></label>
                                <textarea name="visi" id="visi" class="form-control @error('visi') is-invalid @enderror" rows="6"
                                          placeholder="Tuliskan visi organisasi..." required>{{ old('visi') }}</textarea>
                                @error('visi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Visi adalah gambaran masa depan yang ingin dicapai organisasi
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="misi">Misi <span class="text-danger">*</span></label>
                                <textarea name="misi" id="misi" class="form-control @error('misi') is-invalid @enderror" rows="10"
                                          placeholder="Tuliskan misi organisasi (pisahkan dengan enter untuk setiap poin)..." required>{{ old('misi') }}</textarea>
                                @error('misi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Misi adalah langkah-langkah strategis untuk mencapai visi
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="gambar">Gambar Header</label>
                                <div class="custom-file">
                                    <input type="file" name="gambar" id="gambar" class="custom-file-input @error('gambar') is-invalid @enderror" accept="image/*" onchange="previewImage(this)">
                                    <label class="custom-file-label" for="gambar">Pilih gambar...</label>
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-image mr-1"></i>
                                    Format: JPG, PNG, GIF. Maksimal 2MB
                                </small>
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h3 class="card-title"><i class="fas fa-cog mr-2"></i>Pengaturan</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info">
                                <h6 class="alert-heading"><i class="fas fa-info-circle mr-1"></i>Informasi</h6>
                                <ul class="mb-0 pl-3">
                                    <li>Hanya bisa ada 1 Visi & Misi</li>
                                    <li>Status aktif akan ditampilkan di website</li>
                                </ul>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save mr-1"></i> Simpan Visi & Misi
                                </button>
                                <a href="{{ route('admin.visi-misi.index') }}" class="btn btn-secondary btn-block">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    const label = input.nextElementSibling;
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
        label.textContent = input.files[0].name;
    } else {
        previewDiv.style.display = 'none';
        label.textContent = 'Pilih gambar...';
    }
}
</script>
@endsection
