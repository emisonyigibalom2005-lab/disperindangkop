<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bantuan;
use App\Models\PenerimaBantuan;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanController extends Controller
{
    public function index()
    {
        $stats = [
            'total_koperasi' => Koperasi::count(),
            'koperasi_verified' => Koperasi::where('status_verifikasi', 'diverifikasi')->count(),
            'koperasi_pending' => Koperasi::where('status_verifikasi', 'pending')->count(),
            'total_bantuan' => Bantuan::count(),
            'penerima_bantuan' => PenerimaBantuan::where('status', 'diterima')->count(),
        ];

        return view('admin.laporan.index', compact('stats'));
    }

    public function koperasi(Request $request)
    {
        // Ubah query dari Koperasi menjadi Anggota
        $query = \App\Models\Anggota::with('user');

        if ($request->filled('distrik')) {
            $query->where('distrik', $request->distrik);
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

        // Ganti variable $koperasi dengan data anggota
        $koperasi = $query->latest()->get();

        $koperasiPerDistrik = \App\Models\Anggota::select('distrik', DB::raw('COUNT(*) as total'))
            ->groupBy('distrik')->orderByDesc('total')->get();

        $koperasiPerKategori = \App\Models\Anggota::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')->get();

        return view('admin.laporan.koperasi_anggota', compact(
            'koperasi',
            'koperasiPerDistrik',
            'koperasiPerKategori'
        ));
    }

    public function anggota(Request $request)
    {
        $query = \App\Models\Anggota::with('user');

        // Filter
        if ($request->filled('distrik')) {
            $query->where('distrik', $request->distrik);
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

        $anggota = $query->latest()->get();

        // Statistik
        $anggotaPerDistrik = \App\Models\Anggota::select('distrik', DB::raw('COUNT(*) as total'))
            ->groupBy('distrik')->orderByDesc('total')->get();

        $anggotaPerStatus = \App\Models\Anggota::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')->get();

        // List untuk filter
        $distrikList = \App\Models\Anggota::distinct()->pluck('distrik')->filter();
        $periodeList = \App\Models\PeriodePendaftaran::orderBy('tahun_ajaran', 'desc')->get();

        return view('admin.laporan.anggota', compact(
            'anggota',
            'anggotaPerDistrik',
            'anggotaPerStatus',
            'distrikList',
            'periodeList'
        ));
    }

    public function bantuan(Request $request)
    {
        $query = Bantuan::with('penerima.koperasi')->withCount('penerima as jumlah_penerima');

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bantuan = $query->latest()->paginate(20)->appends($request->query());

        $bantuanPerTahun = PenerimaBantuan::join('bantuan', 'penerima_bantuan.bantuan_id', '=', 'bantuan.id')
            ->select('bantuan.tahun', DB::raw('COUNT(*) as total'), DB::raw('SUM(penerima_bantuan.jumlah_bantuan) as total_nilai'))
            ->where('penerima_bantuan.status', 'diterima')
            ->groupBy('bantuan.tahun')
            ->orderBy('bantuan.tahun')
            ->get();

        return view('admin.laporan.bantuan', compact('bantuan', 'bantuanPerTahun'));
    }

    public function bantuanDetail($id)
    {
        $bantuan = Bantuan::with(['penerima.koperasi'])->findOrFail($id);
        
        return view('admin.laporan.bantuan-detail', compact('bantuan'));
    }

    public function exportPdf(Request $request)
    {
        $type = $request->get('type', 'koperasi');

        if ($type === 'anggota') {
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
            
            // Debug: Check if data exists
            if ($data->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data anggota untuk diekspor.');
            }
            
            try {
                $pdf = Pdf::loadView('admin.laporan.pdf.anggota', [
                    'data' => $data,
                    'filters' => $request->all()
                ]);
                
                $pdf->setPaper('a4', 'landscape');
                
                return $pdf->download('laporan-anggota-koperasi-' . date('Ymd') . '.pdf');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error generating PDF: ' . $e->getMessage());
            }
        }

        if ($type === 'bantuan') {
            // Get tren per tahun
            $bantuanPerTahunQuery = \DB::table('pengajuan_bantuan')
                ->join('periode_bantuan', 'pengajuan_bantuan.periode_bantuan_id', '=', 'periode_bantuan.id')
                ->selectRaw('YEAR(periode_bantuan.tanggal_mulai) as tahun, COUNT(*) as total, SUM(pengajuan_bantuan.jumlah_diajukan) as total_nilai')
                ->groupBy('tahun')
                ->orderBy('tahun', 'desc');
            
            if ($request->filled('tahun')) {
                $bantuanPerTahunQuery->whereRaw('YEAR(periode_bantuan.tanggal_mulai) = ?', [$request->tahun]);
            }
            
            $bantuanPerTahun = $bantuanPerTahunQuery->get();
            
            try {
                $pdf = Pdf::loadView('admin.laporan.pdf.bantuan', [
                    'bantuanPerTahun' => $bantuanPerTahun,
                    'filters' => $request->all()
                ]);
                
                $pdf->setPaper('a4', 'landscape');
                
                return $pdf->download('laporan-bantuan-koperasi-' . date('Ymd') . '.pdf');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error generating PDF: ' . $e->getMessage());
            }
        }

        // PDF export disabled for other types - use Excel or Word instead
        return redirect()->back()->with('error', 'Export PDF tersedia untuk data anggota dan bantuan. Silakan gunakan Excel atau Word untuk laporan lainnya.');
    }

    public function exportExcel(Request $request)
    {
        $type = $request->get('type', 'koperasi');

        if ($type === 'koperasi') {
            // Apply filters
            $query = Koperasi::with('verifiedBy');
            
            if ($request->filled('search')) {
                $s = $request->search;
                $query->where(function ($q) use ($s) {
                    $q->where('nama_pemilik', 'like', "%{$s}%")
                        ->orWhere('nama_usaha', 'like', "%{$s}%")
                        ->orWhere('no_ktp', 'like', "%{$s}%")
                        ->orWhere('no_registrasi', 'like', "%{$s}%");
                });
            }
            
            // Handle both 'status_verifikasi' and 'status' parameters
            if ($request->filled('status_verifikasi')) {
                $query->where('status_verifikasi', $request->status_verifikasi);
            } elseif ($request->filled('status')) {
                $query->where('status_verifikasi', $request->status);
            }
            
            if ($request->filled('status_usaha')) {
                $query->where('status_usaha', $request->status_usaha);
            }
            
            if ($request->filled('distrik')) {
                $query->where('distrik', $request->distrik);
            }
            
            if ($request->filled('kategori')) {
                $query->where('kategori', $request->kategori);
            }
            
            $data = $query->latest()->get();
            return $this->exportKoperasiExcel($data);
        }

        if ($type === 'anggota') {
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
            return $this->exportAnggotaExcel($data);
        }

        if ($type === 'bantuan') {
            $data = Bantuan::with('penerima.koperasi')->latest()->get();
            return $this->exportBantuanExcel($data);
        }

        return back()->with('error', 'Tipe laporan tidak dikenali.');
    }

    // ══════════════════════════════════════════════════════════
    // EXPORT WORD
    // Cara pakai: install dulu → composer require phpoffice/phpword
    // Lalu akses: /admin/laporan/export-word?type=koperasi
    //         atau /admin/laporan/export-word?type=bantuan
    // ══════════════════════════════════════════════════════════
    public function exportWord(Request $request)
    {
        $type = $request->get('type', 'koperasi');

        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        // ══════════════════════════════════════════════════════
        // LAPORAN KOPERASI
        // ══════════════════════════════════════════════════════
        if ($type === 'koperasi') {
            // ── Halaman landscape A4 ──────────────────────────────
            $section = $phpWord->addSection([
                'orientation' => 'landscape',
                'pageSizeW' => Converter::cmToTwip(29.7),
                'pageSizeH' => Converter::cmToTwip(21),
                'marginTop' => Converter::cmToTwip(2),
                'marginRight' => Converter::cmToTwip(2),
                'marginBottom' => Converter::cmToTwip(2),
                'marginLeft' => Converter::cmToTwip(2),
            ]);

            // ── Kop surat ─────────────────────────────────────────
            // Logo Tolikara
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

            // Garis pemisah kop - Garis hitam tebal ganda yang menarik
            $section->addText('', [], [
                'borderBottomSize' => 24,
                'borderBottomColor' => '000000',
                'spaceAfter' => 0
            ]);
            
            $section->addText('', [], [
                'borderBottomSize' => 6,
                'borderBottomColor' => '000000',
                'spaceAfter' => 200
            ]);
            
            $section->addTextBreak(1);
            // Apply filters (same as Excel export)
            $query = Koperasi::with('verifiedBy');
            
            if ($request->filled('search')) {
                $s = $request->search;
                $query->where(function ($q) use ($s) {
                    $q->where('nama_pemilik', 'like', "%{$s}%")
                        ->orWhere('nama_usaha', 'like', "%{$s}%")
                        ->orWhere('no_ktp', 'like', "%{$s}%")
                        ->orWhere('no_registrasi', 'like', "%{$s}%");
                });
            }
            
            // Handle both 'status_verifikasi' and 'status' parameters
            if ($request->filled('status_verifikasi')) {
                $query->where('status_verifikasi', $request->status_verifikasi);
            } elseif ($request->filled('status')) {
                $query->where('status_verifikasi', $request->status);
            }
            
            if ($request->filled('status_usaha')) {
                $query->where('status_usaha', $request->status_usaha);
            }
            
            if ($request->filled('distrik')) {
                $query->where('distrik', $request->distrik);
            }
            
            if ($request->filled('kategori')) {
                $query->where('kategori', $request->kategori);
            }
            
            $data = $query->latest()->get();

            $section->addText(
                'LAPORAN DATA KOPERASI',
                ['bold' => true, 'size' => 16, 'color' => '1a1a1a'],
                ['alignment' => 'center', 'spaceAfter' => 0]
            );
            
            // Garis bawah judul
            $section->addText('', [], [
                'borderBottomSize' => 18,
                'borderBottomColor' => '000000',
                'spaceAfter' => 100
            ]);
            
            $section->addText(
                'Per Tanggal: ' . date('d F Y'),
                ['size' => 10, 'italic' => true, 'color' => '666666'],
                ['alignment' => 'center', 'spaceAfter' => 50]
            );
            
            // Filter info
            $filterInfo = [];
            if ($request->filled('search')) $filterInfo[] = 'Pencarian: ' . $request->search;
            if ($request->filled('status_verifikasi')) {
                $filterInfo[] = 'Status Verifikasi: ' . ucfirst($request->status_verifikasi);
            } elseif ($request->filled('status')) {
                $filterInfo[] = 'Status Verifikasi: ' . ucfirst($request->status);
            }
            if ($request->filled('status_usaha')) $filterInfo[] = 'Status Usaha: ' . ucfirst($request->status_usaha);
            if ($request->filled('distrik')) $filterInfo[] = 'Distrik: ' . $request->distrik;
            if ($request->filled('kategori')) $filterInfo[] = 'Kategori: ' . ucfirst($request->kategori);
            
            if (!empty($filterInfo)) {
                $section->addText(
                    'Filter: ' . implode(' | ', $filterInfo),
                    ['size' => 9, 'italic' => true, 'color' => '666666'],
                    ['alignment' => 'center']
                );
            }
            
            $section->addTextBreak(1);

            // Tabel Koperasi
            $table = $section->addTable([
                'borderSize' => 12,
                'borderColor' => '000000',
                'cellMargin' => 100,
                'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
            ]);

            // Style header tabel
            $hFont = ['bold' => true, 'color' => 'FFFFFF', 'size' => 10];
            $hCell = ['bgColor' => '1a1a1a', 'valign' => 'center', 'borderSize' => 12, 'borderColor' => '000000'];

            $table->addRow(500);
            $table->addCell(400, $hCell)->addText('No', $hFont, ['alignment' => 'center']);
            $table->addCell(1800, $hCell)->addText('No. Registrasi', $hFont);
            $table->addCell(2200, $hCell)->addText('Nama Usaha', $hFont);
            $table->addCell(2200, $hCell)->addText('Nama Pemilik', $hFont);
            $table->addCell(1500, $hCell)->addText('Jenis Usaha', $hFont);
            $table->addCell(1200, $hCell)->addText('Distrik', $hFont);
            $table->addCell(1500, $hCell)->addText('Modal (Rp)', $hFont);
            $table->addCell(1500, $hCell)->addText('Karyawan', $hFont, ['alignment' => 'center']);
            $table->addCell(1200, $hCell)->addText('Status', $hFont);

            // Isi baris
            foreach ($data as $i => $u) {
                $rowBg = $i % 2 === 0 ? 'f8f9fa' : 'FFFFFF';
                $cellStyle = ['bgColor' => $rowBg, 'valign' => 'center', 'borderSize' => 8, 'borderColor' => '000000'];
                
                $table->addRow();
                $table->addCell(400, $cellStyle)->addText($i + 1, ['size' => 10], ['alignment' => 'center']);
                $table->addCell(1800, $cellStyle)->addText($u->no_registrasi ?? '-', ['size' => 10]);
                $table->addCell(2200, $cellStyle)->addText($u->nama_usaha ?? '-', ['size' => 10, 'bold' => true]);
                $table->addCell(2200, $cellStyle)->addText($u->nama_pemilik ?? '-', ['size' => 10]);
                $table->addCell(1500, $cellStyle)->addText($u->jenis_usaha ?? '-', ['size' => 10]);
                $table->addCell(1200, $cellStyle)->addText($u->distrik ?? '-', ['size' => 10]);
                $table->addCell(1500, $cellStyle)->addText('Rp ' . number_format($u->modal_usaha, 0, ',', '.'), ['size' => 10]);
                $table->addCell(1500, $cellStyle)->addText($u->jumlah_karyawan ?? '0', ['size' => 10], ['alignment' => 'center']);
                $table->addCell(1200, $cellStyle)->addText(ucfirst($u->status_verifikasi ?? '-'), ['size' => 10, 'bold' => true]);
            }

            // Ringkasan
            $section->addTextBreak(1);
            
            // Box ringkasan dengan border
            $summaryTable = $section->addTable([
                'borderSize' => 12,
                'borderColor' => '000000',
                'cellMargin' => 150,
                'width' => 100 * 50,
                'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
            ]);
            
            $summaryTable->addRow();
            $summaryTable->addCell(null, ['bgColor' => 'f8f9fa', 'borderSize' => 12, 'borderColor' => '000000'])
                ->addText(
                    'TOTAL KOPERASI TERDAFTAR: ' . $data->count() . ' UNIT',
                    ['size' => 12, 'bold' => true, 'color' => '1a1a1a'],
                    ['alignment' => 'center']
                );

            $filename = 'laporan-koperasi-' . date('Ymd') . '.docx';

            // ══════════════════════════════════════════════════════
            // LAPORAN ANGGOTA KOPERASI
            // ══════════════════════════════════════════════════════
        } elseif ($type === 'anggota') {
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

            // ── Halaman landscape A4 ──────────────────────────────
            $section = $phpWord->addSection([
                'orientation' => 'landscape',
                'pageSizeW' => Converter::cmToTwip(29.7),
                'pageSizeH' => Converter::cmToTwip(21),
                'marginTop' => Converter::cmToTwip(2),
                'marginRight' => Converter::cmToTwip(2),
                'marginBottom' => Converter::cmToTwip(2),
                'marginLeft' => Converter::cmToTwip(2),
            ]);

            // ── Kop surat ─────────────────────────────────────────
            // Logo Tolikara
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

            // Garis pemisah kop - Garis tipis
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
            
            // Garis bawah judul - Garis tipis
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

            // Tabel Anggota dengan KOLOM PENTING SAJA (17 kolom) - font dan cell disesuaikan
            $table = $section->addTable([
                'borderSize' => 6,
                'borderColor' => '000000',
                'cellMargin' => 50,
                'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
            ]);

            // Style header tabel dengan warna hitam
            $hFont = ['bold' => true, 'color' => 'FFFFFF', 'size' => 8];
            $hCell = ['bgColor' => '1f2937', 'valign' => 'center', 'borderSize' => 6, 'borderColor' => '111827'];

            // Header dengan 17 kolom penting - ukuran cell disesuaikan agar muat 1 halaman
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

            // Isi baris dengan warna abu-abu muda
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
            
            // Box ringkasan dengan border hitam
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
            
            // Signature - Kepala Dinas
            $section->addTextBreak(2);
            $section->addText(
                'Tolikara, ' . date('d F Y'),
                ['size' => 10],
                ['alignment' => 'right']
            );
            $section->addText(
                'Kepala Dinas,',
                ['size' => 10, 'bold' => true],
                ['alignment' => 'right']
            );
            $section->addTextBreak(3);
            $section->addText(
                'Wugi Kogoya, S.P',
                ['size' => 10, 'bold' => true, 'underline' => 'single'],
                ['alignment' => 'right']
            );
            $section->addText(
                'NIP. 123456150890001',
                ['size' => 10],
                ['alignment' => 'right']
            );

            $filename = 'laporan-anggota-koperasi-' . date('Ymd') . '.docx';

            // ══════════════════════════════════════════════════════
            // LAPORAN BANTUAN
            // ══════════════════════════════════════════════════════
        } elseif ($type === 'bantuan') {
            // ── Halaman landscape A4 untuk data lengkap ──────────────────────────────
            $section = $phpWord->addSection([
                'orientation' => 'landscape',
                'pageSizeW' => Converter::cmToTwip(29.7),
                'pageSizeH' => Converter::cmToTwip(21),
                'marginTop' => Converter::cmToTwip(1.5),
                'marginRight' => Converter::cmToTwip(1.5),
                'marginBottom' => Converter::cmToTwip(1.5),
                'marginLeft' => Converter::cmToTwip(1.5),
            ]);

            // ── Kop surat ─────────────────────────────────────────
            // Logo Tolikara
            $logoPath = public_path('images/logo-tolikara.png');
            if (file_exists($logoPath)) {
                $section->addImage($logoPath, [
                    'width' => 55, 'height' => 55,
                    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                    'wrappingStyle' => 'inline',
                ]);
            }
            
            $section->addText(
                'PEMERINTAH KABUPATEN TOLIKARA',
                ['bold' => true, 'size' => 12, 'color' => '1a1a1a'],
                ['alignment' => 'center', 'spaceAfter' => 0]
            );
            $section->addText(
                'DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI',
                ['bold' => true, 'size' => 12, 'color' => '1a1a1a'],
                ['alignment' => 'center', 'spaceAfter' => 50]
            );
            $section->addText(
                'Jl. Raya Karubaga, Kab. Tolikara, Papua Pegunungan | Telp. (0964) 123456',
                ['size' => 9, 'color' => '333333'],
                ['alignment' => 'center', 'spaceAfter' => 100]
            );

            // Garis pemisah kop
            $section->addText('', [], [
                'borderBottomSize' => 18,
                'borderBottomColor' => '000000',
                'spaceAfter' => 150
            ]);
            
            $section->addText(
                'LAPORAN PROGRAM BANTUAN KOPERASI',
                ['bold' => true, 'size' => 14, 'color' => '1a1a1a'],
                ['alignment' => 'center', 'spaceAfter' => 0]
            );
            
            // Garis bawah judul
            $section->addText('', [], [
                'borderBottomSize' => 12,
                'borderBottomColor' => '000000',
                'spaceAfter' => 50
            ]);
            
            $section->addText(
                'Per Tanggal: ' . date('d F Y'),
                ['size' => 9, 'italic' => true, 'color' => '666666'],
                ['alignment' => 'center', 'spaceAfter' => 100]
            );

            // Get data pengajuan bantuan lengkap
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

            // Tabel: Data Pengajuan Bantuan Lengkap
            if ($pengajuanBantuan->count() > 0) {
                $section->addTextBreak(1);

                $hFont = ['bold' => true, 'color' => 'FFFFFF', 'size' => 10];
                $hCell = ['bgColor' => '1a3a6e', 'valign' => 'center', 'borderSize' => 10, 'borderColor' => '000000'];

                $table2 = $section->addTable([
                    'borderSize' => 10,
                    'borderColor' => '000000',
                    'cellMargin' => 60,
                    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
                ]);

                $table2->addRow(400);
                $table2->addCell(500, $hCell)->addText('No', $hFont, ['alignment' => 'center']);
                $table2->addCell(1200, $hCell)->addText('Tanggal', $hFont, ['alignment' => 'center']);
                $table2->addCell(2000, $hCell)->addText('Nama Pemohon', $hFont);
                $table2->addCell(1300, $hCell)->addText('Kontak', $hFont);
                $table2->addCell(1800, $hCell)->addText('Nama Usaha', $hFont);
                $table2->addCell(1200, $hCell)->addText('Jenis Bantuan', $hFont);
                $table2->addCell(1500, $hCell)->addText('Jumlah (Rp)', $hFont);
                $table2->addCell(1300, $hCell)->addText('Periode', $hFont);
                $table2->addCell(1000, $hCell)->addText('Status', $hFont, ['alignment' => 'center']);

                foreach ($pengajuanBantuan as $i => $p) {
                    $rowBg = $i % 2 === 0 ? 'f8f9fa' : 'FFFFFF';
                    $cellStyle = ['bgColor' => $rowBg, 'valign' => 'center', 'borderSize' => 8, 'borderColor' => '000000'];
                    
                    $table2->addRow(300);
                    $table2->addCell(500, $cellStyle)->addText($i + 1, ['size' => 9], ['alignment' => 'center']);
                    $table2->addCell(1200, $cellStyle)->addText($p->created_at->format('d/m/Y H:i'), ['size' => 8], ['alignment' => 'center']);
                    $table2->addCell(2000, $cellStyle)->addText($p->nama_pemohon, ['size' => 9, 'bold' => true]);
                    $table2->addCell(1300, $cellStyle)->addText($p->no_hp, ['size' => 8]);
                    $table2->addCell(1800, $cellStyle)->addText($p->nama_usaha, ['size' => 9]);
                    $table2->addCell(1200, $cellStyle)->addText($p->jenis_bantuan, ['size' => 8]);
                    $table2->addCell(1500, $cellStyle)->addText('Rp ' . number_format($p->jumlah_diajukan, 0, ',', '.'), ['size' => 9], ['alignment' => 'right']);
                    $table2->addCell(1300, $cellStyle)->addText($p->periodeBantuan ? $p->periodeBantuan->nama_periode : '-', ['size' => 8]);
                    $table2->addCell(1000, $cellStyle)->addText(ucfirst($p->status), ['size' => 8, 'bold' => true], ['alignment' => 'center']);
                }
            }

            // Ringkasan
            $section->addTextBreak(1);
            
            $allPengajuan = \App\Models\PengajuanBantuan::all();
            $summaryTable = $section->addTable([
                'borderSize' => 10,
                'borderColor' => '000000',
                'cellMargin' => 120,
                'width' => 100 * 50,
                'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
            ]);
            
            $summaryTable->addRow();
            $summaryTable->addCell(null, ['bgColor' => 'f8f9fa', 'borderSize' => 10, 'borderColor' => '000000'])
                ->addText(
                    'Total Pengajuan: ' . $allPengajuan->count() . ' | Total Nilai: Rp ' . number_format($allPengajuan->sum('jumlah_diajukan'), 0, ',', '.') . ' | Disetujui: ' . $allPengajuan->where('status', 'disetujui')->count() . ' | Pending: ' . $allPengajuan->where('status', 'pending')->count(),
                    ['size' => 10, 'bold' => true, 'color' => '1a1a1a'],
                    ['alignment' => 'center']
                );

            $filename = 'laporan-bantuan-' . date('Ymd') . '.docx';

        } else {
            return back()->with('error', 'Tipe laporan tidak dikenali.');
        }

        // ── Tanda tangan ──────────────────────────────────────
        $section->addTextBreak(2);
        $section->addText(
            'Tolikara, ' . date('d F Y'),
            ['size' => 11],
            ['alignment' => 'right']
        );
        $section->addText('Kepala Dinas,', ['size' => 11], ['alignment' => 'right']);
        $section->addTextBreak(3);
        $section->addText('Wugi Kogoya, S.P', ['size' => 11, 'bold' => true], ['alignment' => 'right']);
        $section->addText('NIP. 123456150890001', ['size' => 10], ['alignment' => 'right']);

        // ── Simpan & download ─────────────────────────────────
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $tempFile = tempnam(sys_get_temp_dir(), 'laporan_') . '.docx';
        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }

    private function exportKoperasiExcel($data)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('Dinas Perindustrian Tolikara')
            ->setTitle('Laporan Data Koperasi')
            ->setSubject('Data Koperasi')
            ->setDescription('Laporan data koperasi Kabupaten Tolikara');
        
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
        $sheet->setCellValue('A6', 'LAPORAN DATA KOPERASI');
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
        
        // Header Tabel (Baris 9)
        $headers = ['No', 'No. Registrasi', 'Nama Pemilik', 'Nama Usaha', 'Jenis Usaha', 'Kategori', 
                    'Distrik', 'Kelurahan', 'No. KTP', 'Telepon', 'Email', 'Modal Usaha (Rp)', 
                    'Omset/Bulan (Rp)', 'Karyawan', 'Status Verifikasi', 'Status Usaha', 'Tanggal Daftar'];
        
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '9', $header);
            $col++;
        }
        
        // Style header tabel
        $sheet->getStyle('A9:Q9')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1a1a1a']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK, 'color' => ['rgb' => '000000']]]
        ]);
        
        // Data
        $row = 10;
        foreach ($data as $i => $u) {
            $bgColor = $i % 2 === 0 ? 'f8f9fa' : 'FFFFFF';
            
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $u->no_registrasi);
            $sheet->setCellValue('C' . $row, $u->nama_pemilik);
            $sheet->setCellValue('D' . $row, $u->nama_usaha);
            $sheet->setCellValue('E' . $row, $u->jenis_usaha);
            $sheet->setCellValue('F' . $row, ucfirst($u->kategori));
            $sheet->setCellValue('G' . $row, $u->distrik);
            $sheet->setCellValue('H' . $row, $u->kelurahan);
            $sheet->setCellValue('I' . $row, $u->no_ktp);
            $sheet->setCellValue('J' . $row, $u->no_telp ?? '-');
            $sheet->setCellValue('K' . $row, $u->email ?? '-');
            $sheet->setCellValue('L' . $row, $u->modal_usaha);
            $sheet->setCellValue('M' . $row, $u->omset_per_bulan);
            $sheet->setCellValue('N' . $row, $u->jumlah_karyawan);
            $sheet->setCellValue('O' . $row, ucfirst($u->status_verifikasi));
            $sheet->setCellValue('P' . $row, ucfirst(str_replace('_', ' ', $u->status_usaha)));
            $sheet->setCellValue('Q' . $row, $u->created_at->format('d/m/Y'));
            
            // Style baris data
            $sheet->getStyle('A' . $row . ':Q' . $row)->applyFromArray([
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
                'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]
            ]);
            
            // Format angka
            $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('M' . $row)->getNumberFormat()->setFormatCode('#,##0');
            
            // Bold untuk nama usaha
            $sheet->getStyle('D' . $row)->getFont()->setBold(true);
            
            $row++;
        }
        
        // Ringkasan
        $row++;
        $sheet->mergeCells('A' . $row . ':Q' . $row);
        $sheet->setCellValue('A' . $row, 'TOTAL KOPERASI TERDAFTAR: ' . $data->count() . ' UNIT');
        $sheet->getStyle('A' . $row)->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '1a1a1a']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f8f9fa']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK, 'color' => ['rgb' => '000000']]]
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
        $filename = 'laporan-koperasi-' . date('Ymd') . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    private function exportAnggotaExcel($data)
    {
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
    }

    private function exportBantuanExcel($data)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('Dinas Perindustrian Tolikara')
            ->setTitle('Laporan Program Bantuan')
            ->setSubject('Data Bantuan Koperasi')
            ->setDescription('Laporan program bantuan koperasi Kabupaten Tolikara');
        
        // HEADER - Kop Surat
        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', 'PEMERINTAH KABUPATEN TOLIKARA');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '1a1a1a']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);
        
        $sheet->mergeCells('A2:J2');
        $sheet->setCellValue('A2', 'DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '1a1a1a']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);
        
        $sheet->mergeCells('A3:J3');
        $sheet->setCellValue('A3', 'Jl. Raya Karubaga, Kab. Tolikara, Papua Pegunungan | Telp. (0964) 123456');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['size' => 10, 'color' => ['rgb' => '666666']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);
        
        // Garis pemisah
        $sheet->mergeCells('A4:J4');
        $sheet->getStyle('A4')->applyFromArray([
            'borders' => [
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK, 'color' => ['rgb' => '000000']]
            ]
        ]);
        
        // Judul Laporan
        $sheet->mergeCells('A6:J6');
        $sheet->setCellValue('A6', 'LAPORAN PROGRAM BANTUAN KOPERASI');
        $sheet->getStyle('A6')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1a1a1a']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => [
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK, 'color' => ['rgb' => '000000']]
            ]
        ]);
        
        $sheet->mergeCells('A7:J7');
        $sheet->setCellValue('A7', 'Per Tanggal: ' . date('d F Y'));
        $sheet->getStyle('A7')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10, 'color' => ['rgb' => '666666']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);
        
        // Header Tabel (Baris 9)
        $headers = ['No', 'Kode Bantuan', 'Nama Program', 'Jenis', 'Tahun', 'Periode', 
                    'Anggaran (Rp)', 'Kuota', 'Penerima', 'Status'];
        
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '9', $header);
            $col++;
        }
        
        // Style header tabel
        $sheet->getStyle('A9:J9')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1a1a1a']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK, 'color' => ['rgb' => '000000']]]
        ]);
        
        // Data
        $row = 10;
        foreach ($data as $i => $b) {
            $bgColor = $i % 2 === 0 ? 'f8f9fa' : 'FFFFFF';
            
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $b->kode_bantuan);
            $sheet->setCellValue('C' . $row, $b->nama_bantuan);
            $sheet->setCellValue('D' . $row, ucfirst($b->jenis_bantuan));
            $sheet->setCellValue('E' . $row, $b->tahun);
            $sheet->setCellValue('F' . $row, $b->periode);
            $sheet->setCellValue('G' . $row, $b->anggaran);
            $sheet->setCellValue('H' . $row, $b->kuota);
            $sheet->setCellValue('I' . $row, $b->penerima->where('status', 'diterima')->count());
            $sheet->setCellValue('J' . $row, ucfirst($b->status));
            
            // Style baris data
            $sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray([
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
                'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]
            ]);
            
            // Format angka
            $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
            
            // Bold untuk kode dan nama
            $sheet->getStyle('B' . $row)->getFont()->setBold(true);
            $sheet->getStyle('C' . $row)->getFont()->setBold(true);
            
            // Center alignment untuk angka
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
            $row++;
        }
        
        // Ringkasan
        $row++;
        $sheet->mergeCells('A' . $row . ':J' . $row);
        $totalAnggaran = $data->sum('anggaran');
        $sheet->setCellValue('A' . $row, 'Total Program: ' . $data->count() . ' | Total Anggaran: Rp ' . number_format($totalAnggaran, 0, ',', '.'));
        $sheet->getStyle('A' . $row)->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '1a1a1a']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f8f9fa']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK, 'color' => ['rgb' => '000000']]]
        ]);
        
        // Auto size columns
        foreach (range('A', 'J') as $col) {
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
        $filename = 'laporan-bantuan-' . date('Ymd') . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function sertifikat(Request $request)
    {
        $query = \App\Models\Koperasi::where("status_verifikasi", "diverifikasi");
        if ($request->filled("search"))
            $query->where("nama_usaha", "like", "%" . $request->search . "%")->orWhere("nama_pemilik", "like", "%" . $request->search . "%");
        if ($request->filled("distrik"))
            $query->where("distrik", $request->distrik);
        $koperasi = $query->latest()->paginate(20)->appends($request->query());
        return view("admin.laporan.sertifikat", ["koperasi" => $koperasi, "distrik" => \App\Models\Koperasi::listDistrik()]);
    }

    public function cetakSertifikat(\App\Models\Koperasi $koperasi)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView("admin.laporan.pdf.sertifikat", compact("koperasi"))->setPaper("a4", "landscape");
        return $pdf->stream("Sertifikat-" . $koperasi->no_registrasi . ".pdf");
    }
    
    // Export Koperasi Word dengan Filter
    public function exportKoperasiWord(Request $request) {
        try {
            $query = Koperasi::query();
            
            // Apply filters
            if ($request->filled('distrik')) $query->where('distrik', $request->distrik);
            if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
            if ($request->filled('status')) $query->where('status_verifikasi', $request->status);
            
            $data = $query->with('verifiedBy')->latest()->get();
            
            // Create Word document (same as pimpinan)
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $phpWord->setDefaultFontName('Arial');
            $phpWord->setDefaultFontSize(10);
            
            $section = $phpWord->addSection([
                'marginLeft' => 800,
                'marginRight' => 800,
                'marginTop' => 800,
                'marginBottom' => 800,
                'orientation' => 'landscape',
            ]);
            
            // Header
            $headerTable = $section->addTable(['borderSize' => 0, 'borderColor' => 'FFFFFF', 'width' => 100 * 50, 'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT]);
            $headerTable->addRow(1200);
            $logoCell = $headerTable->addCell(2000, ['valign' => 'center']);
            $logoPath = public_path('logo.png');
            if (file_exists($logoPath)) {
                $logoCell->addImage($logoPath, ['width' => 80, 'height' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            }
            
            $textCell = $headerTable->addCell(12000, ['valign' => 'center']);
            $textCell->addText('PEMERINTAH KABUPATEN TOLIKARA', ['bold' => true, 'size' => 14, 'color' => '1a3a6e'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0]);
            $textCell->addText('DINAS PERINDUSTRIAN, PERDAGANGAN, KOPERASI DAN UMKM', ['bold' => true, 'size' => 16, 'color' => '1a3a6e'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 50]);
            $textCell->addText('Jl. Raya Karubaga, Kabupaten Tolikara, Papua Pegunungan', ['size' => 10, 'color' => '666666'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0]);
            
            $section->addText('', [], ['borderBottomSize' => 18, 'borderBottomColor' => '000000', 'spaceAfter' => 0]);
            $section->addText('', [], ['borderBottomSize' => 6, 'borderBottomColor' => '000000', 'spaceAfter' => 200]);
            $section->addTextBreak(1);
            
            // Title
            $section->addText('LAPORAN DATA KOPERASI', ['bold' => true, 'size' => 18, 'color' => '1a3a6e', 'underline' => 'single'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100, 'spaceBefore' => 100]);
            
            // Filter info
            $filterText = 'Filter: ';
            if ($request->filled('distrik')) $filterText .= 'Distrik ' . $request->distrik . ' | ';
            if ($request->filled('kategori')) $filterText .= 'Kategori ' . ucfirst($request->kategori) . ' | ';
            if ($request->filled('status')) $filterText .= 'Status ' . ucfirst($request->status) . ' | ';
            if (!$request->hasAny(['distrik', 'kategori', 'status'])) $filterText = 'Semua Data';
            else $filterText = rtrim($filterText, ' | ');
            
            $infoTable = $section->addTable(['borderSize' => 0, 'width' => 100 * 50, 'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT]);
            $infoTable->addRow();
            $infoTable->addCell(7000)->addText($filterText, ['size' => 10, 'color' => '333333']);
            $infoTable->addCell(7000)->addText('Tanggal Cetak: ' . date('d F Y'), ['size' => 10, 'color' => '333333'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT]);
            $section->addTextBreak(1);
            
            // Stats
            $section->addText('I. RINGKASAN DATA', ['bold' => true, 'size' => 13, 'color' => '1a3a6e'], ['spaceAfter' => 150, 'spaceBefore' => 100]);
            $statsTable = $section->addTable(['borderSize' => 8, 'borderColor' => '1a3a6e', 'cellMargin' => 100, 'width' => 50 * 50, 'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT]);
            $statsTable->addRow(500);
            $statsTable->addCell(5000, ['bgColor' => '1a3a6e', 'valign' => 'center'])->addText('KETERANGAN', ['bold' => true, 'color' => 'FFFFFF', 'size' => 11], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $statsTable->addCell(2000, ['bgColor' => '1a3a6e', 'valign' => 'center'])->addText('JUMLAH', ['bold' => true, 'color' => 'FFFFFF', 'size' => 11], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            
            $statsTable->addRow(450);
            $statsTable->addCell(5000, ['bgColor' => 'e8f4f8', 'valign' => 'center'])->addText('Total Koperasi Terdaftar', ['bold' => true, 'size' => 10, 'color' => '333333']);
            $statsTable->addCell(2000, ['valign' => 'center'])->addText($data->count() . ' Koperasi', ['size' => 11, 'bold' => true, 'color' => '1a3a6e'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            
            $statsTable->addRow(450);
            $statsTable->addCell(5000, ['bgColor' => 'f8f9fa', 'valign' => 'center'])->addText('Koperasi Terverifikasi', ['bold' => true, 'size' => 10, 'color' => '333333']);
            $statsTable->addCell(2000, ['valign' => 'center'])->addText($data->where('status_verifikasi', 'diverifikasi')->count() . ' Koperasi', ['size' => 11, 'bold' => true, 'color' => '28a745'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            
            $statsTable->addRow(450);
            $statsTable->addCell(5000, ['bgColor' => 'e8f4f8', 'valign' => 'center'])->addText('Koperasi Menunggu Verifikasi', ['bold' => true, 'size' => 10, 'color' => '333333']);
            $statsTable->addCell(2000, ['valign' => 'center'])->addText($data->where('status_verifikasi', 'pending')->count() . ' Koperasi', ['size' => 11, 'bold' => true, 'color' => 'ffc107'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            
            $statsTable->addRow(450);
            $statsTable->addCell(5000, ['bgColor' => 'f8f9fa', 'valign' => 'center'])->addText('Koperasi Ditolak', ['bold' => true, 'size' => 10, 'color' => '333333']);
            $statsTable->addCell(2000, ['valign' => 'center'])->addText($data->where('status_verifikasi', 'ditolak')->count() . ' Koperasi', ['size' => 11, 'bold' => true, 'color' => 'dc3545'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            
            $section->addTextBreak(2);
            
            // Data table
            $section->addText('II. DAFTAR KOPERASI', ['bold' => true, 'size' => 13, 'color' => '1a3a6e'], ['spaceAfter' => 150]);
            $table = $section->addTable(['borderSize' => 8, 'borderColor' => '1a3a6e', 'cellMargin' => 80, 'width' => 100 * 50, 'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT]);
            
            $table->addRow(600, ['tblHeader' => true]);
            $table->addCell(600, ['bgColor' => '1a3a6e', 'valign' => 'center'])->addText('NO', ['bold' => true, 'color' => 'FFFFFF', 'size' => 9], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $table->addCell(1800, ['bgColor' => '1a3a6e', 'valign' => 'center'])->addText('NO. REGISTRASI', ['bold' => true, 'color' => 'FFFFFF', 'size' => 9], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $table->addCell(3200, ['bgColor' => '1a3a6e', 'valign' => 'center'])->addText('NAMA USAHA', ['bold' => true, 'color' => 'FFFFFF', 'size' => 9], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $table->addCell(2200, ['bgColor' => '1a3a6e', 'valign' => 'center'])->addText('PEMILIK', ['bold' => true, 'color' => 'FFFFFF', 'size' => 9], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $table->addCell(1600, ['bgColor' => '1a3a6e', 'valign' => 'center'])->addText('DISTRIK', ['bold' => true, 'color' => 'FFFFFF', 'size' => 9], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $table->addCell(1300, ['bgColor' => '1a3a6e', 'valign' => 'center'])->addText('KATEGORI', ['bold' => true, 'color' => 'FFFFFF', 'size' => 9], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $table->addCell(1500, ['bgColor' => '1a3a6e', 'valign' => 'center'])->addText('STATUS', ['bold' => true, 'color' => 'FFFFFF', 'size' => 9], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            
            foreach ($data as $index => $koperasi) {
                $bgColor = ($index % 2 == 0) ? 'f8f9fa' : 'FFFFFF';
                $table->addRow(450);
                $table->addCell(600, ['bgColor' => $bgColor, 'valign' => 'center'])->addText($index + 1, ['size' => 9], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
                $table->addCell(1800, ['bgColor' => $bgColor, 'valign' => 'center'])->addText($koperasi->no_registrasi ?? '-', ['size' => 9, 'color' => '333333']);
                $table->addCell(3200, ['bgColor' => $bgColor, 'valign' => 'center'])->addText($koperasi->nama_usaha ?? '-', ['size' => 9, 'bold' => true, 'color' => '1a3a6e']);
                $table->addCell(2200, ['bgColor' => $bgColor, 'valign' => 'center'])->addText($koperasi->nama_pemilik ?? '-', ['size' => 9, 'color' => '333333']);
                $table->addCell(1600, ['bgColor' => $bgColor, 'valign' => 'center'])->addText($koperasi->distrik ?? '-', ['size' => 9, 'color' => '333333']);
                $table->addCell(1300, ['bgColor' => $bgColor, 'valign' => 'center'])->addText(ucfirst($koperasi->kategori ?? '-'), ['size' => 9, 'color' => '333333']);
                
                $statusColor = match($koperasi->status_verifikasi) { 'diverifikasi' => '28a745', 'pending' => 'ffc107', 'ditolak' => 'dc3545', default => '6c757d' };
                $statusBg = match($koperasi->status_verifikasi) { 'diverifikasi' => 'd4edda', 'pending' => 'fff3cd', 'ditolak' => 'f8d7da', default => 'e9ecef' };
                $table->addCell(1500, ['bgColor' => $statusBg, 'valign' => 'center'])->addText(strtoupper($koperasi->status_verifikasi ?? '-'), ['size' => 8, 'bold' => true, 'color' => $statusColor], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            }
            
            // Footer
            $section->addTextBreak(2);
            $signTable = $section->addTable(['borderSize' => 0, 'width' => 100 * 50, 'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT]);
            $signTable->addRow();
            $signTable->addCell(7000)->addText('', []);
            $signTable->addCell(7000)->addText('Tolikara, ' . date('d F Y'), ['size' => 10, 'color' => '333333'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $signTable->addRow();
            $signTable->addCell(7000)->addText('', []);
            $signTable->addCell(7000)->addText('Kepala Dinas', ['size' => 10, 'bold' => true, 'color' => '333333'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $signTable->addRow(1200);
            $signTable->addCell(7000)->addText('', []);
            $signTable->addCell(7000)->addText('', []);
            $signTable->addRow();
            $signTable->addCell(7000)->addText('', []);
            $signTable->addCell(7000)->addText('(_____________________)', ['size' => 10, 'bold' => true, 'color' => '333333'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            
            $filename = 'Laporan-Koperasi-' . date('d-M-Y') . '.docx';
            $temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($temp_file);
            
            return response()->download($temp_file, $filename, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat dokumen Word: ' . $e->getMessage());
        }
    }
    
    // Export Koperasi Excel dengan Filter (untuk route laporan.koperasi.excel)
    public function exportKoperasiExcelWithFilter(Request $request) {
        try {
            $query = Koperasi::query();
            if ($request->filled('distrik')) $query->where('distrik', $request->distrik);
            if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
            if ($request->filled('status')) $query->where('status_verifikasi', $request->status);
            $data = $query->with('verifiedBy')->latest()->get();
            
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Laporan Koperasi');
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            
            // Header
            $sheet->mergeCells('A1:H1');
            $sheet->setCellValue('A1', 'LAPORAN DATA KOPERASI');
            $sheet->getStyle('A1')->applyFromArray(['font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1a3a6e']], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]]);
            
            $sheet->mergeCells('A2:H2');
            $sheet->setCellValue('A2', 'DINAS PERINDUSTRIAN, PERDAGANGAN, KOPERASI DAN UMKM');
            $sheet->getStyle('A2')->applyFromArray(['font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '1a3a6e']], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]]);
            
            // Filter info
            $filterText = 'Filter: ';
            if ($request->filled('distrik')) $filterText .= 'Distrik ' . $request->distrik . ' | ';
            if ($request->filled('kategori')) $filterText .= 'Kategori ' . ucfirst($request->kategori) . ' | ';
            if ($request->filled('status')) $filterText .= 'Status ' . ucfirst($request->status) . ' | ';
            if (!$request->hasAny(['distrik', 'kategori', 'status'])) $filterText = 'Semua Data';
            else $filterText = rtrim($filterText, ' | ');
            
            $sheet->mergeCells('A4:H4');
            $sheet->setCellValue('A4', $filterText);
            $sheet->getStyle('A4')->applyFromArray(['font' => ['size' => 10, 'italic' => true, 'color' => ['rgb' => '333333']], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]]);
            
            // Stats
            $row = 7;
            $sheet->mergeCells("A{$row}:B{$row}");
            $sheet->setCellValue("A{$row}", 'RINGKASAN DATA');
            $sheet->getStyle("A{$row}")->applyFromArray(['font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '1a3a6e']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'e8f4f8']]]);
            
            $row++;
            $sheet->setCellValue("A{$row}", 'Total Koperasi');
            $sheet->setCellValue("B{$row}", $data->count() . ' Koperasi');
            $sheet->getStyle("A{$row}:B{$row}")->applyFromArray(['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f8f9fa']], 'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]]);
            
            $row++;
            $sheet->setCellValue("A{$row}", 'Terverifikasi');
            $sheet->setCellValue("B{$row}", $data->where('status_verifikasi', 'diverifikasi')->count() . ' Koperasi');
            $sheet->getStyle("B{$row}")->getFont()->getColor()->setRGB('28a745');
            $sheet->getStyle("A{$row}:B{$row}")->applyFromArray(['font' => ['bold' => true], 'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]]);
            
            $row++;
            $sheet->setCellValue("A{$row}", 'Pending');
            $sheet->setCellValue("B{$row}", $data->where('status_verifikasi', 'pending')->count() . ' Koperasi');
            $sheet->getStyle("B{$row}")->getFont()->getColor()->setRGB('ffc107');
            $sheet->getStyle("A{$row}:B{$row}")->applyFromArray(['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f8f9fa']], 'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]]);
            
            $row++;
            $sheet->setCellValue("A{$row}", 'Ditolak');
            $sheet->setCellValue("B{$row}", $data->where('status_verifikasi', 'ditolak')->count() . ' Koperasi');
            $sheet->getStyle("B{$row}")->getFont()->getColor()->setRGB('dc3545');
            $sheet->getStyle("A{$row}:B{$row}")->applyFromArray(['font' => ['bold' => true], 'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]]);
            
            // Table header
            $row += 2;
            $headerRow = $row;
            $headers = ['No', 'No. Registrasi', 'Nama Usaha', 'Pemilik', 'Distrik', 'Kategori', 'Status', 'Tanggal Daftar'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . $row, $header);
                $col++;
            }
            $sheet->getStyle("A{$row}:H{$row}")->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1a3a6e']], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER], 'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '1a3a6e']]]]);
            
            // Data rows
            $row++;
            foreach ($data as $index => $koperasi) {
                $bgColor = ($index % 2 == 0) ? 'f8f9fa' : 'FFFFFF';
                $sheet->setCellValue("A{$row}", $index + 1);
                $sheet->setCellValue("B{$row}", $koperasi->no_registrasi ?? '-');
                $sheet->setCellValue("C{$row}", $koperasi->nama_usaha ?? '-');
                $sheet->setCellValue("D{$row}", $koperasi->nama_pemilik ?? '-');
                $sheet->setCellValue("E{$row}", $koperasi->distrik ?? '-');
                $sheet->setCellValue("F{$row}", ucfirst($koperasi->kategori ?? '-'));
                $sheet->setCellValue("G{$row}", ucfirst($koperasi->status_verifikasi ?? '-'));
                $sheet->setCellValue("H{$row}", $koperasi->created_at ? $koperasi->created_at->format('d/m/Y') : '-');
                
                $sheet->getStyle("A{$row}:H{$row}")->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]], 'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => 'dee2e6']]]]);
                
                $statusColor = match($koperasi->status_verifikasi) { 'diverifikasi' => '28a745', 'pending' => 'ffc107', 'ditolak' => 'dc3545', default => '6c757d' };
                $sheet->getStyle("G{$row}")->getFont()->getColor()->setRGB($statusColor);
                $sheet->getStyle("G{$row}")->getFont()->setBold(true);
                $row++;
            }
            
            // Column widths
            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(30);
            $sheet->getColumnDimension('D')->setWidth(25);
            $sheet->getColumnDimension('E')->setWidth(18);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->freezePane('A' . ($headerRow + 1));
            
            $filename = 'Laporan-Koperasi-' . date('d-M-Y') . '.xlsx';
            $temp_file = tempnam(sys_get_temp_dir(), 'excel');
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save($temp_file);
            
            return response()->download($temp_file, $filename, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat file Excel: ' . $e->getMessage());
        }
    }
}