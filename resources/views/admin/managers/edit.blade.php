





@extends('admin.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/dashboard/manager')}}">{{ $sub_page_title or 'Managers' }}</a></li>
        <li class="active">{{ $page_title or 'Edit' }}</li>
    </ol>

    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Manager {{ $manager->first_name }} {{ $manager->last_name }}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{ Form::model($manager, array('route' => array('manager.update', $manager->id), 'method' => 'PUT', 'class' => 'form-horizontal' , 'id' => 'form_create_manager')) }}

                    <div class="box-body">
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>

                            <div class="col-sm-10">
                                <input type="email" value="{{ $manager->email }}" name="email" class="form-control" id="email" placeholder="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="col-sm-2 control-label">First Name</label>

                            <div class="col-sm-10">
                                <input type="text" value="{{ $manager->first_name }}" name="first_name" class="form-control" id="first_name" placeholder="first name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-sm-2 control-label">Last Name</label>

                            <div class="col-sm-10">
                                <input type="text" value="{{ $manager->last_name }}" name="last_name" class="form-control" id="last_name" placeholder="last name" required>
                            </div>
                        </div>
                        <div class="form-group" id="password_group">
                            <label for="password" class="col-sm-2 control-label">Password</label>

                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" id="password" placeholder="password" required>
                                <span class="help-block hide">Help block with error</span>
                            </div>
                        </div>
                        <div class="form-group" id="password_confirmation_group">
                            <label for="password_confirmation" class="col-sm-2 control-label">Password Vonfirmation</label>

                            <div class="col-sm-10">
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="password_confirmation" required>
                                <span class="help-block hide">Help block with error</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">Company</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="company_id" name="company_id" required>
                                    <option value="{{ $manager->getCompany->id }}">{{ $manager->getCompany->name }}</option>
                                    @foreach ($allCompanies as $company)
                                        @if($manager->getCompany->id != $company->id)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endif
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
                        <button type="button" onclick="passwordConfirmation($('#password').val(),$('#password_confirmation').val());" class="btn btn-info pull-right">Edit</button>
                        <button type="submit" class="btn btn-info pull-right hide" id="btn_submit_form">Edit</button>
                    </div>
                    <!-- /.box-footer -->
                {{ Form::close() }}
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (right) -->

    </div>
    <!-- /.row -->


    <script>
        function passwordConfirmation(pass1,pass2){
            if(pass1 == pass2){
                $('#btn_submit_form').click();
            }else{
                $('.help-block').html("password dosen't match");
                $('.help-block').removeClass("hide");
                $('#password_confirmation_group').addClass("has-error");
                $('#password_group').addClass("has-error");
            }
        }
    </script>
@endsection

