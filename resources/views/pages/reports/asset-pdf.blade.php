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
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .header-content {
        text-align: center;
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
        height: auto;
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

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    td:first-child {
        text-align: center;
        width: 30px;
    }

    td:nth-child(7) {
        text-align: right;
        white-space: nowrap;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        color: #777;
        font-style: italic;
    }
    </style>
</head>

<body>
    @php
    // --- PERBAIKAN DIMULAI DI SINI ---
    // Konversi gambar ke format Base64 untuk di-embed langsung ke HTML.
    // Ini adalah cara paling andal untuk DomPDF.
    $imagePath = public_path('images/logo-pelindo.png');
    $base64Image = '';
    if (file_exists($imagePath)) {
    $fileType = pathinfo($imagePath, PATHINFO_EXTENSION);
    $imageData = base64_encode(file_get_contents($imagePath));
    $base64Image = 'data:image/' . $fileType . ';base64,' . $imageData;
    }
    @endphp

    <div class="header">
        {{-- Tampilkan gambar hanya jika file-nya ada dan berhasil dikonversi --}}
        @if($base64Image)
        <img src="{{ $base64Image }}" alt="Logo Perusahaan" class="logo">
        @endif

        <div class="header-content">
            <h1>Laporan Inventaris Aset</h1>
            <p>PT. Pelindo Multi Terminal</p>
            <p>Tanggal Laporan: {{ $date ?? 'N/A' }}</p>

            @if (isset($startDate) && isset($endDate) && $startDate && $endDate)
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
            @forelse ($assets ?? [] as $asset)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $asset->name ?? 'N/A' }}</td>
                <td>{{ $asset->category->name ?? 'N/A' }}</td>
                <td>{{ $asset->location->name ?? 'N/A' }}</td>
                <td>{{ $asset->serial_number ?? '-' }}</td>
                <td>{{ isset($asset->purchase_date) ? \Carbon\Carbon::parse($asset->purchase_date)->format('d-m-Y') : 'N/A' }}
                </td>
                <td>{{ isset($asset->purchase_price) ? number_format($asset->purchase_price, 0, ',', '.') : '0' }}</td>
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