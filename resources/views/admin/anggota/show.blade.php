@extends('layouts.app')
@section('title', 'Detail Verifikasi Anggota')

@section('content')
<style>
@media print {
    .no-print { display: none !important; }
    .print-only { display: block !important; }
    body { background: white; }
    .card { box-shadow: none !important; border: 1px solid #ddd !important; }
}
@media screen {
    .print-only { display: none; }
}

.verification-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    margin-bottom: 24px;
    overflow: hidden;
}

.section-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    padding: 16px 24px;
    font-weight: 700;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.data-row {
    display: flex;
    padding: 16px 24px;
    border-bottom: 1px solid #f3f4f6;
    transition: background 0.2s;
}

.data-row:hover {
    background: #f9fafb;
}

.data-row:last-child {
    border-bottom: none;
}

.data-label {
    flex: 0 0 200px;
    font-weight: 600;
    color: #6b7280;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.data-value {
    flex: 1;
    font-weight: 600;
    color: #1f2937;
    font-size: 14px;
}

.photo-container {
    position: relative;
    display: inline-block;
}

.photo-frame {
    width: 200px;
    height: 250px;
    object-fit: cover;
    border-radius: 12px;
    border: 4px solid #1e3a8a;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.verification-buttons {
    display: flex;
    gap: 16px;
    margin-top: 24px;
}

.btn-verify {
    flex: 1;
    padding: 16px 24px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s;
    border: none;
}

