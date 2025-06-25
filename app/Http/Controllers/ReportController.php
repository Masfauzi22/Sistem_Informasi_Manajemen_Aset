<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Loan;
use App\Models\Maintenance;
use App\Models\Category;
use App\Models\Location;
use PDF; // PERUBAHAN: Gunakan alias 'PDF' yang sudah didaftarkan di config/app.php
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman utama untuk memilih laporan, lengkap dengan data untuk filter.
     */
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        return view('pages.reports.index', compact('categories', 'locations'));
    }

    /**
     * Memproses dan men-generate laporan PDF.
     */
    public function generate(Request $request)
    {
        // Validasi input form
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

        // Menyiapkan data umum untuk semua laporan
        $data = [
            'date' => date('d F Y'),
            'startDate' => $startDate ? Carbon::parse($startDate)->format('d M Y') : null,
            'endDate' => $endDate ? Carbon::parse($endDate)->format('d M Y') : null,
            'categoryName' => $categoryId ? Category::find($categoryId)?->name : 'Semua Kategori',
            'locationName' => $locationId ? Location::find($locationId)?->name : 'Semua Lokasi',
        ];

        // Memilih laporan mana yang akan dibuat
        if ($reportType === 'all_assets') {
            $query = Asset::with(['category', 'location'])->where('status', '!=', 'Menunggu Persetujuan');
            if ($categoryId) $query->where('category_id', $categoryId);
            if ($locationId) $query->where('location_id', $locationId);
            if ($startDate && $endDate) $query->whereBetween('purchase_date', [$startDate, $endDate]);
            
            $data['assets'] = $query->get();
            $pdf = PDF::loadView('pages.reports.asset-pdf', $data);
            return $pdf->stream('laporan-inventaris-aset-'.date('Ymd').'.pdf');

        } elseif ($reportType === 'loan_history') {
            $query = Loan::with(['user', 'asset.category', 'asset.location'])->latest();
            if ($categoryId) $query->whereHas('asset', fn($q) => $q->where('category_id', $categoryId));
            if ($locationId) $query->whereHas('asset', fn($q) => $q->where('location_id', $locationId));
            if ($startDate && $endDate) $query->whereBetween('loan_date', [$startDate, $endDate]);

            $data['loans'] = $query->get();
            $pdf = PDF::loadView('pages.reports.loan-pdf', $data);
            return $pdf->stream('laporan-riwayat-peminjaman-'.date('Ymd').'.pdf');

        } elseif ($reportType === 'maintenance_history') {
            $query = Maintenance::with(['asset.category', 'asset.location'])->latest();
            if ($categoryId) $query->whereHas('asset', fn($q) => $q->where('category_id', $categoryId));
            if ($locationId) $query->whereHas('asset', fn($q) => $q->where('location_id', $locationId));
            if ($startDate && $endDate) $query->whereBetween('maintenance_date', [$startDate, $endDate]);

            $data['maintenances'] = $query->get();
            $pdf = PDF::loadView('pages.reports.maintenance-pdf', $data);
            return $pdf->stream('laporan-riwayat-perawatan-'.date('Ymd').'.pdf');
        }

        return redirect()->back()->with('error', 'Jenis laporan tidak valid.');
    }
}