@extends('admin.layouts.mainlayout')
@section('title') <title>Add Patients</title>

 @endsection
 @section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           Add Patients
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="dashboard">Forms</a></li>
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
            <div class="alertmsg"></div>
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header">
                <form role="form"  id="addPatientForm" action="javascript:void(0)" {{url('admin/save_patient')}}  method="post" enctype="multipart/form-data">
                
                  <div class="box-body pre-wrp">
                    <div class="col-md-offset-5 col-md-7">
                            <div class="form-group">
                              <label for="company_name">Company Name <span class="text-danger"> *</span></label>
                              @if(count($all_pharmacies)  && isset($all_pharmacies))
                              <select class="form-control" name="company_name"   id="company_name" >
                                <option value="">--Select Company --</option>
                                @foreach($all_pharmacies as $row)
                                <option value="{{$row->website_id}}">{{$row->company_name}} - {{$row->name}}</option>
                                @endforeach
                              </select>
                              @endif
                            </div>
                    </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="first_name">First Name <span class="text-danger"> *</span></label>
                              <input type="text"  onkeypress="return restrictNumerics(event);" class="form-control" maxlength="20"   id="first_name" value="{{old('first_name')}}" name="first_name" placeholder="First Name..">
                            </div>
                            <div class="form-group">
                                <label for="dob">Date Of Birth <span class="text-danger"> *</span></label>
                                <input type="date"   class="form-control" max="{{Carbon\Carbon::now()->format('Y-m-d')}}"   name="dob" value="{{old('dob')}}"  id="dob" placeholder="Date Of Birth" >
                              </div>

                              <!-- textarea -->
                            <div class="form-group">
                                <label for="address">Address </label> Or <a href="#" data-toggle="modal" data-target="#my_map_Modal" style="cursor: pointer;">set to  map </a>
                                <input type="text" class="form-control" value="{{old('address')}}"   id="address"   name="address" placeholder="Address.."/>
                            </div>
                            <label>Location </label>
                            <div class="form-group checkbox-wrp">
                              @if(isset($all_Location)  && count($all_Location))
                                  @foreach($all_Location as  $value)
                                    <label>
                                        <input type="checkbox" {{ (is_array(old('location')) and in_array($value->id, old('location'))) ? ' checked' : '' }} name="location[]" class="minimal " value="{{$value->id}}"  />&nbsp;{{$value->name}} &nbsp;                               
                                    <label>
                                  @endforeach
                               @endif
                                <!-- <label>
                                    <input type="checkbox" name="location[]"   class="minimal" value="shelf"  />&nbsp;Shelf
                                </label>
                                <label>
                                    <input type="checkbox" name="location[]"  class="minimal" value="fridge" />&nbsp;Fridge
                                </label>
                                <label>
                                    <input type="checkbox" name="location[]"  class="minimal" value="safe"  />&nbsp;Safe
                                </label> -->
                            </div>
                            
                            <!-- <label>Get a text  when picked up/Delivered ?</label> -->
                            <div class="form-group">
                                <label>Get a text  when picked up/Delivered ? &nbsp;&nbsp; 
                                  <input type="checkbox" name="up_delivered" id="up_delivered"  class="minimal" />&nbsp;
                                  <span class='load_mobile' style="display:none;"><i class="fa fa-spinner fa-spin fa-lg fa-fw"></i></span>
                                </label>
                            </div>
                            



                        </div>

                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Last Name <span class="text-danger"> *</span> </label>
                            <input type="text" onkeypress="return  restrictNumerics(event);" class="form-control" maxlength="20"   id="last_name" name="last_name" placeholder="Last Name..">
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Mobile Number <span class="text-danger"> *</span></label>
                            <input type="text" class="form-control" value="{{old('phone')?old('phone'):'04'}}"   maxlength="10" onkeypress="return restrictAlphabets(event);" id="phone_number"   name="phone_number" placeholder="+613214569875">
                        </div>
                        <div class="form-group">
                            <label for="facility">Facility <span class="text-danger"> *</span></label>
                            <input type="text" name="facility" id="facility" list="facilitylist"  class="form-control" placeholder="Enter Facility">
                            <datalist id="facilitylist"> 
                            @if(isset($all_facilities))
                            @foreach($all_facilities as $row)
                            <option value="{{$row->name}}">{{$row->name}}</option>
                            @endforeach @endif
                            </datalist>
                        </div>
                        <div class="form-group otherinput"></div>
                        <div class="form-group"  id="mobile_no">
                            
                        </div>
                        <div class="form-group" style="display:none;" id="same_as" >
                                <label>{{__('Secondary Number')}}  &nbsp;&nbsp; 
                                  <input type="checkbox" name="same_as_above" id="same_as_above"  class="minimal" />&nbsp;
                                  <span class='load_mobile2' style="display:none;"><i class="fa fa-spinner fa-spin fa-lg fa-fw"></i></span>
                                </label>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-4">
                          <button type="submit" class="btn btn-primary btn-block addPatientBtn">Add Patient</button>
                          </div>
                       </div>
                              
                              
                              

                              
                              

                        </div>
                        <!-- <div class="box-footer">
                          <button type="submit" class="btn btn-primary">Add A Driver</button>
                        </div> -->
                       
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
          <div class="modal-content" style="height: 500px;" >
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



        <!-- Modal for Patient Dob -->
    <div class="modal fade" id="patientDob_Modal" role="dialog">
        <div class="modal-dialog modal-xs">
          <div class="modal-content"  style="height: 192px;">
            <div class="modal-header">
              <p class="errorfornotchecked text-danger text-center"></p>
              <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
              <h4 class="modal-title text-center">Confirmation</h4>
            </div>

            
              <div class="modal-body text-center" style="padding:0px; " >
                <div class="form-group">
                   <label>
                     <span>I have acknowledging to add patient below 18 year  </span>
                     <input type="checkbox"  name="accept_age" id="accept_age"  class="minimal" />
                   </label>
                   
                </div>
                <div class="form-group">
                  <button type="button" class="btn btn-primary age_yes" >Yes</button>
                  <button type="button" class="btn btn-primary age_no" >No</button>
                </div>
                
              </div>
            <div class="modal-footer">
              <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button> -->
            </div>
            
          </div>
        </div>
      </div>

