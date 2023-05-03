


<table class="table table-bordered">
    <tr>
        <th>Sl</th>
        <th>Name</th> 
        <th>Note</th>
        <th>Date</th>
        <th>Time</th>
    </tr>

    <?php
    if($orders) {
    $count=0;
    foreach ($orders as $order ){
    ?>
    <tr>
        <td><?=++$count?></td>
        <td>{{getUserName($order->user_id)}}</td> 
        <td>{{$order->notificaton}}</td> 
        <td>{{date('d-m-Y',strtotime($order->updated_at))}}</td>
        <td>{{date('h:i a',strtotime($order->updated_at))}}</td>
    </tr>

    <?php } } ?>
</table>