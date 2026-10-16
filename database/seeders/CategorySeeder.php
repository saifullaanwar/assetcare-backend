<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Laptop',      'code' => 'LAPTOP',  'description' => 'Perangkat laptop dan notebook'],
            ['name' => 'PC Desktop',  'code' => 'PC',      'description' => 'Komputer desktop dan workstation'],
            ['name' => 'Printer',     'code' => 'PRINTER', 'description' => 'Printer dan mesin cetak'],
            ['name' => 'Proyektor',   'code' => 'PROJ',    'description' => 'Proyektor dan display presentasi'],
            ['name' => 'Jaringan',    'code' => 'NET',     'description' => 'Switch, router, dan perangkat jaringan'],
            ['name' => 'Kendaraan',   'code' => 'VHC',     'description' => 'Kendaraan operasional perusahaan'],
            ['name' => 'Furnitur',    'code' => 'FURN',    'description' => 'Meja, kursi, dan furnitur kantor'],
            ['name' => 'Elektronik',  'code' => 'ELEC',    'description' => 'Perangkat elektronik lainnya'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['code' => $category['code']], $category);
        }
    }
}
