


@extends('admin.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/dashboard/companies')}}">{{ $sub_page_title or 'Companies' }}</a></li>
        <li class="active">{{ $page_title or 'Edit' }}</li>
    </ol>

    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit company : {{ $company->name }}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{ Form::model($company, array('route' => array('companies.update', $company->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>

                            <div class="col-sm-10">
                                <input type="text" value="{{ $company->name }}" name="name" class="form-control" id="name" placeholder="Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="identifier" class="col-sm-2 control-label">Identifier</label>

                            <div class="col-sm-10">
                                <input type="text" value="{{ $company->identifier }}" name="identifier" class="form-control" id="identifier" placeholder="identifier" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category" class="col-sm-2 control-label">Category</label>

                            <div class="col-sm-10">
                                <input type="text" value="{{ $company->category }}" name="category" class="form-control" id="category" placeholder="category" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description</label>

                            <div class="col-sm-10">
                                <input type="text" value="{{ $company->description }}" name="description" class="form-control" id="description" placeholder="description" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>

                            <div class="col-sm-10">
                                <input type="email" value="{{ $company->email }}" name="email" class="form-control" id="email" placeholder="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Phone</label>

                            <div class="col-sm-10">
                                <input type="number" value="{{ $company->phone }}" name="phone" class="form-control" id="phone" placeholder="phone" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">Address</label>

                            <div class="col-sm-10">
                                <input type="text" value="{{ $company->address }}" name="address" class="form-control" id="address" placeholder="address" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Responsible</label>

                            <div class="col-sm-5 col-sm-offset-1">
                                <div class="box-body" style="color: grey">
                                    <div class="form-group">
                                        <label for="responsible_name">Responsible Name</label>
                                        <input type="text" value="{{ $company->responsible->name }}" class="form-control" name="responsible_name" id="responsible_name" placeholder="responsible name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="responsible_title">Responsible title</label>
                                        <input type="text" value="{{ $company->responsible->title }}" class="form-control" name="responsible_title" id="responsible_title" placeholder="responsible title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="responsible_email">Responsible Email</label>
                                        <input type="email" value="{{ $company->responsible->email }}" class="form-control" name="responsible_email" id="responsible_email" placeholder="responsible email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="responsible_phone1">Responsible phone 1</label>
                                        <input type="number" value="{{ $company->responsible->phone1 }}" class="form-control" name="responsible_phone1" id="responsible_phone1" placeholder="responsible phone 1" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="responsible_phone1">Responsible phone 2</label>
                                        <input type="number" value="{{ $company->responsible->phone2 }}" class="form-control" name="responsible_phone2" id="responsible_phone2" placeholder="responsible phone 2">
                                    </div>
                                    <div class="form-group">
                                        <label for="responsible_fax">Responsible Fax</label>
                                        <input type="text" value="{{ $company->responsible->fax }}" class="form-control" name="responsible_fax" id="responsible_fax" placeholder="responsible fax">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info pull-right">Edit</button>
                    </div>
                    <!-- /.box-footer -->
                {{ Form::close() }}
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (right) -->

    </div>
    <!-- /.row -->
@endsection

