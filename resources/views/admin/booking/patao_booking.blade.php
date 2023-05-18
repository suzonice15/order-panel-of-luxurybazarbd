@extends('admin.master')
@section('main',"Pathao Booking")
@section('active',"Pathao Booking")
@section('title',"Pathao Booking")
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
    <section class="content">
    <div class="container" style="background:#fff;margin-bottom: 9px;">
       <form action="{{url('/')}}/admin/productBookingToPatho" method="get" >
        <div class="row">
            <div class="col-6 col-lg-3">
                <div class="form-group"  >
                    <div class="form-group"  >
                        <label>Starting Date </label>
                        <input  required type="date" id="starting_date" name="starting_date"
                                value="@if(isset($start_date)){{date("Y-m-d",strtotime($start_date))}}@endif"
                                class="form-control">
                    </div>
                </div>
            </div>


            <div class="col-6 col-lg-3">
                <div class="form-group"  >
                    <div class="form-group"  >
                        <label>Starting Date </label>
                        <input  required type="date" id="starting_date" name="end_date"
                                value="@if(isset($end_date)){{date("Y-m-d",strtotime($end_date))}}@endif"
                                class="form-control">
                    </div>
                </div>

            </div>
            <div class="col-6 col-lg-3" style="margin-top:12px">
                <br/>
                <button type="submit"
                        class="btn btn-info btn-sm" name="filter" value="filter">
                    <i class="fas fa-search"></i> Filter
                </button>
                <button type="submit"
                        class="btn btn-success btn-sm" name="booking" value="booking">
                    <i class="fas fa-search"></i> Booking Search
                </button> 
            </div> 
        </div>
       </form>
        </div>

        <div class='container-fluid'> 
        <div class="row" style="cursor: pointer;">
        <div class="col-md-12 col-lg-12"> 
         
            <div class="card mt-1">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                          <h5>Total <span id="status_set" style="color:green;font-weight:bold"></span><span style="color: red;font-size: 18px;font-weight: bold;padding: 2px;" id="total_count">{{count($orders)}}</span> Orders </h5>
                        </div> 
                        <div class="col-md-8">
                        <button type="button"
                                class="btn btn-danger btn-sm" style="float:right" id="send">
                            <i class="fas fa-arrow-circle-right"></i> Send Product To Courier
                        </button>
                            </div>

                    </div>
                    
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-bordered " style="width:100%">
                        <thead>
                        <tr style="text-align:center">
                        <th> 

                        @if(Auth::user()->role_id !=3)
                                    <input type="checkbox"  style="width: 29px;height: 25px;" name="all_select" id="checkAll"/>
                      @else 
                      SL
                    @endif
                        </th>
                            <th class='text-center'>
                           Invoice ID
                         
                            </th>
                            <th style="width:15%;text-align:left">
                           Customers
                            </th> 
                            <th>Products</th>
                            <th>Total</th>
                            <th>
                              Courier
                              </th> 
                              <th>
                                Order Date
                              </th>
                                                         
                             <th>                           
                             Staff                              
                            </th>                             
                            <th width="10%">                              
                            Action </th>

                        </tr>
                        </thead>
                        <tbody>
                        @include('admin.booking.booking_pagination')
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        </div>
        </div>
        <!-- /.card -->

    </section>

  
   


    <script>
        
        $("#send").click(function () {

            var order_id = new Array();
             $('.checkAll').each(function () {
                if ($(this).is(":checked")) {
                    order_id.push(this.value);
                }
            });
            if (order_id.length > 0) {
                $("#send").prop("disabled",true);
                $("#send").text("Please Wait.....");
                $.ajax({
                    url: '{{url('/')}}/admin/productBookingToPatho',
                    data: {
                        order_id: order_id,
                        "_token": "{{csrf_token()}}"
                    },
                    method: 'post',
                    success: function (data) {
                      
                        $("#send").text("Successfully done !");
                        location.reload();
                    },
                    error:function(data){
                        $("#send").prop("disabled",false);
                        $("#send").text("Please Fill Up All Courier Information");
                    }
                });
            } else {
                alert("Please select Product To Send To Courier")
            }
        });


        //$('#checkAll').change(function () {
        $(document).on("change", "#checkAll", function (event) {

            if ($(this).is(":checked")) {

                $('.checkAll').prop('checked', true);

            } else if ($(this).is(":not(:checked)")) {

                $('.checkAll').prop('checked', false);

            }

            var order_id = new Array();
            $('.checkAll').each(function () {
                if ($(this).is(":checked")) {
                    order_id.push(this.value);
                }
            });
            if(order_id.length > 0){
                $("#count_total").text(order_id.length +" items selected");
            }else{
                $("#count_total").text("");
            }


        });

        $(".checkAll").change(function(){
            var order_id = new Array();
            $('.checkAll').each(function () {
                if ($(this).is(":checked")) {
                    order_id.push(this.value);
                }
            });
            if(order_id.length > 0){
                $("#count_total").text(order_id.length +" items selected");
            }else{
                $("#count_total").text("");
            }


        })
 


    </script>



@endsection