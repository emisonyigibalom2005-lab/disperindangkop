@extends('public.layouts.app')
@section('title', 'Visi & Misi - DISPERINDAGKOP Tolikara')
@section('content')

{{-- Hero Header --}}
<div style="background:linear-gradient(135deg,#0d2240,#1a3a6e,#2d5aa0);padding:100px 0 80px;position:relative;overflow:hidden">
    <div style="position:absolute;top:0;left:0;right:0;bottom:0;opacity:.08;background:url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" fill="white"/></svg>') repeat"></div>
    <div style="position:absolute;top:-100px;right:-100px;width:400px;height:400px;background:rgba(245,166,35,.12);border-radius:50%;filter:blur(60px)"></div>
    <div style="position:absolute;bottom:-80px;left:-80px;width:350px;height:350px;background:rgba(245,166,35,.08);border-radius:50%;filter:blur(50px)"></div>
    
    <div class="container-fluid" style="max-width:1500px;padding-left:50px;padding-right:50px;position:relative;z-index:1">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div style="display:inline-flex;align-items:center;gap:14px;background:rgba(245,166,35,.18);padding:10px 24px;border-radius:40px;margin-bottom:24px;border:2px solid rgba(245,166,35,.3)">
                    <i class="fas fa-bullseye" style="color:#f5a623;font-size:20px"></i>
                    <span style="color:#f5a623;font-weight:700;font-size:14px;letter-spacing:.8px;text-transform:uppercase">Profil Dinas</span>
                </div>
                <h1 style="color:#fff;font-size:3.8rem;font-weight:900;margin-bottom:20px;line-height:1.2;text-shadow:0 4px 20px rgba(0,0,0,0.3)">🎯 Visi & Misi</h1>
                <p style="color:rgba(255,255,255,.92);font-size:1.25rem;margin-bottom:0;line-height:1.8;max-width:750px;font-weight:500">
                    Arah dan tujuan strategis Dinas Perindustrian, Perdagangan, dan Koperasi Kabupaten Tolikara dalam memajukan perekonomian daerah menuju kesejahteraan masyarakat yang berkelanjutan
                </p>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div style="width:220px;height:220px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;box-shadow:0 25px 70px rgba(0,0,0,.3);animation:float 6s ease-in-out infinite;padding:20px">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo DISPERINDAGKOP" style="width:100%;height:100%;object-fit:contain">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}
</style>

{{-- Breadcrumb --}}
<div style="background:#f8f9fa;padding:16px 0;border-bottom:1px solid #e9ecef">
    <div class="container">
        <div class="d-flex align-items-center" style="gap:8px;font-size:14px">
            <a href="{{ route('public.home') }}" style="color:#6c757d;text-decoration:none">
                <i class="fas fa-home"></i> Beranda
            </a>
            <i class="fas fa-chevron-right" style="font-size:10px;color:#adb5bd"></i>
            <span style="color:#1a3a6e;font-weight:600">Visi & Misi</span>
        </div>
    </div>
</div>

