<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID kategori dan lokasi yang sudah di-seed
        $laptop   = Category::where('code', 'LAPTOP')->first();
        $pc       = Category::where('code', 'PC')->first();
        $printer  = Category::where('code', 'PRINTER')->first();
        $net      = Category::where('code', 'NET')->first();
        $vhc      = Category::where('code', 'VHC')->first();

        $lt1 = Location::where('code', 'KP-L1')->first();
        $lt2 = Location::where('code', 'KP-L2')->first();
        $lt3 = Location::where('code', 'KP-L3')->first();
        $srv = Location::where('code', 'SRV-1')->first();
        $cab = Location::where('code', 'CAB-JKS')->first();

        if (!$laptop || !$lt1) return; // Guard jika CategorySeeder/LocationSeeder belum jalan

        $assets = [
            [
                'category_id'   => $laptop->id,
                'location_id'   => $lt2->id,
                'name'          => 'Laptop Dell XPS 15',
                'asset_code'    => 'AST-LAPTOP-001',
                'serial_number' => 'DLL-XPS-78901',
                'status'        => 'in_use',
                'purchase_date' => '2024-03-15',
                'purchase_cost' => 18500000,
                'notes'         => 'Digunakan oleh divisi IT',
            ],
            [
                'category_id'   => $laptop->id,
                'location_id'   => $lt2->id,
                'name'          => 'MacBook Pro M3',
                'asset_code'    => 'AST-LAPTOP-002',
                'serial_number' => 'MBP-M3-55234',
                'status'        => 'in_use',
                'purchase_date' => '2024-06-01',
                'purchase_cost' => 28000000,
                'notes'         => 'Digunakan oleh tim desain',
            ],
            [
                'category_id'   => $laptop->id,
                'location_id'   => $cab->id,
                'name'          => 'Laptop Lenovo ThinkPad E14',
                'asset_code'    => 'AST-LAPTOP-003',
                'serial_number' => 'LNV-TP-66712',
                'status'        => 'available',
                'purchase_date' => '2023-11-20',
                'purchase_cost' => 12000000,
                'notes'         => null,
            ],
            [
                'category_id'   => $pc->id,
                'location_id'   => $lt2->id,
                'name'          => 'PC Desktop Asus ROG',
                'asset_code'    => 'AST-PC-001',
                'serial_number' => 'ASS-ROG-44102',
                'status'        => 'in_use',
                'purchase_date' => '2023-08-10',
                'purchase_cost' => 22000000,
                'notes'         => 'Workstation rendering',
            ],
            [
                'category_id'   => $printer->id,
                'location_id'   => $lt1->id,
                'name'          => 'Printer HP LaserJet Pro',
                'asset_code'    => 'AST-PRINTER-001',
                'serial_number' => 'HP-LJ-33201',
                'status'        => 'maintenance',
                'purchase_date' => '2022-05-25',
                'purchase_cost' => 4500000,
                'notes'         => 'Sedang dalam perbaikan roller',
            ],
            [
                'category_id'   => $net->id,
                'location_id'   => $srv->id,
                'name'          => 'Switch Cisco Catalyst 2960',
                'asset_code'    => 'AST-NET-001',
                'serial_number' => 'CSC-CAT-99001',
                'status'        => 'in_use',
                'purchase_date' => '2023-01-15',
                'purchase_cost' => 8700000,
                'notes'         => 'Core switch ruang server',
            ],
            [
                'category_id'   => $net->id,
                'location_id'   => $lt3->id,
                'name'          => 'Router MikroTik RB4011',
                'asset_code'    => 'AST-NET-002',
                'serial_number' => 'MTK-RB-10023',
                'status'        => 'in_use',
                'purchase_date' => '2023-04-10',
                'purchase_cost' => 3200000,
                'notes'         => null,
            ],
            [
                'category_id'   => $vhc->id,
                'location_id'   => $lt1->id,
                'name'          => 'Toyota Avanza 2022',
                'asset_code'    => 'AST-VHC-001',
                'serial_number' => 'B 1234 XYZ',
                'status'        => 'available',
                'purchase_date' => '2022-09-01',
                'purchase_cost' => 210000000,
                'notes'         => 'Kendaraan operasional kantor pusat',
            ],
        ];

        foreach ($assets as $asset) {
            Asset::firstOrCreate(['asset_code' => $asset['asset_code']], $asset);
        }
    }
}
