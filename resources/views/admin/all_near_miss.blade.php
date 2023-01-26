@extends('admin.layouts.mainlayout')
@section('title') <title>All Near Miss</title>
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           All Near Miss
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
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
                  <h3 class="box-title">All Near Miss List</h3> <div class="pull-right alertmessage"></div>
                </div><!-- /.box-header -->
                <div class="box-body pre-wrp-in table-responsive">
               

                @if(isset($all_missed_patients))
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Pharmacy</th>
                        <th>Date Time</th>
                        <th>Person Involved</th>
                        <th>Missed Tablet</th>
                        <th>Extra Tablet</th>
                        <th>Wrong Tablet</th>
                        <th>Wrong Day</th>
                        <th>Other?</th>
                        <th style="width: 60px;" >Action</th>
                      </tr>
                    </thead>
                    <tbody>
                     @foreach($all_missed_patients as $value)
                      <tr id="row_{{$value->id}}">
                        <td></td>
                        <!-- <td><input type="checkbox" class="checkbox" data-id="{{$value->id}}" website-id="{{$value->website_id}}"></td> -->
                        <td>{{ucfirst($value->pharmacy)}}</td>
                        <td>{{date("j/n/Y, h:i A",strtotime($value->created_at))}}</td>
                        <td>{{$value->person_involved}}</td>
                        <td>@if($value->missed_tablet!=NULL) 1 @else 0 @endif</a></td>
                        <td>@if($value->extra_tablet!=NULL) 1 @else 0 @endif</td>
                        <td>@if($value->wrong_tablet!=NULL) 1 @else 0 @endif</td>
                        <td>@if($value->wrong_day!=NULL) 1 @else 0 @endif</td>
                        <td>@if($value->other!=NULL){{$value->other}} @endif</td>
                        <td>
                        <a href="javascript:void(0)" onclick="view_info('Near Miss Overview','{{$value->website_id}}','{{$value->id}}','near_miss_info')" title="View info" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Info</a>
                        &nbsp;&nbsp;
                        <a href="javascript:void(0);" title="delete" onclick="delete_record('{{$value->website_id}}','{{$value->id}}');" ><i class="fa fa-trash text-danger"></i>&nbsp;&nbsp;
                        
                        <a href="{{url('admin/edit_near_miss/'.$value->website_id.'/'.$value->id)}}" title="edit"><i class="fa fa-edit text-success"></i></a></td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  @else
                  <h5 class="box-title text-danger">There is no data.</h3>
                  @endif
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              <div class="row">
                      <div class="col-md-offset-10 col-md-2">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#SummaryModal"><b>Missed Summary</b></a>
                      </div>
                  </div>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->


      <!-- Modal for All Summary -->
  <div class="modal fade" id="SummaryModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" style="height:230px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title " style="font-size:18px; font-weight:bold;" > <i class="fa fa-file-o"></i> Summary</h5>
        </div>
        <div class="modal-body">
           <table class="table">
             <tr>
               <th>MissedTablet</th>
               <td>{{$allMissedTablet}}</td>
             </tr>
             <tr>
               <th>ExtraTablet</th>
               <td>{{$allExtraTablet}}</td>
             </tr>
             <tr>
               <th>WrongTablet</th>
               <td>{{$allWrongTablet}}</td>
             </tr>
             <tr>
               <th>WrongDay</th>
               <td>{{$allWrongDay}}</td>
             </tr>

           </table>
        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
  </div>


@endsection


@section('customjs')


    <script type="text/javascript">
      //  For   Bootstrap  datatable 
      $(function () {
          // CheckBox 
          $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
          });

        // Data atable With Export Button  
        $('#example1').DataTable( {

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
                  url: "{{url('admin/delete_near_miss')}}",
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
