<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\MaintenanceLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Statistik Aset
        $totalAssets = Asset::count();

        // Breakdown Status Aset
        $assetsByStatus = [
            'available'   => Asset::where('status', 'available')->count(),
            'in_use'      => Asset::where('status', 'in_use')->count(),
            'maintenance' => Asset::where('status', 'maintenance')->count(),
            'disposed'    => Asset::where('status', 'disposed')->count(),
        ];

        // Total Pengeluaran Perawatan/Servis
        $totalMaintenanceCost = MaintenanceLog::sum('cost');

        // Ringkasan Pengeluaran Per Kategori Perangkat
        $costPerCategory = Category::select('categories.id', 'categories.name', 'categories.code')
            ->selectRaw('COALESCE(SUM(maintenance_logs.cost), 0) as total_cost')
            ->leftJoin('assets', 'categories.id', '=', 'assets.category_id')
            ->leftJoin('maintenance_logs', 'assets.id', '=', 'maintenance_logs.asset_id')
            ->groupBy('categories.id', 'categories.name', 'categories.code')
            ->get();

        // 5 Riwayat Servis Terbaru
        $recentMaintenances = MaintenanceLog::with(['asset.category', 'asset.location'])
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'total_assets'           => $totalAssets,
                'available_assets'       => $assetsByStatus['available'],
                'in_use_assets'          => $assetsByStatus['in_use'],
                'maintenance_assets'     => $assetsByStatus['maintenance'],
                'disposed_assets'        => $assetsByStatus['disposed'],
                'total_maintenance_cost' => (float) $totalMaintenanceCost,
                'cost_per_category'      => $costPerCategory,
                'recent_maintenances'    => $recentMaintenances,
            ],
        ]);
    }
}