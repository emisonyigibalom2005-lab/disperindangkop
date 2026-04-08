<?php
namespace App\Http\Controllers\Anggota;
use App\Http\Controllers\Controller;
use App\Models\Anggota;

class PortalAnggotaController extends Controller {

    public function dashboard() {
        $user = auth()->user();
        $anggota = Anggota::where('user_id', $user->id)->first();
        if (!$anggota) return view('anggota.menunggu', ['anggota' => null]);
        if ($anggota->status === 'Pending') return view('anggota.menunggu', compact('anggota'));
        if ($anggota->status === 'Ditolak') return view('anggota.ditolak', compact('anggota'));
        return view('anggota.dashboard', compact('anggota'));
    }

    public function kartu() {
        $user = auth()->user();
        $anggota = Anggota::where('user_id', $user->id)->firstOrFail();
        return view('anggota.kartu', compact('anggota'));
    }

    public function profil() {
        $user = auth()->user();
        $anggota = Anggota::where('user_id', $user->id)->firstOrFail();
        return view('anggota.profil', compact('anggota'));
    }
}
