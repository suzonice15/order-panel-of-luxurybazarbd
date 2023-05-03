
@extends('admin.master')
@section('main',"Dashboard")
@section('active',"Dashboard")
@section('title',"Dashboard")
@section('main-content')
<section class="content">
    <div class="container-fluid">
      
<div class="row" style="cursor: pointer;">


<div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Today Order</span>
                <span class="info-box-number">
                 {{$totay_orders}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Processing</span>
                <span class="info-box-number">
                 {{totalOrder('Processing')}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Payment Pending</span>
                <span class="info-box-number"> {{totalOrder('Payment Pending')}} </span>
             
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

           

  
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">On Hold</span>
                <span class="info-box-number">{{totalOrder('On Hold')}}  </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            
          </div> 
         
          

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending Invoiced</span>
                <span class="info-box-number">{{totalOrder('Pending Invoiced')}} </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Invoiced</span>
                <span class="info-box-number">{{totalOrder('Invoiced')}} </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Delivered</span>
                <span class="info-box-number">{{totalOrder('Delivered')}} </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
 
              <div class="info-box-content">
                <span class="info-box-text">Completed</span>
                <span class="info-box-number">{{totalOrder('Completed')}} </span>
              </div>
              <!-- /.info-box-content -->
            </div>            
          </div>

        </div>

     
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Canceled</span>
                <span class="info-box-number">{{totalOrder('Canceled')}} </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            
          </div>

        
    </div><!--/. container-fluid -->
</section>


    @endsection