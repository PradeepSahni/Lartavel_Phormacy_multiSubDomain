<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use App\Models\Tenant\Company;
use App\Models\Tenant\AccessLevel;
use App\Models\Tenant\Audit;
use App\Models\Tenant\Authentication_log;
use App\Models\Tenant\Checking;
use App\Models\Tenant\Facility;
use App\Models\Tenant\Store;
use App\Models\Tenant\Location;
use App\Models\Tenant\MissedPatient;
use App\Models\Tenant\NotesForPatient;
use App\Models\Tenant\Notification;
use App\Models\Tenant\Patient;
use App\Models\Tenant\PatientReturn;
use App\Models\Tenant\PickUp;
use App\Models\Tenant\Form;

use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;

class PostController extends Controller
{
    public $successStatus = 200;
    public  function  get_connection($website_id)
    {
        $user = User::where('website_id', $website_id)->with('website')->get();
        // Switch the environment to use first hostname
        $environment = app(\Hyn\Tenancy\Environment::class);
        $environment->tenant($user[0]->website);
    }

    public  function saveAllRecords(Request $request){
        $website_id=isset($request->website_id)?$request->website_id:0;
        $getWebsite=User::where('website_id',$website_id)->get();
        if(count($getWebsite)){
            $this->get_connection($request->website_id); 
            foreach($request->data as $key=>$row){

                if($key=='patients'){
                    if(count($row)){
                         foreach($row as $patients){
                             if($patients['website_id']==$website_id){
                                $patients['id']=null;
                                Patient::insert($patients);
                             }
                         }
                    }
                }
               if($key=='audits'){
                   if(count($row)){
                        foreach($row as $audit){
                            if($audit['website_id']==$website_id){
                            $audit['id']=null;
                            Audit::insert($audit);
                            }
                        }
                   }
                }
                if($key=='checkings'){
                    if(count($row)){
                         foreach($row as $checkings){
                            if($checkings['website_id']==$website_id){
                             $checkings['id']=null;
                             Checking::insert($checkings);
                            }
                         }
                    }
                 }
                 if($key=='missed_patients'){
                    if(count($row)){
                         foreach($row as $missed_patients){
                            if($missed_patients['website_id']==$website_id){
                             $missed_patients['id']=null;
                             MissedPatient::insert($missed_patients);
                            }
                         }
                    }
                 }
                 if($key=='notes_for_patients'){
                    if(count($row)){
                         foreach($row as $notes_for_patients){
                            if($notes_for_patients['website_id']==$website_id){
                             $notes_for_patients['id']=null;
                             NotesForPatient::insert($notes_for_patients);
                            }
                         }
                    }
                 }
                 
                 if($key=='patient_returns'){
                    if(count($row)){
                         foreach($row as $patient_returns){
                            if($patient_returns['website_id']==$website_id){
                             $patient_returns['id']=null;
                             PatientReturn::insert($patient_returns);
                            }
                         }
                    }
                 }
                 if($key=='pick_ups'){
                    if(count($row)){
                         foreach($row as $pick_ups){
                            if($pick_ups['website_id']==$website_id){
                             $pick_ups['id']=null;
                             PickUp::insert($pick_ups);
                            }
                         }
                    }
                 }
                  
            }
                $pharmacy['companies']=Company::orderBy('created_at','DESC')->take(500)->skip(0)->get();
                $pharmacy['access_levels']=AccessLevel::orderBy('created_at','DESC')->take(500)->skip(0)->get();
                $pharmacy['audits']=Audit::with('stores')->with('patients')->orderBy('created_at','DESC')->take(500)->skip(0)->get();
                $pharmacy['authentication_logs']=Authentication_log::orderBy('created_at','DESC')->take(500)->skip(0)->get();
                $pharmacy['checkings']=Checking::with('patients')->orderBy('created_at','DESC')->take(500)->skip(0)->get();
                $pharmacy['stores']=Store::orderBy('created_at','DESC')->take(500)->skip(0)->get();
                $pharmacy['facilities']=Facility::orderBy('created_at','DESC')->take(500)->skip(0)->get();
                $pharmacy['locations']=Location::orderBy('created_at','DESC')->take(500)->skip(0)->get();
                $pharmacy['missed_patients']=MissedPatient::orderBy('created_at','DESC')->take(500)->skip(0)->get();
                $pharmacy['notes_for_patients']=NotesForPatient::with('patients')->orderBy('created_at','DESC')->take(500)->skip(0)->get();
                $pharmacy['notifications']=Notification::orderBy('created_at','DESC')->take(500)->skip(0)->get();
                $pharmacy['patients']=Patient::with('facility')->orderBy('created_at','DESC')->take(500)->skip(0)->get();
                $pharmacy['patient_returns']=PatientReturn::with('stores')->with('patients')->orderBy('created_at','DESC')->take(500)->skip(0)->get();
                $pharmacy['pick_ups']=PickUp::with('patients')->orderBy('created_at','DESC')->take(500)->skip(0)->get();
                $pharmacy['forms']=Form::orderBy('created_at','DESC')->take(500)->skip(0)->get();
            
                $success['data']=$pharmacy;
            

            DB::disconnect('tenant');
            return response()->json(['success' => $success], $this-> successStatus); 
        }
        else
        {
            return response()->json(['error'=>'Pharmacy not  found!'], 401); 
        }
    }
}
