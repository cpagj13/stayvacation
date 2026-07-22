<?php

namespace Database\Seeders;

use App\Models\RoomCategory;
use Illuminate\Database\Seeder;

class RoomCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'Standard & Economy',
                'description' => 'Comfortable and budget-friendly accommodation essential for relaxing stays.',
            ],
            [
                'id' => 2,
                'name' => 'Deluxe & Executive',
                'description' => 'Spacious rooms with scenic views, king beds, and upgraded room amenities.',
            ],
            [
                'id' => 3,
                'name' => 'Luxury Suites',
                'description' => 'High-end suites featuring private living areas, jacuzzis, and VIP services.',
            ],
            [
                'id' => 4,
                'name' => 'Beachfront Villas & Cottages',
                'description' => 'Exclusive private villas perfect for families and large group getaways.',
            ],
        ];

        foreach ($categories as $cat) {
            RoomCategory::updateOrCreate(['id' => $cat['id']], $cat);
        }
    }
}
