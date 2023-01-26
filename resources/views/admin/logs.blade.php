@extends('admin.layouts.mainlayout')
@section('title') <title>All Logs</title>
<style>
div#example1_paginate {
    margin-top: -30px;
}
</style>
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          All Logs
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="dashboard">Forms</a></li>
            <li class="active">General Elements</li>
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
                  <!-- <h3 class="box-title">All Logs</h3> --> <div class="pull-right alertmessage"></div>
                </div><!-- /.box-header -->
                <div class="box-body pre-wrp-in">
                
                  @if(isset($allLogs))
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Pharmacy</th>
                          <th>User</th>
                          <th>Action</th>
                          <th>Date Time</th>
                          <th>IP Address</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($allLogs as $value)
                      
                        <tr id="row_{{$value['id']}}" >
                           <td></td>
                           <td>{{isset($value->pharmacy_name) ?ucfirst($value->pharmacy_name):''}}</td>
                           <td>{{isset($value->userdata->name)?$value->userdata->name:'Super Admin'}}</td>
                           <td>
                           @if($value->action=='1')
                            <button type="submit" class="btn btn-xs btn-success">Create</button>
                            <button type="submit" class="btn btn-xs btn-success">{{$value->action_detail}}</button>
                           @elseif($value->action=='2')
                           <button type="submit" class="btn btn-xs btn-warning">Update</button>
                           <button type="submit" class="btn btn-xs btn-success">{{$value->action_detail}}</button>
                           @elseif($value->action=='3')
                            <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                            <button type="submit" class="btn btn-xs btn-success">{{$value->action_detail}}</button>
                           @elseif($value->action=='4')
                            <button type="submit" class="btn btn-xs btn-success">Login</button>
                           @elseif($value->action=='5')
                            <button type="submit" class="btn btn-xs btn-info">Logout</button>
                           @endif
                          
                           <!-- {{isset($value->Patientdata->first_name)?' For '.ucfirst($value->Patientdata->first_name.' '.$value->Patientdata->last_name):''}}  -->
                           </td>
                          <td>{{isset($value->created_at)?date("j/n/Y, h:i A",strtotime($value->created_at)):''}}</td>
                          <td>{{$value->ip_address?$value->ip_address:''}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    @else
                    <h5 class="box-title text-danger">There is no data.</h3>
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
      //  For   Bootstrap  datatable 
      $(function () {

        $('#example1').DataTable( {
              lengthChange: true,
          // order: [[1, 'asc']],
          lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],     // page length options
          columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
            } ],
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
            dom: 'Bfrtip',
            buttons: [
               
                {
                    extend: 'print',
                    text: 'Print'
                },
                
                {
                    extend: 'excelHtml5',
                    text: 'Excel'
                },
                
                {
                    extend: 'csv',
                    text: 'Csv'
                },
               
                {
                    extend: 'pdf',
                    text: 'Pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
                ,
                'pageLength','colvis'

            ],
            // select: true,
        });
        
      });

      function delete_record(website_id,rowId)
      {
          if(confirm('Do you want  to  delete this?'))
          {     
              $.ajax({
                  type: "POST",
                  url: "{{url('admin/delete_patient')}}",
                  data: {'row_id':rowId,website_id:website_id,"_token":"{{ csrf_token() }}"},
                  success: function(result){
                      console.log(result);
                      if(result=='200'){
                        $('#row_'+rowId).remove();
                        $('.alertmessage').html('<span class="text-success">Row deleted...</span>');
                      }
                      else{ 
                        $('.alertmessage').html('<span class="text-success">Somthing event wrong!...</span>'); 
                        }
                  }
              });
          }
      }


    </script>
@endsection
