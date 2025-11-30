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

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function collection()
    {
        return Registration::where('event_id', $this->eventId)
                           ->where('status', 'approved')
                           ->get();
    }

    public function headings(): array
    {
        $event = Event::find($this->eventId);
        return [
            ['DAFTAR HADIR PESERTA - ' . strtoupper($event->title)], // Judul
            ['Waktu: ' . $event->start_time->format('d F Y')],
            [''],
            ['No', 'Nama Lengkap', 'Asal Sekolah', 'No HP (WA)', 'TTL', 'Alamat', 'Status Absensi']
        ];
    }

    public function map($registration): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $registration->name,
            $registration->school_origin,
            $registration->phone,
            $registration->birth_place . ', ' . $registration->birth_date,
            $registration->address,
            $registration->presence_at ? 'HADIR (' . \Carbon\Carbon::parse($registration->presence_at)->format('H:i') . ')' : 'TIDAK HADIR',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            4 => [ // Header Kolom
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF83218F']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            1 => ['font' => ['bold' => true, 'size' => 14]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');

                // Border
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A4:G'.$highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);
            },
        ];
    }
}