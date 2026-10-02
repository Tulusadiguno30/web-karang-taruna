<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Ronda - {{ $periode }}</title>
    <style>
        @page {
            margin: 1cm; /* Margin yang sempit agar muat banyak */
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px; /* Ukuran font dikecilkan agar muat */
            color: #000;
        }
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 2px;
        }
        .sub-title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        /* Gaya Tabel Utama */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
            margin-bottom: 15px;
        }
        
        /* Garis antar sel */
        .main-table th, .main-table td {
            border: 1px solid #000;
            padding: 3px 4px;
            vertical-align: middle;
        }
        
        /* Header Tanggal */
        .header-tanggal {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            padding: 5px;
        }

        /* Kolom Nomor Urut */
        .col-no {
            width: 3%;
            text-align: center;
            font-weight: bold;
        }
        
        /* Kolom Nama */
        .col-nama {
            width: 14%; /* Disesuaikan agar nama panjang tidak turun baris */
        }
        
        /* Kolom Blok */
        .col-blok {
            width: 8%;
            text-align: center;
            font-weight: bold;
        }

        .footer-container {
            width: 100%;
            margin-top: 20px;
        }
        .catatan {
            float: left;
            width: 60%;
            font-size: 10px;
        }
        .catatan p {
            margin: 0 0 5px 0;
            font-weight: bold;
        }
        .catatan ol {
            margin: 0;
            padding-left: 15px;
        }
        .catatan li {
            margin-bottom: 4px;
        }
        .ttd-box {
            float: right;
            width: 35%;
            text-align: center;
            font-size: 11px;
        }
        .signature-space {
            height: 60px;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    <div class="header-title">JADWAL RONDA RT.002 RW.010</div>
    <div class="sub-title">PERUM GRAHA PRIMA</div>

    @php
        // 1. Ambil semua kunci tanggal (Misal ada 12 hari Sabtu)
        $tanggalKeys = $jadwal->keys();
        
        // 2. Pecah tanggal menjadi kelompok per 4 kolom per baris utama
        $chunkedTanggal = $tanggalKeys->chunk(4);
    @endphp

    @foreach($chunkedTanggal as $rowTanggal)
    <table class="main-table">
        <!-- BARIS HEADER TANGGAL -->
        <tr>
            @foreach($rowTanggal as $tgl)
                <th colspan="3" class="header-tanggal">
                    TGL. {{ \Carbon\Carbon::parse($tgl)->format('d-m-Y') }}
                </th>
            @endforeach
            <!-- Jika jadwal sisa kurang dari 4, buat header kosong penyeimbang -->
            @for($i = count($rowTanggal); $i < 4; $i++)
                <th colspan="3" class="header-tanggal">&nbsp;</th>
            @endfor
        </tr>

        <!-- BARIS DATA WARGA (Looping 1 sampai 10) -->
        @for($i = 0; $i < 10; $i++)
        <tr>
            @foreach($rowTanggal as $tgl)
                @php
                    // Ambil orang ke-$i di tanggal ini
                    $wargaRonda = $jadwal[$tgl]->get($i);
                @endphp
                
                @if($wargaRonda)
                    <td class="col-no">{{ $i + 1 }}</td>
                    <td class="col-nama">{{ $wargaRonda->warga->nama }}</td>
                    <td class="col-blok">{{ $wargaRonda->warga->blok_rumah }}</td>
                @else
                    <!-- Jika kelompok ini orangnya kurang dari 10, tampilkan baris kosong -->
                    <td class="col-no">{{ $i + 1 }}</td>
                    <td class="col-nama">&nbsp;</td>
                    <td class="col-blok">&nbsp;</td>
                @endif
            @endforeach
            
            <!-- Kolom penyeimbang jika grup tanggal kurang dari 4 -->
            @for($j = count($rowTanggal); $j < 4; $j++)
                <td class="col-no">{{ $i + 1 }}</td>
                <td class="col-nama">&nbsp;</td>
                <td class="col-blok">&nbsp;</td>
            @endfor
        </tr>
        @endfor
    </table>
    @endforeach

    <!-- BAGIAN BAWAH (Catatan & TTD) -->
    <div class="footer-container">
        <div class="catatan">
            <p>NB :</p>
            <ol>
                <li>Bagi warga yang tidak hadir dikenakan biaya administrasi sebesar Rp. 50.000</li>
                <li>Ronda dimulai pada pukul 23.00 s/d 04.00</li>
                <li>Mohon maaf apabila ada salah tulis nama, gelar dan alamat</li>
                <li>Bagi warga yang tidak hadir harap cari penggantinya / tidak boleh tukar jaga minggu depan kecuali sakit</li>
            </ol>
        </div>
        <div class="ttd-box">
            Mengetahui,<br><br>
            Ketua RT.002 RW.010<br>
            <div class="signature-space"></div>
            <strong>( BAMBANG SUPRAYITNO )</strong>
        </div>
        <div class="clear"></div>
    </div>

    <!-- TTD Tambahan Pojok Kanan Bawah Sesuai Kertas -->
    <div style="width: 35%; float: right; text-align: center; font-size: 11px; margin-top: -80px;">
        Tambun, {{ \Carbon\Carbon::now()->translatedFormat('d-m-Y') }}<br><br>
        Bidang Keamanan<br>
        <div class="signature-space"></div>
        <strong>( PUJI PRIYO )</strong><br>
        KHARIM<br>
        Security RT.02/10
    </div>
    
</body>
</html>