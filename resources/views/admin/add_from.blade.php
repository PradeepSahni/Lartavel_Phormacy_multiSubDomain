<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Update Form</title>
     <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
     <!-- Favicon  -->
     <link rel="icon" href="{{ URL::asset('media/logos/favicon.ico') }}" type="image/x-icon"/>
  <!-- Bootstrap 3.3.2 -->
  <link href="{{ URL::asset('admin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />    
        <!-- FontAwesome 4.3.0 -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
       <!--  <link href="{{ URL::asset('admin/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" /> -->
        <!-- Ionicons 2.0.0 -->
        <!-- Theme style -->
        <link href="{{ URL::asset('admin/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins 
              folder instead of downloading all of them to reduce the load. -->
        <link href="{{ URL::asset('admin/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="{{ URL::asset('admin/plugins/iCheck/flat/blue.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ URL::asset('admin/plugins/jQueryUI/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
          
        <link href="{{ URL::asset('admin/dist/css/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css"/>
        
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="{{ URL::asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- DATA TABLES --> 
        <link href="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
          <!-- Date Picker -->
        <link href="{{ URL::asset('admin/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="{{ URL::asset('admin/plugins/daterangepicker/jquery.comiseo.daterangepicker.css') }}" rel="stylesheet" type="text/css" />
        
        

          <!-- fullCalendar 2.2.5 -->  
          <link href="{{ URL::asset('admin/plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('admin/plugins/fullcalendar/fullcalendar.print.css')}}" rel="stylesheet" type="text/css" media='print' />
        <link href="{{ URL::asset('admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />

        <!--   DropZone    Css  -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/plugins/dropzone/css/dropzone.css')}}" />

        <!--  to  Add  Advanced Form feature -->
        <!-- iCheck for checkboxes and radio inputs -->
        <link href="{{ URL::asset('admin/plugins/iCheck/all.css')}}" rel="stylesheet" type="text/css" />
        <!-- Bootstrap Color Picker -->
        <link href="{{ URL::asset('admin/plugins/colorpicker/bootstrap-colorpicker.min.css')}}" rel="stylesheet"/>
        <!-- Bootstrap time Picker -->
        <link href="{{ URL::asset('admin/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet"/>
        <!-- Theme style -->
        <link href="{{ URL::asset('admin/plugins/iCheck/all.css')}}" rel="stylesheet" type="text/css" />

         <link href="{{ URL::asset('admin/dist/css/pre-style.css')}}" rel="stylesheet" type="text/css" />
 
  </head>
  <body class="wysihtml5-supported skin-blue">
      @include('admin.includes.header')
      @include('admin.includes.sidebar')

      <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           Update All  Form
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="dashboard">Forms</a></li>
            <li class="active">General Elements</li>
          </ol>
        </section>

       
       
             



         <!-- Main content -->
         <section class="content pre-wrp-in">
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
            <div class="col-xs-12">


              <div class="box">
                <div class="box-header">
                <div class="row">
                  <div class="col-sm-3">
                     <a href="{{url('admin/subscriptions')}}" class="text-center fa fa-arrow-left"> <b>Back</b></a>
                  </div>
                  <div class="col-sm-3">
                    
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-3">
                    <div class="form-group">
                    <label for="no_of_admins">Admin</label>
                    <input type="text" name="no_of_admins" id="no_of_admins"  maxlength="10" onkeypress="return restrictAlphabets(event);" value="{{$subscription[0]->no_of_admins}}" onkeyup="update_user(this,'no_of_admins')"  placeholder="No Of Admin" class="form-control">
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                     <label for="no_of_technicians">Technicians</label>
                     <input type="text" name="no_of_technicians" id="no_of_technicians" maxlength="10" onkeypress="return restrictAlphabets(event);"  value="{{$subscription[0]->no_of_technicians}}" onkeyup="update_user(this,'no_of_technicians')"  placeholder="No Of Technicians" class="form-control">
                    </div>
                  </div>
                   <div class="col-sm-3">
                     <div class="form-group">
                      <label for="app_logout_time">Logout Time</label>
                      <input type="text" name="app_logout_time" id="app_logout_time"  maxlength="10" onkeypress="return restrictAlphabets(event);" value="{{$subscription[0]->app_logout_time}}" onkeyup="update_user(this,'app_logout_time')"  placeholder="App Logout Time" class="form-control">
                      </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="form-group">
                      <label for="default_cycle">Cycle</label>
                      <input type="text" name="default_cycle" id="default_cycle"  maxlength="10" onkeypress="return restrictAlphabets(event);" value="{{$subscription[0]->default_cycle}}" onkeyup="update_user(this,'default_cycle')"  placeholder="No Of Admin" class="form-control">
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-3">
                     <!-- <a href="{{url('admin/subscriptions')}}" class="text-center fa fa-arrow-left"> <b>Back</b></a> -->
                  </div>
                  <div class="col-sm-3">
                    <div class="text-center alertmessage"></div>
                  </div>
                </div>
                  
                </div><!-- /.box-header -->
                <div class="box-body ">
                <h2 class="heading-h2">{{ucfirst($form['name'])}}</h2>

                  @if(isset($subscription) && count($subscription))
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                     <tr>
                       
                        <th style="width: 150px;" >FORM/Name</th>
                        <th style="width: 60px;" >Subscription</th>
                        <th style="width: 150px;" >FORM/Name</th>
                        <th style="width: 60px;" >Subscription</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td ><b>Add Pick Up</b></td>
                        <td>
                        <div class="onoffswitch">
                              <input type="checkbox" onchange="update_form(this)" name="form1" value="form1" @if($subscription[0]->form1=='1') checked @endif class="onoffswitch-checkbox" id="form1" tabindex="0" >
                              <label class="onoffswitch-label" for="form1">
                                  <span class="onoffswitch-inner"></span>
                                  <span class="onoffswitch-switch"></span>
                              </label>
                        </div>
                        </td>
                        <td ><b>Add Near Misses</b></td>
                        <td>
                        <div class="onoffswitch">
                              <input type="checkbox" onchange="update_form(this)" name="form11" value="form11" @if($subscription[0]->form11=='1') checked @endif class="onoffswitch-checkbox" id="form11" tabindex="0" >
                              <label class="onoffswitch-label" for="form11">
                                  <span class="onoffswitch-inner"></span>
                                  <span class="onoffswitch-switch"></span>
                              </label>
                        </div>
                        </td>
                      </tr>
                      <tr>
                        <td ><b>PickUps Report</b></td>
                        <td>
                        <div class="onoffswitch">
                              <input type="checkbox" onchange="update_form(this)" name="form2" value="form2" @if($subscription[0]->form2=='1') checked @endif class="onoffswitch-checkbox" id="form2" tabindex="0">
                              <label class="onoffswitch-label" for="form2">
                                  <span class="onoffswitch-inner"></span>
                                  <span class="onoffswitch-switch"></span>
                              </label>
                        </div>
                        </td>
                         <td ><b>All Near Misses</b></td>
                          <td>
                          <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form12" value="form12" @if($subscription[0]->form12=='1') checked @endif class="onoffswitch-checkbox" id="form12" tabindex="0" >
                                <label class="onoffswitch-label" for="form12">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                          </div>
                          </td>
                      </tr>
                      <tr>
                                              
                          <td ><b>PickUps Calender</b></td>
                          <td>
                          <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form3" value="form3" @if($subscription[0]->form3=='1') checked @endif class="onoffswitch-checkbox" id="form3" tabindex="0" >
                                <label class="onoffswitch-label" for="form3">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                          </div>
                          </td>
                          <td ><b>Last Month Miss Reports</b></td>
                          <td>
                          <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form13" value="form13" @if($subscription[0]->form13=='1') checked @endif class="onoffswitch-checkbox" id="form13" tabindex="0" >
                                <label class="onoffswitch-label" for="form13">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                          </div>
                          </td>
                      </tr>
                      <tr>
                        <td ><b>6 Monthly Compliance Reports</b></td>
                        <td>
                        <div class="onoffswitch">
                              <input type="checkbox" onchange="update_form(this)" name="form4" value="form4" @if($subscription[0]->form4=='1') checked @endif class="onoffswitch-checkbox" id="form4" tabindex="0" >
                              <label class="onoffswitch-label" for="form4">
                                  <span class="onoffswitch-inner"></span>
                                  <span class="onoffswitch-switch"></span>
                              </label>
                        </div>
                        </td>
                        <td ><b>Near Miss Monthly Reports v2</b></td>
                        <td>
                        <div class="onoffswitch">
                              <input type="checkbox" onchange="update_form(this)" name="form14" value="form14" @if($subscription[0]->form14=='1') checked @endif class="onoffswitch-checkbox" id="form14" tabindex="0" >
                              <label class="onoffswitch-label" for="form14">
                                  <span class="onoffswitch-inner"></span>
                                  <span class="onoffswitch-switch"></span>
                              </label>
                        </div>
                        </td>
                      </tr>
                      <tr>
                         <td ><b>All Compliance Index Reports</b></td>
                          <td>
                          <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form5" value="form5" @if($subscription[0]->form5=='1') checked @endif class="onoffswitch-checkbox" id="form5" tabindex="0" >
                                <label class="onoffswitch-label" for="form5">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                          </div>
                          </td>
                          <td ><b>Add Returns</b></td>
                          <td>
                          <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form15" value="form15" @if($subscription[0]->form15=='1') checked @endif class="onoffswitch-checkbox" id="form15" tabindex="0" >
                                <label class="onoffswitch-label" for="form15">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                          </td>
                      </tr>
                      <tr>
                         <td ><b>Add Patients</b></td>
                          <td>
                          <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form6" value="form6" @if($subscription[0]->form6=='1') checked @endif class="onoffswitch-checkbox" id="form6" tabindex="0" >
                                <label class="onoffswitch-label" for="form6">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                          </div>
                          </td>
                          <td ><b>All Returns</b></td>
                          <td>
                          <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form16" value="form16" @if($subscription[0]->form16=='1') checked @endif class="onoffswitch-checkbox" id="form16" tabindex="0" >
                                <label class="onoffswitch-label" for="form16">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                          </td>
                      </tr>
                      <tr>
                         <td ><b>New Patients Reports</b></td>
                          <td>
                          <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form7" value="form7" @if($subscription[0]->form7=='1') checked @endif class="onoffswitch-checkbox" id="form7" tabindex="0" >
                                <label class="onoffswitch-label" for="form7">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                          </div>
                          </td>
                           <td ><b>Add Audit</b></td>
                            <td>
                            <div class="onoffswitch">
                                  <input type="checkbox" onchange="update_form(this)" name="form17" value="form17" @if($subscription[0]->form17=='1') checked @endif class="onoffswitch-checkbox" id="form17" tabindex="0" >
                                  <label class="onoffswitch-label" for="form17">
                                      <span class="onoffswitch-inner"></span>
                                      <span class="onoffswitch-switch"></span>
                                  </label>
                              </div>
                            </td>
                      </tr>
                      <tr>
                         <td ><b>Patients Picked Up Last Month</b></td>
                          <td>
                          <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form8" value="form8" @if($subscription[0]->form8=='1') checked @endif class="onoffswitch-checkbox" id="form8" tabindex="0" >
                                <label class="onoffswitch-label" for="form8">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                          </div>
                          </td>
                          <td ><b>All Audit</b></td>
                          <td>
                          <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form18" value="form18" @if($subscription[0]->form18=='1') checked @endif class="onoffswitch-checkbox" id="form18" tabindex="0" >
                                <label class="onoffswitch-label" for="form18">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                          </td>
                      </tr>
                      <tr>
                        <td ><b>Add Checking</b></td>
                          <td>
                          <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form9" value="form9" @if($subscription[0]->form9=='1') checked @endif class="onoffswitch-checkbox" id="form9" tabindex="0" >
                                <label class="onoffswitch-label" for="form9">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                          </div>
                          </td>
                          <td ><b>Add Notes For Patients</b></td>
                          <td>
                          
                            <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form19" value="form19" @if($subscription[0]->form19=='1') checked @endif class="onoffswitch-checkbox" id="form19" tabindex="0" >
                                <label class="onoffswitch-label" for="form19">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            
                            </div>
                          </td>
                      </tr>
                      <tr>
                        <td ><b>Checking Reports</b></td>
                          <td>
                          <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form10" value="form10" @if($subscription[0]->form10=='1') checked @endif class="onoffswitch-checkbox" id="form10" tabindex="0" >
                                <label class="onoffswitch-label" for="form10">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                          </div>
                          </td>
                          <td ><b>Note For Patients Reports</b></td>
                          <td>
                            <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form20" value="form20" @if($subscription[0]->form20=='1') checked @endif class="onoffswitch-checkbox" id="form20" tabindex="0" >
                                <label class="onoffswitch-label" for="form20">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            
                            </div>
                          </td>
                      </tr>
                      <!-- <tr>
                         <td ><b>Sms Tracking Reports</b></td>
                          <td>
                            <div class="onoffswitch">
                                <input type="checkbox" onchange="update_form(this)" name="form21" value="form21"  @if($subscription[0]->form21=='1') checked @endif class="onoffswitch-checkbox" id="form21" tabindex="0" >
                                <label class="onoffswitch-label" for="form21">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            
                            </div>
                          </td>
                          <td></td>
                          <td></td>
                      </tr> -->
                    </tbody>
                   
                  </table>
                  @endif


                 
                  

                 
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->
      
      <footer class="main-footer">
        <!-- <div class="pull-right hidden-xs">
          <b>Version</b> 2.0
        </div> -->
        <strong>Copyright &copy; {{date('Y')}}-{{date('Y')+1}} <a href="{{url('/')}}">PackPeak</a>.</strong> All rights reserved.
      </footer>
    </div><!-- ./wrapper -->
         <!-- jQuery 2.1.3 -->
    <!-- <script src="{{ URL::asset('admin/plugins/jQuery/jquery-2.1.3.min.js') }}"></script> -->
    <script src="{{ URL::asset('admin/plugins/jQueryUI/jquery-1.12.4.js') }}" type="text/javascript"></script>  
    <!-- jQuery UI 1.11.2 -->
    <script src="{{ URL::asset('admin/plugins/jQueryUI/jquery-ui.js') }}" type="text/javascript"></script>  
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
   
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ URL::asset('admin/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>  
    
    <!-- DATA TABES SCRIPT -->
    <script src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.js')}}" type="text/javascript"></script>
    <!--  This Use  For Dashboard Graph Only -->

    <!-- Morris.js charts -->
    <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script> -->
    <script src="{{ URL::asset('admin/plugins/ajax/libs/raphael/raphael-min.js') }}"></script>
    <script src="{{ URL::asset('admin/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="{{ URL::asset('admin/plugins/sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="{{ URL::asset('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ URL::asset('admin/plugins/knob/jquery.knob.js') }}" type="text/javascript"></script>

    <!--  This Use  For Dashboard Graph Only -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuCIAfY1ODCoVTvJyBtkZe-irKy0ljPXY&libraries=places"></script>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
<!--AIzaSyBuCIAfY1ODCoVTvJyBtkZe-irKy0ljPXY    AIzaSyD7OIFvK1-udIFDgZwvY7FVTFHMHipNy6Y -->
    <!--   Dropzone Js -->
    <script type="text/javascript" src="{{ URL::asset('admin/plugins/dropzone/js/dropzone.js')}}"></script>

   <!-- InputMask -->
   <script src="{{ URL::asset('admin/plugins/input-mask/jquery.inputmask.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('admin/plugins/input-mask/jquery.inputmask.date.extensions.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('admin/plugins/input-mask/jquery.inputmask.extensions.js')}}" type="text/javascript"></script>


    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ URL::asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>
    <!-- iCheck -->
    <!-- <script src="{{ URL::asset('admin/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script> -->
    <!-- Slimscroll -->
    <script src="{{ URL::asset('admin/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="{{ URL::asset('admin/plugins/fastclick/fastclick.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('admin/dist/js/app.min.js') }}" type="text/javascript"></script>
    <!-- <script src="{{ URL::asset('admin/dist/js/pages/dashboard.js') }}" type="text/javascript"></script> -->
     <script src="{{ URL::asset('admin/plugins/ajax/libs/moment/moment.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ URL::asset('admin/dist/js/demo.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('admin/plugins/daterangepicker/jquery.comiseo.daterangepicker.js') }}" type="text/javascript"></script>
    
   
    <script src="{{ URL::asset('admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>

    <script src="{{ URL::asset('admin/dist/js/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>
    

   
    <!-- daterangepicker -->
    <script src="{{ URL::asset('admin/plugins/timepicker/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>

      <script type="text/javascript">
      //  For   Bootstrap  datatable 
      var subcri_id={{$form['id']?$form['id']:'0'}}

      
      $(function () {

        $('#example1').dataTable({
          "ordering": false,
          "bPaginate": true,
          "bLengthChange": true,
          "pageLength": 2,
          "bFilter": true,
          "bSort": false,
          "bInfo": true,
          "bAutoWidth": false
        });

      //  $('.onoffswitch input.onoffswitch-checkbox').change(function(){
        
      });

       //   restrict Alphabets  
       function restrictAlphabets(e){
          var x=e.which||e.keycode; 
          if((x>=48 && x<=57) || x==8 || x==46)
            return true;
          else
            return false;
      }
     
      function  update_user(event,form)
      {
        var status=$(event).val();
        
        if(subcri_id && status && form)
        {
          $.ajax({
                  type: "POST",
                  url: "{{url('admin/update_form')}}",
                  data: {'row_id':subcri_id,status:status,form:form,"_token":"{{ csrf_token() }}"},
                  success: function(result){
                      console.log(result.success);
                      if(result.success){
                        
                        $('.alertmessage').html('<span class="alert alert-success text-success"> data Updated.</span>');
                        setInterval( function(){$('.alertmessage').html("");},5000);
                      }
                      else
                      { 
                        $('.alertmessage').html('<span class="alert alert-danger text-danger">Somthing event wrong!...</span>');
                        setInterval( function(){$('.alertmessage').html("");},5000); 
                      }
                  }
              });
        }
        else
        { 
          $('.alertmessage').html('<span class="alert alert-danger text-danger">Somthing event wrong!...</span>');
          setInterval( function(){$('.alertmessage').html("");},4000); 
        }
      }
      function update_form(event){
        //  alert("hi"); 
        var status='on';
        if (!$(event).is(':checked')) { status='0'; } 
        else{ status='1'; }
        // alert($(this).val());
        console.log(status,$(event).val());

        var form=$(event).val(); 
        // alert(subcri_id); 
        if(subcri_id && status && form)
        {
          $.ajax({
                  type: "POST",
                  url: "{{url('admin/update_form')}}",
                  data: {'row_id':subcri_id,status:status,form:form,"_token":"{{ csrf_token() }}"},
                  success: function(result){
                      console.log(result.success);
                      if(result.success){
                        var sta=(status=="1")?"on":"off"; 
                        $('.alertmessage').html('<span class="alert alert-success text-success">Now this form  is '+sta+'.</span>');
                        setInterval( function(){$('.alertmessage').html("");},4000); 
                      }
                      else
                      { 
                        $('.alertmessage').html('<span class="alert alert-danger text-danger">Somthing event wrong!...</span>');
                        setInterval( function(){$('.alertmessage').html("");},4000); 
                      }
                  }
              });
        }
        else
        { 
          $('.alertmessage').html('<span class="alert alert-danger text-danger">Somthing event wrong!...</span>');
          setInterval( function(){$('.alertmessage').html("");},4000); 
        }
      }

     

     
    </script>

  </body>
</html>
