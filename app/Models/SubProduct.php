<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubProduct extends Model
{
    protected $fillable = ["p_name"];
    use SoftDeletes;

    public function products()
    {
        return $this->belongsToMany(Product::class, "product_sub_product");
    }
}
