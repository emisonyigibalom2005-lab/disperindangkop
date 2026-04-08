@extends('layouts.admin')
@section('title', 'Tulis Berita')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Tulis Berita</h1>
        <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">← Kembali</a>
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

            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" name="judul"
                        class="form-control @error('judul') is-invalid @enderror"
                        value="{{ old('judul') }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="kategori"
                            class="form-control @error('kategori') is-invalid @enderror"
                            value="{{ old('kategori') }}"
                            placeholder="cth: umum, program, pengumuman" required>
                        @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="draft" @selected(old('status') == 'draft')>Draft</option>
                            <option value="published" @selected(old('status') == 'published')>Publish</option>
                            <option value="archived" @selected(old('status') == 'archived')>Archived</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Thumbnail</label>
                        <input type="file" name="thumbnail" accept="image/*"
                            class="form-control @error('thumbnail') is-invalid @enderror"
                            onchange="previewImage(this)">
                        @error('thumbnail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <img id="preview" src="#" alt="Preview" class="mt-2 d-none"
                            style="max-height:120px; border-radius:6px;">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Konten <span class="text-danger">*</span></label>
                    <textarea name="konten" id="konten"
                        class="form-control @error('konten') is-invalid @enderror"
                        rows="12">{{ old('konten') }}</textarea>
                    @error('konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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
</script>
@endsection