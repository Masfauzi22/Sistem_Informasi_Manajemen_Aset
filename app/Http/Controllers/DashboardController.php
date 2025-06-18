<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Panggil library Carbon untuk manajemen tanggal

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil periode filter dari URL, default-nya 'all_time'
        $period = $request->input('period', 'all_time');

        // 2. Tentukan rentang tanggal berdasarkan periode
        $startDate = null;
        $endDate = null;

        if ($period == 'this_month') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($period == 'this_year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        }

        // 3. Buat query dasar untuk Aset
        $assetQuery = Asset::query();
        if ($startDate && $endDate) {
            // Gunakan `created_at` untuk data baru, atau `purchase_date` jika lebih sesuai
            $assetQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        // 4. Hitung ulang semua data berdasarkan query yang sudah difilter
        $assetCount = $assetQuery->count();
        $assetValue = $assetQuery->sum('purchase_price'); // sum juga akan mengikuti filter

        // Data untuk Grafik (juga difilter)
        $categoryQuery = Category::query();
        if ($startDate && $endDate) {
            // Filter kategori yang memiliki aset yang dibuat dalam rentang waktu
            $categoryQuery->whereHas('assets', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }
        $categoriesWithAssetCount = $categoryQuery->withCount(['assets' => function ($q) use ($startDate, $endDate) {
            if ($startDate && $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            }
        }])->get();
        
        $categoryLabels = $categoriesWithAssetCount->pluck('name');
        $categoryData = $categoriesWithAssetCount->pluck('assets_count');
        
        // Filter untuk data status
        $statusQuery = Asset::query();
        if ($startDate && $endDate) {
            $statusQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $assetByStatus = $statusQuery->select('status', DB::raw('count(*) as total'))->groupBy('status')->get();
        $statusLabels = $assetByStatus->pluck('status');
        $statusData = $assetByStatus->pluck('total');
        
        // Tabel Informasi Cepat (juga difilter)
        $recentAssets = Asset::with(['category', 'location'])->latest()->limit(5)->get();
        $attentionAssets = Asset::with(['category', 'location'])->whereIn('status', ['Rusak', 'Dalam Perbaikan'])->limit(5)->get();
        
        $locationCount = Location::count(); // Location & Category count tidak difilter
        $categoryCount = Category::count();

        // Kirim semua data ke view, termasuk variabel 'period'
        return view('dashboard', compact(
            'assetCount', 'categoryCount', 'locationCount', 'assetValue',
            'categoryLabels', 'categoryData', 'statusLabels', 'statusData',
            'recentAssets', 'attentionAssets', 'period' // tambahkan 'period'
        ));
    }
}