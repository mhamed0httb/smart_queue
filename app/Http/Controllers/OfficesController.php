<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Office;
use Sentinek;
use App\Region;
use App\Company;
use Cartalyst\Sentinel\Users\EloquentUser;
use Session;
use Illuminate\Support\Facades\DB;

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
        if($request->manager_id == "not_yet"){
            $office->manager_id = null;
        }else{
            $office->manager_id = $request->manager_id;
        }
        $office->company_id = $request->company_id;
        $office->region_id = $request->region_id;
        $office->office_lat = $request->office_lat;
        $office->office_lng = $request->office_lng;
        $office->raspberry_id = $request->raspberry_id;
        $office->save();

        //WE WILL KEEP THE OFFICE_ID ON USERS TABLE
        if($request->manager_id != "not_yet"){
            $manager = EloquentUser::find($request->manager_id);
            $manager->office_id = $office->id;
            $manager->save();
        }
        $request->session()->flash('success', 'Office was successfully created!');

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
        $office = Office::find($id);
        $allRegions = Region::all();
        $allCompanies = Company::all();
        $role = Sentinel::findRoleBySlug('manager');
        $allManagers = $role->users()->with('roles')->get();
        return view('admin.offices.edit')
            ->with('office', $office)
            ->with('allRegions',$allRegions)
            ->with('allManagers',$allManagers)
            ->with('allCompanies',$allCompanies);
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
        $office = Office::find($id);

        //WE WILL KEEP THE OFFICE_ID ON USERS TABLE
        if($office->manager_id == null){
            if($request->manager_id == "not_yet"){

            }elseif ($request->manager_id == "same"){

            }else{
                $manager = EloquentUser::find($request->manager_id);
                $manager->office_id = $office->id;
                $manager->save();
            }
        }else{
            if($request->manager_id == "not_yet"){
                $manager = EloquentUser::find($office->manager_id);
                $manager->office_id = null;
                $manager->save();
            }elseif ($request->manager_id == "same"){

            }else{
                $managerOld = EloquentUser::find($office->manager_id);
                $managerOld->office_id = null;
                $managerOld->save();

                $manager = EloquentUser::find($request->manager_id);
                $manager->office_id = $office->id;
                $manager->save();
            }
        }


        $office->identifier = $request->identifier;
        if($request->manager_id == "not_yet"){
            $office->manager_id = null;
        }elseif ($request->manager_id == "same"){

        }else{
            $office->manager_id = $request->manager_id;
        }
        $office->company_id = $request->company_id;
        $office->region_id = $request->region_id;

        if($request->office_lat != 0){
            $office->office_lat = $request->office_lat;
            $office->office_lng = $request->office_lng;
        }

        $office->raspberry_id = $request->raspberry_id;
        $office->save();

        $request->session()->flash('update', 'Office was successfully updated!');

        return redirect('/dashboard/offices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $office = Office::find($id);
        $office->ticketWindow()->delete();
        $office->staff()->delete();
        $office->ticket()->delete();
        $office->getManager()->delete();
        $office->ad()->delete();
        $office->delete();
        //Session::flash('delete_success', 'Successfully deleted the office!');
        Session::flash('delete', 'Successfully deleted the office!');
        return redirect('/dashboard/offices');
        //return('ok');
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

    public function assignManagerToOffice(Request $request)
    {
        $office = Office::find($request->office_id);
        $manager = EloquentUser::find($request->manager_id);
        $manager->office_id = $office->id;
        $office->manager_id = $request->manager_id;
        $manager->save();
        $office->save();
        Session::flash('assign', $manager->first_name . ' is managing the office : ' . $office->identifier);
        return redirect('/dashboard/offices');
    }

    public function getOfficeStatus(Request $request)
    {
        $office = Office::find($request->office_id);
        $result = array();
        $windows = $office->ticketWindow;
        $numWindows = 0;
        foreach ($windows as $one){
            $numWindows = $numWindows + 1;
        }
        $result['number_windows'] = $numWindows;
        $ticket = DB::table('tickets')
            ->where('office_id', '=', $request->office_id)
            ->count();
        $config = DB::table('office_config')
            ->where('office_id', '=', $request->office_id)
            ->first();
        $result['opening_morning'] = $config->opening_time_morning;
        $result['closing_morning'] = $config->closing_time_morning;
        $result['opening_evening'] = $config->opening_time_evening;
        $result['closing_eveing'] = $config->closing_time_evening;
        $result['capacity'] = $config->capacity;
        return $result;
    }

    public function getOfficesByCompanyCategory(Request $request)
    {
        $result = array();
        $companies = DB::table('companies')
            ->where('category', '=', $request->category)
            ->get();
        foreach ($companies as $one){
            $offices = DB::table('offices')
                ->where('company_id', '=', $one->id)
                ->get();
            foreach ($offices as $onee){
                array_push($result,$onee);
            }
        }
        return $result;
    }
}
