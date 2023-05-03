@extends('admin.master')
@section('main',"Parcel")
@section('active',"Search Parcel")
@section('title',"Search Parcel")

@section('main-content')

    <style>
        .img-responsive {
            float: left;
            border: 2px solid #ddd;
        }

        .product-title {
            width: 100%;
            display: block;
            height: 30px;
            overflow: hidden;
        }
    </style>
    <section class="content">
        <div class="container-fluid" style="background:#fff;margin-bottom: 9px;">
            <form action="{{url('/')}}/admin/order/getSinglePercel" method="get">
                <div class="row">
                    <div class="col-6 col-lg-4" style="margin-top:12px">
                        <br/>
                        <input type="text" value="{{$name}}" name="parcel" id="parcel" class="form-control"
                               placeholder="Enter Tracking ID of Redex"/>
                    </div>

                    <div class="col-6 col-lg-3" style="margin-top:12px">
                        <br/>
                        <button type="submit"
                                class="btn btn-success btn-sm" name="submit" value="submit">
                            <i class="fas fa-search"></i> Parcel Search
                        </button>


                    </div>


                </div>
            </form>
        </div>
        <div class="row">

            <div class="col-12">

                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr style="text-align:center">


                                <th  width="2%"> SL</th>
                                <th style="text-align:left" width="45%">
                                   English Message
                                </th>
                                <th style="text-align:left" width="45%"> Bangla Message
                                </th>
                                <th  width="8%">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($result))

                                <?php $sel=0;?>
                                @for($i=$total_count-1;$i>=0;$i--)
                                    <tr><td>{{++$sel}}</td>
                                        <td>{{$result[$i]['message_en']}}</td>
                                        <td>{{$result[$i]['message_bn']}}</td>
                                        <td>

                                            <span class="badge badge-pill badge-success" style="font-size:18px">{{date("d-m-Y",strtotime($result[$i]['time']))}}</span>
                                            <br/>
                                             <span class="badge badge-pill badge-danger mt-1" style="font-size:18px">
                                                {{date("H:s:i a",strtotime($result[$i]['time']))}}</span>


                                        </td>
                                    </tr>
                                @endfor
                            @endif


                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

    </section>





@endsection