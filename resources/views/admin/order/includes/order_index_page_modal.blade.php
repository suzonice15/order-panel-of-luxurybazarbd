<?php
$status = Session::get('status');
if($status != 'office-staff'){
?>
<div class="modal fade show" id="modal-default" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Order Exchange</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class='form-group'>
                    <label>Exchange to</label>
                    <select name="staff_id" id="staff_id" class="form-control">
                        <option value="">----select----</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class='form-group'>
                    <label>Order Status</label>
                    <select name="order_status_convert" id="order_status_convert" class="form-control">
                        <option value="">----select----</option>
                        <option value="new">New</option>
                        <option value="pending_payment">Pending for Payment</option>
                        <option value="pending">Pending</option>
                        <option value="on_courier"> Courier</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancled">Cancelled</option>
                        <option value="ready_to_deliver">Pending Invoice</option>
                        <option value="invoice">Invoice</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="exchange_now">Exchange Now</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php }?>

<div class="modal fade show" id="modal-image-view" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <img style="width: 100%" class="img-fluid border" id="modal-image-show" />
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn   btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade show" id="modal-edit" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Order Edit History</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="order_edit_history">
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn   btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
