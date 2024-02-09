<?php

namespace App\Http\Resources;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CheckoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $voucher = Voucher::where("id", $this->voucher_id)->get();
        return [
            "id" => $this->id,
            "status" => $this->status,
            "voucher" => VoucherResource::collection($voucher),
            "photo" => asset(Storage::url($this->photo)),
        ];
    }
}
