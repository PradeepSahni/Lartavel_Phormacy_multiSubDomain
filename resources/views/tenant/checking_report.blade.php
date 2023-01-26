@extends('tenant.layouts.mainlayout')
@section('title') <title>All Checking Report</title>
 <style>
  .dropzone {
    min-height: 150px;
    border: 2px dotted rgba(0, 0, 0, 0.3);
    background: white;
    padding: 20px 59px;
}
.dt-button-collection
{
  margin-top: 5px  !important;
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
           {{__('All Checking')}}
            <small>{{__('Preview')}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
            <li><a href="dashboard">{{__('Checkings')}}</a></li>
            <li class="active">{{__('All Checkings Reports')}}</li>
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
                  <h3 class="box-title">{{__('All Checking Report List')}}</h3> <div class="pull-right alertmessage"></div>
                </div><!-- /.box-header -->
                <div class="box-body pre-wrp-in table-responsive">
                
                  <table id="{{ request()->get('role_type')=='admin'?'multidelete':'tbDatatable' }}"  data-model='Checkings'   class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th  >	{{__('Patient Name')}}</th>
                        <th>{{__('Date-Time')}}</th>
                        <th>{{__('No Of Weeks')}}</th>
                        <th>{{__('Pharmacist Signature')}}</th>
                        <th>{{__('Location')}}</th>
                        <th>{{__('Note For Patient')}}</th>
                        <th>{{__('DD')}}</th>
                        @if(request()->get('role_type')=='admin')
                        <th > {{__('Action')}}</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($checkings as $checking)
                     
                        @php 
                        $m=explode(',',$checking->location);
                        $locations=App\Models\Admin\Location::select('name')->whereIn('id', $m)->get();
                        @endphp
                      <tr>
                      @if(request()->get('role_type')=='admin')
                        <td>{{ $checking->id}}</td>
                      @endif
                        <td>{{$checking->patients->first_name.' '.$checking->patients->last_name}}</td>
                        <td>{{date("j/n/Y, h:i A",strtotime($checking->created_at))}}</td>
                        <td>{{$checking->no_of_weeks}}</td>
                        <td><img src="{{$checking->pharmacist_signature}}" style="height:80px;"/></td>
                        <td>
                        @if(isset($locations) && count($locations))
                            @php $locationarray=array(); @endphp
                             @foreach($locations as $row)
                               @php array_push($locationarray,$row->name); @endphp 
                             @endforeach
                            {{implode(',',$locationarray)}}
                          @endif 
                        </td>
                        <td>{{$checking->note_from_patient}}</td>
                        
                        <td>{{$checking->dd==1?'true':'false'}}</td>
                        @if(request()->get('role_type')=='admin')
                        <td>
                          <a href="{{url('checkings/delete/'.$checking->id)}}" title="delete" ><i class="fa fa-trash text-danger"></i>&nbsp;&nbsp;
                          <a href="{{url('checkings/edit/'.$checking->id)}}" title="edit"><i class="fa fa-edit text-success"></i></a>
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
      $(document).ready(function(){
       
        
      });

    </script>
   
@endsection
