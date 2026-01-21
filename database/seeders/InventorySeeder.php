<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryCategory;
use App\Models\Product;

class InventorySeeder extends Seeder
{
    public function run()
    {
        $labId = 1;

        $categories = [
            'Reagents',
            'Glassware',
            'Kits',
            'Stationery'
        ];

        foreach ($categories as $cat) {
            $category = InventoryCategory::create(['lab_id' => $labId, 'name' => $cat]);
            
            // Add some dummy products
            if ($cat == 'Reagents') {
                Product::create([
                    'lab_id' => $labId, 'category_id' => $category->id, 'name' => 'Ethanol 99%', 'unit' => 'liter', 'quantity' => 10
                ]);
                Product::create([
                    'lab_id' => $labId, 'category_id' => $category->id, 'name' => 'Distilled Water', 'unit' => 'liter', 'quantity' => 50
                ]);
            }
            if ($cat == 'Kits') {
                 Product::create([
                    'lab_id' => $labId, 'category_id' => $category->id, 'name' => 'HIV Rapid Kit', 'unit' => 'box', 'quantity' => 5
                ]);
            }
        }
    }
}
