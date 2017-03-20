<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Company;
use App\Category;
use Sentinel;
use Cartalyst\Sentinel\Users\EloquentUser;
use Session;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allServices = Service::all();
        return view('manager.services.index')
            ->with('allServices',$allServices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allCategories = Category::all();
        return view('manager.services.create')
            ->with('allCategories',$allCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = new Service;
        $service->name = $request->name;
        $service->category_id = $request->category_id;
        $company = EloquentUser::find(Sentinel::getUser()->id)->getCompany; //GET COMPANY OF MANAGER LOGGED IN
        $service->company_id = $company->id;
        //$service->company_id = $request->company_id;
        $service->save();
        $request->session()->flash('success', 'Service was successfully created!');
        return redirect('/manager/services');
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
        $allCategories = Category::all();

        $service = Service::find($id);
        return view('manager.services.edit')
            ->with('allCategories',$allCategories)
        ->with('service',$service);
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
        $service = Service::find($id);
        $service->name = $request->name;
        $service->category_id = $request->category_id;
        $service->save();
        $request->session()->flash('update', 'Service was successfully updated!');
        return redirect('/manager/services');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        $windows = $windows = Service::find($id)->ticketWindows;
        foreach($windows as $one){
            $one->staff_id = null;
            $one->service_id = null;
            $one->ticket_id = null;
            $one->status = 'Offline';
            $one->save();
        }
        $service->delete();
        Session::flash('delete', 'Successfully deleted the service!');
        return redirect('/manager/services');
    }


    public function servicesStatAllDay()
    {
        $office = EloquentUser::find(Sentinel::getUser()->id)->office;
        return view('manager.services.statistics_all')->with('office',$office);
    }
}
