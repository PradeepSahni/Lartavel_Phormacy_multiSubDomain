@extends('tenant.layouts.mainlayout')
@section('title') <title>Notes_For_Patient</title>


@endsection


@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           {{__('Edit Notes For Patient')}}
            <small>{{__('Preview')}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
            <li><a href="dashboard">{{__('Notes For Patient')}}</a></li>
            <li class="active">{{__('Edit Notes For Patient')}}</li>
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
                <form id="add_notes" role="form" action="{{url('notes_for_patients/edit/'.$notes_for_patients->id)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="patient_name">{{__('Patient Name')}} <span style="color:red">*</span></label>
                                <select name="patient_id" id="patient" class="form-control" >
                                  <option value="">{{__('Select Patient')}}</option>
                                  @foreach($patients as $patient)
                                    <option {{$patient->id==$notes_for_patients->patients->id?'selected=selected':''}}  data-dob="{{$patient->dob}}" data-lastPickupDate="{{$patient->latestPickups?$patient->latestPickups->created_at:''}}"  data-lastPickupWeek="{{$patient->latestPickups?$patient->latestPickups->no_of_weeks:''}}" value="{{$patient->id}}">{{$patient->first_name.' '.$patient->last_name}} ( {{$patient->dob?date("j/n",strtotime($patient->dob)):""}} ) </option>
                                  @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="col-md-6">
                              <div class="form-group">
                                <label for="dob">{{__('Date Of Birth')}}</label>
                                <input type="date" readonly value="{{$notes_for_patients->dob}}" class="form-control"   name="dob" id="dob" placeholder="Date Of Birth" max="{{Carbon\Carbon::now()->format('Y-m-d')}}" >
                              </div>

                        </div>
                     <!-- New  row col-12 for new section  -->
                     <div class="col-md-12">
                           <!-- textarea -->
                           <div class="form-group">
                                <label for="note_for_patient">{{__('Note For Patient')}} <span style="color:red">*</span></label>
                                <textarea class="form-control"  style="resize: none;" rows="4" name="notes_for_patients" id="notes_for_patients"   placeholder="note for patient.">{{$notes_for_patients->notes_for_patients}}</textarea>
                              </div>
                            <div class="form-group">
                                <label>
                                    <input {{$notes_for_patients->notes_as_text==1?'checked=checked':''}} type="checkbox" name="notes_as_text" class="minimal" value="1"  />&nbsp;{{__('Send the note as a text message')}} 
                                </label>
                            </div>
                            
                             <div class="row">
                                <div class="col-md-offset-4 col-md-2">
                                  <div class="form-group">
                                      <button type="submit" class="btn btn-primary btn-block">{{__('Submit')}}</button>
                                  </div>
                                </div>
                                <div class=" col-md-2">
                                   <div class="form-group">
                                      <button type="reset" class="btn btn-default">{{__('Reset')}}</button>
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
      
  });
  
  //  for chnage the Driver Type  And Set  Automaticaly  Rate of the Driver
  $(document).ready(function(){
    $('#patient').select2(
      ).on('change', function (e) {
      if(this.value){
            var ob=$(this).children('option:selected');
            var dob=ob.attr('data-dob');
            $('#dob').val(dob);
         }
      });

    $('#add_notes').submit(function(){

          

      });
  });

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
