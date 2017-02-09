



@extends('admin.layouts.master')

@section('content')
    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/manager')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">{{ $sub_page_title or 'Sub Page Title' }}</a></li>
        <li class="active">{{ $page_title or 'Page Title' }}</li>
    </ol>

    <div class="row">
        <!-- right column -->
        <div class="col-md-6">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title col-sm-4">Create Office for : </h3>
                    <div class="col-sm-4 right">
                        <select class="" onchange="companyChanged(this.value)" id="select_company">
                            @foreach ($allCompanies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ url('/dashboard/offices') }}" method="POST" id="form_create_manager">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="identifier" class="col-sm-2 control-label">Identifier</label>

                            <div class="col-sm-6">
                                <input type="text" name="identifier" class="form-control" id="identifier" placeholder="identifier" required>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-warning" href="#" id="btn_map">Check Map </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="region_id" class="col-sm-2 control-label">Region</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="region_id" name="region_id" required>
                                    @foreach ($allRegions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-primary" href="{{url('/dashboard/regions/create')}}">Add new Region</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="manager_id" class="col-sm-2 control-label">Manager</label>
                            <div class="col-sm-6" id="select_manager_holder">
                                <select class="form-control" id="manager_id" name="manager_id" required>

                                </select>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-primary" href="{{url('/dashboard/manager/create')}}">Add new Manager</a>
                            </div>
                        </div>

                        <input type="hidden" name="office_lat" class="form-control" id="office_lat" value="0"  required>
                        <input type="hidden" name="office_lng" class="form-control" id="office_lng" value="0"  required>
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

        <div class="col-md-6">
            <div id="map" style="width: 100%;height: 300px"></div>
        </div>

    </div>
    <!-- /.row -->




@endsection

@section('scripts')
    <script>
        function companiesLoaded(id){
            $.get('{{ url('api/managers/byCompany') }}'+'?company_id='+id, function(data) {
                //var obj = jQuery.parseJSON(data);
                $.each(data, function(i, item) {
                    $('#manager_id').append('<option value="'+item.id+'">'+item.first_name +' '+ item.last_name+'</option>');
                })
            });
        }

        function companyChanged(id){
            $('#manager_id').empty();
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



