<?php
namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Koperasi;
use Illuminate\Http\Request;
class KoperasiController extends Controller
{
    public function index(Request $request) {
        $query = Koperasi::query();
        if ($request->filled('search')) $query->where('nama_usaha','like','%'.$request->search.'%')->orWhere('nama_pemilik','like','%'.$request->search.'%');
        if ($request->filled('status_verifikasi')) $query->where('status_verifikasi',$request->status_verifikasi);
        if ($request->filled('distrik')) $query->where('distrik',$request->distrik);
        $koperasi = $query->latest()->paginate(15)->appends($request->query());
        return view('petugas.koperasi.index', ['koperasi'=>$koperasi,'distrik'=>Koperasi::listDistrik(),'filters'=>$request->only(['search','status_verifikasi','distrik'])]);
    }
    public function show(Koperasi $koperasi) { $koperasi->load('dokumen','penerimaBantuan.bantuan'); return view('petugas.koperasi.show', compact('koperasi')); }
    public function create() { return view('petugas.koperasi.create', ['distrik'=>Koperasi::listDistrik()]); }
    public function store(Request $request) {
        $request->validate(['no_ktp'=>'required|string|max:20|unique:koperasi,no_ktp','nama_pemilik'=>'required','nama_usaha'=>'required','jenis_usaha'=>'required','kategori'=>'required|in:mikro,kecil,menengah','alamat'=>'required','distrik'=>'required','kelurahan'=>'required']);
        $koperasi = Koperasi::create(array_merge($request->all(),['no_registrasi'=>Koperasi::generateNoRegistrasi(),'status_verifikasi'=>'pending','status_usaha'=>'aktif']));
        return redirect()->route('petugas.koperasi.show',$koperasi)->with('success','Data KOPERASI berhasil ditambahkan.');
    }
    public function edit(Koperasi $koperasi) { return view('petugas.koperasi.edit', ['koperasi'=>$koperasi,'distrik'=>Koperasi::listDistrik()]); }
    public function update(Request $request, Koperasi $koperasi) {
        $koperasi->update($request->only(['nama_pemilik','nama_usaha','jenis_usaha','kategori','alamat','distrik','kelurahan','no_telp','email','modal_usaha','omset_per_bulan','jumlah_karyawan']));
        return redirect()->route('petugas.koperasi.show',$koperasi)->with('success','Data berhasil diperbarui.');
    }
    public function destroy(Koperasi $koperasi) { $koperasi->delete(); return redirect()->route('petugas.koperasi.index')->with('success','Data dihapus.'); }
    public function verifikasi(Request $request, Koperasi $koperasi) {
        $request->validate(['status_verifikasi'=>'required|in:diverifikasi,ditolak']);
        $koperasi->update(['status_verifikasi'=>$request->status_verifikasi,'catatan_verifikasi'=>$request->catatan_verifikasi,'verified_by'=>auth()->id(),'verified_at'=>now()]);
        ActivityLog::create(['user_id'=>auth()->id(),'action'=>'update','module'=>'KOPERASI','description'=>'Verifikasi KOPERASI: '.$koperasi->no_registrasi,'ip_address'=>$request->ip()]);
        return back()->with('success','Status verifikasi berhasil diperbarui.');
    }
    public function toggleStatus(Koperasi $koperasi) { $koperasi->update(['status_usaha'=>$koperasi->status_usaha==='aktif'?'tidak_aktif':'aktif']); return back()->with('success','Status diperbarui.'); }
    public function uploadDokumen(Request $request, Koperasi $koperasi) {
        $request->validate(['file'=>'required|file|mimes:pdf,jpg,jpeg,png|max:2048','jenis_dokumen'=>'required']);
        $path = $request->file('file')->store('dokumen','public');
        $koperasi->dokumen()->create(['jenis_dokumen'=>$request->jenis_dokumen,'file_path'=>$path,'uploaded_by'=>auth()->id()]);
        return back()->with('success','Dokumen berhasil diupload.');
    }
}
