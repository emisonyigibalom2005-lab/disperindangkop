@extends('layouts.admin')
@section('title', 'Edit Berita')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Edit Berita</h1>
        <a href="{{ route('admin.berita.show', $berita->id) }}" class="btn btn-secondary">← Kembali</a>
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

            <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" name="judul"
                        class="form-control @error('judul') is-invalid @enderror"
                        value="{{ old('judul', $berita->judul) }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="kategori"
                            class="form-control @error('kategori') is-invalid @enderror"
                            value="{{ old('kategori', $berita->kategori) }}" required>
                        @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="draft" @selected(old('status', $berita->status) == 'draft')>Draft</option>
                            <option value="published" @selected(old('status', $berita->status) == 'published')>Publish</option>
                            <option value="archived" @selected(old('status', $berita->status) == 'archived')>Archived</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Thumbnail</label>
                        @if ($berita->thumbnail)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $berita->thumbnail) }}"
                                    id="preview" style="max-height:120px; border-radius:6px;">
                            </div>
                        @else
                            <img id="preview" src="#" class="d-none mb-2"
                                style="max-height:120px; border-radius:6px;">
                        @endif
                        <input type="file" name="thumbnail" accept="image/*"
                            class="form-control @error('thumbnail') is-invalid @enderror"
                            onchange="previewImage(this)">
                        <div class="form-text">Kosongkan jika tidak ingin mengganti gambar.</div>
                        @error('thumbnail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Konten <span class="text-danger">*</span></label>
                    <textarea name="konten" id="konten"
                        class="form-control @error('konten') is-invalid @enderror"
                        rows="12">{{ old('konten', $berita->konten) }}</textarea>
                    @error('konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.berita.show', $berita->id) }}" class="btn btn-secondary">Batal</a>
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