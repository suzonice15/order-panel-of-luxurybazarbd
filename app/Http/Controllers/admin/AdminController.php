<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Hash;
use Auth;

class AdminController extends Controller
{
    public  function index(){
        $data['users']=  DB::table('admin')->get();
        return view('admin.user.index',$data);
    } 
    public  function create(){ 
        return view('admin.user.create');
    }
    public  function delete($id){ 
        DB::table('admin')->where('admin_id','=',$id)->delete();  
        return redirect()->back()->with('success', 'deleeted successfully.');
    } 
    public  function login(){
       $admin_id= Session::get("admin_id");
        if($admin_id){
            return redirect('admin/dashboard');
        }

        return view('admin.login');
        }

    
    public  function LoginCheck(Request $request)
    {       
         $email= $request->email;   
         $credentials=$request->only('email','password');
       
         $user_info=DB::table('users')
                    ->where('email','=',$email)
                    ->where('status',"Active")
                    ->first();
                     
         if($user_info && Auth::attempt($credentials)){ 
                        //    Session::put("admin_id",$admin->user_id);   
                        //    Session::put("email",$admin->user_email);
                        //    Session::put("name",$admin->user_name);   
                        //    Session::put("status",$admin->user_type);

                           return redirect('/admin/dashboard')->with('success','Login Successfull');                  
                 
         }else {
             return redirect('/admin/login')->with('error','Wrong Email Address ');
   
         }
   

    }
   

    public  function edit($id){
        $data['user']= DB::table('admin')->where('admin_id',$id)->first();
        return view('admin.user.edit',$data);
    }
    public  function update(Request $request,$id)
    {
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['user_phone'] = $request->user_phone;
        $data['status'] = $request->status;
        if ($request->password){
           
            $data['password']=bcrypt($reqeust->password);

          }
         DB::table('admin')->where('admin_id',$id)->update($data);
        return redirect('/admin/user')->with('success','Updated successfully');
    }

    public  function store(Request $request)
    {
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['status'] = $request->status;
        $data['registered_date'] = date("Y-m-d");

        
        if ($request->password){
            $data['password']=bcrypt($request->password);
          }
         DB::table('admin')->insert($data);
        return redirect('/admin/user')->with('success','Updated successfully');
    }
    public function  logout(){
 
        Session::put("admin_id","");     

        Session::put("email","");
        Session::put("name","");
        Session::flush();
        return redirect('/admin/login');
    
    }
    




}
