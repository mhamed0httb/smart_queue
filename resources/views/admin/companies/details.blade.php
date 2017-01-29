


@extends('admin.layouts.master')

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

    </div>
    <!-- /.row -->










    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Company Details</a></li>
            <li><a href="#tab_2" data-toggle="tab">Responsible</a></li>
            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <li><a href="#"><b>Company name : </b>{{$company->name}} </a></li>
                        <li><a href="mailto:{{$company->email}}"><b>Company Email : </b>{{$company->email}} </a></li>
                        <li><a href="#"><b>Company Phone : </b>{{$company->phone}} </a></li>
                        <li><a href="#"><b>Company Address : </b>{{$company->address}} </a></li>
                    </ul>
                </div>

                <hr>
                <b>Company Description</b>
                <p>{{$company->description}}</p>

            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-yellow">
                            <!--div class="widget-user-image">
                                <img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">
                            </div-->
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username">{{$responsible->name}}</h3>
                            <h5 class="widget-user-desc">{{$responsible->title}}</h5>
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="mailto:{{$responsible->email}}"><b>Email : </b>{{$responsible->email}} </a></li>
                                <li><a href="#"><b>Phone 1 : </b>{{$responsible->phone1}} </a></li>
                                <li><a href="#"><b>Phone 2 : </b>{{$responsible->phone2}} </a></li>
                                <li><a href="#"><b>Fax : </b>{{$responsible->fax}} </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.tab-pane -->

            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->















    <!--div class="box box-default collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Expandable</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="box box-widget widget-user-2">
                <div class="widget-user-header bg-yellow">
                    <div class="widget-user-image">
                        <img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">
                    </div>
                    <h3 class="widget-user-username">Nadia Carmichael</h3>
                    <h5 class="widget-user-desc">Lead Developer</h5>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <li><a href="#">Projects <span class="pull-right badge bg-blue">31</span></a></li>
                        <li><a href="#">Tasks <span class="pull-right badge bg-aqua">5</span></a></li>
                        <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>
                        <li><a href="#">Followers <span class="pull-right badge bg-red">842</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div-->
@endsection

