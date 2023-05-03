
@extends('admin.master')
@section('main',"Order Status Report")
@section('active',"Order Status Report")
@section('title',"Order Status Report")
@section('main-content')
    <style>
        .img-responsive {
            float: left;
            border: 2px solid #ddd;
        }

        .product-title {
            width: 100%;
            display: block;
            height: 30px;
            overflow: hidden;
        }

    </style>


    <style> .status_active {
            background: #FE19B4 !important;
            border: none;
        }

        .order_status {
            width: 18.9%;
            background: #6A00A8;
            font-weight: bold;
            border: none;
            margin: 4px;
        }

        .btn .badge {
            position: relative;
            top: 2px;
            text-align: center;
            float: right;
            color: red;
        }

        @media (max-width: 776px) {
            .order_status {
                width: 48%;
                margin-bottom: 8px;
                background: #6a00a8;
                font-weight: bold;
                border: none;
                margin: 2px;
            }

            .btn .badge {
                position: relative;
                top: 2px;
                text-align: center;
                float: right;
                color: red;
            }
        } </style>
    <section class="content">
        <div class="container-fluid">

<form action="{{url('/')}}/admin/orderStatus/report"  method="get" >
    <div class="row" style="cursor: pointer;background: white;margin-bottom: 9px;border: 2px solid #ddd;">
                <div class="col-6 col-lg-3">

                    <div class="form-group"  >
                        <label>Order Status</label>
                        <select name="order_status" id="order_status" class="form-control ">
                            <option value="">------Select----------</option>
                            <option value="new">New</option>
                            <option value="pending_payment">Pending for Payment</option>
                            <option value="pending">Pending</option>
                            <option value="on_courier"> Courier</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancled">Cancelled</option>
                            <option value="ready_to_deliver">Pending Invoice</option>
                            <option value="invoice">Invoice</option>
                            <option value="booking">Booking</option>
                            <option value="return">Return</option>
                        </select>
                    </div>
                </div>


                <div class="col-6 col-lg-3">

                    <div class="form-group"  >
                        <div class="form-group"  >
                            <label>Starting Date </label>
                            <input type="date" id="starting_date" name="starting_date" value="{{date("Y-m-d",strtotime($start_date))}}" class="form-control">
                        </div>
                    </div>
                </div>


                <div class="col-6 col-lg-3">

                    <div class="form-group"  >
                        <label>Ending Date </label>
                        <input type="date" id="ending_date" name="ending_date" value="{{date("Y-m-d",strtotime($ending_date))}}" class="form-control">
                    </div>
                </div>
                <div class="col-6 col-lg-2">

<div class="form-group"  >
    <label>Order ID</label>
    <input type="text" id="order_id" placeholder="Order ID" name="order_id" value="" class="form-control">
</div>
</div>


                <div class="col-6 col-lg-1">
<br>
                    <div class="form-group" >
                       <input type="submit"  style="margin-top: 8px;" value="Search" class="form-control btn btn-success">
                    </div>
                </div>

                </div>
