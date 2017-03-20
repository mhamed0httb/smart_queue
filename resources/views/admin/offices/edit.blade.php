



@extends('admin.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/manager')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/dashboard/offices')}}">{{ $sub_page_title or 'Offices' }}</a></li>
        <li class="active">{{ $page_title or 'Edit' }}</li>
    </ol>

    <div class="row">
        <!-- right column -->
        <div class="col-md-6">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title col-sm-6">Edit Office : {{ $office->identifier }} </h3>
                    <div class="col-sm-6 pull-right">
                        <strong>Company : </strong>
                        <select class="" onchange="companyChanged(this.value)" id="select_company">
                            <option value="{{ $office->getCompany->id }}">{{ $office->getCompany->name }}</option>
                            @foreach ($allCompanies as $company)
                                @if($company->id != $office->getCompany->id)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{ Form::model($office, array('route' => array('offices.update', $office->id), 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'form_create_office')) }}

                    <div class="box-body">
                        <div class="form-group">
                            <label for="identifier" class="col-sm-2 control-label">Identifier</label>

                            <div class="col-sm-6">
                                <input type="text" name="identifier" value="{{ $office->identifier }}" class="form-control" id="identifier" placeholder="identifier" required>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-warning" href="#" id="btn_map">Check Map </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="region_id" class="col-sm-2 control-label">Region</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="region_id" name="region_id" required>
                                    <option value="{{ $office->getRegion->id }}">{{ $office->getRegion->name }}</option>
                                    @foreach ($allRegions as $region)
                                        @if($region->id != $office->getRegion->id)
                                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                            <!--a class="btn btn-primary" href="{{url('/dashboard/regions/create')}}">Add new Region</a-->
                                <a class="btn btn-primary modal-trigger" data-toggle="modal" data-target="#modal_create_region" href="#modal_create_region" >Add new Region</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="manager_id" class="col-sm-2 control-label">Manager</label>
                            <div class="col-sm-6" id="select_manager_holder">
                                <select class="form-control" id="manager_id" name="manager_id" required>

                                </select>
                            </div>
                            <div class="col-sm-2">
                                <!--a class="btn btn-primary modal-trigger" data-toggle="modal" data-target="#modal_create_manager" href="#modal_create_manager" id="btn_create_manager">Add new Manager</a-->
                                <a class="btn btn-primary" href="{{ url('/dashboard/manager/create') }}">Add new Manager</a>
                            </div>
                        </div>
                        <div class="callout callout-info">
                            <p>
                                <i class="icon fa fa-info"></i> &nbsp;
                                @if($office->manager_id == null)
                                    this office has no manager yet !
                                @else
                                    {{ $office->getManager->first_name }} {{ $office->getManager->last_name }} is managing this office, change it carefully !
                                @endif
                            </p>
                        </div>
                        <input type="hidden" name="office_lat" class="form-control" id="office_lat" value="0"  required>
                        <input type="hidden" name="office_lng" class="form-control" id="office_lng" value="0"  required>
                        <input type="hidden" name="company_id" class="form-control" id="company_id" >
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
            <div id="map" style="width: 100%;height: 300px"></div>
        </div>

    </div>
    <!-- /.row -->



    <div class="modal" id="modal_create_region">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create new region</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Region Name</label>

                            <div class="col-sm-8">
                                <input type="text" name="region_name" class="form-control" id="region_name" placeholder="region name..." required>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="btn_close_modal_create_region">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addRegion()">Create</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal" id="modal_create_manager">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create new manager</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- form start -->
                        <form class="form-horizontal" action="{{ url('/dashboard/manager') }}" method="POST" id="form_create_manager">
                            {{csrf_field()}}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="email" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="first_name" class="col-sm-2 control-label">First Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" name="first_name" class="form-control" id="first_name" placeholder="first name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="last_name" class="col-sm-2 control-label">Last Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" name="last_name" class="form-control" id="last_name" placeholder="last name" required>
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
                                            @foreach ($allCompanies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" onclick="passwordConfirmation($('#password').val(),$('#password_confirmation').val());" class="btn btn-info pull-right">Create</button>
                                <button type="submit" class="btn btn-info pull-right hide" id="btn_submit_form">Create</button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="btn_close_modal_create_region">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addRegion()">Create</button>
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
        var managerNow = '{{ $office->manager_id }}';
        function companiesLoaded(id){
            $('#company_id').val(id);
            if(managerNow != ''){
                $('#manager_id').append('<option value="same">Keep the same manager</option>');
            }
            $('#manager_id').append('<option value="not_yet">Not Yet</option>');
            $.get('{{ url('api/managers/byCompany') }}'+'?company_id='+id, function(data) {
                //var obj = jQuery.parseJSON(data);
                $.each(data, function(i, item) {
                    $('#manager_id').append('<option value="'+item.id+'">'+item.first_name +' '+ item.last_name+'</option>');
                })
            });
        }

        function companyChanged(id){
            $('#company_id').val(id);
            $('#manager_id').empty();
            if(managerNow != ''){
                $('#manager_id').append('<option value="same">Keep the same manager</option>');
            }
            $('#manager_id').append('<option value="not_yet">Not Yet</option>');
            $.get('{{ url('api/managers/byCompany') }}'+'?company_id='+id, function(data) {
                //var obj = jQuery.parseJSON(data);
                $.each(data, function(i, item) {
                    $('#manager_id').append('<option value="'+item.id+'">'+item.first_name +' '+ item.last_name+'</option>');
                })
            });
            //$('#select_manager_holder').html('<select class="form-control" id="manager_id" name="manager_id" required>@foreach ($allManagers as $manager) <option value="{{ $manager->id }}">{{ $manager->first_name }} {{ $manager->last_name }} - {{ $manager->getCompany->id }}</option>@endforeach</select>');
        }

        companiesLoaded($('#select_company').val());
        $('#map').css('height',$('.box-info').height());
    </script>

    <script>
        function addRegion(){
            var regionName = $('#region_name').val();
            $.get('{{ url('api/regions/create') }}'+'?name='+regionName, function(data) {
                //var obj = jQuery.parseJSON(data);
                $('#region_id').append('<option value="'+data.id+'">'+data.name +'</option>');
                $('#btn_close_modal_create_region').click();
                $('#div_alert').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-check"></i> SUCCESS!</h4>The new region has been successfully added.</div>');
                $('#div_alert').fadeIn();
                dismissAlertMessage();
            });
            $('#btn_close_modal_create_region').click();
        }

        function dismissAlertMessage(){
            setTimeout(function() {
                $('#div_alert').fadeOut();
            }, 3000);
        }

        function checkCompanyExists() {
            var company = $('#select_company').val();
            if(company == null){
                $('#btn_submit_form').prop('disabled', true);
                var urlAddCompany = "{{ url('/dashboard/companies/create') }}";
                $('#div_alert').html('<div class="alert alert-warning alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Alert!</h4>No companies are available. Please add a company <a target="_blank" href="'+urlAddCompany+'">here</a>.</div>');
                $('#div_alert').fadeIn();
            }else{
                //alert('company exist');
                $('#btn_submit_form').prop('disabled', false);
            }
        }
        checkCompanyExists();



        /*function doesConnectionExist() {
         var xhr = new XMLHttpRequest();
         var file = "https://www.google.tn/";
         var randomNum = Math.round(Math.random() * 10000);

         xhr.open('HEAD', file + "?rand=" + randomNum, true);
         xhr.send();

         xhr.addEventListener("readystatechange", processRequest, false);

         function processRequest(e) {
         if (xhr.readyState == 4) {
         if (xhr.status >= 200 && xhr.status < 304) {
         alert("connection exists!");
         } else {
         alert("connection doesn't exist!");
         }
         }
         }
         }
         doesConnectionExist();*/


    </script>


    <script>
        var marker;
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: {lat: 36.898392, lng: 10.1875433}
            });
            var geocoder = new google.maps.Geocoder();

            document.getElementById('btn_map').addEventListener('click', function() {
                geocodeAddress(geocoder, map);
            });

            marker = new google.maps.Marker({
                map: map,
                position: {lat: 36.898392, lng: 10.1875433},
                draggable: true
            });
            google.maps.event.addListener(marker, 'dragend', function () {
                //map.setCenter(this.getPosition()); // Set map center to marker position
                //updatePosition(this.getPosition().lat(), this.getPosition().lng()); // update position display
                //alert(this.getPosition().lat());
                geocodeLatLng(geocoder, map, this.getPosition());
                document.getElementById('office_lat').value = this.getPosition().lat();
                document.getElementById('office_lng').value = this.getPosition().lng();
            });


        }

        function geocodeAddress(geocoder, resultsMap) {
            var address = document.getElementById('identifier').value;
            geocoder.geocode({'address': address}, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    resultsMap.setCenter(results[0].geometry.location);
                    /*marker = new google.maps.Marker({
                     map: resultsMap,
                     position: results[0].geometry.location,
                     draggable: true
                     });*/
                    marker.setPosition(results[0].geometry.location);
                    document.getElementById('office_lat').value = results[0].geometry.location.lat();
                    document.getElementById('office_lng').value = results[0].geometry.location.lng();
                    //alert(results[0].geometry.location.lat());
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                    document.getElementById('office_lat').value = 0;
                    document.getElementById('office_lng').value = 0;
                }
            });
        }




        function geocodeLatLng(geocoder, map, pos) {
            //var input = document.getElementById('latlng').value;
            //var latlngStr = input.split(',', 2);
            var latlng = {lat: parseFloat(pos.lat()), lng: parseFloat(pos.lng())};
            geocoder.geocode({'location': latlng}, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        /*map.setZoom(11);
                         var marker = new google.maps.Marker({
                         position: latlng,
                         map: map
                         });
                         infowindow.setContent(results[1].formatted_address);
                         infowindow.open(map, marker);*/
                        document.getElementById('identifier').value = results[1].formatted_address;
                    } else {
                        window.alert('No results found');
                        document.getElementById('office_lat').value = 0;
                        document.getElementById('office_lng').value = 0;
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                    document.getElementById('office_lat').value = 0;
                    document.getElementById('office_lng').value = 0;
                }
            });
        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDk-sJhPAI3ivCyIQqGTw2EmkRbdtRFLxY&signed_in=true&callback=initMap"
            async defer></script>


@endsection



