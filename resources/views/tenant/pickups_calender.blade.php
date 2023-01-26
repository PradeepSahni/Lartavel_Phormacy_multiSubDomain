@extends('tenant.layouts.mainlayout')
@section('title') <title>Pickups Calender</title>
 <style>
.width100{ width: 100% !important; }
.width100 .ui-datepicker-inline{ width: 100% !important; min-height: 400px; height: auto; }
.ui-widget.ui-widget-content{ display: none !important; }
 </style>
@endsection

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          Pickups Calender
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
            <li><a href="#">{{__('Picksup')}}</a></li>
            <li class="active">{{__('Picksup Calendar')}}</li>
          </ol>
        </section>
         <!-- Main content -->




      <section class="content">
        <div class="row">
          <div class="col-md-offset-4 col-md-3 col-md-offset-5"><a class="btn btn-xs" style="font-size:17px;" href="{{url('pickups')}}"><i class="fa fa-plus"></i> Add Pickup</a></div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-body no-padding">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
                <span class="pull-right text-success text-bold totalPickupOfMonth"> </span>
              </div><!-- /.box-body -->
            </div><!-- /. box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->


      

      </div><!-- /.content-wrapper -->


@endsection


@section('customjs')

<script src="{{ URL::asset('admin/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      // timeFormat: 'H(:mm)',
      timeFormat: 'h(:mm)a',
      height: 430,
      eventLimit: 2, // allow "more" link when too many events
      eventLimitText: "More", 
      //Random default events
      events    : [
        @foreach($pickups as $pickup)
          {
            title          : '{{$pickup->patients->first_name." ".$pickup->patients->last_name}}',
            start          : '{{$pickup->created_at}}',
            backgroundColor: '#f56954', //red
            // borderColor    : '#f56954',//red
            // url            : "{{url('pickups/show/'.$pickup->id)}}",
            description: 'Pickup of Patient {{$pickup->patients->first_name." ".$pickup->patients->last_name}}' 
          },
        @endforeach
        @foreach($nextPickupList as $key=>$row)
          { 
            title          : '{{$row["patients"]["first_name"]." ".$row["patients"]["last_name"]}}',
            start          : '{{$row["created_at"]}}',
            backgroundColor: '#f39c12', //red
            // borderColor    : '#f56954',//red 
            description: 'Next schedule Pickup of Patient {{$row["patients"]["first_name"]." ".$row["patients"]["last_name"]}}'
          },
        @endforeach
        
      ],
      eventAfterRender: function(info, element) {
          $(element).tooltip({
            title: info.description,
            placement: 'top',
            trigger: 'hover',
            container: 'body'
          });
      },
      editable  : false,
      droppable : false,
      dayClick: function (date, allDay, jsEvent, view) {   
              //alert('Clicked on: ' + date.format());
              var d = new Date();
              var currentDate=moment(d).format('YYYY-MM-DD');
              var clickedDate=date.format();
              if(clickedDate ==  currentDate ){
                 window.location = "{{url('pickups')}}/?day=" + date.format();
              }
              
      },
      drop      : function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
        
        

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      },
      viewRender: function(view, element) {
        let newDate= view.calendar.getDate()._d;
        var getDate=moment(new Date(newDate)).format('YYYY-MM-DD');
         
          console.log(getDate)
          let day = moment(getDate, 'YYYY/MM/DD').date();
          let month = 1 + moment(getDate, 'YYYY/MM/DD').month();
          let year = moment(getDate, 'YYYY/MM/DD').year();
          // console.log(day);
          // console.log(month);
          // console.log(year);
          $.ajax({
            type: "POST",
            url: "{{url('getAllPickupForMonth')}}",
            data: {'month':month,'year':year,"_token":"{{ csrf_token() }}"},
            success: function(result){
              // console.log(result)
              $('.totalPickupOfMonth').html('This Month Pickup :'+result); 
            }
          });
      }
    })

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
  })
</script>


    <script type="text/javascript">
      //  For   Bootstrap  datatable 
      $(function () {

        $('#example1').dataTable({
          "ordering": false,
          //"bPaginate": true,
          "bLengthChange": true,
          "pageLength": 2,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
        
      });

    </script>
@endsection
