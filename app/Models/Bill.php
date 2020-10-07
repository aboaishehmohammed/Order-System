<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use SoftDeletes;
    protected $fillable = ["delivery", "sale", "category_id"];

    public function billProducts()
    {
        return $this->hasMany(BillProduct::class);
    }
}
