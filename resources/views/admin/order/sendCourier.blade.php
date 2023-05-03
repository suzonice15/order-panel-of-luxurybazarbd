@extends('admin.master')
@section('main',"Send Products to Courier")
@section('active',"Send Products to Courier")
@section('title',"Send Products to Courier")

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
        <div class="container-fluid" style="background:#fff;margin-bottom: 9px;">
       <form action="{{url('/')}}/admin/order/sendCourier" method="get" >
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
            <div class="col-6 col-lg-3" style="margin-top:12px">
                <br/>
                <input type="text" name="order_id_search" id="order_id_search" class="form-control" placeholder="Enter Order ID" />

            </div>



        </div>
       </form>
        </div>
        <div class="row">

            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <span style="color:red;font-weight: bold;font-size:18px" id="count_total"></span>
                        <button type="button"
                                class="btn btn-danger btn-sm" style="float:right" id="exchange_send_now">
                            <i class="fas fa-arrow-circle-right"></i> Send Product To Courier
                        </button>

                    </div>

                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr style="text-align:center">
                                <td>
                                    All
                                      <input type="checkbox" name="all_select" id="checkAll"/>

                                </td>

                                <th> Courier Information </th>
                                <th width="10%">
                                    Order ID
                                </th>
                                <th style="width: 9%;">
                                    <span style="font-size: 15px;"> Office Staff</span>
                                    <br/>

                                </th>
                                <th style="width:20%;text-align:left">Customer</th>
                                <th style="text-align:left">Products</th>
                                <th> Amount</th>


                            </tr>
                            </thead>
                            <tbody>
                          @include('admin.order.sendCourierComponent')
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

    </section>




    <script>
        $("#exchange_send_now").click(function () {

            var order_id = new Array();
             $('.checkAll').each(function () {
                if ($(this).is(":checked")) {
                    order_id.push(this.value);
                }
            });
            if (order_id.length > 0) {
                $("#exchange_send_now").prop("disabled",true);
                $("#exchange_send_now").text("Please Wait.....");
                $.ajax({
                    url: '{{url('/')}}/admin/sendProductCourier',
                    data: {
                        order_id: order_id,
                        "_token": "{{csrf_token()}}"
                    },
                    method: 'post',
                    success: function (data) {
                        alert(data)
                        $("#exchange_send_now").text("Successfully done !");
                          location.reload();
                    },
                    error:function(data){
                        $("#exchange_send_now").prop("disabled",false);
                        $("#exchange_send_now").text("Please Fill Up All Courier Information");
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

        $(document).on('keyup input', '#order_id_search', function () {
            var query = $('#order_id_search').val();
            if (query.length > 1) {

                    $.ajax({
                        type: "GET",
                        url: "{{url('admin/order/searchOrderOfRedexCourier')}}?order_id="+query,
                        success: function (data) {
                            $('tbody').html('');
                            $('tbody').html(data);
                        }
                    })

            }
        });


    </script>

@endsection