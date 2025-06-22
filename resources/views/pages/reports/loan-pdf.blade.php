<!DOCTYPE html>
<html>

<head>
    <title>Laporan Riwayat Peminjaman</title>
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
        /* Sedikit margin antar paragraf */
        font-size: 9pt;
        color: #666;
    }

    .logo {
        max-width: 80px;
        /* Atur lebar maksimal logo */
        height: auto;
        /* Biarkan tinggi menyesuaikan proporsi */
        margin-right: 10px;
        /* Jarak antara logo dan teks header (opsional) */
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

    /* Styling Status */
    .status-dipinjam {
        color: #e67e22;
        font-weight: bold;
    }

    .status-kembali {
        color: #27ae60;
        font-weight: bold;
    }

    .status-terlambat {
        color: #e74c3c;
        font-weight: bold;
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
        <img src="{{ public_path('images/logo-pelindo.png') }}" alt="Logo Perusahaan" class="logo">
        <div class="header-content">
            <h1>Laporan Riwayat Peminjaman</h1>
            <p>PT. Pelindo Multi Terminal</p> {{-- Menambahkan nama perusahaan --}}
            <p>Tanggal Laporan: {{ $date }}</p>
        </div>
    </div>

    <hr>
    <table>
        <thead>
            <tr>
                <th>Nama Aset</th>
                <th>Peminjam</th>
                <th>Tgl Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $loan)
            <tr>
                <td>{{$loan->asset->name}}</td>
                <td>{{$loan->user->name}}</td>
                <td>{{$loan->loan_date}}</td>
                <td>{{$loan->due_date}}</td>
                <td>{{$loan->return_date ?? '-'}}</td>
                <td class="status-{{ strtolower(str_replace(' ', '-', $loan->status)) }}">{{$loan->status}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="no-data">Tidak ada data peminjaman yang tersedia.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>