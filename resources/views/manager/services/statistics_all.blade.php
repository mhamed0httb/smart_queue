


@extends('manager.layouts.master')

@section('content')

    <h1>
        {{ $page_title or null }}
        <small>{{ $page_description or null }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/manager')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">{{ $sub_page_title or 'statistics' }}</a></li>
        <li class="active">{{ $page_title or 'services' }}</li>
    </ol>

    <!-- /.row -->
    <div class="row">

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Statistics all Services</h3>

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




        var tickets = new Array();
        var services = new Array();
        var labelName = new Array();
        var serName = new Array();
        var nbrC = new Array();
        var nbCli = new Array();

        var url = "{{ url('/api/statistics/service/allDay?office_id=' . $office->id) }}";
        $.getJSON(url, function(tickets){

            this.tickets = tickets;

            console.log(tickets.services[1].nbr_clients_served);

            console.log(Object.keys(tickets.services).length);
            a = Object.keys(tickets.services).length;

            for (var i = a; i > 0 ; i--) {

                services[i] = tickets.services[i];
                console.log(services[i])
                labelName[i] = services[i].service_name;
                console.log(labelName[i]);
                nbrC[i] = services[i].nbr_clients_served;




            };
            serName = labelName.slice(1);
            nbCli = nbrC.slice(1);
            console.log(serName);
            console.log(nbCli);



            Highcharts.chart('container', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Services statistics'
                },
                subtitle: {
                    text: 'According to the number of clients'
                },
                xAxis: {
                    categories: serName,
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Services',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                    valueSuffix: ' Clients/service'
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
                    data: nbCli
                }]
            });



        }.bind(this));

    </script>




@endsection
