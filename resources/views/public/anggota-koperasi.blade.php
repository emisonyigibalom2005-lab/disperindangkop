@extends('public.layouts.app')
@section('title','Anggota Koperasi Terdaftar - DISPERINDAGKOP Tolikara')

@push('styles')
<style>
.hero-anggota {
    background: linear-gradient(135deg, #1a3a6e 0%, #2d5aa0 50%, #3d6ab0 100%);
    padding: 80px 0 60px;
    color: #fff;
    position: relative;
    overflow: hidden;
}

.hero-anggota::before {
    content: '';
    position: absolute;
    width: 500px;
    height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(245,166,35,0.15), transparent);
    top: -200px;
    right: -150px;
    animation: float 8s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-20px) scale(1.05); }
}

.stats-card {
    background: #fff;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border-left: 5px solid #1a3a6e;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.12);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 15px;
}

.anggota-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid #e5e7eb;
    height: 100%;
}

.anggota-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(26,58,110,0.15);
    border-color: #1a3a6e;
}

.anggota-header {
    background: linear-gradient(135deg, #1a3a6e, #2d5aa0);
    padding: 20px;
    text-align: center;
    position: relative;
}

.anggota-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f5a623, #fdb944);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-size: 32px;
    color: #fff;
    font-weight: 800;
    box-shadow: 0 4px 15px rgba(245,166,35,0.4);
    border: 4px solid rgba(255,255,255,0.3);
}

.anggota-body {
    padding: 20px;
}

.info-row {
    display: flex;
    align-items: flex-start;
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f3f4f6;
}

.info-row:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.info-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    flex-shrink: 0;
    font-size: 14px;
}

.distrik-badge {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    display: inline-block;
    margin-bottom: 10px;
    box-shadow: 0 4px 12px rgba(59,130,246,0.3);
}

.desa-badge {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
}

.filter-card {
    background: #fff;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

.distrik-group {
    background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 30px;
    border-left: 5px solid #0284c7;
}

.distrik-title {
    font-size: 24px;
    font-weight: 900;
    color: #1a3a6e;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.distrik-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #0284c7, #0369a1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 20px;
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border-radius: 20px;
    border: 2px dashed #e5e7eb;
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #e5e7eb, #d1d5db);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 40px;
    color: #9ca3af;
}
</style>
@endpush

@section('content')
{{-- Hero Section --}}
<div class="hero-anggota">
    <div class="container" style="position:relative;z-index:1">
        <div class="text-center">
            <div style="width:90px;height:90px;background:linear-gradient(135deg,rgba(245,166,35,0.25),rgba(251,191,36,0.25));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;backdrop-filter:blur(15px);border:3px solid rgba(255,255,255,0.2);box-shadow:0 8px 32px rgba(0,0,0,0.15)">
                <i class="fas fa-users fa-3x" style="color:#f5a623"></i>
            </div>
            <h1 style="font-size:2.5rem;font-weight:900;margin-bottom:15px;text-shadow:0 4px 20px rgba(0,0,0,0.3)">
                Anggota Koperasi Terdaftar
            </h1>
            <p style="font-size:1.1rem;opacity:0.95;max-width:600px;margin:0 auto;line-height:1.6">
                Daftar anggota koperasi yang telah terverifikasi dan aktif di Kabupaten Tolikara
            </p>
        </div>
    </div>
</div>

{{-- Statistik Section --}}
<section style="padding:40px 0;background:#f8f9fa">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="stats-card">
                    <div class="stats-icon" style="background:linear-gradient(135deg,#dbeafe,#bfdbfe)">
                        <i class="fas fa-users" style="color:#1e40af"></i>
                    </div>
                    <h3 style="font-size:32px;font-weight:900;color:#1a3a6e;margin-bottom:5px">{{ number_format($stats['total_anggota']) }}</h3>
                    <p style="color:#6b7280;margin:0;font-size:14px;font-weight:600">Total Anggota Aktif</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stats-card" style="border-left-color:#10b981">
                    <div class="stats-icon" style="background:linear-gradient(135deg,#d1fae5,#a7f3d0)">
                        <i class="fas fa-map-marked-alt" style="color:#047857"></i>
                    </div>
                    <h3 style="font-size:32px;font-weight:900;color:#1a3a6e;margin-bottom:5px">{{ $stats['total_distrik'] }}</h3>
                    <p style="color:#6b7280;margin:0;font-size:14px;font-weight:600">Distrik Terdaftar</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stats-card" style="border-left-color:#f59e0b">
                    <div class="stats-icon" style="background:linear-gradient(135deg,#fef3c7,#fde68a)">
                        <i class="fas fa-map-marker-alt" style="color:#d97706"></i>
                    </div>
                    <h3 style="font-size:32px;font-weight:900;color:#1a3a6e;margin-bottom:5px">{{ $stats['total_desa'] }}</h3>
                    <p style="color:#6b7280;margin:0;font-size:14px;font-weight:600">Desa/Kelurahan</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Filter & Content Section --}}
