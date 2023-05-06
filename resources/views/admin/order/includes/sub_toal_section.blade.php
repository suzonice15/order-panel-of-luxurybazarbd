<?php
$deliveryCharge =isset($order->deliveryCharge) ? $order->deliveryCharge:100;
$discountCharge =isset($order->discountCharge) ? $order->discountCharge:'';
$paymentAmount =isset($order->paymentAmount) ? $order->paymentAmount:'';
$subTotal =isset($order->subTotal) ? $order->subTotal:'';
?>
<div class="col-md-6">
    <div class="form-group row">
        <label for="fname" class="col-sm-4 text-right control-label col-form-label">Sub
            Total</label>
        <div class="col-sm-8"><span class="form-control" id="subtotal"  style="cursor: not-allowed;"></span>
        </div>
    </div>
    <div class="form-group row">
        <label for="fname" class="col-sm-4 text-right control-label col-form-label">Delivery</label>
        <div class="col-sm-8">
            <input type="text" class="form-control"  value="{{$deliveryCharge}}" name="deliveryCharge"  id="deliveryCharge">
        </div>
    </div>
    <div class="form-group row">
        <label for="fname" class="col-sm-4 text-right control-label col-form-label">Discount</label>
        <div class="col-sm-8">
            <input type="text" value="{{$discountCharge}}" name="discountCharge" class="form-control" id="discountCharge">
        </div>
    </div>

    <div class="form-group row paymentAmount">
        <label for="fname" class="col-sm-4 text-right control-label col-form-label">Payment</label>
        <div class="col-sm-8">
            <input type="text" value="{{$paymentAmount}}" class="form-control" name="paymentAmount" id="paymentAmount">
        </div>
    </div>
    <div class="form-group row">
        <label for="fname" class="col-sm-4 text-right control-label col-form-label">Total</label>
        <div class="col-sm-8">  <span class="form-control" id="total" style="cursor: not-allowed;">{{$subTotal}}</span>
            <input type="hidden" name="subTotal" id="subTotal"
                   value="{{$subTotal}}">
        </div>
    </div>


</div>
