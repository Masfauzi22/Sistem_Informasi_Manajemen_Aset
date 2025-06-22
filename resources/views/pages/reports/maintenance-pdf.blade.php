<!DOCTYPE html>
<html>

<head>
    <title>Laporan Riwayat Perawatan</title>
    <style>
    body {
        font-family: 'Helvetica', 'Arial', sans-serif;
        font-size: 10pt;
        color: #333;
    }

    .header-table {
        width: 100%;
        border-bottom: 1px solid #333;
        margin-bottom: 20px;
    }

    .header-table .logo {
        width: 80px;
        height: auto;
    }

    .header-table .company-info {
        text-align: right;
    }

    .header-table h1 {
        margin: 0;
        color: #2c3e50;
        font-size: 18pt;
    }

    .header-table p {
        margin: 0;
        font-size: 9pt;
        color: #666;
    }

    .main-table {
        width: 100%;
        border-collapse: collapse;
    }

    .main-table th,
    .main-table td {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 9pt;
        text-align: left;
    }

    .main-table thead {
        background-color: #f2f2f2;
    }

    .main-table th {
        font-weight: bold;
    }

    .main-table .cost {
        text-align: right;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        font-style: italic;
        color: #777;
    }
    </style>
</head>

<body>
    @php
    // Mengubah gambar logo menjadi format base64
    $logoPath = public_path('images/logo-pelindo.png');
    $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
    $logoData = file_get_contents($logoPath);
    $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
    @endphp

    <table class="header-table">
        <tr>
            <td>
                <img src="{{ $logoBase64 }}" alt="Logo" class="logo">
            </td>
            <td class="company-info">
                <h1>Laporan Riwayat Perawatan</h1>
                <p>PT. Pelindo Multi Terminal</p>
                <p>Tanggal Laporan: {{ $date }}</p>
            </td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Aset</th>
                <th>Tipe</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Biaya (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($maintenances as $maintenance)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$maintenance->asset->name}}</td>
                <td>{{$maintenance->type}}</td>
                <td>{{ \Carbon\Carbon::parse($maintenance->maintenance_date)->format('d-m-Y') }}</td>
                <td>{{$maintenance->description}}</td>
                <td class="cost">{{number_format($maintenance->cost ?? 0, 0, ',', '.')}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="no-data">Tidak ada data perawatan yang tersedia.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>