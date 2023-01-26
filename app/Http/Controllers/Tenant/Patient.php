<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Tenant\AccessLevel;
use App\Models\Tenant\Patient as Patient_Model;
use App\User; 
use App\Models\Tenant\Location;
use App\Models\Tenant\Facility;
use App\Models\Tenant\Pickups;
use App\Models\Tenant\EventsLog; 
use DB; 
use App\Imports\PatientsImport;
use Maatwebsite\Excel\Facades\Excel;

class Patient extends Controller
{
    protected $views='';

    public function __construct(){

        $this->views='tenant';

        $host=explode('.',request()->getHttpHost());

        config(['database.connections.tenant.database' => $host[0]]);
        DB::purge('tenant');
        DB::reconnect('tenant');
        DB::disconnect('tenant'); 
    }
    public  function  patientsDelete(Request $request,$tenantName,$id)
    {
        $patient=Patient_Model::find($id);
        if(!$patient){
            return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Patient id <strong>'.$id.'</strong> doesnot match in our records.</div>']);
        }

        $patient_name=$patient->first_name.' '.$patient->last_name;
        $patient->delete();
        EventsLog::create([
            'website_id' => $request->session()->get('phrmacy')->website_id,
            'action_by' => $request->session()->get('phrmacy')->id,
            'action' => 3,
            'action_detail' => 'Patient',
            'comment' => 'Delete Patient',
            'patient_id' => $patient->id,
            'ip_address' => $request->ip(),
            'type' => $request->session()->get('phrmacy')->roll_type,
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
         ]);
        return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Patient <strong>'.$patient_name.'</strong> deleted Successfully.</div>']);
    }

    public  function  patients()
    {
        $host=explode('.',request()->getHttpHost());
        
       
        $data=array();
        $data['locations']=Location::get();
        $data['facilities']=Facility::get();
        //return $data;
        return  view($this->views.'.patients',$data); 
    }

    public  function  patientsEdit(Request $request,$tenantName,$id)
    {
        $patient=Patient_Model::find($id);
        if(!$patient){
            return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Patient id <strong>'.$id.'</strong> doesnot match in our records.</div>']);
        }

        if ($request->isMethod('post')) {
          
            $validateArr=array(
                'first_name'        => 'required|string|max:255',
                'last_name'         => 'required|string|max:255',
                'dob'               => 'required|date_format:Y-m-d|before:tomorrow',
                'phone_number'      => 'required|min:10|max:10',
                'facilities_id'     => 'required|string|max:255',
                'mobile_no'         => 'min:10|max:10'
            );
            
            $insert_data=array(
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'dob'=>$request->dob,
                'address'=>$request->address,
                'phone_number'=>$request->phone_number,
                'facilities_id'=>$request->facilities_id,
                'location'=>isset($request->location) ?implode(',',$request->location):'',
                'text_when_picked_up_deliver'=>0,
            );   
           
            if($request->has('up_delivered')){
                $insert_data['text_when_picked_up_deliver']=1;
                if($request->has('up_delivered')){   
                    $insert_data['text_when_picked_up_deliver']=1;
                    $mobileNo=isset($request->mobile_no)?$request->mobile_no:'';
                    $phone_number=isset($request->phone_number)?$request->phone_number:'';
                    $insert_data['mobile_no']=$mobileNo?$mobileNo:$phone_number;
                }
                
            }

            if(!empty($request->get('facilities_id'))){
                $facility=Facility::where('name',$request->get('facilities_id'))->first();
                if(empty($facility)){
                    $createNewFacility=Facility::create([
                        'name'=> $request->get('facilities_id'),
                        'created_by' => $request->session()->get('phrmacy')->id,
                        'status' => '1'
                    ]); 
                    $facilityId=$createNewFacility->id;
                } 
                else{
                    $facilityId=$facility->id;
                }

                $insert_data['facilities_id']=$facilityId;
    
            }

            
           
            $validator = $request->validate($validateArr); 
            $patient->update($insert_data);
            EventsLog::create([
                'website_id' => $request->session()->get('phrmacy')->website_id,
                'action_by' => $request->session()->get('phrmacy')->id,
                'action' => 2,
                'action_detail' => 'Patient',
                'comment' => 'Update Patient',
                'patient_id' => $id,
                'ip_address' => $request->ip(),
                'type' => $request->session()->get('phrmacy')->roll_type,
                'user_agent' => $request->userAgent(),
                'authenticated_by' => 'packnpeaks',
                'status' => 1
              ]);
            return redirect("new_patients_report")->with(["msg"=>'<div class="alert alert-success">Patient <strong>  Updated </strong>  Successfully.</div>']);

        }

        $data=array();
        $data['locations']=Location::get();
        $data['facilities']=Facility::get();
        $data['patient']=$patient;
        //return $data;
        return  view($this->views.'.patientsEdit',$data); 
    }

