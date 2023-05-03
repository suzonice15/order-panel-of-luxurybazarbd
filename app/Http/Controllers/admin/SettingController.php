<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class SettingController extends Controller
{
    public  function setting(Request $request){

        if ($request->isMethod('post')) {
            $data['donate_active']=$request->donate_active;
            DB::table('setting')->update($data);
        }
      $data['setting']=  DB::table('setting')->first();
        return view('admin.setting.setting',$data);
      }
}
