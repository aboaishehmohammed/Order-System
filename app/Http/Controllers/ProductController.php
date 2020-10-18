<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:Categories,id'
        ]);
        $product = Product::create([
            "p_name" => $request->name,
            "price" => $request->price,
            "category_id" => $request->category_id
        ]);

        return Product::with("category")->findOrFail($product->id);

    }

    //
    public function update(Request $request, $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:Categories,id'
        ]);
        $product = Product::findorfail($product);
        $product->p_name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->update();
        return Product::with(['category'])->findOrFail($product->id);
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
        $product = Product::select(DB::raw("*,(select avg(price) from bill_products where deleted_at is null and
        product_id=products.id) as avg,(select sum(quantity) from bill_products where deleted_at is null and
         product_id=products.id) as summ"))->with(['sales' => function ($q) {
            $q->with(['subProduct']);
            $q->orderBy("created_at", "desc");
        }])->withCount("sales")->findorfail($product);
        return $product;
    }

    public function ajaxAll()
    {
        $product = Product::with([
            "category"
        ])->get();
        return $product;
    }

//    public function productBills($product){
//        $bill = Product::whereHas('sales', function (Builder $query) {
//
//        })->get();
//    }
    //
}
