<!DOCTYPE html>
<html>
<head>
    <title>Cetak ID Card Peserta</title>
    <style>
        @page { margin: 10px; }
        body { font-family: sans-serif; margin: 0; padding: 0; }
        
        .container {
            width: 100%;
            text-align: center;
        }

        /* KARTU ID (Ukuran 10cm x 7cm) */
        .card {
            width: 7cm;      /* Lebar ditukar karena Portrait (Model Kalung) */
            height: 10cm;    /* Tinggi */
            border: 1px solid #ddd; /* Border tipis untuk panduan potong */
            display: inline-block;
            margin: 5px;
            position: relative;
            background-color: white;
            vertical-align: top;
            overflow: hidden;
        }

        /* BACKGROUND TEMPLATE */
        .bg-img {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: -1;
        }

        /* FOTO */
        .photo {
            position: absolute;
            top: 57px; left: 73px; /* Sesuaikan koordinat skala cm */
            width: 110px; height: 130px;
            background: #eee;
            border-radius: 10px;
            object-fit: cover;
        }

        /* NAMA */
        .name {
            position: absolute;
            top: 310px; left: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            color: #4a1a68;
            text-transform: uppercase;
        }

        /* DELEGASI */
        .school {
            position: absolute;
            top: 345px; left: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
        }

        /* BARCODE */
        .barcode {
            position: absolute;
            bottom: 70px; left: 20px;
            width: 220px;
            text-align: center;
        }
        .barcode img {
            width: 100%; height: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        @foreach($participants as $p)
            <div class="card">
                <img src="{{ public_path('img/template_idcard.png') }}" class="bg-img">
                
                @if($p->photo_path && file_exists($p->photo_path))
                    <img src="{{ $p->photo_path }}" class="photo">
                @else
                    <div class="photo" style="display:flex;align-items:center;justify-content:center;font-size:40px;color:#83218F;">
                        {{ substr($p->name, 0, 1) }}
                    </div>
                @endif

                <div class="name">{{ Str::limit($p->name, 20) }}</div>
                <div class="school">{{ Str::limit($p->school_origin, 25) }}</div>

                <div class="barcode">
                    <img src="data:image/png;base64,{{ $p->barcode }}">
                    <div style="font-size:8px; margin-top:2px;">{{ $p->id }}</div>
                </div>
            </div>
            
            @if(($loop->index + 1) % 9 == 0)
                <div style="page-break-after: always;"></div>
            @endif
        @endforeach
    </div>
</body>
</html>