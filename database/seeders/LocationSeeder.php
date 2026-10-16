<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'Jakarta - Kantor Pusat Lantai 1', 'code' => 'JKT-1', 'building' => 'Gedung Utama',  'description' => 'Area resepsionis dan ruang tamu'],
            ['name' => 'Jakarta - Kantor Pusat Lantai 2', 'code' => 'JKT-2', 'building' => 'Gedung Utama',  'description' => 'Ruang kerja divisi IT dan keuangan'],
            ['name' => 'Jakarta - Kantor Pusat Lantai 3', 'code' => 'JKT-3', 'building' => 'Gedung Utama',  'description' => 'Ruang direksi dan rapat'],
            ['name' => 'Jakarta - Ruang Server',          'code' => 'JKT-4', 'building' => 'Gedung Utama',  'description' => 'Data center dan server room'],
            ['name' => 'Jakarta - Gudang',                'code' => 'JKT-5', 'building' => 'Gedung B',      'description' => 'Penyimpanan aset dan inventaris'],
            ['name' => 'Jakarta - Area Parkir',           'code' => 'JKT-6', 'building' => 'Gedung Utama',  'description' => 'Parkir kendaraan operasional'],
            ['name' => 'Bandung - Kantor Cabang',         'code' => 'BDG-1', 'building' => 'Ruko Bandung',  'description' => 'Kantor cabang Bandung'],
            ['name' => 'Surabaya - Kantor Cabang',        'code' => 'SBY-1', 'building' => 'Ruko Surabaya', 'description' => 'Kantor cabang Surabaya'],
            ['name' => 'Medan - Kantor Cabang',           'code' => 'MDN-1', 'building' => 'Ruko Medan',    'description' => 'Kantor cabang Medan'],
        ];

        foreach ($locations as $location) {
            Location::firstOrCreate(['code' => $location['code']], $location);
        }
    }
}
