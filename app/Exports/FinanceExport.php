<?php

namespace App\Exports;

use App\Models\Finance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class FinanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    public function collection()
    {
        // Urutkan dari yang terlama ke terbaru untuk laporan alur kas
        return Finance::orderBy('date', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            ['LAPORAN KEUANGAN PAC IPNU LIMBANGAN'], // Baris 1
            ['Dicetak pada: ' . date('d F Y')],      // Baris 2
            [''],
            ['No', 'Tanggal', 'Keterangan / Uraian', 'Jenis', 'Masuk (Debet)', 'Keluar (Kredit)'] // Header Tabel
        ];
    }

    public function map($finance): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $finance->date->format('d/m/Y'),
            $finance->description,
            $finance->type == 'income' ? 'Pemasukan' : 'Pengeluaran',
            $finance->type == 'income' ? $finance->amount : 0,  // Kolom Masuk
            $finance->type == 'expense' ? $finance->amount : 0, // Kolom Keluar
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF83218F']], 'alignment' => ['horizontal' => 'center']],
            4 => [ // Header Tabel
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF83218F']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');

                $highestRow = $sheet->getHighestRow();

                // Border Semua
                $sheet->getStyle('A4:F' . $highestRow)->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                // Format Angka Rupiah/Currency
                $sheet->getStyle('E5:F' . $highestRow)->getNumberFormat()->setFormatCode('#,##0');
                
                // Warna Text (Hijau untuk Masuk, Merah untuk Keluar)
                // Note: Ini loop manual sederhana untuk styling baris per baris (opsional)
            },
        ];
    }
}