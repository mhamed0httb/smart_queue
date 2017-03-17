<?php

use Illuminate\Http\Request;
use App\Region;
use App\Staff;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Ticket;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');



Route::get('/regions', function()
{
    return (Region::all());
});
Route::get('/regions/create', 'RegionsController@add');

Route::post('/staff/add', function(Request $req)
{

    $staff = new Staff;
    $staff->first_name = $req->f_name;
    $staff->last_name = $req->l_name;

    $staff->office_id = 0;
    $staff->save();
    return ('staff member added');
});

Route::get('/tickets/create', 'TicketsController@createTicket');
Route::get('/tickets/serve', 'TicketsController@ServeTicket');
Route::get('/tickets/waiting', 'TicketsController@getTicketsWaiting');

Route::get('/ticket_windows/status', 'TicketWindowsController@getTicketWindowsStatus');

Route::get('/managers/byCompany', 'ManagerController@getNotAffectedManagersByCompany');

Route::get('/statistics/service/byOffice', function(Request $req)
{
    $his = DB::table('history')
        ->where('office_id', '=', $req->office_id)
        //->whereDate('created_at', Carbon::now()->toDateString())
        ->get();
    $allRes = array();
    $services = array();
    $windows = array();
    foreach($his as $one){
        $window = App\TicketWindow::find($one->ticket_window_id);
        $service  = App\Service::find($one->service_id);
        $serArr = array();
        $windArr = array();
        if(array_key_exists($service->id, $services)){
            $occ = $services[$service->id]['recurrence'];
            $occ = $occ + 1;
            $services[$service->id]['recurrence'] = $occ;
        }else{
            $serArr['recurrence'] = 1;
            $serArr['object'] = $service;
            $services[$service->id] = $serArr;
        }


        if(array_key_exists($window->id, $windows)){
            $occ = $windows[$window->id]['recurrence'];
            $occ = $occ + 1;
            $windows[$window->id]['recurrence'] = $occ;
        }else{
            $windArr['recurrence'] = 1;
            $windArr['object'] = $window;
            $windows[$window->id] = $windArr;
        }


    }
    //return (Carbon::now()->toDateString());
    $allRes['windows'] = $windows;
    $allRes['services'] = $services;
    return($allRes);
});

//GET STATISTICS FOR ONE DAY : EVERY SERVICE WITH THE NUMBER OF CLIENTS SERVED AND THE TIME FOR EVERY TICKET SERVED
Route::get('/statistics/service/day', function(Request $req)
{
    $his = DB::table('history')
        ->whereDate('created_at', $req->date)
        ->where('office_id', '=', $req->office_id)
        ->get();

    $nbrClientServed = DB::table('history')
        ->whereDate('created_at', $req->date)
        ->where('office_id', '=', $req->office_id)
        ->count();
    $result = array();
    $services = array();
    $result['total_clients_served'] = $nbrClientServed;
    $result['date'] = $req->date;
    foreach($his as $one){
        $service  = App\Service::find($one->service_id);
        $serArr = array();
        $clientArr = array();
        //$created_at = Carbon::parse($one->created_at);
        //$updated_at = Carbon::parse($one->updated_at);
        //$ticketServed = Ticket::find($one->ticket_id);
        if(array_key_exists($service->id, $services)){
            $occ = $services[$service->id]['nbr_clients_served'];
            $occ = $occ + 1;
            $services[$service->id]['nbr_clients_served'] = $occ;
        }else{
            $serArr['nbr_clients_served'] = 1;
            $serArr['service_name'] = $service->name;

            $hisServ = DB::table('history')
                ->whereDate('created_at', $req->date)
                ->where('service_id', $service->id)
                ->where('office_id', '=', $req->office_id)
                ->get();
            foreach($hisServ as $onee){
                $ticketServed = App\Ticket::find($onee->ticket_id);
                $created_at = Carbon::parse($onee->created_at);
                $updated_at = Carbon::parse($onee->updated_at);
                //$clientArr[$ticketServed->id]['object_ticket'] = $ticketServed;
                //$clientArr[$ticketServed->id]['time_begin'] = $created_at;
                //$clientArr[$ticketServed->id]['time_end'] = $updated_at;
                $beginSeconds = $created_at->second + ($created_at->minute *60) + ($created_at->hour * 3600);
                $endSeconds = $updated_at->second + ($updated_at->minute *60) + ($updated_at->hour * 3600);
                $clientArr[$ticketServed->id]['time_difference_minutes'] = ($endSeconds - $beginSeconds) / 60;
            }

            $serArr['clients_served'] = $clientArr;
            $services[$service->id] = $serArr;
        }
    }
    $result['services'] = $services;
    //return($updated_at->second - $created_at->second);
    return($result);
});