</form>

        </div>

        <?php

        $role_status = Auth::user()->role_id;
        if ($role_status != 3) {

        ?>


        <div class="row">
            <div class="col-sm-6 col-md-4">
                <button onClick="getTotalProducts(1)" type="button"
                        class="btn btn-success form-control "> Total Order <span class="badge badge-light">      {{TotalOnlineStaffOrderList($start_date,$ending_date)}}</span>
                </button>

            </div>
        <div class="col-sm-6 col-md-4">
            <button onClick="getTotalProducts(2)" type="button"
                    class="btn btn-info form-control "> Online Order <span class="badge badge-light">      {{onlineOrder($start_date,$ending_date)}}</span>
            </button>

        </div>
        <div class="col-sm-6 col-md-4">
            <button onClick="getTotalProducts(3)" type="button"
                    class="btn btn-primary form-control "> Staff Order <span class="badge badge-light">      {{StaffOrderList($start_date,$ending_date)}}</span>
            </button>
        </div>
            </div>

        <?php } ?>



        <div class="row">
        <div class="col-12 col-lg-12 col-xl-12">
            <button onClick="orderStatus('Processing')" type="button"
                    class="btn btn-primary order_status  ">Processing<span class="badge badge-light">      {{orderStatusReport('Processing',$start_date,$ending_date)}}</span>
            </button>
 

            <button onClick="orderStatus('Payment Pending')" type="button"
                    class="btn btn-primary order_status ">Payment Pending<span class="badge badge-light">   {{orderStatusReport('Payment Pending',$start_date,$ending_date)}}    </span>
            </button>
            <button onClick="orderStatus('Pending Invoiced')" type="button"
                    class="btn btn-primary order_status ">  Pending Invoiced  <span class="badge badge-light">   {{orderStatusReport('Pending Invoiced',$start_date,$ending_date)}}  </span>
            </button>
            <button onClick="orderStatus('On Hold')" type="button"
                    class="btn btn-primary order_status ">  On Hold  <span class="badge badge-light">  {{orderStatusReport('On Hold',$start_date,$ending_date)}} </span>
            </button>

            <button onClick="orderStatus('Invoiced')" type="button"
                    class="btn btn-primary order_status ">    Invoiced <span class="badge badge-light">    {{orderStatusReport('Invoiced',$start_date,$ending_date)}}  </span>
            </button>
 
            <button onClick="orderStatus('Delivered')" type="button"
                    class="btn btn-primary order_status ">  Delivered  <span class="badge badge-light">   {{orderStatusReport('Delivered',$start_date,$ending_date)}} </span>
            </button>
            <button onClick="orderStatus('Canceled')" type="button"
                    class="btn btn-primary order_status ">  Canceled  <span class="badge badge-light">  {{orderStatusReport('Canceled',$start_date,$ending_date)}} </span>
            </button>
            <button onClick="orderStatus('Completed')" type="button"
                    class="btn btn-primary order_status ">  Completed  <span class="badge badge-light">  {{orderStatusReport('Completed',$start_date,$ending_date)}} </span>
            </button>
         
        </div>
        </div>

        <table class="table table-bordered">

                <thead>
                <tr style="text-align:center">
                    <th width="10%"> Order ID </th>
                    <th width="10%"> Courier Information</th>
                    <th style="width: 9%;">
                        <span style="font-size: 15px;"> Office Staff</span>
                        <br/>
                    </th>
                    <th style="width:20%;text-align:left">Customer</th>
                    <th style="text-align:left">Products</th>
                    <th> Amount</th>
                    <th> Status</th>
                    <th> Action</th>
                </tr>
                </thead>
            <tbody id="tbody">
            @if($orderStatus !='')
            @foreach($orders as $order)
                    <?php
                    $order_track=DB::table('order_edit_track')->where('order_id',$order->order_id)->orderBy('id','desc')->value('updated_date');
                    $areaInfo = DB::table('area')->where('area_id', $order->area_id)->first();

                    ?>
            <tr>
                <td><span   class="badge badge-pill badge-danger" style="font-size:18px">  {{$order->order_id}}</span>
                    {{date('d-m-Y h:i a',strtotime($order->created_time))}}
                    @if($order->shipment_time)
                        <br/>
                        <span style="color:green">
                      Shipping Date
                            {{date('d-m-Y',strtotime($order->shipment_time))}}
                  </span>
                    @endif
                    @if($order->return_date)
                        <br/>
                        <span style="color:red">
                      Return Date
                            {{date('d-m-Y',strtotime($order->return_date))}}
                  </span>

                    @endif
                </td>
                <td>
                                            <span style="color:red;font-size: 17px;font-weight: bold">
                                                 {{$order->courier_service}}
                                            </span>
                    <br/>
                    @if($areaInfo)
                        <span style="color:green;font-size: 15px;font-weight: bold">
                                                 {{$areaInfo->area_name}}
                                            </span>
                    @endif
                    <br/>
                          <span style="color:red;font-size: 15px;font-weight: bold">
                                                Weight : {{$order->weight}}
                                            </span>
                    <br/>
                                              <span style="color:black;font-size: 15px;font-weight: bold">
                                                Invoice : {{$order->invoice_id}}
                                            </span>
                </td>


                <td style="text-align: center" >

                    <span   data-toggle="modal" data-target="#modal-edit" onclick="orderEdit({{$order->order_id}})" class="badge badge-pill badge-primary"> {{officeStaffName($order->staff_id)}}</span>
                    <span class="badge badge-pill badge-danger" >@if($order->order_area=='outside_dhaka')  Outside Dhaka   @else Inside Dhaka @endif</span>
                    <span class="badge badge-pill badge-danger" >{{$order->traking_id}}</span>

                </td>




                <td>
                    <span   class="badge badge-pill badge-info" style="font-size:18px">   {{$order->billing_name}}</span>
                    <br>
                    <span   class="badge badge-pill badge-success" style="font-size:18px">  {{$order->billing_mobile}}</span>
                    <br>
                    {{$order->shipping_address1}}
                    <br>
                    <span style="color:red;font-weight: 400">Note: {{$order->order_note}} </span>
                    @if($order_track)
                        <br>
                        <span class="badge badge-pill badge-success" style="font-size:15px">{{date("d-m-Y",strtotime($order_track))}}</span>
                        <span class="badge badge-pill badge-info" style="font-size:15px">{{date("h:i a",strtotime($order_track))}}</span>
                    @endif

                </td>
                <td>
                    <?php
                    $order_items = unserialize($order->products);
                    if(isset($order_items['items'])) {
                    foreach ($order_items['items'] as $product_id => $item) {
                    $featured_image = isset($item['featured_image']) ? $item['featured_image'] : null;
                     $sku=DB::table('product')->where('product_id',$product_id)->value('sku');
                    ?>
                    <span class="product-title"><?=($item['name'])?></span>
                    <img  class="img-responsive"  width="50" src="<?=$featured_image?>" />
                    <p> {{$item['price']}}
                        <i class="fal fa-times"></i>
                        <?=($item['qty'])?>= {{$item['subtotal']}}
                    </p>
                     <p  style="color:red;font-weight:bold;position: absolute;margin-top: 8px;">Code :{{$sku}}</p>

                    <br>
                    <?php }
                    }
                    ?>
                </td>

                <td>
                    {{$order->order_total}}

                </td>

                <td>
                    <?php if($order->order_status=='pending_payment'){
                    ?>
                    <span   class="badge badge-pill badge-info" style="background-color:#ffad55;color: black;border: none;" >Payment Pending</span>
                    <?php  } elseif ($order->order_status=='new') { ?>
                    <span   class="badge badge-pill badge-info">{{ $order->order_status }}</span>
                    <?php  } elseif ($order->order_status=='invoice') { ?>
                    <span   class="badge badge-pill badge-info">Invoice</span>
                    <?php  } elseif ($order->order_status=='on_courier') { ?>
                    <span   class="badge badge-pill badge-danger">{{ $order->order_status }}</span>
                    <?php  } elseif ($order->order_status=='delivered') { ?>
                    <span   class="badge badge-pill badge-success">{{ $order->order_status }}</span>
                    <?php  } elseif ($order->order_status=='refund') { ?>
                    <span   class="badge badge-pill badge-danger">{{ $order->order_status }}</span>
                    <?php  } elseif ($order->order_status=='cancled') { ?>
                    <span   class="badge badge-pill badge-danger">{{ $order->order_status }}</span>
                    <?php  } elseif ($order->order_status=='phone_pending') { ?>
                    <span    class="badge badge-pill badge-info" style="background-color:#ffad55;color: black;border: none;" >Phone Pending </span>
                    <?php  } elseif ($order->order_status=='failed') { ?>
                    <span    class="badge badge-pill badge-danger"  >Failded Delevery </span>
                    <?php  } elseif ($order->order_status=='return') { ?>
                    <span    class="badge badge-pill badge-danger"  >Return</span>
                    <?php  } else {  ?>
                    <span   class="badge badge-pill badge-success">Pending Invoice</span>
                    <?php } ?>
                    <br>
                </td>
                <td>
                    <a title="edit"   href="{{ url('admin/order') }}/{{ $order->order_id }}/edit" class=" btn btn-success btn-sm">
                        <i class="fa fa-pencil"></i>
                    </a>

                    @if(($order->order_status=='ready_to_deliver') && ($order->order_print_status !=1))

                        <a title="print"  class="btn btn-info btn-sm" target="_blank" href="{{url('/')}}/admin/single_order_invoice/{{ $order->order_id }}?name={{ Session::get('name') }}">

                            <i class="fa fa-print "></i>
                        </a>
                    @endif


                </td>




            </tr>
        @endforeach
                @endif
            </tbody>

                </table>


        </div>
    </section>

    </div>

    <script>
        $("#order_status").val("{{$orderStatus}}");
        function getTotalProducts(status){
           var ending_date= $("#ending_date").val();
           var starting_date= $("#starting_date").val();

            $.ajax({
                type: "GET",
                url: "{{url('admin/order/getTotalProductsReport')}}?status=" + status+"&starting_date="+starting_date+"&ending_date="+ending_date,
                success: function (data) {
                    console.log(data)
                    $('#tbody').html('');
                    $('#tbody').html(data);
                }
            })
        }
    </script>




@endsection