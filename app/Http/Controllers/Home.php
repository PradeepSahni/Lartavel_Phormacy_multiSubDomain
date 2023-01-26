<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking_request; 
use Validator,Redirect,Response;
use DB;
use App\Models\Tenant\Company; 
use App\Models\Tenant\AccessLevel; 
use App\Models\Tenant\Notification; 

use App\Models\Tenant\Audit; 
use App\Models\Tenant\Checking; 
use App\Models\Tenant\MissedPatient; 
use App\Models\Tenant\NotesForPatient; 
use App\Models\Tenant\Patient; 
use App\Models\Tenant\PatientReturn; 
use App\Models\Tenant\PickUp; 


use App\User; 
use Carbon\Carbon;
class Home extends Controller
{


       protected $before_day=3;
       protected $on_day=3;


      public  function  index(Request $request)
      {
         //return  view('front.index'); 
          return  view('welcome'); 
      }


      public  function  get_connection($website_id)
      {
          $get_user=User::get_by_column('website_id',$website_id);
          config(['database.connections.tenant.database' => $get_user[0]->host_name]);
           DB::purge('tenant');
           DB::reconnect('tenant');
           DB::disconnect('tenant'); 
      }

      public  function  before_expiry_send_notification()
      {
          $all_pharmacy=User::all(); 
          foreach($all_pharmacy as $value){
             if($value->expired_date!=NULL)
             {  
                     // get  Diff  between Two  date //  Carbon::now()->format('Y-m-d')
                  $current_date=Carbon::now()->format('Y-m-d');
                  $start_date = \Carbon\Carbon::createFromFormat('Y-m-d',$current_date);
                  $end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $value->expired_date);
                  $different_days = $start_date->diffInDays($end_date);
                  if($different_days > $this->before_day )
                  {

                       $insert_data=array(
                          'type'=>'before_plan_expiry',
                          'notification_msg'=>'after 3 days your subscription plan will be expire',
                          'website_id'=>$value->website_id
                       );
                        $this->get_connection($value->website_id); 
                        $save_res=Notification::insert_data($insert_data);
                        DB::disconnect('tenant');
                      echo  'created notification || ';
                  }
                  else
                  {
                        echo 'not create ||'; 
                  }

             }
             else
             {   
              echo 'Expiry  no Define ||'; 
             }
          }
      }

      /*on Expiry  date notification */

      public  function  on_expiry_send_notification()
      {
              //Carbon::now()->subDays(1); // yesterday 
              //Carbon::now()->addDays(1) //  Twomarrow
         
         $all_pharmacy=User::all(); 
          foreach($all_pharmacy as $value){
             if($value->expired_date!=NULL)
             {  
                     // get  Diff  between Two  date //  Carbon::now()->format('Y-m-d')
                  $current_date=Carbon::now()->format('Y-m-d');
                  $start_date = \Carbon\Carbon::createFromFormat('Y-m-d',$current_date);
                  $end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $value->expired_date);
                  $different_days = $start_date->diffInDays($end_date);
                  //echo $end_date->addDays(2)->format('d-m-Y');  die; 

                  //echo $different_days;  die; 
                  if($different_days == '0')
                  {
                       $insert_data=array(
                          'type'=>'on_plan_expiry',
                          'notification_msg'=>'your plan has been expire today. your free trail expire on '.$end_date->addDays(2)->format('d-m-Y'),
                          'website_id'=>$value->website_id
                       );
                        $this->get_connection($value->website_id); 
                        $save_res=Notification::insert_data($insert_data);
                        DB::disconnect('tenant');

                      echo  'created notification || ';
                  }
                  else
                  {
                        echo 'not create ||'; 
                  }

             }
             else
             {   
              echo 'Expiry  no Define ||'; 
             }
          }

      }


      /*on trail Expiry  notification */

      public  function  on_trail_expiry_notification()
      {
          $all_pharmacy=User::all(); 
          foreach($all_pharmacy as $value){
             if($value->expired_date!=NULL)
             { 
                     // get  Diff  between Two  date //  Carbon::now()->format('Y-m-d')
                  $current_date=Carbon::now()->format('Y-m-d');
                  $start_date = \Carbon\Carbon::createFromFormat('Y-m-d',$current_date);
                  $end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $value->expired_date);
                  $different_days = $start_date->diffInDays($end_date);
                  //echo $end_date->addDays(2)->format('d-m-Y');  die; 
                  if($end_date->addDays(2)->format('d-m-Y') == $start_date->format('d-m-Y'))
                  {    
                       $insert_data=array(
                          'type'=>'on_trail_expiry',
                          'notification_msg'=>'your free trail plan has been expire today.',
                          'website_id'=>$value->website_id
                        );
                        $this->get_connection($value->website_id); 
                        $save_res=Notification::insert_data($insert_data);
                        DB::disconnect('tenant');

                      echo  'created notification || ';
                  }
                  else
                  {
                        echo 'not create ||'; 
                  }

             }
             else
             {   
              echo 'Expiry  no Define ||'; 
             }
          }
      }
      /*End of Expiry of Trail Time */

  /*Create archive */
  public  function  create_archive()
  {
     $all_pharmacy=User::all(); 
      foreach($all_pharmacy as $value){
        
        $current_date=Carbon::now()->subDays(29)->format('Y-m-d');
        $this->get_connection($value->website_id); 
        Audit::where('created_at','<',$current_date)->update(array('is_archive' =>1));
        Checking::where('created_at','<',$current_date)->update(array('is_archive' =>1));
        MissedPatient::where('created_at','<',$current_date)->update(array('is_archive' =>1));
        NotesForPatient::where('created_at','<',$current_date)->update(array('is_archive' =>1));
        Patient::where('created_at','<',$current_date)->update(array('is_archive' =>1));
        PatientReturn::where('created_at','<',$current_date)->update(array('is_archive' =>1));
        PickUp::where('created_at','<',$current_date)->update(array('is_archive' =>1));
        DB::disconnect('tenant');  

      }

      echo  'Archive Created';
  }
  
}


// UPDATE patients SET is_archive = CASE WHEN created_at < '2020-09-01' THEN '1' ELSE 0 END