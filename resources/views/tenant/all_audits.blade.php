@extends('tenant.layouts.mainlayout')
@section('title') <title>All Audits</title>

@endsection

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           {{__('All Audits')}}
            <small>{{__('Preview')}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
            <li><a href="dashboard">{{__('Audits')}}</a></li>
            <li class="active">{{__('All Audits')}}</li>
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
                  <h3 class="box-title">{{__('All Audits List')}}</h3> <div class="pull-right alertmessage"></div>
                </div><!-- /.box-header -->
                <div class="box-body pre-wrp-in table-responsive">
                
                  <table id="{{ request()->get('role_type')=='admin'?'multidelete':'tbDatatable' }}" data-model='Audit' class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        
                        <th  >{{__('Patient Name')}}</th>
                        <th >{{__('Date-Time')}}</th>
                        <th >{{__('No Of Weeks')}}</th>
                        <th  >{{__('Store')}}</th>
                        <th> {{__('Store Other')}}</th>
                        @if(request()->get('role_type')=='admin')
                        <th > {{__('Action')}}</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                    @forelse($audits as $audit)
                      <tr>
                      @if(request()->get('role_type')=='admin')
                        <td>{{ $audit->id}}</td>
                      @endif
                        <td>{{$audit->patients->first_name.' '.$audit->patients->last_name}}</td>
                        <td>{{date("j/n/Y, h:i A",strtotime($audit->created_at))}}</td>
                        <td>{{$audit->no_of_weeks}}</td>
                        <td>{{$audit->stores->name}}</td>
                        <td>{{$audit->store_others_desc}}</td>
                        @if(request()->get('role_type')=='admin')
                        <td>
                        <a href="{{url('audits/delete/'.$audit->id)}}" title="{{__('Delete')}}" onclick="delete_driver(1);" ><i class="fa fa-trash text-danger"></i>&nbsp;&nbsp;
                        <a href="{{url('audits/edit/'.$audit->id)}}" title="{{__('Edit')}}"><i class="fa fa-edit text-success"></i></a>
                        </td>
                        @endif
                       
                      </tr>
                    @empty
                      <tr><td colspan="8">{{__('NO Records')}}</td></tr>
                    @endforelse
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
