
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
                                        <th>New</th>
                                        <th>Pending</th>
                                        <th>Phone Pending</th>
                                        <th>Ready To Deliver</th>
                                        <th>Courier</th>
                                        <th>Print</th>
                                        <th>Cancel</th>
                                        <th>Delivered</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $key=>$order)
                                        @php

                                        if($order->staff_id==73 || $order->staff_id=='' )
                                        {
                                        continue;
                                        }


                                        @endphp


                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{officeStaffName($order->staff_id)}}</td>
                                            <td>{{getOrderStatus('new',$order->staff_id)}}</td>
                                            <td>{{getOrderStatus('pending',$order->staff_id)}}</td>
                                            <td>{{getOrderStatus('pending_payment',$order->staff_id)}}</td>
                                            <td>{{getOrderStatus('ready_to_deliver',$order->staff_id)}}</td>
                                            <td>{{getOrderStatus('on_courier',$order->staff_id)}}</td>
                                            <td>{{getPrint($order->staff_id)}}</td>
                                            <td>{{getOrderStatus('cancled',$order->staff_id)}}</td>
                                            <td>{{getOrderStatus('delivered',$order->staff_id)}}</td>
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