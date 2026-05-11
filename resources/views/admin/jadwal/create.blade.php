@extends("layouts.app")
@section("title","Buat Jadwal")

@push('styles')
<style>
    /* Header Card */
    .jadwal-header-card {
        background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 20px rgba(26, 58, 110, 0.2);
        margin-bottom: 30px;
        overflow: hidden;
        position: relative;
    }

    .jadwal-header-card::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    /* Form Card */
    .form-card-modern {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
    }

    .form-section-header {
        background: #f3f4f6;
        padding: 16px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-section-title {
        font-size: 15px;
        font-weight: 700;
        color: #1a3a6e;
        margin: 0;
    }

    .form-section-title i {
        color: #f5a623;
        margin-right: 8px;
    }

    .form-section-body {
        padding: 24px;
    }

    /* Form Labels */
    .form-label-modern {
        font-weight: 600;
        color: #374151;
        font-size: 14px;
        margin-bottom: 8px;
        display: block;
    }

    /* Form Controls */
    .form-control-modern,
    .form-select-modern {
        border-radius: 10px;
        border: 2px solid #d1d5db;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control-modern:focus,
    .form-select-modern:focus {
        border-color: #1a3a6e;
        box-shadow: 0 0 0 3px rgba(26, 58, 110, 0.1);
        outline: none;
    }

    textarea.form-control-modern {
        min-height: 100px;
        line-height: 1.6;
        resize: vertical;
    }

    /* Info Box */
    .info-box-modern {
        background: #eff6ff;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
        border: 1px solid #bfdbfe;
    }

    .info-box-modern i {
        color: #1e40af;
        font-size: 18px;
        margin-right: 10px;
    }

    .info-box-modern strong {
        color: #1e40af;
    }

    .info-box-modern p {
        color: #1e40af;
        margin: 0;
        font-size: 14px;
    }

    /* Buttons */
    .btn-save-modern {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 28px;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-save-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-cancel-modern {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: 12px 28px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-cancel-modern:hover {
        background: #e5e7eb;
        color: #374151;
    }

    /* Custom Switch */
    .custom-switch-modern {
        padding: 16px;
        background: #f9fafb;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
    }

    .custom-switch-modern .custom-control-label {
        font-weight: 600;
        color: #374151;
    }

    .custom-switch-modern .custom-control-label small {
        display: block;
        font-weight: 400;
        color: #6b7280;
        margin-top: 4px;
    }
</style>
@endpush

@section("content")
<div class="container-fluid">
    {{-- Header --}}
    <div class="jadwal-header-card">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center text-white flex-wrap">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div style="width:60px;height:60px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-right:20px;position:relative;z-index:1">
                        <i class="fas fa-calendar-plus fa-2x"></i>
                    </div>
                    <div style="position:relative;z-index:1">
                        <h3 class="mb-1 font-weight-bold">Buat Jadwal Baru</h3>
                        <p class="mb-0" style="opacity:0.9;font-size:0.95rem">Tambahkan jadwal kegiatan kantor DISPERINDAGKOP</p>
                    </div>
                </div>
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-light" style="border-radius:10px;font-weight:600;position:relative;z-index:1">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- Info Box --}}
    <div class="info-box-modern">
        <div class="d-flex align-items-start">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Tips Membuat Jadwal:</strong>
                <p>Pastikan tanggal, waktu, dan lokasi sudah benar. Pilih petugas pelaksana dan tentukan apakah jadwal perlu ditampilkan ke publik.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.jadwal.store') }}" method="POST">
        @csrf
        
        <div class="row">
            {{-- Main Form --}}
            <div class="col-lg-8">
                {{-- Informasi Jadwal --}}
                <div class="form-card-modern mb-4">
                    <div class="form-section-header">
                        <h5 class="form-section-title">
                            <i class="fas fa-file-alt"></i>Informasi Jadwal
                        </h5>
                    </div>
                    <div class="form-section-body">
                        <div class="form-group">
                            <label class="form-label-modern">
                                Judul Jadwal <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="judul" 
                                   class="form-control form-control-modern @error('judul') is-invalid @enderror"
                                   value="{{ old('judul') }}" 
                                   placeholder="Contoh: Verifikasi Koperasi Distrik Bokondini" 
                                   required>
                            @error("judul")<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label-modern">
                                Deskripsi
                            </label>
                            <textarea name="deskripsi" 
                                      class="form-control form-control-modern @error('deskripsi') is-invalid @enderror"
                                      placeholder="Jelaskan detail kegiatan...">{{ old('deskripsi') }}</textarea>
                            @error("deskripsi")<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Waktu & Lokasi --}}
                <div class="form-card-modern mb-4">
                    <div class="form-section-header">
                        <h5 class="form-section-title">
                            <i class="fas fa-clock"></i>Waktu & Lokasi
                        </h5>
                    </div>
                    <div class="form-section-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label-modern">
                                        Tanggal <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="tanggal" 
                                           class="form-control form-control-modern @error('tanggal') is-invalid @enderror"
                                           value="{{ old('tanggal', date('Y-m-d')) }}" 
                                           required>
                                    @error("tanggal")<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label-modern">
                                        Jam Mulai <span class="text-danger">*</span>
                                    </label>
                                    <input type="time" name="jam_mulai" 
                                           class="form-control form-control-modern @error('jam_mulai') is-invalid @enderror"
                                           value="{{ old('jam_mulai', '08:00') }}" 
                                           required>
                                    @error("jam_mulai")<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label-modern">
                                        Jam Selesai
                                    </label>
                                    <input type="time" name="jam_selesai" 
                                           class="form-control form-control-modern @error('jam_selesai') is-invalid @enderror"
                                           value="{{ old('jam_selesai') }}">
                                    @error("jam_selesai")<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label-modern">
                                Lokasi
                            </label>
                            <input type="text" name="lokasi" 
                                   class="form-control form-control-modern @error('lokasi') is-invalid @enderror"
                                   value="{{ old('lokasi') }}" 
                                   placeholder="Contoh: Aula DISPERINDAGKOP Tolikara">
                            @error("lokasi")<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-0">
                            <label class="form-label-modern">
                                Catatan
                            </label>
                            <textarea name="catatan" 
                                      class="form-control form-control-modern @error('catatan') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                            @error("catatan")<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Koperasi Terlibat --}}
                <div class="form-card-modern">
                    <div class="form-section-header">
                        <h5 class="form-section-title">
                            <i class="fas fa-users"></i>Koperasi yang Terlibat
                        </h5>
                    </div>
                    <div class="form-section-body">
                        <div class="form-group mb-0">
                            <label class="form-label-modern">
                                Pilih Koperasi
                            </label>
                            <select name="koperasi_ids[]" 
                                    class="form-control form-control-modern @error('koperasi_ids') is-invalid @enderror"
                                    multiple 
                                    style="height:150px">
                                @foreach($koperasiList as $u)
                                <option value="{{ $u->id }}">{{ $u->nama_usaha }} ({{ $u->pemilik }})</option>
                                @endforeach
                            </select>
                            @error("koperasi_ids")<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Pengaturan --}}
                <div class="form-card-modern mb-4">
                    <div class="form-section-header">
                        <h5 class="form-section-title">
                            <i class="fas fa-cog"></i>Pengaturan
                        </h5>
                    </div>
                    <div class="form-section-body">
                        <div class="form-group">
                            <label class="form-label-modern">
                                Jenis Jadwal <span class="text-danger">*</span>
                            </label>
                            <select name="jenis" 
                                    class="form-control form-control-modern @error('jenis') is-invalid @enderror"
                                    required>
                                <option value="verifikasi">Verifikasi Lapangan</option>
                                <option value="pelatihan">Pelatihan/Pembinaan</option>
                                <option value="penilaian_bantuan">Penilaian Bantuan</option>
                                <option value="rapat">Rapat/Pertemuan</option>
                            </select>
                            @error("jenis")<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label-modern">
                                Status
                            </label>
                            <select name="status" 
                                    class="form-control form-control-modern @error('status') is-invalid @enderror">
                                <option value="dijadwalkan" selected>Dijadwalkan</option>
                                <option value="berlangsung">Berlangsung</option>
                                <option value="selesai">Selesai</option>
                                <option value="dibatalkan">Dibatalkan</option>
                            </select>
                            @error("status")<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-0">
                            <label class="form-label-modern">
                                Petugas Pelaksana
                            </label>
                            <select name="petugas_id" 
                                    class="form-control form-control-modern @error('petugas_id') is-invalid @enderror">
                                <option value="">-- Pilih Petugas --</option>
                                @foreach($petugas as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            @error("petugas_id")<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Visibilitas --}}
                <div class="form-card-modern">
                    <div class="form-section-header">
                        <h5 class="form-section-title">
                            <i class="fas fa-eye"></i>Visibilitas
                        </h5>
                    </div>
                    <div class="form-section-body">
                        <div class="custom-control custom-switch custom-switch-modern">
                            <input type="checkbox" class="custom-control-input" id="is_publik" name="is_publik">
                            <label class="custom-control-label" for="is_publik">
                                Tampilkan ke Publik
                                <small>Jadwal akan ditampilkan di website publik</small>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="form-card-modern mt-4">
            <div class="card-body p-3" style="background:#f8f9ff">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-cancel-modern">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" class="btn-save-modern">
                        <i class="fas fa-save mr-2"></i>Simpan Jadwal
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
