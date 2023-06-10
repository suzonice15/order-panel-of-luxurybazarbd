<?php
$store_id =isset($order->store_id) ? $order->store_id:1;
$courier_id =isset($order->courier_id) ? $order->courier_id:'';
$city_id =isset($order->city_id) ? $order->city_id:'';
$zone_id =isset($order->zone_id) ? $order->zone_id:'';
$area_id =isset($order->area_id) ? $order->area_id:'';
$orderDate =isset($order->orderDate) ? $order->orderDate:date("Y-m-d H:i:s");
$invoiceID =isset($order->invoiceID) ? $order->invoiceID:$invoice_id;
$billing_name =isset($order->customer) ? optional($order->customer)->customerName:"";
$billing_mobile =isset($order->customer) ? optional($order->customer)->customerPhone:"";
$shipping_address1 =isset($order->customer) ? optional($order->customer)->customerAddress :"";
$order_area =isset($order->order_area) ? $order->order_area:'';
$order_status =isset($order->status) ? $order->status:'Processing';
$shipment_time =isset($order->orderDate) ? $order->orderDate:date("Y-m-d");
?>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Customer Information </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="from-group col-6">
                    <label> Store Name </label>
                    <select required name="store_id" id="store_id" class="form-control select2">
                        <option value="">---Select Option---</option>
                        @foreach($stores as $store)
                        <option @if($store_id==$store->id) selected @endif value="{{$store->id}}">{{$store->storeName}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="from-group col-6">
                    {{FormInput("Invoice Number ","invoiceID","required",$invoiceID,'','')}}
                    <input type="hidden" name="orderDate" value="{{$orderDate}}" />
                </div>
            </div>
            <div class="row">
                {{FormInput("Customer Name","customerName","required",$billing_name,'','','col-6')}}
                {{FormInput("Customer Mobile","customerPhone","required",$billing_mobile,'','','col-6')}}
            </div>
            <div class="form-group">
                {{FormTextarea("Customer Address","customerAddress","required",$shipping_address1,'')}}
            </div>

            <div class="row">
                
                <div class="col-6">
                    <div class="form-group">
                        <label>Order Status</label>
                        {{getAllOrderStatusForOrderIndex($order_status)}}
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group ">
                        <label>Order Date</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                            </div>
                            <input type="date" name="deliveryDate" class="form-control pull-right"
                                   value="{{date("Y-m-d",strtotime($shipment_time))}}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="from-group">
                        <label>  Courier Name   </label>
                        <select required onchange="getCityByCourierId(this.value)" id="courier_id" name="courier_id" class="form-control select2">
                            <option value="">---Select Option---</option>
                            @foreach($couriers as $courier)
                                <option @if($courier_id==$courier->id) selected @endif value="{{$courier->id}}">{{$courier->courierName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12 col-12 city_id">
                    <div class="from-group">
                        <label> City Name  </label>
                        <select onchange="getZoneByCityId(this.value)" style="width:100%" name="city_id" id="city_id" class="form-control select2">
                            <option value="">---Select Courier---</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 col-12 zone_id">
                    <div class="from-group">
                        <label> Zone Name </label>
                        <select name="zone_id" id="zone_id" style="width:100%" class="form-control select2">
                            <option value="">---Select Option---</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12 col-12 area_id">
                    <div class="from-group">
                        <label> Area Name </label>
                        <select name="area_id" id="area_id"  style="width:100%" class="form-control select2">
                            <option value="">---Select Option---</option>
                        </select>
                    </div>
                </div>

            </div>


        </div>
    </div>


<script>
          @if($courier_id > 0)
      getCityByCourierId({{ $courier_id }})
            @endif

    @if($city_id > 0)
         getZoneByCityId({{ $city_id }})
    @endif

    @if($zone_id > 0)
    getAreaByZoneId({{ $zone_id }})
    @endif

    

   function getCityByCourierId(courier_id){
    //  if(courier_id==29)   
    hideCourierAddress()
     
       $.ajax({
           url:"{{url('/')}}/admin/getCityByCourierId?courier_id="+courier_id,
           success:function (data){
            if(courier_id==30){
                $('#city_id').html(data);
                 $('#city_id').val(<?=$city_id?>);
                 $('#area_id').html("");
            }else if(courier_id==24){
                $('#area_id').html(data);
                $('#area_id').val(<?=$area_id?>);
                $('#city_id').html("");
            }else{
                $('#city_id').html(""); 
                $('#area_id').html("");               
            }
               
           }
       })
   }
   
   function getZoneByCityId(id){
    let courier_id=$("#courier_id").val();
       $.ajax({
           url:"{{url('/')}}/admin/getZoneByCityId?city_id="+id+"&courier_id="+courier_id,
           success:function (data){
               $('#zone_id').html(data);
               $('#zone_id').val(<?=$zone_id?>);
           }
       })
   }

   function getAreaByZoneId(id){
    let courier_id=$("#courier_id").val();
       $.ajax({
           url:"{{url('/')}}/admin/getAreaByZoneId?zone_id="+id+"&courier_id="+courier_id,
           success:function (data){
               $('#area_id').html(data);
               $('#area_id').val(<?=$area_id?>);
           }
       })
   }

   $("#zone_id").change(function(){
   let zone_id=$(this).val()
   getAreaByZoneId(zone_id);

   })

   hideCourierAddress()

   function hideCourierAddress(){
           
    let courier_id=$("#courier_id").val();
    if(courier_id==24){ // redex
        $('.city_id').hide();
        $('.zone_id').hide();
        $('.area_id').show(""); 
        $('#area_id').prop("required",true);

        $('#zone_id').val("");
        $('#city_id').val("");
    }else if(courier_id==30){ // patao

        $('#zone_id').prop("required",true);
        $('#city_id').prop("required",true);
        $('#area_id').prop("required",true);

        $('.city_id').show();
        $('.zone_id').show();
        $('.area_id').show("");        
    }else{
        
        $('.city_id').hide();
        $('.zone_id').hide();
        $('.area_id').hide("");  
        $('#zone_id').val("");
        $('#city_id').val("");   
        $('#area_id').val(""); 
        $('#zone_id').prop("required",false);
        $('#city_id').prop("required",false);
        $('#area_id').prop("required",false);  
    }

   }

   $("#order_status").change(function(){

   let order_status=  $(this).val()
    if(order_status=="Canceled"){
        $('#courier_id').prop("required",false);
    }else{
        $('#courier_id').prop("required",true);
    }

   })
</script>