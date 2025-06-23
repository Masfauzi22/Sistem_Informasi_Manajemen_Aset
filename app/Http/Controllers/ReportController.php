<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Loan;
use App\Models\Maintenance;
use App\Models\Category; // Panggil Model Category
use App\Models\Location; // Panggil Model Location
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman utama untuk memilih laporan.
     */
    public function index()
    {
        // Ambil data untuk pilihan filter dropdown
        $categories = Category::all();
        $locations = Location::all();
        
        return view('pages.reports.index', compact('categories', 'locations'));
    }

    /**
     * Memproses dan men-generate laporan PDF.
     */
    public function generate(Request $request)
    {
        // Validasi input
        $request->validate([
            'report_type' => 'required|string',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
            'category_id' => 'nullable|exists:categories,id', // Validasi filter baru
            'location_id' => 'nullable|exists:locations,id', // Validasi filter baru
        ]);

        $reportType = $request->input('report_type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $categoryId = $request->input('category_id');
        $locationId = $request->input('location_id');
        
        $data = [
            'date' => date('d/m/Y'),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'categoryName' => $categoryId ? Category::find($categoryId)->name : null, // Tambahkan nama kategori untuk laporan
            'locationName' => $locationId ? Location::find($locationId)->name : null, // Tambahkan nama lokasi untuk laporan
        ];
        
        // Logika untuk memilih data dan view berdasarkan jenis laporan
        if ($reportType == 'all_assets') {
            $query = Asset::with(['category', 'location'])
                          ->where('status', '!=', 'Menunggu Persetujuan');

            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }
            if ($locationId) {
                $query->where('location_id', $locationId);
            }
            if ($startDate && $endDate) {
                $query->whereBetween('purchase_date', [$startDate, $endDate]);
            }
            $data['assets'] = $query->get();
            $pdf = PDF::loadView('pages.reports.asset-pdf', $data);
            return $pdf->stream('laporan-inventaris-aset.pdf');

        } elseif ($reportType == 'loan_history') {
            $query = Loan::with(['user', 'asset']);
            
            if ($categoryId) {
                $query->whereHas('asset', fn($q) => $q->where('category_id', $categoryId));
            }
            if ($locationId) {
                $query->whereHas('asset', fn($q) => $q->where('location_id', $locationId));
            }
            if ($startDate && $endDate) {
                $query->whereBetween('loan_date', [$startDate, $endDate]);
            }
            
            $data['loans'] = $query->latest()->get(); // Menambahkan latest() untuk pengurutan
            $pdf = PDF::loadView('pages.reports.loan-pdf', $data);
            return $pdf->stream('laporan-riwayat-peminjaman.pdf');

        } elseif ($reportType == 'maintenance_history') {
            $query = Maintenance::with('asset');

            if ($categoryId) {
                $query->whereHas('asset', fn($q) => $q->where('category_id', $categoryId));
            }
            if ($locationId) {
                $query->whereHas('asset', fn($q) => $q->where('location_id', $locationId));
            }
            if ($startDate && $endDate) {
                $query->whereBetween('maintenance_date', [$startDate, $endDate]);
            }
            
            $data['maintenances'] = $query->latest()->get(); // Menambahkan latest() untuk pengurutan
            $pdf = PDF::loadView('pages.reports.maintenance-pdf', $data);
            return $pdf->stream('laporan-riwayat-perawatan.pdf');
        }

        return redirect()->back()->with('error', 'Jenis laporan tidak valid.');
    }
}