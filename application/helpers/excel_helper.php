<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

function export_excel($data, $filename, $headers = array())
{
    // Membuat instance Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Judul kolom
    // $sheet->setCellValue('A1', 'No');
    // $sheet->setCellValue('B1', 'NIK');
    // $sheet->setCellValue('C1', 'Nama');
    // $sheet->setCellValue('D1', 'Departemen');
    // $sheet->setCellValue('E1', 'Jabatan');
    // $sheet->setCellValue('F1', 'Hadir');
    // $sheet->setCellValue('G1', 'Cuti');
    // $sheet->setCellValue('H1', 'Sakit');
    // $sheet->setCellValue('I1', 'Alpha');
    
    // // Isi data
    // $rowNumber = 2;
    // $no = 1;
    // foreach ($data as $row) {
    //     $sheet->setCellValue('A' . $rowNumber, $no++);
    //     $sheet->setCellValue('B' . $rowNumber, $row['nik']);
    //     $sheet->setCellValue('C' . $rowNumber, $row['nama_lengkap']);
    //     $sheet->setCellValue('D' . $rowNumber, $row['departemen']);
    //     $sheet->setCellValue('E' . $rowNumber, $row['jabatan']);
    //     $sheet->setCellValue('F' . $rowNumber, $row['hadir']);
    //     $sheet->setCellValue('G' . $rowNumber, $row['cuti']);
    //     $sheet->setCellValue('H' . $rowNumber, $row['sakit']);
    //     $sheet->setCellValue('I' . $rowNumber, $row['alpha']);
    //     $rowNumber++;
    // }

    if (empty($headers)) {
        $header = array_keys($data[0]);

        $headers = [];
        foreach ($header as $key => $value) {
            $headers[] = ucwords(strtolower(str_replace('_', ' ', $value)));
        }
    }

    // if (!empty($headers)) {
    //     array_unshift($headers, 'No');
    //     $column = 'A';
    //     foreach ($headers as $header) {
    //         $sheet->setCellValue($column . '1', $header);
    //         $column++;
    //     }
    // }
    if (!empty($headers)) {
        array_unshift($headers, 'No');
        $column = 'A';

        // Set header dan formatnya menjadi bold
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            
            // Set style bold untuk header
            $sheet->getStyle($column . '1')->applyFromArray([
                'font' => [
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFFF00', // Warna background header
                    ],
                ],
            ]);

            // Set auto size untuk lebar kolom header
            $sheet->getColumnDimension($column)->setAutoSize(true);

            $lastColumn = $column; // kolom terakhir
            $column++;
        }
        // Tambahkan AutoFilter di header
        $sheet->setAutoFilter('A1:' . $lastColumn . '1'); // Set AutoFilter dari kolom A sampai kolom terakhir header
    }
    // Set data
    $row = 2; // Mulai dari baris ke-2 jika ada header
    $number = 1; 
    foreach ($data as $dataRow) {
        $sheet->setCellValue('A' . $row, $number);
        $sheet->getStyle('A' . $row)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $column = 'B';
        foreach ($dataRow as $cell) {
            $sheet->setCellValue($column . $row, $cell);
            $sheet->getStyle($column . $row)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
            $column++;
        }
        $row++;
        $number++;
    }
    
    ob_clean();
    
    // Set header untuk melakukan export ke Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'. $filename . '.xlsx"');
    header('Cache-Control: max-age=0');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
