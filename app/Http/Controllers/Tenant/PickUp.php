<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Patient;
use App\Models\Tenant\Location;
use App\Models\Tenant\Facility;
use App\Models\Tenant\Pickups;
use App\Models\Tenant\AccessLevel;
use App\Models\Tenant\EventsLog; 
use Carbon\Carbon;
use DB; 
use Session;

class PickUp extends Controller
{
    protected $views='';
    public function __construct(){
        $this->views='tenant';
       // dd(session()->all());

       $host=explode('.',request()->getHttpHost());
       //dd($host[0]);
       config(['database.connections.tenant.database' => $host[0]]);
       DB::purge('tenant');
       DB::reconnect('tenant');
       DB::disconnect('tenant'); 
    }
    /* Start  of  Pickups */
    public  function  pickups(Request $request)
    {
        $data=array();
        $data['created_at']=$request->day?$request->day:"";
        $data['patients']=Patient::get();
        //return $data['patients'][0]->latestPickups;
        $data['locations']=Location::get();
        return  view($this->views.'.pickups',$data); 
    }

    public  function  pickupsEdit(Request $request,$tenantName,$id)
    {
        
        $pickups=Pickups::find($id);
        if(!$pickups){
            return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Pickups id <strong>'.$id.'</strong> doesnot match in our records.</div>']);
        }

        if ($request->isMethod('post')) {
            //return $request->all();
            $validateArr=array(
                'patient_id'      => 'required|numeric|min:1',
                'dob'               => 'date_format:Y-m-d|before:tomorrow',
                'no_of_weeks'       => 'required|numeric|min:1',
                'pick_up_by'        => 'required|string|max:255'
            );
    
            $insert_data=array(
                'patient_id'=>$request->patient_id,
                'dob'=>$request->dob,
                'no_of_weeks'=>$request->no_of_weeks,
                'notes_from_patient'=>$request->notes_from_patient,
                'pick_up_by'=>$request->pick_up_by,
                'location'=>isset($request->location)?implode(',',$request->location):'',
                'patient_sign'=>$request->patient_sign,
                'pharmacist_sign'=>$request->pharmacist_sign,
            );   
    
            if($request->has('pick_up_by') && $request->get('pick_up_by')=='carer'){
                $validateArr['carer_name']='required';
                $insert_data['carer_name']=$request->get('carer_name');
            }
           
            $validator = $request->validate($validateArr); 
            $pickups->update($insert_data);
            EventsLog::create([
                'website_id' => $request->session()->get('phrmacy')->website_id,
                'action_by' => $request->session()->get('phrmacy')->id,
                'action' => 2,
                'action_detail' => 'PickUp',
                'comment' => 'Update PickUp',
                'patient_id' => $request->patient_id,
                'ip_address' => $request->ip(),
                'type' => $request->session()->get('phrmacy')->roll_type,
                'user_agent' => $request->userAgent(),
                'authenticated_by' => 'packnpeaks',
                'status' => 1
            ]);
            return redirect('pickups_reports')->with(["msg"=>'<div class="alert alert-success">Pickups Report <strong> Updated </strong> .</div>']);

        }

        $data=array();
        $data['patients']=Patient::get();
        $data['locations']=Location::get();
        $data['facilities']=Facility::get();
        $data['pickups']=$pickups;
        //return $data;
        return  view($this->views.'.pickupsEdit',$data); 

    }

    public  function  pickupsShow(Request $request,$tenantName,$id)
    {
        $pickups=Pickups::find($id);
        if(!$pickups){
            return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Pickups id <strong>'.$id.'</strong> doesnot match in our records.</div>']);
        }


        $data=array();
        $data['patients']=Patient::get();
        $data['locations']=Location::get();
        $data['facilities']=Facility::get();
        $data['pickups']=$pickups;
        //return $data;
        return  view($this->views.'.pickupsShow',$data); 
    }

    public  function pickupsDelete(Request $request,$tenantName,$id)
    {
        $pickups=Pickups::find($id);
        if(!$pickups){
            return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Patient id <strong>'.$id.'</strong> doesnot match in our records.</div>']);
        }

        $patient_name=$pickups->patients->first_name.' '.$pickups->patients->last_name;
        $pickups->delete();
        EventsLog::create([
            'website_id' => $request->session()->get('phrmacy')->website_id,
            'action_by' => $request->session()->get('phrmacy')->id,
            'action' => 3,
            'action_detail' => 'PickUp',
            'comment' => 'Delete PickUp',
            'patient_id' => $pickups->patient_id,
            'ip_address' => $request->ip(),
            'type' => $request->session()->get('phrmacy')->roll_type,
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
        ]);
        return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Pickups of this patient (<strong>'.$patient_name.'</strong>) deleted Successfully.</div>']);
    }

