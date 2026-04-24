<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Owner
        \App\Models\User::updateOrCreate(
            ['email' => 'owner@nijar.com'],
            [
                'name' => 'Owner Nijar',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'owner'
            ]
        );

        // Create Staff
        \App\Models\User::updateOrCreate(
            ['email' => 'staff@nijar.com'],
            [
                'name' => 'Staff Kasir',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'staff'
            ]
        );

        // Run POS Seeder for products and categories
        $this->call(PosSeeder::class);
    }
}
