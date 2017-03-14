<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Company;
use App\Category;
use Sentinel;
use Cartalyst\Sentinel\Users\EloquentUser;

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
        return view('admin.services.index')
            ->with('allServices',$allServices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allCompanies = Company::all();
        $allCategories = Category::all();
        return view('admin.services.create')
            ->with('allCompanies', $allCompanies)
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
        $service->company_id = $request->company_id;
        $service->save();
        return redirect('/dashboard/services');
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
        $service = Service::find($id);
        $service->delete();
        Session::flash('message', 'Successfully deleted the nerd!');
        return ('service deleted');
    }


    public function servicesStatAllDay()
    {
        $office = EloquentUser::find(Sentinel::getUser()->id)->office;
        return view('manager.services.statistics_all')->with('office',$office);
    }
}
