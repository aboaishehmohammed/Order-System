<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffPayment;
use Illuminate\Http\Request;

class StaffPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $staff)
    {
        $data = $request->all();
        $data['staff_id'] = $staff;
        return StaffPayment::create($data);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\StaffPayment $staffPayment
     * @return \Illuminate\Http\Response
     */
    public function show(StaffPayment $staffPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\StaffPayment $staffPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffPayment $staffPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StaffPayment $staffPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffPayment $staffPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\StaffPayment $staffPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffPayment $staffPayment)
    {
        $staffPayment->delete();
    }

    public function staffPayments($staff)
    {
        return StaffPayment::where("staff_id", $staff)->orderBy("created_at", "desc")->get();
    }
}
