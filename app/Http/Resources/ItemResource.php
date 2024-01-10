<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            "sku" => $this->sku,
            'product_id' => $this->product->id,
            "product_name" => $this->product->name,
            "item_name" => $this->name,
            "size" => $this->size,
            "sale" => $this->sale,
            "price" => $this->price,
            "discount_price" => $this->discount_price,
            'categories' => $this->product->categories->pluck('name')->implode(', '),
            'tags' => $this->product->tags->pluck('name')->implode(', '),
            "item_description" => $this->description,
            "product_description" => $this->product->description,
            "product_short_description" => $this->product->short_description,
            "product_photo" => $this->product->photo,
            "item_photo" => $this->photo,
            "created_at" => $this->created_at->format('d m Y'),
            "updated_at" => $this->updated_at->format('d m Y')
        ];
    }
}
