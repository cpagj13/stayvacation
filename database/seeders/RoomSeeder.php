<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'id' => 1,
                'room_category_id' => 1,
                'name' => 'Standard Single Room',
                'type' => 'Standard',
                'price' => 1200.00,
                'capacity' => 1,
                'image' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80',
                'description' => 'Cozy room with single bed, free high-speed Wi-Fi, air conditioning, and private bathroom.',
                'amenities' => ['Wi-Fi', 'Air Conditioning', 'Flat-screen TV', 'Shower'],
            ],
            [
                'id' => 2,
                'room_category_id' => 1,
                'name' => 'Standard Double Room',
                'type' => 'Standard',
                'price' => 1500.00,
                'capacity' => 2,
                'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80',
                'description' => 'Spacious room featuring a comfortable queen-size bed, workstation, and garden view window.',
                'amenities' => ['Wi-Fi', 'Air Conditioning', 'Flat-screen TV', 'Mini Fridge', 'Shower'],
            ],
            [
                'id' => 3,
                'room_category_id' => 1,
                'name' => 'Standard Family Room',
                'type' => 'Standard',
                'price' => 1800.00,
                'capacity' => 4,
                'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=800&q=80',
                'description' => 'Designed for small families with two double beds, desk space, and complementary breakfast.',
                'amenities' => ['Wi-Fi', 'Air Conditioning', 'Flat-screen TV', 'Breakfast Included', 'Shower'],
            ],
            [
                'id' => 4,
                'room_category_id' => 2,
                'name' => 'Deluxe Ocean View Room',
                'type' => 'Deluxe',
                'price' => 2500.00,
                'capacity' => 2,
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80',
                'description' => 'Elegant room offering stunning panoramic ocean views, private balcony, and king-size plush bed.',
                'amenities' => ['Wi-Fi', 'Ocean View', 'Balcony', 'King Bed', 'Mini Bar', 'Safe Box'],
            ],
            [
                'id' => 5,
                'room_category_id' => 2,
                'name' => 'Deluxe Poolside Room',
                'type' => 'Deluxe',
                'price' => 2800.00,
                'capacity' => 3,
                'image' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=800&q=80',
                'description' => 'Direct patio access to the infinity pool, lounge chairs, rainfall shower, and smart home entertainment.',
                'amenities' => ['Pool Access', 'Patio', 'Wi-Fi', 'Smart TV', 'Coffee Maker', 'Bathrobe'],
            ],
            [
                'id' => 6,
                'room_category_id' => 2,
                'name' => 'Executive Business Suite',
                'type' => 'Executive',
                'price' => 3500.00,
                'capacity' => 2,
                'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80',
                'description' => 'Tailored for executive travellers with an ergonomic work desk, executive lounge access, and espresso bar.',
                'amenities' => ['Executive Lounge Access', 'Work Desk', 'Wi-Fi', 'Espresso Machine', 'City View'],
            ],
            [
                'id' => 7,
                'room_category_id' => 3,
                'name' => 'Presidential Luxury Suite',
                'type' => 'Suite',
                'price' => 5000.00,
                'capacity' => 4,
                'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
                'description' => 'Opulent suite featuring a separate living room, dining area, private balcony, and 24/7 butler service.',
                'amenities' => ['Butler Service', 'Living Room', 'Dining Area', 'Jacuzzi', 'Ocean View'],
            ],
            [
                'id' => 8,
                'room_category_id' => 3,
                'name' => 'Honeymoon Suite with Jacuzzi',
                'type' => 'Suite',
                'price' => 5500.00,
                'capacity' => 2,
                'image' => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=800&q=80',
                'description' => 'Romantic sanctuary featuring a private hot tub jacuzzi, complimentary champagne, and sunset terrace view.',
                'amenities' => ['Private Jacuzzi', 'Champagne Welcome', 'King Bed', 'Terrace View', 'Sound System'],
            ],
            [
                'id' => 9,
                'room_category_id' => 4,
                'name' => 'Garden Villa Cottage',
                'type' => 'Villa',
                'price' => 6500.00,
                'capacity' => 6,
                'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80',
                'description' => 'Secluded tropical garden cottage with 2 bedrooms, private veranda, outdoor hammock, and kitchen facility.',
                'amenities' => ['Private Garden', '2 Bedrooms', 'Full Kitchen', 'Outdoor Hammock', 'BBQ Grill'],
            ],
            [
                'id' => 10,
                'room_category_id' => 4,
                'name' => 'Beachfront Family Villa',
                'type' => 'Villa',
                'price' => 8500.00,
                'capacity' => 8,
                'image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80',
                'description' => 'Luxury 3-bedroom villa located steps away from the white sand beach with a private plunge pool.',
                'amenities' => ['Beachfront Access', 'Private Plunge Pool', '3 Bedrooms', 'Kitchenette', 'Private Butler'],
            ],
            [
                'id' => 11,
                'room_category_id' => 4,
                'name' => 'Overwater Premium Bungalow',
                'type' => 'Villa',
                'price' => 10000.00,
                'capacity' => 4,
                'image' => 'https://images.unsplash.com/photo-1439066615861-d1af74d74000?auto=format&fit=crop&w=800&q=80',
                'description' => 'Iconic bungalow built over clear turquoise waters with glass floor view panels and direct ocean access.',
                'amenities' => ['Glass Floor Views', 'Direct Ocean Access', 'Sun Deck', 'Infinity Dip Pool', 'Room Service'],
            ],
            [
                'id' => 12,
                'room_category_id' => 3,
                'name' => 'Penthouse Sky Loft',
                'type' => 'Suite',
                'price' => 12000.00,
                'capacity' => 6,
                'image' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80',
                'description' => 'Top-floor luxury penthouse with 360-degree resort skyline views, private infinity pool, and personal chef available.',
                'amenities' => ['Private Pool', 'Penthouse Level', 'Personal Chef Service', '3 Bedrooms', 'Smart Controls'],
            ],
        ];

        foreach ($rooms as $r) {
            $r['amenities'] = json_encode($r['amenities']);
            $r['created_at'] = now();
            $r['updated_at'] = now();
            Room::updateOrCreate(['id' => $r['id']], $r);
        }
    }
}