<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PengajuanBantuan;
use Illuminate\Http\Request;

class PengajuanBantuanController extends Controller
{
    public function index(Request $request)
    {
        $q = PengajuanBantuan::query();
        if ($request->status)
            $q->where('status', $request->status);
        $pengajuan = $q->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.pengajuan_bantuan.index', compact('pengajuan'));
    }
    public function show(PengajuanBantuan $pengajuanBantuan)
    {
        return view('admin.pengajuan_bantuan.show', compact('pengajuanBantuan'));
    }
    public function update(Request $request, PengajuanBantuan $pengajuanBantuan)
    {
        $pengajuanBantuan->update(['status' => $request->status, 'catatan_admin' => $request->catatan_admin]);
        return back()->with('success', 'Status pengajuan diperbarui!');
    }
    public function destroy(PengajuanBantuan $pengajuanBantuan)
    {
        $pengajuanBantuan->delete();
        return redirect()->route('admin.pengajuan-bantuan.index')->with('success', 'Data dihapus!');
    }
}