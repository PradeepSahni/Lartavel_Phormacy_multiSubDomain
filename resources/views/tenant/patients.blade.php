@extends('tenant.layouts.mainlayout')
@section('title') <title>Add Patients</title>
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           {{__('Add Patients')}}
            <small>{{__('Preview')}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
            <li><a href="#">{{__('Patient')}}</a></li>
            <li class="active">{{__('Add patient')}}</li>
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
                <form role="form" id="addPatientForm" action="javascript:void(0)" {{url('save_patient')}}  method="post" enctype="multipart/form-data" id="add_patient">
                
                  <div class="box-body pre-wrp">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="first_name">{{__('First Name')}} <span style="color:red">*</span></label>
                              <input  value="{{old('first_name')}}" onkeypress="return restrictNumerics(event);" type="text" class="form-control @error('first_name') is-invalid @enderror" maxlength="20"   id="first_name" name="first_name" placeholder="First Name..">
                              @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                              @enderror
                           </div>

                            <div class="form-group">
                                <label for="dob">{{__('Date Of Birth')}} <span style="color:red">*</span></label>
                                <input  value="{{old('dob')}}"  type="date" class="form-control @error('dob') is-invalid @enderror"  id="dob" name="dob"  data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  placeholder="Date Of Birth"  max="{{Carbon\Carbon::now()->format('Y-m-d')}}" >
                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                              <!-- textarea -->

                            <div class="form-group">
                                <label for="address">Address </label> Or <a href="#" data-toggle="modal" data-target="#my_map_Modal" style="cursor: pointer;">set to  map </a>
                                <input type="text" class="form-control"   id="address"   name="address" placeholder="Address.."/>
                            </div>

                            
                            <label>{{__('Location')}} </label>
                            <div class="form-group checkbox-wrp">
                              @foreach($locations as $location)
                               
                                <label>
                                    <input  {{ (is_array(old('location')) and in_array($location->name, old('location'))) ? ' checked' : '' }} type="checkbox" name="location[]"  class="minimal @error('no_of_weeks') is-invalid @enderror" value="{{$location->id}}"  readonly="readonly"/>&nbsp;{{$location->name}}</label>
                                <label>
                              @endforeach
                              @error('location[]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                              @enderror
                            </div>
                            <!-- <label>Get a text  when picked up/Delivered ?</label> -->
                            <div class="form-group">
                                <label>{{__('Get a text  when picked up/Delivered ?')}} &nbsp;&nbsp; 
                                  <input type="checkbox"  {{old('up_delivered')?'checked':''}} name="up_delivered" id="up_delivered"  class="minimal @error('up_delivered') is-invalid @enderror" />&nbsp;
                                  <span class='load_mobile' style="display:none;"><i class="fa fa-spinner fa-spin fa-lg fa-fw"></i></span>
                                </label>
                                @error('up_delivered')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            

                        </div>

                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">{{__('Last Name')}}<span style="color:red">*</span></label>
                            <input  value="{{old('last_name')}}" onkeypress="return restrictNumerics(event);" type="text" class="form-control @error('last_name') is-invalid @enderror" maxlength="20"   id="last_name" name="last_name" placeholder="Last Name..">
                              @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                        
                        </div>
                        <div class="form-group">
                            <label for="phone">{{__('Mobile Number')}}  <span style="color:red">*</span></label>
                            <input type="text"  value="{{old('phone_number')?old('phone_number'):'04'}}" class="form-control checkIsPhoneNo  @error('phone_number') is-invalid @enderror" maxlength="10" minlength="10" onkeypress="return restrictAlphabets(event);" id="phone"  name="phone_number" placeholder="XXXXX XXXXX">
                            @error('phone_number')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="facility">{{__('Facility')}}<span style="color:red">*</span></label>
                            <input type="text" value="{{old('facilities_id')}}"  list="facilitylist" name="facilities_id" id="facility" class="form-control @error('facilities_id') is-invalid @enderror" placeholder="Enter Facility">
                            <datalist id="facilitylist">
                            @php $facility_name='';  @endphp
                              @foreach($facilities as $facility)
                                @php
                                  if(old('facilities_id')==$facility->id){
                                    $facility_name=$facility->name;
                                  }
                                @endphp
                                <option  {{old('facilities_id')==$facility->id?'selected':''}} value="{{$facility->name}}">{{$facility->name}}</option>
                              @endforeach
                            </datalist>
                            @error('facilities_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group" id="facility_other_desc_div" style="display:{{$facility_name==strtolower('Other')?'block':'none'}};">
                            <label for="facility_other_desc">{{__('Other Description')}}<span style="color:red">*</span></label>
                                <input  value="{{old('facility_other_desc')}}" type="text" class="form-control @error('facility_other_desc') is-invalid @enderror" maxlength="20"   id="facility_other_desc" name="facility_other_desc" placeholder="Facility other description">
                               
                              @error('facility_other_desc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                        </div>
                        <div class="form-group" style="display:{{old('up_delivered') && old('same_as_above')==false?'none':'block'}};" id="mobile_no_div">
                            
                        </div>
                        <div class="form-group" style="display:{{old('up_delivered')?'block':'none'}};" id="same_as" >
                                <label>{{__('Secondary Number')}} 
                                  <input type="checkbox"  {{old('same_as_above')?'checked':''}} name="same_as_above" id="same_as_above"  class="minimal @error('same_as_above') is-invalid @enderror" />&nbsp;
                                  <span class='load_mobile2' style="display:none;"><i class="fa fa-spinner fa-spin fa-lg fa-fw"></i></span>
                                </label>
                                @error('same_as_above')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <div class="row">
                          <div class="col-md-4">
                          <button type="submit" class="btn btn-primary btn-block addPatientBtn">{{__('Add Patient')}}</button>
                          </div>
                       </div>

                        </div>

                       
                 </div>

                </form>


                </div><!-- /.box-header -->
                <div class="box-footer">
                  <h1><b>OR</b></h1> <a href="{{url('public/Patients.csv')}}" class="btn btn-success btn-xs pull-right">Csv Format Download</a>
                <form role="form" action="{{url('import_patients')}}" method="post" enctype="multipart/form-data" >
                {{ csrf_field() }}
                  <div class="box-body pre-wrp">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="first_name">Select Patients Csv OR Excel <span style="color:red">*</span></label>
                              <input type="file"  name="patient_file" placeholder="Choose your Patients File"  class="form-control">
                            </div>

                        </div>

                        <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-4" style="padding-top:25px;">
                          <button type="submit" class="btn btn-primary btn-block">Import Patients</button>
                          </div>
                       </div>

                        </div>
                 </div>

                </form>

                
                </div><!-- bOx -foooter -->
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
                <div id="myMap" style="height:400px;  width:100%;     position: static; "></div>
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
          <div class="modal-content">
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



         
        $("#addPatientForm").on('submit', function(e) {
            // console.log($(this).serialize()+'&_token='+'{{ csrf_token() }}')
               
               e.preventDefault();
               if($('#first_name').val() && $('#last_name').val() &&   $('#dob').val() && $('#facility').val() ){
                $('.alertmsg').html('');
                
                $.ajax({
                  type: "POST",
                  url: "{{url('checkduplicatePatient')}}",
                  data: $('#addPatientForm').serialize()+'&_token='+'{{ csrf_token() }}',
                  beforeSend: function() {
                    $('.addPatientBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                  },
                  success: function(result){
                    if(result=='1'){
                      if(confirm("There is another patient with the same name and DOB, are you sure you want to add this patient as well?")){
                        $.ajax({
                          type: "POST",    
                          url: "{{url('save_patient')}}",
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
                        //alert("new records "); 
                        $.ajax({
                          type: "POST",
                          url: "{{url('save_patient')}}",
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
                 $('.alertmsg').html('<div class="alert  alert-danger"> All  * fields are required .</div>'); 
               }
        });
        
        var m=$("input[type=checkbox][name='up_delivered']:checked").val();
        if(m=='undefined')
        {
          $('#mobile_no_div').css('display','none'); 
          $('#mobile_no').removeAttr('');
        }
        else if(m=='1')
        {
          
          $('#mobile_no_div').css('display','block'); 
          $('#mobile_no').prop('',true);
        }
          
        $('#facility').change(function(){
            if($(this).children("option:selected").text()=='other'){
              $('#facility_other_desc_div').show();
              $('#facility_other_desc').prop('',true);
            }else{
              $('#facility_other_desc_div').hide();
              $('#facility_other_desc').removeAttr('');
            }

        });

        $('#add_patient').submit(function(){
          let obj1=$('input[type=checkbox][name="location[]"]');
          // alert(obj1.length);
          // obj1.css('border-color','red'); 
          // obj1.parent('div').removeClass('icheckbox_minimal-blue');
          // obj1.parent('div').addClass('icheckbox_minimal-red hover');return  false;
          let obj=$('input[type=checkbox][name="location[]"]:checkbox:checked');
          //alert(obj.length);
          if(obj.length>0){
            obj1.parent('div').removeClass('icheckbox_minimal-red hover');
            obj1.parent('div').addClass('icheckbox_minimal-blue');
            return true;
          }else{
            obj1.parent('div').removeClass('icheckbox_minimal-blue');
            obj1.parent('div').addClass('icheckbox_minimal-red hover');
          //  alert('wrong');
            return  false;
          }

         // return  false;
        });

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

        // $("#dob").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
       // $("[data-mask]").inputmask();
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
                // $('#mobile_no_div').css('display','block');
                $('#mobile_no').prop('',true);
              }
              else
              {
                $('#same_as').css('display','none'); 
                // $('#mobile_no_div').css('display','none');
                $('#mobile_no').removeAttr('');
              }
              $('.load_mobile').css('display','none');
            });

            $("input[type=checkbox][name='same_as_above']").on('ifToggled', function(event){

              
             
              $('.load_mobile2').css('display','block'); 
              var checked = $(this).closest('div.icheckbox_minimal-blue').hasClass("checked");
              //  checked ==  false  ||  unchecked ==  true 
            
              if(checked==false)
              {
                $('#mobile_no_div').html('<label for="mobile_no">Mobile <span class="text-danger"> *</span></label><input type="text" class="form-control" maxlength="10"  onkeypress="return restrictAlphabets(event);" id="mobile_no"  name="mobile_no" placeholder="+613214569875">');
                $('#mobile_no').prop('',true);
              }
              else
              { 
                $('#mobile_no_div').html('');
                $('#mobile_no').removeAttr('');
              }
               $('.load_mobile2').css('display','none');
              
            });

        });
     

   
   
    

      //     restrict Alphabets  
      function restrictAlphabets(e){
      var x=e.which||e.keycode; 
      if((x>=48 && x<=57) )
      return true;
      else
      return false;
     }

     function restrictNumerics(e){
        var x=e.which||e.keycode; 
        if((x>=65 && x<=90) || x==8 ||
        (x>=97 && x<=122)|| x==95 || x==32)
        return true;
        else
        return false;
      }

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

        $('.checkIsPhoneNo').change(function(){
           if($(this).val().length !='10'){
             $(this).css('border','1px solid red'); 
           }
           else{
               $(this).css('border','1px solid lightgray');
           }

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
