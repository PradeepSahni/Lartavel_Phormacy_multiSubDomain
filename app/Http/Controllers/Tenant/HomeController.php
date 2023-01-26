<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Patient; 
use App\Models\Tenant\PatientReturn; 
use App\Models\Tenant\PickUp; 
use App\Models\Tenant\Company; 
use App\Models\Tenant\Checking; 
use App\Models\Tenant\AccessLevel; 
use App\Models\Tenant\Notification;
use App\Models\Tenant\EventsLog; 
use Illuminate\Support\Facades\Hash;
use Validator;
class HomeController extends Controller
{
    public  function dashboard(){

          $allChecking=Checking::all()->count();
          $allPatients=Patient::all()->count();
          $allTechnicians=Company::select_all_technician()->count();
          $allPharmacists=Company::where('roll_type','admin')->where('id','>',1)->get()->count();
          $allPickups=PickUp::all()->count();
          $allReturns=PatientReturn::all()->count();
        
        $data=array('allPatients'=>$allPatients,'allChecking'=>$allChecking,'allTechnicians'=>$allTechnicians,'allPickups'=>$allPickups,'allReturns'=>$allReturns,'allPharmacists'=>$allPharmacists);
        return view('tenant.index')->with($data);
    }



    public  function  notification_details(Request $request)
    {
    	$data['notification']=Notification::find($request->id);
    	return view('tenant.notification_details')->with($data);
    }

    public  function  profile(Request $request){
      if(isset($request->session()->get('phrmacy')->id)){
        $data['accessLevel']=AccessLevel::find(1);
        $data['user_data']=Company::find($request->session()->get('phrmacy')->id);
         return view('tenant.profile')->with($data);
      }
      else{
           return redirect('/')->with('msg','<div class="alert alert-danger"> You are logged out <strong>!</strong></div>');
      }
    }

    /*Update Profile*/
    public  function  update_profile(Request $request)
    {
        if(isset($request->session()->get('phrmacy')->id)){
              $pharmacyId=$request->session()->get('phrmacy')->id;
              $update=array('first_name' =>$request->first_name,'last_name'=>$request->last_name,'username'=>$request->username,'pin'=>$request->pin ,'phone'=>$request->phone);
              $update['name']=$request->first_name.' '.$request->last_name;
              $update['initials_name']=strtoupper(substr($request->first_name,0,1)).'.'.strtoupper(substr($request->last_name,0,1)).'.';
              $updateInformation=Company::where('id',$pharmacyId)->Update($update);
              EventsLog::create([
                'website_id' => $request->session()->get('phrmacy')->website_id,
                'action_by' => $request->session()->get('phrmacy')->id,
                'action' => 2,
                'action_detail' => 'Profile',
                'comment' => ' Change Profile',
                'patient_id' => null,
                'ip_address' => $request->ip(),
                'type' => $request->session()->get('phrmacy')->roll_type,
                'user_agent' => $request->userAgent(),
                'authenticated_by' => 'packnpeaks',
                'status' => 1
              ]);
              return redirect('profile')->with('msg','<div class="alert alert-success"> Data Updated <strong>.</strong></div>');
        }
       else{
           return redirect('/')->with('msg','<div class="alert alert-danger"> You are logged out <strong>!</strong></div>');
        }
    }

    /*Update Access*/
    public function update_access(Request $request){
        if(isset($request->session()->get('phrmacy')->id)){
             if($request->session()->get('phrmacy')->roll_type=='admin') {
                      $update=array('app_logout_time'=>$request->app_logout_time,'default_cycle'=>$request->default_cycle); 
                      $updateAppLogout=AccessLevel::where('id',1)->update($update);
                      EventsLog::create([
                        'website_id' => $request->session()->get('phrmacy')->website_id,
                        'action_by' => $request->session()->get('phrmacy')->id,
                        'action' => 2,
                        'action_detail' => 'Cycle And App Session Out Time',
                        'comment' => ' Cycle And App Session Out Time',
                        'patient_id' => null,
                        'ip_address' => $request->ip(),
                        'type' => $request->session()->get('phrmacy')->roll_type,
                        'user_agent' => $request->userAgent(),
                        'authenticated_by' => 'packnpeaks',
                        'status' => 1
                      ]);
                      if($updateAppLogout){
                         echo '200'; 
                      }
                      else{
                         echo '401'; 
                      }

             }
             else{
                  echo 'You can not able update it.';
             }
        }
         else{
            echo 'First you can login again';
        }

    }
    
    /* Chnage Passowrd */
    public  function  update_password(Request $request){
          if(isset($request->session()->get('phrmacy')->id)){
               $validateArr=array(
                'old_password' => 'required|string|min:6',
                'new_password' => 'required|string|min:6'
               );
               $validator = $request->validate($validateArr); 
               $pharmacyId=$request->session()->get('phrmacy')->id;
               $company = Company::where("id",$pharmacyId)->get();
              if(Hash::check($request->old_password, $company[0]->password))
              { 
                  $update=Company::where("id",$pharmacyId)->update(array('password'=>Hash::make($request->new_password)));
                  EventsLog::create([
                    'website_id' => $request->session()->get('phrmacy')->website_id,
                    'action_by' => $request->session()->get('phrmacy')->id,
                    'action' => 2,
                    'action_detail' => 'Password',
                    'comment' => ' Change Password',
                    'patient_id' => null,
                    'ip_address' => $request->ip(),
                    'type' => $request->session()->get('phrmacy')->roll_type,
                    'user_agent' => $request->userAgent(),
                    'authenticated_by' => 'packnpeaks',
                    'status' => 1
                  ]);
                   return redirect()->back()->with(["msgp"=>'<div class="alert alert-success""><strong>Password </strong> Updated Successfully !!</div>']);
              }
              else
              {
                return redirect()->back()->with(["msgp"=>'<div class="alert alert-danger""><strong>Wrong </strong> Old Password does not match !!!</div>']);
              }
          }
            else{
           return redirect('/')->with('msgp','<div class="alert alert-danger"> You are logged out <strong>!</strong></div>');
        }
    }

}
