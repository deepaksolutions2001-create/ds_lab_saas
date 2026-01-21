<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lab;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LabSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Default Lab
        $lab = Lab::create([
            'name' => 'Main Diagnostic Lab',
            'email' => 'admin@lab.com',
            'contact_no' => '1234567890',
            'address' => 'Lab Street, City',
        ]);

        // 2. Create Lab Admin User
        User::create([
            'name' => 'Lab Manager',
            'email' => 'admin@lab.com',
            'password' => Hash::make('password'),
            'lab_id' => $lab->id,
            'role' => 'lab_admin',
        ]);

        // 3. Create Super Admin (Managing all)
        User::create([
            'name' => 'Super Admin',
            'email' => 'super@system.com',
            'password' => Hash::make('password'),
            'lab_id' => null, // Super admin sees all
            'role' => 'super_admin',
        ]);
    }
}
