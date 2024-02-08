<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory, BasicAudit;

    protected $fillable = ["user_id", "address", "phone", "voucher_number", "total_items", "total"];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voucherRecords()
    {
        return $this->hasMany(VoucherRecord::class);
    }

    public function recordedItems()
    {
        return $this->belongsToMany(Item::class, VoucherRecord::class);
    }

    public function checkout()
    {
        return $this->hasMany(Checkout::class);
    }
}
