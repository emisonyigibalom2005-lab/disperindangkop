<?php
namespace App\Http\Controllers\Koperasi;
use App\Http\Controllers\Controller;
use App\Models\Koperasi;
use Illuminate\Http\Request;
class ProfileController extends Controller
{
    public function show() { $koperasi = Koperasi::where('user_id',auth()->id())->first(); return view('koperasi.profile', compact('koperasi')); }
    public function update(Request $request) {
        $koperasi = Koperasi::where('user_id',auth()->id())->firstOrFail();
        $koperasi->update($request->only(['no_telp','alamat','kelurahan','email']));
        return back()->with('success','Profil berhasil diperbarui.');
    }
    public function uploadDokumen(Request $request) {
        $koperasi = Koperasi::where('user_id',auth()->id())->firstOrFail();
        $request->validate(['file'=>'required|file|mimes:pdf,jpg,jpeg,png|max:2048','jenis_dokumen'=>'required']);
        $path = $request->file('file')->store('dokumen','public');
        $koperasi->dokumen()->create(['jenis_dokumen'=>$request->jenis_dokumen,'file_path'=>$path,'uploaded_by'=>auth()->id()]);
        return back()->with('success','Dokumen berhasil diupload.');
    }
}
