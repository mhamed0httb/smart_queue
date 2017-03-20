



@extends('manager.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/manager')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/manager/staffs')}}">{{ $sub_page_title or 'Staff' }}</a></li>
        <li class="active">{{ $page_title or 'Create' }}</li>
    </ol>

    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Create staff Member</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ url('/manager/staffs') }}" method="POST" id="form_create_manager">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="first_name" class="col-sm-2 control-label">First Name</label>

                            <div class="col-sm-10">
                                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="first name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-sm-2 control-label">Last Name</label>

                            <div class="col-sm-10">
                                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="last name" required>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info pull-right" id="btn_submit_form">Create</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (right) -->

    </div>
    <!-- /.row -->


@endsection