Route::get('/statistics/service/allDay', function(Request $req)
{
    $his = DB::table('history')
        ->where('office_id', '=', $req->office_id)
        ->get();

    $nbrClientServed = DB::table('history')
        ->where('office_id', '=', $req->office_id)
        ->count();
    $result = array();
    $services = array();
    $result['total_clients_served'] = $nbrClientServed;
    foreach($his as $one){
        $service  = App\Service::find($one->service_id);
        $serArr = array();
        $clientArr = array();
        //$created_at = Carbon::parse($one->created_at);
        //$updated_at = Carbon::parse($one->updated_at);
        //$ticketServed = Ticket::find($one->ticket_id);
        if(array_key_exists($service->id, $services)){
            $occ = $services[$service->id]['nbr_clients_served'];
            $occ = $occ + 1;
            $services[$service->id]['nbr_clients_served'] = $occ;
        }else{
            $serArr['nbr_clients_served'] = 1;
            $serArr['service_name'] = $service->name;

            $hisServ = DB::table('history')
                ->where('office_id', '=', $req->office_id)
                ->where('service_id', $service->id)
                ->get();
            foreach($hisServ as $onee){
                $ticketServed = App\Ticket::find($onee->ticket_id);
                $created_at = Carbon::parse($onee->created_at);
                $updated_at = Carbon::parse($onee->updated_at);
                //$clientArr[$ticketServed->id]['object_ticket'] = $ticketServed;
                //$clientArr[$ticketServed->id]['time_begin'] = $created_at;
                //$clientArr[$ticketServed->id]['time_end'] = $updated_at;
                $beginSeconds = $created_at->second + ($created_at->minute *60) + ($created_at->hour * 3600);
                $endSeconds = $updated_at->second + ($updated_at->minute *60) + ($updated_at->hour * 3600);
                $clientArr[$ticketServed->id]['time_difference_minutes'] = ($endSeconds - $beginSeconds) / 60;

                $clientArr[$ticketServed->id]['date'] = $created_at->toDateString();
            }

            $serArr['clients_served'] = $clientArr;
            $services[$service->id] = $serArr;
        }
    }
    $result['services'] = $services;
    //return($updated_at->second - $created_at->second);
    return($result);
});




