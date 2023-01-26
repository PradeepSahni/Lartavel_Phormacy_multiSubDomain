@extends('tenant.layouts.mainlayout')
@section('title') <title>Audits</title>

@endsection

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           {{__('Add Audits')}}
            <small>{{__('Preview')}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
            <li><a href="dashboard">{{__('Audits')}}</a></li>
            <li class="active">{{__('Add Audits')}}</li>
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
                <form role="form" action="{{url('save_audits')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="name">{{__('Patient Name')}}<span style="color:red">*</span></label>
                              <select  name="patient_id" id="patient" class="form-control @error('patient_id') is-invalid @enderror" >
                                <option value="">{{__('Select Patient')}}</option>
                                @foreach($patients as $patient)
                                  <option {{old('patient_id')==$patient->id?'selected':''}} data-dob="{{$patient->dob}}" data-lastPickupDate="{{$patient->latestPickups?$patient->latestPickups->created_at:''}}"  data-lastPickupWeek="{{$patient->latestPickups?$patient->latestPickups->no_of_weeks:''}}" value="{{$patient->id}}" >{{$patient->first_name.' '.$patient->last_name}} ( {{$patient->dob?date("j/n",strtotime($patient->dob)):""}} ) </option>
                                @endforeach
                              </select>
                              @error('patient_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="form-group">
                                <label for="store"> {{__('Store')}}</label>
                                <select name="store" id="store" class="form-control @error('store') is-invalid @enderror">
                                   
                                    @forelse($facilities as $facility)
                                      <option   {{old('store')==$facility->id?'selected':''}} value="{{$facility->id}}">{{$facility->name}}</option>
                                      @empty
                                      <option value="">{{__('No Records')}}</option>
                                    @endforelse
                                </select>
                                @error('store')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror

                            </div>
                           
                             <div class="form-group otherinput"></div>

                        </div>

                        <div class="col-md-6">
                              <div class="form-group">
                                <label for="number_of_weeks"> {{__('Number of weeks')}}<span style="color:red">*</span></label>
                                <input type="text"  value="{{old('no_of_weeks')}}" class="form-control @error('no_of_weeks') is-invalid @enderror" maxlength="2" onkeypress="return restrictAlphabets(event);" id="number_of_weeks" name="no_of_weeks" placeholder="no of weeks">
                                @error('no_of_weeks')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>

                              <div class="form-group">
                                <label for="staff_initials"> {{__('Staff initials')}}</label>
                                <input type="text"  value="{{old('staff_initials')}}" name="staff_initials" id="staff_initials" class="form-control @error('staff_initials') is-invalid @enderror" placeholder="staff_initials">
                                @error('staff_initials')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>

                              <div class="row">
                                <div class="col-md-2">
                                  <div class="form-group">
                                      <button type="submit" class="btn btn-primary"> {{__('Submit')}}</button>
                                  </div>
                                </div>
                                <div class="col-md-offset-1 col-md-2">
                                   <div class="form-group">
                                      <!-- <button type="reset" class="btn btn-default"> {{__('Reset')}}</button> -->
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
        $("#dob").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
        var pickerOptsGeneral = { format: "yyyy-mm-dd", autoclose: true, minView: 2, maxView: 2, todayHighlight: true }; //  ,startDate:  new Date()
        $('#dob').datetimepicker(pickerOptsGeneral).on('changeDate',function(ev){}); 


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

        $("input[type=radio][name='who_pickup']").on('ifToggled', function(event){
            var checked = $(this).closest('div.iradio_flat-green').hasClass("checked");
            if($(this).val()=='carer')
            $('.div_carer_name').css('display','block');
            else
            $('.div_carer_name').css('display','none');
        });  

        $('#patient').select2();
         


      });
     

   
    //  for chnage the Driver Type  And Set  Automaticaly  Rate of the Driver
    $(document).ready(function(){
       
        
    });

    $('#store').change(function(){
        if($(this).find('option:selected').text()=='other'){
          $('.otherinput').html('<input type="text" name="store_others_desc" id="store_others_desc" class="form-control"  placeholder="other store">'); 
        } 
        else
        {
          $('.otherinput').html('');
        }
    });
    if($('#store').find('option:selected').text()=='other'){
        $('.otherinput').html('<input type="text" name="store_others_desc" id="store_others_desc" class="form-control"  placeholder="other store">'); 
    } 
       /* End   -- Automatically  set  Driver  And rate */


      //     restrict Alphabets  
      function restrictAlphabets(e){
          var x=e.which||e.keycode; 
          if((x>=48 && x<=57) || x==8 ||
            (x>=35 && x<=40)|| x==46)
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
      });

    </script>
@endsection
