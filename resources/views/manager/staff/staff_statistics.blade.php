


@extends('manager.layouts.master')

@section('content')

    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/manager')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/manager/staffs')}}">{{ $sub_page_title or 'Staff' }}</a></li>
        <li class="active">{{ $page_title or 'Statistics (' . $member->first_name . ' ' . $member->last_name . ')' }}</li>
    </ol>

    <!-- /.row -->
    <div class="row">

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Staff Member : {{$member->first_name . ' ' . $member->last_name}}</h3>

                    <!--div-- class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" id="input_search" class="form-control pull-right" placeholder="Search...">

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default" id="btn_clear_search"><i class="fa fa-close"></i></button>
                            </div>
                        </div>
                    </div-->
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


    <script >

        var staff = new Array();
        var ser = new Array();
        var servN = new Array();
        var servC = new Array();
        var clients = new Array();
        var servName = new Array();
        var servClient = new Array();
        var clientsObj = new Array();
        var clientsOb = new Array();
        var timeDif = new Array();
        var timeD = 0;
        var totalClients = 0;
        var timeDD = new Array();
        var b = new Array();
        var date = new Array();
        var datee = new Array();
        var dateJ = 0;
        var dte = new Array();
        var c = "";
        var url = "{{ url('/api/statistics/staff/allDays?staff_id=' . $member->id . '&office_id=' . $member->getOffice->id) }}";
        url = url.replace(/\&amp;/g, '&');
        $.getJSON(url,
            function(staff){

                this.staff = staff;
                console.log(staff);
                totalClients = staff.total_clients_served;
                console.log(totalClients);
                a = Object.keys(staff.services).length;
                console.log(a);
                ser = staff.services;

                console.log(ser);
                //b = Object.keys(ser.clients_served).length;
                //console.log(b);

                for (var i = 0; i< a; i++ ) {

                    console.log("serII", ser[i])
                    servN[i] = ser[i].service_name;
                    console.log(servN[i]);
                    servC[i] = ser[i].nbr_services_served;
                    console.log("servC",servC[i]);
                    clients[i] = ser[i].clients_served;
                    clientsOb = clients[i];

                    for (var j = 0; j < clientsOb.length; j++) {

                        date[j] = clientsOb[j].date;
                        dateJ = date[j].split('-');
                        console.log("daaaate", dateJ[2]);
                        datee[j] = dateJ[2];
                        console.log("datJJ",datee[0]);
                        if (datee[j] == datee[j+1]) {

                            c = datee[j+1];
                            dte[i-1] = datee[j+1];


                        }
                        else{

                            var aa = datee[j];
                            console.log("aa",aa);
                        }

                        if((Math.round(clientsOb[j].time_difference_minutes,2) > 0)&&(dte[j] == dte[j+1]))

                        {

                            timeD += clientsOb[j].time_difference_minutes;
                            console.log("timeD",timeD);



                            timeDif[i] = Math.round(timeD/60,2);
                            console.log("looool",Math.round(timeD,2));



                            console.log("clientsII",clientsOb[j].time_difference_minutes);
                        }
                    };
                    timeDD = timeDif.slice(1);
                    console.log("timeDiffff",timeDD);
                    console.log("daate",date);
                    console.log("daate",datee);
                    console.log("dte",dte);
                    console.log("cc",c)


                    // b[i] = Object.keys(ser[i].clients_served).length;
                    //console.log("b" , b);

                };

                //console.log("clients",clients[1].time_difference_minutes);



                clientsObj = clients.slice(1);
                console.log("===clientsObj",clientsObj[0]);
                servName = servN.slice(1);
                console.log(servName);
                servClient = servC.slice(1);
                console.log(servClient);

                /* for(var i = 0; i<a;i++){
                 for(var j = 0; j<10000;j++){
                 var index = j.toString();
                 //var index = ind;
                 console.log(index);
                 if(clientsObj[i][j.toString()]["time_difference_minutes"] != undefined){
                 console.log("hahahahahaaaaa",clientsObj[i][j.toString()]["time_difference_minutes"]);
                 };
                 var element = clientsObj[i];
                 console.log("=========",element);
                 }
                 }*/

                /*for(key in clientsObj[0]) {
                 var clientsObjJSON = clientsObj[0][key];
                 if(typeof  clientsObjJSON !== "object"){
                 console.log("info", clientsObjJSON);
                 };*/
                //clientsOb = clientsObj[0];
                //console.log("clientsObj 0",clientsOb);

                /* for (var i = 0 ; i < a ; i++) {

                 timeDif =+ clientsObj[i].time_difference_minutes;
                 var c = servClient[i];
                 console.log("c",c);
                 console.log(timeDif);

                 };*/


                //}



                var data = {
                    labels: servName,
                    datasets: [{
                        label: "My First dataset",
                        //new option, type will default to bar as that what is used to create the scale
                        type: "line",
                        fillColor: "rgba(220,220,220,0.2)",
                        strokeColor: "rgba(220,220,220,1)",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: servClient

                    }, {
                        label: "My First dataset",
                        //new option, type will default to bar as that what is used to create the scale
                        type: "bar",
                        fillColor: "rgba(220,20,220,0.2)",
                        strokeColor: "rgba(220,20,220,1)",
                        pointColor: "rgba(220,20,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: timeDD
                    }]
                };

                var ctx = document.getElementById("myChart").getContext("2d");
                ctx.canvas.width = 1000;
                ctx.canvas.height = 800;

                var myChart = new Chart(ctx).Bar(data);

            }.bind(this));


    </script>






























    <script>

        var staff = new Array();
        var totalClients = 0;
        var nameEmp = "";
        var services = new Array();
        var serviceName = new Array();
        var nbrClient = new Array();
        var clients = [[]];
        var timeDif = new Array();
        var sommeTime = 0;
        var timeFinal = new Array();

        var url = "{{ url('/api/statistics/staff/allDays?staff_id=' . $member->id . '&office_id=' . $member->getOffice->id) }}";
        url = url.replace(/\&amp;/g, '&');
        $.getJSON(url,
            function(staff){

                this.staff = staff;
                console.log(staff);
                totalClients = staff.total_clients_served;//hethi
                console.log(totalClients);
                nameEmp = staff.staff_name;//hethi
                console.log(nameEmp);
                services = staff.services;
                console.log(services);

                for (var i = 0; i < services.length; i++) {

                    serviceName[i] = services[i].service_name;
                    nbrClient[i] = services[i].nbr_services_served;
                    clients[i] = services[i].clients_served;
                };

                console.log(serviceName);//hethi
                console.log(nbrClient);//hethi
                console.log(clients);

                for (var i = 0; i < clients.length; i++) {

                    for (var j = 0; j < clients[i].length; j++) {

                        timeDif[j] = clients[i][j].time_difference_minutes



                    };
                };

                console.log(timeDif);

                for (var j = 0; j < services.length; j++) {

                    for (var i = 0; i < timeDif.length; i++) {

                        if(Math.round(timeDif[i],2) > 0){

                            sommeTime += timeDif[i];
                            console.log("timeD",sommeTime);

                            timeFinal[j] = Math.round(sommeTime/60,2);

                        }

                    };

                };

                console.log(timeFinal);//hethi


                Highcharts.chart('container', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: nameEmp
                    },
                    subtitle: {
                        text: 'Total clients served '+totalClients
                    },
                    xAxis: {
                        categories: serviceName,
                        title: {
                            text: null
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Services/Hours',
                            align: 'high'
                        },
                        labels: {
                            overflow: 'justify'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' Clients/Hours'
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
                        name: 'Nb.Clients',
                        data: nbrClient
                    },
                        {
                            name: 'Nb.hours',
                            data: timeFinal
                        }]
                });



            }.bind(this));



    </script>
@endsection
