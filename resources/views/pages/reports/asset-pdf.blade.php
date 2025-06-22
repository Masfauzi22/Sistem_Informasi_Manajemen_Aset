<!DOCTYPE html>
<html>

<head>
    <title>Laporan Inventaris Aset</title>
    <style>
    /* Reset dan Dasar */
    body {
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        margin: 0;
        padding: 20px;
        color: #333;
        font-size: 10pt;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
        display: flex;
        /* Menggunakan flexbox untuk penempatan logo dan teks */
        align-items: center;
        /* Pusatkan item secara vertikal */
        justify-content: center;
        /* Pusatkan item secara horizontal */
        gap: 15px;
        /* Jarak antara logo dan teks */
    }

    .header-content {
        text-align: center;
        /* Pastikan teks di dalam div ini tetap di tengah */
    }

    .header h1 {
        margin: 0;
        font-size: 18pt;
        color: #2c3e50;
    }

    .header p {
        margin: 2px 0;
        font-size: 9pt;
        color: #666;
    }

    .logo {
        max-width: 80px;
        /* Atur lebar maksimal logo */
        height: auto;
        /* Biarkan tinggi menyesuaikan proporsi */
        margin-right: 10px;
        /* Jarak antara logo dan teks header (opsional, jika ingin logo di kiri) */
    }

    hr {
        border: none;
        border-top: 1px solid #ddd;
        margin: 15px 0;
    }

    /* Tabel */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th,
    td {
        border: 1px solid #e0e0e0;
        padding: 8px 10px;
        font-size: 8pt;
        text-align: left;
        vertical-align: top;
    }

    th {
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        padding: 10px 10px;
    }

    /* Warna baris selang-seling */
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Penyelarasan spesifik kolom */
    td:first-child {
        text-align: center;
        width: 30px;
    }

    td:nth-child(7) {
        text-align: right;
        white-space: nowrap;
    }

    /* Tidak ada data */
    .no-data {
        text-align: center;
        padding: 20px;
        color: #777;
        font-style: italic;
    }
    </style>
</head>

<body>
    <div class="header">
        {{-- Pastikan jalur gambar benar dan bisa diakses oleh PDF renderer (misal: Dompdf) --}}
        {{-- Untuk Laravel/Dompdf, gunakan public_path() atau base64 encode gambar --}}
        <img src="{{ public_path('images/logo-pelindo.png') }}" alt="Logo Perusahaan" class="logo">
        <div class="header-content">
            <h1>Laporan Inventaris Aset</h1>
            <p>PT. Pelindo Multi Terminal</p>
            <p>Tanggal Laporan: {{ $date }}</p>

            @if ($startDate && $endDate)
            <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
            @endif
        </div>
    </div>

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
                <th>Harga Beli (Rp)</th>
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
                <td>{{ number_format($asset->purchase_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="no-data">Tidak ada data aset untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>