<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expenses extends Model
{
    protected $fillable = ["name","price","expenses_category_id"];

    use SoftDeletes;
    public function expensesCategory()
    {
        return $this->belongsTo(ExpensesCategory::class);
    }
}
