
<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}">
    <title>Invoice</title>
   
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }
        

        table {
            width: 100%;
            color: black !important ;
        }

        table,
        th,
        td {
            border: 1px solid #6c757d !important;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

         .table thead tr th {
                background-color: #6c757d !important;
                color:white;
            }

        hr {
            border-top: 1px dashed red;
        }

        
        @media print {

            .table thead tr th {
                background-color: #6c757d !important;
                color:white;
            }
            .section {
                display: flex;
                flex-direction: column;
                width: 100%;
                height: 100vh;
                justify-content: space-around;
                background-color: white;
            }
        }
    </style>
</head>
<body>
<?php
use Illuminate\Support\Facades\DB;
$orderIDs = unserialize($invoice->order_id); ?>


    <?php $count = 1; foreach ($orderIDs as $orderID) {


    $order  = DB::table('orders')
        ->select('orders.*', 'customers.customerName', 'customers.customerPhone', 'customers.customerAddress', 'couriers.courierName', 'cities.cityName', 'zones.zoneName', 'users.name', 'stores.*', 'payment_types.paymentTypeName', 'payments.paymentNumber')
        ->leftJoin('customers', 'orders.id', '=', 'customers.order_id')
        ->leftJoin('couriers', 'orders.courier_id', '=', 'couriers.id')
        ->leftJoin('payment_types', 'orders.payment_type_id', '=', 'payment_types.id')
        ->leftJoin('payments', 'orders.payment_id', '=', 'payments.id')
        ->leftJoin('cities', 'orders.city_id', '=', 'cities.id')
        ->leftJoin('zones', 'orders.zone_id', '=', 'zones.id')
        ->leftJoin('users', 'orders.user_id', '=', 'users.id')
        ->leftJoin('stores', 'orders.store_id', '=', 'stores.id')
        ->where('orders.id', '=', $orderID)->get()->first();
    if($count == 1) {
        echo '<div class="section">';
        $last = true;
    }
     ?>
    <div class="div-section">
        <table class="table table-striped" border="0" cellspacing="0" cellpadding="0">
            <tr>
                
                <td>
                    <img src="https://luxurybazarbd.com/public/619cd94b0477e.jpg" 
                    style="max-width:80px;display:block;"/>
                   
                    <strong>
                        <br>
                        <?php echo $order->storeDetails; ?>
                    </strong>
                </td>
                <td style="width:40%">
                    <h4>CUSTOMER INFO</h4>
                    {{ $order->customerName }} <br>
                    {{ $order->customerPhone }}<br>
                    @if($order->courierName == 'Sa Paribahan' || $order->courierName == 'Sundorban' )

                        {{ $order->courierName }} @if($order->cityName) >>  {{$order->cityName}} @endif  @if($order->zoneName) >> {{ $order->zoneName }} @endif
                    @else
                        {{ $order->customerAddress }} <br>
                        {{ $order->courierName }} @if($order->cityName) >>  {{$order->cityName}} @endif  @if($order->zoneName) >> {{ $order->zoneName }} @endif
                    @endif
                </td>
                <td>
                    <h4>Invoice #{{ $order->invoiceID }}</h4>
                    Order Date : {{ $order->orderDate }}<br>
                    @if($order->courierName == 'Sa Paribahan' || $order->courierName == 'Sundorban' )
                        Payment Method : Courier Condition
                    @else
                        Payment Method : Cash On Delivery
                    @endif

                </td>

            </tr>
        </table>
        
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 60%">Product</th>
                <th style="width: 20%">Quantity</th>
                <th style="width: 20%">Price</th>
            </tr>
            <thead>
            <?php
            $products = DB::table('order_products')
             ->join('products', 'products.id', '=', 'order_products.product_id')
            ->where('order_id', '=', $orderID)->get();
            foreach ($products as $product) { ?>
            <tr>
                <td><img src="https://luxurybazarbd.com/public/product/thumbnail/{{$product->productImage}}" style="max-width:50px;margin-right:10px;"/> {{$product->productName}}</td>
                <td>{{$product->quantity}}</td>
                <td>{{$product->productPrice}}  Tk</td>
            </tr>
           <?php } ?>
            <tfoot>
            <tr>
                <td colspan="1" style="border: none;"></td>
                <th>Delivery :  </th>
                <td>{{$order->deliveryCharge}} Tk</td>
            </tr>
            <tr>
                <td colspan="1" style="border: none;"></td>
                <th>Total : </th>
                <td>{{$order->subTotal}} Tk</td>
            </tr>

        </table>
        <div style=" display: flex; flex-direction: row; justify-content: space-between; ">
            <p>NB:  This invoice will be used as a Warranty Card from purchase date ({{ date('Y-m-d') }}). </p>
            <p>Order Recived By : {{ $order->name }}</p>
        </div>
    </div>
    <br/>
    <br/>
    <br/>
    <br/>
   
    <?php
    if($count == 2 ) {
        echo '</div>';
        $count = 1;
    }else{
        $count++;
    }
    } ?>
</div>
 
<script>
     window.print();
    $(function() {
       
        window.onfocus = function() {
            window.close();
        }
        window.onafterprint = function() {
            window.close();
        };


    });
</script>
</body>

</html>
