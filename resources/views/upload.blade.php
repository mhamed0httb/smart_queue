



@extends('admin.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/dashboard/regions')}}">{{ $sub_page_title or 'Regions' }}</a></li>
        <li class="active">{{ $page_title or 'Create' }}</li>
    </ol>

    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Region</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form  enctype="multipart/form-data"  class="form-horizontal" action="{{ url('/upload') }}" method="POST" id="form_create_manager">
                    {{csrf_field()}}
                    <div class="box-body">

                        <div class="form-group">
                            <label for="exampleInputFile" class="col-sm-2 control-label">File input</label>

                            <div class="col-sm-10">
                                <input class="form-control" id="avatar" name="avatar" type="file" required>
                            </div>


                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info pull-right" id="btn_submit_form">Upload</button>
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



