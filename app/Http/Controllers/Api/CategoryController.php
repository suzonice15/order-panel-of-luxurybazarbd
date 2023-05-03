<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Cache;
use DB;

class CategoryController extends Controller
{

    public function menuList()
    {
        $categories= Cache::remember('menuList', 15000, function() {
            return Category::with('sub.child')->where('parent_id',0)->get();
        });
         return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function homeCategory()
    {
        $homeCategory = Cache::remember('homeCategory', 36000, function () {
            return DB::table('v_category_image_path')->get();
        });
        return $homeCategory;

    }

    public function categoryProducts($category_name)
    {
    $data=DB::table('v_product_category')->where('category_name',$category_name)->get();
     return response()->json($data);
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
