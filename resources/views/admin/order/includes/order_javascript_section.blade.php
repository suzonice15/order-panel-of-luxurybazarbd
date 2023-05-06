<?php
$payment_type_id =isset($order->payment_type_id) ? $order->payment_type_id:'';
$payment_id =isset($order->payment_id) ? $order->payment_id:'';
 ?>
<script>
   @if($payment_type_id > 0)
   getPaymentsNumber({{$payment_type_id}})
    @endif

    function getOrderMeta(product_id) {
        $.ajax({
            url: "{{url('/')}}/admin/getOrderMeta?product_id=" + product_id,
            success: function (html) {
                $("#product_meta").append(html);
                subtotalGenerate();
            }
        })
    }
    getAllProductsForOrder();
    getPaymentMethod();
    function getAllProductsForOrder() {
        $.ajax({
            url: "{{url('/')}}/admin/getAllProductsForOrder",
            success: function (data) {
                var html = '';
                data.forEach((product, index) => {
                    html += '<option value="' + product.id + '">' + product.productName + ' ( ' + product.productCode + ' ) ' + '</option>';
            } )
                $("#product_ids").html(html);
            }
        })
    }
    function getPaymentMethod() {
        $.ajax({
            url: "{{url('/')}}/admin/getPaymentMethod",
            success: function (data) {
                console.log(data)
                var html = '<option value="">--Select Option---</option>';
                data.forEach((payment, index) => {
                    html += '<option value="' + payment.id + '">' + payment.paymentTypeName+ '</option>';
            } )
                $("#paymentTypeID").html(html);
                $("#paymentTypeID").val(<?=$payment_type_id?>);
            }
        })
    }
    function getPaymentsNumber(payment_type) {
        $.ajax({
            url: "{{url('/')}}/admin/getPaymentsNumber?payment_type="+payment_type,
            success: function (data) {
                var html = '<option value="">--Select Option---</option>';
                data.forEach((payment, index) => {
                    html += '<option value="' + payment.id + '">' + payment.paymentNumber+ '</option>';
            } )
                $("#paymentID").html(html);
                $("#paymentID").val(<?=$payment_id?>);
            }
        })
    }


    $(document).on('input change', '.quantity', function () {
        let id = this.id
        let quantity = this.value
        let price = parseInt($("#price_" + id).text());
        let subtotal = price * quantity;
        $("#sub_total_product_" + id).text(subtotal);
        subtotalGenerate();
    })
    function subtotalGenerate() {
        let sum = 0;
        $('.sub_total_product').each(function () {
            sum += parseFloat($(this).text());
        });
        $("#subtotal").text(sum);
        totalGenerate()
    }
   subtotalGenerate()
    function totalGenerate() {
        let subtotal = parseInt($("#subtotal").text());
        let deliveryCharge = parseInt($("#deliveryCharge").val());
        let discountCharge = parseInt($("#discountCharge").val());
        let paymentAmount = parseInt($("#paymentAmount").val());
        deliveryCharge = isNaN(deliveryCharge) ? 0 : deliveryCharge;
        discountCharge = isNaN(discountCharge) ? 0 : discountCharge;
        paymentAmount = isNaN(paymentAmount) ? 0 : paymentAmount;
        let total = (subtotal + deliveryCharge) - (discountCharge + paymentAmount);
        $("#total").text(total);
        $("#subTotal").val(total);
    }
    $("body").on('input', '#deliveryCharge , #discountCharge , #paymentAmount ', function () {
        totalGenerate()
    });
    $(document).on('click', '.delete-product', function(e){
       let confirm_status= confirm('Are you want to remove this product ?');
       if(confirm_status){
        $(this).closest('tr').remove()
        subtotalGenerate()
       }
      
    })
</script>