<!DOCTYPE html>
<html>

<head>
    <title>Laporan Aset</title>
    <style>
    body {
        font-family: sans-serif;
    }

    h1 {
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        font-size: 12px;
    }

    thead {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>
    <h1>Laporan Inventaris Aset</h1>
    <p>Tanggal: {{ $date }}</p>
    <hr>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>No. Seri</th>
                <th>Tgl Beli</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($assets as $asset)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $asset->name }}</td>
                <td>{{ $asset->category->name }}</td>
                <td>{{ $asset->location->name }}</td>
                <td>{{ $asset->serial_number ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($asset->purchase_date)->format('d-m-Y') }}</td>
                <td>Rp {{ number_format($asset->purchase_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data aset yang tersedia.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>