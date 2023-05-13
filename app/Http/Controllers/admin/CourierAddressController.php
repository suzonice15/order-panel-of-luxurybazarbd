<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use  Session;
use Image;
use AdminHelper;
use URL;
use Illuminate\Support\Facades\Redirect;

class CourierAddressController extends Controller
{
     public function getZone(Request $request)
    {
        
       $zones= DB::table('courier_zone')->select('zone_name','zone_id')->where('courier_id',1)->where('city_id',$request->city_id)->get();
        $htmls='<select onchange="getArea(this.value)" required  name="zone_id" id="zone_id" class="form-control select2">
        <option value="">Select Option </option>';
        foreach($zones as $zone){
            $htmls .='<option value="'.$zone->zone_id.'">'.$zone->zone_name.'</option>'; 
        }
        $htmls .='</select>';
        echo $htmls;
    } 

    public function getArea(Request $request)
    { 
       $areas= DB::table('courier_area')->select('area_name','area_id')->where('courier_id',1)->where('zone_id',$request->zone_id)->get();
        $htmls='<select  required  name="area_id" id="area_id" class="form-control select2">
        <option value="">Select Option </option>';
        foreach($areas as $area){
            $htmls .='<option value="'.$area->area_id.'">'.$area->area_name.'</option>'; 
        }
        $htmls .='</select>';
        echo $htmls;
    } 

    public function sendProductToPathao(){
        $data['main'] = 'Pathao Courier';
        $data['active'] = 'Pathao Courier';
        $data['orders']=DB::table('order_data')
                            ->where('order_status','invoice')
                            ->where('zone_id', '>',0)
                            ->whereIn('courier_service',[19,20])
                            ->get();

        return view('admin.courier.sendProductToPathao', $data);
    }

    

    public function orderEntryToPathao(Request $request){  

            // post method : for creating patao api access token   
            // https://api-hermes.pathao.com/aladdin/api/v1/issue-token
            // {
            //     "client_id":"1206",
            //     "client_secret": "eA1vpLVtNEmrngBuFEJ3e3mEA2qxMgL699gmy7Rx",
            //     "username":"jibonpatait.ltd@gmail.com",
            //     "password":"SB@2021#",
            //     "grant_type":"password"
            // }

            $api_key=get_option('patao_token_key');

  
          $orders_ids=$request->order_ids;
          $orders=DB::table('order_data')->whereIn('order_id',$orders_ids)->where('order_status','invoice')->get();

          $total=0;
          $total_success=0;
          $total_failed=0;
         
         foreach($orders as $order) { 
            $total++;

            $name=$order->customer_name;
            $phone=$order->customer_phone;
            $delivery_area=$order->customer_address.''.getPataoAddress($order->city_id,$order->zone_id,$order->area_id);
            $quanity=1;
            $special_instruction="";
            $item_type="";
            if($order->zone_id > 0){
                $order_area=$order->zone_id;
            } else{
              $order_area='';  
          }
        

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api-hermes.pathao.com/aladdin/api/v1/orders',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{
                        "store_id":28049,
                        "merchant_order_id": '.$order->order_id.',
                        "recipient_name":"'.$name.'",
                        "recipient_phone": "'.$phone.'",
                        "recipient_address":"'.$delivery_area.'",
                        "recipient_city": '.$order->city_id.',
                        "recipient_zone": '.$order->zone_id.',
                        "recipient_area":'.$order_area.',
                        "delivery_type":48 ,
                        "item_type":2,
                        "special_instruction":"",
                        "item_quantity": 1,
                        "item_weight":"0.001",
                        "amount_to_collect":'.$order->order_total.',
                        "item_description": ""
                        }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Accept: application/json',
                        'Authorization: Bearer '.$api_key.''),
                ));

  $response = curl_exec($curl);
  curl_close($curl);
  $response=json_decode($response); 
  if($response->type=="success" && $response->code==200){    
    $total_success++ ;     
    DB::table('order_data')->where('order_id',$order->order_id)->update(['order_status'=>'on_courier']);
  }else{
    $total_failed++;
  }

}
echo "Total selected order for booking :".$total. ". Total success to booking ".$total_success.". Total Failed to booking ".$total_failed.'.';

    }


    public function sendProductToWinx(){

        $data['main'] = 'Winx Courier';
        $data['active'] = 'Winx Courier';
        $data['orders']=DB::table('order_data')
                            ->where('order_status','invoice')
                            ->where('area_id', '>',0)
                            ->whereIn('courier_service',[22])
                            ->get();

        return view('admin.courier.sendProductToWinx', $data);
    }

    
    public function orderEntryToWinx(Request $request){  

        $api_key=get_option('winx_api_key');

      $orders_ids=$request->order_ids;
      $orders=DB::table('order_data')->whereIn('order_id',$orders_ids)->where('order_status','invoice')->get();

      $total=0;
      $total_success=0;
      $total_failed=0;
     
     foreach($orders as $order) { 
        $total++;

        $name=$order->customer_name;
        $phone=$order->customer_phone;
        $delivery_area=$order->customer_address;
        $quanity=1; 
        
          $order_area=$order->area_id;
     
    $total=round($order->order_total);


          $client = new \GuzzleHttp\Client();
$response = $client->post(
    'https://winx.com.bd/api/parcel',
    [
        'headers' => [
            'Authorization' => 'Bearer '.$api_key.'',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pickup_id' => 843,
            'name' => ''.$name.'',
            'mobile' => ''.$phone.'',
            'address' => ''.$delivery_area.'',
            'package' => 1,
            'delivery_area' => $order_area,
            'sale_price' => $total,
            'cod' => $total,
            'insurance' => 'Yes',
            'merchant_invoice' => $order->order_id,
        ],
    ]
);
$body = $response->getBody(); 

if($body){    
$total_success++ ;     
DB::table('order_data')->where('order_id',$order->order_id)->update(['order_status'=>'on_courier']);
}else{
$total_failed++;
}

}
echo "Total selected order for booking :".$total. ". Total success to booking ".$total_success.". Total Failed to booking ".$total_failed.'.';

}

    public function city(){ 
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-hermes.pathao.com/aladdin/api/v1/countries/1/city-list',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET', 
        ));        
        $response = curl_exec($curl);
       $data= json_decode($response);
       foreach($data->data->data as $city){ 
            $data_array['courier_id']=1; //for //pathao
            $data_array['city_id']=$city->city_id;
            $data_array['city_name']=$city->city_name;
           // $data[]= $data_array; 
            DB::table('courier_city')->insert($data_array);
       } 
    }

    public function zone(){ 
      
     $city=  DB::table('courier_city')->get();
       foreach( $city as $row_city){ 
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-hermes.pathao.com/aladdin/api/v1/cities/'.$row_city->city_id.'/zone-list',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET', 
        ));
        
        $response = curl_exec($curl);
       $data= json_decode($response);

       foreach($data->data->data as $zone){ 
            $data_array['courier_id']=1; //for //pathao
            $data_array['city_id']=$row_city->city_id; 
            $data_array['zone_id']=$zone->zone_id;
            $data_array['zone_name']=$zone->zone_name; 
            DB::table('courier_zone')->insert($data_array);
       } 
    }

}


