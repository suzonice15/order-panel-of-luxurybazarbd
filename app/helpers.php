<?php
//use Auth;
function totalOrder($order_status)
{
    $staff_id = Auth::user()->id;
    $status = Auth::user()->role_id;
    $query=DB::table('orders');
    if ($status == 3) {
        $query->where('user_id', '=', $staff_id);
    }
    if($order_status !='All'){
      $query->where('status', $order_status);
    }
    return $query->count();
}

function getAllOrderStatusForOrderIndex($order_status=null,$order_id=null){
    $Processing =$order_status=="Processing" ? "selected":"";
     $PendingPayment =$order_status=="Payment Pending" ? "selected":"";
    $Canceled =$order_status=="Canceled" ? "selected":"";
    $Completed =$order_status=="Completed" ? 'selected':"";
    $Delivered =$order_status=="Delivered" ? "selected":"";
    $PendingInvoice =$order_status=="Pending Invoiced" ? "selected":"";
    $Invoice =$order_status=="Invoiced" ? "selected":"";
    $Hold =$order_status=="On Hold" ? "selected":"";
    echo '<select  style="width:120px" name="order_status" id="order_status" class="form-control select2 orderStatusList">
                <option value="">Select Option</option>
                <option '.$Processing.' value="Processing" order_id='.$order_id.'>Processing</option>
                <option '.$PendingPayment.' value="Payment Pending" order_id='.$order_id.'>Payment Pending</option>
                 <option  '.$Completed.' value="Completed" order_id='.$order_id.'> Completed</option>
                <option '.$Delivered.' value="Delivered" order_id='.$order_id.'>Delivered</option>
                <option '.$Canceled.' value="Canceled" order_id='.$order_id.'>Canceled</option>
                <option '.$PendingInvoice.' value="Pending Invoiced" order_id='.$order_id.'>Pending Invoiced</option>
                <option '.$Invoice.' value="Invoiced" order_id='.$order_id.'>Invoiced</option>
                <option '.$Hold.' value="On Hold" order_id='.$order_id.'>On Hold</option>
            </select>';

  
   

}


function orderStatusReport($order_status,$start_date,$ending_date)
{

    if($order_status=='return'){
        return DB::table('orders')
            ->where('return_date', '>=', $start_date)
            ->where('return_date', '<=', $ending_date)
            ->where('status', '=', $order_status)
            ->count();
    }elseif($order_status=='booking'){
    return DB::table('orders')
        ->where('deliveryDate', '>=', $start_date)
        ->where('deliveryDate', '<=', $ending_date)
        ->where('status', '=', $order_status)
        ->count();
     }
        return DB::table('orders')
            ->where('orderDate', '>=', $start_date)
            ->where('orderDate', '<=', $ending_date)
            ->where('status', '=', $order_status)
            ->count();
    
}
function onlineOrder($start_date,$ending_date)
{

    return DB::table('orders')
        ->whereDate('orderDate', '>=', $start_date)
        ->whereDate('orderDate', '<=', $ending_date)
        ->where('order_created_by', '=', 'Online')
        ->count();

}

function TotalOnlineStaffOrderList($start_date,$ending_date)
{

    return DB::table('orders')
        ->whereDate('orderDate', '>=', $start_date)
        ->whereDate('orderDate', '<=', $ending_date)     
        ->count();

}

function getTotalOrderListItems($status,$start_date,$ending_date)
{
if($status==1) {


    return DB::table('orders')
        ->whereDate('orderDate', '>=', $start_date)
        ->whereDate('orderDate', '<=', $ending_date)
        ->get();
}elseif($status==2){
    return DB::table('orders')
        ->whereDate('orderDate', '>=', $start_date)
        ->whereDate('orderDate', '<=', $ending_date)
        ->where('order_created_by', '=', 'online')
        ->get();
}else{
    return DB::table('orders')
        ->whereDate('orderDate', '>=', $start_date)
        ->whereDate('orderDate', '<=', $ending_date)
        ->where('order_created_by', '!=', 'online')
        ->get();
}

}

function StaffOrderList($start_date,$ending_date)
{

    return DB::table('orders')
        ->whereDate('orderDate', '>=', $start_date)
        ->whereDate('orderDate', '<=', $ending_date)
        ->where('order_created_by', '!=', 'Online')
        ->count();

}


function getOrderStatus($order_status,$staff_id)
{
    $start_date = date('Y-m-01');
    $ending_date  = date('Y-m-31');
      return DB::table('orders')
            ->where('staff_id', '=', $staff_id)
            ->where('status', '=', $order_status)
          ->where('orderDate', '>=', $start_date)
          ->where('orderDate', '<=', $ending_date)
            ->count();    
}

function getPrint($staff_id)
{
    $start_date = date('Y-m-01');
    $ending_date  = date('Y-m-31');
    return DB::table('orders')
        ->where('staff_id', '=', $staff_id)
        ->where('order_print_status', '=', 1)
        ->where('orderDate', '>=', $start_date)
        ->where('orderDate', '<=', $ending_date)
        ->count();
}


function officeStaffName($id)
{
    return DB::table('users')
        ->where('id', '=', $id)
        ->value('name');

}
function getCourierName($coureir_id){
    if($coureir_id  >0 ) 
    {    
      $ses_courierInfo= session()->get('ses_courierInfo');    
      return   $ses_courierInfo[$coureir_id];
    }else{
        return 'Not Selected';
    }
}
function getUserName($user_id){
    if($user_id  >0 ) 
    {    
      $userInfo= session()->get('ses_userInfo');    
      if (array_key_exists($user_id,$userInfo))
            { 
                return   $userInfo[$user_id];
            }else{
                   return 'Not Selected';
            }
    }else{
        return 'Not Selected';
    }
}

function setCacheData(){
    
    Cache::remember('users', 360000, function () {
        return DB::table('users')->select('id', 'name')->where('role_id', '=', 3)->get();
    });

      Cache::remember('couriers', 360000, function () {
        return DB::table('couriers')->select('id', 'courierName')->get();
    });
 }
 function removeCacheData(){
    
    
 }


function staticSessionData(){
           $courierArray=[];
             $couriers=  Cache::get('couriers');
            foreach($couriers as $row){ 
                $courierArray[$row->id]=$row->courierName;
            }

     session(['ses_courierInfo'=>$courierArray]);

            $userArray=[];
             $users=  Cache::get('users');
            foreach($users as $row){ 
                $userArray[$row->id]=$row->name;
            }
            session(['ses_userInfo'=>$userArray]);
}

function get_option($option_name)
{
    return DB::table('options')
        ->select('option_value')
        ->where('option_name', $option_name)
        ->value('option_value');
}

function single_product_information($product_id)
{
    $result = DB::table('product')->select('sku', 'product_name', 'product_title')->where('product_id', $product_id)->first();
    if ($result) {
        return $result;
    }
}

function getProductGalaryImageByProductId($product_id)
{
    $picture=array();
    $media_ids= DB::table('productmeta')
        ->where('product_id', $product_id)
        ->where('meta_key', 'gallery_image')
        ->value('meta_value');
    if($media_ids){
       $media_ids_arrays=explode(',',$media_ids);
        $picture= DB::table('media')
            ->select('media_path')
            ->whereIn('media_id', $media_ids_arrays)->get();
         return $picture;
    }
    return $picture;
}