@endsection


@section('customjs')


    <script type="text/javascript">

      
    $(document).ready(function(){

        /*  Start of the Add Patient  By  AJax */
      $("#addPatientForm").on('submit', function(e) {
            // console.log($(this).serialize()+'&_token='+'{{ csrf_token() }}')
               
               e.preventDefault();
               if($('#first_name').val() && $('#last_name').val() &&   $('#dob').val() && $('#company_name').val() && $('#phone_number').val() && $('#facility').val() ){
                $('.alertmsg').html('');
                
                $.ajax({
                  type: "POST",
                  url: "{{url('admin/checkduplicatePatient')}}",
                  data: $('#addPatientForm').serialize()+'&_token='+'{{ csrf_token() }}',
                  beforeSend: function() {
                    $('.addPatientBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                  },
                  success: function(result){
                    console.log(result)
                    if(result=='1'){
                      if(confirm("There is another patient with the same name and DOB, are you sure you want to add this patient as well?")){
                        $.ajax({
                          type: "POST",    
                          url: "{{url('admin/save_patient')}}",
                          data: $('#addPatientForm').serialize()+'&_token='+'{{ csrf_token() }}',
                          success: function(result){
                            $('.addPatientBtn').html('Add Patient');
                            console.log(result.errors)
                             if(result.errors==""){
                                // alert(result.success);
                                $("#addPatientForm")[0].reset();
                                $('input[type=checkbox]').parent().removeClass("checked");
                                $('#mobile_no').html("");
                                $('.alertmsg').html('<div class="alert alert-success"> <strong>Patient</strong> Added Successfully.</div>');
                              }else{
                                 printErrorMsg(result.errors);   
                              } 
                          },
                          error:function(result){
                            if(result.errors!=""){
                                printErrorMsg(result.errors);
                              }
                          }
                        });
                      }
                      else{
                        $('.addPatientBtn').html('Add Patient');
                      }
                       
                    }
                    else if(result=='0'){
                       // alert("new records "); 
                        $.ajax({
                          type: "POST",
                          url: "{{url('admin/save_patient')}}",
                          data: $('#addPatientForm').serialize()+'&_token='+'{{ csrf_token() }}',
                          success: function(result){
                            $('.addPatientBtn').html('Add Patient');
                            
                             //console.log(result)
                             console.log(result.errors)
                              if(result.errors==""){
                                //  alert(result.success);
                                $("#addPatientForm")[0].reset();
                                $('input[type=checkbox]').parent().removeClass("checked");
                                $('#mobile_no').html("");
                                 $('.alertmsg').html('<div class="alert alert-success"> <strong>Patient</strong> Added Successfully.</div>');
                              }else{
                                  printErrorMsg(result.errors);
                              }
                          },
                          error:function(result){
                              if(result.errors!=""){
                                printErrorMsg(result.errors);
                              }
                          }
                        }); 
                    }
                    else{
                      $('.alertmsg').html('<div class="alert  alert-danger"> Somting went wrong! </div>'); 
                    }
                  }
                }); 
                
               
                 
               }
               else{
                 $('.alertmsg').html('<div class="alert  alert-danger"> All * fields are required !.</div>'); 
               }
        });
        /*  ENd of the Add Patient  By  AJax */
            var m=$("input[type=checkbox][name='up_delivered']:checked").val();
           if(m=='undefined')
           {
            $('#mobile_no').html(""); 
           }
           else if(m=='1')
           {
               $('#mobile_no').html('<label for="mobile_no">Mobile <span class="text-danger"> *</span></label><input type="text" class="form-control" maxlength="10"  onkeypress="return restrictAlphabets(event);" id="mobile_no"  name="mobile_no" placeholder="+613214569875">');
           }
        
           

           $('#dob').change(function(){

              var today = new Date();
              var olday = new Date(this.value);
              // console.log(dateDiff(olday, today));

              if(dateDiff(olday, today)<18){
                   $('#patientDob_Modal').modal('toggle'); 
              }
        }); 

        $('.age_yes').click(function(){

          if($("#accept_age").prop('checked') == true){
             $('.errorfornotchecked').html("");
             $('#patientDob_Modal').modal('toggle');
          }
          else{
            $('.errorfornotchecked').html('<span >Accept  acknowledgment about age.</span>'); 
          }
                        
        }); 
        $('.age_no').click(function(){
          $('#dob').val("");
          $('#patientDob_Modal').modal('toggle');
        }); 

        



            
    });

    function printErrorMsg (msg) {
            $('.alertmsg').html('<div class="alert alert-danger">\
                    <ul class="newalertdata"></ul></div>')
            $.each( msg, function( key, value ) {
                $(".newalertdata").append('<li>'+value+'</li>');
            });
    }

function dateDiff(dateold, datenew)
    {
      var ynew = datenew.getFullYear();
      var mnew = datenew.getMonth();
      var dnew = datenew.getDate();
      var yold = dateold.getFullYear();
      var mold = dateold.getMonth();
      var dold = dateold.getDate();
      var diff = ynew - yold;
      if(mold > mnew) diff--;
      else
      {
        if(mold == mnew)
        {
          if(dold > dnew) diff--;
        }
      }
      return diff;
    }

          $(function () {

        //Datemask yyyy-mm-dd
        // $("#dob").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
        // var pickerOptsGeneral = { format: "yyyy-mm-dd", autoclose: true, minView: 2, maxView: 2, todayHighlight: true }; //  ,startDate:  new Date()
        // $('#dob').datetimepicker(pickerOptsGeneral).on('changeDate',function(ev){}); 


         //iCheck for checkbox and radio inputs
          $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        }); 

        
        

          $("input[type=checkbox][name='up_delivered']").on('ifToggled', function(event){
             $('.load_mobile').css('display','block'); 
              var checked = $(this).closest('div.icheckbox_minimal-blue').hasClass("checked");
              //  checked ==  false  ||  unchecked ==  true 
              if(checked==false)
              {
                $('#same_as').css('display','block'); 
                // $('#mobile_no').html('<label for="mobile_no">Mobile <span class="text-danger"> *</span></label><input type="text" class="form-control" maxlength="10"  onkeypress="return restrictAlphabets(event);" id="mobile_no"  name="mobile_no" placeholder="+613214569875">');
              }
              else
              {
                $('#same_as').css('display','none'); 
                // $('#mobile_no').html("");
              }
              $('.load_mobile').css('display','none');
            });
            $("input[type=checkbox][name='same_as_above']").on('ifToggled', function(event){
             $('.load_mobile2').css('display','block'); 
              var checked = $(this).closest('div.icheckbox_minimal-blue').hasClass("checked");
              //  checked ==  false  ||  unchecked ==  true 
              if(checked==false)
              { 
                $('#mobile_no').html('<label for="mobile_no">Mobile <span class="text-danger"> *</span></label><input type="text" class="form-control" maxlength="10"  onkeypress="return restrictAlphabets(event);" id="mobile_no"  name="mobile_no" placeholder="+613214569875">');
              }
              else
              {
                $('#mobile_no').html("");
                
              }
              $('.load_mobile2').css('display','none');
              
            });

      });
     
    /*Other input  */
      $('#facility').change(function(){
           if($(this).val()=='5'){
              $('.otherinput').html('<input type="text" name="other_facility" id="other_facility" class="form-control"  placeholder="Other Facility * ">'); 
            } 
           else
           {
            $('.otherinput').html('');
           }
        });
   


      function restrictAlphabets(e){
        var x=e.which||e.keycode; 
        if((x>=48 && x<=57) )
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

      /* get All Patient  List  By  Website id */
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
                      //  console.log(result.facility)
                      $('#facilitylist').html(result.facility);
                       
                  }
             });
           }
      });


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
   





      

    </script>
@endsection
