<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceLog;
use Illuminate\Http\Request;

class MaintenanceLogController extends Controller
{
    // GET /api/maintenances (Ambil semua log maintenance)
    public function index()
    {
        $logs = MaintenanceLog::with(['asset.category', 'asset.location'])->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => $logs,
        ]);
    }

    // POST /api/maintenances (Tambah log maintenance)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id'          => 'required|exists:assets,id',
            'title'             => 'required|string|max:255',
            'maintenance_date'  => 'required|date',
            'next_service_date' => 'nullable|date|after_or_equal:maintenance_date',
            'cost'              => 'nullable|numeric',
            'status'            => 'required|in:scheduled,in_progress,completed,cancelled',
            'performed_by'      => 'nullable|string|max:255',
            'notes'             => 'nullable|string',
        ]);

        $log = MaintenanceLog::create($validated);
        $log->load(['asset.category', 'asset.location']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Log maintenance berhasil ditambahkan',
            'data'    => $log,
        ], 201);
    }

    // GET /api/maintenances/{id} (Lihat detail log)
    public function show($id)
    {
        $log = MaintenanceLog::with(['asset.category', 'asset.location'])->find($id);

        if (!$log) {
            return response()->json(['status' => 'error', 'message' => 'Log maintenance tidak ditemukan'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $log]);
    }

    // PUT /api/maintenances/{id} (Update log)
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
            'cost'              => 'nullable|numeric',
            'status'            => 'required|in:scheduled,in_progress,completed,cancelled',
            'performed_by'      => 'nullable|string|max:255',
            'notes'             => 'nullable|string',
        ]);

        $log->update($validated);
        $log->load(['asset.category', 'asset.location']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Log maintenance berhasil diperbarui',
            'data'    => $log,
        ]);
    }

    // DELETE /api/maintenances/{id} (Hapus log)
    public function destroy($id)
    {
        $log = MaintenanceLog::find($id);

        if (!$log) {
            return response()->json(['status' => 'error', 'message' => 'Log maintenance tidak ditemukan'], 404);
        }

        $log->delete();

        return response()->json(['status' => 'success', 'message' => 'Log maintenance berhasil dihapus']);
    }
}