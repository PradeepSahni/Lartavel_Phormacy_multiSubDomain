<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Tenant\AccessLevel;
use App\Models\Tenant\Patient as Patient_Model;
use App\Models\Admin\Facility;
use App\Models\Tenant\Facility as  TenantFacilityModel;
use App\Models\Tenant\EventsLog; 
use App\Models\Admin\Location;
use App\User; 
use DB,Response; 
class Patient extends Near_Miss
{


    
    public  function  patients()   
    {
         $data['all_pharmacies']=User::all();
         $data['all_facilities']=Facility::all();
         $data['all_Location'] = Location::get();
         return  view('admin.patients')->with($data);
    }
    public  function  save_patient(Request $request)
    {      
         //  print_r($request->all()); die; 
          $validate_array=array(
                'company_name'        => 'required|numeric|min:1',
                'first_name'        => 'required|string|max:255',
                'last_name'         => 'required|string|max:255',
                'dob'               => 'required|date_format:Y-m-d|before:tomorrow',
                'phone_number'      => 'required|unique:tenant.patients|min:10|max:10',
                'facility'          => 'required|string|max:255',
                'mobile_no'         => 'min:10|max:10'
            ); 


           $insert_data=array(
               'first_name'=>$request->first_name,
               'last_name'=>$request->last_name,
               'dob'=>$request->dob,
               'address'=>$request->address,
               'phone_number'=>$request->phone_number,
               'facilities_id'=>$request->facility,
               'location'=>isset($request->location)?implode(',',$request->location):''
           );


           if(isset($request->up_delivered)  && $request->up_delivered=='on' ) {
             $insert_data['text_when_picked_up_deliver']=1;
           }
           else{
            $insert_data['text_when_picked_up_deliver']=isset($request->mobile_no)?'1':null;
           }
           
           if(isset($request->same_as_above) && $request->same_as_above=='on')
           { 
                $insert_data['mobile_no']=$request->mobile_no;
           }
           else{
                $insert_data['mobile_no']=$request->phone_number;
           }
              

           
        $insert_data['website_id']='1'; 
        if(!empty($request->session()->get('admin')))
        {
            $insert_data['website_id']=$request->company_name;
            $insert_data['created_by']='-'.$request->session()->get('admin')['id'];
            $get_user=User::get_by_column('website_id',$request->company_name);
            $validate_array['company_name']='required'; 
            config(['database.connections.tenant.database' => $get_user[0]->host_name]);
            DB::purge('tenant');
            DB::reconnect('tenant');
            
        }   
         
        if(isset($request->facility))
        {     
                $getPharmacFacility=TenantFacilityModel::where('name',$request->facility)->first();
                if(empty($getPharmacFacility)){  
                    $createNewFacility=TenantFacilityModel::create([
                        'name'=> $request->facility,
                        'created_by' => '-1',
                        'status' => '1'
                    ]); 
                    $facilityId=$createNewFacility->id;
                } 
                else{ 
                    $facilityId=$getPharmacFacility->id;
                }
                $insert_data['facilities_id']=$facilityId;  
                
        }
        // $validator = $request->validate($validate_array);
        $validator = \Validator::make($request->all(),$validate_array);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $save_res=Patient_Model::create($insert_data);
        EventsLog::create([
            'website_id' => $request->company_name,
            'action_by' => '-'.$request->session()->get('admin')->id,
            'action' => 1,
            'action_detail' => 'Patient',
            'comment' => 'Create Patient',
            'patient_id' => $save_res->id,
            'ip_address' => $request->ip(),
            'type' => 'SuperAdmin',
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
           ]);
           DB::disconnect('tenant'); 
        return response()->json(['success'=>1,'errors'=>""]); 

        // $save_res=Patient_Model::insert_data($insert_data);
        // return redirect()->back()->with(["msg"=>'<div class="alert alert-success">Patient <strong>'.$request->first_name.' '.$request->last_name.'</strong> Added Successfully.</div>']);
    
    }

    public  function  get_connection($website_id)
    {
        $get_user=User::get_by_column('website_id',$website_id);
        config(['database.connections.tenant.database' => $get_user[0]->host_name]);
         DB::purge('tenant');
         DB::reconnect('tenant');
         DB::disconnect('tenant'); 
    }

    public function  get_patients_by_website_id(Request $request)
    {
        $this->get_connection($request->website_id); 
        $data['all_patients']=Patient_Model::all();

        $data['mode']='all_patients';
        return view('admin.ajax')->with($data); 
    }
    
    /* get  DOB of Patients  */
    public  function  get_patient_dob(Request $request)
    {
        $this->get_connection($request->website_id);
        $patients=Patient_Model::where('id',$request->patient_id)->select('dob')->first();
        // return  $patients->dob;
        return Response::json(array('success' => true,'dob'=>$patients->dob), 200); 
    }

