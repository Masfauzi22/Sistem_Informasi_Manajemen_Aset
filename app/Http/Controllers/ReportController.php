<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Loan;
use App\Models\Maintenance;
use App\Models\Category;
use App\Models\Location;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $locations = Location::all();

        return view('pages.reports.index', compact('categories', 'locations'));
    }

    // Fungsi bantu untuk memastikan semua isi array/object dikonversi ke UTF-8
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
            $input = mb_convert_encoding($input, 'UTF-8', 'UTF-8');
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

        $data = [
            'date' => date('d/m/Y'),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'categoryName' => $categoryId ? Category::find($categoryId)->name : null,
            'locationName' => $locationId ? Location::find($locationId)->name : null,
        ];

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
            $this->convertUtf8Recursive($data);
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

            $data['loans'] = $query->latest()->get();
            $this->convertUtf8Recursive($data);
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

            $data['maintenances'] = $query->latest()->get();
            $this->convertUtf8Recursive($data);
            $pdf = PDF::loadView('pages.reports.maintenance-pdf', $data);
            return $pdf->stream('laporan-riwayat-perawatan.pdf');
        }

        return redirect()->back()->with('error', 'Jenis laporan tidak valid.');
    }
}