    public  function  add_pickups(Request $request)
    {
         
        // print_r($request->all());die; 
        $validateArr=array(
            'patient_id'        => 'required|numeric|min:1',
            'dob'               => 'date_format:Y-m-d|before:tomorrow',
            'no_of_weeks'       => 'required|numeric|min:1',
            'pick_up_by'        => 'required|string|max:255',
            'patient_sign'      => 'required|string|max:9000',
            'pharmacist_sign'   => 'required|string|max:9000'
        );
        $insert_data=array(
            'patient_id'=>$request->patient_id,
            'dob'=>$request->dob,
            'no_of_weeks'=>$request->no_of_weeks,
            'notes_from_patient'=>$request->notes_from_patient,
            'pick_up_by'=>$request->pick_up_by,
            'location'=>isset($request->location)?implode(',',$request->location):'',
            'patient_sign'=>$request->patient_sign,
            'pharmacist_sign'=>$request->pharmacist_sign,
            'last_pick_up_date'=>$request->last_pick_up_date,
            'weeks_last_picked_up'=>$request->weeks_last_picked_up
        );  
         
        if(!empty($request->created_at))
        { 
         $request->created_at=substr($request->created_at,0,10);
         $created_at=\Carbon\Carbon::createFromFormat('Y-m-d',$request->created_at);
         $insert_data['created_at']=$created_at;
        }

        if($request->has('pick_up_by') && $request->get('pick_up_by')=='carer'){
            $validateArr['carer_name']='required';
            $insert_data['carer_name']=$request->get('carer_name');
        }

        if(!empty($request->session()->get('phrmacy')))
        {
            $insert_data['website_id']=$request->session()->get('phrmacy')->website_id; 
            $insert_data['created_by']='-'.$request->session()->get('phrmacy')->id;
            
        }
        $validator = $request->validate($validateArr); 

        $save_res=Pickups::create($insert_data);
        EventsLog::create([
            'website_id' => $request->session()->get('phrmacy')->website_id,
            'action_by' => $request->session()->get('phrmacy')->id,
            'action' => 1,
            'action_detail' => 'PickUp',
            'comment' => 'Create PickUp',
            'patient_id' => $request->patient_id,
            'ip_address' => $request->ip(),
            'type' => $request->session()->get('phrmacy')->roll_type,
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
        ]);
        $patient=Patient::find($request->patient_id);
        
        return redirect()->back()->with(["msg"=>'<div class="alert alert-success">Your <strong> Pick Ups</strong> Added Successfully.</div>']);
    }
   /* End  of  Pickups */
   /* Start  of  pickups_reports */
    public  function  pickups_reports()
    {
        $patient=Patient::orderBy('first_name','asc')->get();
        $pickups=Pickups::get();
        $data['pickups']=$pickups;
        $data['patients']= $patient;
        return  view($this->views.'.pickups_reports',$data); 
    }
   /* End of  pickups_reports */

    /* Start  of  last_month_pickups_reports */
    public  function  patients_picked_up_last_month()
    {
        $prevMonthDate = date("Y-m-d 00:00:00", strtotime("first day of previous month"));
        $lastMonthDate = date("Y-m-d 24:00:00", strtotime("last day of previous month"));

        $patient=Patient::whereHas('pickups',function($query){ 
        $prevMonthDate = date("Y-m-d 00:00:00", strtotime("first day of previous month"));
        $lastMonthDate = date("Y-m-d 24:00:00", strtotime("last day of previous month"));
        $query->where([['created_at','>=', $prevMonthDate],['created_at','<=',$lastMonthDate]]);  })->orderBy('first_name','asc')->get();
        $data['patients']= $patient;

        $pickups=Pickups::where([['created_at','>=', $prevMonthDate],['created_at','<=',$lastMonthDate]])->orderBy('created_at','desc')->get();
        $data['pickups']=$pickups;
        //return $pickups;
        return  view($this->views.'.pickups_reports_last_month',$data); 
    }
   /* End of  last_month_pickups_reports */


 /* get All Pickup  for this Specific month */
 public  function  getAllPickupForMonth(Request $request){
    $month=$request->month;
    $year=$request->year;
    $allPickups=0;
       $allPickups=Pickups::whereRaw('MONTH(`created_at`) = '.$month.' AND YEAR(`created_at`) = '.$year)->get()->count();
       return $allPickups;
   }


