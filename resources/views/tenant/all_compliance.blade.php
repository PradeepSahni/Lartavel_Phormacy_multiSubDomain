@extends('tenant.layouts.mainlayout')
@section('title') <title>All Compliance Reports</title>
@endsection

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          {{__('All Compliance Reports')}}
            <small>{{__('Preview')}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
            <li><a href="#">{{__('All Compliance')}}</a></li>
            <li class="active">{{__('All Compliance')}}</li>
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
                  <h3 class="box-title">{{__('All Compliance Reports')}}</h3> <div class="pull-right alertmessage"></div>
                </div><!-- /.box-header -->
                <div class="box-body pre-wrp-in table-responsive">
                
                  <table id="{{ request()->get('role_type')=='admin'?'multidelete':'tbDatatable' }}"  data-model='Pickups'   class="table table-bordered table-striped">
                    <thead>

                      <tr>
                        <th style="width: 150px;" >{{__('Patients Name')}}</th>
                        <th>{{__('DOB')}}</th>
                        <th>{{__('Location')}}</th>
                       
                        <th>{{__('MI%')}}</th>
                        @if(request()->get('role_type')=='admin')
                        <th > {{__('Action')}}</th>
                        @endif

                      </tr>

                    </thead>
                    <tbody>
                    @foreach($patients as $patient)
                    
                      @foreach($patient->pickups as $pickup)
                      @php 
                        $m=explode(',',$pickup->location);
                        $locations=App\Models\Admin\Location::select('name')->whereIn('id', $m)->get();
                        @endphp
                      <tr>
                      @if(request()->get('role_type')=='admin')
                        <td>{{ $pickup->id}}</td>
                      @endif
                        <td>{{ $patient->first_name.' '.$patient->last_name }}</td>
                        <td>{{ date("j/n/Y, h:i A",strtotime($patient->dob)) }}</td>
                        <td>
                          @if(isset($locations) && count($locations))
                            @php $locationarray=array(); @endphp
                             @foreach($locations as $row)
                               @php array_push($locationarray,$row->name); @endphp 
                             @endforeach
                            {{implode(',',$locationarray)}}
                          @endif 
                        </td>
                        <td>100</td>
                        @if(request()->get('role_type')=='admin')
                        <td>
                        <a href="{{url('pickups/delete/'.$pickup->id)}}" title="delete" ><i class="fa fa-trash text-danger"></i>&nbsp;&nbsp;
                        <a href="{{url('pickups/edit/'.$pickup->id)}}" title="edit"><i class="fa fa-edit text-success"></i></a>
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
