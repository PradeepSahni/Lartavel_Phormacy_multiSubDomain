@extends('tenant.layouts.mainlayout')
@section('title') <title>All Technicians</title>
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
           {{__('All Technicians')}}
            <small>{{__('Preview')}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
            <li><a href="dashboard">{{__('Technician')}}</a></li>
            <li class="active">{{__('Add Technician')}}</li>
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
            <div class="col-xs-12">


              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"> {{__('All Technicians List')}} <i class="fa fa-hospital-o"></i> </h3> <div class="pull-right alertmessage"></div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  @if(isset($all_technicians) && count($all_technicians))
                  <table id="example1"   class="table table-bordered table-striped">
                    <thead>
                      <tr>
                       
                        <th style="width: 150px;">  {{__('Name')}}</th>
                        <th> {{__('Email')}}</th>
                        <th> {{__('Initials Name')}}</th>
                        <!-- <th>Pharmacy</th> -->
                        <th> {{__('Registration')}}</th>
                        <th> {{__('Phone')}}</th>
                        <!-- <th style="width: 350px;" >Address</th> -->
                        <!-- <th>Host Name</th> -->
                        <!-- <th>Website id</th> -->
                        <th>{{__('Status')}}</th>
                        <th>{{__('Action')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($all_technicians as $row)
                      <tr>
                        <td>{{ucfirst($row['first_name']).' '.ucfirst($row['last_name'])}}</td>
                        <td>{{$row['email']}}</td>
                        <td>{{$row['initials_name']}}</td>
                        <!-- <td><i class="fa fa-hospital-o"></i>&nbsp;{{$row['company_name']}}</td> -->
                        <td>{{$row['registration_no']}}</td>
                        <td>{{$row['phone']}}</td>
                        <!-- <td>{{$row['address']}}</td> -->
                        <!-- <td>{{$row['host_name']}}</td> -->
                        <!-- <td>{{$row['website_id']}}</td> -->
                        <td><a href="{{url('technician/status/'.$row['id'])}}" class="btn btn-xs btn-@if($row['status']=='1'){{'success'}}@else{{'danger'}}@endif">@if($row['status']=='1'){{'Active'}}@else{{'Inactive'}}@endif</a></td>
                        @if(request()->get('role_type')=='admin')
                        <td>
                        <a href="{{url('technician/delete/'.$row['id'])}}" title="{{__('delete')}}" ><i class="fa fa-trash text-danger"></i>&nbsp;&nbsp;
                        <a href="{{url('technician/edit/'.$row['id'])}}" title="{{__('edit')}}"><i class="fa fa-edit text-success"></i></a>
                        </td>
                        @endif

                      </tr>
                      @endforeach

                    </tbody>
                   
                  </table>
                  @else
                   <div class="text-center text-danger"><span> {{__('There are no data.')}}</span></div>
                  @endif
                  


                 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->


@endsection


@section('customjs')


    <script type="text/javascript">
      $(document).ready(function(){
        $('#example1').dataTable();
    
      });

    </script>
@endsection
