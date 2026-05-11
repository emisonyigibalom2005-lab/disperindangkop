@extends('public.layouts.app')

@section('title', 'Pendaftaran Ditutup')

@section('content')
@php
    $alasan = $alasan ?? 'tidak_ada_periode';
    $isKuotaPenuh = $alasan === 'kuota_penuh';
@endphp

{{-- Header Section --}}
<div style="background:#64748b;padding:80px 0;text-align:center">
    <div class="container">
        <div style="width:120px;height:120px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 30px">
            <i class="fas fa-lock" style="font-size:60px;color:white"></i>
        </div>
        <h1 style="color:white;font-size:36px;font-weight:700;margin-bottom:15px">Pendaftaran Ditutup</h1>
        <p style="color:rgba(255,255,255,0.9);font-size:18px;margin:0">
            Saat ini belum ada periode pendaftaran yang dibuka.
        </p>
    </div>
</div>

{{-- Content Section --}}
<div style="padding:60px 0;background:#f8f9fa">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                @if($isKuotaPenuh)
                    {{-- Alert Kuota Penuh --}}
                    <div style="background:#fee2e2;border-left:4px solid #ef4444;border-radius:8px;padding:20px 24px;margin-bottom:30px">
                        <div class="d-flex align-items-start">
                            <div style="width:40px;height:40px;background:#ef4444;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-right:16px;flex-shrink:0">
                                <i class="fas fa-exclamation-circle" style="color:white;font-size:20px"></i>
                            </div>
                            <div>
                                <h5 style="color:#991b1b;font-weight:700;margin-bottom:8px">Kuota Sudah Penuh</h5>
                                <p style="color:#7f1d1d;margin:0;line-height:1.6">
                                    Pendaftaran untuk periode <strong>{{ $periode->nama_periode }}</strong> telah ditutup karena kuota sudah terpenuhi. 
                                    Silakan hubungi admin untuk informasi lebih lanjut atau tunggu periode berikutnya.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Info Periode --}}
                    @if($periode)
                    <div style="background:white;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);padding:30px;margin-bottom:30px">
                        <h5 style="color:#1a3a6e;font-weight:700;margin-bottom:20px">
                            <i class="fas fa-calendar-alt" style="margin-right:8px"></i>Informasi Periode Aktif
                        </h5>
                        <table style="width:100%;border-collapse:collapse">
                            <tr>
                                <td style="padding:12px 0;border-bottom:1px solid #e5e7eb;color:#6b7280;width:40%">Nama Periode</td>
                                <td style="padding:12px 0;border-bottom:1px solid #e5e7eb;color:#1f2937;font-weight:600">{{ $periode->nama_periode }}</td>
                            </tr>
                            <tr>
                                <td style="padding:12px 0;border-bottom:1px solid #e5e7eb;color:#6b7280">Tahun Ajaran</td>
                                <td style="padding:12px 0;border-bottom:1px solid #e5e7eb;color:#1f2937;font-weight:600">{{ $periode->tahun_ajaran }}</td>
                            </tr>
                            <tr>
                                <td style="padding:12px 0;border-bottom:1px solid #e5e7eb;color:#6b7280">Periode Pendaftaran</td>
                                <td style="padding:12px 0;border-bottom:1px solid #e5e7eb;color:#1f2937;font-weight:600">
                                    {{ $periode->tanggal_mulai->format('d M Y') }} - {{ $periode->tanggal_selesai->format('d M Y') }}
                                </td>
                            </tr>
                            @if($periode->kuota)
                            <tr>
                                <td style="padding:12px 0;color:#6b7280">Kuota Pendaftar</td>
                                <td style="padding:12px 0">
                                    <span style="color:#ef4444;font-weight:700;font-size:18px">{{ $periode->jumlah_pendaftar }} / {{ $periode->kuota }} Orang</span>
                                    <span style="background:#ef4444;color:white;padding:4px 12px;border-radius:12px;font-size:12px;font-weight:600;margin-left:8px">PENUH</span>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    @endif

                @else
                    {{-- Alert Tidak Ada Periode --}}
                    <div style="background:#fee2e2;border-left:4px solid #ef4444;border-radius:8px;padding:20px 24px;margin-bottom:30px">
                        <div class="d-flex align-items-start">
                            <div style="width:40px;height:40px;background:#ef4444;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-right:16px;flex-shrink:0">
                                <i class="fas fa-info-circle" style="color:white;font-size:20px"></i>
                            </div>
                            <div>
                                <h5 style="color:#991b1b;font-weight:700;margin-bottom:8px">Belum Ada Periode Aktif</h5>
                                <p style="color:#7f1d1d;margin:0;line-height:1.6">
                                    Saat ini belum ada periode pendaftaran yang dibuka. Silakan hubungi admin untuk informasi lebih lanjut.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div style="text-align:center;margin-bottom:30px">
                    <a href="{{ route('public.home') }}" 
                       style="display:inline-block;background:#1a3a6e;color:white;padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:600;margin:0 8px 16px">
                        <i class="fas fa-home" style="margin-right:8px"></i>Kembali ke Beranda
                    </a>
                    <a href="{{ route('public.kontak') }}" 
                       style="display:inline-block;background:white;color:#1a3a6e;padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:600;border:2px solid #1a3a6e;margin:0 8px 16px">
                        <i class="fas fa-phone" style="margin-right:8px"></i>Hubungi Kami
                    </a>
                </div>

                {{-- Info Cards --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div style="background:white;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);padding:24px">
                            <div style="width:48px;height:48px;background:#dbeafe;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:16px">
                                <i class="fas fa-calendar-check" style="font-size:24px;color:#2563eb"></i>
                            </div>
                            <h6 style="color:#1a3a6e;font-weight:700;margin-bottom:10px">Gelombang Berikutnya</h6>
                            <p style="color:#6b7280;font-size:14px;margin:0;line-height:1.6">
                                Pantau terus website ini untuk informasi pembukaan periode pendaftaran berikutnya
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div style="background:white;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);padding:24px">
                            <div style="width:48px;height:48px;background:#dcfce7;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:16px">
                                <i class="fas fa-file-alt" style="font-size:24px;color:#16a34a"></i>
                            </div>
                            <h6 style="color:#1a3a6e;font-weight:700;margin-bottom:10px">Siapkan Dokumen</h6>
                            <p style="color:#6b7280;font-size:14px;margin:0;line-height:1.6">
                                Siapkan dokumen yang diperlukan sebelum periode berikutnya dibuka
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div style="background:white;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);padding:24px">
                            <div style="width:48px;height:48px;background:#fef3c7;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:16px">
                                <i class="fas fa-bell" style="font-size:24px;color:#d97706"></i>
                            </div>
                            <h6 style="color:#1a3a6e;font-weight:700;margin-bottom:10px">Notifikasi</h6>
                            <p style="color:#6b7280;font-size:14px;margin:0;line-height:1.6">
                                Daftarkan email Anda untuk mendapat notifikasi pembukaan pendaftaran
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div style="background:white;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);padding:24px">
                            <div style="width:48px;height:48px;background:#fee2e2;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:16px">
                                <i class="fas fa-headset" style="font-size:24px;color:#dc2626"></i>
                            </div>
                            <h6 style="color:#1a3a6e;font-weight:700;margin-bottom:10px">Bantuan</h6>
                            <p style="color:#6b7280;font-size:14px;margin:0;line-height:1.6">
                                Hubungi kami jika ada pertanyaan seputar pendaftaran anggota
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
