<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory, BasicAudit;

    public $fillable = ["name", "sku", "product_id", "size", "sale", "price", "discount_price", "total_stock", "description", "photo"];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, VoucherRecord::class);
    }
}
