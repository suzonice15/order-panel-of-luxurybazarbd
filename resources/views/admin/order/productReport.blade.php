@extends('admin.master')
@section('main',"Orders")
@section('active',"  Orders List")
@section('title'," Orders List")

@section('main-content')

     
    <section class="content">
    <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">

                     <form action="{{url('/')}}/admin/product/report" method="get" >
                  <div class="row">
                      <div class="col-md-3">
                          <h3 class="card-title">Order Product Report</h3>
                      </div>

                      <div class="col-md-3">
                          <div class="input-group input-group-sm" >
                              <input type="date" name="order_date_start" value="@if(isset($searchDateStart)){{date("Y-m-d",strtotime($searchDateStart))}}@endif" class="form-control float-right" >

                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="input-group input-group-sm" >
                              <input type="date" name="order_date_end" value="@if(isset($searchDateEnd)){{date("Y-m-d",strtotime($searchDateEnd))}}@endif" class="form-control float-right" >

                          </div>
                      </div>

                      <div class="col-md-3">
                          <div class="input-group input-group-sm" >
                              <input type="text" name="product_code"  value="@if(isset($searchText)){{$searchText}} @endif" class="form-control float-right" placeholder="Search product code here ...">
                              <div class="input-group-append">
                                  <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                              </div>
                          </div>
                      </div>
                  </div>
                     </form>

                <div class="card-tools">




                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>SL</th>
                      <th>Product Name</th>
                      <th style="text-align:center">Product Code</th>
                      <th style="text-align:center" width="5%">Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $total_quantity=0;?>
                      @if($orders)
                      @foreach($orders as $key=>$order)
                          <?php
                          $total_quantity += $order->total;
                          ?>
                    <tr>
                      <td>{{++$key}}</td>
                      <td>{{$order->product_title}}</td>
                      <td style="text-align:center">{{$order->sku}}</td>
                      <td style="text-align:center">{{$order->total}}</td>
                       
                     </tr>
                    @endforeach
                    @endif
                  <tr>
                      <td colspan="3"  style="text-align: right">Total</td>
                      <td style="text-align: right">{{$total_quantity}}</td>
                  </tr>
                    
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
            if (staff_id == '') {
                alert("Please Select at least One Staff")
                return false;
            }
            var order_id = new Array();
//var allId=$('.checkAll').val();
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
        $('#deleteAll').click(function (e) {
            e.preventDefault();
            var order_id = new Array();
//var allId=$('.checkAll').val();
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

        function fetch_data(page, status) {
            $.ajax({
                type: "GET",
                url: "{{url('admin/order/pagination')}}?page=" + page + "&status=" + status,
                success: function (data) {
                    $('tbody').html('');
                    $('tbody').html(data);
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
            fetch_data(page, status);
        }

    </script>


    <script>


        function pagination_search_by_order_id(query) {
            var page = 1
            $.ajax({
                type: "GET",
                url: "{{url('admin/order/pagination_search_by_order_id')}}?page=" + page + "&query=" + query,
                success: function (data) {
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            })
        }


        function pagination_search_by_phone(query) {
            var page = 1
            $.ajax({
                type: "GET",
                url: "{{url('admin/order/pagination_search_by_phone')}}?page=" + page + "&query=" + query,

                success: function (data) {
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            })
        }
        function pagination_search_by_product_code(query) {
            var page = 1
            $.ajax({
                type: "GET",
                url: "{{url('order/pagination_search_by_product_code')}}?page=" + page + "&query=" + query,

                success: function (data) {
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            })
        }


        $(document).on('keyup input', '#order_id', function () {
            var query = $('#order_id').val();
            if (query.length > 1) {
                pagination_search_by_order_id(query);
            } else {
                fetch_data(1, 'new');
            }
        });


        $(document).on('keyup input', '#product_code', function () {
            var query = $('#product_code').val();
            var page = $('#hidden_page').val();
            var status = $('#status').val();
            if (query.length > 3) {
                pagination_search_by_product_code(page, query);
            } else {
                fetch_data(1, 'new');
            }
        });
        $(document).on('keyup input', '#pagination_search_by_phone', function () {
            var query = $('#pagination_search_by_phone').val();

            if (query.length > 7) {
                pagination_search_by_phone(query);
            } else {
                fetch_data(1, 'new');
            }
        });


        $(document).on('click', '.pagination a', function (event) {

            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var status = $('#status').val();
            fetch_data(page, status);
        });


        $(document).on('click', '.status_check', function () {
            var status = $(this).val()
            $('#status').val(status);
            var status = $('#status').val();
            var page = 1;
            fetch_data(page, status);
        });


    </script>



@endsection