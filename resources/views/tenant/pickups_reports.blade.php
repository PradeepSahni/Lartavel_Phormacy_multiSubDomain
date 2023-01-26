@extends('tenant.layouts.mainlayout')
@section('title') <title>Pickups Reports</title>

@endsection

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          {{__('All Pickups Reports')}}
            <small>{{__('Preview')}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
            <li><a href="#">{{__('Pickups')}}</a></li>
            <li class="active">{{__('Pickups Report')}}</li>
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
                  <h3 class="box-title">{{__('All PickUps List')}}</h3> <div class="pull-right alertmessage"></div>
                </div><!-- /.box-header -->
                <div class="box-body pre-wrp-in table-responsive">
                
                  <table id="{{ request()->get('role_type')=='admin'?'multidelete':'tbDatatable' }}"  data-model='Pickups'   class="table table-bordered table-striped">
                    <thead>

                      <tr>
                         
                        <th>{{__('Name')}}</th>
                        <!-- <th>{{__('DOB')}}</th> -->
                        <th>{{__('No Of Weeks')}}</th>
                        <th >{{__('Date')}}</th>
                        <th >{{__('Time')}}</th>
                       
                        <th>{{__('Who is picking up ?')}}</th>
                        <th>{{__('Patient Signature')}}</th>
                        <th>{{__('Pharmacy Signature')}}</th>
                        <th>{{__('Carer`s Name')}}</th>
                        <th>{{__('Notes From Patient')}}</th>
                        <th>{{__('Location')}}</th>
                        <th>{{__('Facility')}}</th>
                        @if(request()->get('role_type')=='admin')
                        <th > {{__('Action')}}</th>
                        @endif
                      </tr>

                    </thead>
                    <tbody>

                   
                      @foreach($pickups as $pickup)
                        @php 
                        $m=explode(',',$pickup->location);
                        $locations=App\Models\Admin\Location::select('name')->whereIn('id', $m)->get();
                        @endphp
                      <tr >
                      @if(request()->get('role_type')=='admin')
                        <td>{{ $pickup->id}}</td>
                      @endif
                        <td>{{ $pickup->patients->first_name.' '.$pickup->patients->last_name }}</td>
                        <!-- <td>{{ $pickup->dob }}</td> -->
                        <td>{{ $pickup->no_of_weeks}}</td>

                        <td>{{ date("j/n/Y",strtotime($pickup->created_at)) }}</td>
                        <td>{{ date("h:i A",strtotime($pickup->created_at)) }}</td>
                        <td>{{ $pickup->pick_up_by }}</td>
                        <td><img style="height:50px" src="{{ $pickup->patient_sign }}" alt="Patient sign" /></td>
                        

                        
                        <td><img style="height:50px" src="{{ $pickup->pharmacist_sign }}" alt="Pharmacist sign" /></td>
                        <td>{{ $pickup->carer_name }}</td>
                        <td>{{ $pickup->notes_from_patient }}</td>
                        <td>
                          @if(isset($locations) && count($locations))
                            @php $locationarray=array(); @endphp
                             @foreach($locations as $row)
                               @php array_push($locationarray,$row->name); @endphp 
                             @endforeach
                            {{implode(',',$locationarray)}}
                          @endif 
                        </td>
                        <td></td>

                        @if(request()->get('role_type')=='admin')
                        <td>
                        <a href="{{url('pickups/delete/'.$pickup->id)}}" title="delete" ><i class="fa fa-trash text-danger"></i>&nbsp;&nbsp;
                        <a href="{{url('pickups/edit/'.$pickup->id)}}" title="edit"><i class="fa fa-edit text-success"></i></a>
                        </td>
                        @endif

                      </tr>
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
      //  For   Bootstrap  datatable 

      $(document).ready(function(){
        
       
      });

    </script>
@endsection
