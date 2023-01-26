@extends('tenant.layouts.mainlayout')
@section('title') <title>Near Miss</title>
 <style>
  .dropzone {
    min-height: 150px;
    border: 2px dotted rgba(0, 0, 0, 0.3);
    background: white;
    padding: 20px 59px;
}


 .btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

</style>
@endsection

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{__('Edit Near Miss')}}
        <small>{{__('Preview')}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
        <li><a href="dashboard">{{__('Near Miss')}}</a></li>
        <li class="active">{{__('Edit Near Miss')}}</li>
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
          <form role="form" id="add_nearMiss" action="{{url('near_miss/edit/'.$missedPatients->id)}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
            <div class="box-body">
                  <div class="col-md-8">
                      <label> </label>
                      <div class="form-group checkbox-wrp">
                          <label><input type="checkbox" {{$missedPatients->missed_tablet==1?'checked=checked':''}} name="missed_tablet" class="minimal" value="missed_tablet"  />&nbsp;{{__('Missed tablet')}}</label>&nbsp;
                          <label><input type="checkbox" {{$missedPatients->extra_tablet==1?'checked=checked':''}} name="extra_tablet" class="minimal" value="extra_tablet"  />&nbsp;{{__('Extra tablet')}}</label>&nbsp;
                          <label><input type="checkbox" {{$missedPatients->wrong_tablet==1?'checked=checked':''}} name="wrong_tablet" class="minimal" value="wrong_tablet"  />&nbsp;{{__('Wrong tablet')}}</label>&nbsp;
                          <label><input type="checkbox" {{$missedPatients->wrong_day==1?'checked=checked':''}} name="wrong_day" class="minimal" value="wrong_day"  />&nbsp;{{__('Wrong day')}}</label>&nbsp;

                          <label>
                              <input type="checkbox" id="other_checkbox" @if($missedPatients->other!="") checked @endif name="other_checkbox" class="minimal"   />&nbsp;other
                          </label>

                      </div>
                       <div class="form-group other_field">
                            @if($missedPatients->other!="")
                                <label for="other">Other? <span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" minlength="3" value="{{$missedPatients->other}}" required name="other" id="other" placeholder="other" >
                              @endif
                      </div>

                      <div class="form-group">
                        <label for="person_involved">{{__('Person involved')}} <span class="text-danger"> *</span> </label>
                        <input type="text"  value="{{$missedPatients->person_involved}}" class="form-control" maxlength="20"  required id="person_involved" required name="person_involved" placeholder="Person  Involved..">
                      </div>
                     

                          <!-- textarea -->
                        <div class="form-group">
                          <label for="initials">{{__('Initials')}} <span class="text-danger"> *</span> </label>
                           <input type="txet" value="{{$missedPatients->initials}}" class="form-control @error('initials') is-invalid @enderror" name="initials" id="initials"   placeholder="Initials." />
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{__('Update Near Miss')}}</button>
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
      $('#other_checkbox').on('ifChanged', function(event){
        //alert($(this).val()); 
        $(this).on('ifChecked', function(event){
            // alert("checked"); 
            $('.other_field').html('<label for="other">Other? <span class="text-danger"> *</span></label>\
                                <input type="text" class="form-control"  minlength="3" required name="other" id="other"\ placeholder="other" >'); 
        });
        $(this).on('ifUnchecked', function(event){
          // alert("Unchecked"); 
          $('.other_field').html(''); 
        });

      });


    });
      
    $(document).ready(function(){
      // $('#add_nearMiss').submit(function(){
      //   var err=0;
      //   let missed_tablet=$('input[type=checkbox][name="missed_tablet"]');
      //   let extra_tablet=$('input[type=checkbox][name="extra_tablet"]');
      //   let wrong_tablet=$('input[type=checkbox][name="wrong_tablet"]');
      //   let wrong_day=$('input[type=checkbox][name="wrong_day"]');

      //   if(missed_tablet.is(':checked')){
      //     missed_tablet.parent('div').removeClass('icheckbox_minimal-red hover');
      //     missed_tablet.parent('div').addClass('icheckbox_minimal-blue');
         
      //   }else{
      //     ++err;
      //     missed_tablet.parent('div').removeClass('icheckbox_minimal-blue');
      //     missed_tablet.parent('div').addClass('icheckbox_minimal-red hover');
      //   }

      //   if(extra_tablet.is(':checked')>0){
      //     extra_tablet.parent('div').removeClass('icheckbox_minimal-red hover');
      //     extra_tablet.parent('div').addClass('icheckbox_minimal-blue');
          
      //   }else{
      //     ++err;
      //     extra_tablet.parent('div').removeClass('icheckbox_minimal-blue');
      //     extra_tablet.parent('div').addClass('icheckbox_minimal-red hover');
      //   }

      //   if(wrong_tablet.is(':checked')>0){
      //     wrong_tablet.parent('div').removeClass('icheckbox_minimal-red hover');
      //     wrong_tablet.parent('div').addClass('icheckbox_minimal-blue');
          
      //   }else{
      //     ++err;
      //     wrong_tablet.parent('div').removeClass('icheckbox_minimal-blue');
      //     wrong_tablet.parent('div').addClass('icheckbox_minimal-red hover');
      //   }

      //   if(wrong_day.is(':checked')>0){
      //     wrong_day.parent('div').removeClass('icheckbox_minimal-red hover');
      //     wrong_day.parent('div').addClass('icheckbox_minimal-blue');
          
      //   }else{
      //     ++err;
      //     wrong_day.parent('div').removeClass('icheckbox_minimal-blue');
      //     wrong_day.parent('div').addClass('icheckbox_minimal-red hover');
      //   }

      //   if(err>0){
      //     alert(err);
      //     return false;
      //   }else{
      //     return true;
      //   }

      // });

    });
      
    //restrict Alphabets  

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
