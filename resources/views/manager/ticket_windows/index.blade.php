


@extends('manager.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/manager')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/manager/ticket_windows')}}">{{ $sub_page_title or 'Ticket Windows' }}</a></li>
        <!--li-- class="active">{{ $page_title or null }}</li-->
    </ol>

    <!-- /.row -->
    <div class="row">
        <a class="btn btn-app" href="{{ url('/manager/ticket_windows/create') }}">
            <i class="fa fa-plus"></i> Add new
        </a>
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">List of All Ticket Windows</h3>

                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" id="input_search" class="form-control pull-right" placeholder="Search...">

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default" id="btn_clear_search"><i class="fa fa-close"></i></button>
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
                            <th>Action</th>
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
                                <td>
                                    <div class="row">
                                        <a class="btn btn-warning  pull-left" href="{{ url('/manager/ticket_windows/' . $window->id . '/edit') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            Edit</a>

                                        <a onclick="confirmDelete({{$window->id}})" class="btn btn-danger pull-left"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                            Delete</a>

                                        {{ Form::open(array('url' => 'manager/ticket_windows/' . $window->id, 'class' => 'pull-left col-xs-4', 'id' => 'form_delete')) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-danger hide ', 'id' => 'btn_delete'. $window->id] )  }}
                                        {{ Form::close() }}
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
        Launch modal
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


    <button class="hide modal-trigger" data-toggle="modal" data-target="#modal_success" href="#modal_success" id="btn_modal_success"></button>
    <div class="modal modal-success" id="modal_success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success</h4>
                </div>
                <div class="modal-body">
                    <p>{{ Session::get('status') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->




    <script>
        function deactivateWindow(id){
            $('#btn_dectivate_modal').click();
            $('#btn_deactivate_confirm').click(function() {
                window.location = '{{ url('manager/ticket_windows/deactivate') }}'+'/'+id;
            });
        }
    </script>
@endsection

@section('scripts')
    @if(Session::has('status'))
        <script>
            //$('#btn_modal_success').click()
            $('#div_alert').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-check"></i> SUCCESS!</h4>{{ Session::get('status') }}</div>');
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
    @if(Session::has('delete'))
        <script>
            //$('#btn_modal_success').click()
            $('#div_alert').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-check"></i> DELETE!</h4>{{ Session::get('delete') }}</div>');
            $('#div_alert').fadeIn();
            dismissAlertMessage();
        </script>
    @endif
    @if(Session::has('activate'))
        <script>
            //$('#btn_modal_success').click()
            $('#div_alert').html('<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <h4><i class="icon fa fa-info"></i> ONLINE!</h4>{{ Session::get('activate') }}</div>');
            $('#div_alert').fadeIn();
            dismissAlertMessage();
        </script>
    @endif
    @if(Session::has('deactivate'))
        <script>
            //$('#btn_modal_success').click()
            $('#div_alert').html('<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <h4><i class="icon fa fa-info"></i> OFFLINE!</h4>{{ Session::get('deactivate') }}</div>');
            $('#div_alert').fadeIn();
            dismissAlertMessage();
        </script>
    @endif


    <script>
        /*$("#input_search").on("keyup", function() {
            var value = $(this).val();

            $("table tr").each(function(index) {
                if (index !== 0) {

                    $row = $(this);

                    var id = $row.find("td:first").text();

                    if (id.indexOf(value) !== 0) {
                        $row.hide();
                    }
                    else {
                        $row.show();
                    }
                }
            });
        });*/






        $(document).ready(function()
        {
            $('#input_search').keyup(function()
            {
                searchTable($(this).val());
            });
        });

        function searchTable(inputVal)
        {
            var table = $('.table');
            table.find('tr').each(function(index, row)
            {
                var allCells = $(row).find('td');
                if(allCells.length != 0)
                {
                    var found = false;
                    allCells.each(function(index, td)
                    {
                        var regExp = new RegExp(inputVal, 'i');
                        if(regExp.test($(td).text()))
                        {
                            found = true;
                            return false;
                        }
                    });
                    if(found == true)$(row).show();else $(row).hide();
                }
            });
        }

        $('#btn_clear_search').click(function() {
            $('#input_search').val('');
            searchTable('');
        });

        function confirmDelete(id){
            swal({
                    title: "Are you sure?",
                    text: "This Ticket Window will be deleted permanently!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        swal("Deleted!", "Ticket Window has been deleted.", "success");
                        $('#btn_delete'+id).click();
                    } else {
                        //swal("Cancelled", "Your imaginary file is safe :)", "error");

                    }
                });
        }
    </script>
@endsection

