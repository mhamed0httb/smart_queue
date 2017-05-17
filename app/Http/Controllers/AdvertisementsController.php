<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Advertisement;
use App\AdPlanning;
use App\Office;
use App\PlanOffices;
use Illuminate\Support\Facades\Storage;
use Sentinel;
use App\Region;
use App\Company;
use App\AdCompany;
use Cartalyst\Sentinel\Users\EloquentUser;
use Session;
use Illuminate\Support\Facades\DB;
use App;
use Carbon\Carbon;

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
        $ad->video_length = $request->video_length * 1000;
        $ad->company_id = $request->company_id;
        $ad->name = $request->name;
        $ad->type = $request->file('file')->getMimeType();

        $pos = strpos($ad->type, '/');
        $ad->type = substr($ad->type, 0,$pos);

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
        $ad = Advertisement::find($id);
        $allAdCompanies = AdCompany::all();
        return view('admin.ads.edit')
            ->with('ad',$ad)
            ->with('allAdCompanies',$allAdCompanies);
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
        $ad = Advertisement::find($id);
        $ad->video_length = $request->video_length * 1000;
        $ad->company_id = $request->company_id;
        $ad->name = $request->name;

        if(!$request->file('file') == null){
            $ad->type = $request->file('file')->getMimeType();

            $pos = strpos($ad->type, '/');
            $ad->type = substr($ad->type, 0,$pos);

            $shortPATH = $request->file('file')->store('storage/ads');
            App::make('files')->link(storage_path('app/storage'), public_path('storage')); //create Symbolic link between "storage/app/..." AND "public/..."
            //$fullPATH = asset($shortPATH);
            $ad->file_path = $shortPATH;
        }

        $ad->save();
        $request->session()->flash('success', 'Advertisement was successfully updated!');
        return redirect('/dashboard/ads');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ad = Advertisement::find($id);
        //return $ad;
        if(!$ad->plan == null){
            if(!$ad->plan->getPlanOffices->count() == 0){
                foreach ($ad->plan->getPlanOffices as $one) {
                    $one->delete();
                }
            }
            $ad->plan->delete();
        }
        $ad->delete();

        return redirect('/dashboard/ads');



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
        /*$ad = DB::table('advertisements')
            ->where('office_id', '=', $request->office_id)
            ->first();
        $res = array();
        $res['file_url'] = asset($ad->file_path);
        $res['video_length'] = $ad->video_length;

        return $res;*/

        $res = array();

        $office = DB::table('offices')
            ->where('raspberry_id', '=', $request->raspberry_id)
            ->first();

        if($office == null){
            $res['status'] = 'no_office_found';
            return $res;
        }else{
            $planOffices = DB::table('plan_offices')
                ->where('office_id', '=', $office->id)
                ->get();
            if(count($planOffices) == 0){
                $res['status'] = 'no_ads_available';
                return $res;
            }else{
                $firstPlanOffices = DB::table('plan_offices')
                    ->where('office_id', '=', $office->id)
                    ->first();
                $firstPlan = AdPlanning::find($firstPlanOffices->plan_id);
                $minShownAd = $firstPlan->nbr_shown;
                $chosenAdId = $firstPlan->ad_id;
                $chosenPlanId = $firstPlan->id;
                foreach ($planOffices as $one){
                    $plan = AdPlanning::find($one->plan_id);
                    if($plan->nbr_shown < $minShownAd ){
                        $chosenAdId = $plan->ad_id;
                        $chosenPlanId = $plan->id;
                    }
                }
                $planToPass = AdPlanning::find($chosenPlanId);
                $formattedStart = Carbon::parse($planToPass->start);
                $formattedEnd = Carbon::parse($planToPass->end);

                $now = Carbon::now()->format('H');
                //return $now;
                //return $formattedEnd->format('H');

                //Verify Time
                /*if($now > $formattedStart->format('H')&& $now < $formattedEnd->format('H')){
                    $ad = Advertisement::find($chosenAdId);
                    $res['status'] = 'ok';
                    $res['file_url'] = asset($ad->file_path);
                    $res['video_length'] = $ad->video_length;
                    $res['file_type'] = $ad->type;
                    $res['start_time'] = $formattedStart->format('H:m a');
                    $res['end_time'] = $formattedEnd->format('H:m a');
                    return $res;
                }else{
                    $res['status'] = 'request_another_time';
                    $res['start_time'] = $formattedStart->format('H:m A');
                    $res['end_time'] = $formattedEnd->format('H:m A');
                    return $res;
                }*/


                //Without Time Verefication
                /*$pplan = AdPlanning::find($chosenPlanId);
                $pplan->nbr_shown = $pplan->nbr_shown + 1;
                $pplan->save();
                $ad = Advertisement::find($chosenAdId);
                $res['status'] = 'ok';
                $res['file_url'] = asset($ad->file_path);
                $res['video_length'] = $ad->video_length;
                $res['file_type'] = $ad->type;
                $res['start_time'] = $formattedStart->format('H:m a');
                $res['end_time'] = $formattedEnd->format('H:m a');*/


                $noww = Carbon::now();
                //return $noww;
                //FOR 5OU5A
                $oneArr = array();
                foreach ($planOffices as $one){
                    $plan = AdPlanning::find($one->plan_id);
                    if ($plan->getAd->type == 'image' && $plan->getAd->active == true){
                        $formattedS = Carbon::parse($plan->start);
                        $formattedE = Carbon::parse($plan->end);
                        $diff = $noww->between($formattedS, $formattedE);
                        if($diff){
                            array_push($oneArr,asset($plan->getAd->file_path));
                            //$oneArr['file_path'] = $plan->getAd->file_path;
                        }else{
                            //return json_encode($diff);
                        }
                    }
                }
                if(count($oneArr) == 0){
                    $res['status'] = 'no_ads_available';
                }else{
                    $res['status'] = 'ok';
                    $res['ads'] = $oneArr;
                }
                return $res;
            }
        }
    }

    public function calendar()
    {
        $ads = Advertisement::all();
        $adsPlan = AdPlanning::all();
        $offices = Office::all();
        return view('admin.ads.calendar')
            ->with('ads',$ads)
            ->with('plans', $adsPlan)
            ->with('offices', $offices);
    }

    public function changeOffices(Request $request)
    {

        /*foreach ($request->office_checkbox as $one){

        }*/
        if($request->office_checkbox == null){
            return redirect('/dashboard/calendar');
        }else{
            $ad = Advertisement::find($request->change_offices_ad_id);

            $plan = DB::table('ad_planning')
                ->where('ad_id', '=', $request->change_offices_ad_id)
                ->first();

            if($plan == null){
                return redirect('/dashboard/calendar');
            }else{
                $allPlanOffices = DB::table('plan_offices')
                    ->where('plan_id', '=', $plan->id)
                    ->get();
                if(count($allPlanOffices) == 0){
                    foreach ($request->office_checkbox as $one){
                        $planOffices = new PlanOffices;
                        $planOffices->office_id = $one;
                        $planOffices->plan_id = $plan->id;
                        $planOffices->save();
                    }
                    Session::flash('success', 'the Ad '.$ad->name.' is now assigned to the new offices');
                    return redirect('/dashboard/calendar');
                }else{
                    foreach ($allPlanOffices as $onePlan){
                        $PlanOfficeToDelete = PlanOffices::find($onePlan->id);
                        $PlanOfficeToDelete->delete();
                    }
                    foreach ($request->office_checkbox as $one){
                        $planOffices = new PlanOffices;
                        $planOffices->office_id = $one;
                        $planOffices->plan_id = $plan->id;
                        $planOffices->save();
                    }
                    Session::flash('success', 'the Ad '.$ad->name.' is now assigned to the new offices');
                    return redirect('/dashboard/calendar');
                }
            }
        }
    }

    public function activate($id)
    {
        $ad = Advertisement::find($id);
        $ad->active = true;
        $ad->save();
        Session::flash('assign', 'the Ad '.$ad->name.' is now active');
        return redirect('/dashboard/ads');
    }

    public function deactivate($id)
    {
        $ad = Advertisement::find($id);
        $ad->active = false;
        $ad->save();
        Session::flash('assign', 'the Ad '.$ad->name.' is now not active');
        return redirect('/dashboard/ads');
    }
}
