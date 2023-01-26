@extends('admin.layouts.mainlayout')
@section('title') <title>Edit Audits</title>

@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           Update Audits
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
                <form role="form" action="{{url('admin/update_audit/'.$audit[0]->website_id.'/'.$audit[0]->id)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <div class="box-body">
                  <div class="col-md-offset-5 col-md-7">
                            <div class="form-group">
                              <label for="company_name">Company Name <span class="text-danger"> *</span></label> <span class="loader_company"></span>
                                 @if(count($all_pharmacies)  && isset($all_pharmacies))
                                    @foreach($all_pharmacies as $row)
                                      @if($row->website_id==$audit[0]->website_id)
                                      <input type="text" readonly value="{{$row->company_name}} - {{$row->name}}" class="form-control">
                                      @endif
                                    @endforeach
                                  @endif
                              <span class="alert_company"></span>
                            </div>
                    </div>
                    
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="patient_name">Patient Name <span class="text-danger"> *</span></label>
                              <select name="patient_name" id="patient_name" class="form-control">
                                 <option value="">-- Select Patient--</option>
                                 @foreach($all_patients as $row)
                                   <option value="{{$row->id}}" @if($row->id==$audit[0]->patient_id) selected @endif 
                                    data-dob="{{$row->dob}}" data-lastPickupDate="{{isset($row->latestPickups->created_at)?$row->latestPickups->created_at:''}}"  data-lastPickupWeek="{{isset($row->latestPickups->created_at)?$row->latestPickups->no_of_weeks:''}}"
                                     data-lastNoteForPatient="{{isset($row->latestPickups->notes_from_patient)?$row->latestPickups->notes_from_patient:''}}"
                                     data-lastLocation="{{isset($row->latestPickups->location)?$row->latestPickups->location:''}}"
                                     >{{$row->first_name.' '.$row->last_name}} ( {{$row->dob?date("j/n",strtotime($row->dob)):""}} ) </option>
                                 @endforeach
                              </select>
                            </div>
                            <div class="form-group">
                                <label for="store">Store </label>
                                <select name="store" id="store" class="form-control">
                                @if(isset($all_facilities))
                                @foreach($all_facilities as $row)
                                <option value="{{$row->id}}" @if($audit[0]->store==$row->id) selected @endif >{{strtoupper($row->name)}}</option>
                                @endforeach @endif
                                </select>
                            </div>
                            <div class="form-group otherinput">
                              @if($audit[0]->store=='5')
                              <input type="text" name="other_store" value="{{$audit[0]->store_others_desc}}" id="other_store" class="form-control"  placeholder="other store">
                              @endif
                            </div>
                           
                            

                        </div>

                        <div class="col-md-6">
                              <div class="form-group">
                                <label for="no_of_weeks">Number of weeks <span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" value="{{$audit[0]->no_of_weeks}}" maxlength="10" onkeypress="return restrictAlphabets(event);" id="no_of_weeks"   name="no_of_weeks" placeholder="no of weeks">
                              </div>
                              
                               
                             
                              <div class="form-group">
                                <label for="staff_initials">Staff initials </label>
                                <input type="text" name="staff_initials" value="{{$audit[0]->staff_initials}}" id="staff_initials" class="form-control"  placeholder="Staff initials">
                             </div>
                             
                              
                              <div class="row">
                                <div class="col-md-2">
                                  <div class="form-group">
                                      <button type="submit" class="btn btn-primary">Update</button>
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

        $('#patient_name').select2();

       
         


      });
     
    $(document).ready(function(){});

    $('#patient_name').click(function(){
           if($('#company_name').val()==false){
                $('.alert_company').html('<span class="text-danger">Please select a valid company . </span>'); 
                $('select[id="company_name"]').css('border','1px solid red');
           } 
      });
      
        /* get All Patient  List  By  Website id */
       $('#company_name').click(function(){
           if($(this).val()){
              
              $.ajax({
                  type: "POST",
                  url: "{{url('admin/get_patients_by_website_id')}}",
                  data: {'website_id':$(this).val(),"_token":"{{ csrf_token() }}"},
                  beforeSend: function() {
                    $('.loader_company').html('<i class="fa fa-spinner fa-spin"></i>');
                  },
                  success: function(result){
                    // console.log(result);
                    $('.loader_company').html('');
                    $('.alert_company').html(''); 
                    $('select[id="company_name"]').css('border','none');
                    $('#patient_name').html(result);
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

</script>
@endsection
