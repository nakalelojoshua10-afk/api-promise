<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; // 👈 Make sure to add this import at the top

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'id' => (string) Str::uuid(), // 👈 Explicitly add this line
            'name' => 'Admin',
            'email' => 'admin@promise.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);

        UserFactory::new()->count(15)->create();
    }
}