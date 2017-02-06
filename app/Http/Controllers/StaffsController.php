<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;
use App\Office;
use Sentinel;
use Cartalyst\Sentinel\Users\EloquentUser;

class StaffsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$allStaff = Staff::all();


        $office = EloquentUser::find(Sentinel::getUser()->id)->office; //GET OFFICE OF MANAGER LOGGED IN
        $allStaff = Office::find($office->id)->staff; //GET ALL STAFF OF OFFICE OF MANAGER LOGGED IN
        return view('manager.staff.index')->with('allStaff',$allStaff);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('admin.staff.create');
        return view('manager.staff.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $staff = new Staff;
        $staff->first_name = $request->first_name;
        $staff->last_name = $request->last_name;

        $office = EloquentUser::find(Sentinel::getUser()->id)->office;
        $staff->office_id = $office->id;
        $staff->save();
        return redirect('/manager/staffs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
