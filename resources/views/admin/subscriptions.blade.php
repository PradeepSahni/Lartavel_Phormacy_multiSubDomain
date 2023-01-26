@extends('admin.layouts.mainlayout')
@section('title') <title>All Subscriptions</title>

@endsection





@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           All Subscriptions
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="dashboard">Forms</a></li>
            <li class="active">General Elements</li>
          </ol>
        </section>

       

        @if(isset($subscription) && count($subscription))
             <!-- Main content -->
        <section class="content">
          
        <div class="row">
            
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header pre-wrp">
                <form role="form" action="{{url('admin/update_subscription/'.$subscription[0]->id)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <div class="box-body">
                        <div class="col-md-3">
                            <div class="form-group">
                              <label for="subcription">Subcription Type</label>
                              <input type="text" class="form-control" maxlength="20" value="{{$subscription[0]->title}}" required id="title" name="title" placeholder="Subscription..">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                              <label for="plan_validity">Plan Validity</label>
                              <input type="text" class="form-control" maxlength="20" value="{{$subscription[0]->plan_validity}}" required id="plan_validity" name="plan_validity" placeholder="plan validity..">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="padding-top:25px; ">
                              <button type="submit" class="btn btn-primary">Update</button> 
                            </div>
                        </div>
                        
                 </div>

                </form>
                </div><!-- /.box-header -->
              </div><!-- /.box -->


          </div>   <!-- /.row -->
        </section><!-- /.content -->
        @endif    



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
                  <h3 class="box-title">All Subscriptions List</h3> <div class="pull-right alertmessage"></div>
                </div><!-- /.box-header -->
                <div class="box-body pre-wrp-in table-responsive">
                  
                 @if( isset($subcriptions) && count($subcriptions))
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                     <tr>
                        <th style="width: 150px;" >Subcription Type</th>
                        <th style="width: 150px;" >Plan Validity (Number of days)</th>
                        <!-- <th style="width: 350px;" >Manage Subcription</th> -->
                        <th style="width: 60px;" >Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($subcriptions as $row)
                      <tr id="row_{{$row['id']}}">
                        <td ><b>{{ucfirst($row->title)}}</b></td>
                        <td ><b>{{$row->plan_validity}}</b></td>
                        <td>
                        <a href="{{url('admin/'.strtolower($row->title).'/add_form/'.$row->id)}}" class="btn btn-xs btn-primary">Form Setting</a> &nbsp;&nbsp;&nbsp;
                        <a href="{{url('admin/edit_subscription/'.$row->id)}}" title="edit"><i class="fa fa-edit text-success"></i></a>
                        </td>
                      </tr>
                      @endforeach

                    </tbody>
                   
                  </table>
                  @else
                   <div class="text-center text-danger"><span>There are no data.</span></div>
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
              dom: 'Bfrtip',
              buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5',
              ]
          } );
        
      });

    </script>
@endsection
