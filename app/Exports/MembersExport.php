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
use Carbon\Carbon;

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
            ['DATA ANGGOTA PAC IPNU KECAMATAN LIMBANGAN'], 
            ['Dicetak pada: ' . date('d F Y, H:i') . ' WIB'], 
            [''], 
            [     
                'No',
                'Nama Lengkap',
                'Email',
                'No HP (WA)',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Delegasi',
                'Alamat Domisili',
                'Bergabung Pada',
            ]
        ];
    }

    // 3. MAPPING DATA (Isi Per Baris - BAGIAN YG DIPERBAIKI)
    protected $rowNumber = 0; 

    public function map($user): array
    {
        $this->rowNumber++;
        
        // Ambil Profile dengan aman
        // Jika profile null (kosong), kita anggap objek kosong agar tidak error
        $profile = $user->profile;

        // Logika Tanggal Lahir Aman
        $tglLahir = '-';
        if ($profile && $profile->birth_date) {
            try {
                $tglLahir = Carbon::parse($profile->birth_date)->format('d-m-Y');
            } catch (\Exception $e) {
                $tglLahir = $profile->birth_date; // Jika format salah, tampilkan apa adanya
            }
        }

        return [
            $this->rowNumber,
            $user->name,
            $user->email,
            // Gunakan Null Coalescing Operator (??) untuk data profile
            $profile->phone ?? '-', 
            $profile->birth_place ?? '-', 
            $tglLahir, // <--- Sudah aman sekarang
            $profile->school_origin ?? '-',
            $profile->address ?? '-',
            $user->created_at->format('d-m-Y'),
        ];
    }

    // 4. STYLING DASAR
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 16, 'color' => ['argb' => 'FF83218F']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            2 => [
                'font' => ['italic' => true, 'size' => 10],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            4 => [ 
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF83218F'], 
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    // 5. EVENT LANJUTAN (Border)
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                
                $sheet->mergeCells('A1:I1');
                $sheet->mergeCells('A2:I2');

                $highestRow = $sheet->getHighestRow(); 
                $highestColumn = 'I'; 

                $sheet->getStyle('A4:' . $highestColumn . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                $sheet->getStyle('A5:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F5:F' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I5:I' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}