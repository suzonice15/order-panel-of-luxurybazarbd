@extends('admin.master')
@section('main',"Order")
@section('active',"Add New Order")
@section('title',"Add New Order")
@section('main-content')
    <form action="{{url('/')}}/admin/order" method="post">
        @csrf
        <section class="content">


            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-6">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Customer Information</h3>
                            </div>


                            <div class="card-body">
                                <div class="form-group ">
                                    <label for="billing_name">Name </label>
                                    <input required class="form-control" placeholder="Customer Name" type="text"
                                           name="billing_name"
                                           value=""/>
                                </div>


                                <div class="form-group ">
                                    <label for="billing_mobile">Customer Phone</label>
                                    <input required type="number" placeholder="Customer Mobile" name="billing_mobile"
                                           class="form-control"
                                           value=""/>
                                </div>


                                <div class="form-group shipping-address-group ">
                                    <label for="shipping_address1">Customer Address </label>
                                        <textarea required class="form-control" rows="2" name="shipping_address1"
                                                  id="shipping_address1" placeholder="Customer Address"></textarea>
                                </div>
                            </div>


                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Action </h3>
                            </div>


                            <div class="card-body">
                                <div class="form-group" id="order_area">
                                    <label> <input type="radio" name="order_area"  value="inside_dhaka" checked="">
                                        Inside Dhaka </label>   <label> 
                                            <input type="radio" name="order_area" value="outside_dhaka"> Outside Dhaka
                                    </label></div>

                                <div class="form-group"  >
                                    <label>Courier </label>
                                    <select name="courier_service" id="courier_service" class="form-control select2">
                                        <option value="sundarban courier service">-----Select----</option>
                                        <option value="sundarban courier service">sundarban courier service</option>
                                        <option value="karatoa courier service">karatoa courier service</option>
                                        <option value="S A paribahan courier service">S A paribahan courier service
                                        </option>
                                        <option value="Janani courier service">Janani courier service</option>
                                        <option value="AJR Courier Service">AJR Courier Service</option>
                                        <option value="Redx">Redx</option>
                                        <option value="M N courier service">M N courier service</option>
                                        <option value="Pathao">Pathao</option>
                                        <option value="Habib Express">Habib Express</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Area Name</label>
                                    <select name="area_id" id="area_id" class="form-control select2"                                                                                    id="courier_service">
                                        <option value="">---- Select ----</option>
                                        @foreach($areas as $area)
                                            <option   value="{{$area->area_id}}">{{$area->area_name}}</option>
                                        @endforeach

                                    </select>

                                </div>

                                <div class="form-group ">
                                    <label for="weight">Product Weight</label>
                                    <input required type="number" placeholder="Product Weight" name="weight"
                                           class="form-control"
                                           value=""/>
                                </div>

                                <div class="form-group ">
                                    <label for="weight">Invoice Number</label>
                                    <input type="text" placeholder="Invoice Number" name="invoice_id"
                                           class="form-control"
                                           value=""/>
                                </div>
                                <div class="form-group"  >
                                    <label>Order Status</label>
                                    <select name="order_status" id="order_status" class="form-control">
                                        <option value="new">New</option>
                                        <option value="pending_payment">Pending for Payment</option>
                                        <option value="pending">Pending</option>
                                        <option value="on_courier"> Courier</option>
                                        <option value="delivered">Delivered</option>
                                        <option value="cancled">Cancelled</option>
                                        <option value="ready_to_deliver">Pending Invoice</option>
                                        <option value="invoice">Invoice</option>


                                    </select>
                                </div>
                                <div class="form-group"  >
                                    <label> Order Note</label>
                                    <textarea rows="2" class="form-control"   name="order_note"></textarea>
                                </div>
                                <div class="form-group "> 
                                    <label>Shipping Date</label> 
                                    <div class="input-group date"> 
                                        <div class="input-group-addon">                                            
                                            </div>
                                              <input type="date" name="shipment_time" class="form-control pull-right" id="datepicker" value="{{date("Y-m-d")}}">
                                     </div>     
                                </div>
                                 </div>
                                   </div>


                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Order Information</h3>
                            </div>


                            <div class="card-body">


                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Product Information</h3>
                                    </div>
                                    <div class="card-body p-0">

                         <span id="product_html">
                           <table class="table table-striped table-bordered">
                               <tr>
                                   <th class="name" width="30%">Product</th>
                                   <th class="name" width="5%">Code</th>
                                   <th class="image text-center" width="5%">Image</th>
                                   <th class="quantity text-center" width="10%">Qty</th>
                                   <th class="price text-center" width="10%">Price</th>
                                   <th class="total text-right" width="10%">Sub-Total</th>
                               </tr>

                           </table>
                           </span>

                                        <div class="form-group">
                                            <select required name="product_ids" id="product_ids" class="form-control select2"
                                                    multiple="multiple"
                                                    data-placeholder="Type... product name here..."
                                                    style="width:100%;">

                                                <?php foreach($products as $product) :
                                                $product_title = substr($product->product_title, 0, 50)
                                                ?>
                                                <option value="{{$product->product_id}}"
                                                >{{$product_title}} - {{$product->sku}}</option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="card-footer">
                  <button type="submit" class="btn btn-primary" style="float:right">Submit</button>
                </div>


                                    </div>

                                    <!-- /.card-body -->
                                </div>


                            </div>


                        </div>


                    </div>


                </div>
            </div>
        </section>
    </form>
    <script>

        $("body").on('input', '#shipping_charge', function () {
            var subtotal_price = $('#subtotal_price_sujon').text();
            var delivary_cost = $(this).val();
            var advabced_price = $("#advabced_price").val();
            var discount_price = $("#discount_price").val();

            if (delivary_cost == '') {
                $("#shipping_charge").val(0);
            }
            if (advabced_price == '') {
                $("#advabced_price").val(0);
            }
            if (discount_price == '') {
                $("#discount_price").val(0);
            }

            var delivary_cost = $("#shipping_charge").val();
            var advabced_price = $("#advabced_price").val();
            var discount_price = $("#discount_price").val();

            var total_price = (parseInt(subtotal_price) + parseInt(delivary_cost) - parseInt(advabced_price)) - parseInt(discount_price);
            $('#total_cost').text(total_price);
            $('#order_total').val(total_price);
        });
        $("body").on('input', '#discount_price', function () {
            var discount_price = parseInt($(this).val());
            var subtotal_price = $('#subtotal_price_sujon').text();
            var delivary_cost = $('#shipping_charge').val();
            var advabced_price = $("#advabced_price").val();
            if (delivary_cost == '') {
                $("#shipping_charge").val(0);
            }
            if (advabced_price == '') {
                $("#advabced_price").val(0);
            }
            if (discount_price == '') {
                $("#discount_price").val(0);
            }

            var delivary_cost = $("#shipping_charge").val();
            var advabced_price = $("#advabced_price").val();
            var discount_price = $("#discount_price").val();
            var total_price = (parseInt(subtotal_price) + parseInt(delivary_cost) - parseInt(advabced_price)) - parseInt(discount_price);

            $('#total_cost').text(total_price);
            $('#order_total').val(total_price);
        });
        $("body").on('input', '#advabced_price', function () {
            var advabced_price = parseInt($(this).val());
            var subtotal_price = $('#subtotal_price_sujon').text();
            var shipping_charge = $('#shipping_charge').val();
            var discount_price = parseInt($('#discount_price').val());
            var total_price = parseInt(subtotal_price) + parseInt(shipping_charge) - (discount_price + advabced_price);
            var total = parseInt(total_price)
            $('#total_cost').text(total);
            $('#order_total').val(total);
        });
    </script>


    <script>


        $(document).on('click', '.update_items', function () {
            var product_ids = [];
            var product_qtys = [];
            var _token = $("input[name='_token']").val();

            var order_id = $('#order_id').val();
            var shipping_charge = $('#shipping_charge').val();
            $.each($(".item_qty"), function () {
                product_ids.push($(this).attr('data-item-id'));
                product_qtys.push($(this).val());
            });
            product_ids = product_ids.join(",");
            product_qtys = product_qtys.join(",");
            $.ajax({
                type: 'POST',
                data: {
                    "product_ids": product_ids,
                    "product_qtys": product_qtys,
                    "shipping_charge": shipping_charge,
                    "order_id": order_id,
                    "_token": _token
                },
                url: "{{  url('admin/order/ProductUpdateChangeOfNewOrder')}} ",
                success: function (result) {
                    console.log(result)
                    //var response = JSON.parse(result);
                    $('#product_html').html(result);
                },
                error: function (result) {

                    console.log(result)
                }
            });
        });


    </script>


    <script>
        $(document).on('change', '#product_ids', function () {
            var product_ids = [];
            var product_qtys = [];
            var shipping_charge = $('#shipping_charge').val();
            $.each($("#product_ids option:selected"), function () {
                product_ids.push($(this).val());
            });
            product_ids = product_ids.join(",");
            $.ajax({
                url: "{{  url('admin/order/newProductEditSelectionChange')}} ",
                type: "POST",
                data: {
                    shipping_charge: shipping_charge,
                    product_id: product_ids,
                    product_quantity: 1,
                    _token: "{{ csrf_token()}}"
                },
                success: function (result) {

                    $('#product_html').html(result);
                },
                errors: function (result) {
                    console.log('error')
                    console.log(result)
                }

            });

        });


    </script>
    </section>


@endsection