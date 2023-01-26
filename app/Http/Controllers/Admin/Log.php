<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Authentication_log;
use App\Models\Tenant\EventsLog; 
use App\Models\Admin\EventsLog as AdminEventsLog; 
use Carbon\Carbon;
use DB;
use App\User;



class Log extends Near_Miss
{
    public function logs(Request $request){

      $all_pharmacy=User::all();
      $newarray=array();
         foreach($all_pharmacy as $key=>$row){
           $this->get_connection($row->website_id);
              $get_all=EventsLog::where('created_at','>=',Carbon::now()->subdays(90))->get();
              if(count($get_all)){
                   foreach($get_all as $col){
                      $col->pharmacy_name=$row->company_name;
                      $col->userdata=$col->users;
                      $col->Patientdata=$col->patients;
                      array_push($newarray,$col);
                   }
              }
           DB::disconnect('tenant');
         }

        array_multisort(array_column($newarray, 'created_at'), SORT_DESC, $newarray);
        $data['allLogs']=$newarray;
      return view('admin.logs')->with($data); 
    }
}
