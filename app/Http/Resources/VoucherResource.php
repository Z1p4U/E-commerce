<?php

namespace App\Http\Resources;

use App\Models\VoucherRecord;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $date = $request->has('date') ? $request->date : $this->created_at;

        return [
            "id" => $this->id,
            "user_name" => $this->user->name,
            'address' => $this->address,
            "phone" => $this->phone,
            "voucher_number" => $this->voucher_number,
            "total_actual_price" => $this->total_actual_price,
            "total" => $this->total,
            "item_count" => VoucherRecordResource::collection(VoucherRecord::whereDate("created_at", $date)->where('voucher_id', $this->id)->get())->count('id'),
            "records" => VoucherRecordResource::collection(VoucherRecord::whereDate("created_at", $date)->where('voucher_id', $this->id)->get()),
            "created_at" => $this->created_at->format("d M Y"),
            "created_time" => $this->created_at->format("h:m A"),
        ];
    }
}
