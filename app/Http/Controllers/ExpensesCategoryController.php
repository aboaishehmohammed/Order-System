<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Models\ExpensesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpensesCategoryController extends Controller
{
    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        return ExpensesCategory::create([
            "name" => $request->name
        ]);

    }

    //
    public function update(Request $request, $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        $category = ExpensesCategory::findorfail($category);
        $category->name = $request->name;
        $category->update();
    }

    public function destroy($category)
    {
        ExpensesCategory::findorfail($category)->delete();
    }

    public function restore($category)
    {
        ExpensesCategory::onlyTrashed()->findOrFail($category)->restore();
    }

    public function getExpensesOfCategory($category, Request $request)
    {

        $expenses = Expenses::where('expenses_category_id', $category)->orderby("created_at", 'desc');
        if ($request->has("start_date") && $request->has("end_date") && $request->start_date != null & $request->end_date != null) {
            $request->validate([
                "start_date" => "date",
                "end_date" => "date"
            ]);
            $start_date = date("Y-m-d", strtotime($request->start_date));
            $end_date = date("Y-m-d", strtotime($request->end_date));
            $expenses->whereRaw(DB::raw("date(created_at)>='" . $start_date . "'  AND date(created_at)<='" . $end_date . "'"));

        }
        return $expenses->orderBy("created_at", "desc")->paginate(32);

    }

    public function ajaxOne($category)
    {

        return ExpensesCategory::findorfail($category);

    }

    public function ajaxAll()
    {
        $category = ExpensesCategory::with([
            "expenses"
        ])->orderBy("created_at", 'desc')->get();
        return $category;
    }

    public function getExpensesOfCategoryReports(Request $request, $category)
    {
        $request->validate([
            "start_date" => "required|date",
            "end_date" => "required|date"
        ]);
        $start_date = date("Y-m-d", strtotime($request->start_date));
        $end_date = date("Y-m-d", strtotime($request->end_date));

        $expenses = Expenses::where('expenses_category_id', $category)->withoutTrashed();


        $expenses->whereRaw(DB::raw("date(created_at)>='" . $start_date . "'  AND date(created_at)<='" . $end_date . "'"));
        return $expenses->get();
    }

    //
}
