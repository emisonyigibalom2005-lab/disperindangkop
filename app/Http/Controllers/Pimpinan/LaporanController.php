<?php
namespace App\Http\Controllers\Pimpinan;
use App\Http\Controllers\Controller;
use App\Models\Bantuan;
use App\Models\PenerimaBantuan;
use App\Models\Koperasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
class LaporanController extends Controller
{
    public function index() {
        $stats = ['total_koperasi'=>Koperasi::count(),'koperasi_verified'=>Koperasi::where('status_verifikasi','diverifikasi')->count(),'total_bantuan'=>Bantuan::count(),'penerima_bantuan'=>PenerimaBantuan::where('status','diterima')->count()];
        return view('pimpinan.laporan.index', compact('stats'));
    }
    public function bantuan() { $bantuan = Bantuan::with('penerima.koperasi')->latest()->paginate(20); return view('pimpinan.laporan.bantuan', compact('bantuan')); }
    public function exportPdf() {
        $data = Koperasi::with('verifiedBy')->latest()->get();
        return Pdf::loadView('admin.laporan.pdf.koperasi', compact('data'))->setPaper('a4','landscape')->download('laporan-'.date('Ymd').'.pdf');
    }
    public function exportExcel() {
        $data = Koperasi::latest()->get();
        $headers = ['Content-Type'=>'text/csv','Content-Disposition'=>'attachment; filename="laporan-'.date('Ymd').'.csv"'];
        $callback = function() use ($data) {
            $f = fopen('php://output','w'); fputs($f,"\xEF\xBB\xBF");
            fputcsv($f,['No','No. Registrasi','Nama Usaha','Pemilik','Distrik','Kategori','Status']);
            foreach ($data as $i => $u) fputcsv($f,[$i+1,$u->no_registrasi,$u->nama_usaha,$u->nama_pemilik,$u->distrik,ucfirst($u->kategori),ucfirst($u->status_verifikasi)]);
            fclose($f);
        };
        return response()->stream($callback, 200, $headers);
    }
}
