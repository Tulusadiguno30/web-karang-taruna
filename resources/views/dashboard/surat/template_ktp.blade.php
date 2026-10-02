<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar KTP - {{ $data['nama_warga'] }}</title>
    <style>
        @page { margin: 2.5cm 2.5cm 2.5cm 3cm; } /* Margin standar dinas */
        body { font-family: "Times New Roman", Times, serif; font-size: 12pt; line-height: 1.5; color: #000; }
        
        /* Kop Surat Resmi */
        .kop-surat { text-align: center; }
        .kop-surat h2 { margin: 0; font-size: 14pt; font-weight: normal; text-transform: uppercase; letter-spacing: 1px; }
        .kop-surat h1 { margin: 0; font-size: 16pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .kop-surat p { margin: 5px 0 0 0; font-size: 10pt; font-style: italic; }
        
        /* Garis Ganda Kop Surat */
        .garis-tebal { border-bottom: 3px solid #000; margin-top: 10px; }
        .garis-tipis { border-bottom: 1px solid #000; margin-top: 2px; margin-bottom: 25px; }

        /* Judul Surat */
        .judul-surat { text-align: center; margin-bottom: 20px; }
        .judul-surat span { text-decoration: underline; font-weight: bold; font-size: 13pt; letter-spacing: 1px; }
        .judul-surat p { margin: 2px 0 0 0; font-size: 11pt; }

        /* Isi Surat */
        .isi-surat { text-align: justify; text-indent: 40px; margin-bottom: 15px; }
        
        /* Tabel Data */
        .tabel-data { width: 90%; margin: 0 auto 20px auto; border-collapse: collapse; }
        .tabel-data td { vertical-align: top; padding: 4px 0; }
        
        /* Tanda Tangan */
        .ttd-container { width: 100%; margin-top: 40px; }
        .ttd-box { float: right; width: 250px; text-align: center; }
        .ttd-clear { clear: both; }
    </style>
</head>
<body>
    <!-- KOP SURAT -->
    <div class="kop-surat">
        <h2>PEMERINTAH KABUPATEN BEKASI</h2>
        <h2>KECAMATAN TAMBUN UTARA</h2>
        <h2>DESA SATRIA JAYA</h2>
        <h1>PENGURUS RT.002 / RW.010</h1>
        <h1>PERUM GRAHA PRIMA</h1>
        <p>Sekretariat: Perum Graha Prima Blok IE, RT. 002 / RW. 010, Kec. Tambun Utara 17510</p>
    </div>
    <div class="garis-tebal"></div>
    <div class="garis-tipis"></div>

    <!-- JUDUL SURAT -->
    <div class="judul-surat">
        <span>SURAT PENGANTAR RT/RW</span>
        <p>Nomor: {{ $data['nomor_surat'] }}</p>
    </div>

    <!-- ISI SURAT -->
    <p class="isi-surat">Yang bertanda tangan di bawah ini Ketua RT. 002 / RW. 010, Perum Graha Prima, Desa Satria Jaya, Kecamatan Tambun Utara, Kabupaten Bekasi, menerangkan dengan sesungguhnya bahwa:</p>

    <table class="tabel-data">
        <tr>
            <td width="30%">Nama Lengkap</td>
            <td width="5%">:</td>
            <td width="65%"><strong>{{ strtoupper($data['nama_warga']) }}</strong></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $data['nik'] }}</td>
        </tr>
        <tr>
            <td>Tempat, Tgl Lahir</td>
            <td>:</td>
            <td>{{ $data['tempat_lahir'] }}, {{ \Carbon\Carbon::parse($data['tanggal_lahir'])->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $data['jenis_kelamin'] }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $data['agama'] }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $data['pekerjaan'] }}</td>
        </tr>
    </table>

    <p class="isi-surat">Nama tersebut di atas adalah benar warga kami yang berdomisili di lingkungan RT. 002 / RW. 010. Surat pengantar ini dibuat sebagai kelengkapan persyaratan administrasi untuk keperluan: <strong>{{ strtoupper($data['keperluan']) }}</strong>.</p>
    
    <p class="isi-surat">Demikian surat pengantar ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya oleh instansi yang berwenang.</p>

    <!-- TANDA TANGAN -->
    <div class="ttd-container">
        <div class="ttd-box">
            Tambun Utara, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
            Ketua RT. 002 / RW. 010<br><br><br><br><br>
            <strong>( ............................................ )</strong>
        </div>
        <div class="ttd-clear"></div>
    </div>
</body>
</html>