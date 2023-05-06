<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use Cache;
use Auth;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Store;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Notification;
 use App\Models\OrderProduct;

class OrderController extends Controller
{

    public function __constructor(){
        date_default_timezone_set('Asia/Dhaka');
    }
    public function index(Request $request)
    {
        $staff_id = Auth::user()->id;
        $role_status = Auth::user()->role_id;
        $order_status='Processing';

        if ($role_status ==3) {
           
            $data['orders']=Order::with('customer','products')->where('status', '=',$order_status)
                        ->where('user_id', '=', $staff_id)
                        ->orderBy('updated_at', 'desc')
                        ->paginate(10);
            return view('admin.order.index', $data);
        }
        $data['orders'] =Order::with('customer','products')->where('status', '=', $order_status) 
                        ->orderBy('updated_at', 'desc')
                        ->paginate(10); 

        $data['users'] =Cache::get('users');
        $data['courierInfo'] =Cache::get('couriers');

        return view('admin.order.index', $data);
    }

    public function orderExchange(Request $request)
    {
        $count = count($request->order_id);
          if($request->staff_id){
            $data['user_id'] = $request->staff_id;
              } 
        if ($count > 0) {
            foreach ($request->order_id as $order_id) {
                if($request->staff_id || $request->order_status){
                  
                    if($request->order_status){
                        $status= $request->order_status;
                   // $data['status'] = $request->order_status;
                   $order =   DB::table('orders')->where('id', '=', $order_id)->first();
                    if ($status == 'Completed') {
                        $data['orderDate'] = date('Y-m-d');
                        $data['status'] = "Pending Invoiced";
                    }
                     if ($status == 'Delivered') {
                        $data['deliveryDate'] = date('Y-m-d');
                        $orderProducts = OrderProduct::query()->where('order_id', '=', $order_id)->get();
                        foreach ($orderProducts as $orderProduct) {
                            $stock = Stock::query()->where('product_id', '=', $orderProduct->product_id)->first();
                            $stock->stock = $stock->stock - $orderProduct->quantity;
                            $stock->save();
                        }
                    }
                     if ($status == 'Paid') {
                        $data['completeDate'] = date('Y-m-d');
                    }
                     if ($status == 'Return') {
                        $data['completeDate'] = date('Y-m-d');
                        $orderProducts = OrderProduct::query()->where('order_id', '=', $order_id)->get();
                        foreach ($orderProducts as $orderProduct) {
                            $stock = Stock::query()->where('product_id', '=', $orderProduct->product_id)->first();
                            $stock->stock = $stock->stock + $orderProduct->quantity;
                            $stock->save();
                        }
                    }
                     if ($order->courier_id || $status == 'Canceled' || $status == 'On Hold' || $status == 'Payment Pending') {
                       
                      if ($status == 'Completed') { 
                          $data['status']= "Pending Invoiced";
                      }else{
                      $data['status'] = $status;
                      }
                        $result =   DB::table('orders')->where('id', '=', $order_id)->update($data);
                        if ($result) {
                            $response['status'] = 'success';
                            $response['message'] = 'Successfully Update Status to ' . $status;
                            $notification = new Notification();
                            $notification->order_id = $order_id;
                            $notification->notificaton = Auth::user()->name . ' Successfully Update #BB-' . $order_id . ' Order status to ' . $status;
                            $notification->user_id = Auth::id();
                            $notification->save();
                        }  
                    }  

                    }
            
                }
            }
        }
    }
  
    public function storeInvoice(Request $request)
    {
        Order::whereIn('id',$request->order_id)->update(['status'=>'Invoiced']);
        $ids = serialize($request->order_id);
        $invoice = new Invoice();
        $invoice->order_id = $ids;
        $result = $invoice->save();
        if ($result) {
            $response['status'] = 'success';
            $response['link'] = url('admin/order/invoiceList?id='). $invoice->id;
        } else {
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to Add Order';
        }
        return json_encode($response);
        die();
    }
    public function editHistory(Request $request, $order_id)
    {


        $data['orders'] = DB::table('notifications')
            ->where('id', $order_id)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.order.orderEditHistory', $data);

    }

