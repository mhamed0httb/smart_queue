


@extends('admin.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/dashboard/manager')}}">{{ $sub_page_title or 'Managers' }}</a></li>
        <!--li-- class="active">{{ $page_title or null }}</li-->
    </ol>

    <!-- /.row -->
    <div class="row">
        <div class="col-xs-12">
            <a class="btn btn-app" href="{{ url('/dashboard/manager/create') }}">
                <i class="fa fa-plus"></i> Add new
            </a>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">List of Managers we work with</h3>

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
                            <th>ID</th>
                            <th>User</th>
                            <th>Company</th>
                            <th>Date Creation</th>
                            <th>Action</th>
                            <!--th>Status</th>
                            <th>Reason</th-->
                        </tr>
                        @foreach ($allManagers as $manager)
                            <tr>
                                <td>{{ $manager->id }}</td>
                                <td>{{ $manager->first_name }}</td>
                                <td>{{ $manager->getCompany->name }}</td>
                                <td>{{ $manager->created_at }}</td>
                                <td>
                                    <a class="btn btn-warning  pull-left" href="{{ url('/dashboard/manager/' . $manager->id . '/edit') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        Edit</a>
                                    <a onclick="confirmDelete({{$manager->id}})" class="btn btn-danger pull-left"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                        Delete</a>

                                    {{ Form::open(array('url' => 'dashboard/manager/' . $manager->id, 'class' => 'pull-left col-xs-4', 'id' => 'form_delete')) }}
                                    {{ Form::hidden('_method', 'DELETE') }}
                                    {{ Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-danger hide ', 'id' => 'btn_delete'. $manager->id] )  }}
                                    {{ Form::close() }}
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

        function confirmDelete(id){
            swal({
                    title: "Are you sure?",
                    text: "This Manager will be deleted permanently !",
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
                        swal("Deleted!", "Manager has been deleted.", "success");
                        $('#btn_delete'+id).click();
                    } else {
                        //swal("Cancelled", "Your imaginary file is safe :)", "error");

                    }
                });
        }
    </script>
@endsection

