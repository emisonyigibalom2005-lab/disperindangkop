<?php
namespace App\Http\Controllers\Pimpinan;
use App\Http\Controllers\Controller;
use App\Models\Bantuan;
use App\Models\PenerimaBantuan;
use App\Models\Koperasi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index() {
        $stats = ['total_koperasi'=>Koperasi::count(),'koperasi_verified'=>Koperasi::where('status_verifikasi','diverifikasi')->count(),'total_bantuan'=>Bantuan::count(),'penerima_bantuan'=>PenerimaBantuan::where('status','diterima')->count()];
        $koperasiPerKategori = Koperasi::selectRaw('kategori, COUNT(*) as total')->groupBy('kategori')->get();
        $koperasiPerDistrik  = Koperasi::selectRaw('distrik, COUNT(*) as total')->groupBy('distrik')->orderByDesc('total')->take(10)->get();
        return view('pimpinan.dashboard', compact('stats','koperasiPerKategori','koperasiPerDistrik'));
    }
    public function koperasi(Request $request) {
        $query = Koperasi::query();
        if ($request->filled('distrik')) $query->where('distrik',$request->distrik);
        if ($request->filled('kategori')) $query->where('kategori',$request->kategori);
        $koperasi = $query->latest()->paginate(20)->appends($request->query());
        return view('pimpinan.koperasi', ['koperasi'=>$koperasi,'distrik'=>Koperasi::listDistrik()]);
    }
    public function showKoperasi(Koperasi $koperasi) { $koperasi->load('penerimaBantuan.bantuan'); return view('pimpinan.koperasi-detail', compact('koperasi')); }
    public function profile() { $user = auth()->user(); return view('pimpinan.profile', compact('user')); }

    public function jadwal() {
        $jadwal = \App\Models\Jadwal::orderBy("tanggal", "desc")->paginate(15);
        return view("pimpinan.jadwal", compact("jadwal"));
    }
    public function updateProfile(Request $request) {
        $user = auth()->user();
        $request->validate(['name'=>'required','email'=>'required|email|unique:users,email,'.$user->id,'password'=>'nullable|min:8|confirmed']);
        $data = $request->only(['name','email','phone']);
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_photo);
            $data['profile_photo'] = $request->file('profile_photo')->store('foto_profil','public');
        }
        if ($request->filled('password')) $data['password'] = Hash::make($request->password);
        $user->update($data);
        return back()->with('success','Profil berhasil diperbarui.');
    }
}
