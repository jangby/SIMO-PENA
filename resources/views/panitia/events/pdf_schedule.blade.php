<!DOCTYPE html>
<html>
<head>
    <title>Absensi Materi</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2, .header h3, .header p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; }
        th { background-color: #f0f0f0; }
        .text-center { text-align: center; }
        .status-hadir { color: green; font-weight: bold; }
        .status-alpha { color: red; font-weight: bold; }
        .meta-info { margin-bottom: 10px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN ABSENSI MATERI</h2>
        <h3>{{ $schedule->event->title }}</h3>
    </div>

    <div class="meta-info">
        <strong>Materi:</strong> {{ $schedule->activity }} <br>
        <strong>Waktu:</strong> {{ \Carbon\Carbon::parse($schedule->start_time)->format('d M Y, H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} <br>
        <strong>Pemateri:</strong> {{ $schedule->pic ?? '-' }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Peserta</th>
                <th width="25%">Asal Delegasi</th>
                <th width="20%">Waktu Scan</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedule->event->registrations as $i => $reg)
                @php
                    // Cek apakah peserta ini ada di data kehadiran jadwal ini
                    $attendance = $schedule->attendances->firstWhere('registration_id', $reg->id);
                @endphp
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $reg->name }}</td>
                <td>{{ $reg->school_origin }}</td>
                <td class="text-center">
                    {{ $attendance ? \Carbon\Carbon::parse($attendance->scanned_at)->format('H:i:s') : '-' }}
                </td>
                <td class="text-center {{ $attendance ? 'status-hadir' : 'status-alpha' }}">
                    {{ $attendance ? 'HADIR' : 'TIDAK' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>