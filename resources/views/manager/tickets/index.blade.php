


@extends('manager.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/manager')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/manager/tickets') }}">{{ $sub_page_title or 'Tickets' }}</a></li>
        <li class="active">{{ $page_title or 'Today' }}</li>
    </ol>

    <!-- /.row -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">List of All Tickets Served Today</h3>

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
                            <th>Ticket Number</th>
                            <th>Office</th>
                            <th>Staff Member</th>
                            <th>Service</th>
                            <th>Date Creation</th>
                            <th>Date Served</th>
                            <th>Status</th>
                            <!--th>Status</th>
                            <th>Reason</th-->
                        </tr>
                        @foreach ($allTickets as $ticket)
                            <tr>
                                <td>{{ $ticket->number }} </td>
                                <td>
                                    {{ $ticket->getOffice->identifier }}
                                </td>
                                <td>
                                    {{ $ticket->getTicketWindow->getStaff->first_name or null }} {{ $ticket->getTicketWindow->getStaff->last_name or null }}
                                </td>
                                <td>
                                    {{ $ticket->getTicketWindow->getService->name or null }}
                                </td>
                                <td>{{ $ticket->created_at }}</td>
                                <td>
                                    @if($ticket->expired == true )
                                        {{ $ticket->updated_at }}
                                    @endif
                                </td>

                                <td>
                                    <div class="row">
                                        @if($ticket->status == 'waiting' )
                                            <a href="#">
                                                <i class="fa fa-circle-o text-red"></i>
                                                <span> Waiting</span>
                                            </a>
                                        @elseif($ticket->status == 'in_service')
                                            <a href="#">
                                                <i class="fa fa-circle-o text-yellow"></i>
                                                <span> In Service</span>
                                            </a>
                                            @else
                                            <a href="#">
                                                <i class="fa fa-circle-o text-green"></i>
                                                <span> Served</span>
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
@section('scripts')
    <script>
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
    </script>
@endsection

