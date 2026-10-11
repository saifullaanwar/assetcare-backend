<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data'   => Location::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:locations,code',
            'building'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $location = Location::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Lokasi berhasil ditambahkan',
            'data'    => $location,
        ], 201);
    }

    public function show($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['status' => 'error', 'message' => 'Lokasi tidak ditemukan'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $location]);
    }

    public function update(Request $request, $id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['status' => 'error', 'message' => 'Lokasi tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:locations,code,' . $id,
            'building'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $location->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Lokasi berhasil diperbarui',
            'data'    => $location,
        ]);
    }

    public function destroy($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['status' => 'error', 'message' => 'Lokasi tidak ditemukan'], 404);
        }

        $location->delete();

        return response()->json(['status' => 'success', 'message' => 'Lokasi berhasil dihapus']);
    }
}