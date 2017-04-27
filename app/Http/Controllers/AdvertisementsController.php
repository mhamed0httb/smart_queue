<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Advertisement;
use App\Office;
use Illuminate\Support\Facades\Storage;
use Sentinel;
use App\Region;
use App\Company;
use App\AdCompany;
use Cartalyst\Sentinel\Users\EloquentUser;
use Session;
use Illuminate\Support\Facades\DB;
use App;

class AdvertisementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allAds = Advertisement::all();
        return view('admin.ads.index')->with('allAds',$allAds);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allOffices = Office::all();
        $allRegions = Region::all();
        $allCompanies = AdCompany::all();
        $allAdCompanies = AdCompany::all();
        $role = Sentinel::findRoleBySlug('manager');
        $allManagers = $role->users()->with('roles')->get();
        return view('admin.ads.create')
            ->with('allRegions',$allRegions)
            ->with('allManagers',$allManagers)
            ->with('allCompanies',$allCompanies)
            ->with('allAdCompanies',$allAdCompanies)
            ->with('allOffices',$allOffices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ad = new Advertisement;
        $ad->video_length = $request->video_length;
        $ad->company_id = $request->company_id;
        $ad->name = $request->name;
        $ad->type = $request->file('file')->getMimeType();

        $shortPATH = $request->file('file')->store('storage/ads');
        App::make('files')->link(storage_path('app/storage'), public_path('storage')); //create Symbolic link between "storage/app/..." AND "public/..."
        //$fullPATH = asset($shortPATH);
        $ad->file_path = $shortPATH;
        $ad->save();
        $request->session()->flash('success', 'Advertisement was successfully created!');
        return redirect('/dashboard/ads');
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
        $idCompany = $request->company_id;
        $offices = DB::table('offices')
            ->where('company_id', '=', $idCompany)
            ->get();

        return $offices;
    }

    public function getAdsByOffice(Request $request)
    {
        $ad = DB::table('advertisements')
            ->where('office_id', '=', $request->office_id)
            ->first();
        $res = array();
        $res['file_url'] = asset($ad->file_path);
        $res['video_length'] = $ad->video_length;

        return $res;
    }

    public function calendar()
    {
        $ads = Advertisement::all();
        return view('admin.ads.calendar')->with('ads',$ads);
    }
}
