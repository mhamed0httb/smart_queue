<?php

namespace App\Http\Controllers;

use App\AdPlanning;
use App\Advertisement;
use App\Office;
use App\PlanOffices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdPlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function savePlan(Request $request)
    {
        $checkPlanExist = DB::table('ad_planning')
            ->where('ad_id', '=', $request->ad_id)
            ->first();
        if($checkPlanExist == null){
            $ad = Advertisement::find($request->ad_id);
            $plan = new AdPlanning;
            $plan->ad_id = $request->ad_id;
            $plan->start = $request->start;
            $plan->end = $request->end;
            $plan->status = 'not_active';
            $plan->office_id = 0;
            $plan->nbr_shown = 0;
            $plan->save();
            //$ad->active = true;
            //$ad->save();
            return 'success';
        }else{
            $planToUpdate = AdPlanning::find($checkPlanExist->id);
            $planToUpdate->start = $request->start;
            $planToUpdate->end = $request->end;
            $planToUpdate->save();
            return 'updated';
        }
    }

    public function deletePlan(Request $request)
    {
        $ad = Advertisement::find($request->ad_id);

        $plan = DB::table('ad_planning')
            ->where('ad_id', '=', $request->ad_id)
            ->first();
        $planToDelete = AdPlanning::find($plan->id);
        $planToDelete->delete();

        //$ad->active = false;
        //$ad->save();

        $allPlanOffices = DB::table('plan_offices')
            ->where('plan_id', '=', $plan->id)
            ->get();
        if(count($allPlanOffices) != 0){
            foreach ($allPlanOffices as $onePlan){
                $PlanOfficeToDelete = PlanOffices::find($onePlan->id);
                $PlanOfficeToDelete->delete();
            }
        }

        //Session::flash('delete', 'the Ad '.$ad->name.' has been deleted from plan');
        return 'deleted';
    }

    public function planDetails(Request $request)
    {
        $ad = Advertisement::find($request->ad_id);

        $plan = DB::table('ad_planning')
            ->where('ad_id', '=', $request->ad_id)
            ->first();

        if($plan == null){
            return 0;
        }else{
            $result = array();
            $result['ad_name'] = $ad->name;
            $result['ad_id'] = $ad->id;
            $result['plan_id'] = $plan->id;

            $formattedStart = Carbon::parse($plan->start);
            $formattedEnd = Carbon::parse($plan->end);

            $result['plan_start'] = $formattedStart->format('d-M-Y H:m A');
            $result['plan_end'] = $formattedEnd->format('d-M-Y H:m A');

            $allPlanOffices = DB::table('plan_offices')
                ->where('plan_id', '=', $plan->id)
                ->get();
            $offices = array();
            if(count($allPlanOffices) == 0){
                $result['plan_offices'] = $offices;
            }else{
                foreach ($allPlanOffices as $onePlan){
                    $oneOfficeArray = array();
                    $oneOffice = Office::find($onePlan->office_id);
                    $oneOfficeArray['office_name'] = $oneOffice->identifier;
                    $oneOfficeArray['office_id'] = $oneOffice->id;
                    array_push($offices, $oneOfficeArray);
                }
                $result['plan_offices'] = $offices;
            }
            return $result;
        }
    }

}
