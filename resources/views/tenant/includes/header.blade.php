<div class="wrapper">
 <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo"><b>
         @if(!empty(session('phrmacy')['roll_type']) && session('phrmacy')['roll_type']=='admin')
               {{'Pharmacy '.ucfirst(session('phrmacy')['roll_type'])}}
         @else
          {{ucfirst(session('phrmacy')['roll_type'])}}

         @endif
        </b></a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
        
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
            
              <!-- Messages: style can be found in dropdown.less-->
              <!--<li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success">4</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 4 messages</li>
                  <li>
                 
                  
                   
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="{{ URL::asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image"/>
                          </div>
                          <h4>
                            Support Team 
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="{{ URL::asset('admin/dist/img/user3-128x128.jpg') }}" class="img-circle" alt="user image"/>
                          </div>
                          <h4>
                            AdminLTE Design Team
                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="{{ URL::asset('admin/dist/img/user4-128x128.jpg') }}" class="img-circle" alt="user image"/>
                          </div>
                          <h4>
                            Developers
                            <small><i class="fa fa-clock-o"></i> Today</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="{{ URL::asset('admin/dist/img/user3-128x128.jpg') }}" class="img-circle" alt="user image"/>
                          </div>
                          <h4>
                            Sales Department
                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="{{ URL::asset('admin/dist/img/user4-128x128.jpg') }}" class="img-circle" alt="user image"/>
                          </div>
                          <h4>
                            Reviewers
                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li>-->
              
              @php
              $allNotification=App\Models\Tenant\Notification::all();
              @endphp

              <li class="dropdown notifications-menu">
                @if($allNotification->count())
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning notification_counting">
                    {{$allNotification->count()}}
                  </span>
                </a>
                @endif
                @if($allNotification->count() )
                <ul class="dropdown-menu">
                  <li class="header">You have <strong class="notification_counting">{{$allNotification->count()}} new </strong> notifications</li>
                  <li>
                  
                    <ul class="menu">
                      @foreach(App\Models\Tenant\Notification::all()  as $value)
                        <li id="delete_notification_id_{{$value->id}}">
                          <a href="{{url('notification_details/'.$value->id)}}">
                           <!-- {{ucfirst($value->booking_type)}} :  -->
                            <i class="fa fa-envelope-o text-aqua" title="{{$value->id}}"></i>{{ucfirst($value->id)}} 
                            <span class=""> :{{ucfirst($value->type)}} </span>
                          </a>
                        </li>
                      @endforeach   
                    </ul>
                  </li>
                
                </ul>
               @endif

              </li>
             
              <!--<li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger">9</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 9 tasks</li>
                  <li>
                  
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <h3>
                            Design some buttons
                            <small class="pull-right">20%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">20% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <h3>
                            Create a nice theme
                            <small class="pull-right">40%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">40% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <h3>
                            Some task I need to do
                            <small class="pull-right">60%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">60% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <h3>
                            Make beautiful transitions
                            <small class="pull-right">80%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">80% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="#">View all tasks</a>
                  </li>
                </ul>
              </li>-->
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ URL::asset('media/logos/logo2.png') }}" style="width:90px;" alt="User Image"/>
                  <!-- <img src="{{ URL::asset('images/users') }}/{{session()->get('image')?session()->get('image'):''}}" class="user-image" alt="User Image"/> -->
                  <span class="hidden-xs">@if(!empty(session('phrmacy')['roll_type'])) {{ ucfirst(session('phrmacy')['name'])}}  @endif</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                  <img src="{{ URL::asset('media/logos/logo2.png') }}" alt="User Image" />
                    <!-- <img src="{{ URL::asset('images/users') }}/{{session()->get('image')?session()->get('image'):''}}" class="user-image" alt="User Image"/> -->
                    <p>
                    @if(!empty(session('phrmacy')['roll_type']) && session('phrmacy')['roll_type']=='admin')
                           {{'Pharmacy '.ucfirst(session('phrmacy')['roll_type'])}}
                      
                     @endif
                      <small>Member since {{date("F, Y",strtotime(session()->get('join_date')))}}</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <!-- <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li> -->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{url('profile')}}"  class="btn btn-default btn-flat">Profile</a>
                    </div>
                    
                    <div class="pull-right">
                      <a href="{{url('logout')}}" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>