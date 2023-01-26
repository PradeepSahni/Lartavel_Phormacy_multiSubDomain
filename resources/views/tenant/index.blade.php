    @extends('tenant.layouts.mainlayout')
    @section('title') <title>dashboard </title> 
 
    <style type="text/css">
  
    [class^="icon-"], [class*=" icon-"] {
        background-image: url("public/admin/bootstrap/glyphicons/glyphicons-halflings.png");
    }
    .fc-basic-view td.fc-day-number, .fc-basic-view td.fc-week-number span {
          padding-top: 2px;
          padding-bottom: 2px;
          font-size: 12px;
          cursor:pointer;
      }
      div.fc.fc-unthemed  {
          font-size: 60%;
          border: 1px solid #eee;
      }
      div.fc.fc-unthemed h2{
          font-size: 18px
      }
      div.fc.fc-unthemed  th {
        font-size: 12px !important;
    }  
    .nav-tabs-custom>.nav-tabs>li.active>a{
      background-color: #3c8dbc !important;
      color:#fff !important;
      font-weight: 800 !important;
    }

    .warning-box{
      -webkit-animation: warns 0.6s linear 0s infinite alternate;
      animation: warns 0.6s linear 0s infinite alternate;
    }
    

    </style>
    @endsection
    @section('content')
    <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
              <h1>
                Dashboard
                <small>Control panel</small>
              </h1>
              <ol class="breadcrumb">
                <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
              </ol>
            </section>
            @php 
              $Subscription=App\Models\tenant\AccessLevel::find(1);
            @endphp
            <!-- Main content -->
            <section class="content" style="min-height: 0px; ">
              <!-- Small boxes (Stat box) -->
              <div class="row">
                <div class="col-lg-1"></div>
               @if(!empty(session('phrmacy')['roll_type']) && session('phrmacy')['roll_type']=='admin')
                <div class="col-lg-2 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-green">
                    <div class="inner">
                      <h3>{{$allPharmacists}}</h3>
                      <p>All Pharmacists</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{url('all_admin')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div><!-- ./col -->
               @else
                <div class="col-lg-2 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-aqua">
                    <div class="inner">
                      <h3>{{$allReturns}}</h3>
                      <p>Patients Return</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{url('all_returns')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div><!-- ./col -->
               @endif
               @if($Subscription->form7)
                <div class="col-lg-2 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-yellow">
                    <div class="inner">
                      <h3>{{$allPatients}}</h3>
                      <p>Patients </p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{url('new_patients_report')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div><!-- ./col -->
                @endif
                <div class="col-lg-2 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-aqua">
                    <div class="inner">
                      <h3>{{$allTechnicians}}</h3>
                      <p>Technician</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{url('all_technician')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div><!-- ./col -->
                @if($Subscription->form3)
                <div class="col-lg-2 col-xs-6">
                   <!-- small box -->
                   <div class="small-box bg-red warning-box">
                    <div class="inner">
                      <h3>{{$allPickups}} </h3>
                      <p class="text">PickUp Calendar</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-car"></i>
                    </div>
                   
                    <a href="{{url('pickups_calender')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div><!-- ./col -->
                @endif
                <div class="col-lg-2 col-xs-6">
                   <!-- small box -->
                   <div class="small-box bg-primary warning-box" >
                    <div class="inner">
                      <h3>&nbsp;</h3>
                      <p class="text">Notification</p>
                    </div>
                    <div class="icon">
                      <i class="fa  fa-cogs"></i>
                    </div>
                   
                    <a href="{{url('patients_notification')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div><!-- ./col -->

              </div><!-- /.row -->


            </section><!-- /.content -->


            <!-- Main content -->
            <section class="content">
            <div class="row">
              <div class="col-md-12 alert_message">
             
             
                
                  
                  
                </div>
              </div>
              <div class="row">
            
              </div><!-- /.row -->
            </section><!-- /.content -->


          </div><!-- /.content-wrapper -->


   
     



     


      @endsection

    @section('customjs')

   
    <script src="{{ URL::asset('admin/plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>    

    <script type="text/javascript">

       
        
    $(document).ready(function(){
      
      }); 

</script>

@endsection

