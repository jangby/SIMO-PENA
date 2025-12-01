<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>ID Card - {{ $registration->name }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Roboto:wght@400;500;700&display=swap');

        body {
            background: #e5e7eb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        /* Container Utama ID Card */
        .id-card-wrapper {
            position: relative;
            width: 800px; /* Resolusi Tinggi agar tidak pecah saat print */
            height: 1131px; /* Disesuaikan dengan rasio gambar A4/Portrait */
            background-color: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        /* Gambar Background Template */
        .bg-template {
            width: 100%;
            height: 100%;
            object-fit: fill;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        /* --- AREA KONTEN (MENUMPANG DI ATAS BACKGROUND) --- */
        
        /* 1. Foto Peserta */
        .photo-area {
            position: absolute;
            z-index: 2;
            /* Koordinat (Sesuaikan jika kurang pas) */
            top: 185px; 
            left: 50%;
            transform: translateX(-50%);
            /* Ukuran Kotak Putih di Desain */
            width: 330px; 
            height: 390px; 
            background: #ddd;
            border-radius: 25px; /* Melengkung sesuai desain */
            overflow: hidden;
        }
        .photo-area img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* 2. Nama Lengkap */
        .name-area {
            position: absolute;
            z-index: 2;
            top: 650px; /* Posisi Vertikal Garis Nama */
            left: 0;
            width: 100%;
            text-align: center;
            padding: 0 50px; /* Padding kiri kanan agar tidak mentok */
            box-sizing: border-box;
        }
        .name-text {
            font-family: 'Oswald', sans-serif; /* Font agak tegas */
            font-size: 32px;
            font-weight: bold;
            color: #4a1a68; /* Warna Ungu Tua sesuai tema */
            text-transform: uppercase;
            letter-spacing: 1px;
            background: transparent;
            border: none;
            width: 100%;
            text-align: center;
        }

        /* 3. Delegasi (Sekolah) */
        .delegasi-area {
            position: absolute;
            z-index: 2;
            top: 757px; /* Posisi Vertikal Garis Delegasi */
            left: 0;
            width: 100%;
            text-align: center;
            padding: 0 50px;
            box-sizing: border-box;
        }
        .delegasi-text {
            font-family: 'Roboto', sans-serif;
            font-size: 24px;
            font-weight: 500;
            color: #333;
        }

        /* 4. Barcode Area */
        .barcode-area {
            position: absolute;
            z-index: 2;
            /* Koordinat Kotak Bawah */
            top: 845px; 
            left: 50%;
            transform: translateX(-50%);
            width: 480px; /* Lebar area barcode */
            height: 80px;
            display: flex;
            flex-col-reverse: column;
            align-items: center;
            justify-content: center;
            /* background: rgba(255, 255, 255, 0.5); Optional: debug area */
        }
        .barcode-img {
            width: 100%;
            height: 100%;
            opacity: 0.9;
        }
        .barcode-code {
            font-size: 14px;
            letter-spacing: 5px;
            margin-top: 5px;
            font-weight: bold;
            color: #4a1a68;
        }

        /* Tombol Print (Tidak ikut tercetak) */
        .action-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 100;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 50px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .btn-print { background: #83218F; color: white; }
        .btn-back { background: white; color: #333; }

        @media print {
            body { background: white; -webkit-print-color-adjust: exact; }
            .action-buttons { display: none; }
            .id-card-wrapper { box-shadow: none; margin: 0; page-break-after: always; }
            @page { margin: 0; size: auto; }
        }
    </style>
</head>
<body>

    <div class="id-card-wrapper">
        <img src="{{ asset('img/template_idcard.png') }}" class="bg-template" alt="Background ID Card">

        <div class="photo-area">
            @if(Auth::user()->profile && Auth::user()->profile->photo)
                <img src="{{ asset('storage/' . Auth::user()->profile->photo) }}" alt="Foto Peserta">
            @else
                <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#f3e8f5; color:#83218F; font-size:100px; font-weight:bold;">
                    {{ substr($registration->name, 0, 1) }}
                </div>
            @endif
        </div>

        <div class="name-area">
            <div class="name-text">{{ $registration->name }}</div>
        </div>

        <div class="delegasi-area">
            <div class="delegasi-text">{{ $registration->school_origin }}</div>
        </div>

        <div class="barcode-area">
            <img src="data:image/png;base64,{{ $barcodeBase64 }}" class="barcode-img">
            <div class="barcode-code">{{ $registration->id }}</div>
        </div>

    </div>

    <div class="action-buttons">
        <a href="{{ route('my-events.show', $registration->id) }}" class="btn btn-back">Kembali</a>
        <button onclick="window.print()" class="btn btn-print">Cetak ID Card</button>
    </div>

</body>
</html>