{{-- Main Content --}}
<div style="padding:80px 0;background:linear-gradient(to bottom, #f8f9fa, #ffffff)">
    <div class="container-fluid" style="max-width:1500px;padding-left:50px;padding-right:50px">
        <div class="row">
            {{-- Main Content --}}
            <div class="col-lg-9">
                @if($visiMisi)
                {{-- Visi Section --}}
                <div style="background:#fff;border-radius:24px;box-shadow:0 10px 40px rgba(0,0,0,.1);padding:55px 60px;margin-bottom:35px;border:2px solid #f0f2f7;transition:all .3s" onmouseover="this.style.borderColor='#1a3a6e'" onmouseout="this.style.borderColor='#f0f2f7'">
                    <div style="display:flex;align-items:center;gap:24px;margin-bottom:40px">
                        <div style="width:80px;height:80px;background:linear-gradient(135deg,#1a3a6e,#2d5aa0);border-radius:20px;display:flex;align-items:center;justify-content:center;box-shadow:0 12px 30px rgba(26,58,110,.35)">
                            <i class="fas fa-eye" style="font-size:38px;color:#f5a623"></i>
                        </div>
                        <div>
                            <h2 style="color:#1a3a6e;font-size:2.8rem;font-weight:900;margin:0;line-height:1">VISI</h2>
                            <p style="color:#6c757d;font-size:16px;margin:8px 0 0;font-weight:700;letter-spacing:0.8px">Pandangan Masa Depan</p>
                        </div>
                    </div>
                    
                    <div style="background:linear-gradient(135deg,#f0f4ff,#e8f0fe);border-left:6px solid #1a3a6e;padding:40px 45px;border-radius:16px;box-shadow:0 6px 20px rgba(26,58,110,.1)">
                        <p style="font-size:1.4rem;line-height:2.1;color:#1a3a6e;font-weight:700;margin:0;font-style:italic;text-align:center">
                            "{{ $visiMisi->visi }}"
                        </p>
                    </div>
                    
                    @if($visiMisi->gambar)
                    <div style="margin-top:30px;text-align:center">
                        <img src="{{ asset('storage/'.$visiMisi->gambar) }}" alt="Visi & Misi" style="max-width:100%;height:auto;border-radius:16px;box-shadow:0 8px 30px rgba(0,0,0,.1)">
                    </div>
                    @endif
                </div>

                {{-- Misi Section --}}
                <div style="background:#fff;border-radius:24px;box-shadow:0 10px 40px rgba(0,0,0,.1);padding:55px 60px;border:2px solid #f0f2f7;transition:all .3s" onmouseover="this.style.borderColor='#f5a623'" onmouseout="this.style.borderColor='#f0f2f7'">
                    <div style="display:flex;align-items:center;gap:24px;margin-bottom:40px">
                        <div style="width:80px;height:80px;background:linear-gradient(135deg,#f5a623,#fdb944);border-radius:20px;display:flex;align-items:center;justify-content:center;box-shadow:0 12px 30px rgba(245,166,35,.4)">
                            <i class="fas fa-rocket" style="font-size:38px;color:#0d2240"></i>
                        </div>
                        <div>
                            <h2 style="color:#1a3a6e;font-size:2.8rem;font-weight:900;margin:0;line-height:1">MISI</h2>
                            <p style="color:#6c757d;font-size:16px;margin:8px 0 0;font-weight:700;letter-spacing:0.8px">Langkah Strategis</p>
                        </div>
                    </div>

                    <div style="background:linear-gradient(135deg,#fff8f0,#fff);border-left:6px solid #f5a623;padding:40px 45px;border-radius:16px;box-shadow:0 6px 20px rgba(245,166,35,.1)">
                        <div style="font-size:1.15rem;line-height:2.2;color:#495057">
                            {!! nl2br(e($visiMisi->misi)) !!}
                        </div>
                    </div>
                </div>
                @else
                {{-- Empty State --}}
                <div style="background:#fff;border-radius:24px;box-shadow:0 10px 40px rgba(0,0,0,.1);padding:80px 60px;text-align:center">
                    <div style="width:120px;height:120px;background:linear-gradient(135deg,#e5e7eb,#d1d5db);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 30px">
                        <i class="fas fa-bullseye fa-3x" style="color:#9ca3af"></i>
                    </div>
                    <h3 style="color:#6b7280;font-weight:700;margin-bottom:15px">Visi & Misi Belum Tersedia</h3>
                    <p style="color:#9ca3af;font-size:16px;margin:0">Informasi visi dan misi sedang dalam proses penyusunan</p>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-3">
                {{-- Menu Profil --}}
                <div style="background:#fff;border-radius:16px;box-shadow:0 8px 30px rgba(0,0,0,.08);overflow:hidden;margin-bottom:24px;border:1px solid #f0f2f7">
                    <div style="background:linear-gradient(135deg,#1a3a6e,#2d5aa0);padding:20px">
                        <h5 style="color:#fff;font-weight:700;margin:0;font-size:16px">
                            <i class="fas fa-building" style="color:#f5a623;margin-right:10px"></i>Menu Profil
                        </h5>
                    </div>
                    <div style="padding:8px">
                        @php
                        $menuProfil = [
                            ['visi-misi','fas fa-bullseye','Visi & Misi'],
                            ['struktur-organisasi','fas fa-sitemap','Struktur Organisasi'],
                           
                            ['koperasi','fas fa-handshake','Koperasi'],
                        ];
                        @endphp
                        @foreach($menuProfil as $m)
                        <a href="{{ route('public.halaman', $m[0]) }}" 
                           style="display:flex;align-items:center;gap:12px;padding:14px 16px;border-radius:10px;text-decoration:none;transition:all .2s;margin-bottom:4px;{{ $m[0] === 'visi-misi' ? 'background:linear-gradient(135deg,#1a3a6e,#2d5aa0);color:#fff' : 'color:#495057' }}"
                           onmouseover="if('{{ $m[0] }}' !== 'visi-misi') this.style.background='#f8f9fa'"
                           onmouseout="if('{{ $m[0] }}' !== 'visi-misi') this.style.background='transparent'">
                            <i class="{{ $m[1] }}" style="width:20px;color:{{ $m[0] === 'visi-misi' ? '#f5a623' : '#6c757d' }};font-size:16px"></i>
                            <span style="font-weight:600;font-size:14px">{{ $m[2] }}</span>
                            @if($m[0] === 'visi-misi')
                            <i class="fas fa-chevron-right ml-auto" style="color:#f5a623;font-size:12px"></i>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Info Box --}}
                <div style="background:linear-gradient(135deg,#f5a623,#fdb944);border-radius:16px;padding:30px;box-shadow:0 8px 30px rgba(245,166,35,.3);margin-bottom:24px">
                    <div style="text-align:center;margin-bottom:20px">
                        <i class="fas fa-info-circle" style="font-size:48px;color:#0d2240"></i>
                    </div>
                    <h5 style="color:#0d2240;font-weight:800;text-align:center;margin-bottom:16px;font-size:18px">Butuh Informasi?</h5>
                    <p style="color:#0d2240;font-size:14px;text-align:center;margin-bottom:20px;opacity:.9">Hubungi kami untuk informasi lebih lanjut tentang program dan layanan kami</p>
                    <a href="{{ route('public.kontak') }}" style="display:block;background:#0d2240;color:#fff;text-align:center;padding:12px;border-radius:10px;text-decoration:none;font-weight:700;font-size:14px;transition:all .2s" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 20px rgba(13,34,64,.3)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
                        <i class="fas fa-envelope mr-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
