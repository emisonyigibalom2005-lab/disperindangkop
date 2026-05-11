@extends("layouts.app")
@section("title","Edit Jadwal")
@section("page-title","Edit Jadwal")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{ route('admin.jadwal.index') }}">Jadwal</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@push('styles')
<style>
    /* Card Modern */
    .card-modern {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: none;
        margin-bottom: 24px;
    }

    .card-modern-header {
        background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
        padding: 16px 24px;
        border-radius: 12px 12px 0 0;
    }

    .card-modern-title {
        font-size: 18px;
        font-weight: 700;
        color: white;
        margin: 0;
    }

    .card-modern-title i {
        margin-right: 10px;
    }

    .card-modern-body {
        padding: 24px;
    }

    /* Section Header */
    .section-header {
        background: #f3f4f6;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #e5e7eb;
    }

    .section-header h6 {
        font-size: 14px;
        font-weight: 700;
        color: #1a3a6e;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .section-header i {
        color: #f59e0b;
        margin-right: 8px;
    }

    /* Form Group Modern */
    .form-group-modern {
        margin-bottom: 20px;
    }

    .form-label-modern {
        font-size: 13px;
        font-weight: 700;
        color: #1a3a6e;
        margin-bottom: 8px;
        display: block;
    }

    .form-label-modern i {
        margin-right: 6px;
        color: #3b82f6;
    }

    .form-label-modern .required {
        color: #ef4444;
        margin-left: 4px;
    }

    /* Form Control Modern */
    .form-control-modern {
        border-radius: 8px;
        border: 2px solid #d1d5db;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control-modern:focus {
        border-color: #1a3a6e;
        box-shadow: 0 0 0 3px rgba(26, 58, 110, 0.1);
        background: white;
        outline: none;
    }

    .form-control-modern.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .form-control-modern.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    textarea.form-control-modern {
        resize: vertical;
        min-height: 80px;
    }

    select.form-control-modern {
        cursor: pointer;
    }

    /* Info Box */
    .info-box {
        background: #eff6ff;
        padding: 10px 14px;
        border-radius: 6px;
        margin-top: 8px;
        border: 1px solid #bfdbfe;
    }

    .info-box small {
        color: #1e40af;
        font-size: 12px;
        display: block;
        line-height: 1.5;
    }

    .info-box i {
        color: #3b82f6;
        margin-right: 6px;
    }

    /* Multi Select Info */
    .multi-select-info {
        background: #fef3c7;
        padding: 10px 14px;
        border-radius: 6px;
        margin-top: 8px;
        border: 1px solid #fde68a;
    }

    .multi-select-info small {
        color: #92400e;
        font-size: 12px;
        font-weight: 500;
    }

    .multi-select-info i {
        color: #f59e0b;
        margin-right: 6px;
    }

    /* Switch Modern */
    .switch-container {
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 16px;
        margin-top: 20px;
        transition: all 0.3s ease;
    }

    .switch-container:hover {
        background: #f0f9ff;
        border-color: #bfdbfe;
    }

    .custom-switch-modern .custom-control-label {
        font-weight: 600;
        color: #1a3a6e;
        cursor: pointer;
        padding-left: 10px;
    }

    .custom-switch-modern .custom-control-label::before {
        width: 50px;
        height: 26px;
        border-radius: 13px;
        background: #d1d5db;
        border: none;
        transition: all 0.3s ease;
    }

    .custom-switch-modern .custom-control-label::after {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        top: 3px;
        left: -21px;
        transition: all 0.3s ease;
    }

    .custom-switch-modern .custom-control-input:checked ~ .custom-control-label::before {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    /* Button Modern */
    .btn-modern {
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-modern i {
        margin-right: 8px;
    }

    .btn-save {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .btn-save:hover {
        background: linear-gradient(135deg, #059669, #047857);
        color: white;
    }

    .btn-cancel {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
    }

    .btn-cancel:hover {
        background: linear-gradient(135deg, #4b5563, #374151);
        color: white;
    }

    /* Invalid Feedback */
    .invalid-feedback {
        display: block;
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
        font-weight: 500;
    }

    /* Section Divider */
    .section-divider {
        border: none;
        border-top: 2px solid #e5e7eb;
        margin: 30px 0;
    }
</style>
@endpush

@section("content")
<div class="card-modern">
    <div class="card-modern-header">
        <h3 class="card-modern-title">
            <i class="fas fa-edit"></i>Perbarui Informasi Jadwal Kegiatan
        </h3>
    </div>
    <div class="card-modern-body">
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" style="border-radius:8px;border-left:4px solid #ef4444">
            <i class="fas fa-exclamation-circle mr-2"></i><strong>Terdapat kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
        @endif

        <form action="{{ route('admin.jadwal.update',$jadwal) }}" method="POST">
            @csrf @method("PUT")
            
            <div class="row">
                {{-- Main Content --}}
                <div class="col-md-8">
                    {{-- Informasi Dasar --}}
                    <div class="section-header">
                        <h6><i class="fas fa-info-circle"></i>Informasi Dasar</h6>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-heading"></i>Judul Jadwal<span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="judul" 
                               class="form-control-modern @error('judul') is-invalid @enderror"
                               value="{{ old('judul',$jadwal->judul) }}" 
                               placeholder="Contoh: Verifikasi Koperasi Distrik Bokondini" 
                               required>
                        @error("judul")
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-align-left"></i>Deskripsi
                        </label>
                        <textarea name="deskripsi" 
                                  rows="4" 
                                  class="form-control-modern" 
                                  placeholder="Jelaskan detail kegiatan yang akan dilaksanakan...">{{ old('deskripsi',$jadwal->deskripsi) }}</textarea>
                        <div class="info-box">
                            <small>
                                <i class="fas fa-lightbulb"></i>
                                Deskripsi akan ditampilkan di laporan dan detail jadwal
                            </small>
                        </div>
                    </div>

                    {{-- Waktu & Lokasi --}}
                    <div class="section-header">
                        <h6><i class="fas fa-clock"></i>Waktu & Lokasi</h6>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-calendar"></i>Tanggal<span class="required">*</span>
                                </label>
                                <input type="date" 
                                       name="tanggal" 
                                       class="form-control-modern" 
                                       value="{{ old('tanggal',$jadwal->tanggal->format('Y-m-d')) }}" 
                                       required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-clock"></i>Jam Mulai<span class="required">*</span>
                                </label>
                                <input type="time" 
                                       name="jam_mulai" 
                                       class="form-control-modern" 
                                       value="{{ old('jam_mulai',substr($jadwal->jam_mulai,0,5)) }}" 
                                       required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-clock"></i>Jam Selesai
                                </label>
                                <input type="time" 
                                       name="jam_selesai" 
                                       class="form-control-modern" 
                                       value="{{ old('jam_selesai',$jadwal->jam_selesai?substr($jadwal->jam_selesai,0,5):'') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-map-marker-alt"></i>Lokasi
                        </label>
                        <input type="text" 
                               name="lokasi" 
                               class="form-control-modern" 
                               value="{{ old('lokasi',$jadwal->lokasi) }}" 
                               placeholder="Contoh: Aula DISPERINDAGKOP Karubaga">
                    </div>

                    {{-- Koperasi & Catatan --}}
                    <div class="section-header">
                        <h6><i class="fas fa-store"></i>Koperasi & Catatan</h6>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-users"></i>Koperasi yang Terlibat
                        </label>
                        <select name="koperasi_ids[]" 
                                class="form-control-modern" 
                                multiple 
                                style="height:120px;background:white">
                            @foreach($koperasiList as $u)
                            <option value="{{ $u->id }}" {{ $jadwal->koperasiList->contains($u->id) ? 'selected' : '' }}>
                                {{ $u->nama_usaha }} ({{ $u->pemilik }})
                            </option>
                            @endforeach
                        </select>
                        <div class="multi-select-info">
                            <small>
                                <i class="fas fa-info-circle"></i>
                                Tahan tombol <strong>Ctrl</strong> (Windows) atau <strong>Cmd</strong> (Mac) untuk memilih beberapa koperasi
                            </small>
                        </div>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-sticky-note"></i>Catatan
                        </label>
                        <textarea name="catatan" 
                                  rows="3" 
                                  class="form-control-modern" 
                                  placeholder="Tambahkan catatan khusus jika diperlukan...">{{ old('catatan',$jadwal->catatan) }}</textarea>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-md-4">
                    {{-- Pengaturan --}}
                    <div class="section-header">
                        <h6><i class="fas fa-cog"></i>Pengaturan</h6>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-tag"></i>Jenis Jadwal<span class="required">*</span>
                        </label>
                        <select name="jenis" class="form-control-modern" required>
                            <option value="verifikasi" {{ old('jenis', $jadwal->jenis) == 'verifikasi' ? 'selected' : '' }}>
                                Verifikasi Lapangan
                            </option>
                            <option value="pelatihan" {{ old('jenis', $jadwal->jenis) == 'pelatihan' ? 'selected' : '' }}>
                                Pelatihan/Pembinaan
                            </option>
                            <option value="penilaian_bantuan" {{ old('jenis', $jadwal->jenis) == 'penilaian_bantuan' ? 'selected' : '' }}>
                                Penilaian Bantuan
                            </option>
                            <option value="rapat" {{ old('jenis', $jadwal->jenis) == 'rapat' ? 'selected' : '' }}>
                                Rapat/Pertemuan
                            </option>
                        </select>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-info-circle"></i>Status
                        </label>
                        <select name="status" class="form-control-modern">
                            <option value="dijadwalkan" {{ old('status', $jadwal->status) == 'dijadwalkan' ? 'selected' : '' }}>
                                Dijadwalkan
                            </option>
                            <option value="berlangsung" {{ old('status', $jadwal->status) == 'berlangsung' ? 'selected' : '' }}>
                                Berlangsung
                            </option>
                            <option value="selesai" {{ old('status', $jadwal->status) == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                            <option value="dibatalkan" {{ old('status', $jadwal->status) == 'dibatalkan' ? 'selected' : '' }}>
                                Dibatalkan
                            </option>
                        </select>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-user-tie"></i>Petugas Pelaksana
                        </label>
                        <select name="petugas_id" class="form-control-modern">
                            <option value="">-- Pilih Petugas --</option>
                            @foreach($petugas as $p)
                            <option value="{{ $p->id }}" {{ old('petugas_id', $jadwal->petugas_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="switch-container">
                        <div class="custom-control custom-switch custom-switch-modern">
                            <input type="checkbox" 
                                   class="custom-control-input" 
                                   id="is_publik" 
                                   name="is_publik" 
                                   {{ old('is_publik', $jadwal->is_publik) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_publik">
                                <i class="fas fa-globe mr-2"></i>Tampilkan ke Publik
                                <small class="d-block text-muted mt-1" style="font-weight:400">
                                    Jadwal dapat dilihat oleh umum di website
                                </small>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-cancel btn-modern">
                    <i class="fas fa-times"></i>Batal
                </a>
                <button type="submit" class="btn btn-save btn-modern">
                    <i class="fas fa-save"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
