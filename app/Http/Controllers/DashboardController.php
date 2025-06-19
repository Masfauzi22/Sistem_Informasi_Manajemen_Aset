<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'all_time');

        $startDate = null;
        $endDate = null;

        if ($period == 'this_month') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($period == 'this_year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        }

        // ========================================================
        // PERUBAHAN LOGIKA DI SINI
        // ========================================================
        // Buat Query Dasar untuk Aset yang BUKAN 'Menunggu Persetujuan'
        $approvedAssetsQuery = Asset::where('status', '!=', 'Menunggu Persetujuan');

        if ($startDate && $endDate) {
            $approvedAssetsQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Hitung data kartu statistik dari query yang sudah difilter
        $assetCount = (clone $approvedAssetsQuery)->count();
        $assetValue = (clone $approvedAssetsQuery)->sum('purchase_price');

        // Hitung data untuk Grafik Kategori dari aset yang sudah disetujui
        $categoriesWithAssetCount = Category::whereHas('assets', function ($query) use ($startDate, $endDate) {
            $query->where('status', '!=', 'Menunggu Persetujuan');
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        })->withCount(['assets' => function ($query) use ($startDate, $endDate) {
            $query->where('status', '!=', 'Menunggu Persetujuan');
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }])->get();
        
        $categoryLabels = $categoriesWithAssetCount->pluck('name');
        $categoryData = $categoriesWithAssetCount->pluck('assets_count');
        
        // Hitung data untuk Grafik Status dari aset yang sudah disetujui
        $assetByStatus = (clone $approvedAssetsQuery)->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')->get();
        $statusLabels = $assetByStatus->pluck('status');
        $statusData = $assetByStatus->pluck('total');
        
        // Tabel Informasi Cepat (ini tidak berubah, tujuannya tetap sama)
        $recentAssets = Asset::with(['category', 'location'])->latest()->limit(5)->get();
        $attentionAssets = Asset::with(['category', 'location'])
            ->whereIn('status', ['Rusak', 'Dalam Perbaikan'])->limit(5)->get();
        
        // Total Kategori dan Lokasi tidak berubah
        $locationCount = Location::count();
        $categoryCount = Category::count();

        return view('dashboard', compact(
            'assetCount', 'categoryCount', 'locationCount', 'assetValue',
            'categoryLabels', 'categoryData', 'statusLabels', 'statusData',
            'recentAssets', 'attentionAssets', 'period'
        ));
    }
}