@extends("layouts.app")
@section("title","Edit Pengumuman")
@section("page-title","Edit Pengumuman")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{ route('admin.pengumuman.index') }}">Pengumuman</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection
@section("content")
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0"><i class="fas fa-edit mr-2"></i>Edit Pengumuman</h3>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.pengumuman.update', $pengumuman) }}" method="POST" enctype="multipart/form-data">
        @csrf @method("PUT")
        
        {{-- Judul --}}
        <div class="form-group">
            <label class="font-weight-bold">Judul Pengumuman <span class="text-danger">*</span></label>
            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                   value="{{ old('judul', $pengumuman->judul) }}" placeholder="Masukkan judul pengumuman..." required>
            @error("judul")<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Isi --}}
        <div class="form-group">
            <label class="font-weight-bold">Isi Pengumuman <span class="text-danger">*</span></label>
            <textarea name="isi" rows="8" class="form-control @error('isi') is-invalid @enderror"
                      placeholder="Tulis isi pengumuman..." required>{{ old('isi', $pengumuman->isi) }}</textarea>
            @error("isi")<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Foto --}}
        <div class="form-group">
            <label class="font-weight-bold">Foto <small class="text-muted">(opsional, maks 3MB)</small></label>
            @if($pengumuman->foto)
            <div class="mb-2">
                <img src="{{ asset('storage/'.$pengumuman->foto) }}" alt="Foto saat ini" class="img-thumbnail" style="max-height:150px">
                <p class="text-muted small mb-0 mt-1">Foto saat ini (akan diganti jika upload foto baru)</p>
            </div>
            @endif
            <input type="file" name="foto" accept="image/*" class="form-control-file @error('foto') is-invalid @enderror"
                onchange="if(this.files[0]){var r=new FileReader();r.onload=function(e){document.getElementById('prevFoto').src=e.target.result;document.getElementById('prevFoto').classList.remove('d-none');};r.readAsDataURL(this.files[0]);}">
            <img id="prevFoto" class="mt-2 d-none rounded shadow-sm" style="max-height:180px;object-fit:cover;">
            @error("foto")<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="row">
            {{-- Tanggal --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label class="font-weight-bold">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                           value="{{ old('tanggal', $pengumuman->tanggal) }}">
                    @error("tanggal")<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Mulai Tampil --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label class="font-weight-bold">Mulai Tampil</label>
                    <input type="datetime-local" name="mulai_tampil" class="form-control @error('mulai_tampil') is-invalid @enderror"
                           value="{{ old('mulai_tampil', $pengumuman->mulai_tampil ? date('Y-m-d\TH:i', strtotime($pengumuman->mulai_tampil)) : '') }}">
                    <small class="text-muted">Kosong = sekarang</small>
                    @error("mulai_tampil")<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Selesai Tampil --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label class="font-weight-bold">Selesai Tampil</label>
                    <input type="datetime-local" name="selesai_tampil" class="form-control @error('selesai_tampil') is-invalid @enderror"
                           value="{{ old('selesai_tampil', $pengumuman->selesai_tampil ? date('Y-m-d\TH:i', strtotime($pengumuman->selesai_tampil)) : '') }}">
                    <small class="text-muted">Kosong = selamanya</small>
                    @error("selesai_tampil")<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Hidden fields untuk field yang dihapus tapi masih dibutuhkan di database --}}
        <input type="hidden" name="jenis" value="{{ $pengumuman->jenis ?? 'info' }}">
        <input type="hidden" name="tampil_di" value="{{ $pengumuman->tampil_di ?? 'keduanya' }}">
        <input type="hidden" name="urutan" value="{{ $pengumuman->urutan ?? 0 }}">
        <input type="hidden" name="is_aktif" value="1">
        <input type="hidden" name="hari" value="{{ $pengumuman->hari ?? '' }}">
        <input type="hidden" name="jam" value="{{ $pengumuman->jam ?? '' }}">
        <input type="hidden" name="tahun" value="{{ $pengumuman->tahun ?? date('Y') }}">
        <input type="hidden" name="pembuat" value="{{ $pengumuman->pembuat ?? auth()->user()->name }}">

        <hr class="my-4">
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i>Simpan Perubahan
            </button>
        </div>
        </form>
    </div>
</div>
@endsection
