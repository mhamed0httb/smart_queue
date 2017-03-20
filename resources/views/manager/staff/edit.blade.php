



@extends('manager.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/manager')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/manager/staffs')}}">{{ $sub_page_title or 'Staff' }}</a></li>
        <li class="active">{{ $page_title or 'Edit' }}</li>
    </ol>

    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit staff Member : {{ $member->first_name . ' ' . $member->last_name }}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{ Form::model($member, array('route' => array('staffs.update', $member->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
                <div class="box-body">
                    <div class="form-group">
                        {{ Form::label('first_name', 'First Name', array('class' => 'col-sm-2 control-label', 'for' => 'first_name')) }}

                        <div class="col-sm-10">
                            {{ Form::text('first_name', null, array('class' => 'form-control','value' => $member->first_name,'placeholder' => 'first name', 'name' => 'first_name', 'id' => 'first_name', 'required' => 'true')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('last_name', 'Last Name', array('class' => 'col-sm-2 control-label', 'for' => 'last_name')) }}

                        <div class="col-sm-10">
                            {{ Form::text('last_name', null, array('class' => 'form-control','value' => $member->last_name,'placeholder' => 'last name', 'name' => 'last_name', 'id' => 'last_name', 'required' => 'true')) }}
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



