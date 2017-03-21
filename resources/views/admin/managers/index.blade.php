


@extends('admin.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/dashboard/manager')}}">{{ $sub_page_title or 'Managers' }}</a></li>
        <!--li-- class="active">{{ $page_title or null }}</li-->
    </ol>

    <!-- /.row -->
    <div class="row">
        <div class="col-xs-12">
            <a class="btn btn-app" href="{{ url('/dashboard/manager/create') }}">
                <i class="fa fa-plus"></i> Add new
            </a>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">List of Managers we work with</h3>

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
                            <th>ID</th>
                            <th>User</th>
                            <th>Date Creation</th>
                            <th>Action</th>
                            <!--th>Status</th>
                            <th>Reason</th-->
                        </tr>
                        @foreach ($allManagers as $manager)
                            <tr>
                                <td>{{ $manager->id }}</td>
                                <td>{{ $manager->first_name }}</td>
                                <td>{{ $manager->created_at }}</td>
                                <td>
                                    <a class="btn btn-warning">edit</a>
                                    <a class="btn btn-danger">delete</a>
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

