<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    public function getProductPrice($product)
    {
        return Product::findOrFail($product)->price;
    }

    public function ajaxAll()
    {
        $bills = Bill::with(["billProducts" => function ($q) {
            $q->with(["product"]);
        }])->orderBy("created_at", 'desc')->get();//paginate(10);
        return $bills;
    }

    public function delivery()
    {
        $deliveries = Bill::select(DB::raw("*,( JSON_EXTRACT(delivery, '$.delivery_time')) as delivery_time"))->whereRaw(DB::raw("delivery is not null and delivery_time >CURRENT_DATE and order_done=false"))
            ->get();
        return $deliveries;
    }

    public function orderDone($order)
    {
        $order = Bill::findorfail($order);
        $order->order_done = true;
        $order->update();
    }

    public function paginate()
    {
        return Bill::with(["billProducts"])->paginate(20);
    }

    public function ajaxOne($bill)
    {
        $bills = Bill::with([
            "billProducts" => function ($q) {
                $q->with(["product" => function ($q) {
                    //    $q->with(["subProduct"]);
                }, "subProduct"]);
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
        $date = null;
        $delivery = null;
        $f = true;
        if ($request->has("delivery")) {
            $request->validate([
                "delivery.delivery_fees" => "required|numeric",
                "delivery.delivery_time" => "required|date",


            ]);
            $date = date("Y-m-d H:i:s a", strtotime($request->delivery['delivery_time']));
            //return response(Carbon::createFromFormat("Y-m-d H:i:s a", $request->delivery['delivery_time']), 403);
            $delivery = json_encode($request->delivery);
            $f = false;
        }
        $bill = Bill::create(
            [
                "delivery" => $delivery,
                "sale" => $request->sale,
                "delivery_time" => $date,
                "order_done" => $f
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
        return $bill;
    }

    public function getBillsForProductId($product_id)
    {
        return BillProduct::whereHas("bill")->with(["subProduct"])->where("product_id", "=", $product_id)->paginate(9);
    }
    //
}
