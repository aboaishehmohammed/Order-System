<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use SoftDeletes;

    protected $fillable = ["delivery", "sale", "category_id", "delivery_time", "order_done","extra_name","extra_price"];
    protected $appends = ['deliveryData'];
    protected $hidden = ['delivery'];
    public function billMorts()
    {
        return $this->hasOne(Mort::class);
    }

    public function billProducts()
    {
        return $this->hasMany(BillProduct::class);
    }

    public function getDeliveryDataAttribute()
    {
        if ($this->delivery != null) {
            return json_decode($this->delivery);
        } else {
            return null;
        }
    }

}
