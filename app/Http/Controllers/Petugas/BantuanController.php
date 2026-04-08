<?php
namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use App\Models\Bantuan;
use App\Models\PenerimaBantuan;
use App\Models\Koperasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
class BantuanController extends Controller
{
    public function index() { $bantuan = Bantuan::latest()->paginate(15); return view('petugas.bantuan.index', compact('bantuan')); }
    public function show(Bantuan $bantuan) {
        $bantuan->load('penerima.koperasi','jadwal');
        $koperasiTersedia = Koperasi::where('status_verifikasi','diverifikasi')->where('status_usaha','aktif')->whereNotIn('id',$bantuan->penerima->pluck('koperasi_id'))->get();
        return view('petugas.bantuan.show', compact('bantuan','koperasiTersedia'));
    }
    public function penerima(Bantuan $bantuan) { $bantuan->load('penerima.koperasi'); return view('petugas.bantuan.penerima', compact('bantuan')); }
    public function tambahPenerima(Request $request, Bantuan $bantuan) {
        $request->validate(['koperasi_id'=>'required|exists:koperasi,id','jumlah_bantuan'=>'required|numeric|min:0']);
        if ($bantuan->penerima()->count() >= $bantuan->kuota) return back()->with('error','Kuota penuh.');
        PenerimaBantuan::create(['bantuan_id'=>$bantuan->id,'koperasi_id'=>$request->koperasi_id,'jumlah_bantuan'=>$request->jumlah_bantuan,'status'=>'terdaftar']);
        return back()->with('success','Penerima berhasil ditambahkan.');
    }
    public function validasiPenerima(Request $request, PenerimaBantuan $penerima) {
        $request->validate(['status'=>'required|in:divalidasi,diterima,ditolak']);
        $penerima->update(['status'=>$request->status,'validated_by'=>auth()->id(),'validated_at'=>now()]);
        return back()->with('success','Status berhasil diperbarui.');
    }
    public function cetakSK(PenerimaBantuan $penerima) {
        $penerima->load('koperasi','bantuan');
        $pdf = Pdf::loadView('admin.bantuan.pdf.sk', compact('penerima'))->setPaper('a4');
        return $pdf->download('SK-'.$penerima->koperasi->no_registrasi.'.pdf');
    }
}
