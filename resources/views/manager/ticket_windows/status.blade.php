



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
                    <h3 class="box-title">Activate Ticket Window Number {{ $window->number }} - </h3>
                    <small>
                        Office :
                        @foreach($allOffices as $office)
                            @if($office->id == $window->office_id)
                                {{ $office->identifier }}
                            @endif
                        @endforeach
                    </small>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ url('/manager/ticket_windows/update_status') }}" method="POST" id="form_create_manager">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$window->id}}" name="window_id">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="staff_id" class="col-sm-2 control-label">staff Member</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="staff_id" name="staff_id" required>
                                    @foreach ($allStaffs as $member)
                                        <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="service_id" class="col-sm-2 control-label">Service</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="service_id" name="service_id" required>
                                    @foreach ($allServices as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info pull-right" id="btn_submit_form">Update</button>
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



