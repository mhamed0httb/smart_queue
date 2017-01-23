<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;

class RegistrationController extends Controller
{
    public function register(){
        return view('authentication.register');
    }

    public function postRegister(Request $req){
        $user = Sentinel::registerAndActivate($req->all());
        //dd($user);
        $role = Sentinel::findRoleBySlug('admin');
        $role->users()->attach($user);
        return redirect('/login');
    }
}