    public function pagination(Request $request)
    {
        $role_status = Auth::user()->role_id;
        $order_status = $request->get('status');
        $per_page = $request->per_page;
        $courier_id = $request->courier_id;
        $customer_phone = $request->customer_phone;
        $invoice_id = $request->invoice_id;
        $order_date = $request->order_date;
        $user_id = $request->user_id;
        $staff_id = Auth::user()->id;
        $query=Order::with('customer','products');
            if ($role_status == 3) {            
               $query->where('user_id',  $staff_id);  
            }  
            if ($user_id) {            
                $query->where('user_id',$user_id);  
             }  
             if ($order_date) {            
                $query->where('orderDate',$order_date);  
             }  
             

            if($order_status !='All'){
                if($customer_phone=='' && $invoice_id==''){
                    $query->where('status', $order_status);
                }
                
            }  

            if($customer_phone){
                $orderIds=DB::table('customers')
                ->where('customerPhone',$customer_phone)
                ->pluck('order_id')
                ->toArray();
                $query->whereIn('id', $orderIds);
            }  

            if($courier_id){
                $query->where('courier_id', $courier_id);
            } 
            if($invoice_id){
                $query->where('invoiceId', $invoice_id);
            }       
        $orders =$query->orderBy('updated_at', 'desc')->paginate($per_page);  

        $data['orders'] = $orders;
        $response_data['htmls']= view('admin.order.pagination', $data)->render();
        $response_data['total_count']= $orders->total();
        return response()->json($response_data);

    }

   
   

    public function create()
    {   
        $max_order_id=  Order::max('id');
        $invoice_id="BB-".$max_order_id+1; 
        $data['stores']= Store::select('id','storeName')->where('status','Active')->get();
        $data['couriers']= Courier::select('id','courierName')->where('status','Active')->get();
        $data['products'] = DB::table('products')->get();
        $data['invoice_id'] = $invoice_id;
        return view('admin.order.create', $data);
    }

    public function edit($order_id)
    {
      //  $data['areas'] = DB::table('area')->get();
        $data['products'] = DB::table('products')->get();
        $data['order'] = Order::where('id', '=', $order_id)->first();
        $data['stores']= Store::select('id','storeName')->where('status','Active')->get();
        $data['couriers']= Courier::select('id','courierName')->where('status','Active')->get();
        $data['orderTrackInfo'] = DB::table('notifications')
        ->where('order_id', $order_id)->orderBy('id', 'desc')
        ->get();
        return view('admin.order.edit', $data);
    }

    public function update(Request $request, $order_id)
    {
        date_default_timezone_set("Asia/Dhaka");
        
       $order= Order::find($order_id);
       $order->update($request->all()); 
        $customer=  Customer::where('order_id',$order_id)->first();
        $customer->update($request->all());

        $product_ids= $request->product_id;
        $productCode= $request->productCode; 
        $productName= $request->productName;
        $productPrice= $request->productPrice;
        $quantity= $request->quantity;

        OrderProduct::where('order_id',$order_id)->delete();

        foreach($product_ids as $key=>$product_id){
            $newArray=array([
                'product_id'=>$product_ids[$key],
                'productCode'=>$productCode[$key], 
                'productName'=>$productName[$key],
                'productPrice'=>$productPrice[$key],
                'quantity'=>$quantity[$key],
                'order_id'=>$order_id,
            ]);
            OrderProduct::insert($newArray);
        }   

        $result = 1;

     
        if ($result) {
            return redirect('admin/order')->with('success', 'Updated successfully.');
        } else {
            return redirect('/admin/order')->with('error', 'Error to Update this order');
        }

    }

