<?php $total_quantity=0;?>
@if($orders)
    @foreach($orders as $key=>$order)
        @php

        $areaInfo = DB::table('area')->where('area_id', $order->area_id)->first();

        @endphp
        <tr>
            <td>
                @if($order->traking_id =='')
                    <input style="width: 15px;text-align: center"
                           type="checkbox"
                           value="{{$order->order_id}}"
                           class="checkAll">
                @else
                    <span style="color:red;font-weight:bold">{{$order->traking_id  }}</span>

                @endif
            </td>
            <td>
                                            <span style="color:red;font-size: 17px;font-weight: bold">
                                                 {{$order->courier_service}}
                                            </span>
                <br/>
                @if($areaInfo)
                    <span style="color:green;font-size: 15px;font-weight: bold">
                                                 {{$areaInfo->area_name}}
                                            </span>
                @endif
                <br/>

                                                <span style="color:red;font-size: 15px;font-weight: bold">
                                                Weight : {{$order->weight}}
                                            </span>
                <br/>
                                              <span style="color:black;font-size: 15px;font-weight: bold">
                                                Invoice : {{$order->invoice_id}}
                                            </span>
            </td>
            <td><span   class="badge badge-pill badge-danger" style="font-size:18px">  {{$order->order_id}}</span>
                <span   class="badge badge-pill badge-success" style="font-size:18px">    {{date('d-m-Y',strtotime($order->created_time))}}</span>
                {{date('h:i a',strtotime($order->created_time))}}
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

        </tr>

    @endforeach
@endif