<section style="padding:50px 0;background:#fff">
    <div class="container">
        {{-- Filter Card --}}
        <div class="filter-card">
            <h5 style="font-weight:800;color:#1a3a6e;margin-bottom:20px">
                <i class="fas fa-filter mr-2"></i>Filter Pencarian
            </h5>
            <form method="GET">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label style="font-weight:600;color:#374151;font-size:13px;margin-bottom:8px">
                            <i class="fas fa-search mr-1"></i>Cari Anggota
                        </label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Nama, No. Anggota, NIK, Usaha..." 
                               value="{{ request('search') }}"
                               style="border-radius:10px;border:2px solid #e5e7eb">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label style="font-weight:600;color:#374151;font-size:13px;margin-bottom:8px">
                            <i class="fas fa-map-marked-alt mr-1"></i>Distrik
                        </label>
                        <select name="distrik" class="form-control" id="distrikSelect"
                                style="border-radius:10px;border:2px solid #e5e7eb">
                            <option value="">Semua Distrik</option>
                            @foreach($distrikList as $d)
                            <option value="{{ $d }}" {{ request('distrik') == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label style="font-weight:600;color:#374151;font-size:13px;margin-bottom:8px">
                            <i class="fas fa-map-marker-alt mr-1"></i>Desa/Kelurahan
                        </label>
                        <select name="desa" class="form-control"
                                style="border-radius:10px;border:2px solid #e5e7eb"
                                {{ !request('distrik') ? 'disabled' : '' }}>
                            <option value="">Semua Desa</option>
                            @foreach($desaList as $desa)
                            <option value="{{ $desa }}" {{ request('desa') == $desa ? 'selected' : '' }}>{{ $desa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label style="font-weight:600;color:#374151;font-size:13px;margin-bottom:8px">&nbsp;</label>
                        <div class="d-flex" style="gap:8px">
                            <button type="submit" class="btn btn-primary flex-fill" style="border-radius:10px;font-weight:700">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request()->hasAny(['search', 'distrik', 'desa', 'bidang_usaha']))
                            <a href="{{ route('public.anggota-koperasi') }}" class="btn btn-secondary" style="border-radius:10px">
                                <i class="fas fa-redo"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Anggota per Distrik --}}
        @if($anggota->count() > 0)
            @php
                $anggotaByDistrik = $anggota->groupBy('distrik');
            @endphp
            
            @foreach($anggotaByDistrik as $distrik => $anggotaList)
            <div class="distrik-group">
                <div class="distrik-title">
                    <div class="distrik-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div>
                        <div>Distrik {{ $distrik }}</div>
                        <small style="font-size:14px;font-weight:600;color:#6b7280">{{ $anggotaList->count() }} Anggota Terdaftar</small>
                    </div>
                </div>
                
                <div class="row">
                    @foreach($anggotaList as $a)
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="anggota-card">
                            <div class="anggota-header">
                                <div class="anggota-avatar">
                                    {{ strtoupper(substr($a->nama, 0, 1)) }}
                                </div>
                                <h5 style="color:#fff;font-weight:800;margin-bottom:5px;font-size:16px">{{ $a->nama }}</h5>
                                <small style="color:rgba(255,255,255,0.9);font-weight:600">{{ $a->no_anggota }}</small>
                            </div>
                            
                            <div class="anggota-body">
                                <div class="text-center mb-3">
                                    <span class="distrik-badge">
                                        <i class="fas fa-map-marked-alt mr-1"></i>{{ $a->distrik }}
                                    </span>
                                    @if($a->desa && $a->desa != '-')
                                    <span class="desa-badge">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $a->desa }}
                                    </span>
                                    @endif
                                </div>
                                
                                <div class="info-row">
                                    <div class="info-icon" style="background:#fef3c7">
                                        <i class="fas fa-store" style="color:#d97706"></i>
                                    </div>
                                    <div style="flex:1">
                                        <small style="color:#6b7280;font-size:11px;display:block">Nama Usaha</small>
                                        <strong style="color:#1a3a6e;font-size:13px">{{ $a->nama_usaha }}</strong>
                                    </div>
                                </div>
                                
                                @if($a->bidang_usaha)
                                <div class="info-row">
                                    <div class="info-icon" style="background:#dbeafe">
                                        <i class="fas fa-briefcase" style="color:#1e40af"></i>
                                    </div>
                                    <div style="flex:1">
                                        <small style="color:#6b7280;font-size:11px;display:block">Bidang Usaha</small>
                                        <strong style="color:#1a3a6e;font-size:13px">{{ $a->bidang_usaha }}</strong>
                                    </div>
                                </div>
                                @endif
                                
                                @if($a->lama_berdiri_usaha)
                                <div class="info-row">
                                    <div class="info-icon" style="background:#d1fae5">
                                        <i class="fas fa-calendar-alt" style="color:#047857"></i>
                                    </div>
                                    <div style="flex:1">
                                        <small style="color:#6b7280;font-size:11px;display:block">Lama Berdiri</small>
                                        <strong style="color:#1a3a6e;font-size:13px">{{ $a->lama_berdiri_usaha }}</strong>
                                    </div>
                                </div>
                                @endif
                                
                                @if($a->jumlah_karyawan)
                                <div class="info-row">
                                    <div class="info-icon" style="background:#ede9fe">
                                        <i class="fas fa-users" style="color:#6d28d9"></i>
                                    </div>
                                    <div style="flex:1">
                                        <small style="color:#6b7280;font-size:11px;display:block">Jumlah Karyawan</small>
                                        <strong style="color:#1a3a6e;font-size:13px">{{ $a->jumlah_karyawan }} orang</strong>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="info-row">
                                    <div class="info-icon" style="background:#fce7f3">
                                        <i class="fas fa-check-circle" style="color:#be185d"></i>
                                    </div>
                                    <div style="flex:1">
                                        <small style="color:#6b7280;font-size:11px;display:block">Status</small>
                                        <strong style="color:#059669;font-size:13px">
                                            <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
            
            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $anggota->links('pagination::bootstrap-4') }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h5 style="font-weight:700;color:#374151;margin-bottom:10px">Tidak Ada Anggota Ditemukan</h5>
                <p style="color:#6b7280;margin-bottom:20px">
                    @if(request()->hasAny(['search', 'distrik', 'desa']))
                        Coba ubah filter pencarian Anda
                    @else
                        Belum ada anggota koperasi yang terdaftar
                    @endif
                </p>
                @if(request()->hasAny(['search', 'distrik', 'desa']))
                <a href="{{ route('public.anggota-koperasi') }}" class="btn btn-primary" style="border-radius:10px">
                    <i class="fas fa-redo mr-2"></i>Reset Filter
                </a>
                @endif
            </div>
        @endif
    </div>
