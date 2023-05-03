<?php
$html = 'No Products Info. Found!';
if (count($products) > 0) {
?>


<table class="table table-striped table-bordered">
    <tr>
        <th class="name" width="30%">Product</th>
        <th class="name" width="5%">Code</th>
        <th class="image text-center" width="5%">Image</th>
        <th class="quantity text-center" width="10%">Qty</th>
        <th class="price text-center" width="10%">Price</th>
        <th class="total text-right" width="10%">Sub-Total</th>
    </tr>
    <tbody>
<?php
$subtotall = 0;

foreach ($products as $prod) {
$qty = $pqty[$prod->product_id];
$total_quntity = $qty + $pqty[$prod->product_id];
//
//if ($prod->discount_price) {
//    $sell_price = floatval($prod->discount_price);
//} else {
//    $sell_price = floatval($prod->sell_price);
//}
$product_price =$prod->sell_price;

$product_discount =$prod->discount_price;
$discount_type = $prod->discount_type;


if($discount_type == 'fixed')
{
    $sell_price = ($product_price - $product_discount);
}
elseif($discount_type == 'percent')
{
    $save_money = ($product_discount / 100) * $product_price;
    $sell_price = floatval($product_price - $save_money);
}

$subtotal = ($sell_price * $qty);
$subtotall += $subtotal;
$product_link = url('/') . '/' . $prod->product_name;
$featured_image = 'https://www.dhakabaazar.com/' . $prod->featured_image;
?>

    <tr>
    <td><?=$prod->product_title?></td>
    <td><?=$prod->sku?></td>
    <td class="image text-center">
        <img src="<?=$featured_image?>" height="30" width="30">
    </td>
    <td class="text-center">
        <input type="number" name="products[items][<?=$prod->product_id?>][qty]" class="form-control item_qty"
               value="<?= $qty ?>" data-item-id="<?=$prod->product_id?>" style="width:60px;">
    </td>


    <td class="text-center">৳ <?=$sell_price ?>.00</td>
    <td class="text-right">৳ <?=$subtotal?>.00</td>

        <input type="hidden" id="featured_image" name="products[items][<?=$prod->product_id?>][featured_image]"
               value="<?= $featured_image; ?>"/>

        <input type="hidden" id="price" name="products[items][<?=$prod->product_id?>][price]" value="<?= $sell_price; ?>"/>
        <input type="hidden" id="name" name="products[items][<?=$prod->product_id?>][name]"
               value="<?=  $prod->product_title; ?>"/>
        <input type="hidden" id="subtotal" name="products[items][<?=$prod->product_id?>][subtotal]" value="<?= $subtotal; ?>"/>


</tr>

<?php
}
} ?>
    <tr>
        <td colspan="6" class="text-right"><a class="btn btn-primary  update_items">Change</a>
        </td>
    </tr>


<?php
$order_total = $subtotall;
$order_total = $order_total + $shipping_charge;
?>
<tr>
    <td colspan="5" class="text-right"> Sub Total</td>
    <td
            class="text-right"> ৳ <span
                id="subtotal_price_sujon"><?php echo $subtotall . '.00' ?></span></td>
</tr>
<tr>
    <td  colspan="5" class="text-right"> <span
                class="extra bold">Delivery Cost</span></td>
    <td  ><input
                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                type="text" name="shipping_charge" class="form-control" id="shipping_charge"
                value="<?= $shipping_charge;?>"></td>
</tr>

<tr>
    <td  colspan="5" class="text-right"> <span
                class="extra bold">Discount Price</span></td>
    <td  ><input
                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                type="text" name="discount_price" class="form-control" id="discount_price"
                value="{{$order->discount_price}}"></td>
</tr>
<tr>
    <td  colspan="5" class="text-right"> <span
                class="extra bold">Advance Price</span></td>
    <td class="text-right"><input
                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                type="text" name="advabced_price" class="form-control" id="advabced_price"
                value="{{$order->advabced_price}}"></td>
</tr>

<tr>
    <td  colspan="5" class="text-right"> <span
                class="extra bold totalamout">Total</span></td>
    <td class="text-right"> <span class="bold totalamout"><p> ৳ <span   id="total_cost"><?php echo $order->order_total; ?></span></p></span>
        <input type="hidden"    name="order_total"  id="order_total"  value="<?php echo $order->order_total ?>">

</tr>
    </tbody>

</table>