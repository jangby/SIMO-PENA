<!DOCTYPE html>
<html>
<head>
    <title>Absensi Materi - {{ $schedule->activity }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #83218F; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; color: #333; }
        .header p { margin: 2px 0; color: #555; }
        .meta-info { margin-bottom: 15px; font-size: 11px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #444; padding: 6px 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .center { text-align: center; }
        
        /* Pemisah Halaman */
        .page-break { page-break-after: always; }

        .category-label {
            display: inline-block;
            padding: 5px 10px;
            color: white;
            font-weight: bold;
            margin-bottom: 10px;
            border-radius: 4px;
            font-size: 11px;
        }
        .status-hadir { color: green; font-weight: bold; }
        .status-alfa { color: red; font-style: italic; }
    </style>
</head>
<body>

    {{-- LOGIC: Filter Peserta & Ambil Data Hadir --}}
    @php
        // Ambil semua peserta dari event terkait jadwal ini
        $pesertaIpnu = $schedule->event->registrations->where('gender', 'L')->sortBy('name');
        $pesertaIppnu = $schedule->event->registrations->where('gender', 'P')->sortBy('name');

        // Ambil ID peserta yang sudah scan di jadwal ini
        $hadirIds = $schedule->attendances->pluck('registration_id')->toArray();
    @endphp

    {{-- ================= HALAMAN 1: IPNU ================= --}}
    
    <div class="header">
        <h2>PRESENSI MATERI / JADWAL</h2>
        <p><strong>{{ $schedule->event->title }}</strong></p>
    </div>

    <div class="meta-info">
        <table style="border: none; width: 100%;">
            <tr>
                <td style="border: none; width: 15%;"><strong>Materi/Kegiatan</strong></td>
                <td style="border: none;">: {{ $schedule->activity }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Waktu</strong></td>
                <td style="border: none;">: {{ \Carbon\Carbon::parse($schedule->start_time)->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</td>
            </tr>
            @if($schedule->pic)
            <tr>
                <td style="border: none;"><strong>Pemateri/PIC</strong></td>
                <td style="border: none;">: {{ $schedule->pic }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="category-label" style="background-color: #0d6efd;">KHUSUS IPNU (REKAN)</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Lengkap</th>
                <th width="30%">Asal Sekolah</th>
                <th width="15%">Status</th>
                <th width="15%">Waktu Scan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesertaIpnu as $p)
                @php
                    // Cek apakah ID peserta ini ada di daftar hadir jadwal ini
                    $isPresent = in_array($p->id, $hadirIds);
                    $scanTime = $isPresent ? $schedule->attendances->where('registration_id', $p->id)->first()->scanned_at : null;
                @endphp
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->school_origin }}</td>
                <td class="center">
                    @if($isPresent)
                        <span class="status-hadir">HADIR</span>
                    @else
                        <span class="status-alfa">TIDAK</span>
                    @endif
                </td>
                <td class="center">
                    {{ $scanTime ? \Carbon\Carbon::parse($scanTime)->format('H:i') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="center">Tidak ada data peserta IPNU.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- PEMISAH HALAMAN --}}
    <div class="page-break"></div>

    {{-- ================= HALAMAN 2: IPPNU ================= --}}

    <div class="header">
        <h2>PRESENSI MATERI / JADWAL</h2>
        <p><strong>{{ $schedule->event->title }}</strong></p>
    </div>

    <div class="meta-info">
        <table style="border: none; width: 100%;">
            <tr>
                <td style="border: none; width: 15%;"><strong>Materi/Kegiatan</strong></td>
                <td style="border: none;">: {{ $schedule->activity }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Waktu</strong></td>
                <td style="border: none;">: {{ \Carbon\Carbon::parse($schedule->start_time)->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</td>
            </tr>
        </table>
    </div>

    <div class="category-label" style="background-color: #d63384;">KHUSUS IPPNU (REKANITA)</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Lengkap</th>
                <th width="30%">Asal Sekolah</th>
                <th width="15%">Status</th>
                <th width="15%">Waktu Scan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesertaIppnu as $p)
                @php
                    $isPresent = in_array($p->id, $hadirIds);
                    $scanTime = $isPresent ? $schedule->attendances->where('registration_id', $p->id)->first()->scanned_at : null;
                @endphp
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->school_origin }}</td>
                <td class="center">
                    @if($isPresent)
                        <span class="status-hadir">HADIR</span>
                    @else
                        <span class="status-alfa">TIDAK</span>
                    @endif
                </td>
                <td class="center">
                    {{ $scanTime ? \Carbon\Carbon::parse($scanTime)->format('H:i') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="center">Tidak ada data peserta IPPNU.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>