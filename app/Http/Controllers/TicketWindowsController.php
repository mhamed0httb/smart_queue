<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\TicketWindow;
use App\Office;
use App\Staff;
use App\Service;
use Cartalyst\Sentinel\Users\EloquentUser;
use Sentinel;

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
        $staffs = Office::find($office->id)->staff;
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

    public function updateStatus(Request $request)
    {
        $ticketWindow = TicketWindow::find($request->window_id);
        $ticketWindow->staff_id = $request->staff_id;
        $ticketWindow->service_id = $request->service_id;
        $ticketWindow->status = 'Online';
        $ticketWindow->save();
        return redirect('/manager/ticket_windows');
    }

    public function deactivateWindow($id)
    {
        $window = TicketWindow::find($id);
        $window->staff_id = null;
        $window->service_id = null;
        $window->status = 'Offline';
        $window->save();
        return redirect('/manager/ticket_windows');

    }
}
