@extends('layouts.app')
@section('title','Upload Bagan Struktur')
@section('page-title','Upload Bagan Struktur')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.struktur.index') }}">Struktur Organisasi</a></li>
    <li class="breadcrumb-item active">Upload Bagan</li>
@endsection
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ session('success') }}
</div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-upload mr-2"></i>Upload Foto Bagan Struktur</h3>
            </div>
            <form method="POST" action="{{ route('admin.struktur.bagan.upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <p class="text-muted">Upload foto/gambar bagan struktur organisasi. Foto ini akan tampil di halaman publik.</p>
                    <div class="form-group">
                        <label>Pilih Foto Bagan</label>
                        <div class="custom-file">
                            <input type="file" name="foto_bagan" class="custom-file-input" id="foto_bagan" accept="image/*" required>
                            <label class="custom-file-label" for="foto_bagan">Pilih gambar...</label>
                        </div>
                        <small class="text-muted">Format: JPG, PNG. Maks 5MB. Disarankan landscape.</small>
                    </div>
                    <div id="preview-wrap" class="mt-3 d-none">
                        <label>Preview:</label>
                        <img id="preview" src="" class="img-fluid rounded shadow-sm" style="max-height:300px;">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload mr-1"></i> Upload</button>
                    <a href="{{ route('admin.struktur.index') }}" class="btn btn-secondary ml-2">Kembali</a>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-info card-outline">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-image mr-2"></i>Bagan Saat Ini</h3></div>
            <div class="card-body text-center">
                @if($bagan && $bagan->value)
                    <img src="{{ asset('storage/'.$bagan->value) }}" class="img-fluid rounded shadow" style="max-height:350px;">
                    <p class="mt-3 mb-2 text-muted small"><i class="fas fa-check-circle text-success mr-1"></i>Bagan struktur organisasi aktif</p>
                    <button type="button" 
                            class="btn btn-sm mt-2" 
                            style="background:linear-gradient(135deg,#ef4444,#dc2626);color:white;border:none;padding:8px 16px;border-radius:8px;box-shadow:0 2px 8px rgba(239,68,68,0.3);font-weight:600"
                            onclick="confirmDeleteBagan()">
                        <i class="fas fa-trash mr-1"></i> Hapus Foto Bagan
                    </button>
                    
                    <form id="formHapusBagan" method="POST" action="{{ route('admin.struktur.bagan.hapus') }}" style="display:none">
                        @csrf @method('DELETE')
                    </form>
                @else
                    <div class="py-5 text-muted">
                        <i class="fas fa-image fa-4x mb-3 d-block" style="opacity:.2"></i>
                        <p>Belum ada foto bagan diupload</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="modalHapusBagan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-trash mr-2"></i>Hapus Foto Bagan</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                </div>
                <p>Apakah Anda yakin ingin menghapus foto bagan struktur organisasi?</p>
                <p class="text-muted mb-0"><small>Foto bagan akan dihapus dari sistem dan tidak akan ditampilkan di halaman publik.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" 
                        class="btn btn-danger" 
                        style="background:linear-gradient(135deg,#ef4444,#dc2626);border:none;box-shadow:0 2px 8px rgba(239,68,68,0.3)"
                        onclick="submitHapusBagan()">
                    <i class="fas fa-trash mr-1"></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    document.querySelector('.custom-file-label').textContent = file.name;
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('preview').src = e.target.result;
        document.getElementById('preview-wrap').classList.remove('d-none');
    };
    reader.readAsDataURL(file);
});

function confirmDeleteBagan() {
    $('#modalHapusBagan').modal('show');
}

function submitHapusBagan() {
    document.getElementById('formHapusBagan').submit();
}
</script>
@endpush