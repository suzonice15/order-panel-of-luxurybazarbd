<?php if(isset($user_sidebar)) echo $user_sidebar?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?=$page_title?></h1>
        <ol class="breadcrumb">
            <li><a href=""<?=base_url('admin')?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?=$page_title?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <?php if($_GET){ echo '<div class="btnarea">'.get_req_message().'</div>'; } ?>

                <?php //echo validation_errors(); ?>


                <form method="POST" id="checkout" action="<?=base_url()?>order/add_new" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box box-danger">
                                <div class="box-header">
                                    <h3 class="box-title">Customer Informations</h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group <?=form_error('billing_name') ? 'has-error' : ''?>">
                                        <label for="billing_name">Name<span class="required">*</span></label>
                                        <?php echo form_input(array('name'=>'billing_name', 'class'=>'form-control', 'id'=>'billing_name', 'value'=>set_value('billing_name'))); ?>
                                    </div>
                                    <div hidden class="form-group <?=form_error('billing_email') ? 'has-error' : ''?>">
                                        <label for="billing_email">Email</label>
                                        <?php echo form_input(array('name'=>'billing_email', 'class'=>'form-control', 'id'=>'billing_email', 'value'=>set_value('billing_email'))); ?>
                                    </div>
                                    <div class="form-group <?=form_error('billing_phone') ? 'has-error' : ''?>">
                                        <label for="billing_phone">Phone<span class="required">*</span></label>
                                        <?=form_input(array('name'=>'billing_phone', 'class'=>'form-control', 'id'=>'billing_phone', 'value'=>set_value('billing_phone')))?>
                                    </div>
                                    <div class="form-group shipping-address-group <?=form_error('shipping_address1') ? 'has-error' : ''?>">
                                        <label for="shipping_address1">Delivery Address<span class="required">*</span></label>
                                        <textarea class="form-control" rows="5" name="shipping_address1" id="shipping_address1"><?php echo set_value('shipping_address1'); ?></textarea>
                                    </div>

                                    <?=form_hidden('billing_address2', set_value('billing_address2'))?>
                                    <?=form_hidden('billing_postcode', set_value('billing_postcode'))?>
                                    <?=form_hidden('billing_city', set_value('billing_city'))?>
                                    <?=form_hidden('billing_state', set_value('billing_state'))?>
                                    <?=form_hidden('billing_country', 'Bangladesh')?>



                                    <?=form_hidden('shipping_name', set_value('shipping_name'))?>
                                    <?=form_hidden('shipping_address2', set_value('shipping_address2'))?>
                                    <?=form_hidden('shipping_postcode', set_value('shipping_postcode'))?>
                                    <?=form_hidden('shipping_city', set_value('shipping_city'))?>
                                    <?=form_hidden('shipping_state', set_value('shipping_state'))?>
                                </div>
                            </div>
                        </div>

                        <!-- Data Host -->

                        <div class="col-md-8">

                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Actions</h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group" id="order_area">
                                        <label>
                                            <input type="radio" name="order_area" value="inside_dhaka" checked> Inside Dhaka
                                        </label>

                                        <label>
                                            <input type="radio" name="order_area" value="outside_dhaka"> Outside Dhaka
                                        </label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Courier Service</label>
                                        <select name="courier_service" class="form-control" id="courier_service">
                                            <option value="" > Select Option</option>
                                            <?php
                                            foreach($couriers as $courier) {

                                            ?>
                                            <option <?php if($order->courier_service==$courier->id)  { echo "selected";} ?> value="<?=$courier->id?>" ><?=$courier->name?></option>

                                            <?php } ?>
                                        </select>

                                    </div>


                                    <div class="form-group col-md-6">
                                        <label>Order Status</label>
                                        <?php
                                        $status_option['new'] = 'In Riview';
                                        $status_option['processing'] = 'Processing';
                                        $status_option['ready'] = 'Ready';
                                        $status_option['send'] = 'Send';
                                        $status_option['delivered'] = 'Delivered';
                                        $status_option['cancled'] = 'Cancelled';
                                        $status_option['partly_delivered'] = 'Partly Delivered';
                                        $status_option['hold'] = 'Hold';
                                        $status_option['problems'] = 'Problems';
                                        $status_option['return_accept'] = 'Return Accept';


                                        $selected_status = set_value('order_status') ? set_value('order_status') : 'new';

                                        echo form_dropdown('order_status', $status_option, $selected_status, array('class'=>'form-control', 'id'=>'order_status'));
                                        ?>
                                    </div>
                                    <div class="form-group  col-md-6 <?=form_error('shipment_time') ? 'has-error' : ''?>">
                                        <label>Shipping Date</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="shipment_time" class="form-control pull-right" id="datepicker" value="<?=date('m/d/Y')?>">
                                        </div>
                                    </div>
                                    <div class="form-group  col-md-6 <?=form_error('shipment_time') ? 'has-error' : ''?>">
                                        <label> Exchange Note </label>


                                        <input type="text" name="order_product_note" class="form-control " id="order_product_note" value=" ">

                                    </div>
                                    <div class="form-group"> <label>Order Note</label> <textarea name="order_note" class="form-control"></textarea> </div>

                                    <div class="form-group col-md-12" style="display: flex;flex-direction: row;justify-content: space-around;align-items: baseline;">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="product_order_source" id="product_order_source" value="Facebook"   >
                                                Facebook
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="product_order_source" id="product_order_source" value="WhatsApp"   >
                                                WhatsApp
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="product_order_source" id="product_order_source" value="Cell"   >
                                                Cell
                                            </label>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>

                        <div class="col-md-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Order Info</h3>

                                    <?php

                                    $order_id = $this->session->flashdata('order_id');
                                    ?>

                                    <?php if(isset($order_id)) { ?>
                                    <a class="btn btn-success pull-right hidden-print" href="<?=base_url()?>order/single_invoice/<?=$order_id?>" onclick="myFunction()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</a>

                                    <?php } ?>

                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <select name="product_ids" id="product_ids" class="form-control select2" multiple="multiple" data-placeholder="Type... product name here..." style="width:100%;">
                                            <?=get_option_based_product(true,1);?>
                                        </select>
                                    </div>
                                    <span id="product_html"></span>
                                </div>
                            </div>

                            <div class="box-footer">
                                <?=form_hidden('shipping_charge_in_dhaka', get_option('shipping_charge_in_dhaka'))?>
                                <?=form_hidden('shipping_charge_out_of_dhaka', get_option('shipping_charge_out_of_dhaka'))?>
                                <?=form_hidden('submission_level', '1')?>
                                <?=form_hidden('created_by', 'office-staff')?>


                                <input type="hidden" name="staff_id" value="<?=$user_id?>">
                                <button type="submit" class="btn btn-primary"><?=$form_title?></button>
                            </div>

                        </div>
                        <!-- Data Host -->


                    </div>
                </form>











            </div>
        </div>
    </section>
</div>

<script>

    $("body").on('input','#shipping_charge',function(){
        var subtotal_price=$('#subtotal_price_sujon').text();
        var delivary_cost=parseInt($(this).val());
        var total_price=delivary_cost+parseInt(subtotal_price);
        $('#total_cost').text(total_price);
        $('#order_total').val(total_price);
    });
    $("body").on('input','#discount_price',function(){
        var discount_price=parseInt($(this).val());
        var subtotal_price=$('#subtotal_price_sujon').text();
        var shipping_charge=$('#shipping_charge').val();
        var total_price=parseInt(subtotal_price)+parseInt(shipping_charge);

        var total=parseInt(total_price)-discount_price;
        $('#total_cost').text(total);
        $('#order_total').val(total);
    });
    $("body").on('input','#advabced_price',function(){
        var advabced_price=parseInt($(this).val());
        var subtotal_price=$('#subtotal_price_sujon').text();
        var shipping_charge=$('#shipping_charge').val();
        var discount_price=parseInt($('#discount_price').val());

        var total_price=parseInt(subtotal_price)+parseInt(shipping_charge) - (discount_price+advabced_price);

        var total=parseInt(total_price)
        $('#total_cost').text(total);
        $('#order_total').val(total);
    });
</script>