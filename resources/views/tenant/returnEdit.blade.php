
@extends('tenant.layouts.mainlayout')
@section('title') <title>Returns</title>

@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           {{__('Update Returns')}}
            <small>{{__('Preview')}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
            <li><a href="dashboard">{{__('Returns')}}</a></li>
            <li class="active">{{__('Add Returns')}}</li>
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
                <form role="form" action="{{url('return/edit/'.$returns->id)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <div class="box-body">
                        <div class="col-md-6">
                           
                            <div class="form-group">
                              <label for="no_of_returned_day_weeks">{{__('Number of days/weeks returned')}} </label>
                              <input type="number" value="{{$returns->returned_in_days_weeks}}" class="form-control" maxlength="2" onkeypress="return restrictAlphabets(event);" id="no_of_returned_day_weeks"   name="no_of_returned_day_weeks" placeholder="no of returned day weeks">
                            </div>
                            <div class="form-group">
                              <label for="select_days_weeks">{{__('Select Days/Weeks')}} <span style="color:red">*</span></label>
                              <select name="select_days_weeks" id="select_days_weeks" class="form-control">
                                 <option value="days" {{$returns->day_weeks=='Days'?'selected=selected':''}} >{{__('Days')}}</option>
                                 <option value="weeks" {{$returns->day_weeks=='Weeks'?'selected=selected':''}} >{{__('Weeks')}}</option>
                              </select>
                            </div>
                           
                            
                            <div class="form-group">
                               <label for="initials">{{__('Staff initials')}} </label>
                               <input type="text" name="initials" id="initials" value="{{$returns->staff_initials}}" class="form-control"  placeholder="initials">
                            </div>

                            

                        </div>

                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="name">{{__('Patient Name')}}<span style="color:red">*</span></label>
                              <select name="patient_id" id="patient" class="form-control" >
                                <option value="">{{__('Select Patient')}}</option>
                                @foreach($patients as $patient)
                                  <option data-dob="{{$patient->dob}}" {{$patient->id==$returns->patients->id?'selected=selected':''}} data-lastPickupDate="{{$patient->latestreturns?$patient->latestreturns->created_at:''}}"  data-lastPickupWeek="{{$patient->latestreturns?$patient->latestreturns->no_of_weeks:''}}" value="{{$patient->id}}">{{$patient->first_name.' '.$patient->last_name}} ( {{$patient->dob?date("j/n",strtotime($patient->dob)):""}} ) </option>
                                @endforeach
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="dob">{{__('Date Of Birth')}} </label>
                              <input type="date" readonly class="form-control"   name="dob" value="{{$returns->dob}}" id="dob" placeholder="Date Of Birth" max="{{Carbon\Carbon::now()->format('Y-m-d')}}">
                            </div>
                            <div class="form-group">
                            <label for="store">{{__('Store')}} </label>
                            <select name="store" id="store" class="form-control">
                              <option value="">{{__('Select')}}</option>
                              @forelse($facilities as $facility)
                                <option value="{{$facility->id}}" {{$returns->store==$facility->id?'selected':''}}>{{$facility->name}}</option>
                                @empty
                                <option value="">{{__('No Records')}}</option>
                              @endforelse
                             
                            </select>
                            </div>
                            <div class="form-group otherinput"></div>
                            
                              
                            <div class="row">
                                <div class="col-md-2">
                                  <div class="form-group">
                                      <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                  </div>
                                </div>
                                <div class="col-md-offset-1 col-md-2">
                                   <div class="form-group">
                                      <!-- <button type="reset" class="btn btn-default">{{__('Reset')}}</button> -->
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
 
         
      });
     
   
   
    $(document).ready(function(){
        $('#patient').select2(
          ).on('change', function (e) {
          if(this.value){
                var ob=$(this).children('option:selected');
                var dob=ob.attr('data-dob');
                $('#dob').val(dob);
             }
          });
        
    });

    if($('#store').find('option:selected').text()=='other'){
        $('.otherinput').html('<input type="text" name="other_store" value="{{$returns->other_store}}" id="other_store" class="form-control"  placeholder="other store">'); 
    } 

    $('#store').change(function(){
        if($(this).find('option:selected').text()=='other'){
          $('.otherinput').html('<input type="text" name="other_store" id="other_store" value="{{$returns->other_store}}"  class="form-control"  placeholder="other store">'); 
        } 
        else
        {
        $('.otherinput').html('');
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
      //  For   Bootstrap  datatable 
     
      
  </script>
@endsection


