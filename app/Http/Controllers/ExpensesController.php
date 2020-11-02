<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpensesController extends Controller
{
    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'expenses_category_id' => 'required|exists:expenses_categories,id'

        ]);
        $expenses = Expenses::create([
            "name" => $request->name,
            "price" => $request->price,
            "expenses_category_id" => $request->expenses_category_id

        ]);

        return Expenses::with("expensesCategory")->findOrFail($expenses->id);
    }

    //
    public function update(Request $request, $expenses)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required',
            'expenses_category_id' => 'required|exists:expenses_categories,id'

        ]);
        $expenses = Expenses::findorfail($expenses);
        $expenses->name = $request->name;
        $expenses->price = $request->price;
        $expenses->expenses_category_id = $request->expenses_category_id;
        $expenses->update();
        return Expenses::with("expensesCategory")->findOrFail($expenses->id);
    }

    public function destroy($expenses)
    {
        Expenses::findorfail($expenses)->delete();
    }

    public function restore($expenses)
    {
        Expenses::onlyTrashed()->findOrFail($expenses)->restore();
    }

    public function ajaxOne($expenses)
    {
        $expenses = Expenses::findorfail($expenses);
        return $expenses;
    }

    public function ajaxAll()
    {
        $expenses = Expenses::orderBy("created_at", 'desc')->paginate(30);
        return $expenses;
    }

    public function report(Request $request)
    {
        $request->validate([
            "type" => "required|in:month,year,daily"
        ]);
        $expenses = Expenses::withoutTrashed();

        switch ($request->type) {
            case 'daily':
                $expenses->whereRaw(DB::raw("date(created_at)=current_date"));
                break;
            case 'month':
                $request->validate(["month" => "required|numeric", "year" => "required|numeric"]);
                $year = $request->year;
                $month = $request->month;
                $expenses->whereRaw(DB::raw("year(date(created_at))=$year"));
                $expenses->whereRaw(DB::raw("month(date(created_at))=$month"));

                break;
            case 'year':
                $request->validate(["year" => "required|numeric"]);
                $year = $request->year;
                $expenses->whereRaw(DB::raw("year(date(created_at))=" . $year));
                break;
            default :
                return response("NO Content", 204);
        }
        return $expenses->sum(DB::raw("price"));


    }


    //
}