public function area(){ 

    ini_set('max_execution_time', 1800000000);
    $city=  DB::table('courier_city')->orderBy('city_id','asc')->get();
      foreach( $city as $row_city){ 
       $curl = curl_init();

     $zone_list=  DB::table('courier_zone')->where('courier_id',1)->where('city_id',$row_city->city_id)->orderBy('zone_id','asc')->get();
     foreach($zone_list as $zoneRow){

       curl_setopt_array($curl, array(
           CURLOPT_URL => 'https://api-hermes.pathao.com/aladdin/api/v1/zones/'.$zoneRow->zone_id.'/area-list',
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => '',
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => 'GET', 
           
       ));
       
       $response = curl_exec($curl);
      $data= json_decode($response);
      $row_data=array();
      foreach($data->data->data as $areaRow){ 
           $data_array['courier_id']=1; //for //pathao
           $data_array['city_id']=$row_city->city_id; 
           $data_array['zone_id']=$zoneRow->zone_id;
           $data_array['area_id']=$areaRow->area_id; 
           $data_array['area_name']=$areaRow->area_name;  
           DB::table('courier_area')->insert($data_array);
          
      } 

         
   }
   

}

}

public function accessPataoApi(){
    $post = [
        'client_id' => 1206,
        'client_secret' => 'eA1vpLVtNEmrngBuFEJ3e3mEA2qxMgL699gmy7Rx',
        'username' => 'jibonpatait.ltd@gmail.com',
        'password' => 'SB@2021#', 
        'grant_type' =>'password', 
    ];
    
    $ch = curl_init('https://api-hermes.pathao.com/aladdin/api/v1/issue-token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    
    // execute!
    $response = json_decode(curl_exec($ch));
    
    // close the connection, release resources used
    curl_close($ch);
    
    // do anything you want with your response
    // var_dump($response->access_token);
    echo $response->access_token;
 }

public function winxArea(){ 
     $api_key=get_option('winx_api_key');
 

    ini_set('max_execution_time', 1800000000);
   
    $curl = curl_init();
       curl_setopt_array($curl, array(
           CURLOPT_URL => 'https://winx.com.bd/api/location/select?full=yes',
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => '',
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => 'GET',
           CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer '.$api_key.'')));
       
       $response = curl_exec($curl);
      $data= json_decode($response); 
      $row_data=array();
     
      foreach($data->results as $areaRow){ 
        
           $data_array['courier_id']=19; //for // winx
           $data_array['area_id']=$areaRow->id; 
           $data_array['division']=$areaRow->division; 
           $data_array['district']=$areaRow->district;
           $data_array['thana']=$areaRow->thana; 
           $data_array['suboffice']=$areaRow->suboffice;  
           $data_array['postcode']=$areaRow->postcode;  
           $data_array['text']=$areaRow->text;  
           $data_array['created_at']=date("Y-m-d");  
         $row_data[]=$data_array;
      } 
      DB::table('winx_courier_area')->insert($row_data); 
         
   }  

}
