<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        return Category::create([
            "name" => $request->name
        ]);

    }

    //
    public function update(Request $request, $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        $category = Category::findorfail($category);
        $category->name = $request->name;
        $category->update();
    }

    public function destroy($category)
    {
        Category::findorfail($category)->delete();
    }

    public function restore($category)
    {
        Category::onlyTrashed()->findOrFail($category)->restore();
    }

    public function ajaxOne($category)
    {
        $category = Category::findorfail($category);
        return $category;
    }
    public function ajaxAll()
    {
        $category = Category::all();
        return $category;
    }
}
