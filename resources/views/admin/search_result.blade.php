@extends('admin.layouts.mainlayout')
@section('title') <title>Patient Search</title>
<style type="text/css">
	th{
		text-align:center;
	}
</style>
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           Search Result
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb" style="padding-right:200px; margin-bottom: 10px;">
            <a href="{{url('admin/create_patient_details_pdf/'.$patient->website_id.'/'.$patient->id)}}"  class="bg-primary" style="padding:10px;">Pdf</a>
                   <a href="javascript:void(0)" onclick="window.print()" class="bg-primary" style="padding:10px;">Print</a>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            
              <!-- general form elements -->
              <div class="box box-primary">
              	
              	 
                <div class="box-header pre-wrp">
                	
                	<div class="col-md-offset-1 col-md-10 table-responsive">
                    <h2> Patient Information </h2>
					<table class="table table-bordered table-striped table-hover table-condensed">
						<tbody>
							@php 
							$m=explode(',',$patient->location);
							$locations=App\Models\Admin\Location::select('name')->whereIn('id', $m)->get();
							@endphp
							<tr>
								<th class="text-center"> First Name </th>
								<th class="text-center"> Last Name </th>
								<th class="text-center"> DOB </th>
								<th class="text-center"> Facility </th>
								<th class="text-center"> Location </th>
								<th class="text-center"> Phone </th>
								<th class="text-center"> Carer Mobile </th>
							</tr>
							<tr >
								<th class="text-center"> {{ucfirst($patient->first_name)}} </th>
								<th class="text-center"> {{ucfirst($patient->last_name)}} </th>
								<th class="text-center">{{date("j/n/Y",strtotime($patient->dob))}}</th>
								<th class="text-center"> {{ucfirst($patient->facility->name)}} </th>
								<th class="text-center"> 
								@if(isset($locations) && count($locations))
								@php $locationarray=array(); @endphp
								@foreach($locations as $row)
									@php array_push($locationarray,$row->name); @endphp 
								@endforeach
								{{implode(',',$locationarray)}}
								@endif
								</th>
								<th class="text-center"> {{$patient->phone_number}} </th>
								<th class="text-center"> {{$patient->mobile_no}} </th>
							</tr>
						</tbody>
					</table>
					<h2> Picks Up</h2>
					<table class="table table-bordered table-striped table-hover table-condensed">
						<tbody>
							<tr>
								<th class="text-center"> Date-Time </th>
								<th class="text-center"> Notes For Patients </th>
								<th class="text-center"> Number of Weeks </th>
								<th class="text-center"> Who is picking up? </th>
								<th class="text-center"> Carers Name </th>
								<th class="text-center"> Notes </th>
							</tr>
							@if(count($allPickup))
							@foreach($allPickup as $pickup)
							<tr>
								<th class="text-center"> {{date("j/n/Y h:i:s A",strtotime($pickup->created_at))}} </th>
								<th class="text-center"> {{$pickup->notes_from_patient}} </th>
								<th class="text-center"> {{$pickup->no_of_weeks}} </th>
								<th class="text-center"> {{ucfirst($pickup->pick_up_by)}} </th>
								<th class="text-center"> {{ucfirst($pickup->carer_name)}} </th>
								<th class="text-center"> {{$pickup->notes_from_patient}} </th>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
					<h2>Checking</h2>
					<table class="table table-bordered table-striped table-hover table-condensed">
						<tbody>
							<tr>
								<th class="text-center"> Date-Time </th>
								<th class="text-center"> Number of weeks </th>
							</tr>
							@if(count($allChecking))
							@foreach($allChecking as $checking)
							<tr>
								<th class="text-center"> {{date("j/n/Y h:i:s A",strtotime($checking->created_at))}}</th>
								<th class="text-center"> {{$checking->no_of_weeks}} </th>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
					<h2>Returns</h2>
					<table class="table table-bordered table-striped table-hover table-condensed">
						<tbody>
							<tr>
								<th class="text-center"> Date-Time </th>
								<th class="text-center"> Select Days/Weeks </th>
								<th class="text-center"> Number of days/weeks returned </th>
								<th class="text-center"> Strore </th>
								<th class="text-center"> Staff initials </th>
							</tr>
							@if(count($allPatientReturn))
							@foreach($allPatientReturn as $return)
							<tr>
								<th class="text-center"> {{date("j/n/Y h:i:s A",strtotime($return->created_at))}} </th>
								<th class="text-center"> {{$return->day_weeks}} </th>
								<th class="text-center"> {{$return->returned_in_days_weeks}} </th>
								<th class="text-center"> {{isset($return->stores->name)?$return->stores->name:''}} {{$return->other_store?', Other :'.$return->other_store:''}} </th>
								<th class="text-center"> {{$return->staff_initials}} </th>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
					<h2> Audits </h2>
					<table class="table table-bordered table-striped table-hover table-condensed">
						<tbody>
							<tr>
								<th class="text-center"> Date-Time </th>
								<th class="text-center"> Number of weeks </th>
								<th class="text-center"> Store </th>
								<th class="text-center"> Staff initials </th>
							</tr>
							@if(count($allAudit))
							@foreach($allAudit as $audit)
							<tr>
								<th class="text-center"> {{date("j/n/Y h:i:s A",strtotime($audit->created_at))}} </th>
								<th class="text-center"> {{$audit->no_of_weeks}} </th>
								<th class="text-center"> {{$audit->stores->name}} </th>
								<th class="text-center"> {{$audit->staff_initials}} </th>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
					</div>
                </div><!-- /.box-header -->
              </div><!-- /.box -->


          </div>   <!-- /.row -->
        </section><!-- /.content -->



      </div><!-- /.content-wrapper -->



 

@endsection


@section('customjs')
    <script type="text/javascript">

    </script>
@endsection
