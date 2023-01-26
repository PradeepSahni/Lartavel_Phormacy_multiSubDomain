
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
 <!-- sidebar: style can be found in sidebar.less -->
 <section class="sidebar">
   <!-- Sidebar user panel -->
   <div class="user-panel">
     <div class="pull-left image">
     <img src="{{ URL::asset('media/logos/logo2.png') }}" alt="User Image" />
       <!-- <img src="{{ URL::asset('images/users') }}/{{session()->get('image')?session()->get('image'):''}}" class="img-circle" alt="User Image"/> -->
     </div>
     <div class="pull-left info">
       <p>@if(!empty(Session::has('name'))) PackPeak @else PackPeak  @endif </p>
       <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
     </div>
   </div>

         <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu ">
        <li class="treeview ">
          <a href="{{url('dashboard')}}">
            <i class="fa fa-dashboard"></i><span>Dashboard</span>
          </a>
        </li>
      
             
@php 
    $Subscription=App\Models\tenant\AccessLevel::find(1);
    $differ_day=3;
    $admin_parmacy=App\Models\Tenant\Company::where('id','1')->first();
    $current_date=\Carbon\Carbon::now()->format('Y-m-d');
    $start_date = \Carbon\Carbon::createFromFormat('Y-m-d',$current_date);
    
    $end_date=\Carbon\Carbon::createFromFormat('Y-m-d',$admin_parmacy->expired_date)->format('Y-m-d');
    $different_days = $start_date->diffInDays($end_date);
    
@endphp

          @if( $current_date <  $admin_parmacy->expired_date || 
           ( $admin_parmacy->expired_date < $start_date && $different_days <= ($differ_day-1) ) )
                  

          <li class="treeview ">
            <a href="#">
              <i class="fa fa-user-md"></i><span>Technician</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
              <ul class="treeview-menu">
                  <li class=""><a href="{{url('/')}}/technician"><i class="fa fa-user-md"></i>Add Technician</a></li>
                  <li class=""><a href="{{url('/')}}/all_technician"><i class="fa fa-circle-o"></i>All Technician</a></li>
              </ul>
          </li>
      
             
       
        @if($Subscription->form6 || $Subscription->form7 )
          <li class="treeview ">
            <a href="#">
              <i class="fa fa-wheelchair"></i><span>Patients</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @if($Subscription->form6)
                  <li class=""><a href="{{url('/')}}/patients"><i class="fa fa-key"></i>Add New Patient</a></li>
                @endif  @if($Subscription->form7)
                  <li class=""><a href="{{url('/')}}/new_patients_report"><i class="fa fa-circle-o"></i>New Patient Report</a></li>
                @endif 
                </ul>
          </li>
        @endif
      
             
       @if($Subscription->form1 || $Subscription->form2 || $Subscription->form3 ||  $Subscription->form5)
                  
          <li class="treeview ">
            <a href="#">
              <i class="fa fa-ambulance"></i><span>Pick Ups</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @if($Subscription->form1)
                  <li class=""><a href="{{url('/')}}/pickups"><i class="fa fa-circle-o"></i>Add Pick Ups</a></li>
                @endif  @if($Subscription->form2)
                  <li class=""><a href="{{url('/')}}/pickups_reports"><i class="fa fa-circle-o"></i>Pickups Report</a></li>
                @endif  @if($Subscription->form5)
                  <li class=""><a href="{{url('/')}}/all_compliance"><i class="fa fa-circle-o"></i>All Compliance Index Reports</a></li>
                @endif  @if($Subscription->form4)
                  <!-- <li class=""><a href="{{url('/')}}/six_month_compliance"><i class="fa fa-circle-o"></i>6 Monthly Index Reports</a></li>                -->
                @endif  @if($Subscription->form3)
                  <li class=""><a href="{{url('/')}}/pickups_calender"><i class="fa fa-circle-o"></i>Pick Ups Calender</a></li>
                @endif
                </ul>
          </li>
       @endif
      
             
       
      @if($Subscription->form9 || $Subscription->form10 )           
          <li class="treeview ">
            <a href="#">
              <i class="fa fa-magic"></i><span>Checking</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @if($Subscription->form9)
                  <li class=""><a href="{{url('/')}}/checkings"><i class="fa fa-key"></i>Add Checking</a></li>
                @endif  @if($Subscription->form10)
                  <li class=""><a href="{{url('/')}}/checkings_report"><i class="fa fa-circle-o"></i>Checking Report</a></li>
                @endif 
                </ul>
          </li>
      @endif
      
             
       
        @if($Subscription->form15 || $Subscription->form16 )        
          <li class="treeview ">
            <a href="#">
              <i class="fa fa-reply"></i><span>Returns</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
            <ul class="treeview-menu">
              @if($Subscription->form15)
                <li class=""><a href="{{url('/')}}/returns"><i class="fa fa-key"></i>Add Return</a></li>
              @endif  @if($Subscription->form16)
                <li class=""><a href="{{url('/')}}/all_returns"><i class="fa fa-circle-o"></i>All Returns</a></li>
              @endif  
            </ul>
          </li>
        @endif
      
             
       
      @if($Subscription->form17 || $Subscription->form18 )       
          <li class="treeview ">
            <a href="#">
              <i class="fa fa-edit"></i><span>Audits</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @if($Subscription->form17)
                  <li class=""><a href="{{url('/')}}/audits"><i class="fa fa-key"></i>Add Audit</a></li>
                @endif  @if($Subscription->form18)
                  <li class=""><a href="{{url('/')}}/all_audits"><i class="fa fa-circle-o"></i>All Audit</a></li>
                @endif  
                </ul>
          </li>
      @endif
      
             
       
      @if($Subscription->form19 || $Subscription->form20 || $Subscription->form21 )       
          <li class="treeview ">
            <a href="#">
              <i class="fa fa-tag"></i><span>Notes For Patient</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @if($Subscription->form19)
                  <li class=""><a href="{{url('/')}}/notes_for_patients"><i class="fa fa-circle-o"></i>Add Notes For Patients</a></li>
                @endif  @if($Subscription->form20)
                  <li class=""><a href="{{url('/')}}/notes_for_patients_report"><i class="fa fa-circle-o"></i>Notes For Patients Report</a></li>
                @endif  @if($Subscription->form21)
                  <!-- <li class=""><a href="{{url('/')}}/sms_tracking_report"><i class="fa fa-circle-o"></i>Sms Tracking Report</a></li> -->
                @endif  
                </ul>
          </li>
        @endif
      
             
       
        @if($Subscription->form11 || $Subscription->form12 || $Subscription->form13  || $Subscription->form14)            
          <li class="treeview ">
            <a href="#">
              <i class="fa fa-tag"></i><span>Near Misses</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              @if($Subscription->form11)
                <li class=""><a href="{{url('/')}}/near_miss"><i class="fa fa-key"></i>Near Miss</a></li>
              @endif  @if($Subscription->form12)
                <li class=""><a href="{{url('/')}}/all_near_miss"><i class="fa fa-circle-o"></i>All Near Misses</a></li>
              @endif  @if($Subscription->form13)
                <li class=""><a href="{{url('/')}}/nm_last_month"><i class="fa fa-circle-o"></i>Last Month Report</a></li>
              @endif  @if($Subscription->form14)
                <li class=""><a href="{{url('/')}}/nm_monthly"><i class="fa fa-circle-o"></i>NM Montholy Report V2</a></li>
              @endif  
              </ul>
          </li>
        @endif

      @endif
      
                   

        </ul>
 </section>
 <!-- /.sidebar -->
</aside>


