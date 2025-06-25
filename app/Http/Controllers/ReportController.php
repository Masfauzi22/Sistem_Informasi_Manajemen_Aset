<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Loan;
use App\Models\Maintenance;
use App\Models\Category;
use App\Models\Location;
use Barryvdh\DomPDF\Facade\Pdf;

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
     * Membuat dan men-stream laporan dalam format PDF berdasarkan input dari user.
     */
    public function generate(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'report_type' => 'required|string',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
            'category_id' => 'nullable|exists:categories,id',
            'location_id' => 'nullable|exists:locations,id',
        ]);

        // 2. Ambil semua data input
        $reportType = $request->input('report_type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $categoryId = $request->input('category_id');
        $locationId = $request->input('location_id');

        // 3. Ambil nama kategori & lokasi, LALU LANGSUNG BERSIHKAN
        $categoryName = $categoryId ? Category::find($categoryId)?->name : null;
        if ($categoryName) {
            $categoryName = mb_convert_encoding($categoryName, 'UTF-8', 'UTF-8');
        }

        $locationName = $locationId ? Location::find($locationId)?->name : null;
        if ($locationName) {
            $locationName = mb_convert_encoding($locationName, 'UTF-8', 'UTF-8');
        }

        // 4. PERUBAHAN UNTUK TES DIAGNOSTIK
        // Kita hanya akan mengirim 'date' untuk melihat apakah PDF bisa dibuat.
        // Variabel lain dinonaktifkan sementara dengan tanda komentar (//).
        $data = [
            'date' => date('d/m/Y'),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'categoryName' => $categoryName,
            'locationName' => $locationName,
        ];

        // 5. Buat fungsi pembersih data yang akan dipakai berulang
        $cleanData = function ($collection) {
            return $collection->map(function ($item) {
                foreach ($item->getAttributes() as $key => $value) {
                    if (is_string($value)) {
                        $item->{$key} = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                }
                return $item;
            });
        };

        // 6. Proses sesuai jenis laporan yang dipilih
        if ($reportType === 'all_assets') {
            // PERUBAHAN UNTUK TES DIAGNOSTIK
            // Kita tidak akan mengambil data aset dulu untuk sementara.
            /*
            $query = Asset::with(['category', 'location'])
                ->where('status', '!=', 'Menunggu Persetujuan');

            if ($categoryId) $query->where('category_id', $categoryId);
            if ($locationId) $query->where('location_id', $locationId);
            if ($startDate && $endDate) $query->whereBetween('purchase_date', [$startDate, $endDate]);

            $assets = $query->get();
            $data['assets'] = $cleanData($assets);
            */

            // Langsung coba buat PDF hanya dengan data tanggal
            $pdf = PDF::loadView('pages.reports.asset-pdf', $data);
            return $pdf->stream('laporan-inventaris-aset.pdf');

        } elseif ($reportType === 'loan_history') {
            // Bagian ini tidak kita ubah, karena kita fokus pada 'all_assets'
            $query = Loan::with(['user', 'asset.location', 'asset.category']);

            if ($categoryId) $query->whereHas('asset', fn($q) => $q->where('category_id', $categoryId));
            if ($locationId) $query->whereHas('asset', fn($q) => $q->where('location_id', $locationId));
            if ($startDate && $endDate) $query->whereBetween('loan_date', [$startDate, $endDate]);

            $loans = $query->latest()->get();
            $data['loans'] = $cleanData($loans);
            
            $pdf = PDF::loadView('pages.reports.loan-pdf', $data);
            return $pdf->stream('laporan-riwayat-peminjaman.pdf');

        } elseif ($reportType === 'maintenance_history') {
            // Bagian ini tidak kita ubah
            $query = Maintenance::with(['asset.location', 'asset.category']);

            if ($categoryId) $query->whereHas('asset', fn($q) => $q->where('category_id', $categoryId));
            if ($locationId) $query->whereHas('asset', fn($q) => $q->where('location_id', $locationId));
            if ($startDate && $endDate) $query->whereBetween('maintenance_date', [$startDate, $endDate]);

            $maintenances = $query->latest()->get();
            $data['maintenances'] = $cleanData($maintenances);

            $pdf = PDF::loadView('pages.reports.maintenance-pdf', $data);
            return $pdf->stream('laporan-riwayat-perawatan.pdf');
        }

        return redirect()->back()->with('error', 'Jenis laporan tidak valid.');
    }
}