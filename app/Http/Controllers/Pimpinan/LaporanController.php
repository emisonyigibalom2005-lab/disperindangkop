<?php
namespace App\Http\Controllers\Pimpinan;
use App\Http\Controllers\Controller;
use App\Models\Bantuan;
use App\Models\PenerimaBantuan;
use App\Models\Koperasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index() {
        // Check permission
        if (!can_view('laporan')) {
            return redirect()->route('pimpinan.dashboard')
                ->with('error', 'Anda tidak memiliki izin untuk mengakses Laporan. Silakan hubungi Admin untuk mendapatkan akses.');
        }
        
        $stats = ['total_koperasi'=>Koperasi::count(),'koperasi_verified'=>Koperasi::where('status_verifikasi','diverifikasi')->count(),'total_bantuan'=>Bantuan::count(),'penerima_bantuan'=>PenerimaBantuan::where('status','diterima')->count()];
        return view('pimpinan.laporan.index', compact('stats'));
    }
    
    public function koperasi(Request $request) {
        // Check permission
        if (!can_view('laporan')) {
            return redirect()->route('pimpinan.dashboard')
                ->with('error', 'Anda tidak memiliki izin untuk mengakses Laporan Pendaftaran Anggota.');
        }
        
        $query = \App\Models\Anggota::with(['koperasi', 'user']);
        
        // Apply filters
        if ($request->filled('distrik')) {
            $query->where('distrik', $request->distrik);
        }
        if ($request->filled('koperasi_id')) {
            $query->where('koperasi_id', $request->koperasi_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('periode')) {
            $query->where('periode_pendaftaran_id', $request->periode);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%')
                  ->orWhere('no_anggota', 'like', '%' . $search . '%');
            });
        }

        // Variable $koperasi berisi data anggota (untuk konsistensi dengan view)
        $koperasi = $query->latest()->get();

        $koperasiPerDistrik = \App\Models\Anggota::select('distrik', \Illuminate\Support\Facades\DB::raw('COUNT(*) as total'))
            ->groupBy('distrik')->orderByDesc('total')->get();

        $koperasiPerKategori = \App\Models\Anggota::select('status', \Illuminate\Support\Facades\DB::raw('COUNT(*) as total'))
            ->groupBy('status')->get();

        return view('pimpinan.laporan.koperasi_anggota', compact(
            'koperasi',
            'koperasiPerDistrik',
            'koperasiPerKategori'
        ));
    }
    
    public function bantuan(Request $request) {
        // Check permission
        if (!can_view('laporan')) {
            return redirect()->route('pimpinan.dashboard')
                ->with('error', 'Anda tidak memiliki izin untuk mengakses Laporan Bantuan.');
        }
        
        $query = Bantuan::with('penerima.koperasi')->withCount('penerima as jumlah_penerima');

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bantuan = $query->latest()->paginate(20)->appends($request->query());

        $bantuanPerTahun = PenerimaBantuan::join('bantuan', 'penerima_bantuan.bantuan_id', '=', 'bantuan.id')
            ->select('bantuan.tahun', \Illuminate\Support\Facades\DB::raw('COUNT(*) as total'), \Illuminate\Support\Facades\DB::raw('SUM(penerima_bantuan.jumlah_bantuan) as total_nilai'))
            ->where('penerima_bantuan.status', 'diterima')
            ->groupBy('bantuan.tahun')
            ->orderBy('bantuan.tahun')
            ->get();

        return view('pimpinan.laporan.bantuan', compact('bantuan', 'bantuanPerTahun'));
    }
    
    public function bantuanCreate() {
        // Check permission
        if (!can_create('laporan')) {
            return redirect()->route('pimpinan.laporan.bantuan')
                ->with('error', 'Anda tidak memiliki izin untuk menambah Program Bantuan. Silakan hubungi Admin untuk mendapatkan akses.');
        }
        
        return view('pimpinan.laporan.bantuan-create');
    }
    
    public function bantuanStore(Request $request) {
        // Check permission
        if (!can_create('laporan')) {
            return redirect()->route('pimpinan.laporan.bantuan')
                ->with('error', 'Anda tidak memiliki izin untuk menambah Program Bantuan.');
        }
        
        $validated = $request->validate([
            'kode_bantuan' => 'required|string|max:50|unique:bantuans,kode_bantuan',
            'nama_bantuan' => 'required|string|max:255',
            'jenis_bantuan' => 'required|in:uang,barang,pelatihan',
            'tahun' => 'required|integer|min:2020|max:2100',
            'anggaran' => 'required|numeric|min:0',
            'kuota' => 'required|integer|min:1',
            'status' => 'required|in:aktif,nonaktif,selesai',
            'deskripsi' => 'nullable|string',
            'satuan' => 'nullable|string|max:50',
        ]);
        
        $validated['jumlah_penerima'] = 0;
        $validated['created_by'] = auth()->id();
        
        Bantuan::create($validated);
        
        return redirect()->route('pimpinan.laporan.bantuan')
            ->with('success', 'Program bantuan berhasil ditambahkan.');
    }
    
    public function bantuanEdit($id) {
        // Check permission
        if (!can_edit('laporan')) {
            return redirect()->route('pimpinan.laporan.bantuan')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit Program Bantuan. Silakan hubungi Admin untuk mendapatkan akses.');
        }
        
        $bantuan = Bantuan::findOrFail($id);
        
        return view('pimpinan.laporan.bantuan-edit', compact('bantuan'));
    }
    
    public function bantuanUpdate(Request $request, $id) {
        // Check permission
        if (!can_edit('laporan')) {
            return redirect()->route('pimpinan.laporan.bantuan')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit Program Bantuan.');
        }
        
        $bantuan = Bantuan::findOrFail($id);
        
        $validated = $request->validate([
            'kode_bantuan' => 'required|string|max:50|unique:bantuans,kode_bantuan,' . $id,
            'nama_bantuan' => 'required|string|max:255',
            'jenis_bantuan' => 'required|in:uang,barang,pelatihan',
            'tahun' => 'required|integer|min:2020|max:2100',
            'anggaran' => 'required|numeric|min:0',
            'kuota' => 'required|integer|min:1',
            'status' => 'required|in:aktif,nonaktif,selesai',
            'deskripsi' => 'nullable|string',
            'satuan' => 'nullable|string|max:50',
        ]);
        
        $bantuan->update($validated);
        
        return redirect()->route('pimpinan.laporan.bantuan')
            ->with('success', 'Program bantuan berhasil diperbarui.');
    }
    
    public function bantuanDetail($id) {
        // Check permission
        if (!can_view('laporan')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk melihat detail bantuan.'
            ], 403);
        }
        
        try {
            $bantuan = Bantuan::with('penerima.koperasi')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $bantuan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }
    
    public function bantuanDelete($id) {
        // Check permission
        if (!can_delete('laporan')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk menghapus data bantuan.'
            ], 403);
        }
        
        try {
            $bantuan = Bantuan::findOrFail($id);
            
            // Check if bantuan has penerima
            if ($bantuan->penerima()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Program bantuan tidak dapat dihapus karena sudah memiliki penerima.'
                ], 400);
            }
            
            $bantuan->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Program bantuan berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function anggota(Request $request) {
        // Check permission
        if (!can_view('laporan')) {
            return redirect()->route('pimpinan.dashboard')
                ->with('error', 'Anda tidak memiliki izin untuk mengakses Laporan Anggota.');
        }
        
        $query = \App\Models\Anggota::with(['koperasi']);
        
        // Apply filters
        if ($request->filled('distrik')) $query->where('distrik', $request->distrik);
        if ($request->filled('koperasi_id')) $query->where('koperasi_id', $request->koperasi_id);
        if ($request->filled('status')) $query->where('status', $request->status);
        
        $anggota = $query->latest()->get();
        
        // Stats berdasarkan filter
        $stats = [
            'total' => $anggota->count(),
            'aktif' => $anggota->where('status', 'Aktif')->count(),
            'pending' => $anggota->where('status', 'Pending')->count(),
            'nonaktif' => $anggota->where('status', 'Nonaktif')->count(),
        ];
        
        $distrikList = ['Karubaga', 'Bokondini', 'Kanggime', 'Kembu', 'Kondaga', 'Wunim', 'Wari', 'Wina', 'Wugi', 'Wulik', 'Dow', 'Dundu', 'Egiam', 'Gearek', 'Geya', 'Gilubandu', 'Goyage', 'Gundagi', 'Kai', 'Kamboneri', 'Kuari', 'Kubu', 'Kumbiagama', 'Kumo', 'Nabunage', 'Nelawi', 'Numba', 'Nunggawi', 'Panaga', 'Poganeri', 'Tagime', 'Tagineri', 'Telenggeme', 'Timori', 'Umagi', 'Wakuwo', 'Wenam', 'Wollo', 'Yuko', 'Yuneri'];
        
        $koperasiList = Koperasi::where('status_verifikasi', 'diverifikasi')
            ->where('status_usaha', 'aktif')
            ->orderBy('nama_usaha')
            ->get();
        
        return view('pimpinan.laporan.anggota', compact('anggota', 'stats', 'distrikList', 'koperasiList'));
    }
    
    public function anggotaDetail($id) {
        // Check permission
        if (!can_view('laporan')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk melihat detail laporan.'
            ], 403);
        }
        
        try {
            $anggota = \App\Models\Anggota::with('koperasi')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $anggota->id,
                    'no_anggota' => $anggota->no_anggota,
                    'nama_lengkap' => $anggota->nama ?? $anggota->nama_lengkap ?? '-',
                    'nik' => $anggota->nik,
                    'tempat_lahir' => $anggota->tempat_lahir,
                    'tanggal_lahir' => $anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d M Y') : '-',
                    'jenis_kelamin' => $anggota->jenis_kelamin,
                    'no_hp' => $anggota->no_hp,
                    'email' => $anggota->email ?? '-',
                    'distrik' => $anggota->distrik,
                    'alamat' => $anggota->alamat_lengkap ?? $anggota->alamat ?? '-',
                    'koperasi_nama' => $anggota->koperasi->nama_usaha ?? '-',
                    'simpanan_pokok' => $anggota->simpanan_pokok ?? 0,
                    'simpanan_wajib' => $anggota->simpanan_wajib ?? 0,
                    'status' => $anggota->status,
                    'tanggal_bergabung' => $anggota->tanggal_bergabung ? \Carbon\Carbon::parse($anggota->tanggal_bergabung)->format('d M Y') : '-',
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }
    
    public function exportAnggotaWord(Request $request) {
        // Check permission
        if (!can_export('laporan')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengekspor laporan.');
        }
        
        // Implementation similar to koperasi export
        return redirect()->back()->with('info', 'Fitur export Word sedang dalam pengembangan.');
    }
    
    public function exportAnggotaExcel(Request $request) {
        // Check permission
        if (!can_export('laporan')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengekspor laporan.');
        }
        
        // Implementation similar to koperasi export
        return redirect()->back()->with('info', 'Fitur export Excel sedang dalam pengembangan.');
    }
    
    public function koperasiDetail($id) {
        // Check permission
        if (!can_view('laporan')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk melihat detail laporan.'
            ], 403);
        }
        
        try {
            $anggota = \App\Models\Anggota::with('koperasi')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $anggota->id,
                    'no_anggota' => $anggota->no_anggota,
                    'nama_lengkap' => $anggota->nama ?? $anggota->nama_lengkap ?? '-',
                    'nik' => $anggota->nik,
                    'tempat_lahir' => $anggota->tempat_lahir ?? '-',
                    'tanggal_lahir' => $anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d M Y') : '-',
                    'jenis_kelamin' => $anggota->jenis_kelamin ?? '-',
                    'status_perkawinan' => $anggota->status_perkawinan ?? '-',
                    'pendidikan_terakhir' => $anggota->pendidikan_terakhir ?? '-',
                    'agama' => $anggota->agama ?? '-',
                    'no_hp' => $anggota->no_hp ?? '-',
                    'email' => $anggota->email ?? '-',
                    'distrik' => $anggota->distrik ?? '-',
                    'alamat' => $anggota->alamat_lengkap ?? $anggota->alamat ?? '-',
                    'koperasi_nama' => $anggota->koperasi->nama_usaha ?? '-',
                    'nama_usaha' => $anggota->nama_usaha ?? '-',
                    'bidang_usaha' => $anggota->bidang_usaha ?? '-',
                    'simpanan_pokok' => $anggota->simpanan_pokok ?? 0,
                    'simpanan_wajib' => $anggota->simpanan_wajib ?? 0,
                    'status' => $anggota->status ?? '-',
                    'tanggal_bergabung' => $anggota->tanggal_bergabung ? \Carbon\Carbon::parse($anggota->tanggal_bergabung)->format('d M Y') : '-',
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }
    
    public function exportKoperasiWord(Request $request) {
        try {
            // Check permission
            if (!can_export('laporan')) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengekspor laporan.');
            }
            
            // Apply filters - SAMA DENGAN ADMIN
            $query = \App\Models\Anggota::with('user');
            
            if ($request->filled('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('nama','like',"%{$request->search}%")
                      ->orWhere('no_anggota','like',"%{$request->search}%")
                      ->orWhere('nik','like',"%{$request->search}%");
                });
            }
            if ($request->filled('distrik')) {
                $query->where('distrik', $request->distrik);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('periode')) {
                $query->where('periode_pendaftaran_id', $request->periode);
            }
            
            $data = $query->latest()->get();
            
            // Check if data exists
            if ($data->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data untuk diekspor.');
            }

            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $phpWord->setDefaultFontName('Arial');
            $phpWord->setDefaultFontSize(11);

            // ── Halaman landscape A4 ──────────────────────────────
            $section = $phpWord->addSection([
                'orientation' => 'landscape',
                'pageSizeW' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(29.7),
                'pageSizeH' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(21),
                'marginTop' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
                'marginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
                'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
                'marginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
            ]);

            // ── Kop surat ─────────────────────────────────────────
            $logoPath = public_path('images/logo-tolikara.png');
            if (file_exists($logoPath)) {
                $section->addImage($logoPath, [
                    'width' => 70, 'height' => 70,
                    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                    'wrappingStyle' => 'inline',
                ]);
            }
            
            $section->addText(
                'PEMERINTAH KABUPATEN TOLIKARA',
                ['bold' => true, 'size' => 14, 'color' => '1a1a1a'],
                ['alignment' => 'center', 'spaceAfter' => 0]
            );
            $section->addText(
                'DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI',
                ['bold' => true, 'size' => 14, 'color' => '1a1a1a'],
                ['alignment' => 'center', 'spaceAfter' => 100]
            );
            $section->addText(
                'Jl. Raya Karubaga, Kab. Tolikara, Papua Pegunungan | Telp. (0964) 123456',
                ['size' => 10, 'color' => '333333'],
                ['alignment' => 'center', 'spaceAfter' => 150]
            );

            // Garis pemisah kop
            $section->addText('', [], [
                'borderBottomSize' => 12,
                'borderBottomColor' => '000000',
                'spaceAfter' => 150
            ]);
            
            $section->addTextBreak(1);

            $section->addText(
                'LAPORAN DATA ANGGOTA KOPERASI',
                ['bold' => true, 'size' => 16, 'color' => '1a1a1a'],
                ['alignment' => 'center', 'spaceAfter' => 0]
            );
            
            // Garis bawah judul
            $section->addText('', [], [
                'borderBottomSize' => 12,
                'borderBottomColor' => '000000',
                'spaceAfter' => 100]
            );
            
            $section->addText(
                'Per Tanggal: ' . date('d F Y'),
                ['size' => 10, 'italic' => true, 'color' => '666666'],
                ['alignment' => 'center', 'spaceAfter' => 50]
            );
            
            // Filter info
            $filterInfo = [];
            if ($request->filled('distrik')) $filterInfo[] = 'Distrik: ' . $request->distrik;
            if ($request->filled('status')) $filterInfo[] = 'Status: ' . ucfirst($request->status);
            if ($request->filled('periode')) {
                $periode = \App\Models\PeriodePendaftaran::find($request->periode);
                if ($periode) $filterInfo[] = 'Periode: ' . $periode->nama_periode;
            }
            
            if (!empty($filterInfo)) {
                $section->addText(
                    'Filter: ' . implode(' | ', $filterInfo),
                    ['size' => 9, 'italic' => true, 'color' => '666666'],
                    ['alignment' => 'center']
                );
            }
            
            $section->addTextBreak(1);

            // Tabel Anggota dengan 17 kolom penting
            $table = $section->addTable([
                'borderSize' => 6,
                'borderColor' => '000000',
                'cellMargin' => 50,
                'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
            ]);

            // Style header tabel
            $hFont = ['bold' => true, 'color' => 'FFFFFF', 'size' => 8];
            $hCell = ['bgColor' => '1f2937', 'valign' => 'center', 'borderSize' => 6, 'borderColor' => '111827'];

            // Header dengan 17 kolom
            $table->addRow(350);
            $table->addCell(250, $hCell)->addText('No', $hFont, ['alignment' => 'center']);
            $table->addCell(600, $hCell)->addText('No. Anggota', $hFont);
            $table->addCell(800, $hCell)->addText('NIK', $hFont);
            $table->addCell(1000, $hCell)->addText('Nama Lengkap', $hFont);
            $table->addCell(900, $hCell)->addText('Tempat, Tgl Lahir', $hFont);
            $table->addCell(250, $hCell)->addText('JK', $hFont);
            $table->addCell(600, $hCell)->addText('No. HP', $hFont);
            $table->addCell(1000, $hCell)->addText('Alamat', $hFont);
            $table->addCell(600, $hCell)->addText('Distrik', $hFont);
            $table->addCell(1000, $hCell)->addText('Nama Usaha', $hFont);
            $table->addCell(800, $hCell)->addText('Bidang Usaha', $hFont);
            $table->addCell(800, $hCell)->addText('Modal Usaha', $hFont);
            $table->addCell(500, $hCell)->addText('Bank', $hFont);
            $table->addCell(700, $hCell)->addText('No. Rekening', $hFont);
            $table->addCell(800, $hCell)->addText('Total Simpanan', $hFont);
            $table->addCell(450, $hCell)->addText('Status', $hFont);
            $table->addCell(500, $hCell)->addText('Tgl Daftar', $hFont);

            // Isi baris
            foreach ($data as $i => $k) {
                $rowBg = $i % 2 === 0 ? 'f9fafb' : 'ffffff';
                $cellStyle = ['bgColor' => $rowBg, 'valign' => 'center', 'borderSize' => 4, 'borderColor' => 'd1d5db'];
                $textFont = ['size' => 8];
                $textFontBold = ['size' => 8, 'bold' => true];
                
                $table->addRow();
                $table->addCell(250, $cellStyle)->addText($i + 1, $textFontBold, ['alignment' => 'center']);
                $table->addCell(600, $cellStyle)->addText($k->no_anggota ?? '-', $textFont);
                $table->addCell(800, $cellStyle)->addText($k->nik ?? '-', $textFont);
                $table->addCell(1000, $cellStyle)->addText($k->nama ?? '-', $textFontBold);
                $table->addCell(900, $cellStyle)->addText(($k->tempat_lahir ?? '-') . ', ' . ($k->tanggal_lahir ? $k->tanggal_lahir->format('d/m/Y') : '-'), $textFont);
                $table->addCell(250, $cellStyle)->addText($k->jenis_kelamin == 'L' ? 'L' : 'P', $textFont, ['alignment' => 'center']);
                $table->addCell(600, $cellStyle)->addText($k->no_hp ?? '-', $textFont);
                $table->addCell(1000, $cellStyle)->addText(($k->alamat_lengkap ?? '-') . ', ' . ($k->desa ?? ''), $textFont);
                $table->addCell(600, $cellStyle)->addText($k->distrik ?? '-', $textFont);
                $table->addCell(1000, $cellStyle)->addText($k->nama_usaha ?? '-', $textFontBold);
                $table->addCell(800, $cellStyle)->addText($k->bidang_usaha ?? '-', $textFont);
                $table->addCell(800, $cellStyle)->addText('Rp ' . number_format($k->modal_usaha ?? 0, 0, ',', '.'), $textFont, ['alignment' => 'right']);
                $table->addCell(500, $cellStyle)->addText($k->nama_bank ?? '-', $textFont);
                $table->addCell(700, $cellStyle)->addText($k->nomor_rekening ?? '-', $textFont);
                $table->addCell(800, $cellStyle)->addText('Rp ' . number_format($k->total_simpanan ?? 0, 0, ',', '.'), $textFont, ['alignment' => 'right']);
                $table->addCell(450, $cellStyle)->addText(ucfirst($k->status ?? '-'), $textFontBold, ['alignment' => 'center']);
                $table->addCell(500, $cellStyle)->addText($k->created_at ? $k->created_at->format('d/m/Y') : '-', $textFont, ['alignment' => 'center']);
            }

            // Ringkasan
            $section->addTextBreak(1);
            
            $summaryTable = $section->addTable([
                'borderSize' => 12,
                'borderColor' => '000000',
                'cellMargin' => 150,
                'width' => 100 * 50,
                'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
            ]);
            
            $summaryTable->addRow();
            $summaryTable->addCell(null, ['bgColor' => 'f3f4f6', 'borderSize' => 12, 'borderColor' => '000000'])
                ->addText(
                    'TOTAL ANGGOTA KOPERASI: ' . $data->count() . ' ORANG',
                    ['size' => 12, 'bold' => true, 'color' => '1a1a1a'],
                    ['alignment' => 'center']
                );
            
            // Signature
            $section->addTextBreak(2);
            $section->addText(
                'Tolikara, ' . date('d F Y'),
                ['size' => 10],
                ['alignment' => 'right']
            );
            $section->addText(
                'Kepala Dinas,',
                ['size' => 10, 'bold' => true],
                ['alignment' => 'right', 'spaceAfter' => 800]
            );
            $section->addText(
                'Wugi Kogoya, S.P',
                ['size' => 10, 'bold' => true],
                ['alignment' => 'right']
            );
            $section->addText(
                'NIP. 123456150890001',
                ['size' => 9],
                ['alignment' => 'right']
            );

            // Generate filename
            $filename = 'Rekap-Anggota-Koperasi-' . date('d-M-Y') . '.docx';
            
            // Save ke temporary file
            $temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($temp_file);
            
            \Log::info('Export Word success - File: ' . $filename);
            
            // Download
            return response()->download($temp_file, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ])->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            \Log::error('Export Word Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Gagal membuat dokumen Word: ' . $e->getMessage());
        }
    }
    
    public function exportKoperasiExcel(Request $request) {
        try {
            // Check permission
            if (!can_export('laporan')) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengekspor laporan.');
            }
            
            // Apply filters - SAMA DENGAN ADMIN
            $query = \App\Models\Anggota::with('user');
            
            if ($request->filled('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('nama','like',"%{$request->search}%")
                      ->orWhere('no_anggota','like',"%{$request->search}%")
                      ->orWhere('nik','like',"%{$request->search}%");
                });
            }
            if ($request->filled('distrik')) {
                $query->where('distrik', $request->distrik);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('periode')) {
                $query->where('periode_pendaftaran_id', $request->periode);
            }
            
            $data = $query->latest()->get();
            
            // Check if data exists
            if ($data->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data untuk diekspor.');
            }
            
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set document properties
            $spreadsheet->getProperties()
                ->setCreator('Dinas Perindustrian Tolikara')
                ->setTitle('Laporan Data Anggota Koperasi')
                ->setSubject('Data Anggota Koperasi')
                ->setDescription('Laporan data anggota koperasi Kabupaten Tolikara');
            
            // HEADER - Kop Surat
            $sheet->mergeCells('A1:Q1');
            $sheet->setCellValue('A1', 'PEMERINTAH KABUPATEN TOLIKARA');
            $sheet->getStyle('A1')->applyFromArray([
                'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '1a1a1a']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ]);
            
            $sheet->mergeCells('A2:Q2');
            $sheet->setCellValue('A2', 'DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI');
            $sheet->getStyle('A2')->applyFromArray([
                'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '1a1a1a']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ]);
            
            $sheet->mergeCells('A3:Q3');
            $sheet->setCellValue('A3', 'Jl. Raya Karubaga, Kab. Tolikara, Papua Pegunungan | Telp. (0964) 123456');
            $sheet->getStyle('A3')->applyFromArray([
                'font' => ['size' => 10, 'color' => ['rgb' => '666666']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ]);
            
            // Garis pemisah
            $sheet->mergeCells('A4:Q4');
            $sheet->getStyle('A4')->applyFromArray([
                'borders' => [
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK, 'color' => ['rgb' => '000000']]
                ]
            ]);
            
            // Judul Laporan
            $sheet->mergeCells('A6:Q6');
            $sheet->setCellValue('A6', 'LAPORAN DATA ANGGOTA KOPERASI');
            $sheet->getStyle('A6')->applyFromArray([
                'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1a1a1a']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                'borders' => [
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK, 'color' => ['rgb' => '000000']]
                ]
            ]);
            
            $sheet->mergeCells('A7:Q7');
            $sheet->setCellValue('A7', 'Per Tanggal: ' . date('d F Y'));
            $sheet->getStyle('A7')->applyFromArray([
                'font' => ['italic' => true, 'size' => 10, 'color' => ['rgb' => '666666']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ]);
            
            // Header Tabel (Baris 9) - 17 kolom penting
            $headers = [
                'No', 'No. Anggota', 'NIK', 'Nama Lengkap', 'Tempat, Tgl Lahir', 'JK', 'No. HP', 'Alamat',
                'Distrik', 'Nama Usaha', 'Bidang Usaha', 'Modal Usaha (Rp)', 'Bank', 'No. Rekening',
                'Total Simpanan (Rp)', 'Status', 'Tanggal Daftar'
            ];
            
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '9', $header);
                $col++;
            }
            
            // Style header tabel dengan warna hijau
            $sheet->getStyle('A9:Q9')->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK, 'color' => ['rgb' => '000000']]]
            ]);
            
            // Data
            $row = 10;
            foreach ($data as $i => $k) {
                $bgColor = $i % 2 === 0 ? 'f0fdf4' : 'FFFFFF';
                
                $sheet->setCellValue('A' . $row, $i + 1);
                $sheet->setCellValue('B' . $row, $k->no_anggota);
                $sheet->setCellValue('C' . $row, $k->nik);
                $sheet->setCellValue('D' . $row, $k->nama);
                $sheet->setCellValue('E' . $row, $k->tempat_lahir . ', ' . $k->tanggal_lahir->format('d/m/Y'));
                $sheet->setCellValue('F' . $row, $k->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan');
                $sheet->setCellValue('G' . $row, $k->no_hp);
                $sheet->setCellValue('H' . $row, ($k->alamat_lengkap ?? '-') . ', ' . ($k->desa ?? ''));
                $sheet->setCellValue('I' . $row, $k->distrik);
                $sheet->setCellValue('J' . $row, $k->nama_usaha);
                $sheet->setCellValue('K' . $row, $k->bidang_usaha);
                $sheet->setCellValue('L' . $row, $k->modal_usaha ?? 0);
                $sheet->setCellValue('M' . $row, $k->nama_bank ?? '-');
                $sheet->setCellValue('N' . $row, $k->nomor_rekening ?? '-');
                $sheet->setCellValue('O' . $row, $k->total_simpanan ?? 0);
                $sheet->setCellValue('P' . $row, $k->status);
                $sheet->setCellValue('Q' . $row, $k->created_at->format('d/m/Y'));
                
                // Style baris data
                $sheet->getStyle('A' . $row . ':Q' . $row)->applyFromArray([
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                    'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
                    'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]
                ]);
                
                // Format angka untuk currency
                $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle('O' . $row)->getNumberFormat()->setFormatCode('#,##0');
                
                // Bold untuk nama
                $sheet->getStyle('D' . $row)->getFont()->setBold(true);
                $sheet->getStyle('J' . $row)->getFont()->setBold(true);
                
                $row++;
            }
            
            // Ringkasan
            $row++;
            $sheet->mergeCells('A' . $row . ':Q' . $row);
            $sheet->setCellValue('A' . $row, 'TOTAL ANGGOTA KOPERASI: ' . $data->count() . ' ORANG');
            $sheet->getStyle('A' . $row)->applyFromArray([
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '1a1a1a']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'd1fae5']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK, 'color' => ['rgb' => '10b981']]]
            ]);
            
            // Auto size columns
            foreach (range('A', 'Q') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Set row heights
            $sheet->getRowDimension(1)->setRowHeight(25);
            $sheet->getRowDimension(2)->setRowHeight(25);
            $sheet->getRowDimension(6)->setRowHeight(30);
            $sheet->getRowDimension(9)->setRowHeight(30);
            
            // Freeze pane
            $sheet->freezePane('A10');
            
            // Save file
            $filename = 'laporan-anggota-koperasi-' . date('Ymd') . '.xlsx';
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output');
            exit;
            
        } catch (\Exception $e) {
            \Log::error('Export Excel Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Gagal membuat file Excel: ' . $e->getMessage());
        }
    }
    
    public function exportKoperasiPdf(Request $request) {
        try {
            // Check permission
            if (!can_export('laporan')) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengekspor laporan.');
            }
            
            // Apply filters for anggota
            $query = \App\Models\Anggota::with('user');
            
            if ($request->filled('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('nama','like',"%{$request->search}%")
                      ->orWhere('no_anggota','like',"%{$request->search}%")
                      ->orWhere('nik','like',"%{$request->search}%");
                });
            }
            if ($request->filled('distrik')) {
                $query->where('distrik', $request->distrik);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('periode')) {
                $query->where('periode_pendaftaran_id', $request->periode);
            }
            
            $data = $query->latest()->get();
            
            // Check if data exists
            if ($data->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data anggota untuk diekspor.');
            }
            
            try {
                $pdf = Pdf::loadView('pimpinan.laporan.pdf.anggota', [
                    'data' => $data,
                    'filters' => $request->all()
                ]);
                
                $pdf->setPaper('a4', 'landscape');
                
                return $pdf->download('laporan-anggota-koperasi-' . date('Ymd') . '.pdf');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error generating PDF: ' . $e->getMessage());
            }
            
        } catch (\Exception $e) {
            \Log::error('Export PDF Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Gagal membuat file PDF: ' . $e->getMessage());
        }
    }
    
    // ══════════════════════════════════════════════════════════
    // GENERIC EXPORT METHODS (for bantuan and other reports)
    // ══════════════════════════════════════════════════════════
    
    public function exportWord(Request $request) {
        // Check permission
        if (!can_export('laporan')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengekspor laporan.');
        }
        
        $type = $request->get('type', 'anggota');
        
        if ($type === 'bantuan') {
            return $this->exportBantuanWord($request);
        } elseif ($type === 'anggota') {
            return $this->exportKoperasiWord($request);
        }
        
        return redirect()->back()->with('error', 'Tipe export tidak valid.');
    }
    
    public function exportExcel(Request $request) {
        // Check permission
        if (!can_export('laporan')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengekspor laporan.');
        }
        
        $type = $request->get('type', 'anggota');
        
        if ($type === 'bantuan') {
            return $this->exportBantuanExcel($request);
        } elseif ($type === 'anggota') {
            return $this->exportKoperasiExcel($request);
        }
        
        return redirect()->back()->with('error', 'Tipe export tidak valid.');
    }
    
    public function exportPdf(Request $request) {
        // Check permission
        if (!can_export('laporan')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengekspor laporan.');
        }
        
        $type = $request->get('type', 'anggota');
        
        if ($type === 'bantuan') {
            return $this->exportBantuanPdf($request);
        } elseif ($type === 'anggota') {
            return $this->exportKoperasiPdf($request);
        }
        
        return redirect()->back()->with('error', 'Tipe export tidak valid.');
    }
    
    // ══════════════════════════════════════════════════════════
    // BANTUAN EXPORT METHODS
    // ══════════════════════════════════════════════════════════
    
    private function exportBantuanWord(Request $request) {
        try {
            // Get tren per tahun data
            $bantuanPerTahunQuery = \DB::table('pengajuan_bantuan')
                ->join('periode_bantuan', 'pengajuan_bantuan.periode_bantuan_id', '=', 'periode_bantuan.id')
                ->selectRaw('YEAR(periode_bantuan.tanggal_mulai) as tahun, COUNT(*) as total, SUM(pengajuan_bantuan.jumlah_diajukan) as total_nilai')
                ->groupBy('tahun')
                ->orderBy('tahun', 'desc');
            
            if ($request->filled('tahun')) {
                $bantuanPerTahunQuery->whereRaw('YEAR(periode_bantuan.tanggal_mulai) = ?', [$request->tahun]);
            }
            
            $bantuanPerTahun = $bantuanPerTahunQuery->get();
            
            // Get pengajuan bantuan data
            $pengajuanQuery = \App\Models\PengajuanBantuan::with(['anggota', 'periodeBantuan']);
            
            if ($request->filled('tahun')) {
                $pengajuanQuery->whereHas('periodeBantuan', function($q) use ($request) {
                    $q->whereYear('tanggal_mulai', $request->tahun);
                });
            }
            
            if ($request->filled('status_pengajuan')) {
                $pengajuanQuery->where('status', $request->status_pengajuan);
            }
            
            $pengajuanBantuan = $pengajuanQuery->latest()->get();
            
            // Create Word document
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $phpWord->setDefaultFontName('Arial');
            $phpWord->setDefaultFontSize(11);
            
            $section = $phpWord->addSection([
                'orientation' => 'landscape',
                'pageSizeW' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(29.7),
                'pageSizeH' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(21),
                'marginTop' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
                'marginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
                'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
                'marginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
            ]);
            
            // Kop surat
            $logoPath = public_path('images/logo-tolikara.png');
            if (file_exists($logoPath)) {
                $section->addImage($logoPath, [
                    'width' => 70, 'height' => 70,
                    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                    'wrappingStyle' => 'inline',
                ]);
            }
            
            $section->addText(
                'PEMERINTAH KABUPATEN TOLIKARA',
                ['bold' => true, 'size' => 14, 'color' => '1a1a1a'],
                ['alignment' => 'center', 'spaceAfter' => 0]
            );
            $section->addText(
                'DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI',
                ['bold' => true, 'size' => 14, 'color' => '1a1a1a'],
                ['alignment' => 'center', 'spaceAfter' => 100]
            );
            $section->addText(
                'Jl. Raya Karubaga, Kab. Tolikara, Papua Pegunungan | Telp. (0964) 123456',
                ['size' => 10, 'color' => '333333'],
                ['alignment' => 'center', 'spaceAfter' => 150]
            );
            
            // Garis pemisah
            $section->addText('', [], [
                'borderBottomSize' => 12,
                'borderBottomColor' => '000000',
                'spaceAfter' => 150
            ]);
            
            $section->addTextBreak(1);
            
            $section->addText(
                'LAPORAN PROGRAM BANTUAN KOPERASI',
                ['bold' => true, 'size' => 16, 'color' => '1a1a1a'],
                ['alignment' => 'center', 'spaceAfter' => 0]
            );
            
            $section->addText('', [], [
                'borderBottomSize' => 12,
                'borderBottomColor' => '000000',
                'spaceAfter' => 100
            ]);
            
            $section->addText(
                'Per Tanggal: ' . date('d F Y'),
                ['size' => 10, 'italic' => true, 'color' => '666666'],
                ['alignment' => 'center', 'spaceAfter' => 50]
            );
            
            $section->addTextBreak(1);
            
            // Tabel Tren per Tahun
            if ($bantuanPerTahun->count() > 0) {
                $section->addText(
                    'TREN PENERIMA BANTUAN PER TAHUN',
                    ['bold' => true, 'size' => 12, 'color' => '1a1a1a'],
                    ['spaceAfter' => 100]
                );
                
                $table = $section->addTable([
                    'borderSize' => 6,
                    'borderColor' => '000000',
                    'cellMargin' => 80,
                ]);
                
                $hFont = ['bold' => true, 'color' => 'FFFFFF', 'size' => 10];
                $hCell = ['bgColor' => '1a3a6e', 'valign' => 'center'];
                
                $table->addRow(400);
                $table->addCell(2000, $hCell)->addText('Tahun', $hFont, ['alignment' => 'center']);
                $table->addCell(3000, $hCell)->addText('Jumlah Penerima', $hFont, ['alignment' => 'center']);
                $table->addCell(4000, $hCell)->addText('Total Nilai Bantuan', $hFont, ['alignment' => 'center']);
                
                foreach ($bantuanPerTahun as $i => $b) {
                    $rowBg = $i % 2 === 0 ? 'f9fafb' : 'ffffff';
                    $cellStyle = ['bgColor' => $rowBg, 'valign' => 'center'];
                    
                    $table->addRow();
                    $table->addCell(2000, $cellStyle)->addText($b->tahun, ['size' => 10, 'bold' => true], ['alignment' => 'center']);
                    $table->addCell(3000, $cellStyle)->addText($b->total . ' orang', ['size' => 10], ['alignment' => 'center']);
                    $table->addCell(4000, $cellStyle)->addText('Rp ' . number_format($b->total_nilai, 0, ',', '.'), ['size' => 10, 'bold' => true]);
                }
                
                $section->addTextBreak(2);
            }
            
            // Tabel Pengajuan Bantuan
            $section->addText(
                'DATA PENGAJUAN BANTUAN',
                ['bold' => true, 'size' => 12, 'color' => '1a1a1a'],
                ['spaceAfter' => 100]
            );
            
            $table = $section->addTable([
                'borderSize' => 6,
                'borderColor' => '000000',
                'cellMargin' => 50,
            ]);
            
            $hFont = ['bold' => true, 'color' => 'FFFFFF', 'size' => 8];
            $hCell = ['bgColor' => '1a3a6e', 'valign' => 'center'];
            
            $table->addRow(350);
            $table->addCell(300, $hCell)->addText('No', $hFont, ['alignment' => 'center']);
            $table->addCell(800, $hCell)->addText('Tanggal', $hFont);
            $table->addCell(1500, $hCell)->addText('Nama Pemohon', $hFont);
            $table->addCell(800, $hCell)->addText('No. HP', $hFont);
            $table->addCell(1500, $hCell)->addText('Nama Usaha', $hFont);
            $table->addCell(800, $hCell)->addText('Jenis', $hFont);
            $table->addCell(1200, $hCell)->addText('Jumlah', $hFont);
            $table->addCell(800, $hCell)->addText('Periode', $hFont);
            $table->addCell(600, $hCell)->addText('Status', $hFont);
            
            foreach ($pengajuanBantuan as $i => $p) {
                $rowBg = $i % 2 === 0 ? 'f9fafb' : 'ffffff';
                $cellStyle = ['bgColor' => $rowBg, 'valign' => 'center'];
                $textFont = ['size' => 8];
                
                $table->addRow();
                $table->addCell(300, $cellStyle)->addText($i + 1, ['size' => 8, 'bold' => true], ['alignment' => 'center']);
                $table->addCell(800, $cellStyle)->addText($p->created_at->format('d M Y'), $textFont);
                $table->addCell(1500, $cellStyle)->addText($p->nama_pemohon, ['size' => 8, 'bold' => true]);
                $table->addCell(800, $cellStyle)->addText($p->no_hp, $textFont);
                $table->addCell(1500, $cellStyle)->addText($p->nama_usaha, $textFont);
                $table->addCell(800, $cellStyle)->addText($p->jenis_bantuan, $textFont, ['alignment' => 'center']);
                $table->addCell(1200, $cellStyle)->addText('Rp ' . number_format($p->jumlah_diajukan, 0, ',', '.'), ['size' => 8, 'bold' => true]);
                $table->addCell(800, $cellStyle)->addText($p->periodeBantuan ? $p->periodeBantuan->nama_periode : '-', $textFont);
                $table->addCell(600, $cellStyle)->addText(ucfirst($p->status), ['size' => 8, 'bold' => true], ['alignment' => 'center']);
            }
            
            // Ringkasan
            $section->addTextBreak(1);
            $summaryTable = $section->addTable([
                'borderSize' => 12,
                'borderColor' => '000000',
                'cellMargin' => 150,
            ]);
            
            $summaryTable->addRow();
            $summaryTable->addCell(null, ['bgColor' => 'f8f9fa'])
                ->addText(
                    'TOTAL PENGAJUAN: ' . $pengajuanBantuan->count() . ' | TOTAL NILAI: Rp ' . number_format($pengajuanBantuan->sum('jumlah_diajukan'), 0, ',', '.'),
                    ['size' => 12, 'bold' => true, 'color' => '1a1a1a'],
                    ['alignment' => 'center']
                );
            
            $filename = 'Laporan-Bantuan-' . date('d-M-Y') . '.docx';
            
            $temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($temp_file);
            
            return response()->download($temp_file, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ])->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            \Log::error('Export Bantuan Word Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat dokumen Word: ' . $e->getMessage());
        }
    }
    
    private function exportBantuanExcel(Request $request) {
        try {
            // Get tren per tahun data
            $bantuanPerTahunQuery = \DB::table('pengajuan_bantuan')
                ->join('periode_bantuan', 'pengajuan_bantuan.periode_bantuan_id', '=', 'periode_bantuan.id')
                ->selectRaw('YEAR(periode_bantuan.tanggal_mulai) as tahun, COUNT(*) as total, SUM(pengajuan_bantuan.jumlah_diajukan) as total_nilai')
                ->groupBy('tahun')
                ->orderBy('tahun', 'desc');
            
            if ($request->filled('tahun')) {
                $bantuanPerTahunQuery->whereRaw('YEAR(periode_bantuan.tanggal_mulai) = ?', [$request->tahun]);
            }
            
            $bantuanPerTahun = $bantuanPerTahunQuery->get();
            
            // Get pengajuan bantuan data
            $pengajuanQuery = \App\Models\PengajuanBantuan::with(['anggota', 'periodeBantuan']);
            
            if ($request->filled('tahun')) {
                $pengajuanQuery->whereHas('periodeBantuan', function($q) use ($request) {
                    $q->whereYear('tanggal_mulai', $request->tahun);
                });
            }
            
            if ($request->filled('status_pengajuan')) {
                $pengajuanQuery->where('status', $request->status_pengajuan);
            }
            
            $pengajuanBantuan = $pengajuanQuery->latest()->get();
            
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Kop Surat
            $sheet->mergeCells('A1:I1');
            $sheet->setCellValue('A1', 'PEMERINTAH KABUPATEN TOLIKARA');
            $sheet->getStyle('A1')->applyFromArray([
                'font' => ['bold' => true, 'size' => 14],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ]);
            
            $sheet->mergeCells('A2:I2');
            $sheet->setCellValue('A2', 'DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI');
            $sheet->getStyle('A2')->applyFromArray([
                'font' => ['bold' => true, 'size' => 14],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ]);
            
            $sheet->mergeCells('A3:I3');
            $sheet->setCellValue('A3', 'Jl. Raya Karubaga, Kab. Tolikara, Papua Pegunungan | Telp. (0964) 123456');
            $sheet->getStyle('A3')->applyFromArray([
                'font' => ['size' => 10],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ]);
            
            $sheet->mergeCells('A4:I4');
            $sheet->getStyle('A4')->applyFromArray([
                'borders' => ['bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK]]
            ]);
            
            $sheet->mergeCells('A6:I6');
            $sheet->setCellValue('A6', 'LAPORAN PROGRAM BANTUAN KOPERASI');
            $sheet->getStyle('A6')->applyFromArray([
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ]);
            
            $sheet->mergeCells('A7:I7');
            $sheet->setCellValue('A7', 'Per Tanggal: ' . date('d F Y'));
            $sheet->getStyle('A7')->applyFromArray([
                'font' => ['italic' => true, 'size' => 10],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ]);
            
            // Header Tabel
            $headers = ['No', 'Tanggal', 'Nama Pemohon', 'No. HP', 'Nama Usaha', 'Jenis Bantuan', 'Jumlah', 'Periode', 'Status'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '9', $header);
                $col++;
            }
            
            $sheet->getStyle('A9:I9')->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1a3a6e']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK]]
            ]);
            
            // Data
            $row = 10;
            foreach ($pengajuanBantuan as $i => $p) {
                $bgColor = $i % 2 === 0 ? 'f9fafb' : 'ffffff';
                
                $sheet->setCellValue('A' . $row, $i + 1);
                $sheet->setCellValue('B' . $row, $p->created_at->format('d M Y'));
                $sheet->setCellValue('C' . $row, $p->nama_pemohon);
                $sheet->setCellValue('D' . $row, $p->no_hp);
                $sheet->setCellValue('E' . $row, $p->nama_usaha);
                $sheet->setCellValue('F' . $row, $p->jenis_bantuan);
                $sheet->setCellValue('G' . $row, $p->jumlah_diajukan);
                $sheet->setCellValue('H' . $row, $p->periodeBantuan ? $p->periodeBantuan->nama_periode : '-');
                $sheet->setCellValue('I' . $row, ucfirst($p->status));
                
                $sheet->getStyle('A' . $row . ':I' . $row)->applyFromArray([
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                    'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
                ]);
                
                $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle('C' . $row)->getFont()->setBold(true);
                
                $row++;
            }
            
            // Ringkasan
            $row++;
            $sheet->mergeCells('A' . $row . ':I' . $row);
            $sheet->setCellValue('A' . $row, 'Total Pengajuan: ' . $pengajuanBantuan->count() . ' | Total Nilai: Rp ' . number_format($pengajuanBantuan->sum('jumlah_diajukan'), 0, ',', '.'));
            $sheet->getStyle('A' . $row)->applyFromArray([
                'font' => ['bold' => true, 'size' => 12],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f8f9fa']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK]]
            ]);
            
            foreach (range('A', 'I') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            $filename = 'Laporan-Bantuan-' . date('d-M-Y') . '.xlsx';
            
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $temp_file = tempnam(sys_get_temp_dir(), 'excel');
            $writer->save($temp_file);
            
            return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            \Log::error('Export Bantuan Excel Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat file Excel: ' . $e->getMessage());
        }
    }
    
    private function exportBantuanPdf(Request $request) {
        try {
            // Get tren per tahun data
            $bantuanPerTahunQuery = \DB::table('pengajuan_bantuan')
                ->join('periode_bantuan', 'pengajuan_bantuan.periode_bantuan_id', '=', 'periode_bantuan.id')
                ->selectRaw('YEAR(periode_bantuan.tanggal_mulai) as tahun, COUNT(*) as total, SUM(pengajuan_bantuan.jumlah_diajukan) as total_nilai')
                ->groupBy('tahun')
                ->orderBy('tahun', 'desc');
            
            if ($request->filled('tahun')) {
                $bantuanPerTahunQuery->whereRaw('YEAR(periode_bantuan.tanggal_mulai) = ?', [$request->tahun]);
            }
            
            $bantuanPerTahun = $bantuanPerTahunQuery->get();
            
            // Get pengajuan bantuan data
            $pengajuanQuery = \App\Models\PengajuanBantuan::with(['anggota', 'periodeBantuan']);
            
            if ($request->filled('tahun')) {
                $pengajuanQuery->whereHas('periodeBantuan', function($q) use ($request) {
                    $q->whereYear('tanggal_mulai', $request->tahun);
                });
            }
            
            if ($request->filled('status_pengajuan')) {
                $pengajuanQuery->where('status', $request->status_pengajuan);
            }
            
            $pengajuanBantuan = $pengajuanQuery->latest()->get();
            
            $pdf = Pdf::loadView('pimpinan.laporan.pdf.bantuan', [
                'bantuanPerTahun' => $bantuanPerTahun,
                'pengajuanBantuan' => $pengajuanBantuan,
                'filters' => $request->all(),
                'tanggalCetak' => date('d F Y, H:i') . ' WIT'
            ]);
            
            $pdf->setPaper('a4', 'landscape');
            
            $filename = 'Laporan-Bantuan-' . date('d-M-Y') . '.pdf';
            
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            \Log::error('Export Bantuan PDF Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat file PDF: ' . $e->getMessage());
        }
    }
}
