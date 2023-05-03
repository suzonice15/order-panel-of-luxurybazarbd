<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Cache;
class DashboardController extends Controller
{
    public  function index(){

        $data['users']=  DB::table('users')->get();
        $data['totay_orders']= DB::table('orders')
                    ->whereDate('created_at',date("Y-m-d"))
                    ->count(); 
    setCacheData();

     staticSessionData();

 

        return view('admin.dashboard',$data);
    }
}
