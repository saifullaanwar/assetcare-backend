<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // User default untuk testing
        User::firstOrCreate(
            ['email' => 'admin@assetcare.com'],
            [
                'name'     => 'Admin AssetCare',
                'password' => Hash::make('password123'),
            ]
        );

        // Seed data dummy
        $this->call([
            CategorySeeder::class,
            LocationSeeder::class,
            AssetSeeder::class,
        ]);
    }
}
