<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin
        User::firstOrCreate(
            ['email' => 'jancook@hotel.com'],
            [
                'name' => 'Super Admin',
                'password' => 'hotel123', // auto-hash via cast 'hashed'
                'role_id' => Role::where('slug', 'superadmin')->value('id'),
                'is_active' => true,
            ]
        );

        // Admin Hotel
        User::firstOrCreate(
            ['email' => 'admin@hotel.com'],
            [
                'name' => 'Admin Hotel',
                'password' => 'admin123',
                'role_id' => Role::where('slug', 'resepsionis')->value('id'),
                'is_active' => true,
            ]
        );

        // Admin F&B
        User::firstOrCreate(
            ['email' => 'fnb@hotel.com'],
            [
                'name' => 'Admin F&B',
                'password' => 'f&b123',
                'role_id' => Role::where('slug', 'admin_fnb')->value('id'),
                'is_active' => true,
            ]
        );

        // Housekeeping
        User::firstOrCreate(
            ['email' => 'housekeeping@hotel.com'],
            [
                'name' => 'Admin Housekeeping',
                'password' => 'housekeeping123',
                'role_id' => Role::where('slug', 'housekeeping')->value('id'),
                'is_active' => true,
            ]
        );
    }
}
