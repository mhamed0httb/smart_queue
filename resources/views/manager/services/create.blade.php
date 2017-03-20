
@extends('manager.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/manager')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/manager/services')}}">{{ $sub_page_title or 'Services' }}</a></li>
        <li class="active">{{ $page_title or 'Create' }}</li>
    </ol>

    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Service</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ url('/manager/services') }}" method="POST" id="form_create_manager">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Service Name</label>

                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="name" placeholder="name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_id" class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="category_id" name="category_id" required>
                                    @foreach ($allCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-primary modal-trigger" data-toggle="modal" data-target="#modal_create_category" href="#modal_create_category" >Add new Category</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info pull-right" id="btn_submit_form">Create</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (right) -->

    </div>
    <!-- /.row -->


    <div class="modal" id="modal_create_category">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create new Category</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Category Name</label>

                            <div class="col-sm-8">
                                <input type="text" name="region_name" class="form-control" id="category_name" placeholder="category name..." required>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="btn_close_modal_create_category">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addCategory()">Create</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


@endsection

@section('scripts')
    <script>
        function addCategory(){
            var regionName = $('#category_name').val();
            $.get('{{ url('api/categories/create') }}'+'?name='+regionName, function(data) {
                //var obj = jQuery.parseJSON(data);
                $('#category_id').append('<option value="'+data.id+'">'+data.name +'</option>');
                $('#btn_close_modal_create_category').click();
                $('#div_alert').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-check"></i> SUCCESS!</h4>The new Category has been successfully added.</div>');
                $('#div_alert').fadeIn();
                dismissAlertMessage();
            });
            $('#btn_close_modal_create_region').click();
        }
    </script>
@endsection


