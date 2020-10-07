<?php

namespace App\Http\Controllers;

use App\Models\SubProduct;
use Illuminate\Http\Request;

class SubProductController extends Controller
{
    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'name' => 'required|max:255',
            "products" => "array|required",
            "products.*" => "required|exists:products,id",

        ]);

        $subProducts = SubProduct::create([
            "p_name" => $request->name,
        ]);
        $data = $request->all();

        $subProducts->products()->sync($data['products']);

    }

    //
    public function update(Request $request, $sub)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        $subProduct = SubProduct::findorfail($sub);
        $subProduct->p_name = $request->name;
        $subProduct->update();
    }

    public function destroy($sub)
    {
        SubProduct::findorfail($sub)->delete();
    }

    public function restore($sub)
    {
        SubProduct::onlyTrashed()->findOrFail($sub)->restore();
    }

    public function ajaxOne($sub)
    {
        $subProduct = SubProduct::findorfail($sub);
        return $subProduct;
    }

    public function ajaxAll()
    {
        $subProduct = SubProduct::all();
        return $subProduct;
    }

}
