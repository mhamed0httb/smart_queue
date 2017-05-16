


@extends('admin.layouts.master')


@section('css')
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="{{ asset('css/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fullcalendar.print.css') }}" media="print">
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Calendar
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Calendar</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h4 class="box-title">All Ads</h4>
                        </div>
                        <div class="box-body">
                            <!-- the events -->
                            <div id="external-events">
                                @foreach ($ads as $ad)
                                    @if($ad->active == true && $ad->plan == null)
                                        <div id="{{ $ad->id }}" class="external-event bg-aqua">{{ $ad->name }}</div>
                                    @endif
                                @endforeach
                                <!--div class="external-event bg-green">Lunch</div>
                                <div class="external-event bg-yellow">Go home</div>
                                <div class="external-event bg-aqua">Do homework</div>
                                <div class="external-event bg-light-blue">Work on UI design</div>
                                <div class="external-event bg-red">Sleep tight</div-->
                                <!--div class="checkbox">
                                    <label for="drop-remove">
                                        <input type="checkbox" id="drop-remove">
                                        remove after drop
                                    </label>
                                </div-->
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /. box -->
                    <!--div-- class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create Event</h3>
                        </div>
                        <div class="box-body">
                            <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                                <button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>
                                <ul class="fc-color-picker" id="color-chooser">
                                    <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                                </ul>
                            </div>
                            <div class="input-group">
                                <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                                <div class="input-group-btn">
                                    <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add</button>
                                </div>
                            </div>
                        </div>
                    </div-->
                    <div class="box box-solid">

                        <div class="box-body hide" id="plan_details">
                            <div class="box-header with-border">
                                <h4 class="box-title" id="plan_details_title"><strong>Ad</strong> : fanta </h4>
                                <div id="plan_details_date">
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>start : </strong>
                                    <br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>end : </strong>
                                </div>

                            </div>
                            <h5 class="box-title"><strong>Offices</strong></h5>

                            <div class="btn-group" style="width: 100%; margin-bottom: 10px;" id="div_offices">
                                <!--button-- type="button"  class="btn btn-info btn-block " data-toggle="dropdown">Save changes</button-->

                                <ul id="plan_details_offices">
                                    <li>ffezfe</li>
                                    <li>dddza zda</li>
                                </ul>
                            </div>
                            <input type="hidden" id="plan_details_ad_id">
                            <input type="hidden" id="plan_details_ad_title">
                            <button type="button" onclick="changeOffices()"  class="btn btn-info btn-block " data-toggle="dropdown">Change Offices</button>
                            <button type="button" onclick="deletePlan()"  class="btn btn-danger btn-block " data-toggle="dropdown">Delete Plan</button>

                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="box box-primary">
                        <div class="box-body no-padding">
                            <!-- THE CALENDAR -->
                            <div id="calendar"></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /. box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->

    <!-- /.content-wrapper -->








    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg hide" data-toggle="modal" data-target="#modal_offices" id="btn_show_offices">
        Launch modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modal_offices" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ url('/dashboard/calendar/changeOffices') }}">
                    {{csrf_field()}}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Choose offices </h4>
                    </div>
                    <div class="modal-body" id="modal_delete_body">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                @foreach ($offices as $office)
                                    <tr>
                                        <td>
                                            <input name="office_checkbox[]" value="{{ $office->id }}" type="checkbox">
                                        </td>
                                        <td>{{ $office->identifier }}</td>
                                        <!--td><span class="label label-success">Approved</span></td>
                                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td-->
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <input type="hidden" id="change_offices_ad_id" name="change_offices_ad_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn_delete_confirm">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection




