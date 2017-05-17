<?php

namespace App\Http\Controllers;

use App\TicketWindow;
use App\User;
use Illuminate\Http\Request;
use App\Ticket;
use App\Office;
use App\Service;
use App\Staff;
use App\History;
use Cartalyst\Sentinel\Users\EloquentUser;
use Sentinel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$office = EloquentUser::find(Sentinel::getUser()->id)->office;
        //$allTickets = Office::find($office->id)->ticket;
        $allTicketsToday = DB::table('tickets')
            ->whereDate('created_at',Carbon::now()->toDateString())
            ->orderBy('number','ASC')
            ->get();
        $res = array();
        foreach($allTicketsToday as $one){
            $tik = Ticket::find($one->id);
            array_push($res,$one);
        }
        $converted = Ticket::hydrate($res);
        return view('manager.tickets.index')->with('allTickets',$converted);
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
        $checkTickets = DB::table('tickets') //CHECK IF USER HAVE ALREADY A TICKET
            ->where('expired', '=', false)
            ->where('status', '=', 'waiting')
            ->where('office_id', '=', $request->office_id)
            ->where('owner_id', '=', $request->owner_id)
            ->whereDate('created_at', Carbon::now()->toDateString())
            ->get();

        if ($checkTickets->count() == 0) {
            $allTicketsByOffice = DB::table('tickets') //GET ALL TICKETS WAITING
                //->where('expired', '=', false)
                ->where('office_id', '=', $request->office_id)
                ->whereDate('created_at', Carbon::now()->toDateString())
                ->orderBy('number', 'desc')
                ->get();

            /*if($allTicketsByOffice->count() == 0){
                $newNumber = 1;
            }else{
                $initTicket = DB::table('tickets')
                    ->where('expired', '=', false)
                    ->where('office_id', '=', $request->office_id)
                    ->orderBy('number', 'desc')
                    ->first();
                $maximumNumber = $initTicket->number;
                if($maximumNumber == 20)
                {
                    $newNumber = 1;
                }else{
                    $newNumber = $maximumNumber + 1;
                }
            }*/
            //return $allTicketsByOffice->count();
            if($allTicketsByOffice->count() == 0){
                $ticket = new Ticket;
                $ticket->office_id = $request->office_id;
                $ticket->owner_id = $request->owner_id;
                $ticket->number = 1;
                $ticket->expired = false;
                $ticket->service_id = $request->service_id;
                $ticket->save();
                return $ticket;
            }else{
                $initTicket = DB::table('tickets')
                    ->where('office_id', '=', $request->office_id)
                    ->whereDate('created_at', Carbon::now()->toDateString())
                    ->orderBy('number', 'desc')
                    ->first();
                $maximumNumber = $initTicket->number;
                $newNumber = $maximumNumber + 1;

                $ticket = new Ticket;
                $ticket->office_id = $request->office_id;
                $ticket->owner_id = $request->owner_id;
                $ticket->number = $newNumber;
                $ticket->expired = false;
                $ticket->service_id = $request->service_id;
                $ticket->save();
                return $ticket;
            }
        }else{
            if($request->owner_id == null){
                $allTicketsByOffice = DB::table('tickets') //GET ALL TICKETS WAITING
                //->where('expired', '=', false)
                ->where('office_id', '=', $request->office_id)
                    ->whereDate('created_at', Carbon::now()->toDateString())
                    ->orderBy('number', 'desc')
                    ->get();

                /*if($allTicketsByOffice->count() == 0){
                    $newNumber = 1;
                }else{
                    $initTicket = DB::table('tickets')
                        ->where('expired', '=', false)
                        ->where('office_id', '=', $request->office_id)
                        ->orderBy('number', 'desc')
                        ->first();
                    $maximumNumber = $initTicket->number;
                    if($maximumNumber == 20)
                    {
                        $newNumber = 1;
                    }else{
                        $newNumber = $maximumNumber + 1;
                    }
                }*/
                //return $allTicketsByOffice->count();
                if($allTicketsByOffice->count() == 0){
                    $ticket = new Ticket;
                    $ticket->office_id = $request->office_id;
                    $ticket->owner_id = $request->owner_id;
                    $ticket->number = 1;
                    $ticket->expired = false;
                    $ticket->service_id = $request->service_id;
                    $ticket->save();
                    return $ticket;
                }else{
                    $initTicket = DB::table('tickets')
                        ->where('office_id', '=', $request->office_id)
                        ->whereDate('created_at', Carbon::now()->toDateString())
                        ->orderBy('number', 'desc')
                        ->first();
                    $maximumNumber = $initTicket->number;
                    $newNumber = $maximumNumber + 1;

                    $ticket = new Ticket;
                    $ticket->office_id = $request->office_id;
                    $ticket->owner_id = $request->owner_id;
                    $ticket->number = $newNumber;
                    $ticket->expired = false;
                    $ticket->service_id = $request->service_id;
                    $ticket->save();
                    return $ticket;
                }
            }else{
                return('user have already a ticket');
            }

        }
    }


    public function ServeTicket(Request $request)
    {
        $ticketWindow = TicketWindow::find($request->ticket_window_id);
        $ticketChosenNumber = 0;
        //IF TICKET WINDOW IS NOT SERVING ANYONE
        if($ticketWindow->ticket_id == null){
            $allTicketsWaiting = DB::table('tickets') //GET ALL TICKETS WAITING
                ->where('expired', '=', false)
                ->where('office_id', '=', $ticketWindow->office_id)
                ->where('status', '=', 'waiting')
                ->where('service_id', '=', $ticketWindow->service_id) //ADDED NEW TO SERVE THE APPROPRIATE TICKET WITH THE APPROPRIATE SERVICE
                ->get();
            if(! $allTicketsWaiting->count() == 0){ //IF THERE ARE TICKETS WAITING
                $initTicket = DB::table('tickets')  //GET FIRST RESULT FOR TICKETS WAITING
                    ->where('expired', '=', false)
                    ->where('office_id', '=', $ticketWindow->office_id)
                    ->where('status', '=', 'waiting')
                    ->where('service_id', '=', $ticketWindow->service_id) //ADDED NEW TO SERVE THE APPROPRIATE TICKET WITH THE APPROPRIATE SERVICE
                    ->orderBy('number', 'asc')
                    ->first();
                $minimumNumber = $initTicket->number; //INITIALIZE MINIMUM NUMBER OF TICKETS
                $idTicketChosen = $initTicket->id; //INITIALIZE TICKET ID WHICH HAVE THE MINIMUM NUMBER

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

                $ticketChosenNumber = $ticketChosen->number;
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
                ->where('service_id', '=', $ticketWindow->service_id) //ADDED NEW TO SERVE THE APPROPRIATE TICKET WITH THE APPROPRIATE SERVICE
                ->get();
            if(! $allTicketsWaiting->count() == 0){
                $initTicket = DB::table('tickets')
                    ->where('expired', '=', false)
                    ->where('office_id', '=', $ticketWindow->office_id)
                    ->where('status', '=', 'waiting')
                    ->where('service_id', '=', $ticketWindow->service_id) //ADDED NEW TO SERVE THE APPROPRIATE TICKET WITH THE APPROPRIATE SERVICE
                    ->orderBy('number', 'asc')
                    ->first();
                $minimumNumber = $initTicket->number;
                $idTicketChosen = $initTicket->id;

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

                $ticketChosenNumber = $ticketChosen->number;
            }else{
                $ticketWindow->ticket_id = null;
                $ticketWindow->save();
            }
        }

        return($ticketChosenNumber);
        //return("serving");
    }


    public function getTicketsWaiting(Request $request)
    {
        $office = Office::find($request->office_id);
        $tickets = DB::table('tickets')
            ->where('office_id', '=', $request->office_id)
            ->where('status', '=', 'waiting')
            ->whereDate('created_at', Carbon::now()->toDateString())
            ->orderBy('number', 'asc')
            ->get();
        return $tickets->count();
    }

    public function cancelTicket(Request $request)
    {
        $office = Office::find($request->office_id);
        $owner = EloquentUser::find($request->owner_id);
        $ticket = DB::table('tickets')
            ->where('office_id', '=', $request->office_id)
            ->where('owner_id', '=', $request->owner_id)
            ->where('status', '=', 'waiting')
            ->where('expired', '=', false)
            ->whereDate('created_at', Carbon::now()->toDateString())
            ->first();

        if($ticket != null){
            $ticketToCancel = Ticket::find($ticket->id);
            $ticketToCancel->expired = true;
            $ticketToCancel->status = 'canceled';
            $ticketToCancel->save();
            return 'ticekt canceled';
        }else{
            return 'no ticket found';
        }
    }

    public function getHistoryTicketsByOwner(Request $request){
        $historyResults = DB::table('history')
            ->where('user_id', '=', $request->owner_id)
            ->get();

        $result = array();

        if($historyResults->count() != 0){
            foreach ($historyResults as $one) {
                $oneTicketResult = array();

                $ticket = Ticket::find($one->ticket_id);
                $window = TicketWindow::find($one->ticket_window_id);
                $service = Service::find($one->service_id);
                $office = Office::find($one->office_id);
                $staff = Staff::find($one->staff_id);

                $oneTicketResult['id_ticket'] = $one->ticket_id;
                $oneTicketResult['ticekt_number'] = $ticket->number;
                $oneTicketResult['office'] = $office->identifier;
                $oneTicketResult['window_number'] = $window->number;
                $oneTicketResult['service'] = $service->name;
                $oneTicketResult['staff_member'] = $staff->first_name . ' ' . $staff->last_name;
                array_push($result, $oneTicketResult);
            }
            return $result;
        }else{
            return 'no data found';
        }
    }

    public function scanQR(Request $req)
    {
        $ticket = Ticket::find($req->ticket_id);
        $user = User::find($req->user_id);
        if($user == null){
            return 'no_user';
        }else{
            if($ticket == null){
                return 'no_ticket';
            }else{
                if($ticket->owner_id != null){
                    return 'ticket_has_already_user';
                }else{
                    $ticket->owner_id = $user->id;
                    $ticket->save();
                    return $ticket;
                }
            }
        }
    }

    public function allTicketsByUser(Request $req)
    {
        $user = User::find($req->user_id);
        $res = array();
        if($user == null){
            return 'no_user_found';
        }else{
            $tickets = DB::table('tickets')
                ->where('owner_id', '=', $user->id)
                ->get();
            if($tickets == null){
                return 'no_tickets_found';
            }else{
                foreach ($tickets as $one){
                    $oneArr = array();
                    $oneArr['ticket_id'] = $one->id;
                    $oneArr['ticket_number'] = $one->number;
                    $off = Office::find($one->office_id);
                    $oneArr['office_name'] = $off->identifier;
                    $oneArr['status'] = $one->status;
                    $bokingDate = Carbon::parse($one->created_at);
                    $servedDate = Carbon::parse($one->updated_at);
                    $oneArr['booking_date'] = $bokingDate->toDateString();
                    $oneArr['booking_time'] = $bokingDate->toTimeString();
                    $oneArr['served_date'] = $servedDate->toDateString();
                    $oneArr['served_time'] = $servedDate->toTimeString();
                    array_push($res,$oneArr);
                }
                return $res;
            }
        }

    }
}
