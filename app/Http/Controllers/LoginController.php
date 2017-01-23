<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;

class LoginController extends Controller
{
    public function login(){
        return view('authentication.login');
    }

    public function postLogin(Request $req){
        Sentinel::Authenticate($req->all());
        if(Sentinel::check()){
            if(Sentinel::getUser()->roles()->first()->slug == 'admin'){
                return redirect('/dashboard');
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/login');
        }
        //return Sentinel::check();
        //dd($req->all());
    }

    public function logout(){
        Sentinel::logout();
        return redirect('/login');
    }
}
