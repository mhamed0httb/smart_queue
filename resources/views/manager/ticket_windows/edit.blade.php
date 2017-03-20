



@extends('manager.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/manager')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/manager/ticket_windows')}}">{{ $sub_page_title or 'Ticket Windows' }}</a></li>
        <li class="active">{{ $page_title or 'Edit' }}</li>
    </ol>

    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Ticket Window number : {{ $window->number }}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{ Form::model($window, array('route' => array('ticket_windows.update', $window->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}

                    <div class="box-body">
                        <div class="form-group">
                            <label for="number" class="col-sm-2 control-label">Number</label>

                            <div class="col-sm-10">
                                <input type="number" name="number" class="form-control" id="number" placeholder="number" required>
                            </div>
                        </div>


                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        {{ Form::submit('Edit', array('class' => 'btn btn-info pull-right')) }}
                    </div>
                    <!-- /.box-footer -->
                {{ Form::close() }}
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (right) -->

    </div>
    <!-- /.row -->


@endsection



