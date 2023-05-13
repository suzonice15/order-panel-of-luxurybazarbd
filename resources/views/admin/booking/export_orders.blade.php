
<?php 


?>
 
 

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>SL</th>
            <th>Invoice ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Number</th>
            <th>Product Name</th>
            <th>Price </th>
        </tr>
    </thead>
    <tbody>
    @foreach($orders as $key=>$order)
        <tr>
            <td> {{date("d.m.y",strtotime($order->orderDate))}}  </td>
            <td>{{++$key}}</td>
            <td>{{$order->invoiceID}}   </td>
            <td>{{ optional($order->customer)->customerName}}  </td>
            <td>{{ optional($order->customer)->customerAddress}}  </td>
            <td>{{ optional($order->customer)->customerPhone}}</td>
            <td>
            @foreach ($order->products as $row => $item)     
                 {{$item->productName}}  
                @endforeach
            </td>
            <td>{{$order->subTotal}}</td>
        </tr>
        @endforeach
    </tbody>
</table>


