@extends('admin.layouts.mainlayout')
@section('title') <title>Near Miss</title>
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           Add Near Miss
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
                <form role="form" action="{{url('admin/save_near_miss')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <div class="box-body">
                      
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="company_name">Company Name <span class="text-danger"> *</span></label> <span class="loader_company"></span>
                            @if(count($all_pharmacies)  && isset($all_pharmacies))
                            <select class="form-control"  name="company_name" id="company_name">
                              <option value="">--Select Company --</option>
                              @foreach($all_pharmacies as $row)
                              <option @if(old('company_name')==$row->website_id) selected @endif value="{{$row->website_id}}">{{$row->company_name}} - {{$row->name}}</option>
                              @endforeach
                            </select>
                            @endif
                            <span class="alert_company"></span>
                          </div>
                            <label> Error Type </label>
                            <div class="form-group checkbox-wrp">
                                <label>
                                    <input type="checkbox" name="missed_tablet" class="minimal" value="missed_tablet"  />&nbsp;Missed tablet                                </label>
                                <label>
                                    <input type="checkbox" name="extra_tablet" class="minimal" value="extra_tablet"  />&nbsp;Extra tablet
                                </label>
                                <label>
                                    <input type="checkbox" name="wrong_tablet" class="minimal" value="wrong_tablet"  />&nbsp;Wrong tablet
                                </label>
                                <label>
                                    <input type="checkbox" name="wrong_day" class="minimal" value="wrong_day"  />&nbsp;Wrong day
                                </label>
                                <label>
                                    <input type="checkbox" id="other_checkbox" name="other_checkbox" class="minimal"   />&nbsp;other
                                </label>
                            </div>

                            <div class="form-group other_field">
                                
                              </div>
                            <div class="form-group">
                              <label for="person_involved">Person involved <span class="text-danger"> *</span></label><span class="loader_patient"></span>
                              <input type="text" value="{{old('person_involved')}}" name="person_involved"   id="person_involved" class="form-control" >
                            </div>
                           

                               <!-- textarea -->
                              <div class="form-group">
                                <label for="Initials">Initials <span class="text-danger"> *</span></label>
                                <textarea class="form-control"  style="resize: none;" rows="4" name="initials" id="initials"   placeholder="Initials.">{{old('initials')}}</textarea>
                              </div>

                              <div class="row">
                                <div class="col-md-2">
                                  <div class="form-group">
                                      <button type="submit" class="btn btn-primary">Add Near Miss</button>
                                  </div>
                                </div>
                                <div class="col-md-offset-1 col-md-2">
                                   <div class="form-group">
                                      <button type="reset" class="btn btn-default">Reset</button>
                                   </div>
                                </div>
                             </div>


                        </div>

                        <div class="col-md-6">
                              
                             
                             

                             

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
                                <input type="text" class="form-control" minlength="3"  name="other" id="other"\ placeholder="other" >'); 
        });
        $(this).on('ifUnchecked', function(event){
          // alert("Unchecked"); 
          $('.other_field').html(''); 
        });

      });



         
         


      });
      
    // $(document).ready(function(){});

    $('#person_involved').click(function(){
           if($('#company_name').val()==false){
                $('.alert_company').html('<span class="text-danger">Please select a valid company . </span>'); 
                $('select[id="company_name"]').css('border','1px solid red');
           } 
      });

      $('#company_name').click(function(){
           if($(this).val()){
              $('.alert_company').html(''); 
              $('select[id="company_name"]').css('border','none');
           } 
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


    </script>
@endsection
