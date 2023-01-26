@extends('admin.layouts.mainlayout')
@section('title') <title>All Pharmacies</title>

@endsection





@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           All Pharmacies
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{{url('admin/all_pharmacies')}}"><i class="fa fa-dashboard"></i> Home</a></li>
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
                  <h3 class="box-title">All Pharmacies List <i class="fa fa-hospital-o"></i> </h3> <div class="pull-right alertmessage"></div>
                </div><!-- /.box-header -->


                <div class="box-body pre-wrp-in table-responsive">
                    @if(count($all_pharmacies))
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th style="width: 150px;" >Name</th>
                        <th>Email</th>
                        <th>Initials Name</th>
                        <th>Pharmacy</th>
                        <th>Registration</th>
                        <th>Phone</th>
                        <th>Host Name</th>
                        <th>Website Url</th>
                        <th>Validity</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($all_pharmacies as $row)
                      <?php
                    $current_date=\Carbon\Carbon::now()->format('Y-m-d');
                    $start_date = \Carbon\Carbon::createFromFormat('Y-m-d',$current_date);
                    $end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $row['expired_date']);
                    if($end_date >$start_date)
                    {
                       $different_days = $start_date->diffInDays($end_date).' days remaining';
                    }
                    else
                    {
                      $different_days='plan has been expired';
                    }
                  ?>
                      <tr id="row_4">
                        <td></td>
                        <td>{{$row['name']}}</td>
                        <td>{{$row['email']}}</td>
                        <td>{{$row['initials_name']}}</td>
                        <td>{{$row['company_name']}}</td>
                        <td>{{$row['registration_no']}}</td>
                        <td>{{$row['phone']}}</td>
                        <!-- <td>{{$row['address']}}</td> -->
                        <td>{{ucfirst($row['host_name'])}}</td>
                        <td><a href="{{'http://'.$row['host_name'].'.packnpeaks.tk'}}" target="_blank">{{'http://'.$row['host_name'].'.packnpeaks.tk'}}</td>
                        <td class="text-danger">{{$different_days}}</td>
                        <td>
                        <a href="{{url('admin/pharmacy_deatils/'.$row['website_id'])}}" class="btn btn-xs fa fa-eye" title="Details"></a>
                        <a href="{{url('admin/edit_pharmacy/'.$row['website_id'])}}" class="btn btn-xs fa fa-edit" title="Edit"></a>
                        
                        <a  onclick="extends_validity('{{$row["website_id"]}}','{{$row["company_name"]}}','{{$row["registration_no"]}}')" class="btn btn-xs btn-info" title="extends">Extend Plans</a>

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


<!-- Modal  From Extends validity -->
<div id="extends_plan_Modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="height:230px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Extend Validity Plans</h4>
      </div>
      <div class="modal-body">
        <form action="{{url('admin/update_validity')}}"  method="post" >
            {{ csrf_field() }}
         <div class="row">
             <div class="col-sm-4">
                <div class="form-group">
                    <label>Parmacy</label>
                    <input type="hidden" name="website_id"  id="website_id">
                    <p class="pharmacy_name"></p>
                </div>
                
             </div>
             <div class="col-sm-4">
               <div class="form-group">
                    <label>Registration</label>
                    <p class="pharmacy_registration_number"></p>
                </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group">
                   <label>Extends validity (days)</label>
                   <input type="text" name="plan_validity" id="plan_validity" required="required" onkeypress="return restrictAlphabets(event);" maxlength="10" class="form-control" placeholder="validity">
                </div>
             </div>
             <div class="col-sm-offset-8 col-sm-4">
                 <button type="submit" class="btn btn-primary btn-block" >Submit</button>
             </div>
         </div>
        </form>
      </div>
      
    </div>

  </div>
</div>



@endsection


@section('customjs')


    <script type="text/javascript">

      /*Extends Validity  of Subcription plan */
       function extends_validity(website_id,company_name,registration_no)
       {
          $('#website_id').val(website_id);
          $('.pharmacy_name').html(company_name);
          $('.pharmacy_registration_number').html(registration_no);
          $('#extends_plan_Modal').modal();
       }

       function restrictAlphabets(e){
        var x=e.which||e.keycode; 
        if((x>=48 && x<=57) || x==8)
        return true;
        else
        return false;
      }

      $(document).ready(function(){

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
            // select: true,
        });
        
      });

    </script>
@endsection
