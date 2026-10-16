<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    // GET /api/assets (Tampilkan semua aset + search & filter)
    public function index(Request $request)
    {
        $query = Asset::with(['category', 'location']);

        // Search berdasarkan nama atau nomor seri
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('serial_number', 'ilike', "%{$search}%")
                  ->orWhere('asset_code', 'ilike', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter berdasarkan lokasi
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $assets = $query->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => $assets,
        ]);
    }

    // POST /api/assets (Tambah aset baru)
    public function store(StoreAssetRequest $request)
    {
        $asset = Asset::create($request->validated());
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
    public function update(UpdateAssetRequest $request, $id)
    {
        $asset = Asset::find($id);

        if (!$asset) {
            return response()->json(['status' => 'error', 'message' => 'Aset tidak ditemukan'], 404);
        }

        $asset->update($request->validated());
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