</section>

{{-- Sebaran Anggota per Distrik --}}
@if($anggotaPerDistrik->count() > 0)
<section style="padding:50px 0;background:linear-gradient(to bottom,#f8f9fa,#ffffff)">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="font-size:32px;font-weight:900;color:#1a3a6e;margin-bottom:15px">
                Sebaran Anggota per Distrik
            </h2>
            <p style="color:#6b7280;font-size:16px">Distribusi anggota koperasi di seluruh Kabupaten Tolikara</p>
        </div>
        
        <div class="row">
            @foreach($anggotaPerDistrik as $item)
            <div class="col-md-4 col-sm-6 mb-4">
                <div style="background:#fff;border-radius:16px;padding:25px;box-shadow:0 4px 20px rgba(0,0,0,0.08);transition:all 0.3s ease;border-left:5px solid #0284c7"
                     onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.12)'"
                     onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 style="font-weight:800;color:#1a3a6e;margin-bottom:5px">{{ $item->distrik }}</h5>
                            <p style="color:#6b7280;margin:0;font-size:14px">
                                <i class="fas fa-users mr-1" style="color:#0284c7"></i>
                                <strong>{{ $item->total }}</strong> Anggota
                            </p>
                        </div>
                        <div style="width:60px;height:60px;background:linear-gradient(135deg,#dbeafe,#bfdbfe);border-radius:12px;display:flex;align-items:center;justify-content:center">
                            <i class="fas fa-map-marked-alt" style="font-size:24px;color:#1e40af"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-submit form when distrik changes to load desa options
    $('#distrikSelect').change(function() {
        if ($(this).val()) {
            $(this).closest('form').submit();
        } else {
            $('select[name="desa"]').prop('disabled', true).val('');
        }
    });
});
</script>
@endpush
