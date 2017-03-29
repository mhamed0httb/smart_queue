<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\CompanyResponsible;
use Session;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCompanies = Company::all();
        //$allStaff = Staff::whereFirstName("dzd")->get();
        return view('admin.companies.index')
            ->with('allCompanies',$allCompanies)
            ->with('page_title','All Companies')
            ->with('sub_page_title', 'Companies');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.companies.create')
            ->with('page_title','Create Company')
            ->with('sub_page_title', 'Companies');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = new Company;
        $companyResponsible = new CompanyResponsible;
        $company->name = $request->name;
        $company->identifier = $request->identifier;
        $company->description = $request->description;
        $company->email = $request->email;
        $company->phone = $request->phone;
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
        return redirect('/dashboard/companies');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);
        $companyResponsible = CompanyResponsible::find($company->responsible_id);
        return view('admin.companies.details')
            ->with('company', $company)
            ->with('responsible', $companyResponsible);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);
        return view('admin.companies.edit')->with('company', $company);
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
        $company = Company::find($id);
        $responsible = CompanyResponsible::find($company->responsible_id);
        $company->name = $request->name;
        $company->identifier = $request->identifier;
        $company->description = $request->description;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->address = $request->address;
        $responsible->name = $request->responsible_name;
        $responsible->title = $request->responsible_title;
        $responsible->email = $request->responsible_email;
        $responsible->phone1 = $request->responsible_phone1;
        $responsible->phone2 = $request->responsible_phone2;
        $responsible->fax = $request->responsible_fax;
        $responsible->save();
        $company->save();
        Session::flash('update', 'Company was successfully updated!');
        return redirect('/dashboard/companies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company  = Company::find($id);
        $services = $company->service;
        $managers = $company->manager;
        $offices = $company->office;
        foreach ($services as $one){
            //$one->getCategory->delete();
            $one->delete();
        }
        foreach ($managers as $one){
            $one->delete();
        }
        foreach ($offices as $one){
            $one->ticketWindow()->delete();
            $one->staff()->delete();
            $one->ticket()->delete();
            $one->ad()->delete();
            $one->delete();
        }
        $company->responsible()->delete();
        $company->delete();
        Session::flash('delete', 'Successfully deleted the comapny!');
        return redirect('/dashboard/companies');
    }

    public function getAllCompanies()
    {
        $resCompanies = Company::all();
        /*$managers = Company::find($request->company_id)->manager;
        foreach ($managers as $one) {
            $office = EloquentUser::find($one->id)->office;
            array_push($resOffices,$office);
        }
        //$offices = EloquentUser::find($manager->id)->office;*/
        return($resCompanies);
    }
}
