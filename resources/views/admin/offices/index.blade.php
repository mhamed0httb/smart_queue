


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
                                        <a class="btn btn-warning col-xs-4">edit</a>

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
@endsection

