<?php

use Illuminate\Http\Request;
use App\Region;
use App\Staff;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Ticket;
use App\Service;
use App\Office;
use App\Company;
use App\Advertisement;
use App\OfficePub;

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

Route::group(['middleware' => 'cors'], function(){

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:api');



    Route::get('/regions', function()
    {
        return (Region::all());
    });
    Route::get('/regions/create', 'RegionsController@add');
    Route::get('/categories/create', 'CategoryController@add');

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
    Route::get('/tickets/cancel', 'TicketsController@cancelTicket');
    Route::get('/tickets/serve', 'TicketsController@ServeTicket');
    Route::get('/tickets/waiting', 'TicketsController@getTicketsWaiting');

    Route::get('/tickets/byOwner', 'TicketsController@getHistoryTicketsByOwner');

    Route::get('/ads/byOffice', 'AdvertisementsController@getAdsByOffice');

    Route::get('/ticket_windows/status', 'TicketWindowsController@getTicketWindowsStatus');

    Route::get('/managers/byCompany', 'ManagerController@getNotAffectedManagersByCompany');
    Route::get('/offices/byCompany', 'AdvertisementsController@getOfficesByCompany');

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

        $result['total_clients_served'] = $nbrClientsServed;

        //FOR 5OU5A
        $khoukhaStaff = Staff::find($req->staff_id);
        $result['staff_id'] = $khoukhaStaff->id;
        $result['staff_name'] = $khoukhaStaff->first_name . ' ' . $khoukhaStaff->last_name;
        //END FOR 5OU5A

        foreach($his as $one){
            $service  = App\Service::find($one->service_id);
            $serArr = array();

            $checkServiceFound = false;
            $indexServiceFound = 0;

            $clientArr = array();
            $oneClientServed = array();
            $created_at = Carbon::parse($one->created_at);
            $updated_at = Carbon::parse($one->updated_at);
            $ticketServed = Ticket::find($one->ticket_id);

            $index = 0;
            foreach ($services as $checkOne) {
                if($checkOne['id_service'] == $service->id){
                    $checkServiceFound = true;
                    $indexServiceFound = $index;
                }
                $index += 1;
            }


            if($checkServiceFound){
                $services[$indexServiceFound]['nbr_services_served'] += 1;
            }else{
                $serArr['nbr_services_served'] = 1;
                $serArr['service_name'] = $service->name;
                $serArr['id_service'] = $service->id;

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



                //$services[$service->id] = $serArr;
                array_push($services,$serArr);
            }
        }
        $result['services'] = $services;
        return($result);

    });

    Route::get('/statistics/allStaff/allDays', function(Request $req)
    {


        $bigResult = array();
        $allStaff = DB::table('staffs')
            ->where('office_id', '=', $req->office_id)
            ->get();


        foreach ($allStaff as $oneStaff){
            $result = array();
            $services = array();
            $his = DB::table('history')
                ->where('office_id', '=', $req->office_id)
                ->where('staff_id', '=', $oneStaff->id)
                ->get();

            $nbrClientsServed = DB::table('history')
                ->where('staff_id', '=', $oneStaff->id)
                ->count();

            $result['total_clients_served'] = $nbrClientsServed;

            //FOR 5OU5A
            $khoukhaStaff = Staff::find($oneStaff->id);
            $result['staff_id'] = $khoukhaStaff->id;
            $result['staff_name'] = $khoukhaStaff->first_name . ' ' . $khoukhaStaff->last_name;
            //END FOR 5OU5A

            foreach($his as $one){
                $service  = App\Service::find($one->service_id);
                $serArr = array();

                $checkServiceFound = false;
                $indexServiceFound = 0;

                $clientArr = array();
                $oneClientServed = array();
                $created_at = Carbon::parse($one->created_at);
                $updated_at = Carbon::parse($one->updated_at);
                $ticketServed = Ticket::find($one->ticket_id);

                $index = 0;
                foreach ($services as $checkOne) {
                    if($checkOne['id_service'] == $service->id){
                        $checkServiceFound = true;
                        $indexServiceFound = $index;
                    }
                    $index += 1;
                }


                if($checkServiceFound){
                    $services[$indexServiceFound]['nbr_services_served'] += 1;
                }else{
                    $serArr['nbr_services_served'] = 1;
                    $serArr['service_name'] = $service->name;
                    $serArr['id_service'] = $service->id;

                    $hisServ = DB::table('history')
                        ->where('service_id', $service->id)
                        ->where('staff_id', $oneStaff->id)
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



                    //$services[$service->id] = $serArr;
                    array_push($services,$serArr);
                }
            }
            $result['services'] = $services;
            $result['staff_name'] = $oneStaff->first_name . ' ' . $oneStaff->last_name;
            $result['staff_id'] = $oneStaff->id;

            array_push($bigResult,$result);
        }


        return($bigResult);

    });


    Route::get('/offices/all', 'OfficesController@getOfficesByCompany');
    Route::get('/companies/all', 'CompanyController@getAllCompanies');
    Route::get('/staff/all', 'StaffsController@getAllStaff');

    Route::get('/offices/assign', 'OfficesController@assignManagerToOffice');

    Route::get('/user/signUp', 'AdminController@signUp');
    Route::get('/user/signIn', 'AdminController@signIn');

    Route::get('/offices/status', 'OfficesController@getOfficeStatus');

    Route::get('/tickets/checkAvailable', function(Request $req)
    {

        $ticket = DB::table('tickets')
            ->where('office_id', '=', $req->office_id)
            ->where('owner_id', '=', $req->user_id)
            ->where('expired', '=', false)
            ->first();
        if($ticket == null){
            return ('not_found');
        }else{
            return ('found');
        }

    });

    Route::get('/estimatedTime', function(Request $req)
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

        $windowsOnline = DB::table('ticket_windows')
            ->where('status', '=', 'Online')
            ->where('office_id', $req->office_id)
            ->get();


        $totalTime = 0;
        foreach ($result['services'] as $one){
            foreach ($one['clients_served'] as $onee){
                //return $onee['time_difference_minutes'];
                $totalTime = $totalTime + $onee['time_difference_minutes'];
            }
        }

        $ticketsCount = DB::table('tickets')
            ->where('office_id', '=', $req->office_id)
            ->where('expired', '=', false)
            ->whereDate('created_at', Carbon::now()->toDateString())
            ->orderBy('number', 'desc')
            ->get();
        if(count($ticketsCount) == 0){
            return 0;
        }
        return $totalTime / $result['total_clients_served'] * $ticketsCount;
    });

    Route::get('/tickets/lastTicket', function(Request $req)
    {

        $ticket = DB::table('tickets')
            ->where('office_id', '=', $req->office_id)
            ->where('expired', '=', false)
            ->whereDate('created_at', Carbon::now()->toDateString())
            ->orderBy('number', 'desc')
            ->first();

        if($ticket == null){
            return 1;
        }else{
            return $ticket->number + 1;
        }


    });

    Route::get('/offices/byComapny/category', 'OfficesController@getOfficesByCompanyCategory');
    Route::get('/companies/byCategory', 'CompanyController@getCompaniesByCategory');

    Route::get('/sendNotif', 'ManagerController@sendNotifMsg');
    Route::post('/tokens/store', 'ManagerController@tokenStore');

    Route::get('/offices/allServices', function(Request $req)
    {
        $office = DB::table('offices')
            ->where('raspberry_id', '=', $req->raspberry_id)
            ->first();
        $company = Company::find($office->company_id);
        $services = DB::table('services')
            ->where('company_id', '=', $company->id)
            ->get();
        $result = array();
        foreach ($services as $one){
            $oneArray = array();
            $oneArray['service_name'] = $one->name;
            $oneArray['id_service'] = $one->id;
            array_push($result, $oneArray);
        }
        $bigResult = array();
        $bigResult['office_name'] = $office->identifier;
        $bigResult['services'] = $result;
        return $bigResult;
    });

    Route::get('/offices/ad/request', function(Request $req)
    {
        $office = DB::table('offices')
            ->where('raspberry_id', '=', $req->raspberry_id)
            ->first();
        $ad = DB::table('advertisements')
            ->where('office_id', '=', $office->id)
            ->first();
        $officePub = DB::table('office_pub')
            ->where('raspberry_id', '=', $req->raspberry_id)
            ->first();
        return asset($ad->file_path);
    });

    Route::get('/tickets/byServices', function(Request $req)
    {

        $office = DB::table('offices')
            ->where('raspberry_id', '=', $req->raspberry_id)
            ->first();

        $company = Company::find($office->company_id);

        $services = DB::table('services')
            ->where('company_id', '=', $company->id)
            ->get();

        $result = array();

        foreach ($services as $one){
            $oneArray = array();
            $oneArray['service_name'] = $one->name;
            $tickets = DB::table('tickets')
                ->where('office_id', '=', $office->id)
                ->whereDate('created_at', Carbon::now()->toDateString())
                ->where('status', '=', 'waiting')
                ->where('expired', '=', false)
                ->where('service_id', '=', $one->id)
                ->get();
            $oneArray['tickets'] = $tickets;
            $oneArray['number_tickets_waiting'] = $tickets->count();
            array_push($result,$oneArray);
        }


        return $result;

    });
});





