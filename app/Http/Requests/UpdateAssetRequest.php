<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $assetId = $this->route('asset');

        return [
            'category_id'   => 'required|exists:categories,id',
            'location_id'   => 'required|exists:locations,id',
            'name'          => 'required|string|max:255',
            'asset_code'    => 'required|string|max:50|unique:assets,asset_code,' . $assetId,
            'serial_number' => 'nullable|string|max:255',
            'status'        => 'required|in:available,in_use,maintenance,disposed',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric|min:0',
            'notes'         => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required'  => 'Kategori wajib dipilih.',
            'category_id.exists'    => 'Kategori tidak ditemukan.',
            'location_id.required'  => 'Lokasi wajib dipilih.',
            'location_id.exists'    => 'Lokasi tidak ditemukan.',
            'name.required'         => 'Nama aset wajib diisi.',
            'asset_code.required'   => 'Kode aset wajib diisi.',
            'asset_code.unique'     => 'Kode aset sudah digunakan.',
            'status.required'       => 'Status wajib dipilih.',
            'status.in'             => 'Status tidak valid.',
            'purchase_cost.numeric' => 'Harga beli harus berupa angka.',
            'purchase_cost.min'     => 'Harga beli tidak boleh negatif.',
        ];
    }
}
