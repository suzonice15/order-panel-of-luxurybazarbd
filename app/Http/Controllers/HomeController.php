<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
  use  Session;
 use URL;
use Illuminate\Support\Facades\Redirect;
use Cache;
class HomeController extends Controller
{
    
    
    public function index()
    {
       
        $data['main'] = 'Categories'; 
        $sliders = Cache::remember('sliders', 36000, function () {
            return DB::table('sliders')->select('slider_picture')->get();
        });
        $data['sliders']=  $sliders;  
        $data['donate_active']=DB::table('setting')->value('donate_active');

        return view('website.home',  $data);
    }

    

    
    public function news()
    {
        $top_blogs = Cache::remember('top_blog', 36000, function () {
            return DB::table('blogs')->where('blog_status','=',1)->orderBy('blog_id','desc')->limit(6)->get();
        });
        $data['top_blogs']=$top_blogs;
        $bottom_blog = Cache::remember('bottom_blog', 36000, function () {
            return DB::table('blogs')->where('blog_status','=',0)->orderBy('blog_id','desc')->get();
        });
        $data['bottom_blogs']=$bottom_blog;        
        return view('website.news',  $data);
    }

    public function single_news($id)
    {
         $data['blog']= DB::table('blogs')->where('blog_parmalink','=',$id)->first(); 
         
        
         $row_data['count']=$data['blog']->count+1;
         DB::table('blogs')->where('blog_id','=',$data['blog']->blog_id)->update($row_data);  
         $data['blogs']= DB::table('blogs')->limit(5)->get();  
        return view('website.single_news',  $data);
    }

    

    public function about()
    {
       
        $data['main'] = 'Categories';
        $data['active'] = 'All Categories';
        $data['title'] = '  ';
        
        return view('website.about',  $data);
    }

    public function donateStore(Request $request)
    {
       
       $data['transaction_id']=$request->transaction_id;
       $data['amount']=$request->amount;
       $data['mobile']=$request->mobile;
       $data['name']=$request->name;
       $data['status']=0;
       $data['created_at']=date("Y-m-d"); 
      $result=  DB::table('donate_us')->insert($data);
      return response()->json(['success'=>true]);
    }
    
  
     
 
}
