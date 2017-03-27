<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Region;
use Session;

class RegionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allRegions = Region::all();
        return view('admin.regions.index')->with('allRegions', $allRegions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.regions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $region = new Region;
        $region->name = $request->name;
        $region->save();
        $request->session()->flash('success', 'Region was successfully created!');
        return redirect('/dashboard/regions');
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
        $region = Region::find($id);
        return view('admin.regions.edit')->with('region', $region);
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
        $region = Region::find($id);
        $region->name = $request->name;
        $region->save();
        $request->session()->flash('update', 'Region was successfully updated!');
        return redirect('/dashboard/regions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $region = Region::find($id);
        $offices =Region::find($id)->offices;
        foreach($offices as $one){
            $one->ticketWindow()->delete();
            $one->staff()->delete();
            $one->ticket()->delete();
            $one->getManager()->delete();
            $one->ad()->delete();
            $one->delete();
        }
        $region->delete();
        Session::flash('delete', 'Successfully deleted the region and all the offices related!');
        //Session::flash('message', 'Successfully deleted the staff member!');
        return redirect('/dashboard/regions');
    }

    public function add(Request $request)
    {
        $region = new Region;
        $region->name = $request->name;
        $region->save();
        return ($region);
    }

}
