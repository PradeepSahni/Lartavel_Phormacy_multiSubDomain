<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Company;
use App\Models\Tenant\AccessLevel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\Tenant\EventsLog; 

class Technician extends Controller
{
    public  function  technician(Request $request)
    {
        $data['pin']="";
        if(!empty($request->session()->get('phrmacy'))){
            $getPharmacyAdmin=Company::find($request->session()->get('phrmacy')->id);
            $data['pin']=$getPharmacyAdmin->pin;
        }
        return  view('tenant.add_technician')->with($data); 
    }

    public  function  add_technician(Request $request)
    {
        $validator = $request->validate(array(
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'email'             => 'required|string|email|min:6|max:20|unique:tenant.companies',
            'password'          => 'required|string|min:4',
            'confirm_password'  => 'required|string|same:password|min:4',
            'term'              => 'required',
            'phone'             => 'required|string|max:12|min:10',
            'username'          => 'required|string|min:6|max:20|unique:tenant.companies',
            'pin'               => 'required|numeric|min:4',
            'address'           => 'required|string|max:255',
            'role'              => 'required|string|max:255',
        )); 
        $insert_data=array(
            'name'          => $request->first_name.' '.$request->last_name,
            'initials_name' => strtoupper(substr($request->first_name,0,1)).'.'.strtoupper(substr($request->last_name,0,1)).'.',
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'phone'         => $request->phone,
            'username'      => $request->username,
            'pin'           => $request->pin,
            'registration_no'=>'PHA00'.date('HisYdm'),
            'address'       => $request->address,
            'roll_type'     => $request->role
        );
        if(!empty($request->session()->get('phrmacy')))
        {
            $insert_data['subscription']=$request->session()->get('phrmacy')->subscription; 
            $insert_data['website_id']=$request->session()->get('phrmacy')->website_id; 
            $insert_data['created_by']='-'.$request->session()->get('phrmacy')->id;
            
        }


        $getAccess=AccessLevel::find(1); 
        $getAllAdmin=Company::where('roll_type','admin')->get();
        $getAllTechnician=Company::where('roll_type','technician')->get();
        if($request->role=='admin' && $getAccess->no_of_admins <= count($getAllAdmin)){ 
            // return response()->json(['error'=>'your pharmacy can create only number of '.$getAccess->no_of_admins.' Admin '], 401);
            return redirect()->back()->withInput()->with('msg','<div class="alert alert-danger""> your pharmacy can create only '.$getAccess->no_of_admins.' Admin </div>');
        }
        if($request->role=='technician' && $getAccess->no_of_technicians <= count($getAllTechnician) ){ 
            // return response()->json(['error'=>'your pharmacy can create only number of '.$getAccess->no_of_technicians.' Technician '], 401);
            return redirect()->back()->withInput()->with('msg','<div class="alert alert-danger""> your pharmacy can create only '.$getAccess->no_of_technicians.' Technician </div>');
        }
        
        $result=Company::create($insert_data);
        EventsLog::create([
            'website_id' => $request->session()->get('phrmacy')->website_id,
            'action_by' => $request->session()->get('phrmacy')->id,
            'action' => 1,
            'action_detail' => ucfirst($request->role),
            'comment' => 'Create '.ucfirst($request->role),
            'patient_id' => null,
            'ip_address' => $request->ip(),
            'type' => $request->session()->get('phrmacy')->roll_type,
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
        ]);
        if($request->role=='admin'){ 
           return redirect('all_admin')->with('msg','<div class="alert alert-success""> '.ucfirst($request->role).' <strong> '.$request->first_name.' '.$request->last_name.'</strong>.  Added Successfully !</div>');
        }
        else{
        return redirect('all_technician')->with('msg','<div class="alert alert-success""> '.ucfirst($request->role).' <strong> '.$request->first_name.' '.$request->last_name.'</strong>.  Added Successfully !</div>');
        }

    }

