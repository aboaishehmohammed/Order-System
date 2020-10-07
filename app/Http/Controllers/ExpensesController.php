<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0'
        ]);
        return Expenses::create([
            "name" => $request->name,
            "price" => $request->price
        ]);

    }

    //
    public function update(Request $request, $expenses)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        $expenses = Expenses::findorfail($expenses);
        $expenses->name = $request->name;
        $expenses->price = $request->price;
        $expenses->update();
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
        $expenses = Expenses::all();
        return $expenses;
    }
    //
}
