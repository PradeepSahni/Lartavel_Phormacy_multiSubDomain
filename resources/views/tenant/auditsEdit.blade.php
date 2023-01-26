@extends('tenant.layouts.mainlayout')
@section('title') <title>Audits</title>

@endsection

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           {{__('Edit Audits')}}
            <small>{{__('Preview')}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
            <li><a href="dashboard">{{__('Audits')}}</a></li>
            <li class="active">{{__('Edit Audits')}}</li>
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
                <form role="form" action="{{url('audits/edit/'.$audits->id)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="name">{{__('Patient Name')}}<span style="color:red">*</span></label>
                              <select name="patient_id" id="patient" class="form-control" >
                                <option value="">{{__('Select Patient')}}</option>
                                @foreach($patients as $patient)
                                  <option {{$patient->id==$audits->patients->id?'selected=selected':''}} data-dob="{{$patient->dob}}" data-lastPickupDate="{{$patient->latestPickups?$patient->latestPickups->created_at:''}}"  data-lastPickupWeek="{{$patient->latestPickups?$patient->latestPickups->no_of_weeks:''}}" value="{{$patient->id}}">{{$patient->first_name.' '.$patient->last_name}} ( {{$patient->dob?date("j/n",strtotime($patient->dob)):""}} ) </option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group">
                                <label for="store"> {{__('Store')}} </label>
                                <select name="store" id="store" class="form-control" >
                                    @forelse($facilities as $facility)
                                      <option value="{{$facility->id}}" {{$audits->store==$facility->id?'selected=selected':''}}>{{$facility->name}}</option>
                                      @empty
                                      <option value="">{{__('No Records')}}</option>
                                    @endforelse
                                </select>

                            </div>
                           
                             <div class="form-group otherinput">
                               @if(isset($audits->store_others_desc) && $audits->store_others_desc!="" )
                               <input type="text" value="{{$audits->store_others_desc}}" name="store_others_desc" id="store_others_desc" class="form-control"  placeholder="other store">
                               @endif
                             </div>

                        </div>

                        <div class="col-md-6">
                              <div class="form-group">
                                <label for="number_of_weeks"> {{__('Number of weeks')}} <span style="color:red">*</span> </label>
                                <input type="text" class="form-control" value="{{$audits->no_of_weeks}}" maxlength="2" onkeypress="return restrictAlphabets(event);" id="number_of_weeks"   name="no_of_weeks" placeholder="no of weeks">
                              </div>

                              <div class="form-group">
                                <label for="staff_initials"> {{__('Staff initials')}}  </label>
                                <input type="text" name="staff_initials" value="{{$audits->staff_initials}}" id="staff_initials" class="form-control"  placeholder="staff_initials">
                             </div>

                              <div class="row">
                                <div class="col-md-2">
                                  <div class="form-group">
                                      <button type="submit" class="btn btn-primary"> {{__('Submit')}}</button>
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
          $('.otherinput').html('<input type="text" value="{{$audits->store_others_desc}}" name="store_others_desc" id="store_others_desc" class="form-control"  placeholder="other store">'); 
        } 
        else
        {    
          $('.otherinput').html('');
        }
    });
    // if($('#store').find('option:selected').text()=='Others'){
    //     $('.otherinput').html('<input type="text" value="{{$audits->store_others_desc}}" name="store_others_desc" id="store_others_desc" class="form-control"  placeholder="other store">'); 
    // } 
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
