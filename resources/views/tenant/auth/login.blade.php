
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>PeakPack || Parmacy || Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Favicon  -->
    <link rel="icon" href="{{ URL::asset('media/logos/favicon.ico') }}" type="image/x-icon"/>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ URL::asset('admin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <!-- <link href="{{ URL::asset('admin/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
 -->   
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ URL::asset('admin/dist/css/AdminLTE.min.css') }} " rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="{{ URL::asset('admin/plugins/iCheck/square/blue.css') }} " rel="stylesheet" type="text/css" />
    <style>
     body {
        /* background-image: url("{{ URL::asset('admin/tourpdf/images/backbeauty.jpg') }}"); */
        background:lightgray;
        background-repeat: no-repeat, repeat;
        background-position: center; 
        background-size: cover;  
      }
      .padding-left-10{
        padding-left:70px; 
      }
    </style>
 
  </head>
  <body >
    <div class="login-box">

   
    @if(Session::has('msg'))
      {!!  Session::get("msg") !!}
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
      <div class="login-logo">
        <a href="{{url('admin-login')}}"><img src="{{ $company_logo }}" style="height:130px;  width:100%; "></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">{{__('Log in to')}} {{ $company_name }}</p>
        <p>{{ $account }}.{{env('PROJECT_HOST', 'packnpeaks.tk') }}</p>
        <form  action="{{ url('pharmacylogin') }}"  method="post">  <!--dashboard-->
        	{{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="text"  name="email" class="form-control" placeholder="Email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <!-- <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>-->
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

      <!--  <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div>-->
        <!-- /.social-auth-links -->

        <!-- <a href="#">I forgot my password</a><br> -->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- <div class="row">
      <div class="col-sm-4"></div>
      <div class="col-sm-4 padding-left-10" >
        <a href="{{url('pharmacist_login')}}" class="text-center btn btn-xs btn-primary">Pharmacy login</a> &nbsp; &nbsp;
        <a href="{{url('pharmacist_signup')}}" class="text-center btn btn-xs btn-primary">Add New Pharmacy </a>&nbsp; &nbsp;
        <a href="{{url('/')}}" class="text-center btn btn-xs btn-primary">Supper Admin </a>&nbsp; &nbsp;
      </div>
    </div> -->
    <!-- jQuery 2.1.3 -->
    <script src="{{ URL::asset('admin/plugins/jQuery/jQuery-2.1.3.min.js') }}"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ URL::asset('admin/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="{{ URL::asset('admin/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>