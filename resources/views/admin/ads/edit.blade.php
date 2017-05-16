
@extends('admin.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/manager')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/dashboard/ads')}}">{{ $sub_page_title or 'Ads' }}</a></li>
        <li class="active">{{ $page_title or 'Edit' }}</li>
    </ol>

    <div class="row">
        <!-- right column -->
        <div class="col-md-6">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title col-sm-12">Edit Advertisement : {{ $ad->name }}  </h3>

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{ Form::model($ad, array('route' => array('ads.update', $ad->id), 'method' => 'PUT', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')) }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="video_length" class="col-sm-2 control-label">Name</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" class="form-control" id="name" value="{{ $ad->name }}" placeholder="name">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="identifier" class="col-sm-2 control-label">File</label>

                            <div class="col-sm-6">
                                <input class="form-control" id="file" name="file" type="file">
                            </div>

                            <div class="col-sm-2">
                                <a class="btn btn-info" data-toggle="modal" data-target="#modal_show_ad">View Ad</a>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="video_length" class="col-sm-2 control-label">Video Length</label>

                            <div class="col-sm-6">
                                <input type="text" name="video_length" class="form-control" value="{{ $ad->video_length }}" id="video_length" placeholder="video length">
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="region_id" class="col-sm-2 control-label">Comapny</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="company_id" name="company_id" required>
                                    @foreach ($allAdCompanies as $adCompany)
                                        <option value="{{ $adCompany->id }}">{{ $adCompany->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        {{ Form::submit('Edit', array('class' => 'btn btn-info pull-right', 'id' => 'btn_submit_form')) }}
                    </div>
                    <!-- /.box-footer -->
                {{ Form::close() }}
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (right) -->

        <div class="col-md-6">
            <!--div id="map" style="width: 100%;height: 300px"></div-->
        </div>

    </div>
    <!-- /.row -->




    <!-- Modal view Ad -->
    <div class="modal fade" id="modal_show_ad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">AD : {{ $ad->name }}</h4>
                </div>
                <div class="modal-body">
                    <center>
                        @if($ad->type == 'image')
                            <img class="img-responsive center" src="{{ asset($ad->file_path) }}" />
                        @elseif($ad->type == 'video')
                            <video controls autoplay  style="width: 100%">
                                <source src="{{ asset($ad->file_path) }}" type="video/mp4">
                                <source src="movie.ogg" type="video/ogg">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('scripts')

@endsection



