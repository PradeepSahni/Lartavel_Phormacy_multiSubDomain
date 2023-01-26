@extends('admin.layouts.mainlayout')
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
    @-webkit-keyframes warns{
      to{
        background-color: #dd4b39;
      }
      from{
        background-color: #ffc0b8;
      }
    }
    @keyframes warns{
      to{
        background-color: #dd4b39;
      }
      from{
        background-color: #ffc0b8;
      }
    }

    </style>
    @endsection
    @section('content')
    <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
              <h1>
                Dashboard jhkhhjhk
                <small>Control panel</small>
              </h1>
              <ol class="breadcrumb">
                <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
              </ol>
            </section>

            <!-- Main content -->
            <section class="content" style="min-height: 0px; ">
              <!-- Small boxes (Stat box) -->
              <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-2 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-green pre-box-d">
                    <div class="inner">
                      <h3>{{$allPharmacy}}</h3>
                      <p>Pharmacy</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{url('admin/all_pharmacies')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div><!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-aqua pre-box-d">
                    <div class="inner">
                      <h3>{{$allTechnicians}}</h3>
                      <p>Technician </p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{url('admin/all_technician')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div><!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-yellow pre-box-d">
                    <div class="inner">
                      <h3>{{$allPatients}}</h3>
                      <p>Patients </p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{url('admin/new_patients_report')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div><!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                   <!-- small box -->
                   <div class="small-box bg-red  pre-box-d">
                    <div class="inner">
                      <h3>{{$allPickups}}</h3>
                      <p class="text">Pick Ups </p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-car"></i>
                    </div>
                   
                    <a href="{{url('admin/pickups_reports')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div><!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                   <!-- small box -->
                   <div class="small-box bg-primary  pre-box-d">
                    <div class="inner">
                      <i class="fa  fa-cog" style="color:white;font-size: 51px;"></i>
                      <p class="text">Settings </p>
                    </div>
                    <div class="icon">
                      <i class="fa  fa-cogs"></i>
                    </div>
                   
                    <a href="{{url('admin/subscriptions')}}" class="small-box-footer">Click here <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div><!-- ./col -->

              </div><!-- /.row -->

            </section><!-- /.content -->


           


          </div><!-- /.content-wrapper -->


   



     


      @endsection

    @section('customjs')

   

</script>

@endsection

