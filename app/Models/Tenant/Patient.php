<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection; 
use Illuminate\Database\Eloquent\SoftDeletes;
use  DB; 
class Patient extends Model
{
    use UsesTenantConnection; 
    use SoftDeletes;
    

    protected $fillable = [
        'first_name','last_name',
        'dob','phone_number','location','facilities_id','facility_other_desc','text_when_picked_up_deliver','mobile_no','address','notification',
        'created_by','deleted_by','status','updated_at','deleted_at','website_id'
    ];

     /* save data   */
    public static function insert_data($insert_data){
      return Patient::create($insert_data);
    }

      public function facility(){
        return $this->belongsTo('App\Models\Tenant\Facility','facilities_id','id');
      }
      
  
      public function pickups(){
        return $this->hasMany('App\Models\Tenant\Pickups','patient_id','id');
      }
  
      public function latestPickups(){
        return $this->hasOne('App\Models\Tenant\Pickups','patient_id','id')->latest();
      }
      public function location_list(){
        return $this->belongsTo('App\Models\Tenant\Location','location','id');
      }
      


    

    /* get  By column  */
    public static  function  get_by_where($condition)
    {
        return  Patient::where($condition)->get(); 
    }

    /* update data  */
    public static  function update_where($condition,$update_data)
    {
      return Patient::where($condition)->update($update_data);
    }


     /* delete record  */
   public  static  function  delete_record($id)
   {
     return Patient::find($id)->delete();
   }
   
   



}
