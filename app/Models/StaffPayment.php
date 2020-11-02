<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffPayment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['month_d', "year_d", "payment", "staff_id"];
}
