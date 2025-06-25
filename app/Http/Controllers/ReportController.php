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
    /**
     * Menampilkan halaman utama untuk memilih jenis laporan.
     */
    public function index()
    {
        $categories = Category::all();
        $locations = Location::all();

        return view('pages.reports.index', compact('categories', 'locations'));
    }

    /**
     * Membersihkan semua data string dalam array, objek, dan relasinya secara rekursif.
     * Ini adalah versi yang lebih kuat untuk memastikan semua data bersih.
     */
    private function cleanDataRecursively(&$data)
    {
        // Jika data adalah koleksi, kita proses setiap item di dalamnya
        if ($data instanceof Collection) {
            $data->transform(function ($item) {
                return $this->cleanDataRecursively($item);
            });
        } elseif (is_array($data) || is_object($data)) {
            // Jika data adalah array atau objek, kita loop setiap propertinya
            foreach ($data as &$value) {
                // Panggil fungsi ini lagi untuk setiap value (rekursif)
                $this->cleanDataRecursively($value);
            }
        } elseif (is_string($data)) {
            // Ini adalah intinya: paksa encoding ke UTF-8 untuk membersihkan karakter aneh
            $data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        }

        return $data;
    }

    /**
     * Membuat dan men-stream laporan dalam format PDF berdasarkan input dari user.
     */
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
        
        // Membersihkan data awal (seperti categoryName dan locationName)
        $this->cleanDataRecursively($data);

        if ($reportType === 'all_assets') {
            $query = Asset::with(['category', 'location'])
                ->where('status', '!=', 'Menunggu Persetujuan');

            if ($categoryId) $query->where('category_id', $categoryId);
            if ($locationId) $query->where('location_id', $locationId);
            if ($startDate && $endDate) $query->whereBetween('purchase_date', [$startDate, $endDate]);

            $assets = $query->get();
            $data['assets'] = $this->cleanDataRecursively($assets); // Panggil fungsi pembersih rekursif

            $pdf = PDF::loadView('pages.reports.asset-pdf', $data);
            return $pdf->stream('laporan-inventaris-aset.pdf');

        } elseif ($reportType === 'loan_history') {
            $query = Loan::with(['user', 'asset.location', 'asset.category']);

            if ($categoryId) $query->whereHas('asset', fn($q) => $q->where('category_id', $categoryId));
            if ($locationId) $query->whereHas('asset', fn($q) => $q->where('location_id', $locationId));
            if ($startDate && $endDate) $query->whereBetween('loan_date', [$startDate, $endDate]);

            $loans = $query->latest()->get();
            $data['loans'] = $this->cleanDataRecursively($loans); // Panggil fungsi pembersih rekursif
            
            $pdf = PDF::loadView('pages.reports.loan-pdf', $data);
            return $pdf->stream('laporan-riwayat-peminjaman.pdf');

        } elseif ($reportType === 'maintenance_history') {
            $query = Maintenance::with(['asset.location', 'asset.category']);

            if ($categoryId) $query->whereHas('asset', fn($q) => $q->where('category_id', $categoryId));
            if ($locationId) $query->whereHas('asset', fn($q) => $q->where('location_id', $locationId));
            if ($startDate && $endDate) $query->whereBetween('maintenance_date', [$startDate, $endDate]);

            $maintenances = $query->latest()->get();
            $data['maintenances'] = $this->cleanDataRecursively($maintenances); // Panggil fungsi pembersih rekursif

            $pdf = PDF::loadView('pages.reports.maintenance-pdf', $data);
            return $pdf->stream('laporan-riwayat-perawatan.pdf');
        }

        return redirect()->back()->with('error', 'Jenis laporan tidak valid.');
    }
}