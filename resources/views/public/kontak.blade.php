@extends('public.layouts.app')
@section('title','Hubungi Kami - DISPERINDAGKOP Tolikara')

@push('styles')
<style>
/* Hero Section */
.contact-hero {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 50%, #3d6ab0 100%);
    padding: 100px 0 80px;
    color: #fff;
    position: relative;
    overflow: hidden;
}

.contact-hero::before {
    content: '';
    position: absolute;
    width: 600px;
    height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(245,166,35,0.15), transparent);
    top: -250px;
    right: -200px;
    animation: float 8s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

/* Contact Cards */
.contact-info-card {
    background: white;
    border-radius: 20px;
    padding: 35px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    transition: all 0.4s;
    height: 100%;
    border: 2px solid transparent;
}

.contact-info-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(26,58,110,0.15);
    border-color: #f5a623;
}

.contact-icon {
    width: 70px;
    height: 70px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin-bottom: 20px;
    transition: all 0.3s;
}

.contact-info-card:hover .contact-icon {
    transform: scale(1.1) rotate(5deg);
}

.contact-title {
    font-size: 18px;
    font-weight: 700;
    color: #1a3a6e;
    margin-bottom: 12px;
}

.contact-text {
    color: #64748b;
    font-size: 15px;
    line-height: 1.7;
    margin: 0;
}

/* Form Card */
.form-card {
    background: white;
    border-radius: 24px;
    padding: 50px 80px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    margin-top: 40px;
}

.form-label {
    font-weight: 700;
    color: #1a3a6e;
    font-size: 14px;
    margin-bottom: 10px;
    display: block;
}

.form-control-modern {
    border: 2px solid #e0e7ff;
    border-radius: 12px;
    padding: 16px 20px;
    font-size: 15px;
    transition: all 0.3s;
    width: 100%;
}

.form-control-modern:focus {
    border-color: #1a3a6e;
    box-shadow: 0 0 0 4px rgba(26,58,110,0.1);
    outline: none;
}

.form-control-modern::placeholder {
    color: #cbd5e1;
}

.btn-send {
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 16px 40px;
    font-size: 16px;
    font-weight: 700;
    transition: all 0.3s;
    box-shadow: 0 8px 20px rgba(26,58,110,0.3);
    width: 100%;
}

.btn-send:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(26,58,110,0.4);
    background: linear-gradient(135deg, #2d5aa0, #1a3a6e);
    color: white;
}

.alert-modern {
    border-radius: 16px;
    border: none;
    padding: 18px 24px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 600;
}

.alert-success-modern {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
}

.alert-info-modern {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
}

/* Animation */
.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.contact-info-card:nth-child(1) { animation-delay: 0.1s; }
.contact-info-card:nth-child(2) { animation-delay: 0.2s; }
.contact-info-card:nth-child(3) { animation-delay: 0.3s; }
.contact-info-card:nth-child(4) { animation-delay: 0.4s; }

@media (max-width: 1200px) {
    .container-fluid {
        padding-left: 30px !important;
        padding-right: 30px !important;
    }
}

@media (max-width: 992px) {
    .form-card {
        padding: 40px 35px;
    }
    .container-fluid {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }
}

@media (max-width: 768px) {
    .contact-hero {
        padding: 60px 0 40px;
    }
    
    .form-card {
        padding: 30px 20px;
    }
}
</style>
@endpush

@section('content')
{{-- Hero Section --}}
<div class="contact-hero">
    <div class="container" style="position:relative;z-index:1">
        <div class="text-center">
            <div style="width:90px;height:90px;background:linear-gradient(135deg,rgba(245,166,35,0.25),rgba(251,191,36,0.25));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;backdrop-filter:blur(15px);border:3px solid rgba(255,255,255,0.2)">
                <i class="fas fa-envelope fa-2x" style="color:#f5a623"></i>
            </div>
            <h1 style="font-size:2.8rem;font-weight:900;margin-bottom:15px;text-shadow:0 4px 20px rgba(0,0,0,0.3)">
                📧 Hubungi Kami
            </h1>
            <p style="font-size:1.15rem;opacity:0.95;max-width:650px;margin:0 auto">
                Kami siap membantu Anda. Hubungi kami melalui informasi kontak di bawah atau kirim pesan langsung
            </p>
        </div>
    </div>
</div>

