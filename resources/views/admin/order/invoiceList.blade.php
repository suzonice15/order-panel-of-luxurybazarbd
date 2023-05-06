@extends('admin.master')
@section('main',"Invoices ")
@section('active',"  Invoices  List")
@section('title'," Invoices  List")
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

        <div class="col-md-12">
             
                    <div class="card mt-1">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4">
                                <h5><b>Total <span id="total_count">{{$invoices->total()}}</span> Invoices </b></h5>
                                </div> 
                            </div>
                            
                        </div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table table-bordered " style="width:100%">
                                <thead>
                                <tr style="text-align:center">
                                <th class="text-center">SL </th>
                                    <th class="text-center">
                                    Invoice ID
                                    </th> 
                                    <th class="text-center">Total Order</th> 
                                    <th class="text-center">Created At </th> 
                                
                                    <th class="text-center">Action </th>

                                </tr>
                                </thead>
                                <tbody>
                                @php $i = $invoices->perPage() * ($invoices->currentPage() - 1); @endphp

                                    @foreach($invoices as $invoice)
                                    <?php $order_ids=explode(':',$invoice->order_id);
                                  
                                    ?>
                                    <tr>
                                        <td class="text-center">{{++$i}}</td>
                                        <td class="text-center">{{$invoice->id}}</td>
                                        <td class="text-center">{{$order_ids[1]}}</td>
                                        <td class="text-center">
                                            {{date("d-m-Y",strtotime($invoice->created_at))}}
                                            <br/>
                                            {{date("h:i:a",strtotime($invoice->created_at))}}
                                        </td>
                                        <td class="text-center">
                                            <a  class="btn btn-success btn-sm" href="{{url('/admin/order/invoiceList?id='.$invoice->id)}}">Print</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4">{{$invoices->links()}}</td>
                                    </tr>
                            
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
        </div>
        </div>
        </div>
       

    </section> 
           
 
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="status" id="status" value="new"/>  

@endsection