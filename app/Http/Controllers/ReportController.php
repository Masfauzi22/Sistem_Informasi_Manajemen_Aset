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

    /**
     * Membersihkan data secara rekursif MENGGUNAKAN ICONV,
     * fungsi yang sama yang menyebabkan error, tapi dengan mode "IGNORE"
     * untuk membuang karakter yang bermasalah.
     */
    private function cleanDataRecursively(&$data)
    {
        if ($data instanceof Collection) {
            $data->transform(fn($item) => $this->cleanDataRecursively($item));
        } elseif (is_array($data) || is_object($data)) {
            foreach ($data as &$value) {
                $this->cleanDataRecursively($value);
            }
        } elseif (is_string($data)) {
            // INI PERUBAHAN UTAMANYA
            // Kita gunakan iconv untuk memaksa pembersihan. Karakter yang tidak valid akan dibuang.
            $data = iconv('UTF-8', 'UTF-8//IGNORE', $data);
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
        
        // Pembersihan rekursif dijalankan di sini
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
            $query = Loan::with(['user', 'asset.location', 'asset.category']);
            if ($categoryId) $query->whereHas('asset', fn($q) => $q->where('category_id', $categoryId));
            if ($locationId) $query->whereHas('asset', fn($q) => $q->where('location_id', $locationId));
            if ($startDate && $endDate) $query->whereBetween('loan_date', [$startDate, $endDate]);
            $loans = $query->latest()->get();
            $data['loans'] = $this->cleanDataRecursively($loans);
            $pdf = PDF::loadView('pages.reports.loan-pdf', $data);
            return $pdf->stream('laporan-riwayat-peminjaman.pdf');

        } elseif ($reportType === 'maintenance_history') {
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