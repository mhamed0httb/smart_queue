<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TicketWindow;
use App\Office;
use App\Staff;
use App\Service;

class TicketWindowsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allTicketWindows = TicketWindow::all();
        $allOffices = Office::all();
        $allStaffs = Staff::all();
        $allServices = Service::all();
        //$allTicketWindows = TicketWindow::with(array('office'))->get();
        return view ('manager.ticket_windows.index')
            ->with('allTicketWindows',$allTicketWindows)
            ->with('allOffices',$allOffices)
            ->with('allStaffs',$allStaffs)
            ->with('allServices',$allServices);
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
        $ticketWindow->office_id = $request->office_id;
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
        $staffs = Staff::all();
        $services = Service::all();
        $window = TicketWindow::find($id);
        $offices = Office::all();
        return view('manager.ticket_windows.status')
            ->with('window',$window)
            ->with('allStaffs',$staffs)
            ->with('allServices',$services)
            ->with('allOffices',$offices);
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
}
