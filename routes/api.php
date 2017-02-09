<?php

use Illuminate\Http\Request;
use App\Region;
use App\Staff;

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


Route::get('/names', function()
{
    return array(
        1 => "John",
        2 => "Mary",
        3 => "Steven"
    );
});

Route::get('names/{id}', function($id)
{
    $names = array(
        1 => "John",
        2 => "Mary",
        3 => "Steven"
    );
    return array($id => $names[$id]);
});

Route::get('/regions', function()
{
    return (Region::all());
});

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
//Route::get('/tickets/update', 'TicketsController@updateTicket');
Route::get('/tickets/serve', 'TicketsController@ServeTicket2');

Route::get('/managers/byCompany', 'ManagerController@getNotAffectedManagersByCompany');
