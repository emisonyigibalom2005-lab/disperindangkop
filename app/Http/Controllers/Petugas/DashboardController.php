<?php
namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use App\Models\Bantuan;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_koperasi'    => Koperasi::count(),
            'koperasi_pending'  => Koperasi::where('status_verifikasi','pending')->count(),
            'koperasi_verified' => Koperasi::where('status_verifikasi','diverifikasi')->count(),
            'total_bantuan' => Bantuan::where('status','aktif')->count(),
        ];
        $koperasi_pending = Koperasi::where('status_verifikasi','pending')->latest()->take(5)->get();
        return view('petugas.dashboard', compact('stats','koperasi_pending'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('petugas.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.$user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $data = $request->only(['name','email','phone']);
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_photo);
            $data['profile_photo'] = $request->file('profile_photo')->store('foto_profil','public');
        }
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return back()->with('success','Profil berhasil diperbarui.');
    }
}