   /* pickups_calender */
    public  function  pickups_calender(Request $request)
    {
        $pickups=Pickups::get();
        $data['pickups']=$pickups;
        // $now = Carbon::now(); 
        // $allPickups=$this->getAllPickupForMonth($now->month,$now->year);
        // $data['allPickups']=$allPickups; 
       
        // if(session()->has('phrmacy') && session()->get('phrmacy')->id>0)
        // echo session()->get('phrmacy')->website_id;
        $getAccess=AccessLevel::first(); 
        if(!empty($getAccess)){
          $default_cycle=$getAccess->default_cycle;
        }
        else{
            $default_cycle=4;
        }
        
        $getAllPatient=Pickups::distinct()->get(['patient_id']);
       
        $allLastPickup=array();
        foreach($getAllPatient as $key=>$value){
            if($value->patient_id!=""){
                $getLastPickup=Pickups::where('patient_id',$value->patient_id)->orderBy('created_at', 'DESC')->first();
                array_push($allLastPickup,$getLastPickup);
            }
        }

        $allNeaxtPickup=array();
        
        foreach($allLastPickup as $key=>$row){

            $no_of_weeks=$row->no_of_weeks?$row->no_of_weeks-1:0;
            for($i=0;$i < $no_of_weeks; $i++){
               $start_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$row->created_at);
               $nextdate=$start_date->addWeeks($default_cycle);
               $row->created_at=$nextdate;
               $row->updated_at=$nextdate;
               
               $nextpickup['id']=$i;
               $nextpickup['patient_id']=$row->patient_id;
               $nextpickup['dob']=$row->dob;
               $nextpickup['last_pick_up_date']=$row->created_at;
               $nextpickup['weeks_last_picked_up']=$row->weeks_last_picked_up;
               $nextpickup['no_of_weeks']=$row->no_of_weeks;
               $nextpickup['location']=$row->location;
               $nextpickup['pick_up_by']=$row->pick_up_by;
               $nextpickup['carer_name']=$row->carer_name;
               $nextpickup['notes_from_patient']=$row->notes_from_patient;
               $nextpickup['pharmacist_sign']=$row->pharmacist_sign;
               $nextpickup['patient_sign']=$row->patient_sign;
               $nextpickup['created_by']=$row->created_by;
               $nextpickup['deleted_by']=$row->deleted_by;
               $nextpickup['status']=$row->status;
               $nextpickup['deleted_at']=$row->deleted_at;
               $nextpickup['is_archive']=$row->is_archive;
               $nextpickup['website_id']=$row->website_id;
               $nextpickup['created_at']=$nextdate;
               $nextpickup['updated_at']=$nextdate;
               $nextpickup['patients']=$row->patients;
               array_push($allNeaxtPickup,$nextpickup); 
            }
            // echo $start_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$row->created_at);
            // echo $start_date->addWeeks($default_cycle);
            // echo json_encode($allNeaxtPickup);die; 
        }
        $data['nextPickupList']=(object)$allNeaxtPickup;
        return  view($this->views.'.pickups_calender',$data); 
    }
   /* pickups_calender */

   /* 6_month_compliance */
    public  function six_month_compliance()
    {
        $lastSixMonthDate = date("Y-m-d 00:00:00", strtotime("- 6 months"));
        $patient=Patient::whereHas('pickups',function($query){ 
        
        $lastSixMonthDate = date("Y-m-d 00:00:00", strtotime("- 6 months"));
       
        $query->where([['created_at','>=', $lastSixMonthDate]]);  })->orderBy('first_name','asc')->get();

        $pickups=Pickups::where([['created_at','>=', $lastSixMonthDate]])->orderBy('created_at','desc')->get();
        $data['pickups']=$pickups;
        $data['patients']= $patient;
        return  view($this->views.'.six_month_compliance',$data); 
    }  
   /* 6_month_compliance */

   /* all_compliance */
    public  function  all_compliance()
    {
        $patient=Patient::whereHas('pickups',function($query){ 
        
        $lastSixMonthDate = date("Y-m-d 00:00:00", strtotime("- 6 months"));
        
        $query->where([['created_at','>=', $lastSixMonthDate]]);  })->orderBy('first_name','asc')->get();
        $data['patients']= $patient;
        return  view($this->views.'.all_compliance',$data); 
    }
   /* all_compliance */
   
}
