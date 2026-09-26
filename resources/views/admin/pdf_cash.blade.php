<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan Kas Karang Taruna</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 2px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .summary { margin-top: 20px; width: 40%; float: right; }
        .badge-in { color: green; font-weight: bold; }
        .badge-out { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>KARANG TARUNA {{ strtoupper($settings['site_title'] ?? 'PEMUDA MANDIRI') }}</h2>
        <p>Laporan Transaksi Keuangan Kas Organisasi</p>
        <p>Dicetak pada: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Keterangan</th>
                <th>Kategori</th>
                <th class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cashes as $index => $cash)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($cash->transaction_date)->format('d/m/Y') }}</td>
                <td>
                    <span class="{{ $cash->type == 'in' ? 'badge-in' : 'badge-out' }}">
                        {{ $cash->type == 'in' ? 'Pemasukan' : 'Pengeluaran' }}
                    </span>
                </td>
                <td>{{ $cash->title }}</td>
                <td>{{ $cash->category }}</td>
                <td class="text-right">Rp {{ number_format($cash->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <table>
            <tr>
                <td>Total Pemasukan</td>
                <td class="text-right badge-in">Rp {{ number_format($totalIn, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Pengeluaran</td>
                <td class="text-right badge-out">Rp {{ number_format($totalOut, 0, ',', '.') }}</td>
            </tr>
            <tr style="font-weight: bold; background-color: #f9f9f9;">
                <td>Saldo Akhir Kas</td>
                <td class="text-right">Rp {{ number_format($balance, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>