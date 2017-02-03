
@extends('admin.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">{{ $sub_page_title or 'Sub Page Title' }}</a></li>
        <li class="active">{{ $page_title or 'Page Title' }}</li>
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
                <form class="form-horizontal" action="{{ url('/dashboard/services') }}" method="POST" id="form_create_manager">
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
                                <a class="btn btn-primary" href="{{url('/dashboard/vategories/create')}}">Add new Category</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company_id" class="col-sm-2 control-label">Company</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="company_id" name="company_id" required>
                                    @foreach ($allCompanies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-primary" href="{{url('/dashboard/companies/create')}}">Add new Company</a>
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


@endsection


