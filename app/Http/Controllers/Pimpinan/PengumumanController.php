<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        // Get selected pengumuman if ID is provided
        $selectedPengumuman = null;
        if ($request->has('id')) {
            $selectedPengumuman = Pengumuman::with('user')->find($request->id);
        } else {
            // Auto-select first active pengumuman if no ID provided
            $selectedPengumuman = Pengumuman::with('user')
                ->where('is_aktif', true)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        return view('pimpinan.pengumuman.index', compact('selectedPengumuman'));
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::with('user')->findOrFail($id);
        
        return view('pimpinan.pengumuman.show', compact('pengumuman'));
    }
}
