<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Http\Request;
use Sentinel;
use Session;
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

    public function editManager($id)
    {
        $manager = EloquentUser::find($id);
        $allCompanies = Company::all();
        return view('admin.managers.edit')
            ->with('manager',$manager)
            ->with('allCompanies',$allCompanies);
    }

    public function updateManager(Request $request, $id)
    {
        $user = Sentinel::findById($id);
        $user = Sentinel::update($user, $request->all());
        Session::flash('update', 'Manager was successfully updated!');
        return redirect('/dashboard/manager');
    }

    public function destroy($id)
    {
        $manager = EloquentUser::find($id);
        if($manager->office != null){
            $manager->office->manager_id = null;
            $manager->office->save();
            $manager->office->ad->delete();
        }
        $roles = DB::table('role_users')
            ->where('user_id', '=', $manager->id)
            ->delete();
        $manager->delete();
        Session::flash('delete', 'Successfully deleted the Manager!');
        return redirect('/dashboard/manager');
    }

    public function signUp(Request $request)
    {
        $user = Sentinel::registerAndActivate($request->all());
        $role = Sentinel::findRoleBySlug('simple_user');
        $role->users()->attach($user);
        return($user);
    }

    public function signIn(Request $req)
    {
        Sentinel::Authenticate($req->all());
        if(Sentinel::check()){
            if(Sentinel::getUser()->roles()->first()->slug == 'simple_user'){
                return Sentinel::getUser();
            }
        }else{
            return ("error");
        }
    }


}