    public function order_status()
    {
        return view('admin.order.order_status');
    }

    public function store(Request $request)
    {
        if(empty($request->product_id)){
            return redirect('admin/order/create')->with('error', 'Please Select Product');
        }
        date_default_timezone_set("Asia/Dhaka");
        $order= Order::create($request->all()); 
        $order->invoiceId= "BB-".$order->id;
        $order->save();
        $order_id=$order->id;

        $customer=  Customer::create($request->all());
        $customer->order_id=$order_id;
        $customer->save();

        $product_ids= $request->product_id;
        $productCode= $request->productCode; 
        $productName= $request->productName;
        $productPrice= $request->productPrice;
        $quantity= $request->quantity;

 
        foreach($product_ids as $key=>$product_id){
            $newArray=array([
                'product_id'=>$product_ids[$key],
                'productCode'=>$productCode[$key], 
                'productName'=>$productName[$key],
                'productPrice'=>$productPrice[$key],
                'quantity'=>$quantity[$key],
                'order_id'=>$order_id,
            ]);
            OrderProduct::insert($newArray);
        }   

        
        /// order edit track
        $order_track['status'] = 1;
        $order_track['user_id'] = Auth::user()->id;
        $order_track['order_id'] = $order_id;
        $order_track['created_at'] = date('Y-m-d H:i:s');
        $order_track['updated_at'] = date('Y-m-d H:i:s'); 
        $order_track['notificaton'] = $request->invoiceId ."has been created by ".Auth::user()->name;

         DB::table('notifications')->insert($order_track);
        if ($order_id) {
            return redirect('admin/order')->with('success', "Invoice ID BB-$order_id Created successfully.");
        } else {
            return redirect('admin/order')->with('error', 'Error to Create this order');
        }

    }
    public function orderUpdateByOrderStatus(Request $request)
    {        

      $order=  Order::find($request->order_id);
     // $order->status=$request->order_status;
      $status = $request->order_status;
   

      if ($status == 'Completed') {
          $order->orderDate = date('Y-m-d');
          $order->status = "Pending Invoiced";
      }
       if ($status == 'Delivered') {
          $order->deliveryDate = date('Y-m-d');
          $orderProducts = OrderProduct::query()->where('order_id', '=', $order->id)->get();
          foreach ($orderProducts as $orderProduct) {
              $stock = Stock::query()->where('product_id', '=', $orderProduct->product_id)->first();
              $stock->stock = $stock->stock - $orderProduct->quantity;
              $stock->save();
          }
      }
       if ($status == 'Paid') {
          $order->completeDate = date('Y-m-d');
      }
       if ($status == 'Return') {
          $order->completeDate = date('Y-m-d');
          $orderProducts = OrderProduct::query()->where('order_id', '=', $order->id)->get();
          foreach ($orderProducts as $orderProduct) {
              $stock = Stock::query()->where('product_id', '=', $orderProduct->product_id)->first();
              $stock->stock = $stock->stock + $orderProduct->quantity;
              $stock->save();
          }
      }
       if ($order->courier_id || $status == 'Canceled' || $status == 'On Hold' || $status == 'Payment Pending') {
         
        if ($status == 'Completed') { 
            $order->status = "Pending Invoiced";
        }else{
        $order->status = $status;
        }
          $result = $order->save();
          if ($result) {
              $response['status'] = 'success';
              $response['message'] = 'Successfully Update Status to ' . $status;
              $notification = new Notification();
              $notification->order_id = $request->order_id;
              $notification->notificaton = Auth::user()->name . ' Successfully Update #BB-' . $request->order_id . ' Order status to ' . $status;
              $notification->user_id = Auth::id();
              $notification->save();
          } else {
              $response['status'] = 'failed';
              $response['message'] = 'Unsuccessful to update Status ' . $status;
          }
      }else {
        $response['status'] = 'failed';
        $response['message'] = 'Please Update order courier and try again !';
    }  

    return json_encode($response);
        
    }

