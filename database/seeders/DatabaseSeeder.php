<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MotorcycleModel;
use App\Models\Part;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Motorcycle Models
        $nmax = MotorcycleModel::firstOrCreate(['brand' => 'Yamaha', 'name' => 'NMAX 155']);
        $aerox = MotorcycleModel::firstOrCreate(['brand' => 'Yamaha', 'name' => 'Aerox 155']);
        $click125 = MotorcycleModel::firstOrCreate(['brand' => 'Honda', 'name' => 'Click 125i']);
        $click160 = MotorcycleModel::firstOrCreate(['brand' => 'Honda', 'name' => 'Click 160']);
        $raider = MotorcycleModel::firstOrCreate(['brand' => 'Suzuki', 'name' => 'Raider R150 FI']);
        $tmx = MotorcycleModel::firstOrCreate(['brand' => 'Honda', 'name' => 'TMX 125 Alpha']);

        // 2. Complete Motorcycle Shop Categories
        $oils = Category::firstOrCreate(['slug' => 'oils-lubricants'], ['name' => 'Oils & Lubricants']);
        $engine = Category::firstOrCreate(['slug' => 'engine-parts'], ['name' => 'Engine Parts']);
        $cvt = Category::firstOrCreate(['slug' => 'cvt-transmission'], ['name' => 'CVT & Transmission']);
        $brakes = Category::firstOrCreate(['slug' => 'brakes-tires'], ['name' => 'Brakes & Tires']);
        $electrical = Category::firstOrCreate(['slug' => 'electrical-lighting'], ['name' => 'Electrical & Lighting']);
        $suspension = Category::firstOrCreate(['slug' => 'suspension-chassis'], ['name' => 'Suspension & Chassis']);
        $exhaust = Category::firstOrCreate(['slug' => 'exhaust-performance'], ['name' => 'Exhaust & Performance']);
        $accessories = Category::firstOrCreate(['slug' => 'body-accessories'], ['name' => 'Body & Accessories']);

        // 3. Sample Parts Across Categories
        $oil = Part::firstOrCreate(
            ['sku' => 'CAS-PWR1-10W40'],
            [
                'category_id' => $oils->id,
                'name' => 'Castrol Power1 Racing 4T 10W-40 (1L)',
                'brand' => 'Castrol',
                'description' => 'Full synthetic motorcycle engine oil for maximum acceleration.',
                'price' => 520.00,
                'stock_quantity' => 24,
                'is_active' => true,
            ]
        );
        $oil->compatibleModels()->sync([$nmax->id, $aerox->id, $click125->id, $click160->id, $raider->id]);

        $piston = Part::firstOrCreate(
            ['sku' => 'UMA-62MM-BLK'],
            [
                'category_id' => $engine->id,
                'name' => 'UMA Racing Ceramic Cylinder Block Kit 62mm',
                'brand' => 'UMA Racing',
                'description' => 'Forged piston & ceramic cylinder block kit for high durability and torque.',
                'price' => 6400.00,
                'stock_quantity' => 5,
                'is_active' => true,
            ]
        );
        $piston->compatibleModels()->sync([$nmax->id, $aerox->id]);

        $sparkPlug = Part::firstOrCreate(
            ['sku' => 'NGK-IRIDIUM-CPR8'],
            [
                'category_id' => $engine->id,
                'name' => 'NGK Iridium IX Spark Plug (CPR8EAIX-9)',
                'brand' => 'NGK',
                'description' => 'Fine iridium tip for faster starts, smoother idle, and better fuel efficiency.',
                'price' => 480.00,
                'stock_quantity' => 18,
                'is_active' => true,
            ]
        );
        $sparkPlug->compatibleModels()->sync([$click125->id, $click160->id, $nmax->id, $aerox->id]);

        $cvtSet = Part::firstOrCreate(
            ['sku' => 'JVT-CVT-NMAX'],
            [
                'category_id' => $cvt->id,
                'name' => 'JVT Pulley & Drive Face Set',
                'brand' => 'JVT',
                'description' => 'Complete racing pulley kit with flyballs and center spring.',
                'price' => 2850.00,
                'stock_quantity' => 4,
                'is_active' => true,
            ]
        );
        $cvtSet->compatibleModels()->sync([$nmax->id, $aerox->id]);

        $brakePad = Part::firstOrCreate(
            ['sku' => 'RCB-BP-CLK125'],
            [
                'category_id' => $brakes->id,
                'name' => 'RCB Ceramic Front Brake Pads',
                'brand' => 'Racing Boy (RCB)',
                'description' => 'High-friction ceramic brake pads for daily and touring use.',
                'price' => 380.00,
                'stock_quantity' => 15,
                'is_active' => true,
            ]
        );
        $brakePad->compatibleModels()->sync([$click125->id, $click160->id]);

        $battery = Part::firstOrCreate(
            ['sku' => 'MOTOLITE-YTZ6V'],
            [
                'category_id' => $electrical->id,
                'name' => 'Motolite Maintenance-Free Gel Battery (YTZ6V)',
                'brand' => 'Motolite',
                'description' => 'Heavy-duty sealed gel battery with high cranking power.',
                'price' => 1250.00,
                'stock_quantity' => 10,
                'is_active' => true,
            ]
        );
        $battery->compatibleModels()->sync([$click125->id, $click160->id, $raider->id]);

        $shock = Part::firstOrCreate(
            ['sku' => 'RCB-MB2-330MM'],
            [
                'category_id' => $suspension->id,
                'name' => 'RCB MB2 Series Rear Shock Absorber (330mm)',
                'brand' => 'Racing Boy (RCB)',
                'description' => 'Adjustable spring preload rear mono/dual shock absorber.',
                'price' => 3650.00,
                'stock_quantity' => 6,
                'is_active' => true,
            ]
        );
        $shock->compatibleModels()->sync([$click125->id, $click160->id]);

        $pipe = Part::firstOrCreate(
            ['sku' => 'JVT-V3-PIPE'],
            [
                'category_id' => $exhaust->id,
                'name' => 'JVT V3 Adjustable Power Pipe',
                'brand' => 'JVT',
                'description' => 'Stainless steel canister with adjustable silencer.',
                'price' => 4500.00,
                'stock_quantity' => 3,
                'is_active' => true,
            ]
        );
        $pipe->compatibleModels()->sync([$nmax->id, $aerox->id, $click125->id]);
    }
}
