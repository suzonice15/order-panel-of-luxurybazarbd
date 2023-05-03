<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;
use DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sliders()
    {
        $sliders= Cache::remember('sliders', 15000, function() {
            return DB::table('homeslider')->select('homeslider_banner')->get();
        });
        return response()->json($sliders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function homeCategoryProducts()
    {

        $homeCategoryProducts= Cache::remember('homeCategoryProducts', 15000, function() {
              $home_cat_section = explode(",", get_option('home_cat_section'));
            $data=array();
            foreach ($home_cat_section as $key=>$home_cat){
                $data['products'][$key]=DB::table('v_product_category')->where('term_id',$home_cat)->limit(12)->get();
            }
            return $data;
        });

        return response()->json($homeCategoryProducts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
