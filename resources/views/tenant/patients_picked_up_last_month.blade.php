@extends('tenant.layouts.mainlayout')
@section('title') <title>Pickups Reports</title>
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
           {{__('Last Month Pickup Reports')}} 
            <small>{{__('Preview')}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
            <li><a href="dashboard">{{__('Picksup')}}</a></li>
            <li class="active">{{__('Patient pickups last month')}}</li>
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
                  <h3 class="box-title">{{__('All PickUps List</h3> <div class="pull-right alertmessage"></div>
                </div><!-- /.box-header -->
                <div class="box-body pre-wrp-in table-responsive">
                
                  <table id="{{ request()->get('role_type')=='admin'?'multidelete':'tbDatatable' }}"  data-model='Pickups'   class="table table-bordered table-striped">
                    <thead>

                      <tr>
                        <th style="width: 150px;" >{{__('Name')}}</th>
                        <th>{{__('DOB')}}</th>
                        <th>{{__('No Of Weeks')}}</th>
                        <th style="width: 350px;" >{{__('Date-Time')}}</th>
                       
                        <th{{__('>Who is picking up ?')}}</th>
                        <th>{{__('Patient Signature')}}</th>
                        <th>{{__('Carer\'s Name')}}</th>
                        <th>{{__('Notes From Patient')}}</th>
                        <th>{{__('Location')}}</th>
                        @if(request()->get('role_type')=='admin')
                        <th > {{__('Action')}}</th>
                        @endif
                      </tr>

                    </thead>
                    <tbody>

                    @foreach($patients as $patient)
                      <tr style="background-color: #b6d8ec;"><td colspan="10"><center><b>{{ strToUpper($patient->first_name)}}</b></center></td></tr>
                      @foreach($patient->pickups as $pickup)
                      <tr >
                      @if(request()->get('role_type')=='admin')
                        <td>{{ $pickup->id}}</td>
                      @endif

                        <td>{{ $patient->first_name.' '.$patient->last_name }}</td>
                        <td>{{ date("j/n/Y",strtotime($patient->dob)) }}</td>
                        <td>{{ $pickup->no_of_weeks}}</td>

                        <td>{{ $pickup->created_at }}</td>
                        <td>{{ $pickup->pick_up_by }}</td>
                        <td><img style="height:50px" src="{{ $pickup->patient_sign }}" alt="Patient sign" /></td>
                        <td>{{ $pickup->carer_name }}</td>
                        <td>{{ $pickup->notes_from_patient }}</td>
                        <td>{{ $pickup->location }}</td>

                        @if(request()->get('role_type')=='admin')
                        <td>
                        <a href="javascript:void(0);" title="delete" onclick="delete_driver(1);" ><i class="fa fa-trash text-danger"></i>&nbsp;&nbsp;
                        <a href="{{url('edit_driver/1')}}" title="edit"><i class="fa fa-edit text-success"></i></a>
                        </td>
                        @endif

                      </tr>
                      @endforeach
                    @endforeach

                    </tbody>
                   
                  </table>


                 
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

        
      });

    </script>
   
@endsection