    public  function  all_technician()
    {  
        $data['all_technicians']=Company::select_all_technician();    
        return  view('tenant.all_technician')->with($data); 
    }

    public  function  all_admin(){
        $data['all_admins']=Company::select_all_admin();    
        return  view('tenant.all_admins')->with($data);
    }

/*Delete techniaician */
     public  function technicianDelete(Request $request,$tenantName,$id)
    {
        $delete=Company::find($id);
        if(!$delete){
            return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Technician id <strong>'.$id.'</strong> doesnot match in our records.</div>']);
        }
        $delete->delete();
        EventsLog::create([
            'website_id' => $request->session()->get('phrmacy')->website_id,
            'action_by' => $request->session()->get('phrmacy')->id,
            'action' => 3,
            'action_detail' => 'Technician',
            'comment' => 'Delete Technician',
            'patient_id' => null,
            'ip_address' => $request->ip(),
            'type' => $request->session()->get('phrmacy')->roll_type,
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
        ]);
        return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Technician Deleted Successfully.</div>']);
    }

   /* edit technician  */
   public  function  technicianEdit(Request $request,$tenantName,$id)
   {       
      //return $request->all();
       $ob=Company::find($id);
       if(!$ob){
          return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Patient Notes id <strong>'.$id.'</strong> doesnot match in our records.</div>']);
       }

       if ($request->isMethod('post')) {
           //return $request->all();
           $validate_array=array(
            // 'first_name'        => 'required|string|max:255',
            // 'last_name'         => 'required|string|max:255',
            // 'term'              => 'required',
            // 'phone'             => 'required|string|max:10|min:10',
            // 'address'           => 'required|string|max:255',
            // 'role'         => 'required|string|max:255',

            'first_name'        => ['required', 'string', 'max:255'],
            'last_name'         => ['required', 'string', 'max:255'],
            'term'              => ['required'],
            'phone'             => ['required', 'string', 'max:12'],
            'address'           => ['required', 'string', 'max:255']

         ); 
         

           $update_data=array(
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'roll_type'=> $request->role,
           );
           if($request->password!=""){
            $validate_array['password']         = 'required|string|min:4';
            $validate_array['confirm_password'] = 'required|string|same:password|min:4';
            $update_data['password']=Hash::make($request->password);
           }
           if($request->pin!=""){
            $update_data['pin']=$request->pin;
           }
        
          $validator = $request->validate($validate_array);
          
          $ob->update($update_data);
          EventsLog::create([
            'website_id' => $request->session()->get('phrmacy')->website_id,
            'action_by' => $request->session()->get('phrmacy')->id,
            'action' => 2,
            'action_detail' => ucfirst($request->role),
            'comment' => 'Update '.ucfirst($request->role),
            'patient_id' => null,
            'ip_address' => $request->ip(),
            'type' => $request->session()->get('phrmacy')->roll_type,
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
          ]);
          if ($request->role=='admin') {
            return redirect('all_admin')->with(["msg"=>'<div class="alert alert-success"><strong>'.ucfirst($request->role).'</strong> Updated Successfully.</div>']);
          }
          else
          {
           return redirect('all_technician')->with(["msg"=>'<div class="alert alert-success"><strong>'.ucfirst($request->role).'</strong> Updated Successfully.</div>']);
          }

          
       }

       $data=array();
       $data['technician']=$ob;
      // return $ob;
       return  view('tenant.technicianEdit',$data); 

   }



   /* update Technician Status Active or In-Active*/
   public  function  technicianStatus(Request $request){
         $ob=Company::find($request->id);
         $update_data=array();
         if($ob->status){
            $update_data['status']='0';
         }
         else{
            $update_data['status']='1';
         }
         $ob->update($update_data);
          return redirect('all_technician')->with(["msg"=>'<div class="alert alert-success"><strong> Records </strong> Updated Successfully.</div>']);
   }
}

