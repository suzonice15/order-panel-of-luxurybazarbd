<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Cache;
class DashboardController extends Controller
{
    public  function index(Request $request){

      //  $data['users']=  DB::table('users')->get();
      $today_date=date("Y-m-d");
      $data['today_date']="";
      if($request->all()){ 
        $today_date=$request->orderDate; 
        $data['today_date']=$request->orderDate; 
        $data['totay_orders']= DB::table('orders')
                    ->whereDate('orderDate',$today_date)
                    ->count(); 
          return view('admin.ajax_dashboard',$data);        


         }

        $data['totay_orders']= DB::table('orders')
                    ->whereDate('orderDate',$today_date)
                    ->count(); 
      setCacheData();
     staticSessionData();

 

        return view('admin.dashboard',$data);
    }
}
