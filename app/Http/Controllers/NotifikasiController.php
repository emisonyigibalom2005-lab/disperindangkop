<?php
namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    // API: ambil notifikasi belum dibaca (untuk polling)
    public function unread()
    {
        $notif = Notifikasi::where("user_id", auth()->id())
            ->where("dibaca", false)
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            "count" => $notif->count(),
            "items" => $notif->map(fn($n) => [
                "id"        => $n->id,
                "judul"     => $n->judul,
                "pesan"     => $n->pesan,
                "icon"      => $n->icon,
                "warna"     => $n->warna,
                "url"       => $n->url,
                "tipe"      => $n->tipe,
                "waktu"     => $n->created_at->diffForHumans(),
            ])
        ]);
    }

    // Tandai 1 notifikasi dibaca
    public function read(Notifikasi $notifikasi)
    {
        if($notifikasi->user_id === auth()->id()) {
            $notifikasi->update(["dibaca" => true]);
        }
        return response()->json(["ok" => true]);
    }

    // Tandai semua dibaca
    public function readAll()
    {
        Notifikasi::where("user_id", auth()->id())
                  ->where("dibaca", false)
                  ->update(["dibaca" => true]);
        return response()->json(["ok" => true]);
    }

    // Halaman semua notifikasi
    public function index()
    {
        $notifikasi = Notifikasi::where("user_id", auth()->id())
            ->latest()->paginate(20);
        // Tandai semua dibaca saat halaman dibuka
        Notifikasi::where("user_id", auth()->id())
                  ->where("dibaca", false)
                  ->update(["dibaca" => true]);
        return view("notifikasi.index", compact("notifikasi"));
    }

    // Hapus notifikasi
    public function destroy(Notifikasi $notifikasi)
    {
        if($notifikasi->user_id === auth()->id()) {
            $notifikasi->delete();
        }
        return back()->with("success", "Notifikasi dihapus.");
    }
}