<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
// use Auth; 
use Illuminate\Http\Request;
use App\User;
use App\Models\Tenant\Audit; 
use App\Models\Tenant\Checking; 
use App\Models\Tenant\MissedPatient; 
use App\Models\Tenant\NotesForPatient; 
use App\Models\Tenant\Patient; 
use App\Models\Tenant\PatientReturn; 
use App\Models\Tenant\PickUp; 
use App\Models\Tenant\Company; 
use DB;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {   
    	$all_pharmacy=User::all();
        $newarray=array(); $allPatients=0;$allPharmacy=0;$allTechnicians=0;$allPickups=0;
        if(count($all_pharmacy)){
          $allPharmacy+=User::all()->count();
        foreach($all_pharmacy  as $row){
              
              $this->get_connection($row->website_id);
              $allPatients+=Patient::all()->count();
              $allTechnicians+=Company::select_all_technician()->count();
              $allPickups+=PickUp::all()->count();
              DB::disconnect('tenant');
        }
       }
        
        $data=array('allPatients'=>$allPatients,'allPharmacy'=>$allPharmacy,'allTechnicians'=>$allTechnicians,'allPickups'=>$allPickups); 
        return view('admin.index')->with($data);
    }

     public  function  get_connection($website_id)
    {
        $get_user=User::get_by_column('website_id',$website_id);
        config(['database.connections.tenant.database' => $get_user[0]->host_name]);
         DB::purge('tenant');
         DB::reconnect('tenant');
         DB::disconnect('tenant'); 
    }
}
