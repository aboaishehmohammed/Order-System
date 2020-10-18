<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillProduct;
use App\Models\Mort;
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
        return Bill::with(["billProducts"])->orderBy("created_at", 'desc')->paginate(20);
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
                "delivery.name" => "required",
                "delivery.delivery_fees" => "required|numeric",
                "delivery.delivery_time" => "required|date",
            ]);;
            $date = date("Y-m-d H:i:s", strtotime($request->delivery['delivery_time']));
            /*return response($date, 403);*/
            //return response(Carbon::createFromFormat("Y-m-d H:i:s a", $request->delivery['delivery_time']), 403);
            $delivery = json_encode($request->delivery);
            $f = false;


        }
        $bill = Bill::create(
            [
                "delivery" => $delivery,
                "sale" => $request->sale,
                "delivery_time" => $date,
                "order_done" => $f,
                "extra_name" => $request->extra_name,
                "extra_price" => $request->extra_price
            ]
        );
        if ($request->has("label")) {
            $bill->billMorts()->create([
                "label" => $request->label,
                "qty" => $request->qty,
                "price" => $request->price
            ]);
        }
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

    public function mortsData()
    {
        return Mort::with(["bill"])->whereHas("bill")->get();
    }

    public function mortDestroy($mort)
    {
        Mort::findorfail($mort)->delete();
    }

    public function report(Request $request)
    {
        $request->validate([
            "type" => "required|in:month,year,daily"
        ]);
        $bills = BillProduct::whereHas("bill");
        if ($request->type == 'daily')
            $bills->whereRaw(DB::raw("date(created_at)=current_date"));
        else
            if ($request->type == 'month') {
                $request->validate(["month" => "required|numeric", "year" => "required|numeric"]);
                $year = $request->year;
                $month = $request->month;
                $bills->whereRaw(DB::raw("year(date(created_at))=" . $year));
                $bills->whereRaw(DB::raw("month(date(created_at))=" . $month));
            } else {
                if ($request->type == 'year') {

                    $request->validate(["year" => "required|numeric"]);
                    $year = $request->year;

                    $bills->whereRaw(DB::raw("year(date(created_at))=" . $year));

                } else {
                    return response("NO Content", 204);
                }
            }


        return $bills->sum(DB::raw("price*quantity"));
    }
    //
}
