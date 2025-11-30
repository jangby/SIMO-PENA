<?php

namespace App\Exports;

use App\Models\User;
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

class MembersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    // 1. AMBIL DATA
    public function collection()
    {
        return User::where('role', 'member')->with('profile')->get();
    }

    // 2. STRUKTUR JUDUL (KOP) & HEADER KOLOM
    public function headings(): array
    {
        return [
            ['DATA ANGGOTA PAC IPNU KECAMATAN LIMBANGAN'], // Baris 1: Judul Besar
            ['Dicetak pada: ' . date('d F Y, H:i') . ' WIB'], // Baris 2: Tanggal Cetak
            [''], // Baris 3: Kosong (Spasi)
            [     // Baris 4: Header Kolom Asli
                'No',
                'Nama Lengkap',
                'Email',
                'No HP (WA)',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Asal Sekolah / Komisariat',
                'Alamat Domisili',
                'Bergabung Pada',
            ]
        ];
    }

    // 3. MAPPING DATA (Isi Per Baris)
    protected $rowNumber = 0; // Untuk nomor urut

    public function map($user): array
    {
        $this->rowNumber++;
        
        return [
            $this->rowNumber,
            $user->name,
            $user->email,
            $user->profile->phone ?? '-',
            $user->profile->birth_place ?? '-',
            $user->profile->birth_date ? \Carbon\Carbon::parse($user->profile->birth_date)->format('d-m-Y') : '-',
            $user->profile->school_origin ?? '-',
            $user->profile->address ?? '-',
            $user->created_at->format('d-m-Y'),
        ];
    }

    // 4. STYLING DASAR (Font & Warna Header)
    public function styles(Worksheet $sheet)
    {
        return [
            // Baris 1 (Judul Utama): Bold, Ukuran 16, Tengah
            1 => [
                'font' => ['bold' => true, 'size' => 16, 'color' => ['argb' => 'FF83218F']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            // Baris 2 (Tanggal): Miring, Tengah
            2 => [
                'font' => ['italic' => true, 'size' => 10],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            // Baris 4 (Header Kolom): Background Ungu, Teks Putih, Bold
            4 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF83218F'], // Warna Ungu Kita
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    // 5. EVENT LANJUTAN (Merge Cells & Border)
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                
                // A. Merge Cells untuk Judul (Dari Kolom A sampai I)
                $sheet->mergeCells('A1:I1');
                $sheet->mergeCells('A2:I2');

                // B. Tambahkan Border ke Seluruh Data
                // Hitung baris terakhir data
                $highestRow = $sheet->getHighestRow(); 
                $highestColumn = 'I'; // Kolom terakhir kita

                // Terapkan border tipis hitam untuk range A4 sampai data terakhir
                $sheet->getStyle('A4:' . $highestColumn . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // C. Center Alignment untuk data tertentu (No, Tgl Lahir, Tgl Gabung)
                // Kolom A (No), F (Tgl Lahir), I (Tgl Gabung)
                $sheet->getStyle('A5:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F5:F' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I5:I' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}