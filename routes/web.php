<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', 'RegistrationController@register');
Route::post('/register', 'RegistrationController@postRegister');

Route::get('/login', 'LoginController@login');
Route::post('/login', 'LoginController@postLogin');

Route::post('/logout', 'LoginController@logout');

Route::group(['middleware' => 'admin'], function(){
    Route::get('/dashboard', 'AdminController@index');
    //Route::resource('/dashboard/services', 'ServicesController');
    //Route::resource('/dashboard/staffs', 'StaffsController');
    Route::get('/dashboard/manager/create', 'AdminController@createManager');
    Route::post('/dashboard/manager', 'AdminController@postCreateManager');
    Route::get('/dashboard/manager', 'AdminController@allManagers');
    Route::delete('/dashboard/manager/{manager}', [
        'as' => 'manager.destroy', 'uses' => 'AdminController@destroy'
    ]);
    Route::get('/dashboard/manager/{manager}/edit', 'AdminController@edit');
    Route::put('/dashboard/manager/{manager}', [
        'as' => 'manager.update', 'uses' => 'AdminController@update'
    ]);
    Route::resource('/dashboard/companies', 'CompanyController');
    Route::resource('/dashboard/categories', 'CategoryController');
    Route::get('/dashboard/categories/', 'AdminController@index');
    Route::resource('/dashboard/offices', 'OfficesController');
    Route::resource('/dashboard/regions', 'RegionsController');
});

Route::group(['middleware' => 'manager'], function(){
    Route::get('/manager', 'ManagerController@index');
    Route::resource('/manager/staffs', 'StaffsController');
    Route::resource('/manager/services', 'ServicesController');
    Route::resource('/manager/ticket_windows', 'TicketWindowsController');
    Route::get('/manager/ticket_windows/deactivate/{id}', 'TicketWindowsController@deactivateWindow');
    Route::resource('/manager/tickets', 'TicketsController');
    Route::post('/manager/ticket_windows/update_status', 'TicketWindowsController@updateStatus');
    Route::get('/manager/statistics/staff/{id}', 'StaffsController@staffStatAllDay');
    Route::get('/manager/statistics/services', 'ServicesController@servicesStatAllDay');
});

//Route::get('/webservices/tickets/create', 'TicketsController@createTicket');
//Route::get('/webservices/tickets/update', 'TicketsController@updateTicket');
//Route::get('/webservices/managers/byCompany', 'ManagerController@getNotAffectedManagersByCompany');

Route::get('/upload', 'ManagerController@upload');
Route::post('/upload', 'ManagerController@postUpload');




