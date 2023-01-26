@extends('admin.layouts.mainlayout')
@section('title') <title>Add Technician</title>

@endsection





@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
        Add Technician 
            <small>New</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">General Elements</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            @if(Session::has('msg'))
              {!!  Session::get("msg") !!}
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header pre-wrp">
                    <form action="{{ url('admin/save_technician') }}" method="post" >  <!--dashboard-->
                        {{ csrf_field() }}
                        <div class="row">
                              <div class="col-md-offset-5 col-md-7">
                                  <div class="form-group">
                                    <label for="company_name">Company Name <span class="text-danger"> * </span></label>
                                    @if(count($all_pharmacies)  && isset($all_pharmacies))
                                    <select class="form-control" id="company_name" name="company_name" required  >
                                      <option value="">--Select Company --</option>
                                      @foreach($all_pharmacies as $row)
                                      <option value="{{$row->website_id}}" @if(old('company_name')==$row->website_id) {{'selected'}}  @endif >{{$row->company_name}} - {{$row->name}}</option>
                                      @endforeach
                                    </select>
                                    @endif
                                  </div>
                              </div>
                            <div class="col-xs-6">  
                               <div class="form-group">
                                <label for="first_name">{{__('First Name')}} <span class="text-danger"> * </span></label>
                                    <input type="text" required="required" onkeypress="return restrictNumerics(event);"  name="first_name" value="{{old('first_name')}}" class="form-control" placeholder="First Name"/>
                                </div>
                                <div class="form-group">
                                <label for="last_name">{{__('Last Name')}}  <span class="text-danger"> * </span></label>
                                    <input type="text" onkeypress="return restrictNumerics(event);"  name="last_name" class="form-control" value="{{old('last_name')}}" placeholder="Last Name"/>
                                </div>
                               
                                <div class="form-group">
                                    <label for="phone">{{__('Phone')}} <span class="text-danger"> * </span></label>
                                    <!-- <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>&nbsp;
                                      </div>
                                      <div class="input-group-addon">
                                        +04
                                      </div>
                                      
                                    </div> -->
                                    <input type="text" value="{{old('phone')?old('phone'):'04'}}"  required="required" name="phone" class="form-control" maxlength="10" onkeypress="return restrictAlphabets(event);"  placeholder="Phone"/>
                                </div>
                                <div class="form-group">
                                   <label for="address">{{__('Address   Or')}} <span class="text-danger"> * </span> <a href="#" data-toggle="modal" data-target="#my_map_Modal" style="cursor: pointer;">{{__('set to  map marker')}}</a> </label>
                                   <textarea name="address" required="required" style="resize:none;" id="address" onFocus="geolocate()" class="form-control" cols="30" rows="5" placeholder="Enter address">{{old('address')}}</textarea>
                                </div>
                                <!-- <a href="{{url('/')}}" class="text-center">I already have a membership</a> -->
                            </div><!-- /.col -->
                            <div class="col-xs-6">
                                <div class="form-group">
                                <label for="email">{{__('Email')}} <span class="text-danger"> * </span></label>
                                    <input type="text"  name="email" value="{{old('email')}}" required="required" class="form-control" placeholder="Email"/>
                                </div>
                                <div class="form-group">
                                <label for="password">{{__('Password')}} <span class="text-danger"> * </span></label>
                                    <input type="password"  name="password" value="{{old('password')}}" required="required" class="form-control" placeholder="Password"/>
                                </div>
                                <div class="form-group">
                                <label for="password_confirmation">{{__('Confirm Password')}} <span class="text-danger"> * </span></label>
                                    <input type="password" required="required" value="{{old('password_confirmation')}}" name="password_confirmation" class="form-control" placeholder="Confirm Password"/>
                                </div>

                                <div class="form-group">
                                <label for="email">{{__('Username')}} <span class="text-danger"> * </span></label>
                                    <input type="text"  name="username" value="{{old('username')}}" required="required" class="form-control" placeholder="username"/>
                                </div>

                                <div class="form-group">
                                <label for="pin">{{__('Pin')}} <span class="text-danger"> * </span></label>
                                    <input type="text" maxlength="4" id="pin" minlength="4" onkeypress="return restrictAlphabets(event);"    value="{{old('pin')}}" name="pin" class="form-control" placeholder="Pin"/>
                                </div>
                                
                                <div class="checkbox icheck">
                                    <label> <input type="checkbox" @if(old('term')=='on') {{'checked'}}@endif name="term"> <span class="text-danger"> * </span> {{__('I agree to the general terms and conditions .')}} . </label>
                                </div>
                                
                               <button type="submit" class="btn btn-primary btn-flat">{{__('Submit')}}</button>
                            </div><!-- /.col -->
                            

                        </div>
                    </form>     
                </div><!-- /.box-header -->
              </div><!-- /.box -->


          </div>   <!-- /.row -->
        </section><!-- /.content -->



         

      </div><!-- /.content-wrapper -->



 
      <!-- Modal -->
    <div class="modal fade" id="my_map_Modal" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Select Address</h4>
            </div>
            <form action="#"  method="post" >
            {{ csrf_field() }}
              <div class="modal-body" style="padding:0px; " >
                <input type="hidden"  name="event_date"  id="event_date" />
                <div id="myMap" style="height:435px;  width:100%;     position: static; "></div>
                <input id="map_address" type="text" style="width:600px; display:none; "/><br/>
                <input type="hidden" id="latitude" placeholder="Latitude"/>
                <input type="hidden" id="longitude" placeholder="Longitude"/>
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
            </div>
            </form>
          </div>
        </div>
      </div>

