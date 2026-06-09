<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Produk</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .title { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #333; }
        th { background-color: #f2f2f2; padding: 8px; text-align: left; }
        td { padding: 8px; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="title">
        <h2>LAPORAN DATA PRODUK</h2>
        <p>Dicetak pada tanggal: {{ date('d-m-Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">NO</th>
                <th>NAMA PRODUK</th>
                <th>HARGA</th>
                <th style="width: 10%">STOK</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($products as $product)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $product->title }}</td>
                    <td>{{ "Rp " . number_format($product->price, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $product->stock }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Data Produk Kosong</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>