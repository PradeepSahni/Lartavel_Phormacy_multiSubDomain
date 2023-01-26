@extends('tenant.layouts.mainlayout')
@section('title') <title>User  Details </title>
<style>
 
img.margin.borderclass {
    border: 2px solid #3c8dbc;
}
</style>

@endsection



@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
      <h1>
        @if(Session::get('phrmacy')->roll_type=='admin') Admin  @elseif(Session::get('phrmacy')->roll_type=='technician') Technician @endif Profile
      </h1>
      <!-- <ol class="breadcrumb">
            <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{url('technician')}}">Technician</a></li>
            <li class="active" ><a href="{{url('Profile/'.Session::get('phrmacy')->id)}}">Driver details</a></li>
      </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
        
        <!-- /.col -->
        <div class="col-md-6">
            @if(Session::has('msg'))
              {!!  Session::get("msg") !!}
           @endif
            <div class="box box-primary" style="min-height:445px;">
            <div class="box-header with-border">
              <!-- <h3 class="box-title">Basic Info</h3> -->
            </div>
            <div>
              <div class="timeline-body">
                <form class="form-group" action="{{url('update_profile')}}" method="post">
                  @csrf
                  <fieldset>
                    <legend>&nbsp;&nbsp;Update Information</legend>

                     <div class="col-md-6">
                        <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="first_name" onkeypress="return restrictNumerics(event);" value="{{$user_data->first_name}}" class="form-control" placeholder="First Name">
                        </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="last_name" onkeypress="return restrictNumerics(event);" value="{{$user_data->last_name}}" class="form-control" placeholder="Enter Last Name">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                          <label>Username</label>
                          <input type="text" name="username" value="{{$user_data->username}}" class="form-control" placeholder="Enter Username">
                        </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                          <label>Pin</label>
                          <input type="text" name="pin" onkeypress="return restrictAlphabets(event);" maxlength="4" minlength="4" value="{{$user_data->pin}}" class="form-control" placeholder="Enter Pin">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                          <label>Phone</label>
                          <input type="text" name="phone" onkeypress="return restrictAlphabets(event);" value="{{$user_data->phone?$user_data->phone:'04'}}" maxlength="10" class="form-control" placeholder="Enter Phone Number">
                        </div>
                     </div>
                     <div class="col-md-3">
                       <div class="form-group">
                          <label></label>
                          <button class="btn btn-primary btn-block">Update</button>
                        </div>
                     </div>
                   </fieldset>
                </form>
                @if(Session::get('phrmacy')->roll_type=='admin')
                <form class="form-group" id="update_access" action="javascript:void(0);">
                  <fieldset>
                    <legend>&nbsp;&nbsp;Update Information</legend>
                     
                     <div class="col-md-6">
                        <div class="form-group">
                          <label>App Session Time Out Time</label>
                          <input type="text" name="app_logout_time" id="app_logout_time" value="{{$accessLevel->app_logout_time}}" class="form-control" placeholder="Time (minut)">
                        </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                          <label>Cycle</label>
                          <input type="text" name="default_cycle" id="default_cycle" value="{{$accessLevel->default_cycle}}" class="form-control" placeholder="Enter cycle">
                        </div>
                     </div>
                     <div class="col-md-6">
                       <div class="text-center update_access_alert"></div>
                     </div>
                     <div class="col-md-3">
                       <div class="form-group">
                          <label></label>
                          <button class="btn btn-primary btn-block">Update</button>
                        </div>
                     </div>
                   </fieldset>
                </form>
                @endif
                
                     
                    
              </div>
             </div>
            </div>
        </div>

        <div class="col-md-6">
           @if(Session::has('msgp'))
              {!!  Session::get("msgp") !!}
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
          <div class="box box-primary" style="min-height:245px;">
            <div class="box-header with-border">
              <!-- <h3 class="box-title">About</h3> -->
            </div>
            <div>
              <div class="timeline-body">
                  <form class="form-group" action="{{url('update_password')}}" method="post">
                    @csrf
                    <fieldset>
                      <legend>&nbsp;&nbsp;Change Password</legend>
                       <div class="col-md-6">
                          <div class="form-group">
                            <label>old Password</label>
                            <input type="password" name="old_password" class="form-control" placeholder="Enter Old Password">
                          </div>
                       </div>
                       <div class="col-md-6">
                         <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="new_password" class="form-control" placeholder="Enter New Password">
                          </div>
                       </div>
                       <div class="col-md-offset-6 col-md-3">
                         <div class="form-group">
                            <label></label>
                            <button class="btn btn-primary btn-block">Update</button>
                          </div>
                       </div>
                     </fieldset>
                  </form>
              </div>
            </div>
          </div>
                
        
        </div>

        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


 
     

@endsection


@section('customjs')
<script>
  
    $(function () {

        $('#update_access').submit(function(e){
            
             if($('#app_logout_time').val() && $('#default_cycle').val()){
                   $.ajax({
                  type: "POST",
                  url: "{{url('update_access')}}",
                  data: {'app_logout_time':$('#app_logout_time').val(),'default_cycle':$('#default_cycle').val(),"_token":"{{ csrf_token() }}"},
                  beforeSend: function() {
                    $('.loader_company').html('<i class="fa fa-spinner fa-spin"></i>');
                  },
                  success: function(result){
                    console.log(result);
                    if(result=='200'){
                       $('.update_access_alert').html('<span class="text-success">Data Updated.</span>');
                    }
                    else if(result=='401'){
                      $('.update_access_alert').html('<span class="text-danger">somthing went wrong!</span>');
                    }
                    else{
                      $('.update_access_alert').html('<span class="text-danger">'+result+'</span>');
                    }
                    
                    
                  },
                  error:function(result){
                     console.log(result);
                  }
                  });
             }
             else{
               
               $('.update_access_alert').html('<span class="text-danger">fields are required</span>');
             }
        });
    });

    function restrictNumerics(e){
        var x=e.which||e.keycode; 
        if((x>=65 && x<=90) || x==8 ||
        (x>=97 && x<=122)|| x==95 || x==32)
        return true;
        else
        return false;
      }


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