{{-- Main Content --}}
<section style="padding:80px 0;background:linear-gradient(to bottom, #f8f9fa, #ffffff)">
    <div class="container-fluid" style="max-width:1400px;padding-left:40px;padding-right:40px">
        
        {{-- Contact Info Cards --}}
        <div class="row mb-5 g-4" style="margin-top:-80px;position:relative;z-index:2">
            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="contact-info-card fade-in-up">
                    <div class="contact-icon" style="background:linear-gradient(135deg,#3b82f6,#2563eb);color:white">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h5 class="contact-title">Alamat Kantor</h5>
                    <p class="contact-text">
                        Jl. Raya Karubaga, Kecamatan Kanggime, Kabupaten Tolikara, Papua Pegunungan 99551
                    </p>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="contact-info-card fade-in-up">
                    <div class="contact-icon" style="background:linear-gradient(135deg,#10b981,#059669);color:white">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h5 class="contact-title">Telepon</h5>
                    <p class="contact-text">
                        <a href="tel:0964123456" style="color:#10b981;text-decoration:none;font-weight:600">(0964) 123456</a>
                        <br>
                        <small style="color:#94a3b8">Senin - Jumat</small>
                    </p>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="contact-info-card fade-in-up">
                    <div class="contact-icon" style="background:linear-gradient(135deg,#f59e0b,#d97706);color:white">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5 class="contact-title">Email</h5>
                    <p class="contact-text">
                        <a href="mailto:info@disperindagkop.tolikara.go.id" style="color:#f59e0b;text-decoration:none;font-weight:600;word-break:break-all">
                            info@disperindagkop.tolikara.go.id
                        </a>
                    </p>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="contact-info-card fade-in-up">
                    <div class="contact-icon" style="background:linear-gradient(135deg,#ef4444,#dc2626);color:white">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h5 class="contact-title">Jam Layanan</h5>
                    <p class="contact-text">
                        <strong>Senin - Jumat</strong><br>
                        08:00 - 16:00 WIT<br>
                        <small style="color:#94a3b8">Sabtu - Minggu: Tutup</small>
                    </p>
                </div>
            </div>
        </div>

        {{-- Contact Form --}}
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="form-card fade-in-up">
                    <div class="text-center mb-4">
                        <h2 style="font-size:2rem;font-weight:800;color:#1a3a6e;margin-bottom:12px">
                            <i class="fas fa-paper-plane mr-2" style="color:#f5a623"></i>
                            Kirim Pesan
                        </h2>
                        <p style="color:#64748b;font-size:15px;margin:0">
                            Isi formulir di bawah ini dan kami akan segera merespons pesan Anda
                        </p>
                    </div>

                    @if(session("success"))
                    <div class="alert-modern alert-success-modern">
                        <i class="fas fa-check-circle" style="font-size:24px"></i>
                        <div>{{ session("success") }}</div>
                    </div>
                    @endif

                    @if(session("error"))
                    <div class="alert-modern" style="background:linear-gradient(135deg,#fee2e2,#fecaca);color:#991b1b">
                        <i class="fas fa-exclamation-circle" style="font-size:24px"></i>
                        <div>{{ session("error") }}</div>
                    </div>
                    @endif

                    <div class="alert-info-modern alert-modern mb-4">
                        <i class="fas fa-info-circle" style="font-size:24px"></i>
                        <div>Untuk layanan lebih cepat, hubungi kami melalui telepon atau email langsung</div>
                    </div>

                    <form method="POST" action="{{ route('public.kontak.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-user mr-2" style="color:#f5a623"></i>
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="nama" 
                                       class="form-control-modern @error('nama') is-invalid @enderror"
                                       placeholder="Masukkan nama lengkap Anda" 
                                       value="{{ old('nama') }}" 
                                       required 
                                       minlength="3">
                                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-lg-6 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-envelope mr-2" style="color:#f5a623"></i>
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       class="form-control-modern @error('email') is-invalid @enderror"
                                       placeholder="email@anda.com" 
                                       value="{{ old('email') }}" 
                                       required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-phone mr-2" style="color:#f5a623"></i>
                                    No. Telepon <small class="text-muted">(opsional)</small>
                                </label>
                                <input type="text" 
                                       name="no_hp" 
                                       class="form-control-modern @error('no_hp') is-invalid @enderror"
                                       placeholder="08xx-xxxx-xxxx" 
                                       value="{{ old('no_hp') }}" 
                                       minlength="10">
                                @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-lg-6 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-tag mr-2" style="color:#f5a623"></i>
                                    Subjek <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="subjek" 
                                       class="form-control-modern @error('subjek') is-invalid @enderror"
                                       placeholder="Perihal pesan Anda" 
                                       value="{{ old('subjek') }}" 
                                       required>
                                @error('subjek')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-comment-alt mr-2" style="color:#f5a623"></i>
                                Pesan <span class="text-danger">*</span>
                            </label>
                            <textarea name="pesan" 
                                      class="form-control-modern @error('pesan') is-invalid @enderror"
                                      rows="7" 
                                      placeholder="Tulis pesan Anda di sini... (minimal 10 karakter)"
                                      required 
                                      minlength="10">{{ old('pesan') }}</textarea>
                            @error('pesan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn-send">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Pesan Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
