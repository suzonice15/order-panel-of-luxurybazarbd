

<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Order Action </h3>
    </div>
    <div class="card-body">
        <div class="form-group" id="order_area">
            <label><input type="radio" name="order_area" value="inside_dhaka" @if($order_area=='inside_dhaka') checked="" @endif>
                Inside Dhaka </label> <label>
                <input type="radio" name="order_area" value="outside_dhaka"
                       @if($order_area=='outside_dhaka') checked="" @endif>
                Outside Dhaka
            </label></div>
        <div class="form-group">
            <label>Order Status</label>
             {{getAllOrderStatus()}}
        </div>
        <div class="form-group ">
            <label>Shipping Date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                </div>
                <input type="date" name="deliveryDate" class="form-control pull-right"
                       value="{{date("Y-m-d",strtotime($shipment_time))}}">
            </div>
        </div>
    </div>
</div>

