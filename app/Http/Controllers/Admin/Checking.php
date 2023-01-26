<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\User; 
use App\Models\Tenant\Checking as Checking_Model;
use App\Models\Tenant\Patient as Patient_Model;
use App\Models\Admin\Location;
use App\Models\Tenant\EventsLog; 
use DB;
use Illuminate\Http\Request;

class Checking extends Near_Miss
{
    public  function  checkings(Request $request)
    {
       $data['all_pharmacies']=User::all();
       $data['all_Location'] = Location::get();
       return  view('admin.checkings')->with($data); 
    }

    /* save Checking here  */
    public  function  save_checking(Request $request)
    {       
        $validate_array=array(
            'company_name'        => 'required|numeric|min:1',
            'patient_name'      => 'required|array|min:1',
            "patient_name.*"    => "required|string|distinct|min:1",
            'no_of_weeks'       => 'required|numeric|min:1',
            'pharmacist_signature'=> 'required|string|max:9000'
        ); 


        $insert_data=array(
            // 'patient_id'=>$request->patient_name,
            'no_of_weeks'=>$request->no_of_weeks,
            'location'=>$request->location?implode(',',$request->location):'',
            'pharmacist_signature'=>$request->pharmacist_signature,
            'note_from_patient'=>$request->note
        );
        
        if($request->dd){ $insert_data['dd']=1; }else{ $insert_data['dd']=0; }
        $insert_data['website_id']='1'; 
        if(!empty($request->session()->get('admin')))
        {
            $insert_data['website_id']=$request->company_name; 
            $insert_data['created_by']='-'.$request->session()->get('admin')['id'];
            $validate_array['company_name']='required'; 
        }
        $validator = $request->validate($validate_array);
        /* Pharmacy Signature   */
        $folderPath = public_path('upload/pharmacy/');
	    $image_parts = explode(";base64,", $request->pharmacist_signature);
	    $image_type_aux = explode("image/", $image_parts[0]);
	    $image_type = $image_type_aux[1];
	    $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.'.$image_type;
        file_put_contents($file, $image_base64);

        $this->get_connection($request->company_name); 
        
        foreach ($request->patient_name as $key => $value) {
           $insert_data['patient_id']=$value;
           $save_res=Checking_Model::insert_data($insert_data);
           EventsLog::create([
            'website_id' => $request->company_name,
            'action_by' => '-'.$request->session()->get('admin')->id,
            'action' => 1,
            'action_detail' => 'Checking',
            'comment' => 'Create Checking',
            'patient_id' => $value,
            'ip_address' => $request->ip(),
            'type' => 'SuperAdmin',
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
           ]);
        }
        
        
        DB::disconnect('tenant');
        return redirect()->back()->with(["msg"=>'<div class="alert alert-success"> <strong> Patient Checking </strong> Added Successfully.</div>']);
        
        
    }
    /* checking Reports  */
    public function checkings_report()
    {
        $all_pharmacy=User::all();
        $newarray=array();
        foreach($all_pharmacy  as $row){
              $this->get_connection($row->website_id);
              $get_audit=Checking_Model::get_all();
                foreach($get_audit as $col) {
                    $col->pharmacy=$row->company_name;
                    $newarray[]=$col;
                }
              DB::disconnect('tenant');
        } 
        $data['all_checkings']=$newarray;  
        return  view('admin.checking_report')->with($data);
    }
/* Edit Checking  */
    public  function  edit_checking(Request $request)
    {
        $data['all_pharmacies']=User::all();
        $data['all_Location'] = Location::get();
        $this->get_connection($request->website_id);
        $data['get_checking']=Checking_Model::get_by_where(array('id'=>$request->row_id,'deleted_at'=>NULL)); 
        $data['all_patients']=Patient_Model::get_by_where(array('deleted_at'=>NULL,'website_id'=>$request->website_id));
        DB::disconnect('tenant');
        return  view('admin.edit_checking')->with($data);
    }

