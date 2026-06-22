<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'superadmin'],
            ['name' => 'Admin Hotel', 'slug' => 'resepsionis'],
            ['name' => 'Admin F&B',   'slug' => 'admin_fnb'],
            ['name' => 'Housekeeping', 'slug' => 'housekeeping'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
