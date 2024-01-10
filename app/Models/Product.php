<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, BasicAudit;

    public $fillable = ["name", "short_description", "description", "photo"];

    // public $appends = ["category_name", "tag_name"];

    // protected function getCategoryNameAttribute()
    // {
    //     $category = Category::where(['id' => $this->attributes['category_ids']])->first();

    //     if ($category) {
    //         return $category->name;
    //     } else {
    //         return null;
    //     }
    // }

    // protected function getTagsNameAttribute()
    // {
    //     $tags = Tags::where(['id' => $this->attributes['tag_ids']])->first();

    //     if ($tags) {
    //         return $tags->name;
    //     } else {
    //         return null;
    //     }
    // }

    public function categories()
    {
        return $this->belongsToMany(Category::class, "category_product");
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, "tag_product");
    }

    public function items()
    {
        $this->hasMany(Item::class);
    }
}
