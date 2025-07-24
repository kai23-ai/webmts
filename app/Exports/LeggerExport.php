<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeggerExport implements FromArray, WithStyles, WithCustomStartCell
{
    protected $data;
    protected $header;
    protected $kelas;
    protected $tahunAjaran;
    protected $semester;

    public function __construct($data, $header, $kelas = null, $tahunAjaran = null, $semester = 'Genap')
    {
        $this->data = $data;
        $this->header = $header;
        $this->kelas = $kelas;
        $this->tahunAjaran = $tahunAjaran;
        $this->semester = $semester;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function startCell(): string
    {
        return 'A9';
    }



    public function styles(Worksheet $sheet)
    {
        // Judul
        $sheet->mergeCells('A2:T2');
        $sheet->setCellValue('A2', 'LEGGER NILAI ' . ($this->kelas->nama_kelas ?? ''));
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        // Info kelas (mulai dari kolom A)
        $sheet->setCellValue('A4', 'Kelas:');
        $sheet->setCellValue('B4', $this->kelas->nama_kelas ?? '');
        $sheet->setCellValue('A5', 'Madrasah:');
        $sheet->setCellValue('B5', 'MTsN 2 SUMENEP');
        $sheet->setCellValue('D4', 'Semester:');
        $sheet->setCellValue('E4', $this->semester);
        $sheet->setCellValue('D5', 'Tahun Ajaran:');
        $sheet->setCellValue('E5', $this->tahunAjaran->tahun ?? '');
        // Merge info
        $sheet->mergeCells('A4:A4'); $sheet->mergeCells('A5:A5');
        $sheet->mergeCells('B4:B4'); $sheet->mergeCells('B5:B5');
        $sheet->mergeCells('D4:D4'); $sheet->mergeCells('D5:D5');
        $sheet->mergeCells('E4:E4'); $sheet->mergeCells('E5:E5');
        // Style label info abu-abu gelap, value kuning
        $grey = 'FF808080';
        $yellow = 'FFFFFF00';
        foreach(['A4','A5','D4','D5'] as $cell) {
            $sheet->getStyle($cell)->getFill()->setFillType('solid')->getStartColor()->setARGB($grey);
            $sheet->getStyle($cell)->getFont()->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getAlignment()->setHorizontal('right');
        }
        foreach(['B4','B5','E4','E5'] as $cell) {
            $sheet->getStyle($cell)->getFill()->setFillType('solid')->getStartColor()->setARGB($yellow);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getAlignment()->setHorizontal('left');
        }
        // HEADER 2 BARIS, MERGE SESUAI TEMPLATE, DIMULAI DARI KOLOM A
        // Baris 7: No, NIS, Nisn, Nama, JK, PAI, BAR, PP, BINDO, MTK, IPA, IPS, BING, PJOK, INFO, SBP, MULOK, Jumlah
        // Baris 8: (kosong kecuali PAI: QH, AA, FIK, SKI; MULOK: BTTQ, MADUR)
        // Merge vertikal (baris 7-8): A7:A8, B7:B8, C7:C8, D7:D8, E7:E8, J7:J8, K7:K8, L7:L8, M7:M8, N7:N8, O7:O8, P7:P8, Q7:Q8, T7:T8
        // Merge horizontal: F7:I7 (PAI), R7:S7 (MULOK)
        $sheet->setCellValue('A7', 'No');
        $sheet->setCellValue('B7', 'NIS');
        $sheet->setCellValue('C7', 'Nisn');
        $sheet->setCellValue('D7', 'Nama');
        $sheet->setCellValue('E7', 'JK');
        $sheet->setCellValue('F7', 'PAI');
        $sheet->setCellValue('J7', 'BAR');
        $sheet->setCellValue('K7', 'PP');
        $sheet->setCellValue('L7', 'BINDO');
        $sheet->setCellValue('M7', 'MTK');
        $sheet->setCellValue('N7', 'IPA');
        $sheet->setCellValue('O7', 'IPS');
        $sheet->setCellValue('P7', 'BING');
        $sheet->setCellValue('Q7', 'PJOK');
        $sheet->setCellValue('R7', 'INFO');
        $sheet->setCellValue('S7', 'SBP');
        $sheet->setCellValue('T7', 'MULOK');
        $sheet->setCellValue('V7', 'Jumlah');
        // Subheader
        $sheet->setCellValue('F8', 'QH');
        $sheet->setCellValue('G8', 'AA');
        $sheet->setCellValue('H8', 'FIK');
        $sheet->setCellValue('I8', 'SKI');
        $sheet->setCellValue('J8', '');
        $sheet->setCellValue('K8', '');
        $sheet->setCellValue('L8', '');
        $sheet->setCellValue('M8', '');
        $sheet->setCellValue('N8', '');
        $sheet->setCellValue('O8', '');
        $sheet->setCellValue('P8', '');
        $sheet->setCellValue('Q8', '');
        $sheet->setCellValue('R8', '');
        $sheet->setCellValue('S8', '');
        $sheet->setCellValue('T8', 'BTTQ');
        $sheet->setCellValue('U8', 'MADUR');
        $sheet->setCellValue('V8', '');
        // Merge vertikal
        foreach(['A','B','C','D','E','J','K','L','M','N','O','P','Q','R','S','V'] as $col) {
            $sheet->mergeCells($col.'7:'.$col.'8');
        }
        // Merge horizontal
        $sheet->mergeCells('F7:I7'); // PAI
        $sheet->mergeCells('T7:U7'); // MULOK
        // Style header
        $sheet->getStyle('A7:V8')->getFont()->setBold(true);
        $sheet->getStyle('A7:V8')->getFill()->setFillType('solid')->getStartColor()->setARGB($grey);
        $sheet->getStyle('A7:V8')->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A7:V8')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A7:V8')->getBorders()->getAllBorders()->setBorderStyle('thin');
        // Style kolom nilai kuning
        $lastRow = 8 + count($this->data);
        $sheet->getStyle('F9:U'.$lastRow)->getFill()->setFillType('solid')->getStartColor()->setARGB($yellow);
        $sheet->getStyle('F9:U'.$lastRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F9:U'.$lastRow)->getBorders()->getAllBorders()->setBorderStyle('thin');
        // Style kolom No, NIS, Nisn, Nama, JK, Jumlah abu-abu gelap
        foreach(['A','B','C','D','E','V'] as $col) {
            $sheet->getStyle($col.'9:'.$col.$lastRow)->getFill()->setFillType('solid')->getStartColor()->setARGB($grey);
            $sheet->getStyle($col.'9:'.$col.$lastRow)->getFont()->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle($col.'9:'.$col.$lastRow)->getAlignment()->setHorizontal($col=='D'?'left':'center');
            $sheet->getStyle($col.'9:'.$col.$lastRow)->getBorders()->getAllBorders()->setBorderStyle('thin');
        }
        // Border semua
        $sheet->getStyle('A8:V'.$lastRow)->getBorders()->getAllBorders()->setBorderStyle('thin');
        // Lebar kolom otomatis
        foreach (range('A', 'V') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        // Tinggi baris header
        $sheet->getRowDimension(7)->setRowHeight(24);
        $sheet->getRowDimension(8)->setRowHeight(20);
        // Pastikan kolom W, X, Y, Z, AA benar-benar kosong
        foreach(['W','X','Y','Z','AA'] as $col) {
            $sheet->setCellValue($col.'7', '');
            $sheet->setCellValue($col.'8', '');
            for ($row = 9; $row <= $lastRow; $row++) {
                $sheet->setCellValue($col.$row, '');
                $sheet->getStyle($col.$row)->getBorders()->getAllBorders()->setBorderStyle('none');
                $sheet->getStyle($col.$row)->getFill()->setFillType('none');
            }
            $sheet->getColumnDimension($col)->setAutoSize(false);
            $sheet->getColumnDimension($col)->setWidth(2);
        }
        return [];
    }


} 