    /* Update Checking  */
    public  function  update_checking(Request $request)
    {
        $validate_array=array(
            'patient_name'      => 'required|numeric|min:1',
            // "patient_name.*"    => "required|string|distinct|min:1",
            'no_of_weeks'       => 'required|numeric|min:1'
        ); 
        $update_data=array(
            'patient_id'=>$request->patient_name,
            'no_of_weeks'=>$request->no_of_weeks,
            'location'=>$request->location?implode(',',$request->location):'',
            // 'pharmacist_signature'=>$request->pharmacist_signature,
            'note_from_patient'=>$request->note
        );
        
        if($request->dd){ $update_data['dd']=1; }else{ $update_data['dd']=0; }
        if($request->pharmacist_signature){ 
            $update_data['pharmacist_signature']=$request->pharmacist_signature; 
              /* Pharmacy Signature   */
            $folderPath = public_path('upload/pharmacy/');
            $image_parts = explode(";base64,", $request->pharmacist_signature);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath . uniqid() . '.'.$image_type;
            file_put_contents($file, $image_base64);
        }

        $validator = $request->validate($validate_array);
        // print_r($update_data);die; 
        $this->get_connection($request->website_id); 
        Checking_Model::update_where(array('id'=>$request->row_id,'website_id'=>$request->website_id),$update_data);
        EventsLog::create([
            'website_id' => $request->website_id,
            'action_by' => '-'.$request->session()->get('admin')->id,
            'action' => 2,
            'action_detail' => 'Checking',
            'comment' => 'Update Checking',
            'patient_id' => $request->patient_name,
            'ip_address' => $request->ip(),
            'type' => 'SuperAdmin',
            'user_agent' => $request->userAgent(),
            'authenticated_by' => 'packnpeaks',
            'status' => 1
           ]);
        DB::disconnect('tenant');
        return redirect('admin/checkings_report')->with(["msg"=>'<div class="alert alert-success"> <strong>  Checking </strong> Updated 
        Successfully.</div>']);
    }

     /* Delete Return  */
     public function  delete_checking(Request $request)
     {
        $this->get_connection($request->website_id);
        $getdata=Checking_Model::find($request->row_id);
        Checking_Model::update_where(array('id'=>$request->row_id,'website_id'=>$request->website_id),array('deleted_by'=>'-'.$request->session()->get('admin')['id']));
        Checking_Model::delete_record($request->row_id); 
        EventsLog::create([
            'website_id' => $request->website_id,
            'action_by' => '-'.$request->session()->get('admin')->id,
            'action' => 3,
            'action_detail' => 'Checking',
            'comment' => 'Delete Checking',
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

     /* Multi  ple  delete  */
     public function multiple_delete_checking(Request $request)
    {
        $ids = explode(",",$request->row_id);
        $website_Ids=explode(",",$request->website_id);
        for($i=0;$i < count($ids);$i++)
        {
               $this->get_connection($website_Ids[$i]);
               $getdata=Checking_Model::find($ids[$i]);
               Checking_Model::update_where(array('id'=>$ids[$i],'website_id'=>$website_Ids[$i]),array('deleted_by'=>'-'.$request->session()->get('admin')['id']));
               Checking_Model::delete_record($ids[$i]); 
               EventsLog::create([
                'website_id' => $website_Ids[$i],
                'action_by' => '-'.$request->session()->get('admin')->id,
                'action' => 3,
                'action_detail' => 'Checking',
                'comment' => 'Delete Checking',
                'patient_id' => $getdata->patient_id,
                'ip_address' => $request->ip(),
                'type' => 'SuperAdmin',
                'user_agent' => $request->userAgent(),
                'authenticated_by' => 'packnpeaks',
                'status' => 1
               ]);
               DB::disconnect('tenant');

        }  
        return response()->json(['status'=>true,'message'=>"Patient Audits  deleted successfully."]);
    }

    /*GET  Patient  Details */
     public  function  checking_info(Request $request)
     {
        $this->get_connection($request->website_id); 
        $data['checking']=Checking_Model::get_by_where(array('website_id'=>$request->website_id,'id'=>$request->row_id));
        $data['mode']='checking_info';
        DB::disconnect('tenant');
        return view('admin.ajax')->with($data);
     }


}
