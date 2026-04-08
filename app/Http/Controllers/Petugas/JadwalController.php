<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::orderBy('created_at', 'desc')->paginate(15);
        return view('petugas.jadwal.index', compact('jadwal'));
    }

    public function show(Jadwal $jadwal)
    {
        return view('petugas.jadwal.show', compact('jadwal'));
    }

    public function updateStatus(Request $request, Jadwal $jadwal)
    {
        $jadwal->update(['status' => $request->status]);
        return back()->with('success', 'Status jadwal diperbarui!');
    }
}
