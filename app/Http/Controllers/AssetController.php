<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    // GET /api/assets (Tampilkan semua aset beserta relasi kategori & lokasi)
    public function index()
    {
        $assets = Asset::with(['category', 'location'])->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => $assets,
        ]);
    }

    // POST /api/assets (Tambah aset baru)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'location_id'   => 'required|exists:locations,id',
            'name'          => 'required|string|max:255',
            'asset_code'    => 'required|string|max:50|unique:assets,asset_code',
            'serial_number' => 'nullable|string|max:255',
            'status'        => 'required|in:available,in_use,maintenance,disposed',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric',
            'notes'         => 'nullable|string',
        ]);

        $asset = Asset::create($validated);
        $asset->load(['category', 'location']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Aset berhasil ditambahkan',
            'data'    => $asset,
        ], 201);
    }

    // GET /api/assets/{id} (Lihat detail aset)
    public function show($id)
    {
        $asset = Asset::with(['category', 'location'])->find($id);

        if (!$asset) {
            return response()->json(['status' => 'error', 'message' => 'Aset tidak ditemukan'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $asset]);
    }

    // PUT /api/assets/{id} (Update data aset)
    public function update(Request $request, $id)
    {
        $asset = Asset::find($id);

        if (!$asset) {
            return response()->json(['status' => 'error', 'message' => 'Aset tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'location_id'   => 'required|exists:locations,id',
            'name'          => 'required|string|max:255',
            'asset_code'    => 'required|string|max:50|unique:assets,asset_code,' . $id,
            'serial_number' => 'nullable|string|max:255',
            'status'        => 'required|in:available,in_use,maintenance,disposed',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric',
            'notes'         => 'nullable|string',
        ]);

        $asset->update($validated);
        $asset->load(['category', 'location']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Aset berhasil diperbarui',
            'data'    => $asset,
        ]);
    }

    // DELETE /api/assets/{id} (Hapus aset)
    public function destroy($id)
    {
        $asset = Asset::find($id);

        if (!$asset) {
            return response()->json(['status' => 'error', 'message' => 'Aset tidak ditemukan'], 404);
        }

        $asset->delete();

        return response()->json(['status' => 'success', 'message' => 'Aset berhasil dihapus']);
    }
}