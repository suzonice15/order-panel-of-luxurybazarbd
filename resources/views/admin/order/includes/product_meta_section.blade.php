<div class="form-group">
    <select name="product_ids" onchange="getOrderMeta(this.value)" id="product_ids"
            class="form-control select2">
    </select>
</div>
<table class="table  table-bordered">
    <thead>
    <tr>
        <th class="image text-center" width="5%">Product</th> 
        <th class="name" width="5%">Code</th>
        <th class="quantity text-center" width="25%">Qty</th>
        <th class="price text-right" width="10%">Price</th>
        <th class="total text-right" width="10%">S.Total</th>
        <th class="total text-right" width="5%"></th>
    </tr>
    </thead>
    <tbody id="product_meta">
    @if(isset($order))
        @foreach($order->products as $key=>$product)
           <?php  
             $product_image=DB::table('products')->where('id',$product->product_id)->value('productImage');
           ?>
            <tr >
                <td>
                    <img width="60" src="{{env('IMG_URL')}}{{$product_image}}"/>
                    <br/>
                    {{$product->productName}}
                     <input type="hidden" name="product_id[]" value="{{ $product->product_id}}" />
                    <input type="hidden" name="productCode[]" value="{{$product->productCode}}" />
                    <input type="hidden" name="productName[]" value="{{$product->productName}}" />
                    <input type="hidden" name="productPrice[]" value="{{$product->productPrice}}" />
                </td>
                
                <td>{{$product->productCode}}</td>
                <td><input type="number" id="{{$key}}" min="1"
                           class="form-control quantity" name="quantity[]" value="{{$product->quantity}}">
                </td>
                <td class="price text-right"
                    id="price_{{$key}}">{{$product->productPrice}}</td>
                <td class="price text-right sub_total_product"
                    id="sub_total_product_{{$key}}">{{$product->productPrice*$product->quantity}}</td>
                <td><button type="button"   class="btn btn-danger btn-sm delete-product">
                        <i class="fa fa-trash"></i>
                    </button></td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>