    public  function  save_patient(Request $request)
    {
        // return $request->all();die; 
       // dd($request->has('mobile_no'));
        if(session()->has('phrmacy') && session()->get('phrmacy')->id>0)
        {   
            $validateArr=array(
                'first_name'        => 'required|string|max:255',
                'last_name'         => 'required|string|max:255',
                'dob'               => 'required|date_format:Y-m-d|before:tomorrow',
                'phone_number'      => 'required|unique:tenant.patients|min:10|max:10',
                'facilities_id'     => 'required|string|max:255',
                'mobile_no'         => 'min:10|max:10'
            );
            
           
            $insert_data=array(
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'dob'=>$request->dob,
                'address'=>$request->address,
                'phone_number'=>$request->phone_number,
                'location'=>$request->location?implode(',',$request->location):'',
                'text_when_picked_up_deliver'=>0,
            );   
            
            if($request->has('up_delivered')){   
                $insert_data['text_when_picked_up_deliver']=1;
                $mobileNo=isset($request->mobile_no)?$request->mobile_no:'';
                $phone_number=isset($request->phone_number)?$request->phone_number:'';
                $insert_data['mobile_no']=$mobileNo?$mobileNo:$phone_number;
            }
            
            if(!empty($request->get('facilities_id'))){
                $facility=Facility::where('name',$request->get('facilities_id'))->first();
                if(empty($facility)){
                    $createNewFacility=Facility::create([
                        'name'=> $request->get('facilities_id'),
                        'created_by' => $request->session()->get('phrmacy')->id,
                        'status' => '1'
                    ]); 
                    $facilityId=$createNewFacility->id;
                } 
                else{
                    $facilityId=$facility->id;
                }

                $insert_data['facilities_id']=$facilityId;
    
            }
           
            if(!empty($request->session()->get('phrmacy')))
            {
                $insert_data['website_id']=$request->session()->get('phrmacy')->website_id; 
                $insert_data['created_by']=$request->session()->get('phrmacy')->id;
                
            }

            // $validator = $request->validate($validateArr); 
            $validator = \Validator::make($request->all(),$validateArr);
            if ($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()->all()]);
            }
            $save_res=Patient_Model::create($insert_data);
            EventsLog::create([
                'website_id' => $request->session()->get('phrmacy')->website_id,
                'action_by' => $request->session()->get('phrmacy')->id,
                'action' => 1,
                'action_detail' => 'Patient',
                'comment' => 'Create Patient',
                'patient_id' => $save_res->id,
                'ip_address' => $request->ip(),
                'type' => $request->session()->get('phrmacy')->roll_type,
                'user_agent' => $request->userAgent(),
                'authenticated_by' => 'packnpeaks',
                'status' => 1
            ]);
            return response()->json(['success'=>1,'errors'=>""]); 
            // return redirect()->back()->with(["msg"=>'<div class="alert alert-success">Patient <strong>'.$request->first_name.' '.$request->last_name.'</strong> Added Successfully.</div>']);
        } 
        else{  
            return response()->json(['success'=>0,'errors'=>array('login'=>'Login Error !')]); 
            //return redirect($this->views.'-login')->with(["msg"=>'<div class="alert alert-danger><strong>Wrong </strong> First you can do login !!!</div>']);
        }
    }

    public  function  new_patients_report()
    {
        $data['patient_reports']=Patient_Model::get();
        return  view($this->views.'.new_patients_report',$data);
    }

    public  function  patients_notification(){
        $data['patient_reports']=Patient_Model::get();
        return  view($this->views.'.patients_notification',$data);
    }
    public  function  notification(Request $request,$tenantName,$id){
      $patient=Patient_Model::find($id);
        if(!$patient){
            return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Patient id <strong>'.$id.'</strong> doesnot match in our records.</div>']);
        }

        $patient_name=$patient->first_name.' '.$patient->last_name;
        if($patient->notification=='1'){
           $update=array('notification'=>null);
        }
        else{
            $update=array('notification'=>1); 
        }
        $patient->update($update);
        EventsLog::create([
            'website_id' => $request->session()->get('phrmacy')->website_id,
            'action_by' => $request->session()->get('phrmacy')->id,
            'action' => ($patient->notification=='1')?6:7,
            'action_detail' => 'Patient Notification',
            'comment' => ' Patient Notification',
            'patient_id' => $patient->id,
            'ip_address' => $request->ip(),
            'type' => $request->session()->get('phrmacy')->roll_type,
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
        ]);
        return redirect()->back()->with(["msg"=>'<div class="alert alert-success">Patient <strong>'.$patient_name.'</strong> Notification update .</div>']);
    }



    public function  import_patients(Request $request){

       $validateArr=array(
                'patient_file'=>'required'
            );
        $validator = $request->validate($validateArr);
        Excel::import(new PatientsImport,request()->file('patient_file'));
         return redirect()->back()->with(["msg"=>'<div class="alert alert-success"> <strong>Patient </strong> Added Successfully.</div>']);

    }

    /*  check Duplicate patient */
    public  function checkduplicatePatient(Request  $request){
        //   print_r($request->all()); die; 
          if($request->first_name && $request->last_name && $request->dob  ){
            $getPatient=Patient_Model::where('first_name',$request->first_name)
            ->where('last_name',$request->last_name)
            ->where('dob',$request->dob)
            ->get();
            if(count($getPatient)){
                   echo '1';  //  records  exit 
            }
            else{
               echo '0';  //  records not  exit   
            }
          }
          else{
              echo '401'; 
          }
    }

}
