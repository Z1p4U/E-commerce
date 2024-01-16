<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Voucher;
use App\Models\VoucherRecord;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $endDate = Carbon::now();
        $startDate = Carbon::create(2022, 7, 1);

        $period = CarbonPeriod::create($startDate, $endDate);
        $id = 1;
        foreach ($period as $index => $day) {
            $vouchers = [];
            $voucherCount = random_int(1, 10);
            for ($i = 1; $i <= $voucherCount; $i++) {
                $ids = [];
                $itemId = random_int(1, 10);
                for ($y = 1; $y <= $itemId; $y++) {
                    $ids[] = random_int(1, 20);
                }

                $items = Item::whereIn('id', $ids)->get();
                $total = 0;
                $totalActualPrice = 0;

                $records = [];
                foreach ($ids as $itemId) {
                    $quantity = random_int(1, 10);
                    $currentItem = $items->find($itemId);
                    $totalActualPrice += $quantity * $currentItem->price;
                    $total += $quantity * $currentItem->discount_price;

                    $records[] = [
                        "voucher_id" => $id,
                        "item_id" => $itemId,
                        "quantity" => $quantity,
                        "cost" => $quantity * $currentItem->discount_price,
                        "created_at" => $day,
                        "updated_at" => $day
                    ];

                    Item::where("id", $itemId)->update([
                        "total_stock" => $currentItem->total_stock - $quantity
                    ]);
                }

                VoucherRecord::insert($records); // use database

                $vouchers[] = [
                    "voucher_number" => $id,
                    'address' => fake()->address(),
                    'phone' => fake()->phoneNumber(),
                    "total_actual_price" => $totalActualPrice,
                    "total" => $total,
                    "user_id" => rand(1, 50),
                    "created_at" => $day,
                    "updated_at" => $day
                ];
                $id++;
            }
            Voucher::insert($vouchers);
        }
    }
}
