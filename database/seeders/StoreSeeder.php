<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\StoreBalance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; // 👈 Imported the Str utility class

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::factory()->count(10)->create()->each(function ($store) {
            // Force-inject the UUID 'id' directly inside the factory generation loop
            StoreBalance::factory()->create([
                'id' => (string) Str::uuid(), // 👈 ADDED THIS LINE
                'store_id' => $store->id,
            ]);
        });
    }
}   