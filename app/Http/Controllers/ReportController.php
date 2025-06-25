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
            // --- KODE DIAGNOSTIK DIMULAI DI SINI ---
            $query = Asset::with(['category', 'location'])
                ->where('status', '!=', 'Menunggu Persetujuan');

            if ($categoryId) $query->where('category_id', $categoryId);
            if ($locationId) $query->where('location_id', $locationId);
            if ($startDate && $endDate) $query->whereBetween('purchase_date', [$startDate, $endDate]);

            // Ambil semua aset untuk diuji satu per satu
            $allAssets = $query->get();

            echo "<h1>Memulai Pengujian " . count($allAssets) . " Aset...</h1>";

            foreach ($allAssets as $index => $singleAsset) {
                echo "<strong>Menguji Aset ke-" . ($index + 1) . " (ID: " . $singleAsset->id . ") - " . $singleAsset->name . "</strong>... ";

                $testData = $data;
                $collection = new Collection([$singleAsset]);
                $testData['assets'] = $this->cleanDataRecursively($collection);

                try {
                    // Coba render PDF di memori tanpa menampilkannya
                    PDF::loadView('pages.reports.asset-pdf', $testData)->render();
                    echo "<span style='color:green;'>AMAN</span><br>";
                } catch (\Exception $e) {
                    // JIKA GAGAL, KITA MENEMUKAN PENYEBABNYA!
                    echo "<hr><h1><span style='color:red;'>ERROR DITEMUKAN PADA ASET INI!</span></h1>";
                    echo "<h3>Penyebab error `iconv()` kemungkinan besar ada pada data di bawah ini:</h3>";
                    echo "<h4>Data Aset:</h4>";
                    dump($singleAsset->toArray());
                    echo "<h4>Data Kategori Terkait:</h4>";
                    dump($singleAsset->category->toArray());
                    echo "<h4>Data Lokasi Terkait:</h4>";
                    dump($singleAsset->location->toArray());
                    exit; // Hentikan proses
                }
            }

            // Jika semua aset berhasil diuji tanpa error
            echo "<hr><h1><span style='color:blue;'>Luar Biasa! Semua aset berhasil diproses tanpa error.</span></h1>";
            echo "<p>Jika Anda melihat pesan ini, berarti masalahnya sangat-sangat aneh dan bukan disebabkan oleh data individual.</p>";
            exit;
            
        } else {
            // Untuk laporan lain, biarkan seperti biasa
            return "Silakan uji Laporan Inventaris Aset.";
        }
    }
}