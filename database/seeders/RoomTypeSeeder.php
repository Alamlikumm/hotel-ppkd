<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Standard',
                'description' => 'Standard Room Is Comfortable For 1-2 People.',
                'price_per_night' => 450000,
                'max_occupancy' => 2,
                'facilities' => ['AC', 'WiFi', 'TV', 'Ensuite Bathroom'],
            ],
            [
                'name' => 'Deluxe',
                'description' => 'Deluxe Room With Garden View.',
                'price_per_night' => 650000,
                'max_occupancy' => 2,
                'facilities' => ['AC', 'WiFi', 'TV', 'Bathtub', 'Mini Bar'],
            ],
            [
                'name' => 'Suite',
                'description' => 'Luxury Suite With Separate Living Room.',
                'price_per_night' => 1500000,
                'max_occupancy' => 4,
                'facilities' => ['AC', 'WiFi', 'TV', 'Bathtub', 'Mini Bar', 'Sitting Room', 'Kitchenette'],
            ],
        ];

        foreach ($types as $type) {
            RoomType::updateOrCreate(['name' => $type['name']], $type);
        }
    }
}
