


@extends('admin.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/dashboard/offices')}}">{{ $sub_page_title or 'Offices' }}</a></li>
        <!--li class="active">{{ $page_title or null }}</li-->
    </ol>

    <!-- /.row -->
    <div class="row">
        <a class="btn btn-app" href="{{ url('/dashboard/offices/create') }}">
            <i class="fa fa-plus"></i> Add new office
        </a>
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">List of All Offices</h3>

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
                            <th>Identifier</th>
                            <th>Region</th>
                            <th>Manager responsible</th>
                            <th>Date Creation</th>
                            <th>Action</th>
                            <!--th>Status</th>
                            <th>Reason</th-->
                        </tr>
                        @foreach ($allOffices as $office)
                            <tr>
                                <td>{{ $office->identifier }}</td>
                                <td>{{ $office->getRegion->name }}</td>
                                <td>
                                    @if($office->manager_id == 0)
                                        Not Yet Assigned
                                        <a class="modal-trigger btn btn-primary" data-toggle="modal" data-target="#modal_assign_manager" href="#modal_assign_manager" id="btn_modal_assign_manager">Assign</a>
                                    @else
                                        {{ $office->getManager->first_name or null }}
                                        {{ $office->getManager->last_name or null }}
                                    @endif
                                </td>
                                <td>{{ $office->created_at }}</td>
                                <td>
                                    <div class="row">
                                        <a class="btn btn-warning  pull-left" href="{{ url('/dashboard/offices/' . $office->id . '/edit') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                             Edit</a>
                                        &nbsp
                                    <!--a onclick="deleteOffice({{$office->id}})" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                            Delete</a-->

                                        <a onclick="confirmDelete({{$office->id}})" class="btn btn-danger pull-left"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                            Delete</a>

                                        {{ Form::open(array('url' => 'dashboard/offices/' . $office->id, 'class' => 'pull-left col-xs-4', 'id' => 'form_delete')) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-danger hide ', 'id' => 'btn_delete'. $office->id] )  }}
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


    <button class="hide modal-trigger" data-toggle="modal" data-target="#modal_assign_manager" href="#modal_assign_manager" id="btn_modal_assign_manager"></button>
    <div class="modal" id="modal_assign_manager">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Default Modal</h4>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->




    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg hide" data-toggle="modal" data-target="#modal_delete" id="btn_delete_modal">
        Launch modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Delete office</h4>
                </div>
                <div class="modal-body" id="modal_delete_body">
                    Are you sure you want to delete this office ?



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="btn_delete_confirm">Delete</button>
                    {{ Form::open(array('url' => 'dashboard/offices/', 'class' => 'pull-right hide', 'id' => 'form_delete')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete this office', array('class' => 'btn btn-danger', 'data-dismiss' => "modal", 'id' => 'btn_form_delete')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>


    <div id="div_alert" style="position: fixed; top: 10%; right: 0%"></div>

@endsection

@section('scripts')
    @if(Session::has('success'))
        <script>
            //$('#btn_modal_success').click()
            $('#div_alert').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-check"></i> SUCCESS!</h4>{{ Session::get('success') }}</div>');
        </script>
    @endif
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

       function confirmDelete(id){
           swal({
                   title: "Are you sure?",
                   text: "This Office will be deleted permanently!",
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
                       swal("Deleted!", "Office file has been deleted.", "success");
                       $('#btn_delete'+id).click();
                   } else {
                       //swal("Cancelled", "Your imaginary file is safe :)", "error");

                   }
               });
       }
    </script>


@endsection

