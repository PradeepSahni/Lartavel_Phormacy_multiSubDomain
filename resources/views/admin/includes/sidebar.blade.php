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
              <p>@if(!empty(Session::has('name'))) Pack Peak @else Pack Peak  @endif </p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form> -->
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <!-- <li class="header">MAIN NAVIGATION</li> -->
            <li >
              <a href="{{url('admin/dashboard')}}">
                <i class="fa fa-dashboard"></i><span>Dashboard</span> <i class="fa pull-right"></i>
              </a>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-hospital-o"></i><span>Stores/Pharmacy</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('admin/add_pharmacy')}}"><i class="fa fa-hospital-o"></i>Add Pharmacy</a></li>
                <li><a href="{{url('admin/all_pharmacies')}}" ><i class="fa fa-circle-o"></i>All Pharmacy</a></li>
              </ul>
            </li>
             <li class="treeview">
              <a href="#">
                <i class="fa fa-hospital-o"></i><span>Technician</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('admin/technician')}}"><i class="fa fa-hospital-o"></i>Add Technician</a></li>
                <li><a href="{{url('admin/all_technician')}}" ><i class="fa fa-circle-o"></i>All Technician</a></li>
              </ul>
            </li>
            <li><a href="{{url('admin/subscriptions')}}"><i class="fa fa-book"></i>Subscription Settings</a></li>
            
            <li class="treeview">
              <a href="#">
                <i class="fa fa-wheelchair"></i><span>Patients</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('admin/patients')}}" ><i class="fa fa-key"></i>Add  New Patient</a></li>
                <li><a href="{{url('admin/new_patients_report')}}" ><i class="fa fa-circle-o"></i>New Patient  Report</a></li>
              </ul>
            </li>

            

            <!-- <li>
              <a href="{{url('patients')}}">
                <i class="fa fa-key"></i> <span>Patients</span>
                <i class="fa  pull-right"></i>
              </a>
            </li> -->

             <li class="treeview">
              <a href="#">
                <i class="fa fa-ambulance"></i><span>Pick Ups</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('admin/pickups')}}"><i class="fa fa-circle-o"></i>Add Pick Ups</a></li>
                <li><a href="{{url('admin/pickups_calender')}}" ><i class="fa fa-circle-o"></i>Pick Ups Calender</a></li>
               
                
              </ul>
            </li>

            <li class="treeview" >
              <a href="#">
                <i class="fa fa-magic"></i> <span>Checking</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('admin/checkings')}}"><i class="fa fa-key"></i>Add Checking</a></li>
              </ul>
            </li>

            <li class="treeview" >
              <a href="#">
                <i class="fa fa-tag"></i> <span>Near Misses</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('admin/near_miss')}}"><i class="fa fa-key"></i>Add Near Miss</a></li>
              </ul>
            </li>
            <li class="treeview" >
              <a href="{{url('admin/returns')}}">
                <i class="fa fa-reply"></i> <span>Returns</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              	<li><a href="{{url('admin/returns')}}"><i class="fa fa-key"></i>Add Return</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-edit"></i> <span>Audits</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('admin/audits')}}"><i class="fa fa-key"></i>Add Audit</a></li>
              </ul>
            </li>
            <li class="treeview" >
              <a href="#">
                <i class="fa fa-tag"></i> <span>Notes For Patient</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('admin/notes_for_patients')}}" ><i class="fa fa-circle-o"></i> Add Notes For Patients</a></li>
                <!-- <li><a href="{{url('admin/notes_for_patients_report')}}" ><i class="fa fa-circle-o"></i> Notes For Patients Report</a></li> -->
                <!-- <li><a href="{{url('admin/sms_tracking_report')}}" ><i class="fa fa-circle-o"></i> Sms Tracking Report</a></li> -->
              </ul>
            </li>

            

            <li class="treeview">
              <a href="#">
                <i class="fa fa-file-o"></i> <span>Reports</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" >
                <li class="treeview">
              <a href="#">
                <i class="fa fa-ambulance"></i><span>Pick Ups</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('admin/pickups_reports')}}" ><i class="fa fa-circle-o"></i>Pick Ups Report</a></li>
                <!-- <li><a href="{{url('admin/pickups_calender')}}" ><i class="fa fa-circle-o"></i>Pick Ups Calender</a></li> -->
                <!-- <li><a href="{{url('admin/six_month_compliance')}}" ><i class="fa fa-circle-o"></i>6 Monthly Compliance Report</a></li> -->
                <!-- <li><a href="{{url('admin/all_compliance')}}" ><i class="fa fa-circle-o"></i>Compliance Index Reports</a></li> -->
                
                <!-- <li><a href="{{url('admin/patients_picked_up_last_month')}}" ><i class="fa fa-circle-o"></i>Patient Picked Up Last Month</a></li> -->
              </ul>
            </li>

            <li class="treeview" >
              <a href="#">
                <i class="fa fa-magic"></i> <span>Checking</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('admin/checkings_report')}}"><i class="fa fa-circle-o"></i>Checking Report</a></li>
              </ul>
            </li>

            <li class="treeview" >
              <a href="#">
                <i class="fa fa-tag"></i> <span>Near Misses</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('admin/all_near_miss')}}"><i class="fa fa-circle-o"></i>All  Near Misses</a></li>
              </ul>
            </li>
            <li class="treeview" >
              <a href="{{url('admin/returns')}}">
                <i class="fa fa-reply"></i> <span>Returns</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('admin/all_returns')}}"><i class="fa fa-circle-o"></i>Returns Reports</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-edit"></i> <span>Audits</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('admin/all_audits')}}"><i class="fa fa-circle-o"></i>Audit Reports</a></li>
              </ul>
            </li>

            <li class="treeview" >
              <a href="#">
                <i class="fa fa-tag"></i> <span>Notes For Patient</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('admin/notes_for_patients_report')}}" ><i class="fa fa-circle-o"></i> Notes For Patients Report</a></li>
              </ul>
            </li>


            




              </ul>
            </li>

            
            

            <li><a href="{{url('admin/search')}}"><i class="fa fa-search"></i> Search</a></li>
            <li><a href="{{url('admin/logs')}}"><i class="fa fa-file"></i> logs</a></li>
            

            



            

            
            
            

            
           
            
            
            
            


           
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>