@section('scripts')

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('js/fastclick.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('js/demo.js') }}"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/fullcalendar.min.js') }}"></script>
    <!-- Page specific script -->


    @if(Session::has('success'))
        <script>
            //$('#btn_modal_success').click()
            $('#div_alert').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-check"></i> SUCCESS!</h4>{{ Session::get('success') }}</div>');
            dismissAlertMessage();
        </script>
    @endif
    @if(Session::has('update'))
        <script>
            //$('#btn_modal_success').click()
            $('#div_alert').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-check"></i> UPDATE!</h4>{{ Session::get('update') }}</div>');
            $('#div_alert').fadeIn();
            dismissAlertMessage();
        </script>
    @endif
    @if(Session::has('delete'))
        <script>
            //$('#btn_modal_success').click()
            $('#div_alert').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-check"></i> DELETE!</h4>{{ Session::get('delete') }}</div>');
            $('#div_alert').fadeIn();
            dismissAlertMessage();
        </script>
    @endif
    @if(Session::has('assign'))
        <script>
            //$('#btn_modal_success').click()
            $('#div_alert').html('<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-info"></i> SUCCESS!</h4>{{ Session::get('assign') }}</div>');
            $('#div_alert').fadeIn();
            dismissAlertMessage();
        </script>
    @endif

    <script>
        $(function () {

            /* initialize the external events
             -----------------------------------------------------------------*/
            function ini_events(ele) {
                ele.each(function () {

                    // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                    // it doesn't need to have a start or end
                    var eventObject = {
                        title: $.trim($(this).text()) // use the element's text as the event title
                    };

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject);

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 1070,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0  //  original position after the drag
                    });

                });
            }

            ini_events($('#external-events div.external-event'));

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date();
            var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                buttonText: {
                    today: 'today',
                    month: 'month',
                    week: 'week',
                    day: 'day'
                },
                //Random default events
                events: [
                    @foreach ($ads as $ad)
                        @if($ad->active == true && $ad->plan != null)
                    {
                        title: '{{ $ad->name }}',
                        start: '{{ $ad->plan->start }}',
                        end: '{{ $ad->plan->end }}',
                        backgroundColor: "#f56954", //red
                        borderColor: "#f56954", //red
                        id: "{{ $ad->id }}" //red
                    },
                        @endif
                    @endforeach
                    /*{
                        title: 'All Day Event',
                        start: new Date(y, m, 1),
                        backgroundColor: "#f56954", //red
                        borderColor: "#f56954" //red
                    },
                    {
                        title: 'Long Event',
                        start: new Date(y, m, d - 5),
                        end: new Date(y, m, d - 2),
                        backgroundColor: "#f39c12", //yellow
                        borderColor: "#f39c12" //yellow
                    },
                    {
                        title: 'Meeting',
                        start: new Date(y, m, d, 10, 30),
                        allDay: false,
                        backgroundColor: "#0073b7", //Blue
                        borderColor: "#0073b7" //Blue
                    },
                    {
                        title: 'Lunch',
                        start: new Date(y, m, d, 12, 0),
                        end: new Date(y, m, d, 14, 0),
                        allDay: false,
                        backgroundColor: "#00c0ef", //Info (aqua)
                        borderColor: "#00c0ef" //Info (aqua)
                    },
                    {
                        title: 'Birthday Party',
                        start: new Date(y, m, d + 1, 19, 0),
                        end: new Date(y, m, d + 1, 22, 30),
                        allDay: false,
                        backgroundColor: "#00a65a", //Success (green)
                        borderColor: "#00a65a" //Success (green)
                    },
                    {
                        title: 'Click for Google',
                        start: new Date(y, m, 28),
                        end: new Date(y, m, 29),
                        url: 'http://google.com/',
                        backgroundColor: "#3c8dbc", //Primary (light-blue)
                        borderColor: "#3c8dbc" //Primary (light-blue)
                    }*/
                ],
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                eventClick: function(event) {
                    //openModal(event.id, event.title, event);
                    planDetails(event.id, event.title, event);

                },
                drop: function (date, allDay) { // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');

                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;
                    copiedEventObject.backgroundColor = $(this).css("background-color");
                    copiedEventObject.borderColor = $(this).css("border-color");
                    copiedEventObject.id = $(this).attr('id');
                    console.log(date.format('h:mm a'));
                    //$('#plan_details').removeClass('hide');
                    savePlan(date,copiedEventObject.id,copiedEventObject.end);




                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    /*if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }*/
                    $(this).remove();

                },
                eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {

                    /*alert(
                        event.title + " was moved " +
                        dayDelta + " days and " +
                        minuteDelta + " minutes."+
                        event.id
                    );*/
                    //alert(event.start.format());
                    console.log(event);

                    if (allDay) {
                        //alert("Event is now all-day");
                    }else{
                        //alert("Event has a time-of-day");
                    }

                    if(event.end != null){
                        //alert(event.end.format());
                        savePlan(event.start,event.id,event.end);
                    }

                    /*if (!confirm("Are you sure about this change?")) {
                        revertFunc();
                    }*/

                }
            });

            /* ADDING EVENTS */
            var currColor = "#3c8dbc"; //Red by default
            //Color chooser button
            var colorChooser = $("#color-chooser-btn");
            $("#color-chooser > li > a").click(function (e) {
                e.preventDefault();
                //Save color
                currColor = $(this).css("color");
                //Add color effect to button
                $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
            });
            $("#add-new-event").click(function (e) {
                e.preventDefault();
                //Get value and make sure it is not null
                var val = $("#new-event").val();
                if (val.length == 0) {
                    return;
                }

                //Create events
                var event = $("<div />");
                event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
                event.html(val);
                $('#external-events').prepend(event);

                //Add draggable funtionality
                ini_events(event);

                //Remove event from text input
                $("#new-event").val("");
            });
        });

        /*function openModal(id,title, event) {
            console.log(event);

            swal({
                    title: "Delete '" + title + "' ?",
                    text: "This Ad  will be deleted from plan !",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        //swal("Deleted!", "Ad has been deleted.", "success");
                        $.get('{{ url('/api/adsPlan/deletePlan') }}'+'?ad_id='+id, function(data) {
                            //var obj = jQuery.parseJSON(data);
                            //alert(data);
                            $('#calendar').fullCalendar( 'removeEvents', id );
                        });
                    } else {
                        //swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                });
        }*/


        function planDetails(id,title, event){

            $.get('{{ url('/api/adsPlan/details') }}'+'?ad_id='+id, function(data) {
                //var obj = jQuery.parseJSON(data);
                if(data == 0){

                }else {
                    $('#plan_details').removeClass('hide');
                    $('#plan_details_title').html('<strong>Ad</strong> : '+title);
                    $('#plan_details_ad_id').val(id);
                    $('#plan_details_ad_title').val(title);
                    $('#plan_details_date').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>start : </strong>'+data.plan_start+'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>end : </strong>'+data.plan_end);

                    $('#change_offices_ad_id').val(id);

                    $('#plan_details_offices').empty();
                    $.each(data.plan_offices, function(i, item) {
                        $('#plan_details_offices').append('<li>'+item.office_name+'</li>');
                    })
                }
            });
        }

        function deletePlan(){
            var id = $('#plan_details_ad_id').val();
            var title = $('#plan_details_ad_title').val();

            swal({
                    title: "Delete '" + title + "' ?",
                    text: "This Ad  will be deleted from plan !",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        //swal("Deleted!", "Ad has been deleted.", "success");
                        $.get('{{ url('/api/adsPlan/deletePlan') }}'+'?ad_id='+id, function(data) {
                            //var obj = jQuery.parseJSON(data);
                            //alert(data);
                            $('#calendar').fullCalendar( 'removeEvents', id );
                            location.reload();
                        });
                    } else {
                        //swal("Cancelled", "Your imaginary file is safe :)", "error");

                    }
                });
        }

        function changeOffices(){
            $('#btn_show_offices').click();
        }

        function openModal(id,title, event) {
            console.log(event);

            swal({
                    title: "Action for '" + title + "' ",
                    text: "Choose what you want to do !",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Choose offices",
                    cancelButtonText: "Delete",
                    cancelButtonColor: "#DD6B55",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        //swal("Deleted!", "Ad has been deleted.", "success");
                        chooseOffices();

                    } else {
                        //swal("Cancelled", "Your imaginary file is safe :)", "error");
                        deleteModel(id,title, event);
                    }
                });
        }

        function deleteModel(id,title, event){

            swal({
                    title: "Delete '" + title + "' ?",
                    text: "This Ad  will be deleted from plan !",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        //swal("Deleted!", "Ad has been deleted.", "success");
                        $.get('{{ url('/api/adsPlan/deletePlan') }}'+'?ad_id='+id, function(data) {
                            //var obj = jQuery.parseJSON(data);
                            //alert(data);
                            $('#calendar').fullCalendar( 'removeEvents', id );
                            //location.reload();
                        });
                    } else {
                        //swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                });
        }


        function chooseOffices(){
            swal({
                    title: "An input!",
                    text: "Write something interesting:",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: "Write something"
                },
                function(inputValue){
                    if (inputValue === false) return false;

                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }

                    swal("Nice!", "You wrote: " + inputValue, "success");
                });
        }
    </script>

    <script>
        function savePlan(startDate, id, endDate){
            var start = startDate.format('YYYY-MM-DD HH:mm:ss');

            if(endDate == null){
                //alert('please add start and end of ad in the day section');
                swal("Start & End date required", "please add start and end of ad in the day section")
            }else{
                /*if (!confirm("Are you sure to add this plan ?")) {

                }else{
                    var end = endDate.format('YYYY-MM-DD HH:mm:ss');
                    $.get('{{ url('/api/adsPlan/savePlan') }}'+'?ad_id='+id+'&start='+start+'&end='+end, function(data) {
                        //var obj = jQuery.parseJSON(data);
                        alert(data);
                    });
                }*/
                swal({
                        title: "Add Plan ?",
                        text: "Are you sure to add this plan ?",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, add",
                        closeOnConfirm: false
                    },
                    function(){
                        var end = endDate.format('YYYY-MM-DD HH:mm:ss');
                        $.get('{{ url('/api/adsPlan/savePlan') }}'+'?ad_id='+id+'&start='+start+'&end='+end, function(data) {
                            //var obj = jQuery.parseJSON(data);
                            //alert(data);
                            if(data == "success"){
                                swal("SUCCESS", "Plan has been added succsessfully.", "success");
                                location.reload();
                                ///setInterval(function(){location.reload();},1000);

                                //console.log($('#calendar').fullCalendar( 'clientEvents', id ));
                               // var evento = $('#calendar').fullCalendar( 'clientEvents', id );
                                //evento.backgroundColor = "#DD6B55";
                                //console.log(evento.backgroundColor);
                                //.backgroundColor = "#f56954";
                                //$('#calendar').fullCalendar('removeEvents');
                                //$('#calendar').fullCalendar('refetchEvents');

                            }else if(data == "updated"){
                                swal("UPDATED", "Plan has been updated succsessfully.", "success");
                            }else{
                                swal("ERROR", "Something bad happened !", "error");
                            }

                        });
                    });
            }
            //alert(start);
            /*$.get('{{ url('/api/adsPlan/savePlan') }}'+'?ad_id='+id+'&start='+start, function(data) {
                //var obj = jQuery.parseJSON(data);
                alert(data);

            });*/
        }
            @foreach ($ads as $ad)
            @if($ad->active == true)

        @endif
        @endforeach
    </script>

@endsection

