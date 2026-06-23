<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Smart Waste Management</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #2d333d; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; color: #2d333d; font-size: 18px; }
        .header p { margin: 4px 0 0 0; color: #777; font-size: 11px; }
        .table { w-full; width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table th { background-color: #2d333d; color: #ffffff; text-align: left; padding: 8px; font-weight: bold; text-transform: uppercase; font-size: 9px; }
        .table td { padding: 8px; border-bottom: 1px solid #eee; }
        .summary-box { margin-top: 20px; float: right; width: 300px; border: 1px solid #ddd; padding: 10px; border-radius: 8px; }
        .summary-item { display: block; margin-bottom: 5px; font-size: 12px; }
        .summary-item strong { color: #2d333d; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Hasil Timbangan Setoran Masuk</h2>
        <p>Sistem Informasi Manajemen Smart Waste Management — Rekapitulasi Data Petugas Lapangan</p>
        <p>Tanggal Cetak Dokumen: {{ now()->translatedFormat('d F Y, H:i') }} Wita</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID Detail</th>
                <th>Waktu Setor</th>
                <th>Nama Nasabah</th>
                <th>Titik Kumpul Drop-Off</th>
                <th>Kategori Sampah</th>
                <th>Berat (Kg)</th>
                <th>Nominal Rupiah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    <td><strong>#DTL-{{ $row->id }}</strong></td>
                    <td>{{ $row->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $row->wasteDeposit->user->name ?? 'Masyarakat Umum' }}</td>
                    <td>{{ $row->wasteDeposit->dropOffPoint->name ?? '-' }}</td>
                    <td>{{ $row->wastePrice->wasteCategory->name ?? '-' }}</td>
                    <td>{{ number_format($row->weight_kg, 2, ',', '.') }} Kg</td>
                    <td style="color: #059669; font-weight: bold;">Rp {{ number_format($row->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <span class="summary-item"><strong>Total Akumulasi Massa:</strong> {{ number_format($totalMassa, 2, ',', '.') }} Kg</span>
        <span class="summary-item"><strong>Total Dana Kas Keluar:</strong> Rp {{ number_format($totalKas, 0, ',', '.') }}</span>
    </div>

</body>
</html>