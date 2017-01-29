<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use App\Company;

class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }

    public function allManagers()
    {
        $role = Sentinel::findRoleBySlug('manager');
        $allManagers = $role->users()->with('roles')->get();
        return view('admin.managers.index')->with('allManagers',$allManagers);
    }

    public function createManager()
    {
        $allCompanies = Company::all();
        return view('admin.managers.create')->with('allCompanies',$allCompanies);
    }

    public function postCreateManager(Request $request)
    {
        $user = Sentinel::registerAndActivate($request->all());
        $role = Sentinel::findRoleBySlug('manager');
        $role->users()->attach($user);
        $user->company_id = $request->company_id;
        return redirect('/dashboard/manager');
    }


}
