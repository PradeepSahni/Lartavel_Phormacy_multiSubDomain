<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Checking;
use Illuminate\Support\Facades\Auth; 
use App\User;
use Validator,DB;
class CheckingController extends Controller
{
    public $successStatus = 200;
    public  function  get_connection($website_id)
    {
        $get_user=User::get_by_column('website_id',$website_id);
        config(['database.connections.tenant.database' => $get_user[0]->host_name]);
         DB::purge('tenant');
         DB::reconnect('tenant');
    }

    /**
     * Create Checking 
    */

    public function createChecking(Request $request){
        $getWebsite=User::where('website_id',$request->website_id)->get();
        if(count($getWebsite)){
            $this->get_connection($request->website_id); 
            $validator = Validator::make($request->all(), [
                'website_id'        => 'required|numeric|min:1',
                'patient_name'      => 'required|array|min:1',
                "patient_name.*"    => "required|string|distinct|min:1",
                'no_of_weeks'       => 'required|numeric|min:1',
                'pharmacist_signature'=> 'required|string|max:9000'
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            $insert_data=array(
                'no_of_weeks'=>$request->no_of_weeks,
                'location'=>isset($request->location)?implode(',',$request->location):'',
                'pharmacist_signature'=>$request->pharmacist_signature,
                'note_from_patient'=>$request->note
            );
            if($request->dd){ $insert_data['dd']=1; }else{ $insert_data['dd']=0; }
            $user = Auth::user();
            if(!empty($user))
            {
                $insert_data['website_id']=$user->website_id; 
                $insert_data['created_by']=$user->id;
            }
            if($user->website_id!=$request->website_id){
                return response()->json(['error'=>'website id is not match to login pharmacy`s website id '], 401); 
            }

            /* Pharmacy Signature   */
            $folderPath = public_path('upload/pharmacy/');
            $image_parts = explode(";base64,", $request->pharmacist_signature);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath . uniqid() . '.'.$image_type;
            file_put_contents($file, $image_base64);
            $allChecking=array();
            foreach ($request->patient_name as $key => $value) {
                $insert_data['patient_id']=$value;
                $save_res=Checking::create($insert_data);
                array_push($allChecking,$insert_data);
            }
            // echo json_encode($allChecking);
            DB::disconnect('tenant');
            return response()->json(['success' => $allChecking], $this-> successStatus);
        }
        else
        {
            return response()->json(['error'=>'Pharmacy not  found!'], 401); 
        }
    }
}
