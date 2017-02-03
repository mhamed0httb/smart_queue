


@extends('manager.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">{{ $sub_page_title or null }}</a></li>
        <li class="active">{{ $page_title or null }}</li>
    </ol>

    <!-- /.row -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">List of All Ticket Windows</h3>

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
                            <th>Window Number</th>
                            <th>Office</th>
                            <th>Staff Member</th>
                            <th>Service</th>
                            <th>Date Creation</th>
                            <th>Status</th>
                            <!--th>Status</th>
                            <th>Reason</th-->
                        </tr>
                        @foreach ($allTicketWindows as $window)
                            <tr>
                                <td>{{ $window->number }} </td>
                                <td>
                                    {{ $window->getOffice->identifier }}
                                </td>
                                <td>
                                    {{ $window->getStaff->first_name or null }} {{ $window->getStaff->last_name or null }}
                                </td>
                                <td>
                                    {{ $window->getService->name or null }}
                                </td>
                                <td>{{ $window->created_at }}</td>
                                <td>
                                    <div class="row">
                                        @if($window->status == 'Offline' )
                                        <a href="{{url('/manager/ticket_windows/'.$window->id)}}">
                                            <i class="fa fa-circle-o text-red"></i>
                                            <span>{{ $window->status }}</span>
                                        </a>
                                        @else
                                            <a href="#">
                                                <i class="fa fa-circle-o text-green"></i>
                                                <span>{{ $window->status }}</span>
                                            </a>
                                        @endif
                                    </div>
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

