<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller {

    public function index(Request $request) {
        $q = Anggota::query();
        if ($request->search) $q->where('nama','like',"%{$request->search}%")->orWhere('no_anggota','like',"%{$request->search}%");
        if ($request->status) $q->where('status',$request->status);
        if ($request->distrik) $q->where('distrik',$request->distrik);
        $anggota = $q->orderBy('created_at','desc')->paginate(15)->withQueryString();
        $distrik = Anggota::distinct()->pluck('distrik');
        $stats = [
            'total'    => Anggota::count(),
            'aktif'    => Anggota::where('status','Aktif')->count(),
            'pending'  => Anggota::where('status','Pending')->count(),
            'nonaktif' => Anggota::where('status','Nonaktif')->count(),
        ];
        return view('admin.anggota.index', compact('anggota','distrik','stats'));
    }

    public function create() {
        $no = Anggota::generateNoAnggota();
        return view('admin.anggota.create', compact('no'));
    }

    public function store(Request $request) {
        $request->validate([
            'nik'          => 'required|unique:anggotas,nik|digits:16',
            'nama'         => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir'=> 'required|date',
            'no_hp'        => 'required',
            'distrik'      => 'required',
            'nama_usaha'   => 'required',
        ]);
        $d = $request->only(['nik','nama','tempat_lahir','tanggal_lahir','jenis_kelamin','agama','no_hp','email','desa','distrik','kabupaten','alamat_lengkap','nama_komplek_dekat_desa','nama_usaha','modal_usaha','omzet_per_bulan','total_simpanan','keterangan_usaha','status']);
        $d['no_anggota'] = Anggota::generateNoAnggota();
        if ($request->hasFile('foto')) $d['foto'] = $request->file('foto')->store('anggota','public');
        Anggota::create($d);
        return redirect()->route('admin.anggota.index')->with('success','Anggota berhasil ditambah!');
    }

    public function show(Anggota $anggota) {
        return view('admin.anggota.show', compact('anggota'));
    }

    public function edit(Anggota $anggota) {
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota) {
        $request->validate([
            'nik'  => 'required|digits:16|unique:anggotas,nik,'.$anggota->id,
            'nama' => 'required',
        ]);
        $d = $request->only(['nik','nama','tempat_lahir','tanggal_lahir','jenis_kelamin','agama','no_hp','email','desa','distrik','kabupaten','alamat_lengkap','nama_komplek_dekat_desa','nama_usaha','modal_usaha','omzet_per_bulan','total_simpanan','keterangan_usaha','status']);
        if ($request->hasFile('foto')) {
            if ($anggota->foto) Storage::disk('public')->delete($anggota->foto);
            $d['foto'] = $request->file('foto')->store('anggota','public');
        }
        $anggota->update($d);
        return redirect()->route('admin.anggota.index')->with('success','Data anggota diperbarui!');
    }

    public function destroy(Anggota $anggota) {
        if ($anggota->foto) Storage::disk('public')->delete($anggota->foto);
        $anggota->delete();
        return redirect()->route('admin.anggota.index')->with('success','Anggota dihapus!');
    }

    public function sertifikat(Anggota $anggota) {
        return view('admin.anggota.sertifikat', compact('anggota'));
    }

    public function updateStatus(Request $request, Anggota $anggota) {
        $statusLama = $anggota->status;
        $data = ['status' => $request->status, 'catatan_admin' => $request->catatan_admin];
        if ($request->status === 'Aktif') $data['tanggal_verifikasi'] = now();
        $anggota->update($data);

        // Kirim notifikasi ke user jika ada
        if ($anggota->user_id) {
            $pesan = $request->status === 'Aktif'
                ? 'Selamat! Pendaftaran anggota Anda telah DISETUJUI. Silakan login untuk melihat kartu anggota.'
                : 'Mohon maaf, pendaftaran anggota Anda DITOLAK. '.($request->catatan_admin ?? '');
            \App\Models\Notifikasi::create([
                'user_id' => $anggota->user_id,
                'judul'   => $request->status === 'Aktif' ? 'Pendaftaran Anggota Disetujui ✅' : 'Pendaftaran Anggota Ditolak ❌',
                'pesan'   => $pesan,
                'tipe'    => $request->status === 'Aktif' ? 'success' : 'danger',
            ]);
        }

        return back()->with('success','Status anggota diperbarui!');
    }


    public function dokumen(Request $request) {
        $q = Anggota::query();
        if ($request->search) $q->where("nama","like","%{$request->search}%")->orWhere("no_anggota","like","%{$request->search}%");
        if ($request->status) $q->where("status",$request->status);
        $anggota = $q->orderBy("created_at","desc")->paginate(15)->withQueryString();
        return view("admin.anggota.dokumen", compact("anggota"));
    }
    public function print(Anggota $anggota, Request $request) {
        $type = $request->get('type', 'kartu');
        $judul = 'Kartu Anggota';
        $subJudul = $anggota->no_anggota;
        return view('admin.anggota.partials.Print', compact('anggota','type','judul','subJudul'));
    }
}
