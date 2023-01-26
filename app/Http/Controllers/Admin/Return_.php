<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Tenant\Patient as Patient_Model;
use App\Models\Tenant\PatientReturn;
use App\Models\Admin\Facility;
use App\Models\Admin\Store;
use App\Models\Tenant\Store as TenantStore;
use App\Models\Tenant\EventsLog; 
use App\User; 
use DB; 
class Return_ extends Controller
{
    public  function  returns()
    {     
        $data['all_pharmacies']=User::all();
        $data['all_facilities']=Store::all();
        return view('admin.returns')->with($data); 
    }

    public  function  all_returns()
    {
        $all_pharmacy=User::all();
        $newarray=array();
        foreach($all_pharmacy  as $row){
              $this->get_connection($row->website_id);
              $get_audit=PatientReturn::get_all();
                foreach($get_audit as $col) {
                    $col->pharmacy=$row->company_name;
                    $newarray[]=$col;
                }
              DB::disconnect('tenant');
        }   
        $data['all_returns']=$newarray;  
        return  view('admin.all_returns')->with($data); 
    }

    /*save the return data */
    public  function save_return(Request $request)
    {   
    	$validate_array=array(
            'company_name'      => 'required|numeric|min:1',
            'patient_name'      => 'required|numeric|min:1',
            'select_days_weeks' => 'required|string|max:255',
            'store'             => 'required|numeric|min:1',
            'dob'               => 'date_format:Y-m-d|before:tomorrow',
            // 'initials'          => 'required|string|max:255',
            'no_of_returned_day_weeks'=>'min:0'
           ); 
            
           $insert_data=array(
               'patient_id'=>$request->patient_name,
               'dob'=>$request->dob,
               'day_weeks'=>$request->select_days_weeks,
               'returned_in_days_weeks'=>$request->no_of_returned_day_weeks,
               'store'=>$request->store,
               'staff_initials'=>$request->initials,
           ); 
           if($request->store=='5'){
            $validate_array['other_store']='required'; 
            $insert_data['other_store']=$request->other_store;
          }
          $insert_data['website_id']='1'; 
           
           if(!empty($request->session()->get('admin')))
           { 
             $insert_data['website_id']=$request->company_name;
             $insert_data['created_by']='-'.$request->session()->get('admin')['id'];
             $validate_array['company_name']='required'; 
           }   
           $validator = $request->validate($validate_array); 
           $this->get_connection($request->company_name);
            //print_r($insert_data);  die;
            $save_res=PatientReturn::insert_data($insert_data);
            EventsLog::create([
                'website_id' => $request->company_name,
                'action_by' => '-'.$request->session()->get('admin')->id,
                'action' => 1,
                'action_detail' => 'Return',
                'comment' => 'Create Return',
                'patient_id' => $request->patient_name,
                'ip_address' => $request->ip(),
                'type' => 'SuperAdmin',
                'user_agent' => $request->userAgent(),
                'authenticated_by' => 'packnpeaks',
                'status' => 1
                ]);
           DB::disconnect('tenant'); 
         return redirect()->back()->with(["msg"=>'<div class="alert alert-success">Patient <strong>Return </strong> Added Successfully.</div>']);
    }

    public  function  get_connection($website_id)
    {
        $get_user=User::get_by_column('website_id',$website_id);
        config(['database.connections.tenant.database' => $get_user[0]->host_name]);
         DB::purge('tenant');
         DB::reconnect('tenant');
         DB::disconnect('tenant'); 
    }


    /* edit Return  */
    public  function  edit_return(Request $request)
    {
        $data['all_pharmacies']=User::all();
        
        $this->get_connection($request->website_id);
        $data['all_facilities']=TenantStore::all();
        $data['patient_return']=PatientReturn::get_by_where(array('id'=>$request->row_id,'deleted_at'=>NULL)); 
        $data['all_patients']=Patient_Model::get_by_where(array('deleted_at'=>NULL,'website_id'=>$request->website_id));
        DB::disconnect('tenant');
        return view('admin.edit_return')->with($data); 
    }