    public function newProductSelectionChange(Request $request)
    {
        $product_ids = explode(",", $request->product_id);
        $data['qty'] = $request->product_quantity;
        $data['shipping_charge'] = $request->shipping_charge;
        $data['order_id'] = $request->order_id;
        $data['products'] = DB::table('product')->whereIn('product_id', $product_ids)->get();
        $data['order'] = DB::table('order')->where('order_id', $request->order_id)->first();
        return view('admin.order.new_ajax_order', $data);
    }

    public function newProductEditSelectionChange(Request $request)
    {
        $product_ids = explode(",", $request->product_id);
        $data['qty'] = $request->product_quantity;
        $data['shipping_charge'] = $request->shipping_charge;
        $data['order_id'] = $request->order_id;
        $data['products'] = DB::table('product')->whereIn('product_id', $product_ids)->get();
        $data['order'] = DB::table('order')->where('order_id', $request->order_id)->first();
        return view('admin.order.new_ajax_order_edit', $data);
    }


    public function newProductUpdateChange(Request $request)
    {


        $product_ids = explode(",", $request->product_ids);
        $product_qtys = explode(",", $request->product_qtys);
        $data['shipping_charge'] = $request->shipping_charge;
        $data['order_id'] = $request->order_id;
        $data['order'] = DB::table('order')->where('order_id', $request->order_id)->first();
        $pqty = array_combine($product_ids, $product_qtys);
        $data['pqty'] = $pqty;
        $data['products'] = DB::table('product')->whereIn('product_id', $product_ids)->get();
        return view('admin.order.newProductUpdateChange', $data);
    }

    public function ProductUpdateChangeOfNewOrder(Request $request)
    {


        $product_ids = explode(",", $request->product_ids);
        $product_qtys = explode(",", $request->product_qtys);
        $data['shipping_charge'] = $request->shipping_charge;
        $data['order_id'] = $request->order_id;
        $data['order'] = DB::table('order')->where('order_id', $request->order_id)->first();
        $pqty = array_combine($product_ids, $product_qtys);
        $data['pqty'] = $pqty;
        $data['products'] = DB::table('product')->whereIn('product_id', $product_ids)->get();
        return view('admin.order.ProductUpdateChangeOfNewOrder', $data);
    }


    public function convertOrder()
    {
        ini_set('max_execution_time', 5555555555);

        $orders = DB::table('order')->select('order_id')->whereBetween('order_id', [28000, 33935])->get();
        foreach ($orders as $order) {
            $order_row = DB::table('ordermeta')->where('order_id', '=', $order->order_id)->first();
            if ($order_row) {
                $data['billing_name'] = DB::table('ordermeta')->where('order_id', '=', $order->order_id)->where('meta_key', '=', 'billing_name')->value('meta_value');
                $data['billing_mobile'] = DB::table('ordermeta')->where('order_id', '=', $order->order_id)->where('meta_key', '=', 'billing_phone')->value('meta_value');
                $data['shipping_address1'] = DB::table('ordermeta')->where('order_id', '=', $order->order_id)->where('meta_key', '=', 'shipping_address1')->value('meta_value');
                if (strlen($data['shipping_address1']) < 450) {
                    DB::table('order')->where('order_id', '=', $order->order_id)->update($data);

                }
            }

        }


    }

