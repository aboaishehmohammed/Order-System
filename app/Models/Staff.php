<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;
    protected $fillable = ["name","salary"];

    public function staffSalary()
    {
        return $this->hasOne(staffSalary::class);
    }


}
