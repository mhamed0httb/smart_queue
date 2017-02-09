<?php

namespace App\Http\Controllers;

use App\TicketWindow;
use Illuminate\Http\Request;
use App\Ticket;
use App\Office;
use App\History;
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
        $allTicketsByOffice = DB::table('tickets') //GET ALL TICKETS WAITING
            ->where('expired', '=', false)
            ->where('office_id', '=', $request->office_id)
            ->get();
        if($allTicketsByOffice->count() == 0){
            $newNumber = 1;
        }else{
            $initTicket = DB::table('tickets')
                ->where('expired', '=', false)
                ->where('office_id', '=', $request->office_id)
                ->first();
            $maximumNumber = $initTicket->number;
            foreach ($allTicketsByOffice as $one)
            {
                if($one->number > $maximumNumber)
                {
                    $maximumNumber = $one->number;
                }
            }
            if($maximumNumber == 20)
            {
                $newNumber = 1;
            }else{
                $newNumber = $maximumNumber + 1;
            }
        }

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

    public function ServeTicket2(Request $request)
    {
        $ticketWindow = TicketWindow::find($request->ticket_window_id);
        //IF TICKET WINDOW IS NOT SERVING ANYONE
        if($ticketWindow->ticket_id == null){
            $allTicketsWaiting = DB::table('tickets') //GET ALL TICKETS WAITING
                ->where('expired', '=', false)
                ->where('office_id', '=', $ticketWindow->office_id)
                ->where('status', '=', 'waiting')
                ->get();
            if(! $allTicketsWaiting->count() == 0){ //IF THERE ARE TICKETS WAITING
                $initTicket = DB::table('tickets')  //GET FIRST RESULT FOR TICKETS WAITING
                    ->where('expired', '=', false)
                    ->where('office_id', '=', $ticketWindow->office_id)
                    ->where('status', '=', 'waiting')
                    ->first();
                $minimumNumber = $initTicket->number; //INITIALIZE MINIMUM NUMBER OF TICKETS
                $idTicketChosen = $initTicket->id; //INITIALIZE TICKET ID WHICH HAVE THE MINIMUM NUMBER
                foreach ($allTicketsWaiting as $one){  //FETCH THE TICKET WHO HAVE THE MINIMUM NUMBER
                    if($one->number < $minimumNumber)
                    {
                        $minimumNumber = $one->number;
                        $idTicketChosen = $one->id;
                    }
                }
                $ticketChosen = Ticket::find($idTicketChosen);
                $ticketChosen->status = 'in_service';
                $ticketChosen->ticket_window_id = $ticketWindow->id;
                $ticketChosen->save();
                $ticketWindow->ticket_id = $idTicketChosen;
                $ticketWindow->save();
                $history = new History;
                $history->ticket_window_id = $ticketWindow->id;
                $history->ticket_id = $idTicketChosen;
                $history->user_id = $ticketChosen->owner_id;
                $history->service_id = $ticketWindow->service_id;
                $history->office_id = $ticketWindow->office_id;
                $history->staff_id = $ticketWindow->staff_id;
                $history->save();
            }
        }
        //IF TICKET WINDOW IS SERVING A CUSTOMER
        else{
            $ticketServing = Ticket::find($ticketWindow->ticket_id);
            $ticketServing->status = 'served';
            $ticketServing->expired = true;
            $ticketServing->save();
            $history = Ticket::find($ticketServing->id)->history;
            $history->ticket_served = true;
            $history->save();

            $allTicketsWaiting = DB::table('tickets')
                ->where('expired', '=', false)
                ->where('office_id', '=', $ticketWindow->office_id)
                ->where('status', '=', 'waiting')
                ->get();
            if(! $allTicketsWaiting->count() == 0){
                $initTicket = DB::table('tickets')
                    ->where('expired', '=', false)
                    ->where('office_id', '=', $ticketWindow->office_id)
                    ->where('status', '=', 'waiting')
                    ->first();
                $minimumNumber = $initTicket->number;
                $idTicketChosen = $initTicket->id;
                foreach ($allTicketsWaiting as $one){
                    if($one->number < $minimumNumber)
                    {
                        $minimumNumber = $one->number;
                        $idTicketChosen = $one->id;
                    }
                }
                $ticketChosen = Ticket::find($idTicketChosen);
                $ticketChosen->status = 'in_service';
                $ticketChosen->ticket_window_id = $ticketWindow->id;
                $ticketChosen->save();
                $ticketWindow->ticket_id = $idTicketChosen;
                $ticketWindow->save();
                $history = new History;
                $history->ticket_window_id = $ticketWindow->id;
                $history->ticket_id = $idTicketChosen;
                $history->user_id = $ticketChosen->owner_id;
                $history->service_id = $ticketWindow->service_id;
                $history->office_id = $ticketWindow->office_id;
                $history->staff_id = $ticketWindow->staff_id;
                $history->save();
            }else{
                $ticketWindow->ticket_id = null;
                $ticketWindow->save();
            }
        }
        return("servinggg");
    }
}
