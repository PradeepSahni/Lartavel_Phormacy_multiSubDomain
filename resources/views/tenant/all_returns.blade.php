@extends('tenant.layouts.mainlayout')

@section('title') <title>All Returns</title>

<style>

  .dt-button-collection
{
  margin-top: 5px  !important;
}

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
           {{__('All Returns')}}
            <small>{{__('Preview')}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
            <li><a href="dashboard">{{__('Forms')}}</a></li>
            <li class="active">{{__('General Elements')}}</li>
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
                  <h3 class="box-title">{{__('All Returns List')}}</h3> <div class="pull-right alertmessage"></div>
                </div><!-- /.box-header -->
                <div class="box-body pre-wrp-in table-responsive">
                
                  <table id="{{ request()->get('role_type')=='admin'?'multidelete':'tbDatatable' }}" data-model='PatientReturn' class="table table-bordered table-striped">
                    <thead>
                      <th>{{__('Patient Name')}}</th>
                      <th>{{__('Patient DOB')}}</th>
                      <th>{{__('Return date-time')}}</th>
                      <th>{{__('Store')}}</th>
                      <th>{{__('Other store')}}</th>
                      <th>{{__('Select days/weeks')}}</th>
                      <th>{{__('Number of days/weeks return')}}</th>
                      <th>{{__('Staff Initial')}}</th>
                      @if(request()->get('role_type')=='admin')
                        <th > {{__('Action')}}</th>
                      @endif
                    </thead>
                    <tbody>
                      @foreach($returns as $return)
                      <tr>
                      @if(request()->get('role_type')=='admin')
                        <td>{{ $return->id}}</td>
                      @endif
                        <td>{{ucfirst($return->patients->first_name).' '.ucfirst($return->patients->last_name)}}</a></td>
                        <td>{{date("j/n/Y",strtotime($return->dob))}}</td>
                        <td>{{date("j/n/Y, h:i A",strtotime($return->created_at))}}</td>
                        <td>{{$return->stores->name}}</td>
                        <td>{{$return->other_store}}</td>
                        <td>{{$return->day_weeks}}</td>
                        <td>{{$return->returned_in_days_weeks}}</td>
                        <td>{{$return->staff_initials}}</td>
                        
                        @if(request()->get('role_type')=='admin')
                        <td>
                        <a href="{{__('return/delete/'.$return->id)}}" title="{{__('Delete')}}" ><i class="fa fa-trash text-danger"></i>&nbsp;&nbsp;
                        <a href="{{__('return/edit/'.$return->id)}}" title="{{__('Edit')}}"><i class="fa fa-edit text-success"></i></a>
                        </td>
                        @endif
                        
                      </tr>
                     
                      @endforeach

                    </tbody>
                   
                  </table>

                </div>
                <!-- /.box-body -->
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
