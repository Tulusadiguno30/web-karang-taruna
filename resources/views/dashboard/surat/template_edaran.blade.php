<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Edaran Karang Taruna</title>
    <style>
        @page { margin: 2.5cm 2.5cm 2.5cm 3cm; }
        body { font-family: "Times New Roman", Times, serif; font-size: 12pt; line-height: 1.5; color: #000; }
        
        /* Kop Surat Karang Taruna */
        .kop-surat { text-align: center; }
        .kop-surat h2 { margin: 0; font-size: 14pt; font-weight: normal; text-transform: uppercase; letter-spacing: 1px;}
        .kop-surat h1 { margin: 0; font-size: 18pt; font-weight: bold; text-transform: uppercase; color: #000; letter-spacing: 1px;}
        .kop-surat p { margin: 3px 0 0 0; font-size: 10pt; font-style: italic; }
        
        .garis-tebal { border-bottom: 3px solid #000; margin-top: 10px; }
        .garis-tipis { border-bottom: 1px solid #000; margin-top: 2px; margin-bottom: 20px; }

        .tabel-header { width: 100%; margin-bottom: 25px; border-collapse: collapse; }
        .tabel-header td { vertical-align: top; }
        
        .isi-surat { text-align: justify; margin-bottom: 15px; }
        .tabel-rincian { width: 85%; margin: 15px auto; border-collapse: collapse; }
        .tabel-rincian td { padding: 3px 0; vertical-align: top; }

        .ttd-container { width: 100%; margin-top: 40px; }
        .ttd-box { float: right; width: 250px; text-align: center; }
        .ttd-clear { clear: both; }
    </style>
</head>
<body>
    <!-- KOP SURAT KARANG TARUNA -->
    <div class="kop-surat">
        <h2>PENGURUS ORGANISASI KEPEMUDAAN</h2>
        <h1>KARANG TARUNA 0210</h1>
        <h2>PERUM GRAHA PRIMA BLOK IE</h2>
        <p>RT. 002 / RW. 010, Desa Satria Jaya, Kec. Tambun Utara, Kab. Bekasi 17510</p>
        <p style="font-size: 9pt;">Email: kartar0210@gmail.com | Instagram: @kartar_graha0210</p>
    </div>
    <div class="garis-tebal"></div>
    <div class="garis-tipis"></div>

    <table class="tabel-header">
        <tr>
            <td width="12%">Nomor</td><td width="3%">:</td><td width="45%">{{ $data['nomor_surat'] }}</td>
            <td width="40%" style="text-align: right;">Tambun, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Lampiran</td><td>:</td><td>-</td>
            <td></td>
        </tr>
        <tr>
            <td>Perihal</td><td>:</td><td><strong>{{ $data['perihal'] }}</strong></td>
            <td></td>
        </tr>
    </table>

    <p class="isi-surat" style="margin-bottom: 20px;">
        Kepada Yth,<br>
        <strong>{{ $data['kepada'] }}</strong><br>
        Di Tempat
    </p>

    <p class="isi-surat">{{ $data['isi_pembuka'] }}</p>

    <table class="tabel-rincian">
        <tr>
            <td width="30%">Hari, Tanggal</td><td width="5%">:</td>
            <td width="65%"><strong>{{ $data['hari_tanggal'] }}</strong></td>
        </tr>
        <tr>
            <td>Waktu</td><td>:</td>
            <td>{{ $data['waktu'] }}</td>
        </tr>
        <tr>
            <td>Tempat</td><td>:</td>
            <td>{{ $data['tempat'] }}</td>
        </tr>
    </table>

    <p class="isi-surat">{{ $data['isi_penutup'] }}</p>

    <div class="ttd-container">
        <div class="ttd-box">
            Ketua Karang Taruna 0210<br><br><br><br><br>
            <strong>( {{ auth()->user()->name ?? '............................................' }} )</strong>
        </div>
        <div class="ttd-clear"></div>
    </div>
</body>
</html>