    /* Update Return  */
    public  function  update_return(Request $request)
    {
        $validate_array=array(
            'patient_name'      => 'required|numeric|min:1',
            'select_days_weeks' => 'required|string|max:255',
            'store'             => 'required|numeric|min:1',
            'dob'               => 'date_format:Y-m-d|before:tomorrow',
            // 'initials'          => 'required|string|max:255',
            'no_of_returned_day_weeks'=>'min:0'
           ); 
           $update_data=array(
               'patient_id'=>$request->patient_name,
               'dob'=>$request->dob,
               'day_weeks'=>$request->select_days_weeks,
               'returned_in_days_weeks'=>$request->no_of_returned_day_weeks,
               'store'=>$request->store,
               'staff_initials'=>$request->initials,
               'other_store'=>$request->other_store
           ); 
           if($request->store=='5'){
            $validate_array['other_store']='required'; 
          }

          $validator = $request->validate($validate_array); 
        //   print_r($update_data);  die;
          $this->get_connection($request->website_id); 
          PatientReturn::update_where(array('id'=>$request->row_id,'website_id'=>$request->website_id),$update_data);
          EventsLog::create([
            'website_id' => $request->website_id,
            'action_by' => '-'.$request->session()->get('admin')->id,
            'action' => 2,
            'action_detail' => 'Return',
            'comment' => 'Update Return',
            'patient_id' => $request->patient_name,
            'ip_address' => $request->ip(),
            'type' => 'SuperAdmin',
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
             ]);
          DB::disconnect('tenant');
          return redirect('admin/all_returns')->with(["msg"=>'<div class="alert alert-success"> <strong>  Patients Return </strong> Updated 
          Successfully.</div>']);
    }

     /* Delete Return  */
     public function  delete_return(Request $request)
     {
        $this->get_connection($request->website_id);
        $getdata=PatientReturn::find($request->row_id);
        PatientReturn::update_where(array('id'=>$request->row_id,'website_id'=>$request->website_id),array('deleted_by'=>'-'.$request->session()->get('admin')['id']));
        PatientReturn::delete_record($request->row_id); 
        EventsLog::create([
            'website_id' => $request->website_id,
            'action_by' => '-'.$request->session()->get('admin')->id,
            'action' => 3,
            'action_detail' => 'Return',
            'comment' => 'Delete Return',
            'patient_id' => $getdata->patient_id,
            'ip_address' => $request->ip(),
            'type' => 'SuperAdmin',
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
             ]);
        DB::disconnect('tenant');
        echo '200'; 
     }

     public function multiple_delete_return(Request $request)
    {
        $ids = explode(",",$request->row_id);
        $website_Ids=explode(",",$request->website_id);
        for($i=0;$i < count($ids);$i++)
        {
               $this->get_connection($website_Ids[$i]);
               $getdata=PatientReturn::find($ids[$i]);
               PatientReturn::update_where(array('id'=>$ids[$i],'website_id'=>$website_Ids[$i]),array('deleted_by'=>'-'.$request->session()->get('admin')['id']));
               PatientReturn::delete_record($ids[$i]); 
               EventsLog::create([
                'website_id' => $website_Ids[$i],
                'action_by' => '-'.$request->session()->get('admin')->id,
                'action' => 3,
                'action_detail' => 'Return',
                'comment' => 'Delete Return',
                'patient_id' => $getdata->patient_id,
                'ip_address' => $request->ip(),
                'type' => 'SuperAdmin',
                'user_agent' => $request->userAgent(),
                'authenticated_by' => 'packnpeaks',
                'status' => 1
                 ]);
               DB::disconnect('tenant');

        }  
        return response()->json(['status'=>true,'message'=>"Patient Returns  deleted successfully."]);
    }

     /*GET  View  Details */
     public  function  return_info(Request $request)
     {
        $this->get_connection($request->website_id); 
        $data['returns']=PatientReturn::get_by_where(array('website_id'=>$request->website_id,'id'=>$request->row_id));
        $data['mode']='return_info';
        DB::disconnect('tenant');
        return view('admin.ajax')->with($data);
     }



}
