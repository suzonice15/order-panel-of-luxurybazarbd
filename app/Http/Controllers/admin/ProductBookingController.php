<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use DB;

class ProductBookingController extends Controller
{
    
    public function productBookingToRedex(Request $request){ 
       
        
            $start_date=date("d-m-Y");
            $end_date=date("d-m-Y");
            if($request->filter=='filter'){
                $start_date=date("Y-m-d",strtotime($request->starting_date));
                $end_date=date("Y-m-d",strtotime($request->end_date));
                $data['orders'] = Order::where('courier_id', 24)
                                        ->where('status', 'Invoiced')
                                        ->where('orderDate', '>=', $start_date)
                                        ->where('orderDate', '<=', $end_date)
                                        ->orderBy('id', 'desc')
                                        ->get();
    
            } else if($request->booking=='booking')   {
                $start_date=date("Y-m-d",strtotime($request->starting_date));
                $end_date=date("Y-m-d",strtotime($request->end_date));
    
                $data['orders'] = Order::where('courier_id', 24)
                                        ->where('status', 'Delivered')
                                        ->where('courier_booking_date', '>=', $start_date)
                                        ->where('courier_booking_date', '<=', $end_date)
                                        ->orderBy('id', 'desc')
                                        ->get();
    
            } else{
    
                $data['orders'] =Order::where('courier_id', 24)
                                    ->whereNull('order_tracking_id')
                                    ->where('status', 'Invoiced')
                                    ->orderBy('id', 'desc')
                                    ->get();
            }
            $data['start_date']= $start_date;
            $data['end_date']= $end_date;
   
            return view('admin.booking.redex_booking', $data);
        }