    public  function  new_patients_report()
    {
        $all_pharmacy=User::all();
        $newarray=array();
        foreach($all_pharmacy  as $row){
              $this->get_connection($row->website_id);
              $get_audit=Patient_Model::all();
                foreach($get_audit as $col) {
                    $col->pharmacy=$row->company_name;
                    $newarray[]=$col;
                }
              DB::disconnect('tenant');
        } 
        $data['new_patients']=$newarray; //print_r($newarray[0]->facility); die; 
        return  view('admin.new_patients_report')->with($data);
    }


    /* Edit Patient  */
    public  function  edit_patient(Request $request)
    {
        $data['all_pharmacies']=User::all();
        
        $data['all_Location'] = Location::get();
        $this->get_connection($request->website_id);
        $data['all_facilities']=TenantFacilityModel::all();
        $data['patient']=Patient_Model::get_by_where(array('id'=>$request->row_id,'deleted_at'=>NULL)); 
        DB::disconnect('tenant');
        return  view('admin.edit_patient')->with($data);
    }

    public function  update_patient(Request $request)
    {
        $this->get_connection($request->website_id);  //  validation for Unique  Field 
        $validate_array=array(
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'dob'               => 'required|date_format:Y-m-d|before:tomorrow',
            'phone_number'      => 'required|min:10|max:10',
            'facility'          => 'required|string|max:255',
            'mobile_no'         => 'min:10|max:10'
        ); 
        $update_data=array(
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'dob'=>$request->dob,
            'address'=>$request->address,
            'phone_number'=>$request->phone_number,
            
            'location'=>isset($request->location)?implode(',',$request->location):''
        );
        
        if(isset($request->up_delivered)  && $request->up_delivered=='on' ) {
            $update_data['text_when_picked_up_deliver']=1;
          }
          else{
           $update_data['text_when_picked_up_deliver']=isset($request->mobile_no)?'1':null;
          }
          
          if(isset($request->same_as_above) && $request->same_as_above=='on')
          { 
               $update_data['mobile_no']=$request->mobile_no;
          }
          else{
               $update_data['mobile_no']=$request->phone_number;
          }
        
        $validator = $request->validate($validate_array); 
        
        if(isset($request->facility))
        {     
                $getPharmacFacility=TenantFacilityModel::where('name',$request->facility)->first();
                if(empty($getPharmacFacility)){
                    $createNewFacility=TenantFacilityModel::create([
                        'name'=> $request->facility,
                        'created_by' => '-1',
                        'status' => '1'
                    ]); 
                    $facilityId=$createNewFacility->id;
                } 
                else{
                    $facilityId=$getPharmacFacility->id;
                }
                $update_data['facilities_id']=$facilityId;  
                
        }
        Patient_Model::update_where(array('id'=>$request->row_id,'website_id'=>$request->website_id),$update_data);
        EventsLog::create([
            'website_id' => $request->website_id,
            'action_by' => '-'.$request->session()->get('admin')->id,
            'action' => 2,
            'action_detail' => 'Patient',
            'comment' => 'Update Patient',
            'patient_id' => $request->row_id,
            'ip_address' => $request->ip(),
            'type' => 'SuperAdmin',
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
           ]);
        DB::disconnect('tenant');
        return redirect('admin/new_patients_report')->with(["msg"=>'<div class="alert alert-success"> <strong>  Patient Report </strong> Updated 
        Successfully.</div>']); 
    }

     /* Delete Return  */
     public function  delete_patient(Request $request)
     {
        $this->get_connection($request->website_id);
        Patient_Model::update_where(array('id'=>$request->row_id,'website_id'=>$request->website_id),array('deleted_by'=>'-'.$request->session()->get('admin')['id']));
        Patient_Model::delete_record($request->row_id); 
        EventsLog::create([
            'website_id' => $request->website_id,
            'action_by' => '-'.$request->session()->get('admin')->id,
            'action' => 3,
            'action_detail' => 'Patient',
            'comment' => 'Delete Patient',
            'patient_id' => $request->row_id,
            'ip_address' => $request->ip(),
            'type' => 'SuperAdmin',
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
           ]);
        DB::disconnect('tenant');
        echo '200'; 
     }

     /*GET  Patient  Details */
     public  function  patient_info(Request $request)
     {
        //print_r($request->all());
        $this->get_connection($request->website_id); 
        $data['patients']=Patient_Model::get_by_where(array('website_id'=>$request->website_id,'id'=>$request->row_id));
        $data['mode']='patients_info';
        DB::disconnect('tenant');
        //print_r($data['patients']);die; 
        return view('admin.ajax')->with($data);
     }


     /*  check Duplicate patient */
    public  function checkduplicatePatient(Request  $request){
        //   print_r($request->all()); die;  
          if($request->company_name && $request->first_name && $request->last_name && $request->dob  ){
               
            $this->get_connection($request->company_name); 
            $getPatient=Patient_Model::where('first_name',$request->first_name)
            ->where('last_name',$request->last_name)
            ->where('dob',$request->dob)
            ->get();
            DB::disconnect('tenant');

            

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
