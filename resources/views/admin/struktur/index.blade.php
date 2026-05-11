@extends('layouts.app')
@section('title','Struktur Organisasi')
@section('page-title','Struktur Organisasi')
@section('breadcrumb')
    <li class="breadcrumb-item active">Struktur Organisasi</li>
@endsection
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ session('success') }}
</div>
@endif

<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-sitemap mr-2"></i>Daftar Pegawai per Bidang</h3>
        <a href="{{ route('admin.struktur.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Struktur Organisasi
        </a>
    </div>
    <div class="card-body">
        @php
        $bidangLabels = [
            'kepala_dinas'=>['label'=>'Kepala Dinas','color'=>'primary','icon'=>'fas fa-user-tie'],
            'sekretariat'=>['label'=>'Sekretariat','color'=>'info','icon'=>'fas fa-building'],
            'perindustrian'=>['label'=>'Bidang Perindustrian','color'=>'danger','icon'=>'fas fa-industry'],
            'perdagangan'=>['label'=>'Bidang Perdagangan','color'=>'success','icon'=>'fas fa-shopping-cart'],
            'koperasi'=>['label'=>'Bidang Koperasi','color'=>'warning','icon'=>'fas fa-handshake'],
            'koperasi'=>['label'=>'Bidang Koperasi','color'=>'secondary','icon'=>'fas fa-store'],
            'uptd'=>['label'=>'UPTD','color'=>'dark','icon'=>'fas fa-network-wired'],
        ];
        @endphp

        @foreach($bidangLabels as $key => $bl)
        @if(isset($data[$key]) && $data[$key]->count() > 0)
        <div class="card card-{{ $bl['color'] }} card-outline mb-3">
            <div class="card-header">
                <h6 class="card-title mb-0"><i class="{{ $bl['icon'] }} mr-2"></i>{{ $bl['label'] }}</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="60">Foto</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>NIP</th>
                            <th width="80">Urutan</th>
                            <th width="80">Status</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data[$key]->sortBy('urutan') as $s)
                        <tr>
                            <td>
                                <img src="{{ $s->foto ? asset('storage/'.$s->foto) : asset('images/default-avatar.png') }}" class="img-circle" width="35" height="35" style="object-fit:cover;" onerror="this.src='https://ui-avatars.com/api/?name='+encodeURIComponent('{{ $s->nama }}')">
                            </td>
                            <td>
                                <strong>{{ $s->nama ?? '-' }}</strong>
                                @if($s->sub_jabatan)<br><small class="text-muted">{{ $s->sub_jabatan }}</small>@endif
                            </td>
                            <td>{{ $s->jabatan }}</td>
                            <td><small class="text-muted">{{ $s->nip ?? '-' }}</small></td>
                            <td class="text-center">{{ $s->urutan }}</td>
                            <td>
                                @if($s->is_active)
                                <span class="badge badge-success">Aktif</span>
                                @else
                                <span class="badge badge-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.struktur.edit', $s->id) }}" 
                                       class="btn btn-sm" 
                                       style="background:linear-gradient(135deg,#f59e0b,#d97706);color:white;border:none;padding:6px 12px;border-radius:6px 0 0 6px"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-sm" 
                                            style="background:linear-gradient(135deg,#06b6d4,#0891b2);color:white;border:none;padding:6px 12px"
                                            onclick="showDetail({{ $s->id }})"
                                            title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.struktur.destroy', $s->id) }}" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm" 
                                                style="background:linear-gradient(135deg,#ef4444,#dc2626);color:white;border:none;padding:6px 12px;border-radius:0 6px 6px 0;box-shadow:0 2px 6px rgba(239,68,68,0.3)"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background: #1e3a8a; color: white;">
                <h5 class="modal-title"><i class="fas fa-user-circle mr-2"></i>Detail Pegawai</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailContent">
                <div class="text-center py-5">
                    <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
                    <p class="mt-3">Memuat data...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
function showDetail(id) {
    $('#modalDetail').modal('show');
    $('#detailContent').html(`
        <div class="text-center py-5">
            <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
            <p class="mt-3">Memuat data...</p>
        </div>
    `);
    
    $.ajax({
        url: '/admin/struktur/' + id,
        method: 'GET',
        success: function(response) {
            let html = `
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <img src="${response.foto_url}" class="img-fluid rounded shadow" style="max-width: 200px; max-height: 250px; object-fit: cover;" onerror="this.src='https://ui-avatars.com/api/?name='+encodeURIComponent('${response.nama}')+'&size=200'">
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div style="background: #f8f9fa; padding: 12px 15px; border-radius: 6px; border-left: 3px solid #1e3a8a;">
                                    <label class="text-muted mb-1" style="font-size:0.75rem; font-weight: 600; text-transform: uppercase;">Nama Lengkap</label>
                                    <div class="font-weight-bold" style="font-size: 16px; color: #1a202c;">${response.nama}</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div style="background: #f8f9fa; padding: 12px 15px; border-radius: 6px; border-left: 3px solid #1e3a8a;">
                                    <label class="text-muted mb-1" style="font-size:0.75rem; font-weight: 600; text-transform: uppercase;">Jabatan</label>
                                    <div class="font-weight-bold" style="font-size: 14px; color: #1a202c;">${response.jabatan}</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div style="background: #f8f9fa; padding: 12px 15px; border-radius: 6px; border-left: 3px solid #1e3a8a;">
                                    <label class="text-muted mb-1" style="font-size:0.75rem; font-weight: 600; text-transform: uppercase;">Sub Jabatan</label>
                                    <div class="font-weight-bold" style="font-size: 14px; color: #1a202c;">${response.sub_jabatan || '-'}</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div style="background: #f8f9fa; padding: 12px 15px; border-radius: 6px; border-left: 3px solid #1e3a8a;">
                                    <label class="text-muted mb-1" style="font-size:0.75rem; font-weight: 600; text-transform: uppercase;">NIP</label>
                                    <div class="font-weight-bold" style="font-size: 14px; color: #1a202c;">${response.nip || '-'}</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div style="background: #f8f9fa; padding: 12px 15px; border-radius: 6px; border-left: 3px solid #1e3a8a;">
                                    <label class="text-muted mb-1" style="font-size:0.75rem; font-weight: 600; text-transform: uppercase;">Bidang</label>
                                    <div class="font-weight-bold" style="font-size: 14px; color: #1a202c;">${response.bidang_label}</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div style="background: #f8f9fa; padding: 12px 15px; border-radius: 6px; border-left: 3px solid #1e3a8a;">
                                    <label class="text-muted mb-1" style="font-size:0.75rem; font-weight: 600; text-transform: uppercase;">Urutan</label>
                                    <div class="font-weight-bold" style="font-size: 14px; color: #1a202c;">${response.urutan}</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div style="background: #f8f9fa; padding: 12px 15px; border-radius: 6px; border-left: 3px solid #1e3a8a;">
                                    <label class="text-muted mb-1" style="font-size:0.75rem; font-weight: 600; text-transform: uppercase;">Status</label>
                                    <div>
                                        ${response.is_active ? '<span class="badge badge-success" style="padding:6px 12px;font-size:12px">Aktif</span>' : '<span class="badge badge-secondary" style="padding:6px 12px;font-size:12px">Nonaktif</span>'}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#detailContent').html(html);
        },
        error: function() {
            $('#detailContent').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Gagal memuat data. Silakan coba lagi.
                </div>
            `);
        }
    });
}
</script>

<style>
.btn-group button:hover, .btn-group a:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2) !important;
    transition: all 0.2s ease;
}
</style>
@endsection