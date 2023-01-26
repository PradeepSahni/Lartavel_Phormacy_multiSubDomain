@extends('tenant.layouts.mainlayout')
@section('title') <title>{{__('All Notes For Patients  Report')}} </title>
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
           {{__('All Notes For Patients Report')}}
            <small>{{__('Preview')}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
            <li><a href="dashboard">{{__('Notes For Patients')}} </a></li>
            <li class="active">{{__('Add Notes For Patients')}}</li>
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
                  <h3 class="box-title">{{__('All Notes For Patients Report List')}}</h3> <div class="pull-right alertmessage"></div>
                </div><!-- /.box-header -->
                <div class="box-body pre-wrp-in table-responsive">
                
                  <table id="{{ request()->get('role_type')=='admin'?'multidelete':'tbDatatable' }}"  data-model='NotesForPatient'   class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th  >{{__('Patient Name')}}</th>
                        <th>{{__('Patient DOB')}}</th>
                        <th  >{{__('Notes For Patient')}}</th>
                        <th  >{{__('Note Date')}}</th>
                        <th>{{__('Send As Text')}}</th>
                        @if(request()->get('role_type')=='admin')
                        <th > {{__('Action')}}</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                    @forelse($notes_for_patients as $notes_for_patient)
                      <tr>
                      @if(request()->get('role_type')=='admin')
                        <td>{{$notes_for_patient->id}}</td>
                      @endif
                        <td>{{$notes_for_patient->patients->first_name.' '.$notes_for_patient->patients->last_name}}</td>
                        <td>{{date("j/n/Y",strtotime($notes_for_patient->dob))}}</td>
                        <td>{{$notes_for_patient->notes_for_patients}}</td>
                        <td>{{date("j/n/Y, h:i A",strtotime($notes_for_patient->created_at))}}</td>
                        <td>{{$notes_for_patient->notes_as_text==1?'Yes':'No'}}</td>

                        @if(request()->get('role_type')=='admin')
                        <td>
                        <a href="{{url('notes_for_patients/delete/'.$notes_for_patient->id)}}" title="{{__('delete')}}" ><i class="fa fa-trash text-danger"></i>&nbsp;&nbsp;
                        <a href="{{url('notes_for_patients/edit/'.$notes_for_patient->id)}}" title="{{__('edit')}}"><i class="fa fa-edit text-success"></i></a>
                        </td>
                        @endif
                        
                      </tr>
                    @empty
                      <tr><td colspan="5">{{__('No Records')</td></tr>
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
    
    </script>
@endsection
