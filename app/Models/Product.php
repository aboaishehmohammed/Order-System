<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $fillable = ["p_name", "price","category_id"];
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subProduct()
    {
        return $this->belongsToMany(SubProduct::class, "product_sub_product");
    }
}
