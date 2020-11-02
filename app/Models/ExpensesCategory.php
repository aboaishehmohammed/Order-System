<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpensesCategory extends Model
{    protected $fillable = ["name"];
    use SoftDeletes;

    public function expenses()
    {
        return $this->hasMany(Expenses::class);
    }
}
