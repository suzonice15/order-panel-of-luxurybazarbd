@extends('admin.master')
@section('main',"Orders")
@section('active',"  Orders List")
@section('title'," Orders List")
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
        <div class='container-fluid'> 
        <div class="row" style="cursor: pointer;">
            <span id="order_status_view"></span>
            <div class="card mt-1">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2">
                          <h5>Total <span id="total_count">{{$orders->total()}}</span> Orders </h5>
                        </div>
                        <div class="col-12 col-md-1">                    
                                <a href="{{url('/')}}/admin/order/create" class="btn btn-success btn-sm"
                                   style="float:right"> <i class="fa fa-plus-circle"></i></a>
                            @if(Auth::user()->role_id !=3)
                                <button type="button" data-toggle="modal" data-target="#modal-default"
                                        class="btn btn-danger btn-sm" style="float:right" id="order_exchange_id"><i
                                            class="fas fa-exchange"></i>
                                </button>
                            @endif

                        </div>
                        <div class="col-12 col-md-4">
                        
                        </div>
                        

                    </div>
                    <div class='row'>
                        <div class='col-md-2'>
                        <label  style="display: flex;justify-content: center;flex-direction: row;margin-top: 7px;">Show 
                            <select name="per_page"  id="per_page"  class="form-control">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="500">500</option>
                            </select>
                         entries</label>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-bordered " style="width:100%">
                        <thead>
                        <tr style="text-align:center">
                        <th>SL 

                        @if(Auth::user()->role_id !=3)
                                    <input type="checkbox"  style="width: 29px;height: 25px;" name="all_select" id="checkAll"/>
                                @endif
                        </th>
                            <th class='text-center'>
                            <input type="text" name="invoice_id" id="invoice_id" placeholder="Invoice"
                                   class="form-control">
                         
                            </th>
                            <th style="width:15%;text-align:left">
                            <input type="text" id="customer_phone" placeholder="Phone Number"
                                   class="form-control">
                            </th> 
                            <th>Products</th>
                            <th>Total</th>
                            <th>
                                <select style="width:100%"   name="courier_id" id="courier_id" class="form-control select2">
                                            <option value="">Select Option</option>
                                            @foreach($courierInfo as $courierRow)
                                                <option value="{{$courierRow->id}}">{{$courierRow->courierName}}</option>
                                            @endforeach 
                                </select>
                              </th> 
                              <th>
                               <input type="date" id="order_date" name="order_date" class='form-control'>   
                              </th>
                              <th  style="width:250px" >
                                 Status
                              </th>
                              
                             <th>
                            <select  style="width:100%" name="user_id" id="user_id" class="form-control select2">
                                            <option value="">Select Option</option>
                                            @foreach($users as $user_row)
                                                <option value="{{$user_row->id}}">{{$user_row->name}}</option>
                                            @endforeach 
                                </select>
                              
                            </th>
                             
                            <th width="10%">Action </th>

                        </tr>
                        </thead>
                        <tbody>
                        @include('admin.order.pagination')
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        </div>
        <!-- /.card -->

    </section>


    @if(Auth::user()->role_id !=3)

    <div class="modal fade show" id="modal-default" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Order Exchange</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class='form-group'>
                        
                   
                    <label>Exchange to</label>
                    <select name="staff_id" id="staff_id" class="form-control">
                        <option value="">Select Option</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach 
                    </select>

                   
                     </div>
                     
                       <div class='form-group'>
                        
                   
                    <label>Order Status</label>
                    <select style="width:100%" name="order_status_convert" id="order_status_convert" class="form-control select2">
                        <option value="">Select Option</option>
                        <option value="new">New</option>
                                        <option value="pending_payment">Pending for Payment</option>
                                        <option value="pending">Pending</option>
                                        <option value="on_courier"> Courier</option>
                                        <option value="delivered">Delivered</option>
                                        <option value="cancled">Cancelled</option>
                                        <option value="ready_to_deliver">Pending Invoice</option>
                                        <option value="invoice">Invoice</option>
                                        <option value="booking">Booking</option>
                    </select>
                     </div>


                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" id="exchange_now">Update</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
   
    @endif

    <div class="modal fade show" id="modal-edit" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Order Edit History</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="order_edit_history">


                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn   btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div> 
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="status" id="status" value="new"/> 
    <script>

        window.load = order_status() 
        function orderEdit(order_id) {
            $.ajax({
                type: "GET",
                url: "{{url('admin/order/editHistory')}}/" + order_id,
                success: function (data) {

                    $('#order_edit_history').html(data);
                }
            })
        }

        $("#exchange_now").click(function () {
            var staff_id = $("#staff_id").val();
            var order_status_convert = $("#order_status_convert").val();
            if (staff_id == '') {
                alert("Please Select at least One Staff")
                return false;
            }
            var order_id = new Array(); 
            $('.checkAll').each(function () {
                if ($(this).is(":checked")) {
                    order_id.push(this.value);
                }
            });
            if (order_id.length > 0) {
                $.ajax({

                    url: '{{url('/')}}/admin/orderExchange',
                    data: {
                        order_id: order_id,
                        order_status:order_status_convert,
                        staff_id: $("#staff_id").val(),
                        "_token": "{{csrf_token()}}"
                    },
                    type: 'post',
                    success: function (data) {
                        location.reload();
                    }
                });
            } else {
                alert("Please select Order Id")
            }
        });

        //$('#checkAll').change(function () {
        $(document).on("change", "#checkAll", function (event) { 
            if ($(this).is(":checked")) { 
                $('.checkAll').prop('checked', true);

            } else if ($(this).is(":not(:checked)")) {
                $('.checkAll').prop('checked', false);
            }
        });

        $('#order_exchange_id').click(function (e) {
            e.preventDefault();
            var order_id = new Array();
 
            $('.checkAll').each(function () {
                if ($(this).is(":checked")) {
                    order_id.push(this.value);
                }
            }); 
            if (order_id.length == 0) { 
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Please Select At least One Order Id',
                    showConfirmButton: true,
                    timer: 2000
                })
            } 
        });

        $(document).on('change', '.orderStatusList', function (event) {
           let order_status_value=this.value;
          let order_id=  $(this).find(':selected').attr('order_id');
         
           if(order_status_value !=''){
           let confirm_check= confirm('Are You Want to changed Order Status ?');
           if(confirm_check){
               $.ajax({
                   url:"{{url('/')}}/admin/order/orderUpdateByOrderStatus",
                   data:{
                     order_id:order_id,
                     order_status:order_status_value
                   },
                   success:function(data){
                       $("#order_id_"+order_id).remove();
                       order_status()
                   }
               })
            }
           }

        });

        function fetch_data(page) {
            var order_status = $('#status').val();
            var per_page = $('#per_page').val();
            var courier_id = $('#courier_id').val();
            var user_id = $('#user_id').val();
            var order_date = $('#order_date').val();
            var invoice_id = $('#invoice_id').val();
            var customer_phone = $('#customer_phone').val();
            var formData={
                status:order_status,
                page:page,
                per_page:per_page,
                courier_id:courier_id,
                user_id:user_id,
                order_date:order_date,
                invoice_id:invoice_id,
                customer_phone:customer_phone,
            }
         
            $.ajax({
                type: "GET",
                data:formData,
                url: "{{url('admin/order/pagination')}}",
                success: function (data) {
                    $('tbody').html('');
                    $('#total_count').html(data.total_count);
                    $('tbody').html(data.htmls);
                    $(".select2").select2()
                }
            })
        }
        function order_status() {
            $.ajax({
                type: "GET",
                url: "{{url('admin/order/order_status')}}",
                success: function (data) {
                    $('#order_status_view').html(data);
                }
            })
        }
        function orderStatus(status) {
            $('#status').val(status);
            let page = 1;
            fetch_data(page);
        } 
       
        $(document).on('keyup input change', '#customer_phone,#invoice_id,#order_date,#per_page ,#courier_id,#user_id', function () {
            fetch_data(1); 
        });


        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);          
            fetch_data(page);
        });


        $(document).on('click', '.status_check', function () {
            var status = $(this).val()
            $('#status').val(status);  
            fetch_data(1);
        });


    </script>



@endsection