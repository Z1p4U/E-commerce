<?php

namespace App\Imports;

use App\Models\Item;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemsImport implements ToModel, ShouldQueue, WithHeadingRow, WithChunkReading
{

    public function model(array $row)
    {
        // Find the existing item by a unique identifier (e.g., 'name')
        $item = Item::where('sku', $row['sku'])->first();

        // If the item exists, update the 'price' attribute
        if ($item) {
            $item->update([
                'price' => $row['price'],
            ]);
        }

        return null;
    }

    // public function model(array $row)
    // {
    //     // Retrieve the item by its identifier (e.g., item_code)
    //     $item = Item::where('id', $row['id'])->first();

    //     if ($item) {
    //         // Detach the item from its current category
    //         $item->product()->detach();

    //         // Retrieve the new category by its ID
    //         $newProduct = Product::find($row['id']);

    //         if ($newProduct) {
    //             // Attach the item to the new category
    //             $item->category()->associate($newProduct);
    //             $item->save();

    //             // Optionally, you can update the category_id directly as well
    //             // $item->update(['category_id' => $newCategory->id]);

    //             // Return the updated item model
    //             return $item;
    //         }
    //     }

    //     // Return null to skip creating a new model instance
    //     return null;
    // }

    public function chunkSize(): int
    {
        return 100000; // this number represents number of rows
    }
}
