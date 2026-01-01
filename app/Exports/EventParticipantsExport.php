<?php

namespace App\Exports;

use App\Models\Registration;
use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class EventParticipantsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    protected $eventId;
    protected $gender; // 1. Tambahan Properti Filter

    // 2. Update Constructor untuk menerima filter gender
    public function __construct($eventId, $gender = null)
    {
        $this->eventId = $eventId;
        $this->gender = $gender;
    }

    public function collection()
    {
        // 3. Query dengan Filter
        $query = Registration::where('event_id', $this->eventId)
                             ->where('status', 'approved');

        // Jika ada filter gender, tambahkan kondisi
        if ($this->gender) {
            $query->where('gender', $this->gender);
        }

        return $query->get();
    }

    public function headings(): array
    {
        $event = Event::find($this->eventId);
        
        // Buat Label Judul Dinamis
        $label = '';
        if ($this->gender == 'L') $label = '(KHUSUS IPNU)';
        if ($this->gender == 'P') $label = '(KHUSUS IPPNU)';

        return [
            ['DAFTAR HADIR PESERTA ' . $label . ' - ' . strtoupper($event->title)], // Judul Dinamis
            ['Waktu: ' . $event->start_time->format('d F Y')],
            [''],
            // Saya tambahkan kolom L/P (Jenis Kelamin) agar lengkap
            ['No', 'Nama Lengkap', 'L/P', 'Asal Sekolah', 'No HP (WA)', 'TTL', 'Alamat', 'Status Absensi']
        ];
    }

    public function map($registration): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $registration->name,
            $registration->gender, // Mapping kolom L/P
            $registration->school_origin,
            $registration->phone,
            $registration->birth_place . ', ' . \Carbon\Carbon::parse($registration->birth_date)->format('d-m-Y'), // Format Tanggal Cantik
            $registration->address,
            $registration->presence_at 
                ? 'HADIR (' . \Carbon\Carbon::parse($registration->presence_at)->format('H:i') . ')' 
                : 'TIDAK HADIR',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            4 => [ // Header Kolom (Baris ke-4)
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF83218F']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
            1 => ['font' => ['bold' => true, 'size' => 14]], // Judul Utama
            2 => ['font' => ['italic' => true, 'size' => 11]], // Sub Judul Waktu
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                
                // Merge Header (Sesuaikan dengan jumlah kolom A-H = 8 Kolom)
                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('A2:H2');

                // Styling Border untuk seluruh tabel
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A4:H'.$highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER], // Rata tengah vertikal semua sel
                ]);
                
                // Center Alignment khusus kolom No, L/P, Status
                $sheet->getStyle('A4:A'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // No
                $sheet->getStyle('C4:C'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // L/P
            },
        ];
    }
}