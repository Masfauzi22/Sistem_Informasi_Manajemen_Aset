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
    public function index()
    {
        $categories = Category::all();
        $locations = Location::all();

        return view('pages.reports.index', compact('categories', 'locations'));
    }

    // Fungsi bantu memastikan semua data string sudah dalam UTF-8 (rekursif untuk array dan objek)
    private function convertUtf8Recursive(&$input)
    {
        if (is_array($input)) {
            foreach ($input as &$value) {
                $this->convertUtf8Recursive($value);
            }
        } elseif (is_object($input)) {
            foreach ($input as $key => $value) {
                $this->convertUtf8Recursive($input->$key);
            }
        } elseif (is_string($input)) {
            // Gunakan mb_detect_encoding supaya konversi lebih akurat
            $encoding = mb_detect_encoding($input, 'UTF-8, ISO-8859-1', true);
            if ($encoding !== 'UTF-8') {
                $input = mb_convert_encoding($input, 'UTF-8', $encoding ?: 'auto');
            }
        }
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

        // Aman cari nama kategori dan lokasi
        $categoryName = null;
        if ($categoryId) {
            $category = Category::find($categoryId);
            $categoryName = $category ? $category->name : null;
        }
        $locationName = null;
        if ($locationId) {
            $location = Location::find($locationId);
            $locationName = $location ? $location->name : null;
        }

        $data = [
            'date' => date('d/m/Y'),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'categoryName' => $categoryName,
            'locationName' => $locationName,
        ];

        if ($reportType === 'all_assets') {
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

            $this->convertUtf8Recursive($data);
            $pdf = PDF::loadView('pages.reports.asset-pdf', $data);
            return $pdf->stream('laporan-inventaris-aset.pdf');

        } elseif ($reportType === 'loan_history') {
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

            $data['loans'] = $query->latest()->get();

            $this->convertUtf8Recursive($data);
            $pdf = PDF::loadView('pages.reports.loan-pdf', $data);
            return $pdf->stream('laporan-riwayat-peminjaman.pdf');

        } elseif ($reportType === 'maintenance_history') {
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

            $data['maintenances'] = $query->latest()->get();

            $this->convertUtf8Recursive($data);
            $pdf = PDF::loadView('pages.reports.maintenance-pdf', $data);
            return $pdf->stream('laporan-riwayat-perawatan.pdf');
        }

        return redirect()->back()->with('error', 'Jenis laporan tidak valid.');
    }
}