<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryProductRelation;
use App\Models\VCategoryRightProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use DB;
use Cache;

class ProductController extends Controller
{
    public function Products($product_name)
    {

        $data= Cache::remember('product_name_'.$product_name, 60, function() use ($product_name) {
            $product=DB::table('product')->where('product_name',$product_name)->first();
            if($product){
                $data['image']=getProductGalaryImageByProductId($product->product_id);
                $data['product']=$product;
                $data['hot_product']=$this->hotProducts();
                $data['related_product']=$this->related_products($product->product_id);
                $data['product_right_category']=$this->singleProductRightCategory($product->product_id);
                return response()->json($data);
            }else{
                $data['image']='';
                $data['product']='';
                $data['hot_product']='';
                $data['related_product']='';
                return response()->json($data);
            }
        });
        return response()->json($data);
    }

    public function allProducts()
    {


        $allProducts= Cache::remember('allProducts', 15000, function() {
            return  DB::table('product')->selectRaw('product_title,product_name,featured_image,sell_price,discount_price,discount_type')
                ->orderBy('modified_time','desc')->get();
        });


        return response()->json($allProducts);
    }
    public function singleProductRightCategory($product_id)
    {
        return VCategoryRightProduct::with('category')
            ->where('product_id',$product_id)->limit(1)->first();

    }

    public function related_products($product_id)
    {
        $category_ids= CategoryProductRelation::where('product_id',$product_id)->pluck('term_id');
        return  CategoryProductRelation::whereIn('term_id',$category_ids)
            ->groupBy('product_id')->limit(6)->get();
    }

    public function hotProducts()
    {
        //$hotProducts= Cache::remember('hotProducts', 15000, function() {
        return CategoryProductRelation::where('discount_price', '>=', 1000)
            ->groupBy('product_id')->limit(6)->get();
        //});
        // return $hotProducts;
    }

    public function productSearch(Request $request)
    {
        $search=$request->search;
        $data= DB::table('product')
            ->selectRaw('product_title,product_name,featured_image,sell_price,discount_price,discount_type,sku')
            ->where('product_title','like',"%$search%")
            ->orWhere('sku','like',"%$search%")
            ->limit(48)
            ->get();
        return response()->json($data);
    }
}
