<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\TicketWindow;
use App\Office;
use App\Staff;
use App\Service;
use App\Ticket;
use Cartalyst\Sentinel\Users\EloquentUser;
use Sentinel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;

class TicketWindowsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$allTicketWindows = TicketWindow::all();
        $office = EloquentUser::find(Sentinel::getUser()->id)->office; //GET OFFICE OF MANAGER LOGGED IN
        $allTicketWindows = Office::find($office->id)->ticketWindow;
        return view ('manager.ticket_windows.index')
            ->with('allTicketWindows',$allTicketWindows);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allOffices = Office::all();
        return view('manager.ticket_windows.create')
            ->with('allOffices', $allOffices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ticketWindow = new TicketWindow;
        $ticketWindow->number = $request->number;
        $office = EloquentUser::find(Sentinel::getUser()->id)->office;
        $ticketWindow->office_id = $office->id;
        $ticketWindow->status = 'Offline';
        $ticketWindow->save();
        $request->session()->flash('status', 'Window was successfully created!');
        return redirect('/manager/ticket_windows');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $office = EloquentUser::find(Sentinel::getUser()->id)->office; //GET OFFICE OF MANAGER LOGGED IN
        //$staffs = Office::find($office->id)->staff;
        $staffs = DB::table('staffs')
            ->where('office_id', '=', $office->id)
            ->where('ticket_window_id', '=', null)
            ->get();
        $services = Company::find(Sentinel::getUser()->getCompany->id)->service;
        $window = TicketWindow::find($id);
        return view('manager.ticket_windows.status')
            ->with('window',$window)
            ->with('allStaffs',$staffs)
            ->with('allServices',$services);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $window = TicketWindow::find($id);
        return view('manager.ticket_windows.edit')->with('window', $window);
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
        $window = TicketWindow::find($id);
        $window->number = $request->number;
        $window->save();
        $request->session()->flash('update', 'Ticket Window was successfully updated!');
        return redirect('/manager/ticket_windows');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $window = TicketWindow::find($id);
        $staff = TicketWindow::find($id)->getStaff;
        if($staff != null){
            $staff->ticket_window_id = null;
            $staff->save();
        }
        $window->delete();
        Session::flash('delete', 'Successfully deleted the ticket window!');
        return redirect('/manager/ticket_windows');
    }

    public function updateStatus(Request $request)
    {
        $ticketWindow = TicketWindow::find($request->window_id);
        $ticketWindow->staff_id = $request->staff_id;
        $ticketWindow->service_id = $request->service_id;
        $ticketWindow->status = 'Online';
        $ticketWindow->save();
        $staff = Staff::find($request->staff_id);
        $staff->ticket_window_id = $request->window_id;
        $staff->save();
        Session::flash('activate', 'Ticket Window number : ' .$ticketWindow->number.' is now online!');
        return redirect('/manager/ticket_windows');
    }

    public function deactivateWindow($id)
    {
        $window = TicketWindow::find($id);
        $window->staff_id = null;
        $window->service_id = null;
        $window->ticket_id = null;
        $window->status = 'Offline';

        $staff = TicketWindow::find($id)->getStaff;
        $staff->ticket_window_id = null;
        $staff->save();
        /*
        $staff =  DB::table('staffs')
            ->where('ticket_window_id', '=', $id)
            ->first();

        $stf = Staff::find($staff->id);
        $stf->ticket_window_id = null;
        $stf->save();
        */
        $window->save();
        Session::flash('deactivate', 'Ticket Window number : ' .$window->number.' is now offline!');
        return redirect('/manager/ticket_windows');

    }

    public function getTicketWindowsStatus(Request $request)
    {
        $result = array();
        $allWindows = DB::table('ticket_windows')
            ->where('office_id', '=', $request->office_id)
            ->where('status', '=', 'Online')
            ->get();
        foreach ($allWindows as $one){
            $service = Service::find($one->service_id);
            $member = Staff::find($one->staff_id);
            $ticket = Ticket::find($one->ticket_id);
            $oneWindowInfo = array();
            $oneWindowInfo['service'] = $service->name;
            $oneWindowInfo['member'] = $member->first_name . ' ' . $member->last_name;
            if($ticket == null){
                $oneWindowInfo['ticket_number'] = 'not_yet';
            }else{
                $oneWindowInfo['ticket_number'] = $ticket->number;
            }
            $oneWindowInfo['window_number'] = $one->number;

            array_push($result,$oneWindowInfo);
        }
        return $result;
    }
}
