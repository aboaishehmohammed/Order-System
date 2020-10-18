<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\staffSalary;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'salary' => 'required|numeric|min:0'
        ]);
        return Staff::create([
            "name" => $request->name,
            "salary" => $request->salary
        ]);

    }

    //
    public function update(Request $request, $staff)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'salary' => 'required|numeric|min:0'

        ]);
        $staff = Staff::findorfail($staff);
        $staff->name=$request->name;
        $staff->salary=$request->salary;
        $staff->update();
        return $staff;

    }

    public function destroy($staff)
    {
        Staff::findorfail($staff)->delete();
    }

    public function restore($staff)
    {
        Staff::onlyTrashed()->findOrFail($staff)->restore();
    }

    public function ajaxOne($staff)
    {
        $staff = Staff::findorfail($staff);
        return $staff;
    }

    public function ajaxAll()
    {
        return Staff::all();
    }

    //
//    public function salary(Request $request, $staff){
//        $staff=Staff::findorfail($staff);
//        $staff->staffSalary()->update([
//        "total_salary"=>$request->total_salary
//    ]);
//        return $staff;
//    }
}
