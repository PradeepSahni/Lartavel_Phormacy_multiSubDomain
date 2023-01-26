<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\Tenant\Company;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use App\Models\Phermacist;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use DB; 
use  App\Models\Admin\Subscription;
use  App\Models\Tenant\AccessLevel;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

   



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'        => ['required', 'string', 'max:255'],
            'last_name'         => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'          => ['required', 'string','confirmed', 'min:6'],
            // 'confirm_password'  => ['required', 'string','min:6'],
            'term'              => ['required'],
            'company_name'      => ['required', 'string', 'max:255','unique:users'],
            'host_name'         => ['required', 'string', 'max:190','unique:users'],
            'phone'             => ['required', 'string', 'max:12'],
            'address'           => ['required', 'string', 'max:255'],
            'subscription'      => ['required', 'string', 'max:255'],
        ]);  
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {  
        $host_name = $data['host_name'];  
        
        $website = $this->tenantSetUp($host_name, $data); 

        $user_data=array(
                'name'          => $data['first_name'].' '.$data['last_name'],
                'initials_name' => strtoupper(substr($data['first_name'],0,1)).'.'.strtoupper(substr($data['last_name'],0,1)).'.',
                'first_name'    => $data['first_name'],
                'last_name'     => $data['last_name'],
                'email'         => $data['email'],
                'password'      => Hash::make($data['password']),
                'company_name'  => $data['company_name'],
                'phone'         => '04'.$data['phone'],
                'registration_no'=>'PHA00'.date('HisYdm'),
                'address'       => $data['address'],
                'host_name'     => $host_name,
                'website_id'    => $website->id,
                'subscription'  => $data['subscription']
        );
        User::create($user_data);   
        
        $user_data['roll_type']='admin';
        
        return Company::create($user_data);
        // access_levels
    }
	
    
    public function register(Request $request) {  
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all()))); 
        return redirect('pharmacist_login')->with('msg','<div class="alert alert-success""> Your Host-name create <strong> Success</strong>.  now you  can login!</div>');
        // return $this->registered($request, $user) ?: redirect()->back();
    }
	
	    private function tenantSetUp($host_name, $data) {
        // $fqdn = "www.{$host_name}." . env('PROJECT_HOST', 'packnpeaks.tk');
        $fqdn = "{$host_name}." . env('PROJECT_HOST', 'localhost');
        
        $hostname = new Hostname;
        $hostname->fqdn = $fqdn;

        $uuid = Str::limit(Str::slug($host_name, '_'), 15, '');
        $website = new Website;
        $website->uuid = $uuid;

        $website->hostnames()->save($hostname); 
        
        $host = app(HostnameRepository::class)->create($hostname);
        app(WebsiteRepository::class)->create($website);
        app(HostnameRepository::class)->attach($host, $website);
        


        /* Create default folders */
        $folders = [
            'document_templates',
            'phermacist_documents',
            'phermacist_profile',
        ];
        foreach ($folders as $folder) {
            $path="storage/tenancy/tenants/{$uuid}/{$folder}"; 
             
            if(!is_dir($path)){
                File::makeDirectory("storage/tenancy/tenants/{$uuid}/{$folder}", 0777, true);
            }
        }

        
        
        $permacist_result = Phermacist::create([
            'username'         => Str::slug($data['first_name'].$data['last_name']),
            'first_name'       => $data['first_name'],     
            'last_name'        => $data['last_name'],
            'email'            => $data['email'],
            'company_name'     => $data['company_name'],
            'host_name'        => $data['host_name'],
            'password'         => Hash::make($data['password']),
            'subscription'     => $data['subscription'],
        ]); 

        
        $subscrip=Subscription::getdatabycolumn_name('id',$data['subscription']); 
        // echo $subscrip[0]->title;  die; 
        if(count($subscrip))
        {
            $update_data=[
                'no_of_admins'=>$subscrip[0]->no_of_admins,
                'no_of_technicians'=>$subscrip[0]->no_of_technicians,
                'form1' => $subscrip[0]->form1,
                'form2' => $subscrip[0]->form2,
                'form3' => $subscrip[0]->form3,
                'form4' => $subscrip[0]->form4,
                'form5' => $subscrip[0]->form5,
                'form6' => $subscrip[0]->form6,
                'form7' => $subscrip[0]->form7,
                'form8' => $subscrip[0]->form8,
                'form9' => $subscrip[0]->form9,
                'form10'=> $subscrip[0]->form10,
                'form11'=> $subscrip[0]->form11,
                'form12'=> $subscrip[0]->form12,
                'form13'=> $subscrip[0]->form13,
                'form14'=> $subscrip[0]->form14,
                'form15'=> $subscrip[0]->form15,
                'form16'=> $subscrip[0]->form16,
                'form17'=> $subscrip[0]->form17,
                'form18'=> $subscrip[0]->form18,
                'form19'=> $subscrip[0]->form19,
                'form20'=> $subscrip[0]->form20,
                'form21'=> $subscrip[0]->form21,
        ]; 
        }
        AccessLevel::create($update_data);
        
        // $create_date = date('Y-m-d H:i:s', strtotime($company->created_at));
        // $interval = new \DateInterval("P30D");
        // $until = new \DateTime($create_date);
        // $end_date = $until->add($interval);
        // $company->expiry_date = $end_date->format('Y-m-d H:i:s');
        // $company->save();

        // $employee = Company::create([
        //     'username'          => employee_username($data['first_name'], $data['last_name']),
        //     'first_name'        => $data['first_name'],
        //     'last_name'         => $data['last_name'],
        //     'email'             => $data['email'],
        //     'password'          => Hash::make($data['password']),
        //     'status'            => 'active',
        //     'login_created'     => 1,
        // ]);
        
        // $company->owner_id = $employee->id;
        // $company->save();

        // $defaultRole = config('roles.models.role')::where('level', '=', 0)->first();
        // $employee->attachRole($defaultRole);

        // $role = config('roles.models.role')::where(['is_admin_role' => 1, 'slug' => 'administrator'])->first();
        // $employee->attachRole($role);

        return $website;
    }



	
}
