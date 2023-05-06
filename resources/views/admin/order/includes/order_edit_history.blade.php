<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Order Edit History</h3>
    </div>
    <div class="card-body">
        <label for="status">Add Note</label>
        <div class="input-group mb-3">
            <input type="text" id="order_note" class="form-control" placeholder="Add Notes">
            <div class="input-group-append">
                <button onclick="storeOrderEditHistory()" class="btn btn-success waves-effect waves-light" id="updateNote" type="button"><i class="fas fa-plus-circle"></i></button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Created At</th> 
                <th>Order Note</th>
            </tr>
            </thead>
            <tbody id="orderEditHistory">
            </tbody>
        </table>
    </div>
</div>
<script>

setTimeout( getAllOrderTrackHistory,300)
    function storeOrderEditHistory() {
        var order_note=$('#order_note').val();
        if($('#order_note').val().length > 0){
            $('#order_note').val('');
            $.ajax({
                url:"{{url('/')}}/admin/storeOrderEditHistory?order_id="+$('#order_id').val(),
                data:{order_note:order_note},
                success:function (data) {
                    getAllOrderTrackHistory();
                }
            })
        }
    }
    function getAllOrderTrackHistory() {
      var order_id=  $('#order_id').val();
        $.ajax({
            url:"{{url('/')}}/admin/getAllOrderTrackHistory?order_id="+order_id,
            success:function (data) {
                var html='';

                data.forEach((order_id,index)=>{

                    html +='<tr><td>'+order_id.created_at+'</td><td>'+order_id.notificaton+'</td></tr>';
            } )
                $("#orderEditHistory").html(html);
            }
        })
    }
</script>