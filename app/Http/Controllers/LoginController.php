<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Sentinel;
use Session;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Reminder;
use Mail;

class LoginController extends Controller
{
    public function login(){
        return view('admin.login');
    }

    public function postLogin(Request $req){
        try{
            Sentinel::Authenticate($req->all());
            if(Sentinel::check()){
                if(Sentinel::getUser()->roles()->first()->slug == 'admin'){
                    return redirect('/dashboard');
                }elseif (Sentinel::getUser()->roles()->first()->slug == 'manager'){
                    return redirect('/manager');
                }else{
                    return redirect('/');
                }
            }else{
                Session::flash('error_credentials', 'Wrong Credentials');
                return redirect('/login');
            }
        }catch(ThrottlingException $e){
            $delay = $e->getDelay();
            Session::flash('banned', 'You are banned for '.$delay.' seconds');
            return redirect('/login');
        }
        //return Sentinel::check();
        //dd($req->all());
    }

    public function logout(){
        Sentinel::logout();
        return redirect('/login');
    }

    public function forgetPassword()
    {
        return view('admin.forget_password');
    }

    public function postForgetPassword(Request $req)
    {
        $user = User::whereEmail($req->email)->first();
        if($user == null){
            return redirect()->back()->with(['success' => 'Reset code was sent to your Email']);
        }
        $sentinelUser = Sentinel::findById($user->id);
        $reminder = Reminder::exists($sentinelUser) ?: Reminder::create($sentinelUser);
        $this->sentEmail($user,$reminder->code);
        return redirect()->back()->with(['success' => 'Reset code was sent to your Email']);
    }

    private function sentEmail($user,$code)
    {
        Mail::send('emails.forget-password',[
            'user' => $user,
            'code' => $code
        ],function($message) use ($user){
            $message->to($user->email);
            $message->subject("Hello $user->first_name, reset your password");
        });
    }

    public function resetPassword($email,$resetCode)
    {
        $user = User::whereEmail($email)->first();
        if($user == null){
            abort(404);
        }
        $sentinelUser = Sentinel::findById($user->id);
        if($reminder = Reminder::exists($sentinelUser)){
            if($resetCode == $reminder->code){
                return view('admin.reset-password');
            }else{
                return redirect('/login');
            }
        }else{
            return redirect('/login');
        }
    }

    public function postResetPassword(Request $req, $email, $resetCode)
    {
        $this->validate($req, [
            'password' => 'confirmed|required|min:5|max:10',
            'password_confirmation' => 'required'
        ]);
        $user = User::whereEmail($email)->first();
        if($user == null){
            abort(404);
        }
        $sentinelUser = Sentinel::findById($user->id);
        if($reminder = Reminder::exists($sentinelUser)){
            if($resetCode == $reminder->code){
                Reminder::complete($sentinelUser,$resetCode,$req->password);
                return redirect('/login')->with('success_reset_password','Please login with your new password');
            }else{
                return redirect('/login');
            }
        }else{
            return redirect('/login');
        }
    }
}
