<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceLog;
use Illuminate\Http\Request;

class MaintenanceLogController extends Controller
{
    /**
     * Sinkronisasi status aset berdasarkan status maintenance.
     * - in_progress → aset jadi 'maintenance'
     * - completed / cancelled → aset kembali ke 'available'
     * - scheduled → tidak mengubah status aset
     */
    private function syncAssetStatus(int $assetId, string $maintenanceStatus): void
    {
        $asset = Asset::find($assetId);
        if (!$asset) return;

        if ($maintenanceStatus === 'in_progress') {
            $asset->update(['status' => 'maintenance']);
        } elseif (in_array($maintenanceStatus, ['completed', 'cancelled'])) {
            // Hanya kembalikan ke available jika saat ini statusnya maintenance
            if ($asset->status === 'maintenance') {
                $asset->update(['status' => 'available']);
            }
        }
    }

    // GET /api/maintenances
    public function index()
    {
        $logs = MaintenanceLog::with(['asset.category', 'asset.location'])->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => $logs,
        ]);
    }

    // POST /api/maintenances
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id'          => 'required|exists:assets,id',
            'title'             => 'required|string|max:255',
            'maintenance_date'  => 'required|date',
            'next_service_date' => 'nullable|date|after_or_equal:maintenance_date',
            'cost'              => 'nullable|numeric|min:0',
            'status'            => 'required|in:scheduled,in_progress,completed,cancelled',
            'performed_by'      => 'nullable|string|max:255',
            'service_location'  => 'nullable|string|max:255',
            'parts_replaced'    => 'nullable|string',
            'notes'             => 'nullable|string',
        ]);

        $log = MaintenanceLog::create($validated);

        // Sinkronisasi status aset
        $this->syncAssetStatus($validated['asset_id'], $validated['status']);

        $log->load(['asset.category', 'asset.location']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Log maintenance berhasil ditambahkan',
            'data'    => $log,
        ], 201);
    }

    // GET /api/maintenances/{id}
    public function show($id)
    {
        $log = MaintenanceLog::with(['asset.category', 'asset.location'])->find($id);

        if (!$log) {
            return response()->json(['status' => 'error', 'message' => 'Log maintenance tidak ditemukan'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $log]);
    }

    // PUT /api/maintenances/{id}
    public function update(Request $request, $id)
    {
        $log = MaintenanceLog::find($id);

        if (!$log) {
            return response()->json(['status' => 'error', 'message' => 'Log maintenance tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'asset_id'          => 'required|exists:assets,id',
            'title'             => 'required|string|max:255',
            'maintenance_date'  => 'required|date',
            'next_service_date' => 'nullable|date|after_or_equal:maintenance_date',
            'cost'              => 'nullable|numeric|min:0',
            'status'            => 'required|in:scheduled,in_progress,completed,cancelled',
            'performed_by'      => 'nullable|string|max:255',
            'service_location'  => 'nullable|string|max:255',
            'parts_replaced'    => 'nullable|string',
            'notes'             => 'nullable|string',
        ]);

        $log->update($validated);

        // Sinkronisasi status aset saat status maintenance berubah
        $this->syncAssetStatus($validated['asset_id'], $validated['status']);

        $log->load(['asset.category', 'asset.location']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Log maintenance berhasil diperbarui',
            'data'    => $log,
        ]);
    }

    // DELETE /api/maintenances/{id}
    public function destroy($id)
    {
        $log = MaintenanceLog::find($id);

        if (!$log) {
            return response()->json(['status' => 'error', 'message' => 'Log maintenance tidak ditemukan'], 404);
        }

        // Jika log yang dihapus sedang in_progress, kembalikan status aset
        if ($log->status === 'in_progress') {
            $this->syncAssetStatus($log->asset_id, 'cancelled');
        }

        $log->delete();

        return response()->json(['status' => 'success', 'message' => 'Log maintenance berhasil dihapus']);
    }
}