        public function sendProductToRedex(Request $request){
            $failed_to_insert='Failed following order to insert in redex: ';
            $error_count=0;
           $count = count($request->order_id);
           if ($count > 0) {
               foreach ($request->order_id as $order_id) {
                   $order = Order::with('customer')->where('id', $order_id)->first();
                   if ( $order->area_id > 0) {
   
                       $name = optional($order->customer)->customerName;
                       $phone = optional($order->customer)->customerPhone;
                       $address = trim(optional($order->customer)->customerAddress); 
                      
                       $cash_collection = str_replace(',', '', $order->subTotal);
                       $percel_weight = 500;
                       $value = 80;
                       $note = '';//$order->order_note;
                       $invoice_id = $order->invoiceID;
                       $areaInfo = DB::table('courier_area')->where('database_id', $order->area_id)->first();
                       if ($areaInfo) {
                           $delivery_area = $areaInfo->area_name;
                           $delivery_area_id = $areaInfo->database_id;
                       }
   
                       $tracking = $this->daynamicRedexCode($name, $phone, $address, $cash_collection, $percel_weight, $value, $note, $invoice_id, $delivery_area, $delivery_area_id);
   
                       $object = json_decode($tracking);
                      
                        
                       if (isset($object->tracking_id)) {
                           $data['order_tracking_id'] = $object->tracking_id;
                           $data['courier_booking_date'] = date("Y-m-d");
                           $data['status'] = 'Delivered';
                           DB::table('orders')->where('id', '=', $order_id)->update($data);
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

        
  

    public function daynamicRedexCode($name, $phone, $address, $cash_collection, $percel_weight, $value, $note, $invoice_id, $delivery_area, $delivery_area_id)
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
                'API-ACCESS-TOKEN:Bearer  eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI2ODE5NTgiLCJpYXQiOjE2MjM4MjA1NzQsImlzcyI6InZJWkVUbmdPMjJEaGt2ZjJaSkdRZEdMYk94T09EWDBmIiwic2hvcF9pZCI6NjgxOTU4LCJ1c2VyX2lkIjoxMDc1Nzg5fQ.MNW7WR05yfWTNy-EMG1dOW2Zpkxh3dLQ60ipJ3blWJE',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;

    }

    

    public function productBookingToSteadFast(Request $request){ 
       
        
        $start_date=date("d-m-Y");
        $end_date=date("d-m-Y");
        if($request->filter=='filter'){
            $start_date=date("Y-m-d",strtotime($request->starting_date));
            $end_date=date("Y-m-d",strtotime($request->end_date));
            $data['orders'] = Order::where('courier_id', 29)
                                    ->where('status', 'Invoiced')
                                    ->where('orderDate', '>=', $start_date)
                                    ->where('orderDate', '<=', $end_date)
                                    ->orderBy('id', 'desc')
                                    ->get();

        } else if($request->booking=='booking')   {
            $start_date=date("Y-m-d",strtotime($request->starting_date));
            $end_date=date("Y-m-d",strtotime($request->end_date));

            $data['orders'] = Order::where('courier_id', 29)
                                    ->where('status', 'Delivered')
                                    ->where('courier_booking_date', '>=', $start_date)
                                    ->where('courier_booking_date', '<=', $end_date)
                                    ->orderBy('id', 'desc')
                                    ->get();

        } else{

            $data['orders'] =Order::where('courier_id', 29)
                                ->whereNull('order_tracking_id')
                                ->where('status', 'Invoiced')
                                ->orderBy('id', 'desc')
                                ->get();
        }
        $data['start_date']= $start_date;
        $data['end_date']= $end_date;

        return view('admin.booking.steadFast_booking', $data);
    }
    
    public function sendProductToSteaddFast(Request $request){

                    $booking_orderids=[];
                    $order_ids=$request->order_id;
                    $total_data=0;
                    $success=0;
                    $fail=0;
                    foreach($order_ids as $key=>$order_id){
                        ++$total_data;
                    
                        $order_row=DB::table('orders')
                        ->join('customers','orders.id','=','customers.order_id')
                        ->where('orders.id',$order_id)->first();
                        //echo $order_row->order_id;
                        
                        
                $url = "https://portal.steadfast.com.bd/api/v1/create_order";
                $token = "generated token code";
                $Api_Key = "7tapyt41s8pybrc1va6qxf63zu2xg4zb";
                $Secret_Key ="ixesbjdjz1xoygzdxvaynwcp";

                $postData = array(
                    "invoice" => $order_row->invoiceID,
                    "recipient_name" =>"$order_row->customerName",
                    "recipient_phone" =>"$order_row->customerPhone",
                    "recipient_address" =>"$order_row->customerAddress",
                    "note"=>"",
                    "cod_amount" =>$order_row->subTotal
                );

                // for sending data as json type
                $fields = json_encode($postData);


                $ch = curl_init($url);
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'Api-Key:'.$Api_Key,
                        'Secret-Key:'.$Secret_Key
                ));
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

                $result = curl_exec($ch);
                curl_close($ch);
                $fianl_data= json_decode($result);

                if($fianl_data->status==200){
                    $booking_orderids[]=$order_id;
                    ++$success;
                $tracking_id= $fianl_data->consignment->consignment_id;
                        $update_order_data['status']="Delivered";
                        $update_order_data['order_tracking_id']=$tracking_id;
                        $update_order_data['courier_booking_date']=date("Y-m-d");
                     DB::table('orders')->where('id',$order_id)->update($update_order_data);                
                }else{
                    ++$fail;                    
                }
                }
                    
                    $final_order_ids = $booking_orderids;
                    $data['success_order_ids']=$final_order_ids;
                    $data['message']="Total Selected =".$total_data." Succesfully Booking=".$success." Failed Booking=".$fail;
                    echo json_encode($data);
  }
         

  public function productBookingToPatho(Request $request){ 
       
        
            $start_date=date("d-m-Y");
            $end_date=date("d-m-Y");
            if($request->filter=='filter'){
                $start_date=date("Y-m-d",strtotime($request->starting_date));
                $end_date=date("Y-m-d",strtotime($request->end_date));
                $data['orders'] = Order::where('courier_id', 30)
                                        ->where('status', 'Invoiced')
                                        ->where('orderDate', '>=', $start_date)
                                        ->where('orderDate', '<=', $end_date)
                                        ->orderBy('id', 'desc')
                                        ->get();
    
            } else if($request->booking=='booking')   {
                $start_date=date("Y-m-d",strtotime($request->starting_date));
                $end_date=date("Y-m-d",strtotime($request->end_date));
    
                $data['orders'] = Order::where('courier_id', 30)
                                        ->where('status', 'Delivered')
                                        ->where('courier_booking_date', '>=', $start_date)
                                        ->where('courier_booking_date', '<=', $end_date)
                                        ->orderBy('id', 'desc')
                                        ->get();
    
            } else{
    
                $data['orders'] =Order::where('courier_id', 30)
                                    ->whereNull('order_tracking_id')
                                    ->where('status', 'Invoiced')
                                    ->orderBy('id', 'desc')
                                    ->get();
            }
            $data['start_date']= $start_date;
            $data['end_date']= $end_date;
    
            return view('admin.booking.patao_booking', $data);
        }
        
        public function sendProductToPatho(Request $request){
    
                        $booking_orderids=[];
                        $order_ids=$request->order_id;
                        $total_data=0;
                        $success=0;
                        $fail=0;
                        foreach($order_ids as $key=>$order_id){
                            ++$total_data;
                        
                            $order_row=DB::table('orders')
                            ->join('customers','orders.id','=','customers.order_id')
                            ->where('orders.id',$order_id)->first();
                            //echo $order_row->order_id;
                            
                           
                    $url = "https://api-hermes.pathao.com/aladdin/api/v1/orders";
                  
                    $api_key ="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImM1MDcxNjY4ZDkyYzcyYzhiMGE3YWRjZmY5Y2QwYzhhOTI0NjMwNTA3OTk3YTA5YjljYzNhNzcxZDVjY2I1NWEzODNkNjNlYzg1NmUyNDliIn0.eyJhdWQiOiIyMDkwIiwianRpIjoiYzUwNzE2NjhkOTJjNzJjOGIwYTdhZGNmZjljZDBjOGE5MjQ2MzA1MDc5OTdhMDliOWNjM2E3NzFkNWNjYjU1YTM4M2Q2M2VjODU2ZTI0OWIiLCJpYXQiOjE2ODQ0MTU2MzAsIm5iZiI6MTY4NDQxNTYzMCwiZXhwIjoxNjkyMTkxNjMwLCJzdWIiOiIxMjAwOTIiLCJzY29wZXMiOltdfQ.Hl69o8hKotNOWeH0M_vetr3RHgJJb9nDNbFM5FZdjr-iBOzQPbtbKGdH4Yw9wofJK3JPHhOP55QDReO1v2ddACpT6c_qAYD847hCHKN4gjac4CwOheTRhNhpmIw_K_5wiUahLy6uW-MnrE4Kn948kHlWD_VAhcdtDxFwi92Y1fvHDssMfvlsv7faAE-hliFkQ_XAO1kLIL-qAE4EqpUBMVIGdOMM20qeUlU424-TZ4I_Mv3n58rHzrYtdjd8VyDAdchOsROg1TML5_J0ViIFtMhnXCYHgawMg-cH0qrS70lAt_Uj3JHUt8dhLFJ3v4xNgPtnpzLj1spyHMtU3W711e8IybjF1DepBlNGjELVoLCcrYvYde1Qbh40OMAHwsk1IvK730dfDuufvzeHvnJBzJW0EFk32CzsM_npx4txKwFBggevfiv_pjS0esPiDdbrhqrHDMoc9k7iuJ5fzwlanP6ZvJx4vYSNewY7KDbnarDIF6jIGBxrMr_uu1oBUl3ftl3ilZscqZTpzPn4jFFGyqw3iZTxFa8XhYkVRXcO_GbWnPKhixvNxe6RC3ruDru8UMV0OZY2_pq56bi1E6PljFFzspLkNVGg029vffu_FX4GJRR3WG-gNQB1G3oZiikOGOK4HPgul_aqzZ_8Q7_BF0OnH2ZJuqvShWL6JoU3XbY";

                 
                    $name=$order_row->customerName;
                    $phone=$order_row->customerPhone;
                    $delivery_area=$order_row->customerAddress;
                    $quanity=1;
                    $special_instruction="";
                    $item_type="";
                    if($order_row->area_id > 0){
                        $order_area=$order_row->area_id;
                    } else{
                    $order_area='';  
                        }
        

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL =>  $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{
                        "store_id":"101581",
                        "merchant_order_id": "'.$order_row->invoiceID.'",
                        "recipient_name":"'.$name.'",
                        "recipient_phone": "'.$phone.'",
                        "recipient_address":"'.$delivery_area.'",
                        "recipient_city": '.$order_row->city_id.',
                        "recipient_zone": '.$order_row->zone_id.',
                        "recipient_area":'.$order_area.',
                        "delivery_type":48 ,
                        "item_type":2,
                        "special_instruction":"",
                        "item_quantity": 1,
                        "item_weight":"0.001",
                        "amount_to_collect":'.$order_row->subTotal.',
                        "item_description": ""
                        }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Accept: application/json',
                        'Authorization:Bearer '.$api_key.''),
                ));

  $response = curl_exec($curl);
   curl_close($curl);
  $response=json_decode($response); 
  
  if($response->type=="success" && $response->code==200){    
                        $booking_orderids[]=$order_id;
                        ++$success;
                       $tracking_id= $response->data->consignment_id;
                            $update_order_data['status']="Delivered";
                          $update_order_data['order_tracking_id']=$tracking_id;
                            $update_order_data['courier_booking_date']=date("Y-m-d");
                         DB::table('orders')->where('id',$order_id)->update($update_order_data);                
                    }else{
                        ++$fail;                    
                    }
                    }
                        
                        $final_order_ids = $booking_orderids;
                        $data['success_order_ids']=$final_order_ids;
                        $data['message']="Total Selected =".$total_data." Succesfully Booking=".$success." Failed Booking=".$fail;
                        echo json_encode($data);
        }             



}