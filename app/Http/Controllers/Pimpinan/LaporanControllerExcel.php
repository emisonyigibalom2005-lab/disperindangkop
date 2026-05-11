<?php
// Fungsi exportExcel yang diperbaiki - copy paste ke LaporanController.php

public function exportExcel() {
    try {
        $data = Koperasi::with('verifiedBy')->latest()->get();
        
        // Buat spreadsheet baru
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Koperasi');
        
        // Set properties
        $spreadsheet->getProperties()
            ->setCreator('DISPERINDAGKOP Tolikara')
            ->setTitle('Laporan Data Koperasi')
            ->setSubject('Laporan Koperasi')
            ->setDescription('Laporan lengkap data koperasi Kabupaten Tolikara');
        
        // ========== HEADER LAPORAN ==========
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'LAPORAN DATA KOPERASI');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1a3a6e']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);
        
        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', 'Dinas Perindustrian, Perdagangan, Koperasi dan UMKM');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '2c3e50']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);
        
        $sheet->mergeCells('A3:I3');
        $sheet->setCellValue('A3', 'Kabupaten Tolikara');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '2c3e50']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);
        
        $sheet->mergeCells('A4:I4');
        $sheet->setCellValue('A4', 'Tanggal: ' . date('d F Y'));
        $sheet->getStyle('A4')->applyFromArray([
            'font' => ['size' => 10, 'color' => ['rgb' => '666666']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);
        
        // ========== HEADER TABEL ==========
        $currentRow = 6;
        $headers = ['No', 'No. Registrasi', 'Nama Usaha', 'Nama Pemilik', 'Distrik', 'Kategori', 'Status Verifikasi', 'Tanggal Daftar', 'Diverifikasi Oleh'];
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . $currentRow, $header);
            $column++;
        }
        
        // Style header tabel
        $sheet->getStyle('A' . $currentRow . ':I' . $currentRow)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1a3a6e']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '1a3a6e']]]
        ]);
        $sheet->getRowDimension($currentRow)->setRowHeight(25);
        
        // ========== DATA ROWS ==========
        $currentRow++;
        $startDataRow = $currentRow;
        
        foreach ($data as $index => $koperasi) {
            $bgColor = ($index % 2 == 0) ? 'f8f9fa' : 'FFFFFF';
            
            $sheet->setCellValue('A' . $currentRow, $index + 1);
            $sheet->setCellValue('B' . $currentRow, $koperasi->no_registrasi ?? '-');
            $sheet->setCellValue('C' . $currentRow, $koperasi->nama_usaha ?? '-');
            $sheet->setCellValue('D' . $currentRow, $koperasi->nama_pemilik ?? '-');
            $sheet->setCellValue('E' . $currentRow, $koperasi->distrik ?? '-');
            $sheet->setCellValue('F' . $currentRow, ucfirst($koperasi->kategori ?? '-'));
            $sheet->setCellValue('G' . $currentRow, ucfirst($koperasi->status_verifikasi ?? '-'));
            $sheet->setCellValue('H' . $currentRow, $koperasi->created_at ? $koperasi->created_at->format('d/m/Y') : '-');
            $sheet->setCellValue('I' . $currentRow, $koperasi->verifiedBy->name ?? '-');
            
            // Style data row
            $sheet->getStyle('A' . $currentRow . ':I' . $currentRow)->applyFromArray([
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => 'dddddd']]],
                'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]
            ]);
            
            // Center align untuk nomor
            $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
            // Warna status
            if ($koperasi->status_verifikasi == 'diverifikasi') {
                $sheet->getStyle('G' . $currentRow)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '28a745']],
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'd4edda']]
                ]);
            } else {
                $sheet->getStyle('G' . $currentRow)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'ffc107']],
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'fff3cd']]
                ]);
            }
            
            $currentRow++;
        }
        
        // ========== FOOTER ==========
        $currentRow++;
        $sheet->mergeCells('A' . $currentRow . ':I' . $currentRow);
        $sheet->setCellValue('A' . $currentRow, 'Total Koperasi: ' . $data->count() . ' | Dicetak pada: ' . date('d F Y H:i:s'));
        $sheet->getStyle('A' . $currentRow)->applyFromArray([
            'font' => ['italic' => true, 'size' => 9, 'color' => ['rgb' => '666666']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);
        
        // ========== AUTO SIZE COLUMNS ==========
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Set minimum width
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(35);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(20);
        
        // ========== FREEZE PANES ==========
        $sheet->freezePane('A7'); // Freeze header
        
        // ========== SAVE & DOWNLOAD ==========
        $filename = 'Laporan-Koperasi-' . date('d-M-Y') . '.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), 'excel');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($temp_file);
        
        return response()->download($temp_file, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal membuat file Excel: ' . $e->getMessage());
    }
}
