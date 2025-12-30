<!DOCTYPE html>
<html>
<head>
    <title>Rekap Absensi Event</title>
    <style>
        /* Menggunakan font DejaVu Sans agar simbol Checkmark (✔) terbaca dan tidak jadi tanda tanya (?) */
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 9pt; 
            color: #333;
        }

        /* KOP SURAT */
        .header-container {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        .header-title {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            color: #83218F; /* Warna Ungu IPNU */
        }
        .header-subtitle {
            font-size: 10pt;
            margin: 5px 0;
            font-weight: bold;
        }
        .header-info {
            font-size: 9pt;
            margin: 0;
            color: #555;
        }

        /* TABEL UTAMA */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px 4px;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            font-size: 8pt;
            text-transform: uppercase;
        }
        
        /* Zebra Striping (Baris selang-seling warna) */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Style Kolom */
        .col-no { width: 5%; text-align: center; }
        .col-nama { width: 25%; }
        .col-check { width: 8%; text-align: center; font-size: 10pt; }

        .hadir { color: green; font-weight: bold; }
        .absen { color: #ccc; font-weight: normal; }
        .alpha { color: red; font-weight: bold; font-size: 8pt; }

        /* SUMMARY & TANDA TANGAN */
        .footer-section {
            margin-top: 30px;
            width: 100%;
        }
        .stats-box {
            float: left;
            width: 40%;
            border: 1px solid #ddd;
            padding: 10px;
            background: #fdfdfd;
        }
        .signature-box {
            float: right;
            width: 40%;
            text-align: center;
        }
        .sign-space {
            height: 60px;
        }
        .clear { clear: both; }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="header-container">
        <h1 class="header-title">{{ $event->title }}</h1>
        <p class="header-subtitle">LAPORAN REKAPITULASI ABSENSI PESERTA</p>
        <p class="header-info">
            Lokasi: {{ $event->location }} | 
            Tanggal: {{ \Carbon\Carbon::parse($event->start_time)->isoFormat('D MMMM Y') }}
        </p>
    </div>

    {{-- TABEL MATRIKS ABSENSI --}}
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-nama">Nama Peserta / Delegasi</th>
                
                {{-- Kolom Daftar Ulang --}}
                <th class="col-check" style="background-color: #e6fffa;">Daftar Ulang</th>

                {{-- Loop Kolom Materi --}}
                @foreach($event->schedules as $sched)
                    <th class="col-check" title="{{ $sched->activity }}">
                        {{ Str::limit($sched->activity, 15, '..') }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($event->registrations as $i => $reg)
            <tr>
                <td class="col-no">{{ $i + 1 }}</td>
                <td class="col-nama">
                    <strong>{{ $reg->name }}</strong><br>
                    <span style="font-size: 8pt; color: #555;">{{ $reg->school_origin }}</span>
                </td>
                
                {{-- STATUS DAFTAR ULANG --}}
                <td class="col-check {{ $reg->presence_at ? 'hadir' : 'alpha' }}" style="background-color: {{ $reg->presence_at ? '#f0fff4' : '#fff5f5' }};">
                    {{ $reg->presence_at ? '✔' : 'X' }}
                </td>

                {{-- STATUS PER MATERI --}}
                @foreach($event->schedules as $sched)
                    @php
                        $isPresent = \App\Models\ScheduleAttendance::where('registration_id', $reg->id)
                                    ->where('event_schedule_id', $sched->id)
                                    ->exists();
                    @endphp
                    <td class="col-check {{ $isPresent ? 'hadir' : 'absen' }}">
                        {{ $isPresent ? '✔' : '-' }}
                    </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- FOOTER (Statistik & Tanda Tangan) --}}
    <div class="footer-section">
        
        {{-- Statistik Ringkas --}}
        <div class="stats-box">
            <strong>Statistik Kehadiran:</strong><br>
            <table style="margin-top: 5px; font-size: 8pt; border: none;">
                <tr>
                    <td style="border: none; padding: 2px;">Total Peserta Terdaftar</td>
                    <td style="border: none; padding: 2px;">: {{ $event->registrations->count() }} Orang</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 2px;">Sudah Daftar Ulang</td>
                    <td style="border: none; padding: 2px;">: {{ $event->registrations->whereNotNull('presence_at')->count() }} Orang</td>
                </tr>
            </table>
        </div>

        {{-- Kolom Tanda Tangan --}}
        <div class="signature-box">
            <p>{{ $event->location }}, {{ date('d F Y') }}</p>
            <p>Ketua Panitia,</p>
            <div class="sign-space"></div>
            <p><strong>( ..................................... )</strong></p>
        </div>

        <div class="clear"></div>
    </div>

</body>
</html>