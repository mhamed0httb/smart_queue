



@extends('admin.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/manager')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">{{ $sub_page_title or 'Sub Page Title' }}</a></li>
        <li class="active">{{ $page_title or 'Page Title' }}</li>
    </ol>

    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Office</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ url('/dashboard/offices') }}" method="POST" id="form_create_manager">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="identifier" class="col-sm-2 control-label">Identifier</label>

                            <div class="col-sm-10">
                                <input type="text" name="identifier" class="form-control" id="identifier" placeholder="identifier" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="region_id" class="col-sm-2 control-label">Region</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="region_id" name="region_id" required>
                                    @foreach ($allRegions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="manager_id" class="col-sm-2 control-label">Manager</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="manager_id" name="manager_id" required>
                                    @foreach ($allManagers as $manager)
                                        <option value="{{ $manager->id }}">{{ $manager->first_name }} {{ $manager->last_name }}</option>
                                    @endforeach
                                </select>
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