    public function productReport(Request $request)
    {

        if ($request->order_date_start || $request->order_date_end || $request->product_code) {


            if ($request->product_code) {
                $start_date = date("Y-m-d");

                $data['searchDateStart'] = $start_date;
                $data['searchDateEnd'] = $start_date;
                $data['searchText'] = $request->product_code;

                $data['orders'] = DB::table('product_order_report')
                    ->select('sku', 'product_title', 'product_code', 'product_order_report.product_id', DB::raw('count(*) as total'))
                    ->join('product', 'product.product_id', '=', 'product_order_report.product_id')
                    ->where('product_code', '=', $request->product_code)
                    ->groupBy('product_order_report.product_id')->get();
            } else if ($request->order_date_start && $request->order_date_end) {
                $start_date = date("Y-m-d", strtotime($request->order_date_start));
                $ending_date = date("Y-m-d", strtotime($request->order_date_end));
                $data['searchDateStart'] = $start_date;
                $data['searchDateEnd'] = $ending_date;
                $data['orders'] = DB::table('product_order_report')
                    ->select('sku', 'product_title', 'product_code', 'product_order_report.product_id', DB::raw('count(*) as total'))
                    ->join('product', 'product.product_id', '=', 'product_order_report.product_id')
                    ->whereBetween('orderDate', [$start_date, $ending_date])->groupBy('product_order_report.product_id')->get();

            } else {
                $start_date = date("Y-m-d", strtotime($request->order_date_start));
                $ending_date = date("Y-m-d", strtotime($request->order_date_end));
                $data['searchDateStart'] = $start_date;
                $data['searchDateEnd'] = $ending_date;
                $data['searchText'] = $request->product_code;
                $data['orders'] = DB::table('product_order_report')
                    ->select('sku', 'product_title', 'product_code', 'product_order_report.product_id', DB::raw('count(*) as total'))
                    ->join('product', 'product.product_id', '=', 'product_order_report.product_id')
                    ->where('product_code', '=', $request->product_code)
                    ->whereBetween('orderDate', [$start_date, $ending_date])
                    ->groupBy('product_order_report.product_id')->get();

            }


        } else {
            $start_date = date("Y-m-d");
            $ending_date = date("Y-m-d");
            $data['searchDateStart'] = $start_date;
            $data['searchDateEnd'] = $start_date;
            $data['orders'] = DB::table('product_order_report')
                ->select('sku', 'product_title', 'product_code', 'product_order_report.product_id', DB::raw('count(*) as total'))
                ->join('product', 'product.product_id', '=', 'product_order_report.product_id')
                ->whereBetween('orderDate', [$start_date, $ending_date])->groupBy('product_order_report.product_id')->get();

        }


        return view('admin.order.productReport', $data);

    }

    public function single_order_invoice($orderID)
    {
        
        $invoice = Invoice::find($id);
        return view('admin.order.print', compact('invoice'));

    }

    public function orderStatusReport(Request $request)
    {


        date_default_timezone_set("Asia/Dhaka");
        $data['start_date'] = date("Y-m-d");
        $data['ending_date'] = date("Y-m-d");
        $data['orders'] = array();

        $data['orderStatus'] = $request->order_status;
        
        if ($request->order_id ) {

            $data['orders'] = DB::table('orders') 
            ->where('order_id', '=', $request->order_id)
            ->orderBy('order_id', 'desc')
            ->get();
            return view('admin.order.orderStatusReport', $data);
        }



        if ($request->order_status && $request->starting_date && $request->ending_date) {

            $data['start_date'] = date("Y-m-d", strtotime($request->starting_date));
            $data['ending_date'] = date("Y-m-d", strtotime($request->ending_date));
            $data['orderStatus'] = $request->order_status;
            if($request->order_status=='return'){
                $data['orders'] = DB::table('orders')
                    ->where('return_date', '>=', $data['start_date'])
                    ->where('return_date', '<=', $data['ending_date'])
                    ->where('status', '=', $request->order_status)
                    ->orderBy('id', 'desc')
                    ->get();
            }elseif($request->order_status=='booking'){
                $data['orders'] = DB::table('orders')
                    ->where('shipment_time', '>=', $data['start_date'])
                    ->where('shipment_time', '<=', $data['ending_date'])
                    ->where('status', '=', $request->order_status)
                    ->orderBy('id', 'desc')
                    ->get();
            }else{
                $data['orders'] = DB::table('orders')
                    ->where('orderDate', '>=', $data['start_date'])
                    ->where('orderDate', '<=', $data['ending_date'])
                    ->where('status', '=', $request->order_status)
                    ->orderBy('id', 'desc')
                    ->get();

            }


        } else if ($request->starting_date && $request->ending_date) {
            $data['orderStatus'] = "";
            $data['start_date'] = date("Y-m-d", strtotime($request->starting_date));
            $data['ending_date'] = date("Y-m-d", strtotime($request->ending_date));
            $data['orders'] = DB::table('orders')
                ->where('orderDate', '>=', $data['start_date'])
                ->where('orderDate', '<=', $data['ending_date'])
                ->orderBy('id', 'desc')
                ->get();
        } else {

            $data['orderStatus'] = "";
            $data['start_date'] = date("Y-m-d");
            $data['ending_date'] = date("Y-m-d");
            $data['orders'] = DB::table('orders')
                ->where('orderDate', '>=', $data['start_date'])
                ->where('orderDate', '<=', $data['ending_date'])
                ->orderBy('id', 'desc')
                ->get();
        }

 
        return view('admin.order.orderStatusReport', $data);


    }

