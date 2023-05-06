@extends('admin.master')
@section('main',"Order")
@section('active',"Update Order")
@section('title',"Update Order")
@section('main-content')
    <form action="{{url('/')}}/admin/order" method="post" id="order_form">
        @csrf
        
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="order_created_by" value="Manual"/> 
                        @include('admin.order.includes.customer_information')
                     </div>
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Product Information</h3>
                            </div>
                            <div class="card-body">
                                @include('admin.order.includes.product_meta_section')
                                  <div class="row mt-5">
                                    @include('admin.order.includes.payment_section')
                                    @include('admin.order.includes.sub_toal_section')
                                </div>
                                {{SaveUpdateButton()}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </form>

</section>
    @include('admin.order.includes.order_javascript_section')
@endsection