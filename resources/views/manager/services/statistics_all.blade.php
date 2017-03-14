


@extends('manager.layouts.master')

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
                    <div style="width: 100%; height: 100%;">
                        <canvas id="myChart" style="width: 100%; height: auto;"></canvas>
                    </div>
                    <div id="js-legend" class="chart-legend"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->








@endsection

@section('scripts')
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.0.6/angular.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.1/Chart.min.js"></script>
    <script type="text/javascript" src="oXHR.js"></script>

    <script >








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


            var data = {
                labels: serName,
                datasets: [
                    {
                        label: "My First dataset",
                        fillColor: "rgba(220,220,220,0.5)",
                        strokeColor: "rgba(220,220,220,0.8)",
                        highlightFill: "rgba(220,220,220,0.75)",
                        highlightStroke: "rgba(220,220,220,1)",

                        data :  nbCli// nbr client servi mèyetzèdech automatiquement
                    },

                ]
            };


            var ctx = document.getElementById("myChart").getContext("2d");
            ctx.canvas.width = 1000;
            ctx.canvas.height = 800;

            var myChart = new Chart(ctx).Bar(data);





        }.bind(this));








    </script>
@endsection