    public function currentMonthStaffReport()
    {
        $start_date = date("Y-m-01");
        $ending_date = date("Y-m-31");

        $data['orders'] = DB::table('order')->select('staff_id', DB::raw('count(order_id) as total'))
            ->groupBy('staff_id')
            ->where('orderDate', '>=', $start_date)
            ->where('orderDate', '<=', $ending_date)
            ->get();

        return view('admin.order.currentMonthStaffReport', $data);
    }

    public function getTotalProductsReport(Request $request)
    {
        $data['orders'] = getTotalOrderListItems($request->status, $request->starting_date, $request->ending_date);
        return view('admin.order.order_loop', $data);
    }

    public function sendProductToRedex(Request $request)
    {
        $start_date=date("d-m-Y");
        $end_date=date("d-m-Y");
        if($request->filter=='filter'){
            $start_date=date("Y-m-d",strtotime($request->starting_date));
            $end_date=date("Y-m-d",strtotime($request->end_date));
            $data['orders'] = DB::table('orders')
                ->where('courier_id', 'Redx')
                ->where('status', 'invoice')
                ->where('orderDate', '>=', $start_date)
                ->where('orderDate', '<=', $end_date)
                ->orderBy('id', 'desc')
                ->get();

        } else if($request->booking=='booking')   {
            $start_date=date("Y-m-d",strtotime($request->starting_date));
            $end_date=date("Y-m-d",strtotime($request->end_date));

            $data['orders'] = DB::table('orders')
                ->where('courier_id', 'Redx')
                ->where('status', 'booking')
                ->where('courier_booking_date', '>=', $start_date)
                ->where('courier_booking_date', '<=', $end_date)
                ->orderBy('id', 'desc')
                ->get();

        } else{

            $data['orders'] = DB::table('orders')
                ->where('courier_id', 'Redx')
                ->whereNull('order_tracking_id')
                ->where('status', 'Invoiced')
                ->orderBy('id', 'desc')
                ->get();
        }
        $data['start_date']= $start_date;
        $data['end_date']= $end_date;
 
        return view('admin.order.sendCourier', $data);
    }

    public function searchOrderOfRedexCourier(Request $request)
    {

            $data['orders'] = DB::table('order')
                ->where('courier_service', 'Redx')
                ->whereIn('order_status', ['invoice','booking'])
                ->where('id', $request->order_id)
                ->orderBy('id', 'desc')
                ->limit(2)->get();
        return view('admin.order.sendCourierComponent', $data);
    }


