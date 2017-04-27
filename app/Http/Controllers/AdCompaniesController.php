<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdCompany;
use App\AdResponsible;
use Session;
use Illuminate\Support\Facades\DB;

class AdCompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCompanies = AdCompany::all();
        //$allStaff = Staff::whereFirstName("dzd")->get();
        return view('admin.ad_companies.index')
            ->with('allCompanies',$allCompanies)
            ->with('page_title','All Ad Companies')
            ->with('sub_page_title', 'Ad Companies');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ad_companies.create')
            ->with('page_title','Create Ad Company')
            ->with('sub_page_title', 'Ad Companies');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = new AdCompany;
        $companyResponsible = new AdResponsible;
        $company->name = $request->name;
        $company->email = $request->email;
        $company->service_category = $request->category;
        $company->address = $request->address;
        $companyResponsible->name = $request->responsible_name;
        $companyResponsible->title = $request->responsible_title;
        $companyResponsible->email = $request->responsible_email;
        $companyResponsible->phone1 = $request->responsible_phone1;
        $companyResponsible->phone2 = $request->responsible_phone2;
        $companyResponsible->fax = $request->responsible_fax;
        $companyResponsible->save();
        $company->responsible_id = $companyResponsible->id;
        $company->save();
        Session::flash('success', 'Ad Company was successfully added!');
        return redirect('/dashboard/adCompanies');
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
        $company = AdCompany::find($id);
        return view('admin.ad_companies.edit')->with('company', $company);
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
        $company = AdCompany::find($id);
        $responsible = AdResponsible::find($company->responsible_id);
        $company->name = $request->name;
        $company->email = $request->email;
        $company->service_category = $request->category;
        $company->address = $request->address;
        $responsible->name = $request->responsible_name;
        $responsible->title = $request->responsible_title;
        $responsible->email = $request->responsible_email;
        $responsible->phone1 = $request->responsible_phone1;
        $responsible->phone2 = $request->responsible_phone2;
        $responsible->fax = $request->responsible_fax;
        $responsible->save();
        $company->save();
        Session::flash('update', 'Ad Company was successfully updated!');
        return redirect('/dashboard/adCompanies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company  = AdCompany::find($id);
        $ads = $company->ad;
        foreach ($ads as $one){
            $one->delete();
        }
        $company->responsible()->delete();
        $company->delete();
        Session::flash('delete', 'Successfully deleted the comapny!');
        return redirect('/dashboard/adCompanies');
    }
}
