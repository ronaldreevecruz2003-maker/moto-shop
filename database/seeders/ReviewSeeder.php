<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $oil = Part::where('sku', 'CAS-PWR1-10W40')->first();
        $cvt = Part::where('sku', 'JVT-CVT-NMAX')->first();
        $pipe = Part::where('sku', 'JVT-V3-PIPE')->first();

        Review::firstOrCreate(
            ['customer_name' => 'Mark Anthony Ordono', 'type' => 'mechanic'],
            [
                'motorcycle_model' => 'Yamaha NMAX 155',
                'rating' => 5,
                'comment' => 'Pulido gumawa ng pang-gilid ang mga mekaniko dito sa Balaoan Cycle Parts. Nawala yung dragging ng NMAX ko at maayos magpaliwanag bago magpalit ng piyesa.',
                'is_approved' => true,
            ]
        );

        Review::firstOrCreate(
            ['customer_name' => 'Jayson Cabanilla', 'type' => 'product', 'part_id' => $oil?->id],
            [
                'motorcycle_model' => 'Honda Click 125i',
                'rating' => 5,
                'comment' => 'Legit Castrol Power1 Racing! Ramdam agad yung gaan ng hatak at hindi mabilis mag-init makina kahit long ride papuntang La Union.',
                'is_approved' => true,
            ]
        );

        Review::firstOrCreate(
            ['customer_name' => 'Kervin Lopez', 'type' => 'product', 'part_id' => $cvt?->id],
            [
                'motorcycle_model' => 'Yamaha Aerox 155',
                'rating' => 5,
                'comment' => 'Ginamit ko yung Buy + Install option nila - pagdating ko sa shop nakahanda na yung JVT Pulley set at kinabit agad. Swabe arangkada!',
                'is_approved' => true,
            ]
        );

        Review::firstOrCreate(
            ['customer_name' => 'Ryan Bautista', 'type' => 'mechanic'],
            [
                'motorcycle_model' => 'Suzuki Raider R150 FI',
                'rating' => 5,
                'comment' => 'Mabilis mag-FI cleaning at tune-up, transparent pa sa labor fee. Dito na ako lagi nagpapa-maintenance.',
                'is_approved' => true,
            ]
        );

        Review::firstOrCreate(
            ['customer_name' => 'Carlo Mendoza', 'type' => 'product', 'part_id' => $pipe?->id],
            [
                'motorcycle_model' => 'Yamaha NMAX 155',
                'rating' => 5,
                'comment' => 'Buong-buo yung tunog ng JVT V3 pipe at walang singaw yung pagkakakabit ng mekaniko. Solid!',
                'is_approved' => true,
            ]
        );
    }
}