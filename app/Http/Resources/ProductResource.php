<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "name" => $this->name,
            'category_ids' => $this->categories->pluck('id')->implode(', '),
            'category_names' => $this->categories->pluck('name')->implode(', '),
            'tags_ids' => $this->tags->pluck('id')->implode(', '),
            'tags_names' => $this->tags->pluck('name')->implode(', '),
            "description" => $this->description,
            "short_description" => $this->short_description,
            "photo" => $this->photo,
            "created_at" => $this->created_at->format('d m Y'),
            "updated_at" => $this->updated_at->format('d m Y')
        ];
    }
}
