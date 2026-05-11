@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Administrator')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css"/>
<style>
#peta-admin { height:350px; width:100%; z-index:1; }
.leaflet-container { z-index:1 !important; }

/* Grafik styling - ukuran lebih kecil dan rapi */
#chartAnggotaDistrik { max-height: 250px !important; }
#chartAnggotaStatus { max-height: 220px !important; }

.card-body canvas {
    max-height: 280px;
}
</style>
@endpush
@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="small-box" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white;">
            <div class="inner">
                <h3>{{ number_format($stats['total_anggota']) }}</h3>
                <p>Total Anggota Koperasi</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <a href="{{ route('admin.anggota.index') }}" class="small-box-footer" style="color: rgba(255,255,255,0.8);">
                Lihat semua <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
            <div class="inner">
                <h3>{{ number_format($stats['anggota_aktif']) }}</h3>
                <p>Anggota Aktif</p>
            </div>
            <div class="icon"><i class="fas fa-user-check"></i></div>
            <a href="{{ route('admin.anggota.index') }}" class="small-box-footer" style="color: rgba(255,255,255,0.8);">
                Lihat semua <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
            <div class="inner">
                <h3>{{ number_format($stats['anggota_pending']) }}</h3>
                <p>Anggota Pending</p>
            </div>
            <div class="icon"><i class="fas fa-user-clock"></i></div>
            <a href="{{ route('admin.anggota.index') }}" class="small-box-footer" style="color: rgba(255,255,255,0.8);">
                Proses sekarang <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white;">
            <div class="inner">
                <h3>{{ number_format($stats['anggota_ditolak']) }}</h3>
                <p>Anggota Ditolak</p>
            </div>
            <div class="icon"><i class="fas fa-user-times"></i></div>
            <a href="{{ route('admin.anggota.index') }}" class="small-box-footer" style="color: rgba(255,255,255,0.8);">
                Lihat semua <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Anggota Koperasi per Distrik</h3>
            </div>
            <div class="card-body"><canvas id="chartAnggotaDistrik" style="height:250px"></canvas></div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card card-success card-outline">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Status Anggota Koperasi</h3></div>
            <div class="card-body">
                <canvas id="chartAnggotaStatus" style="height:220px"></canvas>
                <div class="mt-3">
                    @foreach($anggotaPerStatus as $a)
                    @php
                        $statusColor = match(strtolower($a->status)) {
                            'aktif' => '#10b981',
                            'pending' => '#f59e0b',
                            'nonaktif' => '#ef4444',
                            'ditolak' => '#dc2626',
                            default => '#6b7280'
                        };
                        $badgeClass = match(strtolower($a->status)) {
                            'aktif' => 'success',
                            'pending' => 'warning',
                            'nonaktif' => 'danger',
                            'ditolak' => 'danger',
                            default => 'secondary'
                        };
                    @endphp
                    <div class="d-flex justify-content-between align-items-center mb-2" style="padding: 10px 14px; background: #f9fafb; border-radius: 8px; border-left: 4px solid {{ $statusColor }};">
                        <span class="text-capitalize font-weight-bold" style="color: #374151;">
                            <i class="fas fa-circle mr-2" style="font-size: 10px; color: {{ $statusColor }}"></i>
                            {{ ucfirst($a->status) }}
                        </span>
                        <span class="badge badge-{{ $badgeClass }}" style="font-weight: 700; font-size: 13px; padding: 5px 12px;">{{ $a->total }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-clock mr-2"></i>Anggota Menunggu Verifikasi</h3>
                <div class="card-tools"><a href="{{ route('admin.anggota.index') }}" class="btn btn-sm btn-warning">Lihat Semua</a></div>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light"><tr><th>No. Anggota</th><th>Nama</th><th>Distrik</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                    <tbody>
                    @forelse($pendingAnggota as $a)
                    <tr>
                        <td><small class="text-muted">{{ $a->no_anggota ?? '-' }}</small></td>
                        <td><strong>{{ $a->nama }}</strong><br><small class="text-muted">{{ $a->email ?? '-' }}</small></td>
                        <td><span class="badge badge-secondary">{{ $a->distrik ?? '-' }}</span></td>
                        <td><small>{{ $a->created_at->format('d M Y') }}</small></td>
                        <td><a href="{{ route('admin.anggota.show', $a) }}" class="btn btn-xs btn-primary"><i class="fas fa-eye"></i></a></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Tidak ada Anggota yang menunggu</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history mr-2"></i>Aktivitas Terbaru</h3>
                <div class="card-tools"><a href="{{ route('admin.users.activityLog') }}" class="btn btn-sm btn-info">Semua</a></div>
            </div>
            <div class="card-body p-0">
                <div class="p-3" style="max-height:320px;overflow-y:auto">
                    @foreach($recentActivity as $log)
                    <div class="d-flex align-items-start mb-3">
                        <span class="badge badge-{{ $log->action==='login'?'success':($log->action==='delete'?'danger':'primary') }} mr-2 mt-1">{{ $log->action }}</span>
                        <div>
                            <div style="font-size:12px"><strong>{{ $log->user->name ?? 'System' }}</strong> — {{ $log->description }}</div>
                            <small class="text-muted">{{ $log->created_at->format('d M H:i') }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="info-box shadow-sm" style="border-radius: 10px;">
            <span class="info-box-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border-radius: 10px;">
                <i class="fas fa-users"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text" style="font-weight: 600; color: #6b7280;">Total Anggota</span>
                <span class="info-box-number" style="color: #1a3a6e; font-weight: 700;">{{ number_format($stats['total_anggota']) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box shadow-sm" style="border-radius: 10px;">
            <span class="info-box-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 10px;">
                <i class="fas fa-user-check"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text" style="font-weight: 600; color: #6b7280;">Anggota Aktif</span>
                <span class="info-box-number" style="color: #1a3a6e; font-weight: 700;">{{ number_format($stats['anggota_aktif']) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box shadow-sm" style="border-radius: 10px;">
            <span class="info-box-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border-radius: 10px;">
                <i class="fas fa-user-clock"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text" style="font-weight: 600; color: #6b7280;">Anggota Pending</span>
                <span class="info-box-number" style="color: #1a3a6e; font-weight: 700;">{{ number_format($stats['anggota_pending']) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box shadow-sm" style="border-radius: 10px;">
            <span class="info-box-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border-radius: 10px;">
                <i class="fas fa-user-times"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text" style="font-weight: 600; color: #6b7280;">Anggota Ditolak</span>
                <span class="info-box-number" style="color: #1a3a6e; font-weight: 700;">{{ number_format($stats['anggota_ditolak']) }}</span>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-map-marked-alt mr-2"></i>Peta Sebaran Koperasi Kabupaten Tolikara</h3>
            </div>
            <div class="card-body p-0">
                <div id="peta-admin"></div>
            </div>
            <div class="card-footer">
                <div class="row text-center" style="font-size:13px">
                    <div class="col-4"><i class="fas fa-circle mr-1" style="color:#1a3a6e"></i>Terverifikasi</div>
                    <div class="col-4"><i class="fas fa-circle mr-1" style="color:#f5a623"></i>Menunggu</div>
                    <div class="col-4"><i class="fas fa-circle mr-1" style="color:#dc3545"></i>Ditolak</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script>
$(function(){
    // Bar Chart Anggota per Distrik dengan warna berbeda-beda
    const anggotaDistrikLabels = @json($anggotaPerDistrik->pluck('distrik'));
    const anggotaDistrikData = @json($anggotaPerDistrik->pluck('total'));
    
    // Array warna yang berbeda untuk setiap bar
    const barColors = [
        '#3b82f6', // Blue
        '#8b5cf6', // Purple
        '#ec4899', // Pink
        '#f59e0b', // Orange
        '#10b981', // Green
        '#06b6d4', // Cyan
        '#ef4444', // Red
        '#6366f1', // Indigo
        '#14b8a6', // Teal
        '#f97316', // Deep Orange
        '#a855f7', // Violet
        '#22c55e'  // Light Green
    ];
    
    new Chart($('#chartAnggotaDistrik'),{
        type:'bar',
        data:{
            labels: anggotaDistrikLabels,
            datasets:[{
                label:'Jumlah Anggota',
                data: anggotaDistrikData,
                backgroundColor: barColors.slice(0, anggotaDistrikLabels.length),
                borderRadius: 8,
                borderWidth: 0
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{
                legend:{display:false},
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12 },
                    cornerRadius: 6
                }
            },
            scales:{
                y:{
                    beginAtZero:true,
                    ticks:{stepSize:1},
                    grid: { color: '#f1f5f9' }
                },
                x:{
                    grid: { display: false }
                }
            }
        }
    });
    
    // Doughnut Chart Status Anggota dengan warna berbeda-beda
    const statusLabels = @json($anggotaPerStatus->pluck('status')->map(fn($s)=>ucfirst($s)));
    const statusData = @json($anggotaPerStatus->pluck('total'));
    
    // Warna yang berbeda untuk setiap status
    const statusColorMap = {
        'Aktif': '#10b981',      // Green - untuk status aktif
        'Pending': '#f59e0b',    // Orange - untuk status pending
        'Nonaktif': '#ef4444',   // Red - untuk status nonaktif
        'Ditolak': '#dc2626'     // Dark Red - untuk status ditolak
    };
    
    // Generate array warna berdasarkan label
    const statusColors = statusLabels.map(label => statusColorMap[label] || '#6b7280');
    
    new Chart($('#chartAnggotaStatus'),{
        type:'doughnut',
        data:{
            labels: statusLabels,
            datasets:[{
                data: statusData,
                backgroundColor: statusColors,
                borderWidth: 4,
                borderColor: '#fff',
                hoverOffset: 8,
                hoverBorderWidth: 5
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{
                legend:{
                    position:'bottom',
                    labels: {
                        padding: 15,
                        font: { size: 12, weight: 'bold' },
                        usePointStyle: true,
                        pointStyle: 'circle',
                        generateLabels: function(chart) {
                            const data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map((label, i) => {
                                    const value = data.datasets[0].data[i];
                                    const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return {
                                        text: `${label}: ${value} (${percentage}%)`,
                                        fillStyle: data.datasets[0].backgroundColor[i],
                                        hidden: false,
                                        index: i
                                    };
                                });
                            }
                            return [];
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.85)',
                    padding: 14,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} anggota (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    var koperasiData = @json($koperasiPerDistrik);
    var koord = {"Karubaga":[-3.610,138.462],"Bokondini":[-3.648,138.672],"Tiom":[-3.680,138.395],"Kembu":[-3.580,138.520],"Bewani":[-3.700,138.395],"Bokoneri":[-3.670,138.500],"Geya":[-3.550,138.560],"Nabunage":[-3.720,138.440],"Kanggime":[-3.540,138.340]};

    var map = L.map('peta-admin',{scrollWheelZoom:false}).setView([-3.620,138.480],9);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'OpenStreetMap'}).addTo(map);

    $.each(koperasiData,function(i,v){
        var c=koord[v.distrik]; if(!c) return;
        L.marker(c,{icon:L.divIcon({className:'',
            html:'<div style="background:#1a3a6e;color:#fff;width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:800;border:3px solid #fff;box-shadow:0 2px 6px rgba(0,0,0,0.3)">'+v.total+'</div>',
            iconAnchor:[18,18]
        })}).addTo(map).bindPopup('<b>Distrik '+v.distrik+'</b><br>Total: '+v.total+' Koperasi');
    });

    setTimeout(function(){ map.invalidateSize(); }, 500);
});
</script>
@endpush
