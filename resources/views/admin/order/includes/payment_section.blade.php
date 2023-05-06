<?php
$memo =isset($order->memo) ? $order->memo:'';
?>

<div class="col-md-6">
    <div class="form-group">
        <label>Payment</label>
        <select onchange="getPaymentsNumber(this.value)" id="paymentTypeID" name="payment_type_id"
                class="form-control select2 ">

        </select>
    </div>
    <div class="form-group ">
        <select id="paymentID" name="payment_id" class="form-control ">
            <option value="" ></option>
        </select>
        <button  type="button" class="btn btn-info btn-block mt-2" id="sendSms">Send SMS</button>
    </div>
    {{--<div class="form-group paymentAgentNumber" >--}}
        {{--<input type="text" class="form-control" id="paymentAgentNumber"--}}
               {{--placeholder="Enter Bkash Agent Number" value="">--}}
    {{--</div>--}}
    <div class="form-group hide">
        <label>Memo Number</label>
        <input type="text" class="form-control" name="memo" id="memo" placeholder="Enter Memo Number" value="{{$memo}}">
    </div>
</div>