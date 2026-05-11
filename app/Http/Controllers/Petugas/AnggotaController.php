<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use App\Models\Koperasi;
use App\Models\PeriodePendaftaran;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        if (!can_view('anggota')) {
            abort(403, 'Anda tidak memiliki izin untuk melihat data anggota');
        }
        
        $query = Anggota::with(['koperasi', 'periodePendaftaran']);
        
        // DATA ANGGOTA KOPERASI = Anggota yang SUDAH PERNAH DIVERIFIKASI
        // Kriteria: tanggal_bergabung TERISI (sudah pernah disetujui)
        // Status: Aktif, Pending, Nonaktif (semua yang sudah pernah diverifikasi)
        $query->whereNotNull('tanggal_bergabung');
        
        // Filter
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%')
                  ->orWhere('no_ktp', 'like', '%' . $request->search . '%')
                  ->orWhere('no_anggota', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('distrik')) {
            $query->where('distrik', $request->distrik);
        }
        
        if ($request->filled('koperasi_id')) {
            $query->where('koperasi_id', $request->koperasi_id);
        }
        
        $anggota = $query->latest()->paginate(15)->appends($request->query());
        $koperasi = Koperasi::where('status_verifikasi', 'diverifikasi')->get();
        
        // Hitung statistik - Hanya yang sudah diverifikasi
        $stats = [
            'total' => Anggota::whereNotNull('tanggal_bergabung')->count(),
            'aktif' => Anggota::whereNotNull('tanggal_bergabung')->where('status', 'Aktif')->count(),
            'nonaktif' => Anggota::whereNotNull('tanggal_bergabung')->where('status', 'Nonaktif')->count(),
            'pending' => Anggota::whereNotNull('tanggal_bergabung')->where('status', 'Pending')->count(),
        ];
        
        // Daftar distrik
        $distrik = [
            'Karubaga', 'Bokondini', 'Tiom', 'Kembu', 'Bewani', 
            'Bokoneri', 'Geya', 'Nabunage', 'Kanggime', 'Wugi', 
            'Kagime', 'Lainnya'
        ];
        
        return view('petugas.anggota.index', compact('anggota', 'koperasi', 'stats', 'distrik'));
    }

    public function create()
    {
        if (!can_create('anggota')) {
            abort(403, 'Anda tidak memiliki izin untuk menambah data anggota');
        }
        
        // Petugas HARUS mengikuti periode pendaftaran (seperti User)
        // Cek apakah ada periode pendaftaran yang aktif
        $periodeAktif = PeriodePendaftaran::where('status', 'aktif')
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->first();
        
        // Jika tidak ada periode aktif, tampilkan halaman pendaftaran ditutup
        if (!$periodeAktif) {
            return view('petugas.anggota.pendaftaran-ditutup');
        }
        
        // Cek apakah kuota sudah penuh
        if ($periodeAktif->kuota && $periodeAktif->jumlah_pendaftar >= $periodeAktif->kuota) {
            return view('petugas.anggota.kuota-penuh', compact('periodeAktif'));
        }
        
        $no = Anggota::generateNoAnggota();
        return view('petugas.anggota.create', compact('no', 'periodeAktif'));
    }

    public function store(Request $request)
    {
        if (!can_create('anggota')) {
            abort(403, 'Anda tidak memiliki izin untuk menambah data anggota');
        }
        
        // Petugas HARUS mengikuti periode pendaftaran (seperti User)
        // Cek apakah ada periode pendaftaran yang aktif
        $periodeAktif = PeriodePendaftaran::where('status', 'aktif')
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->first();
        
        // Jika tidak ada periode aktif, tolak pendaftaran
        if (!$periodeAktif) {
            return back()->with('error', 'Pendaftaran anggota baru sedang ditutup. Silakan hubungi Admin untuk membuka periode pendaftaran.')
                ->withInput();
        }
        
        // Cek apakah kuota sudah penuh
        if ($periodeAktif->kuota && $periodeAktif->jumlah_pendaftar >= $periodeAktif->kuota) {
            return back()->with('error', 'Kuota pendaftaran periode ini sudah penuh (' . $periodeAktif->kuota . ' pendaftar).')
                ->withInput();
        }
        
        // Sanitize numeric fields to prevent scientific notation issues
        $numericFields = ['lama_berdiri_usaha', 'jumlah_karyawan', 'modal_usaha', 'omzet_per_bulan'];
        foreach ($numericFields as $field) {
            if ($request->has($field) && $request->input($field) !== null) {
                $value = $request->input($field);
                // Remove any non-numeric characters except decimal point
                $value = preg_replace('/[^0-9.]/', '', $value);
                // If empty after sanitization, set to 0
                $value = $value === '' ? 0 : $value;
                $request->merge([$field => $value]);
            }
        }
        
        // Fix nama_usaha if it's "null" string
        if ($request->input('nama_usaha') === 'null' || $request->input('nama_usaha') === null) {
            $request->merge(['nama_usaha' => 'Usaha ' . $request->input('nama')]);
        }
        
        // Validasi input
        $validated = $request->validate([
            // Identitas Pribadi
            'nik' => 'required|string|size:16|unique:anggotas,nik',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'status_perkawinan' => 'nullable|in:Lajang,Menikah,Cerai',
            'pendidikan_terakhir' => 'nullable|string',
            'agama' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            
            // Alamat
            'desa' => 'nullable|string|max:100',
            'distrik' => 'required|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'alamat_lengkap' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:10',
            'koordinat_gps' => 'nullable|string|max:100',
            'status_kepemilikan_rumah' => 'nullable|in:Milik Sendiri,Sewa,Ikut Orang Tua,Kontrak',
            
            // Usaha
            'nama_usaha' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:100',
            'lama_berdiri_usaha' => 'nullable|integer|min:0',
            'jumlah_karyawan' => 'nullable|integer|min:0',
            'modal_usaha' => 'nullable|numeric|min:0',
            'omzet_per_bulan' => 'nullable|numeric|min:0',
            'alamat_tempat_usaha' => 'nullable|string',
            'legalitas_usaha' => 'nullable|string|max:100',
            'keterangan_usaha' => 'nullable|string',
            
            // Ahli Waris
            'nama_ahli_waris' => 'required|string|max:255',
            'hubungan_ahli_waris' => 'required|string|max:50',
            'no_hp_ahli_waris' => 'required|string|max:15',
            'nik_ahli_waris' => 'required|string|size:16',
            
            // Files
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            
            // Status
            'status' => 'nullable|in:Pending,Aktif,Nonaktif,Ditolak',
        ], [
            // Custom error messages
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'nama.required' => 'Nama lengkap wajib diisi',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'agama.required' => 'Agama wajib dipilih',
            'no_hp.required' => 'Nomor HP wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'distrik.required' => 'Distrik wajib dipilih',
            'nama_usaha.required' => 'Nama usaha wajib diisi',
            'bidang_usaha.required' => 'Bidang usaha wajib dipilih',
            'nama_ahli_waris.required' => 'Nama ahli waris wajib diisi',
            'hubungan_ahli_waris.required' => 'Hubungan keluarga wajib dipilih',
            'no_hp_ahli_waris.required' => 'Nomor HP ahli waris wajib diisi',
            'nik_ahli_waris.required' => 'NIK ahli waris wajib diisi',
            'nik_ahli_waris.size' => 'NIK ahli waris harus 16 digit',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Foto harus format JPG, JPEG, atau PNG',
            'foto.max' => 'Ukuran foto maksimal 2MB',
        ]);
        
        try {
            \DB::beginTransaction();
            
            // Generate nomor anggota
            $noAnggota = Anggota::generateNoAnggota();
            
            // Upload foto jika ada
            $filePaths = [];
            if ($request->hasFile('foto')) {
                $filePaths['foto'] = $request->file('foto')->store('anggota', 'public');
            }
            
            // Create User Account jika email diisi
            $userId = null;
            if ($request->filled('email')) {
                $user = User::create([
                    'name' => $validated['nama'],
                    'email' => $validated['email'],
                    'password' => \Hash::make($validated['password']), // Password yang diinput petugas
                    'role' => 'anggota',
                ]);
                $userId = $user->id;
            }
            
            // Set default values
            $defaults = [
                'lama_berdiri_usaha' => $validated['lama_berdiri_usaha'] ?? 0,
                'jumlah_karyawan' => $validated['jumlah_karyawan'] ?? 0,
                'modal_usaha' => $validated['modal_usaha'] ?? 0,
                'omzet_per_bulan' => $validated['omzet_per_bulan'] ?? 0,
                'kabupaten' => $validated['kabupaten'] ?? 'Tolikara',
                // Simpanan akan diisi nanti setelah anggota diterima
                'simpanan_pokok' => 0,
                'simpanan_wajib' => 0,
            ];
            
            // Merge defaults dengan validated data
            $validated = array_merge($defaults, $validated);
            
            // Hanya ambil field yang ada di tabel anggotas
            $allowedFields = [
                'nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'no_hp',
                'desa', 'distrik', 'kabupaten', 'alamat_lengkap', 'kode_pos', 'koordinat_gps',
                'status_kepemilikan_rumah', 'status_perkawinan', 'pendidikan_terakhir',
                'nama_usaha', 'bidang_usaha', 'lama_berdiri_usaha', 'jumlah_karyawan',
                'modal_usaha', 'omzet_per_bulan', 'alamat_tempat_usaha', 'legalitas_usaha',
                'keterangan_usaha',
                'nama_ahli_waris', 'hubungan_ahli_waris', 'no_hp_ahli_waris', 'nik_ahli_waris',
                'simpanan_pokok', 'simpanan_wajib'
            ];
            
            // Filter hanya field yang diizinkan
            $filteredData = [];
            foreach ($allowedFields as $field) {
                if (isset($validated[$field])) {
                    $filteredData[$field] = $validated[$field];
                }
            }
            
            // Create Anggota
            $anggotaData = array_merge($filteredData, $filePaths, [
                'no_anggota' => $noAnggota,
                'periode_pendaftaran_id' => $periodeAktif ? $periodeAktif->id : null,
                'user_id' => $userId,
                'status' => $request->input('status', 'Pending'), // Default Pending untuk verifikasi admin
                'tanggal_bergabung' => null, // NULL - Akan diisi setelah admin verifikasi
                'created_by' => auth()->id(), // Petugas yang mendaftarkan
                'total_simpanan' => 0, // Simpanan akan diisi nanti setelah anggota diterima
            ]);
            
            $anggota = Anggota::create($anggotaData);
            
            // Update jumlah pendaftar jika ada periode
            if ($periodeAktif) {
                $periodeAktif->increment('jumlah_pendaftar');
            }
            
            // Log aktivitas
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'create',
                'module' => 'ANGGOTA',
                'description' => 'Mendaftarkan anggota baru: ' . $anggota->nama . ' (' . $noAnggota . ') dengan akun user: ' . ($userId ? $validated['email'] : 'tanpa akun'),
                'ip_address' => $request->ip(),
            ]);
            
            \DB::commit();
            
            // Kirim notifikasi ke user jika ada
            if ($userId) {
                \App\Models\Notifikasi::create([
                    'user_id' => $userId,
                    'judul' => '📝 Pendaftaran Berhasil - Menunggu Verifikasi',
                    'pesan' => 'Pendaftaran Anda sebagai anggota koperasi telah berhasil dengan nomor anggota: ' . $noAnggota . '. Saat ini pendaftaran Anda sedang dalam proses verifikasi oleh admin. Anda akan menerima notifikasi setelah verifikasi selesai.',
                    'tipe' => 'info',
                    'link' => route('login'),
                    'is_read' => false,
                ]);
            }
            
            return redirect()->route('petugas.anggota.index')
                ->with('success', 'Anggota berhasil didaftarkan dengan nomor: ' . $noAnggota . '. Status: Menunggu Verifikasi Admin.' . ($userId ? ' Akun login telah dibuat.' : ''));
                
        } catch (\Exception $e) {
            \DB::rollBack();
            
            \Log::error('Error mendaftarkan anggota dari petugas: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Anggota $anggota)
    {
        if (!can_view('anggota')) {
            abort(403, 'Anda tidak memiliki izin untuk melihat detail anggota');
        }
        
        $anggota->load(['koperasi', 'periodePendaftaran', 'createdBy']);
        return view('petugas.anggota.show', compact('anggota'));
    }

    public function edit(Anggota $anggota)
    {
        if (!can_edit('anggota')) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit data anggota');
        }
        
        $koperasi = Koperasi::where('status_verifikasi', 'diverifikasi')
            ->where('status_usaha', 'aktif')
            ->orderBy('nama_usaha')
            ->get();
        
        return view('petugas.anggota.edit', compact('anggota', 'koperasi'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        if (!can_edit('anggota')) {
            abort(403, 'Anda tidak memiliki izin untuk mengupdate data anggota');
        }
        
        $validated = $request->validate([
            'koperasi_id' => 'required|exists:koperasi,id',
            'nik' => 'required|string|size:16|unique:anggotas,nik,' . $anggota->id,
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'status_perkawinan' => 'required|in:Lajang,Menikah,Cerai',
            'pendidikan_terakhir' => 'required|string|max:255',
            'agama' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'desa' => 'nullable|string|max:255',
            'distrik' => 'required|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'alamat_lengkap' => 'nullable|string',
            'nama_komplek_dekat_desa' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'nama_usaha' => 'nullable|string|max:255',
            'modal_usaha' => 'nullable|numeric|min:0',
            'omzet_per_bulan' => 'nullable|numeric|min:0',
            'keterangan_usaha' => 'nullable|string',
            'nama_ibu_kandung' => 'nullable|string|max:255',
            'simpanan_pokok' => 'nullable|numeric|min:0',
            'simpanan_wajib' => 'nullable|numeric|min:0',
            'total_simpanan' => 'nullable|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|in:Aktif,Pending,Nonaktif,Ditolak',
        ]);
        
        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($anggota->foto) {
                Storage::disk('public')->delete($anggota->foto);
            }
            $validated['foto'] = $request->file('foto')->store('anggota/foto', 'public');
        }
        
        // Update data anggota
        $anggota->update($validated);
        
        // Update email user jika ada perubahan
        if ($anggota->user_id && $request->filled('email')) {
            $user = \App\Models\User::find($anggota->user_id);
            if ($user && $user->email !== $request->email) {
                $user->update([
                    'email' => $request->email,
                    'name' => $validated['nama'],
                    'phone' => $validated['no_hp'],
                ]);
            }
        }
        
        // Log aktivitas
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'module' => 'ANGGOTA',
            'description' => 'Mengupdate data anggota: ' . $anggota->nama . ' (' . $anggota->no_anggota . ')',
            'ip_address' => $request->ip(),
        ]);
        
        return redirect()->route('petugas.anggota.index')
            ->with('success', 'Data anggota berhasil diupdate');
    }

    public function destroy(Anggota $anggota)
    {
        if (!can_delete('anggota')) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus data anggota');
        }
        
        // Hapus foto jika ada
        if ($anggota->foto) {
            Storage::disk('public')->delete($anggota->foto);
        }
        
        // Hapus user account jika ada
        if ($anggota->user_id) {
            \App\Models\User::find($anggota->user_id)->delete();
        }
        
        // Log aktivitas
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'module' => 'ANGGOTA',
            'description' => 'Menghapus anggota: ' . $anggota->nama . ' (' . $anggota->no_anggota . ')',
            'ip_address' => request()->ip(),
        ]);
        
        $anggota->delete();
        
        return redirect()->route('petugas.anggota.index')
            ->with('success', 'Data anggota berhasil dihapus');
    }
    
    // Kartu & Sertifikat Methods
    public function kartuSertifikatList(Request $request) {
        if (!can_view('anggota')) {
            abort(403, 'Anda tidak memiliki izin untuk melihat kartu & sertifikat');
        }
        
        try {
            // Query anggota
            $qAnggota = Anggota::with('koperasi');
            if ($request->search_anggota) {
                $qAnggota->where(function($query) use ($request) {
                    $query->where('nama','like',"%{$request->search_anggota}%")
                          ->orWhere('no_anggota','like',"%{$request->search_anggota}%");
                });
            }
            $anggota = $qAnggota->orderBy('created_at','desc')->paginate(12)->withQueryString();
            
            // Query koperasi
            $qKoperasi = \App\Models\Koperasi::query();
            if ($request->search_koperasi) {
                $qKoperasi->where(function($query) use ($request) {
                    $query->where('nama_usaha','like',"%{$request->search_koperasi}%")
                          ->orWhere('no_registrasi','like',"%{$request->search_koperasi}%");
                });
            }
            $koperasi = $qKoperasi->orderBy('created_at','desc')->paginate(12)->withQueryString();
            
            return view('petugas.anggota.kartu-sertifikat-list', compact('anggota', 'koperasi'));
        } catch (\Exception $e) {
            \Log::error('Error in kartuSertifikatList: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function downloadKartu(Anggota $anggota) {
        if (!can_view('anggota')) {
            abort(403, 'Anda tidak memiliki izin untuk download kartu');
        }
        
        $type = 'kartu';
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('petugas.anggota.kartu-sertifikat', compact('anggota', 'type'));
        $pdf->setPaper([0, 0, 242.65, 153], 'landscape'); // 85.6mm x 53.98mm in points
        
        $filename = 'Kartu_Anggota_' . str_replace(' ', '_', $anggota->nama) . '.pdf';
        return $pdf->download($filename);
    }
    
    public function downloadSertifikat(Anggota $anggota) {
        if (!can_view('anggota')) {
            abort(403, 'Anda tidak memiliki izin untuk download sertifikat');
        }
        
        $type = 'sertifikat';
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('petugas.anggota.kartu-sertifikat', compact('anggota', 'type'));
        $pdf->setPaper('a4', 'portrait'); // A4 Portrait untuk sertifikat 1 halaman
        
        $filename = 'Sertifikat_' . str_replace(' ', '_', $anggota->nama) . '.pdf';
        return $pdf->download($filename);
    }
    
    public function downloadDokumen(Anggota $anggota) {
        if (!can_view('anggota')) {
            abort(403, 'Anda tidak memiliki izin untuk download dokumen');
        }
        
        // Generate HTML content
        $html = view('petugas.anggota.dokumen-word', compact('anggota'))->render();
        
        // Set headers for Word download
        $filename = 'Dokumen_Anggota_' . str_replace(' ', '_', $anggota->nama) . '_' . $anggota->no_anggota . '.doc';
        
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-word')
            ->header('Content-Disposition', 'attachment;filename="' . $filename . '"')
            ->header('Cache-Control', 'max-age=0');
    }
    
    public function printDokumen(Anggota $anggota) {
        if (!can_view('anggota')) {
            abort(403, 'Anda tidak memiliki izin untuk print dokumen');
        }
        
        // Return HTML view for printing (not download)
        return view('petugas.anggota.dokumen-word', compact('anggota'));
    }
}
