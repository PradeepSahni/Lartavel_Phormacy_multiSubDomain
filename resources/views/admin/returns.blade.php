@extends('admin.layouts.mainlayout')
@section('title') <title>Returns</title>

@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           Add Returns
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
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header pre-wrp">
                <form role="form" action="{{url('admin/save_return')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <div class="box-body">
                  <div class="col-md-offset-5 col-md-7">
                            <div class="form-group">
                              <label for="company_name">Company Name <span class="text-danger"> *</span></label> <span class="loader_company"></span>
                              @if(count($all_pharmacies)  && isset($all_pharmacies))
                              <select class="form-control" name="company_name"  id="company_name">
                                <option value="">--Select Company --</option>
                                @foreach($all_pharmacies as $row)
                                <option value="{{$row->website_id}}">{{$row->company_name}} - {{$row->name}}</option>
                                @endforeach
                              </select>
                              @endif
                              <span class="alert_company"></span>
                            </div>
                    </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="patient_name">Patient Name <span class="text-danger"> *</span></label> <span class="loader_patient"></span>
                              <select name="patient_name" id="patient_name" class="form-control">
                                 <option value="">-- Select Patient--</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="select_days_weeks">Select Days/Weeks <span class="text-danger"> *</span></label>
                              <select name="select_days_weeks" id="select_days_weeks"  class="form-control">
                                 <option  @if(old('select_days_weeks')=='days') selected @endif  value="days">Days</option>
                                 <option @if(old('select_days_weeks')=='weeks') selected @endif  value="weeks">Weeks</option>
                              </select>
                            </div>
                           
                            <div class="form-group">
                              <label for="no_of_returned_day_weeks">Number of days/weeks returned </label>
                              <input type="text" class="form-control" maxlength="10" onkeypress="return restrictAlphabets(event);" id="no_of_returned_day_weeks" value="{{old('no_of_returned_day_weeks')}}"   name="no_of_returned_day_weeks" placeholder="no of returned day weeks">
                            </div>
                            

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="dob">Date Of Birth </label>
                              <input type="date" readonly class="form-control" max="{{Carbon\Carbon::now()->format('Y-m-d')}}"   name="dob" id="dob" value="{{old('dob')}}" placeholder="Date Of Birth" >
                            </div>
                            <div class="form-group">
                            <label for="store">Store </label>
                            <select name="store" id="store" class="form-control">
                            @if(isset($all_facilities))
                            @foreach($all_facilities as $row)
                            <option @if(old('store')==$row->id) selected @endif  value="{{$row->id}}">{{strtoupper($row->name)}}</option>
                            @endforeach @endif
                            </select>
                            </div>
                            <div class="form-group otherinput">
                              @if(old('other_store'))
                                <input type="text" name="other_store" id="other_store" class="form-control" ="" placeholder="other store" value="{{old('other_store')}}">
                              @endif 

                            </div>
                            <div class="form-group">
                               <label for="initials">Staff initials </label>
                               <input type="text" name="initials" value="{{old('initials')}}" id="initials" class="form-control"  placeholder="initials">
                            </div>
                              
                            <div class="row">
                                <div class="col-md-2">
                                  <div class="form-group">
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                  </div>
                                </div>
                                <div class="col-md-offset-1 col-md-2">
                                   <div class="form-group">
                                      <!-- <button type="reset" class="btn btn-default">Reset</button> -->
                                   </div>
                                </div>
                            </div>

                              

                        </div>
                        
                 </div>

                </form>
                </div><!-- /.box-header -->
              </div><!-- /.box -->


          </div>   <!-- /.row -->
        </section><!-- /.content -->



         

      </div><!-- /.content-wrapper -->



 
    

@endsection


@section('customjs')


    <script type="text/javascript">



     

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

        /* $("input[type=radio][name='who_pickup']").on('ifToggled', function(event){
            var checked = $(this).closest('div.iradio_flat-green').hasClass("checked");
            if($(this).val()=='carer')
            $('.div_carer_name').css('display','block');
            else
            $('.div_carer_name').css('display','none');
        }); */  
         


      });
     

   
   
    $(document).ready(function(){
        /* var gettype=$("input[type=radio][name='type']:checked").val();
        $("input[type=radio][name='type']").change(function(){  }); */
        
      });

      $('#patient_name').click(function(){
           if($('#company_name').val()==false){
                $('.alert_company').html('<span class="text-danger">Please select a valid company . </span>'); 
                $('select[id="company_name"]').css('border','1px solid red');
           } 
      });
      $('#dob').click(function(){
           if($('#company_name').val()==false){
                $('.alert_company').html('<span class="text-danger">Please select a valid company . </span>'); 
                $('select[id="company_name"]').css('border','1px solid red');
           } 
        });
        /* get All Patient  List  By  Website id */
      //  $('#company_name').click(function(){
      //      if($(this).val()){
              
      //         $.ajax({
      //             type: "POST",
      //             url: "{{url('admin/get_patients_by_website_id')}}",
      //             data: {'website_id':$(this).val(),"_token":"{{ csrf_token() }}"},
      //             beforeSend: function() {
      //               $('.loader_company').html('<i class="fa fa-spinner fa-spin"></i>');
      //             },
      //             success: function(result){
      //               // console.log(result);
      //               $('.loader_company').html('');
      //               $('.alert_company').html(''); 
      //               $('select[id="company_name"]').css('border','none');
      //               $('#patient_name').html(result);
      //               $('#patient_name').select2(
      //                 ).on('change', function (e) {
      //                 if(this.value){
      //                       var ob=$(this).children('option:selected');
      //                       var dob=ob.attr('data-dob');
      //                       var lastLocation=ob.attr('data-lastLocation');
      //                       $('#dob').val(dob);
      //                    }
      //                 });
      //             }
      //         });
      //      } 
      //   });

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
                      $('.loader_company').html('');
                      $('.alert_company').html(''); 
                      $('select[id="company_name"]').css('border','none');
                      //  console.log(result.facility)
                       console.log(result.patient)
                       $('#patient_name').html(result.patient);
                       $('#store').html(result.store);
                        $('#patient_name').select2(
                          ).on('change', function (e) {
                          if(this.value){
                                var ob=$(this).children('option:selected');
                                var dob=ob.attr('data-dob');
                                var lastLocation=ob.attr('data-lastLocation');
                                $('#dob').val(dob);
                            }
                          });
                  }
             });
           }
      });

        /* get  Patienst  Dote of  birth by Patient  id and Website id  */
        $('#patient_name').click(function(){
           if($(this).val()){
              
              $.ajax({
                  type: "POST",
                  url: "{{url('admin/get_patient_dob')}}",
                  data: {website_id:$('#company_name').val(),patient_id:$('#patient_name').val(),"_token":"{{ csrf_token() }}"},
                  beforeSend: function() {
                    $('.loader_patient').html('<i class="fa fa-spinner fa-spin"></i>');
                  },
                  success: function(result){
                    $('.loader_patient').html('');
                    if(result.dob)
                    {
                         $('#dob').val(result.dob); 
                    }
                  }
              });
           } 
        });

        $('#store').change(function(){
           if($(this).val()=='5'){
              $('.otherinput').html('<input type="text" name="other_store" id="other_store" class="form-control"  placeholder="other store">'); 
            } 
           else
           {
            $('.otherinput').html('');
           }
        });
        

      


      //     restrict Alphabets  
      function restrictAlphabets(e){
        var x=e.which||e.keycode; 
        if((x>=48 && x<=57) )
        return true;
        else
        return false;
     }

      //  For   Bootstrap  datatable 
     


      

    </script>
@endsection
