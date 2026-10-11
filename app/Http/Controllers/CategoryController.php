<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // GET /api/categories (Ambil semua kategori)
    public function index()
    {
        $categories = Category::latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => $categories,
        ]);
    }

    // POST /api/categories (Tambah kategori baru)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:categories,code',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Kategori berhasil ditambahkan',
            'data'    => $category,
        ], 201);
    }

    // GET /api/categories/{id} (Lihat detail 1 kategori)
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $category,
        ]);
    }

    // PUT /api/categories/{id} (Update data kategori)
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:categories,code,' . $id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Kategori berhasil diperbarui',
            'data'    => $category,
        ]);
    }

    // DELETE /api/categories/{id} (Hapus kategori)
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Kategori berhasil dihapus',
        ]);
    }
}