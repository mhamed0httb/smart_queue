<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Company;
use Illuminate\Support\Facades\Storage;
use App;


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
        /*$exists = Storage::disk('local')->exists('storage/9126e8a08d6be4343d5ac0dcb4299a88.jpeg');
        if($exists){
            return Storage::get('storage/9126e8a08d6be4343d5ac0dcb4299a88.jpeg');
        }else{
            return 'no such file';
        }*/
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
}
