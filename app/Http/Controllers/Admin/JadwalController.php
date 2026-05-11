<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\User;
use App\Models\Koperasi;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with(["pembuat", "petugas"])->latest("tanggal");
        if ($request->jenis)
            $query->where("jenis", $request->jenis);
        if ($request->status)
            $query->where("status", $request->status);
          $jadwal = $query->paginate(15)->withQueryString();     
                 $petugas = User::where('role','petugas')->get();
        return view("admin.jadwal.index", compact("jadwal", "petugas"));
    }

    public function create()
    {
        $petugas = User::where("role", "petugas")->get();
        $koperasiList = Koperasi::where("status_verifikasi", "terverifikasi")->get();
        return view("admin.jadwal.create", compact("petugas", "koperasiList"));
    }

    public function store(Request $request)
    {
        $request->validate(["judul" => "required|string|max:255", "jenis" => "required", "tanggal" => "required|date", "jam_mulai" => "required"]);
        $jadwal = Jadwal::create([
            "judul" => "$request->judul",
            "deskripsi" => $request->deskripsi,
            "jenis" => $request->jenis,
            "tanggal" => $request->tanggal,
            "jam_mulai" => $request->jam_mulai,
            "jam_selesai" => $request->jam_selesai,
            "lokasi" => $request->lokasi,
            "status" => $request->status ?? "dijadwalkan",
            "is_publik" => $request->has("is_publik"),
            "catatan" => $request->catatan,
            "created_by" => auth()->id(),
            "petugas_id" => $request->petugas_id,
        ]);
        if ($request->koperasi_ids)
            $jadwal->koperasiList()->attach($request->koperasi_ids);
        return redirect()->route("admin.jadwal.index")->with("success", "Jadwal berhasil dibuat!");
    }

    public function show(Jadwal $jadwal)
    {
        $jadwal->load(["pembuat", "petugas", "koperasiList"]);
        return view("admin.jadwal.show", compact("jadwal"));
    }

    public function edit(Jadwal $jadwal)
    {
        $petugas = User::where("role", "petugas")->get();
        $koperasiList = Koperasi::where("status_verifikasi", "terverifikasi")->get();
        $jadwal->load("koperasiList");
        return view("admin.jadwal.edit", compact("jadwal", "petugas", "koperasiList"));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate(["judul" => "required|string|max:255", "jenis" => "required", "tanggal" => "required|date", "jam_mulai" => "required"]);
        $jadwal->update([
            "judul" => $request->judul,
            "deskripsi" => $request->deskripsi,
            "jenis" => $request->jenis,
            "tanggal" => $request->tanggal,
            "jam_mulai" => $request->jam_mulai,
            "jam_selesai" => $request->jam_selesai,
            "lokasi" => $request->lokasi,
            "status" => $request->status,
            "is_publik" => $request->has("is_publik"),
            "catatan" => $request->catatan,
            "petugas_id" => $request->petugas_id,
        ]);
        if ($request->koperasi_ids !== null)
            $jadwal->koperasiList()->sync($request->koperasi_ids ?? []);
        return redirect()->route("admin.jadwal.index")->with("success", "Jadwal berhasil diupdate!");
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->koperasiList()->detach();
        $jadwal->delete();
        return back()->with("success", "Jadwal dihapus.");
    }

    public function updateStatus(Request $request, Jadwal $jadwal)
    {
        $jadwal->update(["status" => $request->status]);
        return back()->with("success", "Status diupdate!");
    }

    // Export Print
    public function exportPrint(Request $request)
    {
        $query = Jadwal::with(["pembuat", "petugas"])->latest("tanggal");
        
        if ($request->jenis) {
            $query->where("jenis", $request->jenis);
        }
        if ($request->status) {
            $query->where("status", $request->status);
        }
        
        $jadwal = $query->get();
        
        return view("admin.jadwal.print", compact("jadwal"));
    }

    // Export PDF
    public function exportPdf(Request $request)
    {
        $query = Jadwal::with(["pembuat", "petugas"])->latest("tanggal");
        
        if ($request->jenis) {
            $query->where("jenis", $request->jenis);
        }
        if ($request->status) {
            $query->where("status", $request->status);
        }
        
        $jadwal = $query->get();
        
        // Convert logo to base64 for better PDF compatibility
        $logoPath = public_path('logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }
        
        // Generate PDF dengan DomPDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.jadwal.pdf', compact('jadwal', 'logoBase64'));
        $pdf->setPaper('a4', 'landscape');
        
        $filename = 'Laporan_Jadwal_' . date('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }

    // Export Word
    public function exportWord(Request $request)
    {
        $query = Jadwal::with(["pembuat", "petugas"])->latest("tanggal");
        
        if ($request->jenis) {
            $query->where("jenis", $request->jenis);
        }
        if ($request->status) {
            $query->where("status", $request->status);
        }
        
        $jadwal = $query->get();
        
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection([
            'marginLeft' => 1000,
            'marginRight' => 1000,
            'marginTop' => 1000,
            'marginBottom' => 1000,
        ]);

        // Header/Kop Surat
        $headerTable = $section->addTable(['borderSize' => 0, 'borderColor' => 'ffffff']);
        $headerTable->addRow();
        
        // Logo (jika ada)
        if (file_exists(public_path('logo.png'))) {
            $headerTable->addCell(1500)->addImage(public_path('logo.png'), [
                'width' => 70,
                'height' => 70,
                'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
            ]);
        } else {
            $headerTable->addCell(1500);
        }
        
        $cellText = $headerTable->addCell(8000);
        $cellText->addText('DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI', [
            'bold' => true,
            'size' => 14,
            'name' => 'Arial'
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $cellText->addText('KABUPATEN TOLIKARA', [
            'bold' => true,
            'size' => 14,
            'name' => 'Arial'
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $cellText->addText('Jl. Pemuda No. 123, Karubaga, Tolikara, Papua Pegunungan', [
            'size' => 10,
            'name' => 'Arial'
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $cellText->addText('Telp: (0969) 12345 | Email: disperindagkop@tolikara.go.id', [
            'size' => 10,
            'name' => 'Arial'
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        
        $headerTable->addCell(1500);

        $section->addLine([
            'weight' => 2,
            'width' => 450,
            'height' => 0,
            'color' => '000000'
        ]);
        
        $section->addTextBreak(1);

        // Title
        $section->addText('LAPORAN JADWAL KEGIATAN', [
            'bold' => true,
            'size' => 14,
            'name' => 'Arial'
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        
        $section->addTextBreak(1);

        // Table
        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 80,
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
            'width' => 100 * 50
        ];
        
        $phpWord->addTableStyle('JadwalTable', $tableStyle);
        $table = $section->addTable('JadwalTable');

        // Header
        $table->addRow(400);
        $table->addCell(400, ['bgColor' => '22c55e'])->addText('No', [
            'bold' => true,
            'color' => 'ffffff',
            'size' => 9
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table->addCell(1000, ['bgColor' => '22c55e'])->addText('Hari', [
            'bold' => true,
            'color' => 'ffffff',
            'size' => 9
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table->addCell(1200, ['bgColor' => '22c55e'])->addText('Tanggal', [
            'bold' => true,
            'color' => 'ffffff',
            'size' => 9
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table->addCell(1100, ['bgColor' => '22c55e'])->addText('Waktu', [
            'bold' => true,
            'color' => 'ffffff',
            'size' => 9
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table->addCell(3200, ['bgColor' => '22c55e'])->addText('Judul & Deskripsi', [
            'bold' => true,
            'color' => 'ffffff',
            'size' => 9
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table->addCell(1400, ['bgColor' => '22c55e'])->addText('Jenis', [
            'bold' => true,
            'color' => 'ffffff',
            'size' => 9
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table->addCell(1800, ['bgColor' => '22c55e'])->addText('Lokasi', [
            'bold' => true,
            'color' => 'ffffff',
            'size' => 9
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table->addCell(1300, ['bgColor' => '22c55e'])->addText('Petugas', [
            'bold' => true,
            'color' => 'ffffff',
            'size' => 9
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table->addCell(1000, ['bgColor' => '22c55e'])->addText('Status', [
            'bold' => true,
            'color' => 'ffffff',
            'size' => 9
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        // Data
        $no = 1;
        foreach ($jadwal as $j) {
            $bgColor = $no % 2 == 0 ? 'f0fdf4' : 'ffffff';
            
            $table->addRow();
            $table->addCell(400, ['bgColor' => $bgColor])->addText($no++, [
                'size' => 9
            ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $table->addCell(1000, ['bgColor' => $bgColor])->addText(
                $j->hari,
                ['size' => 9, 'bold' => true],
                ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
            );
            $table->addCell(1200, ['bgColor' => $bgColor])->addText(
                $j->tanggal->format('d/m/Y'),
                ['size' => 9],
                ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
            );
            $table->addCell(1100, ['bgColor' => $bgColor])->addText(
                substr($j->jam_mulai, 0, 5) . ($j->jam_selesai ? ' - ' . substr($j->jam_selesai, 0, 5) : ''),
                ['size' => 9],
                ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
            );
            $cellJudul = $table->addCell(3200, ['bgColor' => $bgColor]);
            $cellJudul->addText($j->judul, ['size' => 9, 'bold' => true]);
            if ($j->deskripsi) {
                $cellJudul->addText(\Str::limit($j->deskripsi, 100), ['size' => 8, 'color' => '666666']);
            }
            $table->addCell(1400, ['bgColor' => $bgColor])->addText(
                $j->jenis_label,
                ['size' => 9]
            );
            $table->addCell(1800, ['bgColor' => $bgColor])->addText(
                $j->lokasi ?? '-',
                ['size' => 9]
            );
            $table->addCell(1300, ['bgColor' => $bgColor])->addText(
                $j->petugas->name ?? '-',
                ['size' => 9]
            );
            $table->addCell(1000, ['bgColor' => $bgColor])->addText(
                $j->status_label,
                ['size' => 9],
                ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
            );
        }

        // Summary
        $section->addTextBreak(2);
        $summaryTable = $section->addTable(['borderSize' => 6, 'borderColor' => '22c55e']);
        $summaryTable->addRow();
        $summaryTable->addCell(4000, ['bgColor' => 'dcfce7'])->addText('Total Jadwal:', [
            'bold' => true,
            'size' => 10
        ]);
        $summaryTable->addCell(2000, ['bgColor' => 'dcfce7'])->addText($jadwal->count() . ' kegiatan', [
            'bold' => true,
            'size' => 10
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        // Footer signature
        $section->addTextBreak(2);
        $section->addText('Karubaga, ' . now()->format('d F Y'), [
            'size' => 10
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END]);
        $section->addText('Kepala Dinas Perindustrian, Perdagangan dan Koperasi', [
            'bold' => true,
            'size' => 10
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END]);
        $section->addText('Kabupaten Tolikara', [
            'bold' => true,
            'size' => 10
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END]);
        
        $section->addTextBreak(3);
        
        $section->addText('( Wugi Kogoya, S.P )', [
            'bold' => true,
            'size' => 10
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END]);
        $section->addText('NIP. 19850215 200604 1 008', [
            'bold' => true,
            'size' => 10
        ], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END]);

        $filename = 'Laporan_Jadwal_' . date('Y-m-d_His') . '.docx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
        exit;
    }

    // Export Excel
    public function exportExcel(Request $request)
    {
        $query = Jadwal::with(["pembuat", "petugas"])->latest("tanggal");
        
        if ($request->jenis) {
            $query->where("jenis", $request->jenis);
        }
        if ($request->status) {
            $query->where("status", $request->status);
        }
        
        $jadwal = $query->get();
        
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(13);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(15);

        // Add logo if exists
        if (file_exists(public_path('logo.png'))) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Logo');
            $drawing->setDescription('Logo Tolikara');
            $drawing->setPath(public_path('logo.png'));
            $drawing->setHeight(60);
            $drawing->setCoordinates('A1');
            $drawing->setOffsetX(10);
            $drawing->setOffsetY(5);
            $drawing->setWorksheet($sheet);
        }

        // Header/Kop Surat
        $sheet->mergeCells('B1:I1');
        $sheet->setCellValue('B1', 'DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI');
        $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('B1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('B2:I2');
        $sheet->setCellValue('B2', 'KABUPATEN TOLIKARA');
        $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('B3:I3');
        $sheet->setCellValue('B3', 'Jl. Pemuda No. 123, Karubaga, Tolikara, Papua Pegunungan');
        $sheet->getStyle('B3')->getFont()->setSize(10);
        $sheet->getStyle('B3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('B4:I4');
        $sheet->setCellValue('B4', 'Telp: (0969) 12345 | Email: disperindagkop@tolikara.go.id');
        $sheet->getStyle('B4')->getFont()->setSize(10);
        $sheet->getStyle('B4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set row heights for header
        $sheet->getRowDimension(1)->setRowHeight(20);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(18);
        $sheet->getRowDimension(4)->setRowHeight(18);

        // Line
        $sheet->mergeCells('A5:I5');
        $sheet->getStyle('A5')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        // Title
        $sheet->mergeCells('A7:I7');
        $sheet->setCellValue('A7', 'LAPORAN JADWAL KEGIATAN');
        $sheet->getStyle('A7')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Table Header
        $headerRow = 9;
        $headers = ['No', 'Hari', 'Tanggal', 'Waktu', 'Judul & Deskripsi', 'Jenis', 'Lokasi', 'Petugas', 'Status'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $headerRow, $header);
            $col++;
        }

        // Style header
        $sheet->getStyle('A' . $headerRow . ':I' . $headerRow)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '22c55e']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
        ]);

        // Data
        $row = $headerRow + 1;
        $no = 1;
        foreach ($jadwal as $j) {
            $bgColor = $no % 2 == 0 ? 'f0fdf4' : 'ffffff';
            
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $j->hari);
            $sheet->setCellValue('C' . $row, $j->tanggal->format('d/m/Y'));
            $sheet->setCellValue('D' . $row, substr($j->jam_mulai, 0, 5) . ($j->jam_selesai ? ' - ' . substr($j->jam_selesai, 0, 5) : ''));
            $sheet->setCellValue('E' . $row, $j->judul . ($j->deskripsi ? "\n" . \Str::limit($j->deskripsi, 80) : ''));
            $sheet->setCellValue('F' . $row, $j->jenis_label);
            $sheet->setCellValue('G' . $row, $j->lokasi ?? '-');
            $sheet->setCellValue('H' . $row, $j->petugas->name ?? '-');
            $sheet->setCellValue('I' . $row, $j->status_label);

            // Style data row
            $sheet->getStyle('A' . $row . ':I' . $row)->applyFromArray([
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
                'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, 'wrapText' => true]
            ]);
            
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
            $sheet->getRowDimension($row)->setRowHeight(30);
            
            $row++;
        }

        // Summary box
        $summaryRow = $row + 1;
        $sheet->mergeCells('A' . $summaryRow . ':H' . $summaryRow);
        $sheet->setCellValue('A' . $summaryRow, 'Total Jadwal:');
        $sheet->setCellValue('I' . $summaryRow, $jadwal->count() . ' kegiatan');
        
        $sheet->getStyle('A' . $summaryRow . ':I' . $summaryRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 11],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'dcfce7']],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);

        // Signature
        $signRow = $summaryRow + 3;
        $sheet->mergeCells('G' . $signRow . ':I' . $signRow);
        $sheet->setCellValue('G' . $signRow, 'Karubaga, ' . now()->format('d F Y'));
        $sheet->getStyle('G' . $signRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $signRow++;
        $sheet->mergeCells('G' . $signRow . ':I' . $signRow);
        $sheet->setCellValue('G' . $signRow, 'Kepala Dinas Perindustrian, Perdagangan dan Koperasi');
        $sheet->getStyle('G' . $signRow)->getFont()->setBold(true);
        $sheet->getStyle('G' . $signRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $signRow++;
        $sheet->mergeCells('G' . $signRow . ':I' . $signRow);
        $sheet->setCellValue('G' . $signRow, 'Kabupaten Tolikara');
        $sheet->getStyle('G' . $signRow)->getFont()->setBold(true);
        $sheet->getStyle('G' . $signRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $signRow += 4;
        $sheet->mergeCells('G' . $signRow . ':I' . $signRow);
        $sheet->setCellValue('G' . $signRow, '( Wugi Kogoya, S.P )');
        $sheet->getStyle('G' . $signRow)->getFont()->setBold(true);
        $sheet->getStyle('G' . $signRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $signRow++;
        $sheet->mergeCells('G' . $signRow . ':I' . $signRow);
        $sheet->setCellValue('G' . $signRow, 'NIP. 19850215 200604 1 008');
        $sheet->getStyle('G' . $signRow)->getFont()->setBold(true);
        $sheet->getStyle('G' . $signRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $filename = 'Laporan_Jadwal_' . date('Y-m-d_His') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}