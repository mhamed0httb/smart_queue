<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Company;
use App\Token;
use App\OfficeConfig;
use Illuminate\Support\Facades\Storage;
use App;
use Sentinel;
use Session;


class ManagerController extends Controller
{
    public function index(){
        return view('manager.dashboard');
    }

    public function getNotAffectedManagersByCompany(Request $request)
    {
        $idCompany = $request->company_id;
        $managers = DB::table('users')
                ->where('company_id', '=', $idCompany)
                ->where('office_id', '=', null)
                ->get();
        return $managers;
    }

    public function upload(){
        /*
        $fileName = 'storage/9126e8a08d6be4343d5ac0dcb4299a88.jpeg';
        $exists = Storage::disk('local')->exists($fileName);
        if($exists){
            return asset($fileName);
            // Storage::get($fileName); RETURN THE ENTIRE FILE
        }else{
            return 'no such file';
        }
        */
        return view('upload');
    }

    public function postUpload(Request $request){
        //Storage::makeDirectory('avatars'); // CREATE A DIRECTORY IN "storage/app/avatars"

        /* THIS WORKS TOO -> STORE IN "storage/app/avatars/..."
        $file = $request->file('avatar');
        $path = Storage::put('avatars', $file, 'public'); //UPLOAD FILE TO "storage/app/avatars/..." WITH VISIBILITY "public"
        $p = asset($path);
        return $p;
        */


        /* THIS WORKS -> STORE IN "public/avatars/..."
        $file = $request->file('avatar');
        $file->move('avatars', 'yo.jpg');
        return('uploaded');
        */


        /* THIS WORKS -> STORE IN "storage/app/public/..."
        $path = $request->file('avatar')->store('public');
        $p = asset($path);
        return $p;
        */

        /*$p = asset('');
        return $p;*/


        //THE BEST WAY TO UPLOAD IMAGE FOR NOW :D
        $shortPATH = $request->file('avatar')->store('storage');
        App::make('files')->link(storage_path('app/storage'), public_path('storage')); //create Symbolic link between "storage/app/..." AND "public/..."
        $fullPATH = asset($shortPATH);
        return $fullPATH;
    }


    public function basicConfiguration()
    {
        $office = DB::table('offices')
            ->where('manager_id', '=', Sentinel::getUser()->id)
            ->first();
        $config = DB::table('office_config')
            ->where('office_id', '=', $office->id)
            ->first();

        if(count($config) == 0){
            return view('manager.office_config.create');
        }else{
            return redirect('/manager/basicConfiguration/edit');
        }

    }

    public function basicConfigurationStore(Request $request)
    {
        $config = new OfficeConfig;
        $config->opening_time_morning = $request->opening_morning;
        $config->closing_time_morning = $request->closing_morning;
        $config->opening_time_evening = $request->opening_evening;
        $config->closing_time_evening = $request->closing_evening;
        $config->capacity = $request->capacity;

        $office = DB::table('offices')
            ->where('manager_id', '=', Sentinel::getUser()->id)
            ->first();
        $config->office_id = $office->id;
        $config->save();
        Session::flash('success', 'Successfully created the office configuration!');
        return redirect('/manager/basicConfiguration/edit');
    }

    public function basicConfigurationEdit()
    {
        $office = DB::table('offices')
            ->where('manager_id', '=', Sentinel::getUser()->id)
            ->first();
        $config = DB::table('office_config')
            ->where('office_id', '=', $office->id)
            ->first();
        return View('manager.office_config.edit')->with('config',$config);
    }

    public function basicConfigurationUpdate(Request $request)
    {
        $config = OfficeConfig::find($request->config_id);
        $config->opening_time_morning = $request->opening_morning;
        $config->closing_time_morning = $request->closing_morning;
        $config->opening_time_evening = $request->opening_evening;
        $config->closing_time_evening = $request->closing_evening;
        $config->capacity = $request->capacity;
        $config->save();
        Session::flash('update', 'Successfully updated the office configuration!');
        return redirect('/manager/basicConfiguration/edit');
    }

    public function send_notification($tokens, $message)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $tokens,
            'data' => $message
        );
        $headers = array(
            'Authorization:key = AAAAJHz9G48:APA91bGs1TrXvJdDoyVoXuFZsHtTPuYw7zuOt3P047YDmS3DImqqxvrOcHCd20j3o12JeplXmYp4OlPaC7m_QojNHHBQFpJJRboeMEO-qWvQMDIsTvG7j1FbjzXRlEF5NqtzR2SPov9m ',
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public function sendNotifMsg()
    {
        $tokens = array();
        $allTokens = Token::all();
        foreach ($allTokens as $one){
            array_push($tokens,$one->token);
        }
        $message = array("message" => " FCM PUSH NOTIFICATION TEST MESSAGE");
        $message_status = ManagerController::send_notification($tokens, $message);
        return $message_status;
    }

    public function tokenStore(Request $request)
    {
        $token = new Token;
        $token->token = $request->token;
        $token->user_id = $request->user_id;
        $token->save();
        return 'token_added';
    }
}
