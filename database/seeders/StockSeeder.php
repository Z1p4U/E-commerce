<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocks = [];

        for ($i = 1; $i <= 1000; $i++) {
            $randQuantity = rand(1, 100);

            $stocks[] = [
                "admin_id" => 1,
                "item_id" => $i,
                "quantity" => $randQuantity,
                "created_at" => now(),
                "updated_at" => now(),
            ];

            $currentProduct = Item::find($i);
            $currentProduct->total_stock += $randQuantity;
            $currentProduct->update();
        }

        Stock::insert($stocks);
    }
}
