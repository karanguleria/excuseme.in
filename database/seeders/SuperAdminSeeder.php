<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@excuseme.in',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'restaurant_id' => null,
        ]);

        $this->command->info('Super Admin created successfully!');
        $this->command->info('Email: admin@excuseme.in');
        $this->command->info('Password: password');
    }
}
