@foreach($orders as $order)
    <?php
    $order_track=DB::table('order_edit_track')->where('order_id',$order->order_id)->orderBy('id','desc')->value('updated_date');

    ?>
    <tr>
        <td><span   class="badge badge-pill badge-danger" style="font-size:18px">  {{$order->order_id}}</span>
            {{date('d-m-Y h:i a',strtotime($order->created_time))}}
        </td>


        <td style="text-align: center" >

            <span   data-toggle="modal" data-target="#modal-edit" onclick="orderEdit({{$order->order_id}})" class="badge badge-pill badge-primary"> {{officeStaffName($order->staff_id)}}</span>
            <span class="badge badge-pill badge-danger" >@if($order->order_area=='outside_dhaka')  Outside Dhaka   @else Inside Dhaka @endif</span>

        </td>




        <td>
            <span   class="badge badge-pill badge-info" style="font-size:18px">   {{$order->billing_name}}</span>
            <br>
            <span   class="badge badge-pill badge-success" style="font-size:18px">  {{$order->billing_mobile}}</span>
            <br>
            {{$order->shipping_address1}}
            <br>
            <span style="color:red;font-weight: 400">Note: {{$order->order_note}} </span>
            @if($order_track)
                <br>
                <span class="badge badge-pill badge-success" style="font-size:15px">{{date("d-m-Y",strtotime($order_track))}}</span>
                <span class="badge badge-pill badge-info" style="font-size:15px">{{date("h:i a",strtotime($order_track))}}</span>
            @endif

        </td>
        <td>
            <?php
            $order_items = unserialize($order->products);
            if(isset($order_items['items'])) {
            foreach ($order_items['items'] as $product_id => $item) {
            $featured_image = isset($item['featured_image']) ? $item['featured_image'] : null;
            $sku=DB::table('product')->where('product_id',$product_id)->value('sku');
            ?>
            <span class="product-title"><?=($item['name'])?></span>
            <img  class="img-responsive"  width="50" src="<?=$featured_image?>" />
            <p> {{$item['price']}}
                <i class="fal fa-times"></i>
                <?=($item['qty'])?>= {{$item['subtotal']}}
            </p>
            <p  style="color:red;font-weight:bold;position: absolute;margin-top: 8px;">Code :{{$sku}}</p>

            <br>
            <?php }
            }
            ?>
        </td>

        <td>
            {{$order->order_total}}

        </td>

        <td>
            <?php if($order->order_status=='pending_payment'){
            ?>
            <span   class="badge badge-pill badge-info" style="background-color:#ffad55;color: black;border: none;" >Payment Pending</span>
            <?php  } elseif ($order->order_status=='new') { ?>
            <span   class="badge badge-pill badge-info">{{ $order->order_status }}</span>
            <?php  } elseif ($order->order_status=='invoice') { ?>
            <span   class="badge badge-pill badge-info">Invoice</span>
            <?php  } elseif ($order->order_status=='on_courier') { ?>
            <span   class="badge badge-pill badge-danger">{{ $order->order_status }}</span>
            <?php  } elseif ($order->order_status=='delivered') { ?>
            <span   class="badge badge-pill badge-success">{{ $order->order_status }}</span>
            <?php  } elseif ($order->order_status=='refund') { ?>
            <span   class="badge badge-pill badge-danger">{{ $order->order_status }}</span>
            <?php  } elseif ($order->order_status=='cancled') { ?>
            <span   class="badge badge-pill badge-danger">{{ $order->order_status }}</span>
            <?php  } elseif ($order->order_status=='phone_pending') { ?>
            <span    class="badge badge-pill badge-info" style="background-color:#ffad55;color: black;border: none;" >Phone Pending </span>
            <?php  } elseif ($order->order_status=='failed') { ?>
            <span    class="badge badge-pill badge-danger"  >Failded Delevery </span>
            <?php  } else {  ?>
            <span   class="badge badge-pill badge-success">Pending Invoice</span>
            <?php } ?>
            <br>
        </td>
        <td>
            <a title="edit"   href="{{ url('admin/order') }}/{{ $order->order_id }}/edit" class=" btn btn-success btn-sm">
                <i class="fa fa-pencil"></i>
            </a>

            @if(($order->order_status=='ready_to_deliver') && ($order->order_print_status !=1))

                <a title="print"  class="btn btn-info btn-sm" target="_blank" href="{{url('/')}}/admin/single_order_invoice/{{ $order->order_id }}?name={{ Session::get('name') }}">

                    <i class="fa fa-print "></i>
                </a>
            @endif


        </td>




    </tr>
@endforeach