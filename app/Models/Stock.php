<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ["admin_id", "item_id", "quantity", 'more'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
