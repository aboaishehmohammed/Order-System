<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Product;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function getProductPrice($product)
    {
        return Product::findOrFail($product)->price;
    }

    public function ajaxAll()
    {
        $bills = Bill::all();
        return $bills;
    }

    public function ajaxOne($bill)
    {
        $bills = Bill::with([
            "billProducts" => function ($q) {
                $q->with(["product" => function ($q) {
                    //$q->withTrashed();
                }]);
            }
        ])->findorfail($bill);
        return $bills;
    }
    public function destroy($bill)
    {
        Bill::findorfail($bill)->delete();
    }

    public function restore($bill)
    {
        Bill::onlyTrashed()->findOrFail($bill)->restore();
    }
    public function store(Request $request)
    {

        $request->validate([
            "sale" => "numeric",
            "products" => "required|array",
            "products.*.id" => "required",
            "products.*.quantity" => "required|numeric",
            "products.*.sub_product_id" => "nullable|exists:sub_products,id",
        ]);

        /*
         * Delivery
         * {addresss,delivery_fees,delivery_time,mobile}
         *
         * */
        if ($request->has("delivery")) {
            $request->validate([
                "delivery.address" => "required",
                "delivery.delivery_fees" => "required|numeric",
                "delivery.delivery_time" => "required",
                "delivery.mobile" => "required|numeric",

            ]);
        }
        $bill = Bill::create(
            [
                "delivery" => json_encode($request->delivery),
                "sale" => $request->sale,
            ]
        );
        $products = $request->products;
        for ($i = 0; $i < sizeof($products); $i++) {
            $bill->billProducts()->create(
                [
                    "price" => $this->getProductPrice($products[$i]['id']),
                    "quantity" => $products[$i]['quantity'],
                    "product_id" => $products[$i]['id'],
                    "sub_product_id" => $products[$i]['sub_product_id']
                ]
            );
        }
    }

    public function update(Request $request, $bill)
    {
        return response("forbiden", 403);
        $request->validate([
            "sale" => "numeric",
            "products" => "required|array",
            "products.*.id" => "required",
            "products.*.quantity" => "required|numeric",
            "products.*.sub_product_id" => "nullable|exists:sub_products,id",
        ]);

        /*
         * Delivery
         * {addresss,delivery_fees,delivery_time,mobile}
         *
         * */
        if ($request->has("delivery")) {
            $request->validate([
                "delivery.address" => "required",
                "delivery.delivery_fees" => "required|numeric",
                "delivery.delivery_time" => "required",
                "delivery.mobile" => "required|numeric",

            ]);
        }
        $bill = Bill::findorfail($bill);
        $bill->delivery = $request->delivery;
        $bill->sale = $request->sale;
        $bill->update();

        $products = $request->products;
        for ($i = 0; $i < sizeof($products); $i++) {
            $bill->billProducts()->update(
                [
                    "price" => $this->getProductPrice($products[$i]['id']),
                    "quantity" => $products[$i]['quantity'],
                    "product_id" => $products[$i]['id'],
                    "sub_product_id" => $products[$i]['sub_product_id']
                ]
            );
        }
    }

    //
}
