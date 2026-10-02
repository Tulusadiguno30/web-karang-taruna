<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Kas Kartar 0210</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: #333; }
        
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0 0 5px 0; font-size: 16px; text-transform: uppercase; }
        .header h3 { margin: 0 0 5px 0; font-size: 14px; font-weight: normal; }
        .header p { margin: 0; font-size: 10px; font-style: italic; }

        .summary-box { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .summary-box td { border: 1px solid #000; padding: 10px; font-weight: bold; text-align: center; font-size: 12px; width: 33.33%; }
        
        /* Warna background untuk Cetak (Opsional) */
        .bg-in { background-color: #d4edda; }
        .bg-out { background-color: #f8d7da; }
        .bg-balance { background-color: #cce5ff; }

        .section-title { font-size: 12px; font-weight: bold; margin-bottom: 8px; text-transform: uppercase; border-bottom: 1px solid #000; display: inline-block; }
        
        .table-data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table-data th, .table-data td { border: 1px solid #000; padding: 6px; }
        .table-data th { background-color: #e2e8f0; text-align: center; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .footer { margin-top: 30px; width: 100%; text-align: center; font-size: 11px; }
        .footer-left { float: left; width: 50%; }
        .footer-right { float: right; width: 50%; }
        .signature-space { height: 70px; }
        .clear { clear: both; }
    </style>
</head>
<body>

    <!-- KOP LAPORAN -->
    <div class="header">
        <h2>LAPORAN KEUANGAN KAS</h2>
        <h3>KARANG TARUNA 0210 PERUM GRAHA PRIMA</h3>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
    </div>

    <!-- RINGKASAN SALDO -->
    <table class="summary-box">
        <tr>
            <td class="bg-in">
                TOTAL PEMASUKAN<br>
                <span style="font-size: 14px;">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</span>
            </td>
            <td class="bg-out">
                TOTAL PENGELUARAN<br>
                <span style="font-size: 14px;">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</span>
            </td>
            <td class="bg-balance">
                SISA SALDO AKHIR<br>
                <span style="font-size: 14px;">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</span>
            </td>
        </tr>
    </table>

    <!-- TABEL 1: PEMASUKAN -->
    <div class="section-title">A. Rincian Pemasukan Kas</div>
    <table class="table-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="25%">Dari (Sumber/Anggota)</th>
                <th width="35%">Keterangan</th>
                <th width="20%">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kasMasuk as $index => $masuk)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($masuk->created_at)->format('d-m-Y') }}</td>
                <td>{{ $masuk->anggota->nama ?? $masuk->sumber ?? '-' }}</td>
                <td>{{ $masuk->keterangan }}</td>
                <td class="text-right">Rp {{ number_format($masuk->nominal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="font-style: italic;">Tidak ada data pemasukan kas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TABEL 2: PENGELUARAN -->
    <div class="section-title">B. Rincian Pengeluaran Kas</div>
    <table class="table-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="60%">Keterangan Pengeluaran</th>
                <th width="20%">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kasKeluar as $index => $keluar)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($keluar->created_at)->format('d-m-Y') }}</td>
                <td>{{ $keluar->keterangan }}</td>
                <td class="text-right">Rp {{ number_format($keluar->nominal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center" style="font-style: italic;">Tidak ada data pengeluaran kas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- BAGIAN TANDA TANGAN -->
    <div class="footer">
        <div class="footer-left">
            Mengetahui,<br>
            Ketua Karang Taruna<br>
            <div class="signature-space"></div>
            <strong>( M. Dzaki Zahirsyah )</strong>
        </div>
        <div class="footer-right">
            Tambun, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
            Bendahara<br>
            <div class="signature-space"></div>
            <strong>( .................................... )</strong>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>