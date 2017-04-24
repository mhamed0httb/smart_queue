


@extends('manager.layouts.master')

@section('content')

    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">{{ $sub_page_title or 'statistics' }}</a></li>
        <li class="active">{{ $page_title or 'staff members' }}</li>
    </ol>

    <!-- /.row -->
    <div class="row">

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Statistics all staff members</h3>

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
                    <div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->








@endsection

@section('scripts')

    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/highcharts.js') }}"></script>
    <script src="{{ asset('js/exporting.js') }}"></script>

    <script>

        var staffs = new Array();
        var staffsName = new Array();
        var nbrClientServed = new Array();
        var services = new Array() ;
        var lengthService = new Array();
        var serviceName = new Array();
        var clients = [[]];
        var clientsOb = new Array();
        var timeDif = new Array();
        var timeD = 0;


        var url = "{{ url('/api/statistics/allStaff/allDays?office_id=' . $office->id) }}";
        $.getJSON(url,
            function(staffs){

                this.staffs = staffs;
                console.log(staffs);

                for (var i = 0; i < staffs.length; i++) {
                    //console.log(staffs[i].staff_name);
                    staffsName[i] = staffs[i].staff_name;
                    nbrClientServed[i] = staffs[i].total_clients_served;
                    services[i] = staffs[i].services;
                    lengthService [i] = Object.keys(services[i]).length;

                };

                console.log(staffsName); //hethi
                console.log(nbrClientServed);//hethi
                console.log(services);

                for (var i = 0; i < services.length; i++) {

                    for (var j = 0; j < services[i].length; j++) {


                        serviceName[i] = services[i][j].service_name;
                        clients[i] = services[i][j].clients_served;

                    };

                };


                for (var i = 0; i < clients.length; i++) {

                    for (var j = 0; j < clients[i].length; j++) {

                        if(Math.round(clients[i][j].time_difference_minutes,2) > 0)

                        {

                            timeD += clients[i][j].time_difference_minutes;
                            console.log("timeD",timeD);



                            timeDif[i] = Math.round(timeD/60,2);
                            console.log("looool",Math.round(timeD,2));

                            console.log("clientsII",clients[i][j].time_difference_minutes);
                        };
                    };
                };
                console.log(clients);
                console.log(serviceName);
                console.log(timeDif);//hethi


                Highcharts.chart('container', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: 'employees statistics'
                    },
                    subtitle: {
                        text: 'According to their effectual services and number of work hours'
                    },
                    xAxis: {
                        categories: staffsName,
                        title: {
                            text: null
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Employees',
                            align: 'high'
                        },
                        labels: {
                            overflow: 'justify'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' clients/hours'
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: true
                            }
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -40,
                        y: 80,
                        floating: false,
                        borderWidth: 1,
                        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                        shadow: false
                    },
                    credits: {
                        enabled: false
                    },
                    series: [{
                        name: 'Nb.Services',
                        data: nbrClientServed
                    }, {
                        name: 'Nb.Hours',
                        data: timeDif
                    }]
                });

            }.bind(this));



    </script>




@endsection
