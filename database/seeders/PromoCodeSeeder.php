<?php

namespace Database\Seeders;

use App\Models\PromoCode;
use Illuminate\Database\Seeder;

class PromoCodeSeeder extends Seeder
{
    public function run(): void
    {
        $codes = [
            [
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'value' => 10.00,
                'min_booking_amount' => null,
                'is_active' => true,
                'description' => '10% discount on your first booking',
            ],
            [
                'code' => 'STAY500',
                'type' => 'fixed',
                'value' => 500.00,
                'min_booking_amount' => 2000.00,
                'is_active' => true,
                'description' => '₱500 off for bookings ₱2,000 and above',
            ],
            [
                'code' => 'SUMMER20',
                'type' => 'percentage',
                'value' => 20.00,
                'min_booking_amount' => 3000.00,
                'is_active' => true,
                'description' => '20% summer getaway discount for bookings ₱3,000+',
            ],
        ];

        foreach ($codes as $promo) {
            PromoCode::updateOrCreate(['code' => $promo['code']], $promo);
        }
    }
}