Route::get('/statistics/staff/day', function(Request $req)
{
    $his = DB::table('history')
        ->where('staff_id', '=', $req->staff_id)
        ->whereDate('created_at', $req->date)
        ->where('office_id', '=', $req->office_id)
        //->whereDate('created_at', Carbon::now()->toDateString())
        ->get();

    $nbrClientsServed = DB::table('history')
        ->where('staff_id', '=', $req->staff_id)
        ->whereDate('created_at', $req->date)
        ->count();

    $staffMember = Staff::find($req->staff_id);
    $staffName = $staffMember->first_name . " " . $staffMember->last_name;


    $result = array();
    $services = array();
    $result['total_clients_served'] = $nbrClientsServed;
    $result['date'] = $req->date;
    $result['staff_name'] = $staffName;

    foreach($his as $one){
        $service  = App\Service::find($one->service_id);
        $serArr = array();

        $clientArr = array();
        $created_at = Carbon::parse($one->created_at);
        $updated_at = Carbon::parse($one->updated_at);
        $ticketServed = Ticket::find($one->ticket_id);
        if(array_key_exists($service->id, $services)){
            $occ = $services[$service->id]['nbr_services_served'];
            $occ = $occ + 1;
            $services[$service->id]['nbr_services_served'] = $occ;
        }else{
            $serArr['nbr_services_served'] = 1;
            $serArr['service_name'] = $service->name;

            $hisServ = DB::table('history')
                ->whereDate('created_at', $req->date)
                ->where('service_id', $service->id)
                ->where('staff_id', $req->staff_id)
                ->get();
            foreach($hisServ as $onee){
                $ticketServed = App\Ticket::find($onee->ticket_id);
                $created_at = Carbon::parse($onee->created_at);
                $updated_at = Carbon::parse($onee->updated_at);
                //$clientArr[$ticketServed->id]['object_ticket'] = $ticketServed;
                //$clientArr[$ticketServed->id]['time_begin'] = $created_at;
                //$clientArr[$ticketServed->id]['time_end'] = $updated_at;
                $beginSeconds = $created_at->second + ($created_at->minute *60) + ($created_at->hour * 3600);
                $endSeconds = $updated_at->second + ($updated_at->minute *60) + ($updated_at->hour * 3600);
                $clientArr[$ticketServed->id]['time_difference_minutes'] = ($endSeconds - $beginSeconds) / 60;
            }

            $serArr['clients_served'] = $clientArr;
            $services[$service->id] = $serArr;
        }
    }
    $result['services'] = $services;
    return($result);

});


Route::get('/statistics/staff/allDays', function(Request $req)
{
    $his = DB::table('history')
        ->where('staff_id', '=', $req->staff_id)
        ->where('office_id', '=', $req->office_id)
        ->get();

    $nbrClientsServed = DB::table('history')
        ->where('staff_id', '=', $req->staff_id)
        ->count();

    $result = array();
    $services = array();
    $clientArr = array();
    $result['total_clients_served'] = $nbrClientsServed;

    foreach($his as $one){
        $service  = App\Service::find($one->service_id);
        $serArr = array();


        $oneClientServed = array();
        $created_at = Carbon::parse($one->created_at);
        $updated_at = Carbon::parse($one->updated_at);
        $ticketServed = Ticket::find($one->ticket_id);
        if(array_key_exists($service->id, $services)){
            $occ = $services[$service->id]['nbr_services_served'];
            $occ = $occ + 1;
            $services[$service->id]['nbr_services_served'] = $occ;
        }else{
            $serArr['nbr_services_served'] = 1;
            $serArr['service_name'] = $service->name;

            $hisServ = DB::table('history')
                ->where('service_id', $service->id)
                ->where('staff_id', $req->staff_id)
                ->get();
            foreach($hisServ as $onee){
                $ticketServed = App\Ticket::find($onee->ticket_id);
                $created_at = Carbon::parse($onee->created_at);
                $updated_at = Carbon::parse($onee->updated_at);
                //$clientArr[$ticketServed->id]['object_ticket'] = $ticketServed;
                //$clientArr[$ticketServed->id]['time_begin'] = $created_at;
                //$clientArr[$ticketServed->id]['time_end'] = $updated_at;
                $beginSeconds = $created_at->second + ($created_at->minute *60) + ($created_at->hour * 3600);
                $endSeconds = $updated_at->second + ($updated_at->minute *60) + ($updated_at->hour * 3600);
                //$clientArr[$ticketServed->id]['time_difference_minutes'] = ($endSeconds - $beginSeconds) / 60;

                //$clientArr[$ticketServed->id]['date'] = $created_at->toDateString();

                $oneClientServed['id_ticket_served'] = $ticketServed->id;
                $oneClientServed['date'] = $created_at->toDateString();
                $oneClientServed['time_difference_minutes'] = ($endSeconds - $beginSeconds) / 60;

                array_push($clientArr, $oneClientServed);
            }

            $serArr['clients_served'] = $clientArr;


            $serArr['id_service'] = $service->id;
            //$services[$service->id] = $serArr;
            array_push($services,$serArr);
        }
    }
    $result['services'] = $services;
    return($result);

});


Route::get('/offices/all', 'OfficesController@getOfficesByCompany');
Route::get('/companies/all', 'CompanyController@getAllCompanies');
Route::get('/staff/all', 'StaffsController@getAllStaff');