    public function sendProductCourier(Request $request)
    {
        $failed_to_insert='Failed following order to insert in redex: ';
         $error_count=0;
        $count = count($request->order_id);
        if ($count > 0) {
            foreach ($request->order_id as $order_id) {
                $order = DB::table('order')->where('id', $order_id)->first();
                if ($order->weight > 0 && $order->area_id > 0) {

                    $name = $order->billing_name;
                    $phone = $order->billing_mobile;
                    $address = trim($order->shipping_address1);
                    $cash_collection = str_replace(',', '', $order->order_total);
                    $percel_weight = $order->weight;
                    $value = 80;
                    $note = $order->order_note;
                    $invoice_id = $order->invoice_id;
                    $areaInfo = DB::table('area')->where('area_id', $order->area_id)->first();
                    if ($areaInfo) {
                        $delivery_area = $areaInfo->area_name;
                        $delivery_area_id = $areaInfo->area_id;
                    }

                    $tracking = $this->getTrackingId($name, $phone, $address, $cash_collection, $percel_weight, $value, $note, $invoice_id, $delivery_area, $delivery_area_id);

                    $object = json_decode($tracking);
                    if (isset($object->tracking_id)) {
                        $data['traking_id'] = $object->tracking_id;
                        $data['shipment_time'] = date("Y-m-d");
                        $data['order_status'] = 'booking';
                        DB::table('order')->where('id', '=', $order_id)->update($data);
                    } else{
                        $failed_to_insert .=$order_id.' ,';
                        ++$error_count;
                    }
                }
            }

        }
        if($error_count >0){
          return  $failed_to_insert;
        }else{
            return "Successfully Your Selected Order Booking  to redex.com ";
        }

    }

    public function getTrackingId($name, $phone, $address, $cash_collection, $percel_weight, $value, $note, $invoice_id, $delivery_area, $delivery_area_id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://openapi.redx.com.bd/v1.0.0-beta/parcel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
    "customer_name":"' . $name . '",
    "customer_phone":"' . $phone . '",
    "delivery_area": "' . $delivery_area . '",
    "delivery_area_id": ' . $delivery_area_id . ',
    "customer_address":"' . $address . '",
    "merchant_invoice_id": "' . $invoice_id . '",
    "cash_collection_amount": "' . $cash_collection . '",
    "parcel_weight": ' . $percel_weight . ',
    "instruction": "' . $note . '",
    "value": 100,
    "parcel_details_json": [ {
            "name": "item1",
            "category": "category1",
            "value": 120.05
        },
        {
            "name": "item2",
            "category": "category2",
            "value": 130.05
        } ]
}',
            CURLOPT_HTTPHEADER => array(
                'API-ACCESS-TOKEN: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIyMTAzOCIsImlhdCI6MTY1MzM3Nzk4NiwiaXNzIjoieExQelFrTmZyZjJnb3JkT2s1U1E0NFhTQVdWV0Jqd0MiLCJzaG9wX2lkIjoyMTAzOCwidXNlcl9pZCI6ODE0Mjd9.ppTa6QWyNUj4_N1g48mZ2VsesbhRsEqwfs4ySFxPm5M',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;

    }