.btn-verify:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.btn-approve {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-reject {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.status-badge-large {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.badge-pending {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.badge-approved {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.badge-rejected {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}
</style>

<div class="container-fluid" style="max-width: 1400px;">
    {{-- Header Section --}}
    <div class="row mb-4 no-print">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(30, 58, 138, 0.3);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-3">
                                <div style="background: white; padding: 12px; border-radius: 12px; margin-right: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                    <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 70px; height: auto;">
                                </div>
                                <div class="text-white">
                                    <h5 class="mb-1" style="font-weight: 800; font-size: 18px; letter-spacing: 0.5px;">PEMERINTAH KABUPATEN TOLIKARA</h5>
                                    <h6 class="mb-0" style="font-weight: 700; font-size: 14px;">DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI</h6>
                                </div>
                            </div>
                            <div class="text-white" style="border-top: 2px solid rgba(255,255,255,0.3); padding-top: 16px;">
                                <h3 class="mb-2" style="font-weight: 800; font-size: 28px;">{{ $anggota->nama }}</h3>
                                <div class="d-flex align-items-center flex-wrap" style="gap: 12px;">
                                    <span class="badge" style="background: rgba(255,255,255,0.2); color: white; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;">
                                        <i class="fas fa-id-card mr-2"></i>{{ $anggota->no_anggota }}
                                    </span>
                                    @if($anggota->status == 'Pending')
                                    <span class="status-badge-large badge-pending">
                                        <i class="fas fa-clock"></i>Menunggu Verifikasi
                                    </span>
                                    @elseif($anggota->status == 'Aktif')
                                    <span class="status-badge-large badge-approved">
                                        <i class="fas fa-check-circle"></i>Disetujui
                                    </span>
                                    @elseif($anggota->status == 'Ditolak')
                                    <span class="status-badge-large badge-rejected">
                                        <i class="fas fa-times-circle"></i>Ditolak
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="photo-container">
                                <img src="{{ $anggota->foto_url }}" alt="Foto {{ $anggota->nama }}" class="photo-frame">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="row mb-4 no-print">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                @php
                    // Tentukan URL kembali berdasarkan status anggota
                    $backUrl = route('admin.anggota.verifikasi'); // Default ke verifikasi
                    
                    // Jika anggota sudah punya tanggal_bergabung (sudah diverifikasi), kembali ke data anggota
                    if ($anggota->tanggal_bergabung) {
                        $backUrl = route('admin.anggota.index');
                    }
                    
                    // Jika ada session previous_url dan berasal dari halaman admin, gunakan itu
                    if (session('previous_url') && str_contains(session('previous_url'), 'admin/anggota')) {
                        $backUrl = session('previous_url');
                    }
                @endphp
                <a href="{{ $backUrl }}" class="btn btn-secondary btn-lg" style="border-radius: 12px; font-weight: 700;">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <button onclick="window.print()" class="btn btn-info btn-lg" style="border-radius: 12px; font-weight: 700;">
                    <i class="fas fa-print mr-2"></i>Cetak Dokumen
                </button>
            </div>
        </div>
    </div>

    {{-- Data Pribadi --}}
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="verification-card">
                <div class="section-header">
                    <i class="fas fa-user-circle fa-lg"></i>
                    <span>DATA PRIBADI</span>
                </div>
                <div class="data-row">
                    <div class="data-label">NIK</div>
                    <div class="data-value">{{ $anggota->nik ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Nama Lengkap</div>
                    <div class="data-value">{{ $anggota->nama }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Tempat, Tgl Lahir</div>
                    <div class="data-value">
                        {{ $anggota->tempat_lahir ?? '-' }}, 
                        {{ $anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d M Y') : '-' }}
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-label">Jenis Kelamin</div>
                    <div class="data-value">
                        @if($anggota->jenis_kelamin == 'L')
                            <i class="fas fa-male text-primary mr-2"></i>Laki-laki
                        @else
                            <i class="fas fa-female text-danger mr-2"></i>Perempuan
                        @endif
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-label">Agama</div>
                    <div class="data-value">{{ $anggota->agama ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Status Perkawinan</div>
                    <div class="data-value">{{ $anggota->status_perkawinan ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Pendidikan Terakhir</div>
                    <div class="data-value">{{ $anggota->pendidikan_terakhir ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="verification-card">
                <div class="section-header">
                    <i class="fas fa-phone fa-lg"></i>
                    <span>KONTAK & ALAMAT</span>
                </div>
                <div class="data-row">
                    <div class="data-label">No. HP</div>
                    <div class="data-value">
                        <i class="fas fa-phone text-success mr-2"></i>{{ $anggota->no_hp ?? '-' }}
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-label">Email</div>
                    <div class="data-value">
                        <i class="fas fa-envelope text-info mr-2"></i>{{ $anggota->email ?? '-' }}
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-label">Alamat Lengkap</div>
                    <div class="data-value">{{ $anggota->alamat_lengkap ?? $anggota->alamat ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Desa</div>
                    <div class="data-value">{{ $anggota->desa ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Distrik</div>
                    <div class="data-value">
                        <i class="fas fa-map-marker-alt text-danger mr-2"></i>{{ $anggota->distrik ?? '-' }}
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-label">Kabupaten</div>
                    <div class="data-value">{{ $anggota->kabupaten ?? 'Tolikara' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Kode Pos</div>
                    <div class="data-value">{{ $anggota->kode_pos ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Usaha --}}
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="verification-card">
                <div class="section-header">
                    <i class="fas fa-store fa-lg"></i>
                    <span>DATA USAHA</span>
                </div>
                <div class="data-row">
                    <div class="data-label">Nama Usaha</div>
                    <div class="data-value">{{ $anggota->nama_usaha ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Bidang Usaha</div>
                    <div class="data-value">{{ $anggota->bidang_usaha ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Modal Usaha</div>
                    <div class="data-value text-primary">
                        <strong>Rp {{ number_format($anggota->modal_usaha ?? 0, 0, ',', '.') }}</strong>
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-label">Omzet per Bulan</div>
                    <div class="data-value text-success">
                        <strong>Rp {{ number_format($anggota->omzet_per_bulan ?? 0, 0, ',', '.') }}</strong>
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-label">Lama Berdiri</div>
                    <div class="data-value">{{ $anggota->lama_berdiri_usaha ?? '-' }} tahun</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Jumlah Karyawan</div>
                    <div class="data-value">{{ $anggota->jumlah_karyawan ?? '-' }} orang</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Alamat Usaha</div>
                    <div class="data-value">{{ $anggota->alamat_tempat_usaha ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="verification-card">
                <div class="section-header">
                    <i class="fas fa-money-bill-wave fa-lg"></i>
                    <span>DATA KEUANGAN</span>
                </div>
                <div class="data-row">
                    <div class="data-label">Simpanan Pokok</div>
                    <div class="data-value text-primary">
                        <strong>Rp {{ number_format($anggota->simpanan_pokok ?? 0, 0, ',', '.') }}</strong>
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-label">Simpanan Wajib</div>
                    <div class="data-value text-warning">
                        <strong>Rp {{ number_format($anggota->simpanan_wajib ?? 0, 0, ',', '.') }}</strong>
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-label">Total Simpanan</div>
                    <div class="data-value text-success">
                        <strong>Rp {{ number_format(($anggota->simpanan_pokok ?? 0) + ($anggota->simpanan_wajib ?? 0), 0, ',', '.') }}</strong>
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-label">Tanggal Bergabung</div>
                    <div class="data-value">
                        <i class="fas fa-calendar text-info mr-2"></i>
                        {{ $anggota->tanggal_bergabung ? \Carbon\Carbon::parse($anggota->tanggal_bergabung)->format('d M Y') : '-' }}
                    </div>
                </div>
            </div>

            <div class="verification-card">
                <div class="section-header">
                    <i class="fas fa-users fa-lg"></i>
                    <span>DATA AHLI WARIS</span>
                </div>
                <div class="data-row">
                    <div class="data-label">Nama Ahli Waris</div>
                    <div class="data-value">{{ $anggota->nama_ahli_waris ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Hubungan</div>
                    <div class="data-value">{{ $anggota->hubungan_ahli_waris ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">NIK Ahli Waris</div>
                    <div class="data-value">{{ $anggota->nik_ahli_waris ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">No. HP Ahli Waris</div>
                    <div class="data-value">
                        <i class="fas fa-phone text-success mr-2"></i>{{ $anggota->no_hp_ahli_waris ?? '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Verification Section (Only for Pending Status) --}}
    @if($anggota->status == 'Pending')
    <div class="row no-print">
        <div class="col-12">
            <div class="verification-card" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 3px solid #f59e0b;">
                <div class="section-header" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="fas fa-clipboard-check fa-lg"></i>
                    <span>VERIFIKASI PENDAFTARAN</span>
                </div>
                <div class="p-4">
                    <div class="alert alert-warning mb-4" style="border-radius: 12px; border-left: 4px solid #f59e0b;">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Perhatian!</strong> Pastikan semua data sudah diperiksa dengan teliti sebelum melakukan verifikasi.
                    </div>
                    
                    <div class="verification-buttons">
                        <button type="button" class="btn-verify btn-approve" onclick="approveAnggota({{ $anggota->id }}, '{{ $anggota->nama }}')">
                            <i class="fas fa-check-circle fa-lg"></i>
                            <span>SETUJUI PENDAFTARAN</span>
                        </button>
                        <button type="button" class="btn-verify btn-reject" onclick="rejectAnggota({{ $anggota->id }}, '{{ $anggota->nama }}')">
                            <i class="fas fa-times-circle fa-lg"></i>
                            <span>TOLAK PENDAFTARAN</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Verification Info (For Approved/Rejected) --}}
    @if($anggota->status != 'Pending')
    <div class="row">
        <div class="col-12">
            <div class="verification-card">
                <div class="section-header">
                    <i class="fas fa-info-circle fa-lg"></i>
                    <span>INFORMASI VERIFIKASI</span>
                </div>
                <div class="data-row">
                    <div class="data-label">Status</div>
                    <div class="data-value">
                        @if($anggota->status == 'Aktif')
                            <span class="badge badge-success" style="padding: 8px 16px; font-size: 14px;">
                                <i class="fas fa-check-circle mr-2"></i>Disetujui
                            </span>
                        @else
                            <span class="badge badge-danger" style="padding: 8px 16px; font-size: 14px;">
                                <i class="fas fa-times-circle mr-2"></i>Ditolak
                            </span>
                        @endif
                    </div>
                </div>
                @if($anggota->tanggal_verifikasi)
                <div class="data-row">
                    <div class="data-label">Tanggal Verifikasi</div>
                    <div class="data-value">
                        <i class="fas fa-calendar-check text-success mr-2"></i>
                        {{ \Carbon\Carbon::parse($anggota->tanggal_verifikasi)->format('d M Y, H:i') }} WIT
                    </div>
                </div>
                @endif
                @if($anggota->catatan_verifikasi)
                <div class="data-row">
                    <div class="data-label">Catatan</div>
                    <div class="data-value">{{ $anggota->catatan_verifikasi }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Modal Approve --}}
<div class="modal fade" id="modalApprove" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #10b981, #059669); color: white; border: none;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-check-circle mr-2"></i>Setujui Pendaftaran
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formApprove" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="Aktif">
                <div class="modal-body p-4">
                    <div class="alert alert-success" style="border-radius: 12px;">
                        <i class="fas fa-info-circle mr-2"></i>
                        Anda akan menyetujui pendaftaran anggota:
                    </div>
                    <div class="text-center mb-4">
                        <h4 class="font-weight-bold text-primary" id="namaAnggotaApprove"></h4>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Catatan (Opsional)</label>
                        <textarea name="catatan_verifikasi" class="form-control" rows="3" 
                                  placeholder="Tambahkan catatan verifikasi..."
                                  style="border-radius: 10px; border: 2px solid #e5e7eb;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border: none; padding: 20px;">
                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal" style="border-radius: 10px; font-weight: 700;">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success btn-lg" style="border-radius: 10px; font-weight: 700;">
                        <i class="fas fa-check-circle mr-2"></i>Ya, Setujui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Reject --}}
<div class="modal fade" id="modalReject" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border: none;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-times-circle mr-2"></i>Tolak Pendaftaran
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formReject" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="Ditolak">
                <div class="modal-body p-4">
                    <div class="alert alert-danger" style="border-radius: 12px;">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Anda akan menolak pendaftaran anggota:
                    </div>
                    <div class="text-center mb-4">
                        <h4 class="font-weight-bold text-danger" id="namaAnggotaReject"></h4>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="catatan_verifikasi" class="form-control" rows="4" 
                                  placeholder="Jelaskan alasan penolakan pendaftaran..."
                                  style="border-radius: 10px; border: 2px solid #e5e7eb;" required></textarea>
                        <small class="text-muted">Alasan penolakan akan dikirimkan ke anggota</small>
                    </div>
                </div>
                <div class="modal-footer" style="border: none; padding: 20px;">
                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal" style="border-radius: 10px; font-weight: 700;">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-danger btn-lg" style="border-radius: 10px; font-weight: 700;">
                        <i class="fas fa-times-circle mr-2"></i>Ya, Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function approveAnggota(id, nama) {
    document.getElementById('namaAnggotaApprove').textContent = nama;
    document.getElementById('formApprove').action = '/admin/anggota/' + id + '/status';
    $('#modalApprove').modal('show');
}

function rejectAnggota(id, nama) {
    document.getElementById('namaAnggotaReject').textContent = nama;
    document.getElementById('formReject').action = '/admin/anggota/' + id + '/status';
    $('#modalReject').modal('show');
}
</script>

@endsection
