<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mort extends Model
{
    protected $fillable = ["label", "qty", "price"];
    use SoftDeletes;

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
