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
    Route::resource('/dashboard/services', 'ServicesController');
    //Route::resource('/dashboard/staffs', 'StaffsController');
    Route::get('/dashboard/manager/create', 'AdminController@createManager');
    Route::post('/dashboard/manager', 'AdminController@postCreateManager');
    Route::get('/dashboard/manager', 'AdminController@allManagers');
    Route::resource('/dashboard/companies', 'CompanyController');
    Route::resource('/dashboard/categories', 'CategoryController');
});

Route::group(['middleware' => 'manager'], function(){
    Route::get('/manager', 'ManagerController@index');
    Route::resource('/manager/staffs', 'StaffsController');
});

