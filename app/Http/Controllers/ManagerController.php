<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Company;

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
}
