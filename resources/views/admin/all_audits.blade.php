@extends('admin.layouts.mainlayout')
@section('title') <title>All Audits</title>


@endsection





@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           All Audits
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
                  <h3 class="box-title">All Audits List</h3> <div class="pull-right alertmessage"></div>
                </div><!-- /.box-header -->
                <div class="box-body pre-wrp-in table-responsive">
                
                @if(isset($all_audit))
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <!-- <th><input type="checkbox" id="check_all"></th> -->
                        <th></th>
                        <th>Pharmacy</th>
                        <th>Date Time</th>
                        <th>Patient Name</th>
                        <th>Number of weeks</th>
                        <th>Store</th>
                        <th>Staff initials</th>
                        <th style="width: 60px;" >Action</th>
                      </tr>
                    </thead>
                    <tbody>
                     @foreach($all_audit as $value)
                      <tr id="row_{{$value->id}}">
                       <td></td>
                        <!-- <td><input type="checkbox" class="checkbox" data-id="{{$value->id}}" website-id="{{$value->website_id}}"></td> -->
                        <td>{{ucfirst($value->pharmacy)}}</td>
                        <td>{{date("j/n/Y, h:i A",strtotime($value->created_at))}}</td>
                        <td>{{ucfirst($value->first_name).' '.ucfirst($value->last_name)}}</a></td>
                        <td>{{$value->no_of_weeks}}</td>
                        <td>{{$value->store}}@if(isset($value->store_others_desc))<br/>-{{$value->store_others_desc}}@endif</td>
                        <td>{{$value->staff_initials}}</td>
                        <td>
                        <a href="javascript:void(0)" onclick="view_info('Audit Overview','{{$value->website_id}}','{{$value->id}}','audit_info')" title="View info" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Info</a>
                          &nbsp;&nbsp;
                        <a href="javascript:void(0);" title="delete" onclick="delete_record('{{$value->website_id}}','{{$value->id}}');" ><i class="fa fa-trash text-danger"></i>&nbsp;&nbsp;
                        
                        <a href="{{url('admin/edit_audit/'.$value->website_id.'/'.$value->id)}}" title="edit"><i class="fa fa-edit text-success"></i></a></td>
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
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
       var table= $('#example1').DataTable( {
             lengthChange: true,
            order: [[1, 'asc']],
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
              select: true,
            
        });

        
        


      });



      function delete_record(website_id,rowId)
      {
          if(confirm('Do you want  to  delete this?'))
          {     
              $.ajax({
                  type: "POST",
                  url: "{{url('admin/delete_audit')}}",
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
