<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "item_name" => $this->item->name,
            "item_photo" => $this->item->photo,
            "item_price" => $this->item->price,
            "item_discount_price" => $this->item->discount_price,
            "quantity" => $this->quantity,
            "total_cost" => $this->cost,
            "created_at" => $this->created_at->format("d M Y"),
        ];
    }
}
