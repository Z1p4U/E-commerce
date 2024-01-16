<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherRecord extends Model
{
    use HasFactory;

    protected $fillable = ["voucher_id", "item_id", "quantity", "cost"];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
