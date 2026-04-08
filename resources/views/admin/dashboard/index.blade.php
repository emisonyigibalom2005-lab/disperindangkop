
@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Administrator')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css"/>
<style>
#peta-admin { height:450px; width:100%; z-index:1; }
.leaflet-container { z-index:1 !important; }
</style>
@endpush
@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-primary">
            <div class="inner"><h3>{{ number_format($stats['total_koperasi']) }}</h3><p>Total Koperasi Terdaftar</p></div>
            <div class="icon"><i class="fas fa-store"></i></div>
            <a href="{{ route('admin.koperasi.index') }}" class="small-box-footer">Lihat semua <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-success">
            <div class="inner"><h3>{{ number_format($stats['koperasi_verified']) }}</h3><p>Koperasi Terverifikasi</p></div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
            <a href="{{ route('admin.koperasi.index') }}" class="small-box-footer">Lihat semua <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-warning">
            <div class="inner"><h3>{{ number_format($stats['koperasi_pending']) }}</h3><p>Menunggu Verifikasi</p></div>
            <div class="icon"><i class="fas fa-clock"></i></div>
            <a href="{{ route('admin.koperasi.index') }}" class="small-box-footer">Proses sekarang <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-info">
            <div class="inner"><h3>{{ number_format($stats['penerima_bantuan']) }}</h3><p>Penerima Bantuan</p></div>
            <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
            <a href="{{ route('admin.bantuan.index') }}" class="small-box-footer">Lihat bantuan <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <div class="card card-primary card-outline">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Koperasi per Distrik</h3></div>
            <div class="card-body"><canvas id="chartDistrik" style="min-height:280px"></canvas></div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card card-success card-outline">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Kategori Koperasi</h3></div>
            <div class="card-body">
                <canvas id="chartKategori" style="min-height:200px"></canvas>
                <div class="mt-3">
                    @foreach($koperasiPerKategori as $k)
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-capitalize font-weight-bold">{{ $k->kategori }}</span>
                        <span class="badge badge-{{ $k->kategori==='mikro'?'primary':($k->kategori==='kecil'?'success':'warning') }}">{{ $k->total }}</span>
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
                <h3 class="card-title"><i class="fas fa-clock mr-2"></i>Koperasi Menunggu Verifikasi</h3>
                <div class="card-tools"><a href="{{ route('admin.koperasi.index') }}" class="btn btn-sm btn-warning">Lihat Semua</a></div>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light"><tr><th>No. Reg</th><th>Nama Usaha</th><th>Distrik</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                    <tbody>
                    @forelse($pendingKoperasi as $u)
                    <tr>
                        <td><small class="text-muted">{{ $u->no_registrasi }}</small></td>
                        <td><strong>{{ $u->nama_usaha }}</strong><br><small class="text-muted">{{ $u->nama_pemilik }}</small></td>
                        <td><span class="badge badge-secondary">{{ $u->distrik }}</span></td>
                        <td><small>{{ $u->created_at->format('d M Y') }}</small></td>
                        <td><a href="{{ route('admin.koperasi.show', $u) }}" class="btn btn-xs btn-primary"><i class="fas fa-eye"></i></a></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Tidak ada Koperasi yang menunggu</td></tr>
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
        <div class="info-box shadow-sm"><span class="info-box-icon bg-primary"><i class="fas fa-store"></i></span>
        <div class="info-box-content"><span class="info-box-text">Koperasi Aktif</span><span class="info-box-number">{{ number_format($stats['koperasi_aktif']) }}</span></div></div>
    </div>
    <div class="col-md-3">
        <div class="info-box shadow-sm"><span class="info-box-icon bg-danger"><i class="fas fa-times-circle"></i></span>
        <div class="info-box-content"><span class="info-box-text">Koperasi Ditolak</span><span class="info-box-number">{{ number_format($stats['koperasi_ditolak']) }}</span></div></div>
    </div>
    <div class="col-md-3">
        <div class="info-box shadow-sm"><span class="info-box-icon bg-success"><i class="fas fa-hand-holding-usd"></i></span>
        <div class="info-box-content"><span class="info-box-text">Program Bantuan Aktif</span><span class="info-box-number">{{ number_format($stats['bantuan_aktif']) }}</span></div></div>
    </div>
    <div class="col-md-3">
        <div class="info-box shadow-sm"><span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
        <div class="info-box-content"><span class="info-box-text">Total Pengguna</span><span class="info-box-number">{{ number_format($stats['total_users']) }}</span></div></div>
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
    new Chart($('#chartDistrik'),{type:'bar',data:{labels:@json($koperasiPerDistrik->pluck('distrik')),datasets:[{label:'Jumlah Koperasi',data:@json($koperasiPerDistrik->pluck('total')),backgroundColor:'rgba(26,58,110,0.75)',borderRadius:4}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{stepSize:1}}}}});
    new Chart($('#chartKategori'),{type:'doughnut',data:{labels:@json($koperasiPerKategori->pluck('kategori')->map(fn($k)=>ucfirst($k))),datasets:[{data:@json($koperasiPerKategori->pluck('total')),backgroundColor:['#007bff','#28a745','#ffc107'],borderWidth:2}]},options:{responsive:true,plugins:{legend:{position:'bottom'}}}});

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
