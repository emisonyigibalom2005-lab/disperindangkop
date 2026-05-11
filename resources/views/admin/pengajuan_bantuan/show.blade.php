@extends('layouts.app')
@section('title','Detail Pengajuan Bantuan')

@push('styles')
<style>
    .detail-header-card {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
        margin-bottom: 24px;
        overflow: hidden;
    }
    
    .detail-header-content {
        padding: 32px;
        color: white;
    }
    
    .detail-card-modern {
        background: white;
        border-radius: 16px;
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        margin-bottom: 24px;
        overflow: hidden;
    }
    
    .detail-card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 20px 24px;
        border-bottom: 2px solid #e9ecef;
    }
    
    .detail-card-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .data-row-modern {
        display: flex;
        padding: 16px 24px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
    }
    
    .data-row-modern:hover {
        background: #f8fafc;
    }
    
    .data-row-modern:last-child {
        border-bottom: none;
    }
    
    .data-label-modern {
        flex: 0 0 180px;
        font-weight: 600;
        color: #64748b;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .data-value-modern {
        flex: 1;
        font-weight: 600;
        color: #1e293b;
        font-size: 14px;
    }
    
    .status-badge-large {
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .badge-menunggu-large {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .badge-disetujui-large {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .badge-ditolak-large {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    
    .badge-diproses-large {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }
    
    .update-status-card {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 3px solid #f59e0b;
    }
    
    .form-group-modern label {
        font-weight: 700;
        color: #1e293b;
        font-size: 14px;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control-modern {
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .form-control-modern:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }
    
    .btn-update-modern {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 24px;
        font-weight: 700;
        font-size: 16px;
        width: 100%;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .btn-update-modern:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
        color: white;
    }
    
    .btn-back-modern {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-back-modern:hover {
        background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(107, 114, 128, 0.3);
        color: white;
    }
    
    .info-box-modern {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-left: 4px solid #3b82f6;
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 20px;
    }
    
    .info-box-modern i {
        color: #3b82f6;
        font-size: 20px;
        margin-right: 12px;
    }
    
    .info-box-modern strong {
        color: #1e40af;
        font-size: 14px;
    }
    
    .info-box-modern p {
        color: #1e40af;
        font-size: 13px;
        margin: 0;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="detail-header-card">
        <div class="detail-header-content">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="mb-2" style="font-size: 28px; font-weight: 700;">Detail Pengajuan Bantuan</h3>
                    <p class="mb-0" style="font-size: 14px; opacity: 0.9;">
                        <i class="fas fa-calendar-alt mr-2"></i>Diajukan pada {{ $pengajuanBantuan->created_at->format('d F Y, H:i') }} WIT
                    </p>
                </div>
                <a href="{{ route('admin.pengajuan-bantuan.index') }}" class="btn-back-modern">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" style="border-radius: 12px; border-left: 4px solid #10b981;">
        <i class="fas fa-check-circle mr-2"></i>
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    <div class="row">
        {{-- Detail Pengajuan --}}
        <div class="col-lg-7 mb-4">
            <div class="detail-card-modern">
                <div class="detail-card-header">
                    <h5 class="detail-card-title">
                        <i class="fas fa-file-alt text-purple"></i>
                        Informasi Pengajuan
                    </h5>
                </div>
                <div>
                    <div class="data-row-modern">
                        <div class="data-label-modern">Nama Pemohon</div>
                        <div class="data-value-modern">
                            <strong style="font-size: 16px;">{{ $pengajuanBantuan->anggota->nama ?? $pengajuanBantuan->nama_pemohon }}</strong>
                        </div>
                    </div>
                    <div class="data-row-modern">
                        <div class="data-label-modern">No. HP</div>
                        <div class="data-value-modern">
                            <i class="fas fa-phone text-success mr-2"></i>
                            {{ $pengajuanBantuan->anggota->no_hp ?? $pengajuanBantuan->no_hp }}
                        </div>
                    </div>
                    <div class="data-row-modern">
                        <div class="data-label-modern">Email</div>
                        <div class="data-value-modern">
                            <i class="fas fa-envelope text-info mr-2"></i>
                            {{ $pengajuanBantuan->anggota->email ?? $pengajuanBantuan->email ?? '-' }}
                        </div>
                    </div>
                    <div class="data-row-modern">
                        <div class="data-label-modern">Nama Usaha</div>
                        <div class="data-value-modern">
                            <i class="fas fa-store text-primary mr-2"></i>
                            {{ $pengajuanBantuan->anggota->nama_usaha ?? $pengajuanBantuan->nama_usaha }}
                        </div>
                    </div>
                    <div class="data-row-modern">
                        <div class="data-label-modern">Jenis Bantuan</div>
                        <div class="data-value-modern">
                            <span class="badge badge-info" style="padding: 8px 16px; border-radius: 8px; font-size: 13px;">
                                {{ ucfirst($pengajuanBantuan->jenis_bantuan) }}
                            </span>
                        </div>
                    </div>
                    <div class="data-row-modern">
                        <div class="data-label-modern">Jumlah Diajukan</div>
                        <div class="data-value-modern">
                            <strong style="font-size: 18px; color: #10b981;">
                                {{ $pengajuanBantuan->jumlah_diajukan ? 'Rp '.number_format($pengajuanBantuan->jumlah_diajukan,0,',','.') : '-' }}
                            </strong>
                        </div>
                    </div>
                    <div class="data-row-modern">
                        <div class="data-label-modern">Periode Bantuan</div>
                        <div class="data-value-modern">
                            <i class="far fa-calendar-alt text-warning mr-2"></i>
                            {{ $pengajuanBantuan->periodeBantuan->nama_periode ?? '-' }}
                        </div>
                    </div>
                    <div class="data-row-modern">
                        <div class="data-label-modern">Tujuan Penggunaan</div>
                        <div class="data-value-modern" style="line-height: 1.6;">
                            {{ $pengajuanBantuan->tujuan_penggunaan ?? '-' }}
                        </div>
                    </div>
                    <div class="data-row-modern">
                        <div class="data-label-modern">Tanggal Pengajuan</div>
                        <div class="data-value-modern">
                            <i class="fas fa-calendar-check text-primary mr-2"></i>
                            {{ $pengajuanBantuan->created_at->format('d F Y, H:i') }} WIT
                        </div>
                    </div>
                    <div class="data-row-modern">
                        <div class="data-label-modern">Status</div>
                        <div class="data-value-modern">
                            @php
                                $statusClass = match($pengajuanBantuan->status) {
                                    'disetujui' => 'badge-disetujui-large',
                                    'ditolak' => 'badge-ditolak-large',
                                    'diproses' => 'badge-diproses-large',
                                    default => 'badge-menunggu-large'
                                };
                                $statusIcon = match($pengajuanBantuan->status) {
                                    'disetujui' => 'fa-check-circle',
                                    'ditolak' => 'fa-times-circle',
                                    'diproses' => 'fa-spinner',
                                    default => 'fa-clock'
                                };
                            @endphp
                            <span class="status-badge-large {{ $statusClass }}">
                                <i class="fas {{ $statusIcon }}"></i>
                                {{ ucfirst($pengajuanBantuan->status) }}
                            </span>
                        </div>
                    </div>
                    @if($pengajuanBantuan->catatan_admin)
                    <div class="data-row-modern">
                        <div class="data-label-modern">Catatan Admin</div>
                        <div class="data-value-modern" style="line-height: 1.6;">
                            <div class="alert alert-info mb-0" style="border-radius: 8px; padding: 12px 16px;">
                                <i class="fas fa-info-circle mr-2"></i>
                                {{ $pengajuanBantuan->catatan_admin }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="col-lg-5 mb-4">
            <div class="detail-card-modern update-status-card">
                <div class="detail-card-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <h5 class="detail-card-title" style="color: white;">
                        <i class="fas fa-edit"></i>
                        Update Status Pengajuan
                    </h5>
                </div>
                <div style="padding: 24px;">
                    <div class="info-box-modern">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>Perhatian!</strong>
                        <p class="mt-2">Pastikan Anda telah memeriksa semua informasi pengajuan sebelum mengubah status.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.pengajuan-bantuan.update', $pengajuanBantuan) }}">
                        @csrf 
                        @method('PUT')
                        
                        <div class="form-group-modern mb-4">
                            <label>
                                <i class="fas fa-flag mr-2"></i>Status Pengajuan
                            </label>
                            <select name="status" class="form-control form-control-modern" required>
                                @foreach(['menunggu'=>'Menunggu Verifikasi','diproses'=>'Sedang Diproses','disetujui'=>'Disetujui','ditolak'=>'Ditolak'] as $v=>$l)
                                <option value="{{ $v }}" {{ $pengajuanBantuan->status==$v?'selected':'' }}>{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group-modern mb-4">
                            <label>
                                <i class="fas fa-comment-alt mr-2"></i>Catatan Admin
                            </label>
                            <textarea name="catatan_admin" 
                                      class="form-control form-control-modern" 
                                      rows="5"
                                      placeholder="Masukkan catatan atau keterangan tambahan...">{{ $pengajuanBantuan->catatan_admin }}</textarea>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-info-circle mr-1"></i>
                                Catatan ini akan dilihat oleh pemohon
                            </small>
                        </div>
                        
                        <button type="submit" class="btn-update-modern">
                            <i class="fas fa-save"></i>
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="detail-card-modern">
                <div class="detail-card-header">
                    <h5 class="detail-card-title">
                        <i class="fas fa-bolt text-warning"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div style="padding: 20px;">
                    <div class="d-grid gap-2">
                        @if($pengajuanBantuan->status === 'menunggu' || $pengajuanBantuan->status === 'pending')
                        <button type="button" 
                                class="btn btn-success btn-lg mb-2" 
                                style="border-radius: 10px; font-weight: 700;"
                                onclick="quickApprove()">
                            <i class="fas fa-check-circle mr-2"></i>Setujui Pengajuan
                        </button>
                        <button type="button" 
                                class="btn btn-danger btn-lg mb-2" 
                                style="border-radius: 10px; font-weight: 700;"
                                onclick="quickReject()">
                            <i class="fas fa-times-circle mr-2"></i>Tolak Pengajuan
                        </button>
                        @endif
                        <button type="button" 
                                class="btn btn-info btn-lg" 
                                style="border-radius: 10px; font-weight: 700;"
                                onclick="window.print()">
                            <i class="fas fa-print mr-2"></i>Cetak Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function quickApprove() {
    Swal.fire({
        title: 'Setujui Pengajuan?',
        text: 'Apakah Anda yakin ingin menyetujui pengajuan ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya, Setujui!',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Update form and submit
            $('select[name="status"]').val('disetujui');
            $('textarea[name="catatan_admin"]').val('Pengajuan disetujui');
            $('form').submit();
        }
    });
}

function quickReject() {
    Swal.fire({
        title: 'Tolak Pengajuan?',
        html: `
            <p>Apakah Anda yakin ingin menolak pengajuan ini?</p>
            <textarea id="reject-reason" class="form-control mt-3" rows="3" placeholder="Masukkan alasan penolakan..."></textarea>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-times mr-2"></i>Ya, Tolak!',
        cancelButtonText: '<i class="fas fa-arrow-left mr-2"></i>Batal',
        reverseButtons: true,
        preConfirm: () => {
            const reason = document.getElementById('reject-reason').value;
            if (!reason) {
                Swal.showValidationMessage('Mohon masukkan alasan penolakan');
            }
            return reason;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Update form and submit
            $('select[name="status"]').val('ditolak');
            $('textarea[name="catatan_admin"]').val(result.value);
            $('form').submit();
        }
    });
}
</script>
@endpush
