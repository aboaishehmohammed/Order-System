<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {


         $request->validate([
            'name' => 'required|max:255',
            'price'=>'required|numeric|min:0',
            'category_id'=>'required|exists:Categories,id'
        ]);
        return Product::create([
            "p_name" => $request->name,
            "price" => $request->price,
            "category_id" => $request->category_id
        ]);

    }

    //
    public function update(Request $request, $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price'=>'required|numeric|min:0',
            'category_id'=>'required|exists:Categories,id'
        ]);
        $product = Product::findorfail($product);
        $product->p_name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->update();
    }

    public function destroy($product)
    {
        Product::findorfail($product)->delete();
    }

    public function restore($product)
    {
        Product::onlyTrashed()->findOrFail($product)->restore();
    }
    public function ajaxOne($product)
    {
        $product = Product::findorfail($product);
        return $product;
    }
    public function ajaxAll()
    {
        $product = Product::all();
        return $product;
    }
    //
}
