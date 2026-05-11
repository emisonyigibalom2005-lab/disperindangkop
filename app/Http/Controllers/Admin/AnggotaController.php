<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use App\Models\PeriodePendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller {

    public function index(Request $request) {
        $q = Anggota::query();
        
        // DATA ANGGOTA KOPERASI = Anggota yang SUDAH PERNAH DIVERIFIKASI
        // Kriteria: tanggal_bergabung TERISI (sudah pernah disetujui)
        // Status: Aktif, Pending, Nonaktif (semua yang sudah pernah diverifikasi)
        
        $q->whereNotNull('tanggal_bergabung');
        
        // Optional status filter from request
        if ($request->status) {
            $q->where('status', $request->status);
        }
        
        if ($request->search) {
            $q->where(function($query) use ($request) {
                $query->where('nama','like',"%{$request->search}%")
                      ->orWhere('no_anggota','like',"%{$request->search}%");
            });
        }
        
        if ($request->distrik) {
            $q->where('distrik',$request->distrik);
        }
        
        $anggota = $q->orderBy('created_at','desc')->paginate(15)->withQueryString();
        $distrik = Anggota::distinct()->pluck('distrik');
        
        // Stats untuk yang sudah diverifikasi
        $stats = [
            'total'    => Anggota::whereNotNull('tanggal_bergabung')->count(),
            'aktif'    => Anggota::whereNotNull('tanggal_bergabung')->where('status','Aktif')->count(),
            'pending'  => Anggota::whereNotNull('tanggal_bergabung')->where('status','Pending')->count(),
            'nonaktif' => Anggota::whereNotNull('tanggal_bergabung')->where('status','Nonaktif')->count(),
        ];
        return view('admin.anggota.index', compact('anggota','distrik','stats'));
    }

    public function create() {
        // Admin bisa mendaftarkan anggota kapan saja, tidak tergantung periode
        // Cek apakah ada periode pendaftaran yang aktif
        $periodeAktif = PeriodePendaftaran::aktif()->first();
        
        // Jika tidak ada periode aktif, gunakan periode terakhir atau null
        if (!$periodeAktif) {
            $periodeAktif = PeriodePendaftaran::latest()->first();
        }
        
        $no = Anggota::generateNoAnggota();
        return view('admin.anggota.create', compact('no', 'periodeAktif'));
    }

    public function store(Request $request) {
        // Admin bisa mendaftarkan anggota kapan saja, tidak tergantung periode
        // Cek periode pendaftaran (gunakan yang aktif atau terakhir)
        $periodeAktif = PeriodePendaftaran::aktif()->first();
        
        if (!$periodeAktif) {
            // Jika tidak ada periode aktif, gunakan periode terakhir
            $periodeAktif = PeriodePendaftaran::latest()->first();
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
                    'password' => \Hash::make($validated['password']), // Password yang diinput admin
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
                'tanggal_bergabung' => null, // Akan diisi saat disetujui
                'created_by' => auth()->id(), // Admin yang mendaftarkan
                'total_simpanan' => 0, // Simpanan akan diisi nanti setelah anggota diterima
            ]);
            
            $anggota = Anggota::create($anggotaData);
            
            // Update jumlah pendaftar jika ada periode
            if ($periodeAktif) {
                $periodeAktif->increment('jumlah_pendaftar');
            }
            
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
            
            return redirect()->route('admin.anggota.verifikasi')
                ->with('success', 'Anggota berhasil didaftarkan dengan nomor: ' . $noAnggota . '. Status: Menunggu Verifikasi.' . ($userId ? ' Akun login telah dibuat.' : ''));
                
        } catch (\Exception $e) {
            \DB::rollBack();
            
            \Log::error('Error mendaftarkan anggota dari admin: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Anggota $anggota) {
        // Simpan URL sebelumnya ke session
        if (request()->headers->get('referer')) {
            session(['previous_url' => request()->headers->get('referer')]);
        }
        
        return view('admin.anggota.show', compact('anggota'));
    }

    public function edit(Anggota $anggota) {
        // Simpan URL sebelumnya ke session
        if (request()->headers->get('referer')) {
            session(['previous_url' => request()->headers->get('referer')]);
        }
        
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota) {
        $request->validate([
            'nik'  => 'required|digits:16|unique:anggotas,nik,'.$anggota->id,
            'nama' => 'required',
            'status' => 'nullable|in:Aktif,Pending,Nonaktif,Ditolak',
        ]);
        
        // Simpan data lama untuk deteksi perubahan
        $dataLama = $anggota->only([
            'nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 
            'agama', 'no_hp', 'email', 'desa', 'distrik', 'kabupaten', 
            'alamat_lengkap', 'nama_komplek_dekat_desa', 'nama_usaha', 
            'modal_usaha', 'omzet_per_bulan', 'total_simpanan', 
            'keterangan_usaha', 'status', 'foto'
        ]);
        
        $d = $request->only(['nik','nama','tempat_lahir','tanggal_lahir','jenis_kelamin','agama','no_hp','email','desa','distrik','kabupaten','alamat_lengkap','nama_komplek_dekat_desa','nama_usaha','modal_usaha','omzet_per_bulan','total_simpanan','keterangan_usaha','status']);
        
        if ($request->hasFile('foto')) {
            if ($anggota->foto) Storage::disk('public')->delete($anggota->foto);
            $d['foto'] = $request->file('foto')->store('anggota','public');
        }
        
        // Update data anggota
        $anggota->update($d);
        
        // Deteksi perubahan dan kirim notifikasi
        $perubahanDetail = [];
        $labelField = [
            'nik' => 'NIK',
            'nama' => 'Nama Lengkap',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'agama' => 'Agama',
            'no_hp' => 'No. HP',
            'email' => 'Email',
            'desa' => 'Desa',
            'distrik' => 'Distrik',
            'kabupaten' => 'Kabupaten',
            'alamat_lengkap' => 'Alamat Lengkap',
            'nama_komplek_dekat_desa' => 'Nama Komplek/Dekat Desa',
            'nama_usaha' => 'Nama Usaha',
            'modal_usaha' => 'Modal Usaha',
            'omzet_per_bulan' => 'Omzet Per Bulan',
            'total_simpanan' => 'Total Simpanan',
            'keterangan_usaha' => 'Keterangan Usaha',
            'status' => 'Status Keanggotaan',
            'foto' => 'Foto Profil'
        ];
        
        foreach ($dataLama as $field => $nilaiLama) {
            $nilaiBaru = $d[$field] ?? $anggota->$field;
            
            // Skip jika tidak ada perubahan
            if ($nilaiLama == $nilaiBaru) continue;
            
            // Format nilai untuk tampilan
            $nilaiLamaFormatted = $nilaiLama;
            $nilaiBaruFormatted = $nilaiBaru;
            
            if (in_array($field, ['modal_usaha', 'omzet_per_bulan', 'total_simpanan'])) {
                $nilaiLamaFormatted = 'Rp ' . number_format($nilaiLama ?? 0, 0, ',', '.');
                $nilaiBaruFormatted = 'Rp ' . number_format($nilaiBaru ?? 0, 0, ',', '.');
            } elseif ($field === 'tanggal_lahir') {
                $nilaiLamaFormatted = $nilaiLama ? \Carbon\Carbon::parse($nilaiLama)->format('d M Y') : '-';
                $nilaiBaruFormatted = $nilaiBaru ? \Carbon\Carbon::parse($nilaiBaru)->format('d M Y') : '-';
            } elseif ($field === 'jenis_kelamin') {
                $nilaiLamaFormatted = $nilaiLama === 'L' ? 'Laki-laki' : 'Perempuan';
                $nilaiBaruFormatted = $nilaiBaru === 'L' ? 'Laki-laki' : 'Perempuan';
            } elseif ($field === 'foto') {
                $nilaiLamaFormatted = $nilaiLama ? 'Ada' : 'Tidak ada';
                $nilaiBaruFormatted = $nilaiBaru ? 'Diperbarui' : 'Tidak ada';
            }
            
            $perubahanDetail[] = [
                'field' => $labelField[$field] ?? $field,
                'lama' => $nilaiLamaFormatted ?: '-',
                'baru' => $nilaiBaruFormatted ?: '-'
            ];
        }
        
        // Kirim notifikasi jika ada perubahan dan anggota punya user_id
        if (count($perubahanDetail) > 0 && $anggota->user_id) {
            $perubahanText = '';
            $jumlahPerubahan = count($perubahanDetail);
            
            // Cek apakah ada perubahan status
            $statusBerubah = false;
            $statusLama = null;
            $statusBaru = null;
            foreach ($perubahanDetail as $perubahan) {
                if ($perubahan['field'] === 'Status Keanggotaan') {
                    $statusBerubah = true;
                    $statusLama = $perubahan['lama'];
                    $statusBaru = $perubahan['baru'];
                    break;
                }
            }
            
            // Jika status berubah, kirim notifikasi khusus untuk perubahan status
            if ($statusBerubah) {
                $judulNotifikasi = '';
                $pesanNotifikasi = '';
                $tipeNotifikasi = 'info';
                $iconNotifikasi = '📝';
                
                if ($statusBaru === 'Aktif') {
                    $judulNotifikasi = '✅ Status Keanggotaan: AKTIF';
                    $pesanNotifikasi = "Selamat! Status keanggotaan Anda telah diubah menjadi <strong>AKTIF</strong> oleh admin.\n\n";
                    $pesanNotifikasi .= "Anda sekarang dapat mengakses semua layanan koperasi dengan penuh. Silakan login dan nikmati berbagai fasilitas yang tersedia.\n\n";
                    $pesanNotifikasi .= "<strong>Status Sebelumnya:</strong> {$statusLama}\n";
                    $pesanNotifikasi .= "<strong>Status Sekarang:</strong> {$statusBaru}";
                    $tipeNotifikasi = 'success';
                    $iconNotifikasi = '✅';
                } elseif ($statusBaru === 'Nonaktif') {
                    $judulNotifikasi = '⚠️ Status Keanggotaan: NONAKTIF';
                    $pesanNotifikasi = "Status keanggotaan Anda telah diubah menjadi <strong>NONAKTIF</strong> oleh admin.\n\n";
                    $pesanNotifikasi .= "Akses Anda ke beberapa layanan koperasi mungkin terbatas. Jika Anda memiliki pertanyaan atau ingin mengaktifkan kembali keanggotaan, silakan hubungi admin koperasi.\n\n";
                    $pesanNotifikasi .= "<strong>Status Sebelumnya:</strong> {$statusLama}\n";
                    $pesanNotifikasi .= "<strong>Status Sekarang:</strong> {$statusBaru}";
                    $tipeNotifikasi = 'warning';
                    $iconNotifikasi = '⚠️';
                } elseif ($statusBaru === 'Pending') {
                    $judulNotifikasi = '⏳ Status Keanggotaan: PENDING';
                    $pesanNotifikasi = "Status keanggotaan Anda telah diubah menjadi <strong>PENDING</strong> oleh admin.\n\n";
                    $pesanNotifikasi .= "Keanggotaan Anda sedang dalam proses review. Mohon tunggu konfirmasi lebih lanjut dari admin koperasi.\n\n";
                    $pesanNotifikasi .= "<strong>Status Sebelumnya:</strong> {$statusLama}\n";
                    $pesanNotifikasi .= "<strong>Status Sekarang:</strong> {$statusBaru}";
                    $tipeNotifikasi = 'info';
                    $iconNotifikasi = '⏳';
                }
                
                // Tambahkan perubahan lainnya jika ada
                if ($jumlahPerubahan > 1) {
                    $pesanNotifikasi .= "\n\n<strong>Perubahan Data Lainnya:</strong>\n";
                    $perubahanLain = 0;
                    foreach ($perubahanDetail as $perubahan) {
                        if ($perubahan['field'] !== 'Status Keanggotaan' && $perubahanLain < 5) {
                            $pesanNotifikasi .= "• {$perubahan['field']}: {$perubahan['lama']} → {$perubahan['baru']}\n";
                            $perubahanLain++;
                        }
                    }
                    if ($jumlahPerubahan - 1 > 5) {
                        $pesanNotifikasi .= "• ... dan " . ($jumlahPerubahan - 1 - 5) . " perubahan lainnya\n";
                    }
                }
                
                \App\Models\Notifikasi::create([
                    'user_id' => $anggota->user_id,
                    'judul'   => $iconNotifikasi . ' ' . $judulNotifikasi,
                    'pesan'   => $pesanNotifikasi,
                    'tipe'    => $tipeNotifikasi,
                    'link'    => route('anggota.profil'),
                    'is_read' => false,
                ]);
                
                return redirect(session('previous_url', route('admin.anggota.index')))->with('success', 'Data anggota berhasil diperbarui! Status berubah: ' . $statusLama . ' → ' . $statusBaru . '. Notifikasi telah dikirim ke anggota.');
            } else {
                // Notifikasi biasa untuk perubahan data (tanpa perubahan status)
                // Batasi detail perubahan maksimal 5 item di notifikasi
                $perubahanTampil = array_slice($perubahanDetail, 0, 5);
                
                foreach ($perubahanTampil as $perubahan) {
                    $perubahanText .= "• {$perubahan['field']}: {$perubahan['lama']} → {$perubahan['baru']}\n";
                }
                
                if ($jumlahPerubahan > 5) {
                    $perubahanText .= "• ... dan " . ($jumlahPerubahan - 5) . " perubahan lainnya\n";
                }
                
                $pesanNotifikasi = "Admin telah memperbarui data Anda:\n\n" . $perubahanText . "\nSilakan cek profil Anda untuk melihat detail lengkap.";
                
                \App\Models\Notifikasi::create([
                    'user_id' => $anggota->user_id,
                    'judul'   => '📝 Data Anda Diperbarui oleh Admin',
                    'pesan'   => $pesanNotifikasi,
                    'tipe'    => 'info',
                    'link'    => route('anggota.profil'),
                    'is_read' => false,
                ]);
                
                return redirect(session('previous_url', route('admin.anggota.index')))->with('success', 'Data anggota berhasil diperbarui dan notifikasi telah dikirim! (' . $jumlahPerubahan . ' perubahan)');
            }
        }
        
        return redirect(session('previous_url', route('admin.anggota.index')))->with('success','Data anggota diperbarui!');
    }

    public function destroy(Anggota $anggota) {
        if ($anggota->foto) Storage::disk('public')->delete($anggota->foto);
        $anggota->delete();
        return redirect()->route('admin.anggota.index')->with('success','Anggota dihapus!');
    }

    public function sertifikat(Anggota $anggota, Request $request) {
        $type = $request->get('type', 'kartu'); // kartu atau sertifikat
        return view('admin.anggota.kartu-sertifikat', compact('anggota', 'type'));
    }
    
    public function downloadDokumen(Anggota $anggota) {
        // Generate HTML content
        $html = view('admin.anggota.dokumen-word', compact('anggota'))->render();
        
        // Set headers for Word download
        $filename = 'Dokumen_Anggota_' . str_replace(' ', '_', $anggota->nama) . '_' . $anggota->no_anggota . '.doc';
        
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-word')
            ->header('Content-Disposition', 'attachment;filename="' . $filename . '"')
            ->header('Cache-Control', 'max-age=0');
    }
    
    public function printDokumen(Anggota $anggota) {
        // Return HTML view for printing (not download)
        return view('admin.anggota.dokumen-word', compact('anggota'));
    }
    
    public function downloadKartu(Anggota $anggota) {
        $type = 'kartu';
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.anggota.kartu-sertifikat', compact('anggota', 'type'));
        $pdf->setPaper([0, 0, 242.65, 153], 'landscape'); // 85.6mm x 53.98mm in points
        
        $filename = 'Kartu_Anggota_' . str_replace(' ', '_', $anggota->nama) . '.pdf';
        return $pdf->download($filename);
    }
    
    public function downloadSertifikat(Anggota $anggota) {
        $type = 'sertifikat';
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.anggota.kartu-sertifikat', compact('anggota', 'type'));
        $pdf->setPaper('a4', 'portrait'); // A4 Portrait untuk sertifikat 1 halaman
        
        $filename = 'Sertifikat_' . str_replace(' ', '_', $anggota->nama) . '.pdf';
        return $pdf->download($filename);
    }

    public function updateStatus(Request $request, Anggota $anggota) {
        $statusLama = $anggota->status;
        
        // Validasi input
        $request->validate([
            'status' => 'required|in:Aktif,Ditolak',
            'catatan_verifikasi' => 'nullable|string|max:500'
        ]);
        
        // Jika DITOLAK - TIDAK HAPUS akun, hanya update status
        if ($request->status === 'Ditolak') {
            $alasanPenolakan = $request->catatan_verifikasi ?? 'Data tidak sesuai persyaratan';
            
            // Update status anggota menjadi Ditolak (AKUN TETAP ADA)
            $anggota->update([
                'status' => 'Ditolak',
                'catatan_admin' => $alasanPenolakan,
                'tanggal_verifikasi' => now()
            ]);
            
            // Kirim notifikasi ke user - TIDAK LULUS (dengan link ke lengkapi data)
            if ($anggota->user_id) {
                \App\Models\Notifikasi::create([
                    'user_id' => $anggota->user_id,
                    'judul'   => '❌ Pendaftaran Tidak Disetujui',
                    'pesan'   => 'Mohon maaf, pendaftaran Anda belum dapat disetujui. Alasan: ' . $alasanPenolakan . '. Klik tombol "Lengkapi Data" di bawah untuk memperbaiki data Anda dan submit ulang.',
                    'tipe'    => 'warning',
                    'link'    => route('anggota.lengkapi-data'),
                    'is_read' => false,
                ]);
            }
            
            return redirect()->route('admin.anggota.verifikasi')->with('success', 'Pendaftaran ditolak. Notifikasi telah dikirim ke anggota. Anggota dapat melengkapi data dan submit ulang.');
        }
        
        // Jika DITERIMA - Update status menjadi Aktif (LULUS)
        if ($request->status === 'Aktif') {
            $catatan = $request->catatan_verifikasi ?? 'Selamat! Pendaftaran Anda telah disetujui.';
            
            $anggota->update([
                'status' => 'Aktif',
                'catatan_admin' => $catatan,
                'tanggal_verifikasi' => now(),
                'tanggal_bergabung' => now(), // Set tanggal bergabung saat disetujui
            ]);
            
            // Kirim notifikasi ke user - LULUS
            if ($anggota->user_id) {
                $pesan = '🎉 Selamat! Pendaftaran Anda LULUS sebagai Anggota Koperasi. No. Anggota: ' . $anggota->no_anggota . '. Anda sekarang dapat mengakses semua layanan koperasi. Silakan cek kartu anggota Anda di dashboard.';
                
                \App\Models\Notifikasi::create([
                    'user_id' => $anggota->user_id,
                    'judul'   => '✅ Selamat! Pendaftaran Lulus',
                    'pesan'   => $pesan,
                    'tipe'    => 'success',
                    'link'    => route('anggota.dashboard'),
                    'is_read' => false,
                ]);
            }
            
            return redirect()->route('admin.anggota.verifikasi')->with('success', 'Pendaftaran DISETUJUI! Notifikasi telah dikirim ke anggota dengan No. Anggota: ' . $anggota->no_anggota);
        }
        
        return redirect()->route('admin.anggota.verifikasi')->with('error', 'Status tidak valid.');
    }


    public function dokumen(Request $request) {
        try {
            $q = Anggota::with('koperasi');
            
            // Filter pencarian
            if ($request->search) {
                $q->where(function($query) use ($request) {
                    $query->where('nama','like',"%{$request->search}%")
                          ->orWhere('no_anggota','like',"%{$request->search}%")
                          ->orWhere('nik','like',"%{$request->search}%");
                });
            }
            
            // Filter status dokumen
            if ($request->status) {
                if ($request->status == 'lengkap') {
                    $q->whereNotNull('foto_ktp')
                      ->whereNotNull('foto_kk')
                      ->whereNotNull('foto');
                } elseif ($request->status == 'tidak_lengkap') {
                    $q->whereNull('foto_ktp')
                      ->whereNull('foto_kk')
                      ->whereNull('foto');
                } elseif ($request->status == 'sebagian') {
                    $q->where(function($query) {
                        $query->whereNotNull('foto_ktp')
                              ->orWhereNotNull('foto_kk')
                              ->orWhereNotNull('foto');
                    })->where(function($query) {
                        $query->whereNull('foto_ktp')
                              ->orWhereNull('foto_kk')
                              ->orWhereNull('foto');
                    });
                }
            }
            
            $anggota = $q->orderBy('created_at','desc')->paginate(15)->withQueryString();
            
            // Statistik
            $totalAnggota = Anggota::count();
            $dokumenLengkap = Anggota::whereNotNull('foto_ktp')
                ->whereNotNull('foto_kk')
                ->whereNotNull('foto')
                ->count();
            $dokumenTidakLengkap = Anggota::whereNull('foto_ktp')
                ->whereNull('foto_kk')
                ->whereNull('foto')
                ->count();
            $dokumenSebagian = $totalAnggota - $dokumenLengkap - $dokumenTidakLengkap;
            
            return view('admin.anggota.dokumen', compact(
                'anggota', 
                'totalAnggota', 
                'dokumenLengkap', 
                'dokumenTidakLengkap', 
                'dokumenSebagian'
            ));
        } catch (\Exception $e) {
            \Log::error('Error di dokumen(): ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function verifikasi(Request $request) {
        $q = Anggota::query();
        
        // VERIFIKASI PENDAFTARAN = Hanya pendaftaran BARU yang BELUM PERNAH DIVERIFIKASI
        // Kriteria: tanggal_bergabung NULL (belum pernah disetujui)
        // Status: Pending atau Ditolak
        
        $q->whereNull('tanggal_bergabung')
          ->whereIn('status', ['Pending', 'Ditolak']);
        
        if ($request->search) {
            $q->where(function($query) use ($request) {
                $query->where('nama','like',"%{$request->search}%")
                      ->orWhere('no_anggota','like',"%{$request->search}%");
            });
        }
        
        if ($request->status) {
            $q->where('status', $request->status);
        }
        
        $anggota = $q->orderBy('created_at','desc')->paginate(12)->withQueryString();
        
        $stats = [
            'total'   => Anggota::whereNull('tanggal_bergabung')->count(),
            'pending' => Anggota::whereNull('tanggal_bergabung')->where('status','Pending')->count(),
            'ditolak' => Anggota::whereNull('tanggal_bergabung')->where('status','Ditolak')->count(),
            'aktif'   => Anggota::whereNotNull('tanggal_bergabung')->where('status','Aktif')->count(),
        ];
        
        return view('admin.anggota.verifikasi', compact('anggota', 'stats'));
    }
    
    public function print(Anggota $anggota, Request $request) {
        $type = $request->get('type', 'kartu');
        $judul = 'Kartu Anggota';
        $subJudul = $anggota->no_anggota;
        return view('admin.anggota.partials.Print', compact('anggota','type','judul','subJudul'));
    }
    
    public function kartuSertifikatList(Request $request) {
        try {
            // Query anggota dengan filter
            $query = Anggota::with('koperasi');
            
            // Filter pencarian
            if ($request->filled('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('nama','like',"%{$request->search}%")
                      ->orWhere('no_anggota','like',"%{$request->search}%")
                      ->orWhere('nik','like',"%{$request->search}%");
                });
            }
            
            // Filter status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            // Filter distrik
            if ($request->filled('distrik')) {
                $query->where('distrik', $request->distrik);
            }
            
            // Urutkan berdasarkan terbaru
            $anggota = $query->orderBy('created_at','desc')->paginate(12)->withQueryString();
            
            // Daftar distrik untuk filter
            $distrik = Anggota::distinct()->pluck('distrik')->filter()->sort()->values();
            
            // Statistik
            $stats = [
                'total' => Anggota::count(),
                'aktif' => Anggota::where('status', 'Aktif')->count(),
                'pending' => Anggota::where('status', 'Pending')->count(),
            ];
            
            return view('admin.anggota.kartu-sertifikat-list', compact('anggota', 'distrik', 'stats'));
        } catch (\Exception $e) {
            \Log::error('Error in kartuSertifikatList: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    // Export methods untuk Data Anggota Koperasi
    public function exportPdf(Request $request) {
        // Delegate to LaporanController with type=anggota
        return app(\App\Http\Controllers\Admin\LaporanController::class)->exportPdf(
            $request->merge(['type' => 'anggota'])
        );
    }
    
    public function exportWord(Request $request) {
        // Delegate to LaporanController with type=anggota
        return app(\App\Http\Controllers\Admin\LaporanController::class)->exportWord(
            $request->merge(['type' => 'anggota'])
        );
    }
    
    public function exportExcel(Request $request) {
        // Delegate to LaporanController with type=anggota
        return app(\App\Http\Controllers\Admin\LaporanController::class)->exportExcel(
            $request->merge(['type' => 'anggota'])
        );
    }
}
