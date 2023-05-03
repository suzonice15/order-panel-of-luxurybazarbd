
@extends('admin.master')
@section('main',"Admin User")
@section('active',"Admin User")
@section('main-content')
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Admin User List</h3>
                <a href="{{url('/')}}/admin/user/create" class="btn btn-success btn-sm   "  style="float:right"><i class="fa fa-plus"></i> Add New User</a>


            </div>
            <div class="card-body p-0">
                <table class="table table-bordered projects">
                    <thead>
                    <tr style="text-align: center">
                        <th style="width: 1%">
                           Sl
                        </th>
                        <th style="width: 20%">
                             Name
                        </th>
                        <th style="width: 30%">
                          Email
                        </th>
                      
                        <th style="width: 15%" class="text-center">
                            Status
                        </th>
                        <th style="width: 20%">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @if($users)
                        @foreach($users as $key=>$user)

                    <tr style="text-align: center" id="user_id{{$user->admin_id}}">

                        <td>{{++$key}}</td>


                        <td class="project_progress">
                            {{$user->name}}
                        </td>
                        <td class="project_progress">
                            {{$user->email}}
                        </td>
                       

                        <td class="project-state">
                              <span class="badge badge-success btn-sm">{{$user->status}}</span>
                        </td>
                        <td class="project-actions text-right">

                            <!-- <a class="btn btn-info btn-sm" href="{{url('/admin/user/')}}/{{$user->admin_id}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                                Edit
                            </a> -->
                            <a  onClick="return confirm('are you want to delete ?')" class="btn btn-danger btn-sm " href="{{url('/')}}/admin/user/delete/{{ $user->admin_id }}">
                                <i class="fas fa-trash">
                                </i>
                                Delete
                            </a>
                        </td>
                    </tr>
                    @endforeach
                     @endif

            <tbody>
                    </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>

 
    

@endsection