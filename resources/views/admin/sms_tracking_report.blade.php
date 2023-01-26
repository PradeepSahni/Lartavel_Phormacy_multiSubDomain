@extends('admin.layouts.mainlayout')
@section('title') <title>Sms Tracking Report</title>

@endsection





@section('content')
 <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
           <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
            Sms Tracking Report
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
                    <h3 class="box-title">{{__('Sms Tracking Report')}}</h3> 
                    <div class="pull-right alertmessage"></div>
                  </div><!-- /.box-header -->

                  <div class="box-body pre-wrp-in table-responsive">
                  
                    <table id="example1" class="table table-bordered table-striped display nowrap" style="width:100%">
                      <thead>
                        <tr>

                        <th></th><th style="width: 150px;"></th>

                        <th colspan="2">{{__('January')}}</th>
                        <th colspan="2">{{__('Febraury')}}</th>
                        <th colspan="2">{{__('March')}}</th>
                        <th colspan="2">{{__('April')}}</th>
                        <th colspan="2">{{__('May')}}</th>
                        <th colspan="2">{{__('June')}}</th>
                        <th colspan="2">{{__('July')}}</th>
                        <th colspan="2">{{__('August')}}</th>
                        <th colspan="2">{{__('September')}}</th>
                        <th colspan="2">{{__('October')}}</th>
                        <th colspan="2">{{__('November')}}</th>
                        <th colspan="2">{{__('December')}}</th>

                        </tr>
                        <tr>
                          <th>S.No</th>
                          <th style="width: 150px;">Pharmacy Name</th>
                          <th style="width: 150px;">Patient Name</th>

                          <th>Total No</th>
                          <th>Amount</th>

                          <th>Total No</th>
                          <th>Amount</th>

                          <th>Total No</th>
                          <th>Amount</th>

                          <th>Total No</th>
                          <th>Amount</th>

                          <th>Total No</th>
                          <th>Amount</th>

                          <th>Total No</th>
                          <th>Amount</th>

                          <th>Total No</th>
                          <th>Amount</th>

                          <th>Total No</th>
                          <th>Amount</th> 

                          <th>Total No</th>
                          <th>Amount</th>

                          <th>Total No</th>
                          <th>Amount</th>

                          <th>Total No</th>
                          <th>Amount</th>

                          <th>Total No</th>
                          <th>Amount</th>

                      
                        </tr>
                      </thead>
                      <tbody>
                        @php $i=0;
                        @endphp
                        @forelse($sms_trackings as $pharmacyName=>$sms_tracking)
                       
                          @foreach($sms_tracking as $patient_id=>$sms)
                         
                            <tr>
                            
                                <td>{{++$i}}</td>
                                <td>{{$pharmacyName}}</td>
                                <td style="width: 150px;">{{$patients_names[$pharmacyName][$patient_id]->first_name .' '.$patients_names[$pharmacyName][$patient_id]->last_name}}</td>
                                @foreach($sms as $month)
                                  @php
                                  
                                    $total=$month['total']>0?$month['total']+1 : $month['total'];
                                  @endphp
                                  <td>{{$total>0?$total:'-'}}</td>
                                  <td>{{$total>0?($total)*(0.2):'-'}}</td>
                                @endforeach
                            </tr>
                          
                          @endforeach

                          @empty
                          <tr><td colspan="26">{{__('No Records')}}</td></tr>

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