@endsection


@section('customjs')


<script type="text/javascript">

    //     restrict Alphabets  
    function restrictAlphabets(e){
          var x=e.which||e.keycode; 
          if((x>=48 && x<=57) || x==8 ||
            (x>=35 && x<=40)|| x==46)
            return true;
          else
            return false;
      }

     function restrictNumerics(e){
        var x=e.which||e.keycode; 
        if((x>=65 && x<=90) || x==8 ||
        (x>=97 && x<=122)|| x==95)
        return true;
        else
        return false;
      }

      function string_to_slug(str) {
        str = str.replace(/^\s+|\s+$/g, ''); // trim
        str = str.toLowerCase();

        // remove accents, swap ñ for n, etc
        var from = "àáãäâèéëêìíïîòóöôùúüûñç·/_,:;";
        var to = "aaaaaeeeeiiiioooouuuunc------";

        for (var i = 0, l = from.length; i < l; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes

        return str;
    }


    $('#company_name').click(function(){
           if($(this).val()){
            $.ajax({
                  type: "POST",
                  url: "{{url('admin/get_parmacydata_by_website_id')}}",
                  data: {'website_id':$(this).val(),"_token":"{{ csrf_token() }}"},
                  beforeSend: function() {
                    $('.loader_company').html('<i class="fa fa-spinner fa-spin"></i>');
                  },
                  success: function(result){
                      $('.loader_company').html('');
                      $('.alert_company').html(''); 
                      $('select[id="company_name"]').css('border','none');
                      //  console.log(result.facility)
                       console.log(result.patient)
                      //  $('#patient_name').html(result.patient);
                      //  $('#store').html(result.store);
                      $('#pin').val(result.pin); 
                        
                  }
             });
           }
      });

      //  For   Bootstrap  datatable 
      $(function () {
        // $('#company_name').keyup(function(){
        //        $('#host_name').val(string_to_slug($(this).val())); alert("hi"); 
        //   }); 
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

  /* Start  The  map  Address    Code  */

  var options = {
  
  componentRestrictions: {country: "AU"}
 };

  var map;
  var marker;
  var myLatlng = new google.maps.LatLng(-25.274399,133.775131);
  var geocoder = new google.maps.Geocoder();
  var infowindow = new google.maps.InfoWindow();

  var placeSearch, autocomplete;


  function initialize(){

     autocomplete = new google.maps.places.Autocomplete(document.getElementById('address'), options);


    ///
    var mapOptions = {
      zoom: 5,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      
      componentRestrictions: {country: "AU"}
    };

    map = new google.maps.Map(document.getElementById("myMap"), mapOptions);

    marker = new google.maps.Marker({
      map: map,
      position: myLatlng,
      draggable: true
    });

    geocoder.geocode({'latLng': myLatlng }, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {
              $('#latitude,#longitude').show();
              $('#map_address').val(results[0].formatted_address); 
              // $('#address').val(results[0].formatted_address);
              $('#latitude').val(marker.getPosition().lat());
              $('#longitude').val(marker.getPosition().lng());
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
          }
      }
    });

    google.maps.event.addListener(marker, 'dragend', function() {

    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
            $('#map_address').val(results[0].formatted_address); 
            $('#address').val(results[0].formatted_address);
            $('#latitude').val(marker.getPosition().lat());
            $('#longitude').val(marker.getPosition().lng());
            infowindow.setContent(results[0].formatted_address);
            infowindow.open(map, marker);
        }
      }
    });
  });

}


        google.maps.event.addDomListener(window, 'load', initialize);

        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        function geolocate() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
              var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
              };
              var circle = new google.maps.Circle(
                  {center: geolocation, radius: position.coords.accuracy});
              autocomplete.setBounds(circle.getBounds());
            });
          }
        }

      $(function () {

        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });

      });
     


      



    </script>
@endsection
