<!DOCTYPE html>
<html>
<head>
    <title>Rekap Absensi - {{ $event->title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 2px 0; color: #555; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .center { text-align: center; }
        
        /* CLASS PENTING UNTUK PISAH HALAMAN */
        .page-break { page-break-after: always; }

        .category-title {
            background-color: #83218F; /* Warna Khas */
            color: white;
            padding: 5px 10px;
            font-weight: bold;
            margin-bottom: 10px;
            border-radius: 4px;
            display: inline-block;
        }
        .signature-box { height: 30px; }
    </style>
</head>
<body>

    {{-- LOGIC PEMISAHAN DATA --}}
    @php
        $pesertaIpnu = $event->registrations->where('gender', 'L')->sortBy('name');
        $pesertaIppnu = $event->registrations->where('gender', 'P')->sortBy('name');
    @endphp

    {{-- ================= HALAMAN 1: IPNU ================= --}}
    <div class="header">
        <h2>DAFTAR HADIR PESERTA</h2>
        <p><strong>{{ $event->title }}</strong></p>
        <p>{{ \Carbon\Carbon::parse($event->event_date)->isoFormat('D MMMM Y') }} | {{ $event->location }}</p>
    </div>

    <div class="category-title" style="background-color: #0d6efd;">KHUSUS IPNU (REKAN)</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Lengkap</th>
                <th width="30%">Asal Sekolah / Instansi</th>
                <th width="15%">Waktu Hadir</th>
                <th width="15%">Paraf</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesertaIpnu as $index => $p)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->school_origin }}</td>
                <td class="center">
                    @if($p->presence_at)
                        {{ \Carbon\Carbon::parse($p->presence_at)->format('H:i') }}
                    @else
                        -
                    @endif
                </td>
                <td class="signature-box"></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="center">Tidak ada peserta IPNU.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- PEMISAH HALAMAN OTOMATIS --}}
    <div class="page-break"></div>


    {{-- ================= HALAMAN 2: IPPNU ================= --}}
    <div class="header">
        <h2>DAFTAR HADIR PESERTA</h2>
        <p><strong>{{ $event->title }}</strong></p>
        <p>{{ \Carbon\Carbon::parse($event->event_date)->isoFormat('D MMMM Y') }} | {{ $event->location }}</p>
    </div>

    <div class="category-title" style="background-color: #d63384;">KHUSUS IPPNU (REKANITA)</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Lengkap</th>
                <th width="30%">Asal Sekolah / Instansi</th>
                <th width="15%">Waktu Hadir</th>
                <th width="15%">Paraf</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesertaIppnu as $index => $p)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->school_origin }}</td>
                <td class="center">
                    @if($p->presence_at)
                        {{ \Carbon\Carbon::parse($p->presence_at)->format('H:i') }}
                    @else
                        -
                    @endif
                </td>
                <td class="signature-box"></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="center">Tidak ada peserta IPPNU.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>