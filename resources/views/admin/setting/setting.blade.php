
@extends('admin.master')
@section('main',"Setting")
@section('active',"Update Setting")
@section('main-content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-defualt">
            <div class="card-header">
                <h3 class="card-title">Setting Update Form</h3>
                <div class="card-tools"></div>
            </div>
            <form action="{{url('/')}}/admin/setting" method="post" name="setting" enctype="multipart/form-data">
            @csrf
                <div class="card-body">
                    <div class="card card-info">
                        <div class="card-header"><h6> Default Setting   Information</h6></div>
                        <div class="row">
                            <div class="col-md-11 col-sm-12 pl-4 mt-2">
                                                 
                                <div class="form-group">
                                    <label for="product_video">Status</label>
                                    <select name="donate_active" class="form-control" >
                                    <option value="">Select</option>
                                        <option value="1">Active</option>
                                        <option value="0">In Active</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                <input type="submit" value="Save" class="btn btn-success btn-sm" >
                                </div>


                            </div>
                           
                    </div>
                
                       
                    </div>
                
                  
                </div>
            </form>
        </div>
    </div>
</section>  
 
<script>
    document.forms['setting'].elements['donate_active'].value={{$setting->donate_active}}

 </script>

    @endsection