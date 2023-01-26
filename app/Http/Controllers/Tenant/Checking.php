<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User; 
use App\Models\Tenant\Patient;
use App\Models\Tenant\Location;
use App\Models\Tenant\Facility;
use App\Models\Tenant\Checkings;
use App\Models\Tenant\EventsLog; 
use DB;


class Checking extends Controller
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

    public  function  checkings(Request $request)
    {
      
       $data=array();
       $data['locations']=Location::get();
       
       $data['patients']=Patient::get();
       //return $data['patients'][0]->latestPickups;
       return  view($this->views.'.checkings')->with($data); 
    }

    /* save Checking here  */
    public  function  save_checking(Request $request)
    {       
        $validate_array=array(
            'patient_id'      => 'required|array|min:1',
            "patient_id.*"    => "required|string|distinct|min:1",
            'no_of_weeks'       => 'required|numeric|min:1',
            'pharmacist_signature'=> 'required|string|max:9000'
        ); 
        $insert_data=array(
            // 'patient_id'=>$request->patient_id,
            'no_of_weeks'=>$request->no_of_weeks,
            'location'=>isset($request->location)?implode(',',$request->location):'',
            'pharmacist_signature'=>$request->pharmacist_signature,
            'note_from_patient'=>$request->note
        );
        
        if($request->dd){ $insert_data['dd']=1; }else{ $insert_data['dd']=0; }
        if(!empty($request->session()->get('phrmacy')))
        {
            $insert_data['website_id']=$request->session()->get('phrmacy')->website_id; 
            $insert_data['created_by']='-'.$request->session()->get('phrmacy')->id;
        }
        $validator = $request->validate($validate_array);
        foreach($request->patient_id as $row){
            $insert_data['patient_id']=$row;
            EventsLog::create([
                'website_id' => $request->session()->get('phrmacy')->website_id,
                'action_by' => $request->session()->get('phrmacy')->id,
                'action' => 1,
                'action_detail' => 'Checking',
                'comment' => 'Create Checking',
                'patient_id' => $row,
                'ip_address' => $request->ip(),
                'type' => $request->session()->get('phrmacy')->roll_type,
                'user_agent' => $request->userAgent(),
                'authenticated_by' => 'packnpeaks',
                'status' => 1
              ]);
            Checkings::create($insert_data);
        }
       
        // Checkings::create($insert_data);
        return redirect()->back()->with(["msg"=>'<div class="alert alert-success"> <strong> Patient Checking </strong> Added Successfully.</div>']);
    }
    /* checking Reports  */
    public function checkings_report()
    {
      
        $data=array();  
        $data['checkings']=Checkings::get();
        //return $data['checkings'];
        return  view($this->views.'.checking_report')->with($data);
    }


    public  function checkingsDelete(Request $request,$tenantName,$id)
    {
        $delete=Checkings::find($id);
        if(!$delete){
            return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Patient id <strong>'.$id.'</strong> doesnot match in our records.</div>']);
        }

        $patient_name=$delete->patients->first_name.' '.$delete->patients->last_name;
        $delete->delete();
        EventsLog::create([
            'website_id' => $request->session()->get('phrmacy')->website_id,
            'action_by' => $request->session()->get('phrmacy')->id,
            'action' => 3,
            'action_detail' => 'Checking',
            'comment' => 'Delete Checking',
            'patient_id' => $delete->patient_id,
            'ip_address' => $request->ip(),
            'type' => $request->session()->get('phrmacy')->roll_type,
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
        ]);
        return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Checkings of this patient (<strong>'.$patient_name.'</strong>) deleted Successfully.</div>']);
    }

    public  function  checkingsEdit(Request $request,$tenantName,$id)
    {       
       //return $request->all();
        $ob=Checkings::find($id);
        if(!$ob){
           return redirect()->back()->with(["msg"=>'<div class="alert alert-danger">Checkings id <strong>'.$id.'</strong> doesnot match in our records.</div>']);
        }

        if ($request->isMethod('post')) {

            $validate_array=array(
                'patient_id'      => 'required|numeric|min:1',
                'no_of_weeks'     => 'required|numeric|min:1',
            ); 
            $insert_data=array(
                'patient_id'=>$request->patient_id,
                'no_of_weeks'=>$request->no_of_weeks,
                'location'=>$request->location?implode(',',$request->location):'',
                'pharmacist_signature'=>$request->pharmacist_signature,
                'note_from_patient'=>$request->note
            );
            if($request->dd){ $insert_data['dd']=1; }else{ $insert_data['dd']=0; }
            $validator = $request->validate($validate_array);
            $ob->update($insert_data);
            EventsLog::create([
                'website_id' => $request->session()->get('phrmacy')->website_id,
                'action_by' => $request->session()->get('phrmacy')->id,
                'action' => 2,
                'action_detail' => 'Checking',
                'comment' => 'Update Checking',
                'patient_id' => $request->patient_id,
                'ip_address' => $request->ip(),
                'type' => $request->session()->get('phrmacy')->roll_type,
                'user_agent' => $request->userAgent(),
                'authenticated_by' => 'packnpeaks',
                'status' => 1
              ]);
            return redirect('checkings_report')->with(["msg"=>'<div class="alert alert-success"> <strong> Patient Checking </strong> Updated Successfully.</div>']);
        }

        $data=array();
        $data['patients']=Patient::get();
        $data['locations']=Location::get();
        $data['checkings']=$ob;
        return  view($this->views.'.checkingsEdit',$data); 
       
    }
}
