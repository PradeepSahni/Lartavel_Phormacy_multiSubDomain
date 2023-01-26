<?php
   
namespace App\Imports;
   
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Tenant\Patient as Patient_Model;
use Carbon\Carbon;
use Session;

class PatientsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    { 

        
        return new Patient_Model([
            'first_name'=>$row['first_name'],
            'last_name'=>$row['last_name'],
            'dob'=>$this->getAttribute($row['dob']),
            'address'=>$row['address'], 
            'phone_number'=>$row['phone_number'],
            'facilities_id'=>$row['facilities_id'],
            'location'=>$row['location'],
            'text_when_picked_up_deliver'=>0,
            'website_id'=>Session::get('phrmacy')->website_id,
            'created_by'=>Session::get('phrmacy')->id
        ]);
    }

    public  function getAttribute($value){
     $date=Carbon::parse($value);
     return $date->format('Y-m-d');
    }
}
