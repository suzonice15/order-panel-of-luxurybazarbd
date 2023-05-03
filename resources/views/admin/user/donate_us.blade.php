
@extends('admin.master')
@section('main',"Donate")
@section('active',"Donate")
@section('main-content')
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Donate  List</h3>
 

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
                        <th style="width: 20%">
                             Mobile
                        </th>
                        <th style="width: 30%">
                          Amount
                        </th>
                      
                        <th style="width: 15%" class="text-center">
                            Transaction ID
                        </th>
                        <!-- <th style="width: 20%">
                            Action
                        </th> -->
                    </tr>
                    </thead>
                    <tbody>

                    @if($donates)
                        @foreach($donates as $key=>$user)

                    <tr style="text-align: center" >

                        <td>{{++$key}}</td>


                        <td class="project_progress">
                            {{$user->name}}
                        </td>
                        <td class="project_progress">
                            {{$user->mobile}}
                        </td>
                        

                        <td class="project_progress">
                            {{$user->amount}}
                        </td>
                        <td class="project_progress">
                            {{$user->transaction_id}}
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