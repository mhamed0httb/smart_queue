<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Http\Request;
use Sentinel;
use App\Company;
use Illuminate\Support\Facades\DB;

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

    public function edit($id)
    {

    }

    public function destroy($id)
    {
        $manager = EloquentUser::find($id);
        if($manager->office != null){
            $manager->office->manager_id = null;
            $manager->office->save();
        }
        $roles = DB::table('role_users')
            ->where('user_id', '=', $manager->id)
            ->delete();
        $manager->delete();
        return redirect('/dashboard/manager');
    }


}
