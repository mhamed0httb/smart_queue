



@extends('manager.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/manager')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/manager/basicConfiguration')}}">{{ $sub_page_title or 'Office config' }}</a></li>
        <li class="active">{{ $page_title or 'Edit' }}</li>
    </ol>

    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Add your config here</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ url('/manager/basicConfiguration/edit') }}" method="POST" id="form_create_manager">
                    {{csrf_field()}}
                    <div class="box-body">


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="opening_morning" class="col-sm-4 control-label">Opening morning</label>

                                <div class="col-sm-8 bootstrap-timepicker">
                                    <input type="text"  value="{{ $config->opening_time_morning }}" id="opening_morning" name="opening_morning" class="form-control timepicker">
                                </div>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="closing_morning" class="col-sm-4 control-label">Closing morning</label>

                                <div class="col-sm-8 bootstrap-timepicker">
                                    <input type="text" value="{{ $config->closing_time_morning }}" id="closing_morning" name="closing_morning" class="form-control timepicker">
                                </div>
                            </div>
                        </div>

                        <hr>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="opening_evening" class="col-sm-4 control-label">Opening evening</label>

                                <div class="col-sm-8 bootstrap-timepicker">
                                    <input type="text" value="{{ $config->opening_time_evening }}" id="opening_evening" name="opening_evening" class="form-control timepicker">
                                </div>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="closing_evening" class="col-sm-4 control-label">Closing evening</label>

                                <div class="col-sm-8 bootstrap-timepicker">
                                    <input type="text" value="{{ $config->closing_time_evening }}" id="closing_evening" name="closing_evening" class="form-control timepicker">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="capacity" class="col-sm-4 control-label">Capacity</label>

                                <div class="col-sm-8">
                                    <input type="number" name="capacity" value="{{ $config->capacity }}" class="form-control" id="capacity" placeholder="capacity" required>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" value="{{ $config->id }}" name="config_id">





                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info pull-right" id="btn_submit_form">Edit</button>
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

@section('scripts')
    <script>

        //Timepicker
        $(".timepicker").timepicker({
            showInputs: false,
        });
    </script>
    @if(Session::has('success'))
        <script>
            //$('#btn_modal_success').click()
            $('#div_alert').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-check"></i> SUCCESS!</h4>{{ Session::get('success') }}</div>');
            $('#div_alert').fadeIn();
            dismissAlertMessage();
        </script>
    @endif
    @if(Session::has('update'))
        <script>
            //$('#btn_modal_success').click()
            $('#div_alert').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-check"></i> UPDATE!</h4>{{ Session::get('update') }}</div>');
            $('#div_alert').fadeIn();
            dismissAlertMessage();
        </script>
    @endif
@endsection



