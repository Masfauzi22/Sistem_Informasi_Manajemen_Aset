<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Loan;
use App\Models\Maintenance;
use App\Models\Category;
use App\Models\Location;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class ReportController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('pages.reports.index', compact('categories', 'locations'));
    }

    private function cleanDataRecursively(&$data)
    {
        if ($data instanceof Collection) {
            $data->transform(fn($item) => $this->cleanDataRecursively($item));
        } elseif (is_array($data) || is_object($data)) {
            foreach ($data as &$value) {
                $this->cleanDataRecursively($value);
            }
        } elseif (is_string($data)) {
            $data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        }
        return $data;
    }

    public function generate(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
            'category_id' => 'nullable|exists:categories,id',
            'location_id' => 'nullable|exists:locations,id',
        ]);

        $reportType = $request->input('report_type');
        
        // ====================================================================
        // BLOK BARU KHUSUS UNTUK PENGECEKAN DATA
        // ====================================================================
        if ($reportType === 'check_all_data') {
            set_time_limit(300);
            echo "<style>body { font-family: monospace; white-space: pre; line-height: 1.5; color: #333; background-color: #f7f7f7; padding: 20px; } h2 { border-bottom: 1px solid #ccc; padding-bottom: 5px; } .ok { color: green; } .error { color: red; font-weight: bold; } </style>";
            echo "<h1>Memulai Pengecekan Encoding Seluruh Data...</h1>";
            $errorFound = false;
            $validateRow = function ($modelName, $item) use (&$errorFound) {
                foreach ($item->getAttributes() as $key => $value) {
                    if (is_string($value) && !mb_check_encoding($value, 'UTF-8')) {
                        echo "<div class='error'>---> ERROR: Karakter tidak valid ditemukan di tabel '". $modelName ."', ID: ". $item->id .", kolom: '". $key ."'</div>";
                        dump($item->toArray());
                        $errorFound = true;
                    }
                }
            };
            
            echo "<h2>Mengecek Tabel: assets</h2>";
            foreach (Asset::cursor() as $asset) { $validateRow('assets', $asset); }
            echo "<span class='ok'>Pengecekan tabel assets selesai.</span>\n\n";

            echo "<h2>Mengecek Tabel: categories</h2>";
            foreach (Category::cursor() as $category) { $validateRow('categories', $category); }
            echo "<span class='ok'>Pengecekan tabel categories selesai.</span>\n\n";

            echo "<h2>Mengecek Tabel: locations</h2>";
            foreach (Location::cursor() as $location) { $validateRow('locations', $location); }
            echo "<span class='ok'>Pengecekan tabel locations selesai.</span>\n\n";

            if ($errorFound) {
                echo "<h1><span class='error'>PENGECEKAN SELESAI.</span> Ditemukan data beracun. Silakan perbaiki data yang ditandai ERROR di atas dengan mengetik ulang isinya di database.</h1>";
            } else {
                echo "<h1><span class='ok'>SELAMAT!</span> Tidak ditemukan masalah encoding pada semua data di tabel assets, categories, dan locations.</h1>";
            }
            // Hentikan eksekusi setelah pengecekan selesai
            exit;
        }

        // ====================================================================
        // Kode Laporan Normal (yang sudah kita perbaiki)
        // ====================================================================
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $categoryId = $request->input('category_id');
        $locationId = $request->input('location_id');
        
        $categoryName = $categoryId ? Category::find($categoryId)?->name : null;
        $locationName = $locationId ? Location::find($locationId)?->name : null;

        $data = [
            'date' => date('d/m/Y'),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'categoryName' => $categoryName,
            'locationName' => $locationName,
        ];
        $this->cleanDataRecursively($data);

        if ($reportType === 'all_assets') {
            $query = Asset::with(['category', 'location'])
                ->where('status', '!=', 'Menunggu Persetujuan');

            if ($categoryId) $query->where('category_id', $categoryId);
            if ($locationId) $query->where('location_id', $locationId);
            if ($startDate && $endDate) $query->whereBetween('purchase_date', [$startDate, $endDate]);

            $assets = $query->get();
            $data['assets'] = $this->cleanDataRecursively($assets);

            $pdf = PDF::loadView('pages.reports.asset-pdf', $data);
            return $pdf->stream('laporan-inventaris-aset.pdf');

        } elseif ($reportType === 'loan_history') {
            // ... (kode laporan pinjaman Anda yang sudah benar)
            $query = Loan::with(['user', 'asset.location', 'asset.category']);
            if ($categoryId) $query->whereHas('asset', fn($q) => $q->where('category_id', $categoryId));
            if ($locationId) $query->whereHas('asset', fn($q) => $q->where('location_id', $locationId));
            if ($startDate && $endDate) $query->whereBetween('loan_date', [$startDate, $endDate]);
            $loans = $query->latest()->get();
            $data['loans'] = $this->cleanDataRecursively($loans);
            $pdf = PDF::loadView('pages.reports.loan-pdf', $data);
            return $pdf->stream('laporan-riwayat-peminjaman.pdf');

        } elseif ($reportType === 'maintenance_history') {
            // ... (kode laporan perawatan Anda yang sudah benar)
            $query = Maintenance::with(['asset.location', 'asset.category']);
            if ($categoryId) $query->whereHas('asset', fn($q) => $q->where('category_id', $categoryId));
            if ($locationId) $query->whereHas('asset', fn($q) => $q->where('location_id', $locationId));
            if ($startDate && $endDate) $query->whereBetween('maintenance_date', [$startDate, $endDate]);
            $maintenances = $query->latest()->get();
            $data['maintenances'] = $this->cleanDataRecursively($maintenances);
            $pdf = PDF::loadView('pages.reports.maintenance-pdf', $data);
            return $pdf->stream('laporan-riwayat-perawatan.pdf');
        }

        return redirect()->back()->with('error', 'Jenis laporan tidak valid.');
    }
}