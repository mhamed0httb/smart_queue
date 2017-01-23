<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;

class AdminController extends Controller
{
    public function index(){
        $u = 'mha';
        return view('admin.dashboard')->with('u',$u);
    }

    public function createManager()
    {
        return view('admin.managers.create');
    }

    public function postCreateManager(Request $request)
    {
        $user = Sentinel::registerAndActivate($request->all());
        $role = Sentinel::findRoleBySlug('manager');
        $role->users()->attach($user);
        return redirect('/dashboard');
    }


}
