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
        $query = Koperasi::query();

        if ($request->filled('distrik')) {
            $query->where('distrik', $request->distrik);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('status_verifikasi')) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $koperasi = $query->latest()->paginate(20)->appends($request->query());

        $koperasiPerDistrik = Koperasi::select('distrik', DB::raw('COUNT(*) as total'))
            ->groupBy('distrik')->orderByDesc('total')->get();

        $koperasiPerKategori = Koperasi::select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')->get();

        return view('admin.laporan.koperasi', compact(
            'koperasi',
            'koperasiPerDistrik',
            'koperasiPerKategori'
        ));
    }

    public function bantuan(Request $request)
    {
        $query = Bantuan::with('penerima.koperasi');

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

    public function exportPdf(Request $request)
    {
        $type = $request->get('type', 'koperasi');

        if ($type === 'koperasi') {
            $data = Koperasi::with('verifiedBy')->latest()->get();
            $pdf = Pdf::loadView('admin.laporan.pdf.koperasi', compact('data'))
                ->setPaper('a4', 'landscape');
            return $pdf->download('laporan-koperasi-' . date('Ymd') . '.pdf');
        }

        if ($type === 'bantuan') {
            $data = Bantuan::with('penerima.koperasi')->latest()->get();
            $pdf = Pdf::loadView('admin.laporan.pdf.bantuan', compact('data'))
                ->setPaper('a4', 'landscape');
            return $pdf->download('laporan-bantuan-' . date('Ymd') . '.pdf');
        }

        return back()->with('error', 'Tipe laporan tidak dikenali.');
    }

    public function exportExcel(Request $request)
    {
        $type = $request->get('type', 'koperasi');

        if ($type === 'koperasi') {
            $data = Koperasi::with('verifiedBy')->latest()->get();
            return $this->exportKoperasiExcel($data);
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
                'width' => 60, 'height' => 60,
                'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                'wrappingStyle' => 'inline',
            ]);
        }
        $section->addText(
            'PEMERINTAH KABUPATEN TOLIKARA',
            ['bold' => true, 'size' => 13],
            ['alignment' => 'center']
        );
        $section->addText(
            'DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI',
            ['bold' => true, 'size' => 13],
            ['alignment' => 'center']
        );
        $section->addText(
            'Jl. Raya Karubaga, Kab. Tolikara, Papua Pegunungan | Telp. (0964) 123456',
            ['size' => 10],
            ['alignment' => 'center']
        );

        // Garis pemisah kop
        $section->addParagraph(null, [
            'border' => ['bottom' => ['color' => '000000', 'size' => 12, 'space' => 1]]
        ]);
        $section->addTextBreak(1);

        // ══════════════════════════════════════════════════════
        // LAPORAN kOPERASI
        // ══════════════════════════════════════════════════════
        if ($type === 'koperasi') {
            $data = Koperasi::with('verifiedBy')->latest()->get();

            $section->addText(
                'LAPORAN DATA KOPERASI',
                ['bold' => true, 'size' => 14, 'underline' => 'single'],
                ['alignment' => 'center']
            );
            $section->addText(
                'Per Tanggal: ' . date('d F Y'),
                ['size' => 10, 'italic' => true],
                ['alignment' => 'center']
            );
            $section->addTextBreak(1);

            // Tabel Koperasi
            $table = $section->addTable([
                'borderSize' => 6,
                'borderColor' => 'cccccc',
                'cellMargin' => 80,
            ]);

            // Style header tabel
            $hFont = ['bold' => true, 'color' => 'FFFFFF', 'size' => 10];
            $hCell = ['bgColor' => '1a2942', 'valign' => 'center'];

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
                $rowBg = $i % 2 === 0 ? [] : ['bgColor' => 'f0f4f8'];
                $table->addRow();
                $table->addCell(400, $rowBg)->addText($i + 1, ['size' => 10], ['alignment' => 'center']);
                $table->addCell(1800, $rowBg)->addText($u->no_registrasi ?? '-', ['size' => 10]);
                $table->addCell(2200, $rowBg)->addText($u->nama_usaha ?? '-', ['size' => 10]);
                $table->addCell(2200, $rowBg)->addText($u->nama_pemilik ?? '-', ['size' => 10]);
                $table->addCell(1500, $rowBg)->addText($u->jenis_usaha ?? '-', ['size' => 10]);
                $table->addCell(1200, $rowBg)->addText($u->distrik ?? '-', ['size' => 10]);
                $table->addCell(1500, $rowBg)->addText('Rp ' . number_format($u->modal_usaha, 0, ',', '.'), ['size' => 10]);
                $table->addCell(1500, $rowBg)->addText($u->jumlah_karyawan ?? '0', ['size' => 10], ['alignment' => 'center']);
                $table->addCell(1200, $rowBg)->addText(ucfirst($u->status_verifikasi ?? '-'), ['size' => 10]);
            }

            // Ringkasan
            $section->addTextBreak(1);
            $section->addText('Total KOPERASI: ' . $data->count() . ' unit', ['size' => 10, 'bold' => true]);

            $filename = 'laporan-koperasi-' . date('Ymd') . '.docx';

            // ══════════════════════════════════════════════════════
            // LAPORAN BANTUAN
            // ══════════════════════════════════════════════════════
        } elseif ($type === 'bantuan') {
            $data = Bantuan::with('penerima.koperasi')->latest()->get();

            $section->addText(
                'LAPORAN PROGRAM BANTUAN KOPERASI',
                ['bold' => true, 'size' => 14, 'underline' => 'single'],
                ['alignment' => 'center']
            );
            $section->addText(
                'Per Tanggal: ' . date('d F Y'),
                ['size' => 10, 'italic' => true],
                ['alignment' => 'center']
            );
            $section->addTextBreak(1);

            // Tabel Bantuan
            $table = $section->addTable([
                'borderSize' => 6,
                'borderColor' => 'cccccc',
                'cellMargin' => 80,
            ]);

            $hFont = ['bold' => true, 'color' => 'FFFFFF', 'size' => 10];
            $hCell = ['bgColor' => '2d6a4f', 'valign' => 'center'];

            $table->addRow(500);
            $table->addCell(400, $hCell)->addText('No', $hFont, ['alignment' => 'center']);
            $table->addCell(1500, $hCell)->addText('Kode', $hFont);
            $table->addCell(2500, $hCell)->addText('Nama Program', $hFont);
            $table->addCell(1200, $hCell)->addText('Jenis', $hFont);
            $table->addCell(800, $hCell)->addText('Tahun', $hFont, ['alignment' => 'center']);
            $table->addCell(1800, $hCell)->addText('Anggaran (Rp)', $hFont);
            $table->addCell(800, $hCell)->addText('Kuota', $hFont, ['alignment' => 'center']);
            $table->addCell(800, $hCell)->addText('Penerima', $hFont, ['alignment' => 'center']);
            $table->addCell(1000, $hCell)->addText('Status', $hFont);

            foreach ($data as $i => $b) {
                $rowBg = $i % 2 === 0 ? [] : ['bgColor' => 'f0f4f8'];
                $table->addRow();
                $table->addCell(400, $rowBg)->addText($i + 1, ['size' => 10], ['alignment' => 'center']);
                $table->addCell(1500, $rowBg)->addText($b->kode_bantuan ?? '-', ['size' => 10]);
                $table->addCell(2500, $rowBg)->addText($b->nama_bantuan ?? '-', ['size' => 10]);
                $table->addCell(1200, $rowBg)->addText(ucfirst($b->jenis_bantuan ?? '-'), ['size' => 10]);
                $table->addCell(800, $rowBg)->addText($b->tahun ?? '-', ['size' => 10], ['alignment' => 'center']);
                $table->addCell(1800, $rowBg)->addText('Rp ' . number_format($b->anggaran, 0, ',', '.'), ['size' => 10]);
                $table->addCell(800, $rowBg)->addText($b->kuota ?? '-', ['size' => 10], ['alignment' => 'center']);
                $table->addCell(800, $rowBg)->addText($b->penerima->count(), ['size' => 10], ['alignment' => 'center']);
                $table->addCell(1000, $rowBg)->addText(ucfirst($b->status ?? '-'), ['size' => 10]);
            }

            // Ringkasan
            $section->addTextBreak(1);
            $section->addText(
                'Total Program: ' . $data->count() . ' | Total Anggaran: Rp ' . number_format($data->sum('anggaran'), 0, ',', '.'),
                ['size' => 10, 'bold' => true]
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
        $section->addText('(__________________________)', ['size' => 11, 'bold' => true], ['alignment' => 'right']);
        $section->addText('NIP. ______________________', ['size' => 10], ['alignment' => 'right']);

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
        $filename = 'laporan-koperasi-' . date('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            // BOM untuk Excel UTF-8
            fputs($file, "\xEF\xBB\xBF");

            // Header
            fputcsv($file, [
                'No',
                'No. Registrasi',
                'Nama Pemilik',
                'Nama Usaha',
                'Jenis Usaha',
                'Kategori',
                'Distrik',
                'Kelurahan',
                'No. KTP',
                'Telepon',
                'Email',
                'Modal Usaha (Rp)',
                'Omset/Bulan (Rp)',
                'Karyawan',
                'Status Verifikasi',
                'Status Usaha',
                'Tanggal Daftar'
            ]);

            foreach ($data as $i => $u) {
                fputcsv($file, [
                    $i + 1,
                    $u->no_registrasi,
                    $u->nama_pemilik,
                    $u->nama_usaha,
                    $u->jenis_usaha,
                    ucfirst($u->kategori),
                    $u->distrik,
                    $u->kelurahan,
                    $u->no_ktp,
                    $u->no_telp ?? '-',
                    $u->email ?? '-',
                    number_format($u->modal_usaha, 0, ',', '.'),
                    number_format($u->omset_per_bulan, 0, ',', '.'),
                    $u->jumlah_karyawan,
                    ucfirst($u->status_verifikasi),
                    ucfirst(str_replace('_', ' ', $u->status_usaha)),
                    $u->created_at->format('d/m/Y'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportBantuanExcel($data)
    {
        $filename = 'laporan-bantuan-' . date('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'No',
                'Kode Bantuan',
                'Nama Program',
                'Jenis',
                'Tahun',
                'Periode',
                'Anggaran (Rp)',
                'Kuota',
                'Penerima',
                'Status'
            ]);

            foreach ($data as $i => $b) {
                fputcsv($file, [
                    $i + 1,
                    $b->kode_bantuan,
                    $b->nama_bantuan,
                    ucfirst($b->jenis_bantuan),
                    $b->tahun,
                    $b->periode,
                    number_format($b->anggaran, 0, ',', '.'),
                    $b->kuota,
                    $b->penerima->where('status', 'diterima')->count(),
                    ucfirst($b->status),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
}