
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
                            <h3 class="card-title">Add New Admin User</h3>
                        </div>

                        <form action="{{url('admin/user/create')}}" method="post">
                            @csrf

                            <div class="card-body">
                                <div class="form-group">
                                    <label  >Name  </label>
                                    <input type="text" name="name" required class="form-control"   placeholder="Enter Name">
                                </div>
                                <div class="form-group">
                                    <label  >Email address</label>
                                    <input type="email" class="form-control" required   name="email"   placeholder="Enter email">
                                </div>
                             
                                
                                <div class="form-group">
                                    <label  >Status  </label>
                                    <select name="status" class="form-control">
                                        <option value="super-admin">Super-admin</option>
                                        <option value="admin">admin</option>
                                        <option value="editor">Editor</option>

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