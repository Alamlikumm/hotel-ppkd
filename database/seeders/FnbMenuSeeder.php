<?php

namespace Database\Seeders;

use App\Models\FnbCategory;
use App\Models\FnbMenu;
use App\Models\User;
use Illuminate\Database\Seeder;

class FnbMenuSeeder extends Seeder
{
    public function run(): void
    {
        $makanan = FnbCategory::where('name', 'Food')->value('id');
        $minuman = FnbCategory::where('name', 'Drink')->value('id');
        $dessert = FnbCategory::where('name', 'Dessert')->value('id');
        $adminId = User::where('email', 'fnb@hotel.com')->value('id');

        $menus = [
            ['name' => 'Special Fried Rice', 'fnb_category_id' => $makanan, 'price' => 40000,  'status' => 'available'],
            ['name' => 'Chicken Soto',       'fnb_category_id' => $makanan, 'price' => 35000,  'status' => 'available'],
            ['name' => 'Beef Steak',         'fnb_category_id' => $makanan, 'price' => 150000, 'status' => 'available'],
            ['name' => 'Gado-Gado',          'fnb_category_id' => $makanan, 'price' => 30000,  'status' => 'available'],
            ['name' => 'Sweet Iced Tea',     'fnb_category_id' => $minuman, 'price' => 10000,  'status' => 'available'],
            ['name' => 'Avocado Juice',      'fnb_category_id' => $minuman, 'price' => 25000,  'status' => 'available'],
            ['name' => 'Milk Coffee',        'fnb_category_id' => $minuman, 'price' => 20000,  'status' => 'available'],
            ['name' => 'Tiramisu',           'fnb_category_id' => $dessert, 'price' => 55000,  'status' => 'available'],
            ['name' => 'Chocolate Pudding',  'fnb_category_id' => $dessert, 'price' => 25000,  'status' => 'available'],
        ];

        foreach ($menus as $menu) {
            FnbMenu::updateOrCreate(
                ['name' => $menu['name']],
                [...$menu, 'created_by' => $adminId]
            );
        }
    }
}
