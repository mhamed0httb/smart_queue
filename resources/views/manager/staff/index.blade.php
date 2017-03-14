


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
                <a class="btn btn-app" href="{{ url('/manager/staffs/create') }}">
                        <i class="fa fa-plus"></i> Add new
                </a>
                <div class="col-xs-12">
                        <div class="box">
                                <div class="box-header">
                                        <h3 class="box-title">List of All staff members</h3>

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
                                                        <th>First name</th>
                                                        <th>Last name</th>
                                                        <th>Action</th>
                                                </tr>
                                                @foreach ($allStaff as $staff)
                                                        <tr>
                                                                <td>{{ $staff->first_name }}  </td>
                                                                <td>{{ $staff->last_name }}</td>
                                                                <td>
                                                                        <!--a class="btn btn-warning">Edit</a-->
                                                                        <a href="{{ url('/manager/statistics/staff/' . $staff->id) }}" class="btn btn-warning"><i class="fa fa-bar-chart" aria-hidden="true"></i>
                                                                             Stats</a>
                                                                        <a onclick="deleteMember({{$staff->id}})" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>
                                                                             Delete</a>
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
        <button type="button" class="btn btn-primary btn-lg hide" data-toggle="modal" data-target="#modal_delete" id="btn_delete_modal">
                Launch modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Delete staff member</h4>
                                </div>
                                <div class="modal-body">
                                        Are you sure you want to delete this staff member ?
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger" id="btn_delete_confirm">Delete</button>
                                        {{ Form::open(array('url' => '/manager/staffs/', 'class' => 'pull-right hide', 'id' => 'form_delete')) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::submit('Delete this member', array('class' => 'btn btn-danger', 'data-dismiss' => "modal")) }}
                                        {{ Form::close() }}
                                </div>
                        </div>
                </div>
        </div>
@endsection

@section('scripts')
<script>
    function deleteMember(id){
        $('#btn_delete_modal').click();
        $('#form_delete').attr('url', '/manager/staffs/' . id);
        $('#btn_delete_confirm').click(function() {
            $('#form_delete').submit();
        });
    }



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
