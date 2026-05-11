@extends('layouts.app')
@section('title', 'Visi & Misi')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-bullseye mr-2"></i>Visi & Misi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Visi & Misi</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
        @endif

        {{-- Tabel Data Visi & Misi --}}
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fas fa-table mr-2"></i>Data Visi & Misi Organisasi</h3>
                <div class="card-tools">
                    @if(!$visiMisi)
                    <a href="{{ route('admin.visi-misi.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah Visi & Misi
                    </a>
                    @endif
                </div>
            </div>
            <div class="card-body p-0">
                @if($visiMisi)
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th width="150">Gambar</th>
                                <th>Visi</th>
                                <th>Misi</th>
                                <th width="100" class="text-center">Status</th>
                                <th width="120" class="text-center">Terakhir Update</th>
                                <th width="200" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center align-middle">1</td>
                                <td class="align-middle">
                                    @if($visiMisi->gambar)
                                    <img src="{{ asset('storage/' . $visiMisi->gambar) }}" 
                                         alt="Gambar Visi Misi" 
                                         class="img-thumbnail"
                                         style="max-height: 80px; max-width: 120px; object-fit: cover; cursor: pointer;"
                                         onclick="showImageModal('{{ asset('storage/' . $visiMisi->gambar) }}')">
                                    @else
                                    <span class="badge badge-secondary">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div style="max-height: 100px; overflow-y: auto;">
                                        {{ Str::limit($visiMisi->visi, 150) }}
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div style="max-height: 100px; overflow-y: auto;">
                                        {{ Str::limit($visiMisi->misi, 150) }}
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge badge-{{ $visiMisi->status == 'aktif' ? 'success' : 'secondary' }} px-3 py-2">
                                        <i class="fas {{ $visiMisi->status == 'aktif' ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                        {{ ucfirst($visiMisi->status) }}
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <small class="text-muted">
                                        {{ $visiMisi->updated_at->format('d M Y') }}<br>
                                        {{ $visiMisi->updated_at->format('H:i') }} WIT
                                    </small>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm" style="background-color: #17a2b8; color: white; border-color: #17a2b8;" onclick="showDetailModal()" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('admin.visi-misi.edit', $visiMisi->id) }}" class="btn btn-sm" style="background-color: #ff9800; color: white; border-color: #ff9800;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm" style="background-color: #dc3545; color: white; border-color: #dc3545;" onclick="confirmDelete({{ $visiMisi->id }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $visiMisi->id }}" action="{{ route('admin.visi-misi.destroy', $visiMisi->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-bullseye fa-5x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">Belum Ada Visi & Misi</h4>
                    <p class="text-muted mb-4">Buat visi dan misi organisasi Anda untuk ditampilkan di website</p>
                    <a href="{{ route('admin.visi-misi.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus mr-2"></i> Tambah Visi & Misi
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Detail --}}
@if($visiMisi)
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-eye mr-2"></i>Detail Visi & Misi Organisasi</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($visiMisi->gambar)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $visiMisi->gambar) }}" 
                         alt="Gambar Visi Misi" 
                         class="img-fluid rounded shadow"
                         style="max-height: 400px;">
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-eye mr-2"></i>VISI</h5>
                            </div>
                            <div class="card-body">
                                <p style="line-height: 1.8; white-space: pre-wrap;">{{ $visiMisi->visi }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-bullseye mr-2"></i>MISI</h5>
                            </div>
                            <div class="card-body">
                                <p style="line-height: 1.8; white-space: pre-wrap;">{{ $visiMisi->misi }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <table class="table table-bordered table-sm">
                            <tr>
                                <th width="150">Status</th>
                                <td>
                                    <span class="badge badge-{{ $visiMisi->status == 'aktif' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($visiMisi->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Dibuat</th>
                                <td>{{ $visiMisi->created_at->format('d M Y, H:i') }} WIT</td>
                            </tr>
                            <tr>
                                <th>Terakhir Update</th>
                                <td>{{ $visiMisi->updated_at->format('d M Y, H:i') }} WIT</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('admin.visi-misi.edit', $visiMisi->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Image --}}
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gambar Visi & Misi</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Gambar" class="img-fluid">
            </div>
        </div>
    </div>
</div>
@endif

<style>
.border-left-primary {
    border-left: 4px solid #007bff !important;
}

.border-left-success {
    border-left: 4px solid #28a745 !important;
}

.icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.text-gray-800 {
    color: #5a5c69;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    margin: 0 2px;
}
</style>

<script>
function showDetailModal() {
    $('#detailModal').modal('show');
}

function showImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    $('#imageModal').modal('show');
}

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus Visi & Misi ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection
