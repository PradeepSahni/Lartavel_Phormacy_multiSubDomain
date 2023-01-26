@extends('admin.layouts.mainlayout')
@section('title') <title>Add Pharmacy</title>
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
        Pharmacy Registration 
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
                    <form action="{{ url('admin/save_pharmacy') }}" method="post" autocomplete="off">  <!--dashboard-->
                        {{ csrf_field() }}
                        
                        
                        <div class="row">
                          <div class="col-xs-6">
                                
                                @if(isset($all_subscription) && count($all_subscription))
                                <label class="mt-20">Subcription Plan <span class="text-danger">*</span></label>
                                <div class="form-group mt-10">
                                    @foreach($all_subscription as $key=>$row)
                                    <label>
                                      <input type="radio" required="required" name="subscription" class="flat-red"  value="{{$row->id}}" @if(old('subscription')==$row->id) {{'checked'}} @elseif($key=='0') {{'checked'}} @endif /> {{ucfirst($row->title)}}
                                    </label>
                                    @endforeach
                                </div>
                                @endif
                                <div class="form-group">
                                <label for="company_name">Company Name <span class="text-danger">*</span></label>
                                    <input type="text"  name="company_name" maxlength="50" value="{{old('company_name')}}" id="company_name" required="required" class="form-control" placeholder="Company Name"/>
                                </div>
                                <div class="form-group" id="host-name-div" style="">
                                    <label>We will setup packnpeaks for you at:</label><br>
                                    https://www.<input type="text" style="border:none;" value="{{old('host_name')}}" maxlength="50" name="host_name" maxlength="50" id="host_name"  autocomplete="host-name">.packnpeaks.tk
                                    
                                </div>
                                
                                <div class="form-group">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password"  name="password" value="{{old('password')}}" required="required" class="form-control" placeholder="Password"/>
                                </div>
                                <div class="form-group">
                                <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" required="required" value="{{old('password_confirmation')}}" name="password_confirmation" class="form-control" placeholder="Confirm Password"/>
                                </div>
                                <div class="checkbox icheck">
                                    <label> <input type="checkbox" name="term" required="required" @if(old('term')=='on') {{'checked'}} @endif  > <span class="text-danger">*</span>  I agree to the general terms and conditions . </label>
                                </div>

                               
                            </div><!-- /.col -->
                            <div class="col-xs-6">  
                              <div class="form-group">
                                    <label for="phone">Phone <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                    <!-- <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>&nbsp;
                                      </div> -->
                                     <!--  <div class="input-group-addon">
                                        +04
                                      </div> -->
                                      <input type="text" required="required"  name="phone" value="{{old('phone')?old('phone'):'04'}}" class="form-control" maxlength="10" onkeypress="return restrictAlphabets(event);"  placeholder="Phone"/>
                                    </div>
                                </div>
                               <div class="form-group">
                                <label for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" value="{{old('first_name')}}" onkeypress="return restrictNumerics(event);"  name="first_name" required="required" class="form-control" placeholder="First Name"/>
                                </div>
                                <div class="form-group">
                                <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" value="{{old('last_name')}}" required="required" onkeypress="return restrictNumerics(event);" name="last_name" class="form-control" placeholder="Last Name"/>
                                </div>
                                <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span> <span class="text-danger"> </span></label>
                                    <input type="text"  value="{{old('email')}}" required="required" name="email" class="form-control" placeholder="Business Email"/>
                                </div>
                                <div class="form-group">
                                <label for="address">Address   Or <a href="#" data-toggle="modal" data-target="#my_map_Modal" style="cursor: pointer;">set to  map marker</a> <span class="text-danger">*</span></label>
                                   <textarea name="address" required="required" style="resize:none;" id="address" onFocus="geolocate()" class="form-control" cols="30" rows="3" placeholder="Enter address">{{old('address')}}</textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-flat">Register</button>
                                <!-- <a href="{{url('/')}}" class="text-center">I already have a membership</a> -->
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
                <div id="myMap" style="height:350px;  width:100%;     position: static; "></div>
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

      /*Restrict Numeric */
      function restrictNumerics(e){
        var x=e.which||e.keycode; 
        if((x>=65 && x<=90) || x==8 ||
        (x>=97 && x<=122)|| x==95 || x==32)
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
      //  For   Bootstrap  datatable 
      $(function () {
        $('#company_name').keyup(function(){
          var m=string_to_slug($(this).val());
         
               $('#host_name').val(m);
          }); 
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
