
@extends('admin.master')
@section('main',"Admin User")
@section('active',"Admin User")
@section('main-content')
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Admin User  Data</h3>
                        </div>

                        <form action="{{url('admin/user/update')}}/{{$user->admin_id}}" method="post">
                            @csrf

                            <div class="card-body">
                                <div class="form-group">
                                    <label  >Name  </label>
                                    <input type="text" name="name" value="{{$user->name}}" class="form-control"   placeholder="Enter Name">
                                </div>
                                <div class="form-group">
                                    <label  >Email address</label>
                                    <input type="email" class="form-control"    name="email"  value="{{$user->email}}" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label  >Phone  </label>
                                    <input type="text" class="form-control"    name="user_phone"  value="{{$user->user_phone}}" placeholder="Enter Phone">
                                </div>
                                <div class="form-group">
                                    <label  >Status  </label>
                                    <select name="status" class="form-control">
                                        <option value="super-admin">Super-admin</option>
                                        <option value="admin">admin</option>
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password"  name="password" class="form-control"  placeholder="Password">
                                </div>


                            </div>


                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->



                </div>

            </div>
            <!-- /.row -->
        </div>




    </section>



@endsection