


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
                            <!--th>Date Creation</th-->
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
                                <!--td>{{ $window->created_at }}</td-->
                                <td>
                                    <div class="row">
                                        @if($window->status == 'Offline' )
                                        <a href="{{url('/manager/ticket_windows/'.$window->id)}}">
                                            <i class="fa fa-circle-o text-red"></i>
                                            <span>{{ $window->status }}</span>
                                        </a>
                                        @else
                                            <a href="#" onclick="deactivateWindow({{$window->id}})">
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





    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg hide" data-toggle="modal" data-target="#modal_deactivate" id="btn_dectivate_modal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modal_deactivate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Deactivate Ticket Window</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to make this window offline ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="btn_deactivate_confirm">Update</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deactivateWindow(id){
            $('#btn_dectivate_modal').click();
            $('#btn_deactivate_confirm').click(function() {
                window.location = '{{ url('manager/ticket_windows/deactivate') }}'+'/'+id;
            });
        }
    </script>
@endsection

