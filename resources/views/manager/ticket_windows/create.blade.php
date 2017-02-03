



@extends('manager.layouts.master')

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
                    <h3 class="box-title">Create Ticket Window</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ url('/manager/ticket_windows') }}" method="POST" id="form_create_manager">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="number" class="col-sm-2 control-label">Number</label>

                            <div class="col-sm-10">
                                <input type="number" name="number" class="form-control" id="number" placeholder="number" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="office_id" class="col-sm-2 control-label">Office</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="office_id" name="office_id" required>
                                    @foreach ($allOffices as $office)
                                        <option value="{{ $office->id }}">{{ $office->identifier }}</option>
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



