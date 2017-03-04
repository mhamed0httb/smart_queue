<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Office;
use Sentinek;
use App\Region;
use App\Company;
use Cartalyst\Sentinel\Users\EloquentUser;

class OfficesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allOffices = Office::all();
        return view('admin.offices.index')->with('allOffices',$allOffices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allRegions = Region::all();
        $allCompanies = Company::all();
        $role = Sentinel::findRoleBySlug('manager');
        $allManagers = $role->users()->with('roles')->get();
        return view('admin.offices.create')
            ->with('allRegions',$allRegions)
            ->with('allManagers',$allManagers)
            ->with('allCompanies',$allCompanies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $office = new Office;
        $office->identifier = $request->identifier;
        $office->manager_id = $request->manager_id;
        $office->region_id = $request->region_id;
        $office->office_lat = $request->office_lat;
        $office->office_lng = $request->office_lng;
        $office->save();

        //WE WILL KEEP THE OFFICE_ID ON USERS TABLE
        $manager = EloquentUser::find($request->manager_id);
        $manager->office_id = $office->id;
        $manager->save();

        return redirect('/dashboard/offices');
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

    public function getOfficesByCompany(Request $request)
    {
      $resOffices = array();
      $managers = Company::find($request->company_id)->manager;
      foreach ($managers as $one) {
        $office = EloquentUser::find($one->id)->office;
        array_push($resOffices,$office);
      }
      //$offices = EloquentUser::find($manager->id)->office;
      return($resOffices);
    }
}
