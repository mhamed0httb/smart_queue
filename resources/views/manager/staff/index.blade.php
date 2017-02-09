


@extends('manager.layouts.master')

@section('content')
        <div class='row'>
                <div class='col-md-12'>
                        <!-- Box -->
                        <div class="box box-primary">
                                <div class="box-header with-border">
                                        <h3 class="box-title">All staff members</h3>
                                        <div class="box-tools pull-right">
                                                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                                        </div>
                                </div>
                                <div class="box-body">
                                        <ul>
                                                @foreach ($allStaff as $staff)
                                                        <li>{{ $staff->first_name }} {{ $staff->last_name }} </li>
                                                @endforeach
                                        </ul>


                                        <a href="{{url('/manager/staffs/create')}}">add new Staff member</a>


                                </div><!-- /.box-body -->

                                </div><!-- /.box-footer-->
                        </div><!-- /.box -->
                </div><!-- /.col -->

        </div><!-- /.row -->
@endsection
