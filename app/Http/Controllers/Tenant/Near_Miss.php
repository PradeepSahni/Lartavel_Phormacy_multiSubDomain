<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\MissedPatient;
use App\Models\Tenant\EventsLog; 
use DB;

class Near_Miss extends Controller
{
   protected $views='';
   public function __construct(){
      $this->views='tenant';
      $host=explode('.',request()->getHttpHost());
      //dd($host[0]);
      config(['database.connections.tenant.database' => $host[0]]);
      DB::purge('tenant');
      DB::reconnect('tenant');
      DB::disconnect('tenant'); 
   }

   public  function  near_miss(Request $request)
   {
      
      return view($this->views.'.near_miss'); 
   }

   public  function  all_near_miss()
   {
      
      $data=[];
      $data['missedPatients']=MissedPatient::get();
      $missedTablet=MissedPatient::where('missed_tablet',1)->get();
      $extraTablet=MissedPatient::where('extra_tablet',1)->get();
      $wrongTablet=MissedPatient::where('wrong_tablet',1)->get();
      $wrongDay=MissedPatient::where('wrong_day',1)->get();
      $data['allMissedTablet']=$missedTablet->count();
      $data['allExtraTablet']=$extraTablet->count();
      $data['allWrongTablet']=$wrongTablet->count();
      $data['allWrongDay']=$wrongDay->count();
      return view($this->views.'.all_near_miss',$data);
   }

   public  function  nm_last_month()
   {
      $data=[];
      $prevMonthDate = date("Y-m-d 00:00:00", strtotime("first day of previous month"));
      $lastMonthDate = date("Y-m-d 24:00:00", strtotime("last day of previous month"));
      $data['missedPatients']=MissedPatient::where([['created_at','>=', $prevMonthDate],['created_at','<=',$lastMonthDate]])->orderBy('created_at','desc')->get();
      return  view($this->views.'.nm_last_month',$data);
   }


   public function nm_monthly()
   {
      $data=[];
      $data['missedPatients']=MissedPatient::get();
      return  view($this->views.'.nm_monthly',$data); 
   }  


   public  function save_near_miss(Request $request)
   {    
      // return $request->all(); die; 
      $validate_array=array(
         'person_involved'  => 'required|string|max:255',
         'initials'         => 'required|string|max:255'
      ); 

      $insert_data=array(
         'person_involved'=>$request->person_involved,
         'other'=>$request->other,
         'initials'=>$request->initials
      ); 

      $insert_data['missed_tablet']=$request->has('missed_tablet')?1:0;
      $insert_data['extra_tablet']=$request->has('extra_tablet')?1:0;
      $insert_data['wrong_tablet']=$request->has('wrong_tablet')?1:0;
      $insert_data['wrong_day']=$request->has('wrong_day')?1:0;

     
       $validator = $request->validate($validate_array);

       if(!empty($request->session()->get('phrmacy')))
       {
           $insert_data['website_id']=$request->session()->get('phrmacy')->website_id; 
           $insert_data['created_by']='-'.$request->session()->get('phrmacy')->id;
       }
       
       $save_res=MissedPatient::create($insert_data);
       EventsLog::create([
         'website_id' => $request->session()->get('phrmacy')->website_id,
         'action_by' => $request->session()->get('phrmacy')->id,
         'action' => 1,
         'action_detail' => 'NearMiss',
         'comment' => 'Create NearMiss',
         'patient_id' => null,
         'ip_address' => $request->ip(),
         'type' => $request->session()->get('phrmacy')->roll_type,
         'user_agent' => $request->userAgent(),
         'authenticated_by' => 'packnpeaks',
         'status' => 1
       ]);
       return redirect()->back()->with(["msg"=>'<div class="alert alert-success"> <strong> Missed Patient </strong> Added Successfully.</div>']);
   }

   public  function near_missDelete(Request $request,$tenantName,$id)
   {
      $delete=MissedPatient::find($id);
      if(!$delete){
           return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Patient Notes id <strong>'.$id.'</strong> doesnot match in our records.</div>']);
      }
    
      $delete->delete();
      EventsLog::create([
         'website_id' => $request->session()->get('phrmacy')->website_id,
         'action_by' => $request->session()->get('phrmacy')->id,
         'action' => 3,
         'action_detail' => 'Near Miss',
         'comment' => 'Delete Near Miss',
         'patient_id' => null,
         'ip_address' => $request->ip(),
         'type' => $request->session()->get('phrmacy')->roll_type,
         'user_agent' => $request->userAgent(),
         'authenticated_by' => 'packnpeaks',
         'status' => 1
      ]);
      return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Near-missed (<strong>patient</strong>) deleted Successfully.</div>']);
   }

   /* edit Return  */
   public  function  near_missEdit(Request $request,$tenantName,$id)
   {       
      //return $request->all();
       $ob=MissedPatient::find($id);
       if(!$ob){
          return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Patient Notes id <strong>'.$id.'</strong> doesnot match in our records.</div>']);
       }

       if ($request->isMethod('post')) {
           //return $request->all();
         $validate_array=array(
            'person_involved'  => 'required|string|max:255',
            'initials'         => 'required|string|max:255'
         ); 
   
         $insert_data=array(
            'person_involved'=>$request->person_involved,
            'other'=>$request->other,
            'initials'=>$request->initials
         ); 
   
         $insert_data['missed_tablet']=$request->has('missed_tablet')?1:0;
         $insert_data['extra_tablet']=$request->has('extra_tablet')?1:0;
         $insert_data['wrong_tablet']=$request->has('wrong_tablet')?1:0;
         $insert_data['wrong_day']=$request->has('wrong_day')?1:0;
   
        
          $validator = $request->validate($validate_array);
           //return $insert_data;
           $ob->update($insert_data);
           EventsLog::create([
            'website_id' => $request->session()->get('phrmacy')->website_id,
            'action_by' => $request->session()->get('phrmacy')->id,
            'action' => 2,
            'action_detail' => 'NearMiss',
            'comment' => 'Update NearMiss',
            'patient_id' => null,
            'ip_address' => $request->ip(),
            'type' => $request->session()->get('phrmacy')->roll_type,
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
          ]);
           return redirect('all_near_miss')->with(["msg"=>'<div class="alert alert-success"><strong>Patient</strong> Near-missed Updated Successfully.</div>']);
       }

       $data=array();
       $data['missedPatients']=$ob;
      // return $ob;
       return  view($this->views.'.near_missEdit',$data); 

   }
}
