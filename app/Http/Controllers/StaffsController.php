<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;
use App\Office;
use Sentinel;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Support\Facades\DB;
use Session;

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
        $request->session()->flash('success', 'Staff member was successfully created!');
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
        //abort(404);
        $member = Staff::find($id);
        return view('manager.staff.edit')->with('member', $member);
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
        $member = Staff::find($id);
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->save();
        $request->session()->flash('update', 'Staff member was successfully updated!');
        return redirect('/manager/staffs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = Staff::find($id);
        $windows = Staff::find($id)->ticketWindow;
        foreach($windows as $one){
            $one->staff_id = null;
            $one->service_id = null;
            $one->ticket_id = null;
            $one->status = 'Offline';
            $one->save();
        }
        $staff->delete();
        Session::flash('delete', 'Successfully deleted the staff member!');
        //Session::flash('message', 'Successfully deleted the staff member!');
        return redirect('/manager/staffs');
    }

    public function getAllStaff(Request $req)
    {
        $allMembers = DB::table('staffs')
            ->where('office_id', '=', $req->office_id)
            ->get();
        $res = array();

        foreach ($allMembers as $one){
            $oneMember = array();
            $oneMember["id"] = $one->id;
            $oneMember["first_name"] = $one->first_name;
            $oneMember["last_name"] = $one->last_name;
            array_push($res,$oneMember);
        }
        return $res;
    }

    public function staffStatAllDay($id)
    {
        $stafMember = Staff::find($id);
        return view('manager.staff.staff_statistics')
            ->with('member',$stafMember);
    }

    public function staffsStatAllDay()
    {
        $office = EloquentUser::find(Sentinel::getUser()->id)->office;
        return view('manager.staff.statistics_all')->with('office',$office);
    }


}
