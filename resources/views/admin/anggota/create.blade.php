@extends('layouts.app')
@section('title','Tambah Anggota')
@section('page-title','Tambah Anggota Baru')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.anggota.index') }}">Data Anggota</a></li>
    <li class="breadcrumb-item active">Tambah Anggota Baru</li>
@endsection
@push('styles')
<style>
.step-header { background:linear-gradient(135deg,#1a3a6e,#2d5aa0); border-radius:16px; padding:24px 30px; color:white; margin-bottom:24px; }
.steps-nav { display:flex; align-items:center; justify-content:center; margin-top:20px; }
.step-item { display:flex; flex-direction:column; align-items:center; position:relative; flex:1; }
.step-item:not(:last-child)::after { content:''; position:absolute; top:18px; left:60%; width:80%; height:2px; background:rgba(255,255,255,.3); }
.step-item.active:not(:last-child)::after { background:rgba(255,255,255,.8); }
.step-circle { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:14px; border:3px solid rgba(255,255,255,.4); color:rgba(255,255,255,.6); }
.step-item.active .step-circle { background:white; color:#1a3a6e; border-color:white; }
.step-item.done .step-circle { background:rgba(255,255,255,.3); border-color:white; color:white; }
.step-label { font-size:11px; margin-top:6px; opacity:.7; font-weight:600; }
.step-item.active .step-label { opacity:1; }
.form-card { background:white; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,.08); overflow:hidden; }
.form-section { display:none; }
.form-section.active { display:block; }
.section-title { padding:20px 30px; border-bottom:2px solid #f0f4ff; }
.section-title h5 { color:#1a3a6e; font-weight:700; margin:0; }
.form-body { padding:30px; }
.form-footer { padding:20px 30px; background:#f8f9ff; border-top:1px solid #eef; display:flex; justify-content:space-between; align-items:center; }
.btn-next, .btn-prev { border-radius:10px; padding:10px 28px; font-weight:700; font-size:14px; }
.form-label { font-weight:600; color:#374151; font-size:13px; margin-bottom:6px; }
.form-control { border-radius:10px; border:2px solid #e5e7eb; padding:10px 14px; font-size:14px; transition:.3s; }
.form-control:focus { border-color:#1a3a6e; box-shadow:0 0 0 3px rgba(26,58,110,.1); }
</style>
@endpush
@section('content')

{{-- Step Header --}}
<div class="step-header">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h4 class="mb-1 font-weight-bold"><i class="fas fa-user-plus mr-2"></i>Tambah Anggota Baru</h4>
            <p class="mb-0" style="opacity:.8;font-size:14px">Lengkapi formulir berikut untuk menambahkan anggota baru ke koperasi</p>
        </div>
        <div style="background:rgba(255,255,255,.15);border-radius:10px;padding:8px 16px;font-size:13px;">
            <i class="fas fa-id-badge mr-1"></i>No. Anggota: Auto-generate
        </div>
    </div>
    <div class="steps-nav mt-3">
        <div class="step-item active" id="step-nav-1">
            <div class="step-circle">1</div>
            <div class="step-label">Data Pribadi</div>
        </div>
        <div class="step-item" id="step-nav-2">
            <div class="step-circle">2</div>
            <div class="step-label">Alamat</div>
        </div>
        <div class="step-item" id="step-nav-3">
            <div class="step-circle">3</div>
            <div class="step-label">Data Usaha</div>
        </div>
        <div class="step-item" id="step-nav-4">
            <div class="step-circle">4</div>
            <div class="step-label">Status</div>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('admin.anggota.store') }}" enctype="multipart/form-data" id="formAnggota">
@csrf
<div class="form-card">
    {{-- Step 1: Data Pribadi --}}
    <div class="form-section active" id="section-1">
        <div class="section-title">
            <h5><i class="fas fa-id-card mr-2" style="color:#1a3a6e"></i>Data Pribadi</h5>
        </div>
        <div class="form-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIK (16 digit) <span class="text-danger">*</span></label>
                    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" placeholder="16 digit NIK" value="{{ old('nik') }}" maxlength="16">
                    @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama lengkap sesuai KTP" value="{{ old('nama') }}">
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" name="tempat_lahir" class="form-control" placeholder="Kota/Kabupaten" value="{{ old('tempat_lahir') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-control">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin')=='L'?'selected':'' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin')=='P'?'selected':'' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Agama <span class="text-danger">*</span></label>
                    <select name="agama" class="form-control">
                        <option value="">Pilih Agama</option>
                        @foreach(['Kristen','Islam','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                        <option value="{{ $ag }}" {{ old('agama')==$ag?'selected':'' }}>{{ $ag }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">No. HP/WhatsApp <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text" style="border-radius:10px 0 0 10px;border:2px solid #e5e7eb;border-right:none"><i class="fas fa-phone"></i></span></div>
                        <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('no_hp') }}" style="border-radius:0 10px 10px 0">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text" style="border-radius:10px 0 0 10px;border:2px solid #e5e7eb;border-right:none"><i class="fas fa-envelope"></i></span></div>
                        <input type="email" name="email" class="form-control" placeholder="email@contoh.com" value="{{ old('email') }}" style="border-radius:0 10px 10px 0">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Foto</label>
                    <div class="custom-file">
                        <input type="file" name="foto" class="custom-file-input" id="foto" accept="image/*">
                        <label class="custom-file-label" for="foto" style="border-radius:10px">Pilih foto...</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('admin.anggota.index') }}" class="btn btn-light btn-prev">
                <i class="fas fa-arrow-left mr-1"></i>Kembali ke Daftar Anggota
            </a>
            <button type="button" class="btn btn-primary btn-next" onclick="nextStep(2)">
                Selanjutnya <i class="fas fa-arrow-right ml-1"></i>
            </button>
        </div>
    </div>

    {{-- Step 2: Alamat --}}
    <div class="form-section" id="section-2">
        <div class="section-title">
            <h5><i class="fas fa-map-marker-alt mr-2" style="color:#1a3a6e"></i>Alamat</h5>
        </div>
        <div class="form-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Desa</label>
                    <input type="text" name="desa" class="form-control" placeholder="Nama desa" value="{{ old('desa') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Distrik <span class="text-danger">*</span></label>
                    <select name="distrik" class="form-control @error('distrik') is-invalid @enderror">
                        <option value="">-- Pilih Distrik --</option>
                        @foreach(['Karubaga','Bokondini','Tiom','Kembu','Bewani','Bokoneri','Geya','Nabunage','Kanggime','Wugi','Kagime','Lainnya'] as $d)
                        <option value="{{ $d }}" {{ old('distrik')==$d?'selected':'' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                    @error('distrik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kabupaten</label>
                    <input type="text" name="kabupaten" class="form-control" value="{{ old('kabupaten','Tolikara') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" class="form-control" rows="3" placeholder="Alamat lengkap...">{{ old('alamat_lengkap') }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Komplek/Dekat Desa</label>
                    <input type="text" name="nama_komplek_dekat_desa" class="form-control" value="{{ old('nama_komplek_dekat_desa') }}" placeholder="Nama komplek atau patokan terdekat">
                </div>
            </div>
        </div>
        <div class="form-footer">
            <button type="button" class="btn btn-light btn-prev" onclick="prevStep(1)">
                <i class="fas fa-arrow-left mr-1"></i>Sebelumnya
            </button>
            <button type="button" class="btn btn-primary btn-next" onclick="nextStep(3)">
                Selanjutnya <i class="fas fa-arrow-right ml-1"></i>
            </button>
        </div>
    </div>

    {{-- Step 3: Data Usaha --}}
    <div class="form-section" id="section-3">
        <div class="section-title">
            <h5><i class="fas fa-store mr-2" style="color:#1a3a6e"></i>Data Usaha</h5>
        </div>
        <div class="form-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Nama Usaha <span class="text-danger">*</span></label>
                    <input type="text" name="nama_usaha" class="form-control @error('nama_usaha') is-invalid @enderror" placeholder="Nama usaha/bisnis" value="{{ old('nama_usaha') }}">
                    @error('nama_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Modal Usaha (Rp)</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text" style="border-radius:10px 0 0 10px;border:2px solid #e5e7eb;border-right:none">Rp</span></div>
                        <input type="number" name="modal_usaha" class="form-control" value="{{ old('modal_usaha',0) }}" style="border-radius:0 10px 10px 0">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Omzet per Bulan (Rp)</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text" style="border-radius:10px 0 0 10px;border:2px solid #e5e7eb;border-right:none">Rp</span></div>
                        <input type="number" name="omzet_per_bulan" class="form-control" value="{{ old('omzet_per_bulan',0) }}" style="border-radius:0 10px 10px 0">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Total Simpanan (Rp)</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text" style="border-radius:10px 0 0 10px;border:2px solid #e5e7eb;border-right:none">Rp</span></div>
                        <input type="number" name="total_simpanan" class="form-control" value="{{ old('total_simpanan',0) }}" style="border-radius:0 10px 10px 0">
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Keterangan Usaha</label>
                    <textarea name="keterangan_usaha" class="form-control" rows="4" placeholder="Deskripsi singkat tentang usaha...">{{ old('keterangan_usaha') }}</textarea>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <button type="button" class="btn btn-light btn-prev" onclick="prevStep(2)">
                <i class="fas fa-arrow-left mr-1"></i>Sebelumnya
            </button>
            <button type="button" class="btn btn-primary btn-next" onclick="nextStep(4)">
                Selanjutnya <i class="fas fa-arrow-right ml-1"></i>
            </button>
        </div>
    </div>

    {{-- Step 4: Status --}}
    <div class="form-section" id="section-4">
        <div class="section-title">
            <h5><i class="fas fa-check-circle mr-2" style="color:#1a3a6e"></i>Status Keanggotaan</h5>
        </div>
        <div class="form-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="form-group mb-4">
                        <label class="form-label">Status Anggota <span class="text-danger">*</span></label>
                        <div class="row mt-2">
                            @foreach(['Aktif'=>['color'=>'#d1fae5','text'=>'#065f46','icon'=>'fas fa-check-circle','desc'=>'Anggota aktif dan terverifikasi'],'Pending'=>['color'=>'#fef3c7','text'=>'#92400e','icon'=>'fas fa-clock','desc'=>'Menunggu verifikasi admin'],'Nonaktif'=>['color'=>'#fee2e2','text'=>'#991b1b','icon'=>'fas fa-times-circle','desc'=>'Keanggotaan tidak aktif']] as $s=>$sc)
                            <div class="col-md-4 mb-3">
                                <label style="cursor:pointer">
                                    <input type="radio" name="status" value="{{ $s }}" {{ old('status','Pending')==$s?'checked':'' }} style="display:none" class="status-radio">
                                    <div class="status-card p-3 text-center border rounded" style="border-radius:12px!important;transition:.2s;background:{{ $sc['color'] }};border-color:{{ $sc['color'] }}!important;">
                                        <i class="{{ $sc['icon'] }} fa-2x mb-2" style="color:{{ $sc['text'] }}"></i>
                                        <div class="font-weight-bold" style="color:{{ $sc['text'] }}">{{ $s }}</div>
                                        <small style="color:{{ $sc['text'] }};opacity:.8">{{ $sc['desc'] }}</small>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Summary --}}
                    <div class="card border-0" style="background:#f0f4ff;border-radius:12px;">
                        <div class="card-body p-4">
                            <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-clipboard-list mr-2"></i>Ringkasan</h6>
                            <div class="row" style="font-size:13px">
                                <div class="col-6"><span class="text-muted">NIK:</span> <strong id="sum-nik">-</strong></div>
                                <div class="col-6"><span class="text-muted">Nama:</span> <strong id="sum-nama">-</strong></div>
                                <div class="col-6 mt-2"><span class="text-muted">Distrik:</span> <strong id="sum-distrik">-</strong></div>
                                <div class="col-6 mt-2"><span class="text-muted">Usaha:</span> <strong id="sum-usaha">-</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <button type="button" class="btn btn-light btn-prev" onclick="prevStep(3)">
                <i class="fas fa-arrow-left mr-1"></i>Sebelumnya
            </button>
            <button type="submit" class="btn btn-success btn-next">
                <i class="fas fa-save mr-1"></i>Simpan Anggota
            </button>
        </div>
    </div>
</div>
</form>

@endsection
@push('scripts')
<script>
function nextStep(step) {
    document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));
    document.getElementById('section-'+step).classList.add('active');
    document.querySelectorAll('.step-item').forEach((item, i) => {
        item.classList.remove('active','done');
        if (i+1 < step) item.classList.add('done');
        if (i+1 === step) item.classList.add('active');
    });
    // Update summary
    document.getElementById('sum-nik').textContent = document.querySelector('[name=nik]').value || '-';
    document.getElementById('sum-nama').textContent = document.querySelector('[name=nama]').value || '-';
    document.getElementById('sum-distrik').textContent = document.querySelector('[name=distrik]').value || '-';
    document.getElementById('sum-usaha').textContent = document.querySelector('[name=nama_usaha]').value || '-';
    window.scrollTo(0,0);
}
function prevStep(step) { nextStep(step); }

// File input
document.querySelector('.custom-file-input').addEventListener('change',function(e){
    document.querySelector('.custom-file-label').textContent = e.target.files[0]?e.target.files[0].name:'Pilih foto...';
});
</script>
@endpush