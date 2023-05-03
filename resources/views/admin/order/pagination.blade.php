 @php $i = $orders->perPage() * ($orders->currentPage() - 1); @endphp
 @foreach($orders as $order) 
                  <tr id="order_id_{{$order->id}}">
                    <td style="text-align:center">{{++$i}}
                    <br/>
                    @if(Auth::user()->role_id !=3)
                    <input style="width: 29px;height: 25px;text-align: center;"
                    type="checkbox" value="{{$order->order_id}}"
                     class="checkAll ">
                    @endif
                 
                    </td>
              <td  class='text-center'>
                <span  style="font-size:18px">  
               {{$order->invoiceID}} 
               </span>
               <br/>
               
               @if($order->order_created_by=="Manual")
                 
                 <span class='badge badge-pill badge-danger'>Manual</span> 

               @else
                <span class='badge badge-pill badge-success'>Online</span> 
               @endif
                
                </td>

                <td>
             {{ optional($order->customer)->customerName}}
               <br>
               {{ optional($order->customer)->customerPhone}}
              <br>
              {{ optional($order->customer)->customerAddress}} 
              </td>
              <td> 
                 @foreach ($order->products as $row => $item)     
               <p>{{$item->quantity}}  x  {{$item->productName}}</p>
                @endforeach
            </td>
            <td> {{$order->subTotal}}</td>
           
                      <td class='text-center'> 
                         {{getCourierName($order->courier_id)}}
                         @if($order->order_tracking_id)
                         <br/>
                         <span class='badge badge-pill badge-success'>   {{$order->order_tracking_id}}</span>
                        @endif
                   
                      </td>
                      <td class='text-center'>
                      <span    style="font-size:18px">
                      {{date('d-m-Y',strtotime($order->created_at))}}</span> <br/>
                   {{date('h:i a',strtotime($order->created_at))}} 
                   @if($order->deliveryDate)
                      <br/>
                      <span style="color:green">
                      Shipping Date
                          {{date('d-m-Y',strtotime($order->deliveryDate))}}
                     </span>
                    @endif  
                      </td>
                      <td style="width:250px" > 
                      {{getAllOrderStatusForOrderIndex("$order->status",$order->id)}} 
                     

                      
                        </td>
                <td style="text-align: center" >
               
                    <span   data-toggle="modal" data-target="#modal-edit" 
                    onclick="orderEdit({{$order->id}})" 
                    class="badge badge-pill badge-primary"> {{getUserName($order->user_id)}}</span>
             
         

               </td> 

            <td>
                <a title="edit"   href="{{ url('admin/order') }}/{{ $order->id }}/edit" class=" btn btn-success btn-sm">
                    <i class="fa fa-pencil"></i>
                </a> 
                @if(($order->status=='ready_to_deliver') ||  ($order->status=='invoice'))

                <a title="print"  class="btn btn-info btn-sm" target="_blank" href="{{url('/')}}/admin/single_order_invoice/{{ $order->order_id }}?name={{ Session::get('name') }}">
                      @if($order->order_print_status ==1)
                        Done
                      @endif
                    <i class="fa fa-print "></i>
                </a>
                @endif
                
            </td>
        </tr>
              @endforeach 
              <tr ><td></td> <td style="text-align: center" colspan="8">  {!! $orders->links() !!}</td><td></td></tr>     
              
         
         
         
         