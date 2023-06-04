
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
                        {{getAllOrderStatusForOrderIndex("all",2)}}
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

            <button onClick="orderStatus('Stock Out')" type="button"
                    class="btn btn-primary order_status "> Stock Out  <span class="badge badge-light">  {{orderStatusReport('Stock Out',$start_date,$ending_date)}} </span>
            </button>

            <button onClick="orderStatus('Request to Return')" type="button"
                    class="btn btn-primary order_status "> Request to Return <span class="badge badge-light">  {{orderStatusReport('Request to Return',$start_date,$ending_date)}} </span>
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
                        <th> 
  
                      SL
                    
                        </th>
                            <th class='text-center'>
                           Invoice ID
                         
                            </th>
                            <th style="width:15%;text-align:left">
                           Customers
                            </th> 
                            <th style="width:150px">Products</th>
                            <th>Total</th>
                            <th>
                              Courier
                              </th> 
                              <th style="width:250px">
                                Order Date
                              </th>
                              <th  style="width:150px" >
                                 Status
                              </th>                              
                             <th>                           
                             Staff                              
                            </th>                             
                            <th width="5%">                              
                            Action </th>

                        </tr>
                        </thead>
            <tbody id="tbody">
            @if($orderStatus !='') 

            @include('admin.order.orderStatusReport_pagination')
            @endif
 
            </tbody>

                </table>


        </div>
    </section>

    </div>

    <script>
        $("#convert_order_status").val("{{$orderStatus}}");
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