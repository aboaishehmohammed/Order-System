<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillProduct extends Model
{
    protected $fillable = ["price", "quantity", "product_id", "sub_product_id"];
    use SoftDeletes;

    public function product()
    {
        return $this->belongsTo(Product::class)->select(["id", "p_name"])->withTrashed();

    }

    public function subProduct()
    {
        return $this->belongsTo(SubProduct::class);
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
