<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Loan;
use App\Models\Maintenance;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman utama untuk memilih laporan.
     */
    public function index()
    {
        return view('pages.reports.index');
    }

    /**
     * Memproses dan men-generate laporan PDF.
     */
    public function generate(Request $request)
    {
        // Validasi input dengan format tanggal yang lebih spesifik
        $request->validate([
            'report_type' => 'required|string',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
        ]);

        $reportType = $request->input('report_type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $data = [
            'date' => date('d/m/Y'),
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        // Logika untuk memilih data dan view berdasarkan jenis laporan
        if ($reportType == 'all_assets') {
            
            $assetsQuery = Asset::with(['category', 'location'])
                            ->where('status', '!=', 'Menunggu Persetujuan');

            if ($startDate && $endDate) {
                // Langsung gunakan string tanggal dari request di dalam query
                $assetsQuery->whereBetween('purchase_date', [$startDate, $endDate]);
            }

            $data['assets'] = $assetsQuery->get();
            $pdf = PDF::loadView('pages.reports.asset-pdf', $data);
            return $pdf->stream('laporan-inventaris-aset.pdf');

        } elseif ($reportType == 'loan_history') {
            
            $loansQuery = Loan::with(['user', 'asset'])->latest();
            
            if ($startDate && $endDate) {
                $loansQuery->whereBetween('loan_date', [$startDate, $endDate]);
            }
            
            $data['loans'] = $loansQuery->get();
            $pdf = PDF::loadView('pages.reports.loan-pdf', $data);
            return $pdf->stream('laporan-riwayat-peminjaman.pdf');

        } elseif ($reportType == 'maintenance_history') {
            
            $maintenancesQuery = Maintenance::with('asset')->latest();

            if ($startDate && $endDate) {
                $maintenancesQuery->whereBetween('maintenance_date', [$startDate, $endDate]);
            }
            
            $data['maintenances'] = $maintenancesQuery->get();
            $pdf = PDF::loadView('pages.reports.maintenance-pdf', $data);
            return $pdf->stream('laporan-riwayat-perawatan.pdf');
        }

        return redirect()->back()->with('error', 'Jenis laporan tidak valid.');
    }
}