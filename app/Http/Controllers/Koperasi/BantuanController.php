<?php
namespace App\Http\Controllers\Koperasi;
use App\Http\Controllers\Controller;
use App\Models\Bantuan;
use App\Models\JadwalDistribusi;
use App\Models\PenerimaBantuan;
use App\Models\Koperasi;
class BantuanController extends Controller
{
    public function index() { $bantuan = Bantuan::where('status','aktif')->latest()->paginate(10); return view('koperasi.bantuan.index', compact('bantuan')); }
    public function show(Bantuan $bantuan) {
        $koperasi = Koperasi::where('user_id',auth()->id())->first();
        $sudahDaftar = $koperasi ? PenerimaBantuan::where('bantuan_id',$bantuan->id)->where('koperasi_id',$koperasi->id)->exists() : false;
        return view('koperasi.bantuan.show', compact('bantuan','sudahDaftar'));
    }
    public function riwayat() {
        $koperasi = Koperasi::where('user_id',auth()->id())->first();
        $riwayat = $koperasi ? PenerimaBantuan::where('koperasi_id',$koperasi->id)->with('bantuan')->latest()->paginate(10) : collect();
        return view('koperasi.bantuan.riwayat', compact('riwayat'));
    }
    public function jadwal() {
        $jadwal = JadwalDistribusi::where('status','terjadwal')->latest()->paginate(10);
        return view('koperasi.bantuan.jadwal', compact('jadwal'));
    }
}
