
@extends('admin.master')
@section('main',"Dashboard")
@section('active',"Dashboard")
@section('title',"Dashboard")
@section('main-content')
<section class="content"> 
<div class="row mb-2 mt-0">
<div class="col-md-9">

</div>
  <div class="col-md-3">
  <input type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" id="orderDate"  name="orderDate"/>
  </div>
</div>

<span id="set_data">
@include('admin.ajax_dashboard')
</span>
   
</section>

<script>
  $("#orderDate").change(function(){
     let orderDate=$(this).val();
     $.ajax({
        url:"{{url('/')}}/admin/dashboard",
        data:{orderDate:orderDate},
        success:function(data){
          console.log(data)
          $("#set_data").empty();
          $("#set_data").html(data)
        }
     })
  });
   
</script>


    @endsection