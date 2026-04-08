@extends('layouts.admin')
@section('title', 'Edit Foto Galeri')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Edit Foto Galeri</h1>
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

            <form action="{{ route('admin.galeri.update', $galeri) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" name="judul"
                        class="form-control @error('judul') is-invalid @enderror"
                        value="{{ old('judul', $galeri->judul) }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    @if ($galeri->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $galeri->foto) }}"
                                id="preview" style="max-height:200px; border-radius:6px;">
                        </div>
                    @else
                        <img id="preview" src="#" class="d-none mb-2"
                            style="max-height:200px; border-radius:6px;">
                    @endif
                    <input type="file" name="foto" accept="image/*"
                        class="form-control @error('foto') is-invalid @enderror"
                        onchange="previewImage(this)">
                    <div class="form-text">Kosongkan jika tidak ingin mengganti foto.</div>
                    @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi"
                        class="form-control @error('deskripsi') is-invalid @enderror"
                        rows="3">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                    @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">Batal</a>
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