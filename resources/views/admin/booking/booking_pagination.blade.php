  @foreach($orders as $key=>$order) 
                  <tr id="order_id_{{$order->id}}">
                    <td style="text-align:center">{{++$key}}
                    <br/>
                    @if(empty($order->order_tracking_id))
                    <input style="width: 29px;height: 25px;text-align: center;"
                    type="checkbox" value="{{$order->id}}"
                     class="checkAll">
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
                      
                <td style="text-align: center" > 
                     {{getUserName($order->user_id)}} 
               </td> 

            <td>
                <a title="edit"   href="{{ url('admin/order') }}/{{ $order->id }}/edit" class=" btn btn-success btn-sm">
                    <i class="fa fa-pencil"></i>
                </a> 
               
                
            </td>
        </tr>
              @endforeach 
              
         
         
         