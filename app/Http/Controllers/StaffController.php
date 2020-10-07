<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'sallery' => 'required|numeric|min:0'
        ]);
        return Staff::create([
            "name" => $request->name,
            "sallery" => $request->sallery
        ]);

    }

    //
    public function update(Request $request, $sallery)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'sallery' => 'required|numeric|min:0'

        ]);
        $sallery = Staff::findorfail($sallery);
        $sallery->name = $request->name;
        $sallery->price = $request->sallery;
        $sallery->update();
    }

    public function destroy($sallery)
    {
        Staff::findorfail($sallery)->delete();
    }

    public function restore($sallery)
    {
        Staff::onlyTrashed()->findOrFail($sallery)->restore();
    }

    public function ajaxOne($sallery)
    {
        $sallery = Staff::findorfail($sallery);
        return $sallery;
    }

    public function ajaxAll()
    {
        $sallery = Staff::all();
        return $sallery;
    }
    //
}
