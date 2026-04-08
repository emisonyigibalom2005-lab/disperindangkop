@extends('layouts.admin')
@section('title', 'Tambah Galeri')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Tambah Galeri</h1>
        <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">← Kembali</a>
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

            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Tipe <span class="text-danger">*</span></label>
                    <select name="tipe" id="tipe" class="form-control" required onchange="toggleTipe()">
                        <option value="foto" {{ old('tipe') == 'foto' ? 'selected' : '' }}>Foto</option>
                        <option value="video" {{ old('tipe') == 'video' ? 'selected' : '' }}>Video</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" name="judul"
                        class="form-control @error('judul') is-invalid @enderror"
                        value="{{ old('judul') }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- INPUT FOTO --}}
                <div class="mb-3" id="inputFoto">
                    <label class="form-label">Foto</label>
                    <input type="file" name="foto" accept="image/*"
                        class="form-control @error('foto') is-invalid @enderror"
                        onchange="previewImage(this)">
                    @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <img id="preview" src="#" class="mt-2 d-none"
                        style="max-height:200px; border-radius:6px;">
                </div>

                {{-- INPUT VIDEO URL --}}
                <div class="mb-3 d-none" id="inputVideo">
                    <label class="form-label">URL YouTube</label>
                    <input type="text" name="video_url"
                        class="form-control @error('video_url') is-invalid @enderror"
                        value="{{ old('video_url') }}"
                        placeholder="https://www.youtube.com/watch?v=xxxxx">
                    @error('video_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi"
                        class="form-control @error('deskripsi') is-invalid @enderror"
                        rows="3">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleTipe() {
    const tipe = document.getElementById('tipe').value;
    document.getElementById('inputFoto').classList.toggle('d-none', tipe === 'video');
    document.getElementById('inputVideo').classList.toggle('d-none', tipe === 'foto');
}

function previewImage(input) {
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Jalankan saat load jika old value video
toggleTipe();
</script>
@endsection
