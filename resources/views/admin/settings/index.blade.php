@extends('layouts.admin')
@section('title', 'Pengaturan Sistem')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Pengaturan Sistem</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header fw-bold">Pengaturan Footer & Identitas</div>
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Instansi / Situs</label>
                    <input type="text" name="site_name"
                        class="form-control @error('site_name') is-invalid @enderror"
                        value="{{ old('site_name', $settings['site_name'] ?? '') }}">
                    @error('site_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <hr>
                <h6 class="text-muted mb-3">Informasi Footer</h6>

                <div class="mb-3">
                    <label class="form-label">Teks Copyright</label>
                    <input type="text" name="footer_copyright"
                        class="form-control @error('footer_copyright') is-invalid @enderror"
                        value="{{ old('footer_copyright', $settings['footer_copyright'] ?? '') }}">
                    <div class="form-text">Contoh: © 2025 DISPERINDAGKOP Kabupaten Tolikara. All rights reserved.</div>
                    @error('footer_copyright') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="footer_address" rows="2"
                        class="form-control @error('footer_address') is-invalid @enderror">{{ old('footer_address', $settings['footer_address'] ?? '') }}</textarea>
                    @error('footer_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="footer_phone"
                            class="form-control @error('footer_phone') is-invalid @enderror"
                            value="{{ old('footer_phone', $settings['footer_phone'] ?? '') }}">
                        @error('footer_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="footer_email"
                            class="form-control @error('footer_email') is-invalid @enderror"
                            value="{{ old('footer_email', $settings['footer_email'] ?? '') }}">
                        @error('footer_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Website</label>
                        <input type="text" name="footer_website"
                            class="form-control @error('footer_website') is-invalid @enderror"
                            value="{{ old('footer_website', $settings['footer_website'] ?? '') }}">
                        @error('footer_website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </form>
        </div>
    </div>

    {{-- Pengaturan Pendaftaran --}}
    <div class="card mt-4">
        <div class="card-header fw-bold"><i class="fas fa-users mr-2"></i>Pengaturan Pendaftaran Anggota Koperasi</div>
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Status Pendaftaran</label>
                        <select name="pendaftaran_buka" class="form-control">
                            <option value="1" {{ ($settings['pendaftaran_buka'] ?? '0') == '1' ? 'selected' : '' }}>Dibuka</option>
                            <option value="0" {{ ($settings['pendaftaran_buka'] ?? '0') == '0' ? 'selected' : '' }}>Ditutup</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Tanggal Mulai</label>
                        <input type="date" name="pendaftaran_mulai" class="form-control"
                            value="{{ $settings['pendaftaran_mulai'] ?? '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Tanggal Selesai</label>
                        <input type="date" name="pendaftaran_selesai" class="form-control"
                            value="{{ $settings['pendaftaran_selesai'] ?? '' }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Simpan</button>
            </form>
        </div>
    </div>

    {{-- Preview Footer --}}
    <div class="card mt-4">
        <div class="card-header fw-bold">Preview Footer</div>
        <div class="card-body p-0">
            <footer style="background:#2d3436; color:#dfe6e9; padding:20px 30px;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <div>
                        <strong style="color:white;">{{ $settings['site_name'] ?? '-' }}</strong><br>
                        <small>{{ $settings['footer_address'] ?? '-' }}</small>
                    </div>
                    <div style="text-align:right;">
                        <small>📞 {{ $settings['footer_phone'] ?? '-' }}</small><br>
                        <small>✉️ {{ $settings['footer_email'] ?? '-' }}</small><br>
                        <small>🌐 {{ $settings['footer_website'] ?? '-' }}</small>
                    </div>
                </div>
                <hr style="border-color:#636e72; margin:15px 0 10px;">
                <p style="text-align:center; margin:0; font-size:12px; color:#b2bec3;">
                    {{ $settings['footer_copyright'] ?? '-' }}
                </p>
            </footer>
        </div>
    </div>
</div>
@endsection