    public function getSinglePercel(Request $request){
$row_data=array();
        $row_data['name']='';
        if($request->all()) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://openapi.redx.com.bd/v1.0.0-beta/parcel/track/' . $request->parcel,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'API-ACCESS-TOKEN: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIyMTAzOCIsImlhdCI6MTY1MzM3Nzk4NiwiaXNzIjoieExQelFrTmZyZjJnb3JkT2s1U1E0NFhTQVdWV0Jqd0MiLCJzaG9wX2lkIjoyMTAzOCwidXNlcl9pZCI6ODE0Mjd9.ppTa6QWyNUj4_N1g48mZ2VsesbhRsEqwfs4ySFxPm5M'
                ),
            ));
            
            $response = curl_exec($curl);
           $final_data= json_decode($response);
            curl_close($curl);
            if($final_data){
                $data=array();
                $total_count=0;
                if(isset($final_data->tracking)) {
                    $total_count = count($final_data->tracking);

                    foreach ($final_data->tracking as $key => $row) {
                        $data[$key]['message_en'] = $row->message_en;
                        $data[$key]['message_bn'] = $row->message_bn;
                        $data[$key]['time'] = $row->time;

                    }
                }
            }
            $row_data['result']=$data;
            $row_data['total_count']=$total_count;
            $row_data['name']=$request->parcel;
        }
         return view('admin.order.getSinglePercel',$row_data);
    }
    public function invoiceList(Request $request){
       
        if($request->id){
            $invoice = Invoice::find($request->id);
            return view('admin.order.print', compact('invoice'));
        }
       $data['invoices']= Invoice::orderBy('id','desc')->paginate(10);
     
        return view('admin.order.invoiceList',$data);
    }
    public function getAllOrderTrackHistory(Request $request)
    {
      return  DB::table('notifications')->where('order_id',$request->order_id)->orderBy('id','desc')->get();
    }
    public function storeOrderEditHistory(Request $request)
    {
        $data['order_id']=$request->order_id;
        $data['notificaton']=$request->order_note;
        $data['user_id']=Auth::user()->id;
        $data['status']=1;
        $data['created_at']=date("Y-m-d H:i:s");
        $data['updated_at']=date("Y-m-d H:i:s");
        DB::table('notifications')->insert($data); 
     }
     public function getAllProductsForOrder()
     {
         $products =  DB::table('products')->select('id', 'productCode', 'productName')->get();
         return response()->json($products);
     }

     public function getOrderMeta(Request $request)
     {        
         $product= DB::table('products')->where('id',$request->product_id)->first();
         $product_image=env('IMG_URL').$product->productImage;
         $price=$product->productRegularPrice;
         if($product->productSalePrice > 0){
             $price =$product->productSalePrice;
         }
         echo '<tr>
             <td>
             <img  width="60" src="'.$product_image.'" />
             <br/>
             '.$product->productName.'
              <input type="hidden" name="product_id[]" value="'.$product->id.'" />
             <input type="hidden" name="productCode[]" value="'.$product->productCode.'" />
             <input type="hidden" name="productName[]" value="'.$product->productName.'" />
             <input type="hidden" name="productPrice[]" value="'.$price.'" />   
             </td>
          
                 <td>'.$product->productCode.'</td>
                  <td><input type="number" id="'.$product->id.'" min="1" name="quantity[]" class="form-control quantity" value="1"> </td>
                    <td class="price text-right" id="price_'.$product->id.'">'.$price.'</td>
                    <td class="price text-right sub_total_product" id="sub_total_product_'.$product->id.'">'.$price.'</td>
                      <td><button type="button"   class="btn btn-danger btn-sm delete-product">
                         <i class="fa fa-trash"></i>
                     </button></td></tr>';
         
     }

     public function getCityByCourierId(Request $request)
     {
          $citis= DB::table('cities')->where('courier_id',$request->courier_id)->get();
         $html='<select  required name="city_id" class="custom-select rounded-0 select2" id="city_id">
                                             <option value="">---Please Select Courier----</option>';
         if(count($citis) > 0) {
 
 
             foreach ($citis as $city) {
                 $html .= '<option value="' . $city->id . '">' . $city->cityName . '</option>';
             }
         }else{
 
             $html='<select  required name="city_id" class="custom-select rounded-0 select2" id="city_id">
                                             <option value="">---There are no City Assing----</option>';
         }
 
         $html .='</select>';
         return $html;
         
         
     }

     public function getZoneByCityId(Request $request)
     {
         $zones=DB::table('zones')->select('id','zoneName')->where(['city_id'=>$request->city_id,'status'=>'Active'])->get();

         $html='<select name="zone_id" id="zone_id" class="form-control select2">
              <option value="">---Select Option---</option>';
         foreach($zones as $zone){
             $html .='<option value="'.$zone->id.'">'.$zone->zoneName.'</option>';
         }
         $html .='</select>';
         echo $html;
     }
 
    
}
