


@extends('admin.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">{{ $sub_page_title or null }}</a></li>
        <li class="active">{{ $page_title or null }}</li>
    </ol>

    <!-- /.row -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">List of All Services</h3>

                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>Service</th>
                            <th>Category</th>
                            <th>Belongs To</th>
                            <th>Date Creation</th>
                            <th>Action</th>
                            <!--th>Status</th>
                            <th>Reason</th-->
                        </tr>
                        @foreach ($allServices as $service)
                            <tr>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->getCategory->name }}</td>
                                <td>{{ $service->getCompany->name }}</td>
                                <td>{{ $service->created_at }}</td>
                                <td>
                                    <div class="row">
                                        <a class="btn btn-warning col-xs-4">edit</a>
                                        <form class="col-xs-4" action="{{url('/dashboard/services/'.$service->id)}}" method="DELETE">
                                            <input type="hidden" name="delete" value="{{$service->id}}">
                                            <button class="btn btn-danger" type="submit">delete</button>
                                        </form>
                                    </div>

                                </td>
                                <!--td><span class="label label-success">Approved</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td-->
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->
@endsection

