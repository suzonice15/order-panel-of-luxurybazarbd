
@extends('admin.master')
@section('main',"Order Status Report")
@section('active',"Order Status Report")
@section('title',"Order Status Report")
@section('main-content')
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">


                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title"> Staff Order List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th> 
                                        <th>Processing</th>
                                        <th>Payment Pending</th>
                                        <th>On Hold</th>
                                        <th>Completed</th>
                                        <th>Pending Invoiced</th>
                                        <th>Invoiced</th>
                                        <th>Delivered</th>
                                        <th>Return</th>
                                        <th>Canceled</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $key=>$order)
                                       


                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{officeStaffName($order->user_id)}}</td>
                                            <td>{{getOrderStatus('Processing',$order->user_id)}}</td>
                                            <td>{{getOrderStatus('Payment Pending',$order->user_id)}}</td>
                                            <td>{{getOrderStatus('On Hold',$order->user_id)}}</td>
                                            <td>{{getOrderStatus('Completed',$order->user_id)}}</td>
                                            <td>{{getOrderStatus('Pending Invoiced',$order->user_id)}}</td>                                            
                                            <td>{{getOrderStatus('Invoiced',$order->user_id)}}</td>                                            
                                            <td>{{getOrderStatus('Delivered',$order->user_id)}}</td>
                                            <td>{{getOrderStatus('Return',$order->user_id)}}</td>
                                            <td>{{getOrderStatus('Canceled',$order->user_id)}}</td>
                                            <td>{{$order->total}}</td>
                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>

                    </div>

                </div>
            </div>

    </div>
    </section>


@endsection