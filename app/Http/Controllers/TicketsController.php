<?php

namespace App\Http\Controllers;

use App\TicketWindow;
use Illuminate\Http\Request;
use App\Ticket;
use App\Office;
use Cartalyst\Sentinel\Users\EloquentUser;
use Sentinel;
use Illuminate\Support\Facades\DB;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $office = EloquentUser::find(Sentinel::getUser()->id)->office;
        $allTickets = Office::find($office->id)->ticket;
        return view('manager.tickets.index')->with('allTickets',$allTickets);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

    public function createTicket(Request $request)
    {
        //Ticket::where('office_id', '=', $request->office_id)->first();
        $allTicketsByOffice = Office::find($request->office_id)->ticket;
        if($allTicketsByOffice->count() == 0){
            $newNumber = 1;
        }else{
            $maximumNumber = Ticket::where('office_id', '=', $request->office_id)->first()->number;
            foreach ($allTicketsByOffice as $one){
                if($one->number > $maximumNumber){
                    $maximumNumber = $one->number;
                }
            }
            if($maximumNumber == 20){
                $newNumber = 1;
            }else{
                $newNumber = $maximumNumber + 1;
            }
        }


        /*$allTickets = Office::find($request->office_id)->ticket;
        if($allTickets->count() == 0){
            return 'nothing';
        }else{
            return $allTickets;
        }*/

        $ticket = new Ticket;
        $ticket->office_id = $request->office_id;
        $ticket->owner_id = $request->owner_id;
        $ticket->number = $newNumber;
        $ticket->expired = false;
        $ticket->save();
        return 'ticket created';
    }

    public function updateTicket(Request $request)
    {
        $ticket = Ticket::find($request->ticket_id);
        /*$office = Office::find($ticket->office_id);
        $TicketWindows = Office::find($office->id)->ticketWindow;
        //TicketWindow::where('status', '=', 'Online')->first();
        $windows = DB::table('ticket_windows')
            ->where('status', 'Online')
            ->where('office_id','=', $office->id)
            ->limit(1)
            ->get();

        $wind = new TicketWindow;
        foreach($windows as $one){
            $ticket->ticket_window_id = $one->id;
        }
        return $ticket;*/

        $ticket->ticket_window_id = $request->ticket_window_id;
        $ticket->expired = true;
        $ticket->save();
        return 'ticket updated';
    }
}
