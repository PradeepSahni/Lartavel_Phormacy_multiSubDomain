<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use App\Models\Tenant\Authentication_log; 
use App\Models\Tenant\EventsLog;
use App\Models\Tenant\Company;
use Illuminate\Support\Facades\Hash;
use Auth;
use Notification;
use App\Notifications\SignupVerification;
use Session;
use App\Providers\RouteServiceProvider;

use Illuminate\Support\Carbon;
use Yadahan\AuthenticationLog\AuthenticationLog;
use Yadahan\AuthenticationLog\Notifications\NewDevice;
use App\Models\Tenant\Employee;
use Illuminate\Support\Str;
use DB;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:pharmacy')->except('logout');
    }
    protected function guard() {
      // return Auth::guard('pharmacy');
    }
  
    public function showLoginForm($account)
    {    
        $company = Company::first();
        $company_name = $company->company_name; 
        $company_logo = $company->logo ? asset('storage/'.$company->logo) : asset('media/logos/logo.png'); 
        // $password_settings = \App\Models\Tenant\PasswordConfiguration::first();
        // $auth_settings = \App\Models\Tenant\AuthenticationSetting::first();
        return view('tenant.auth.login', compact('account', 'company_name', 'company_logo'));
    }

    public function pharmacylogin(Request $request, $account) {

         
          $request->validate(array(
              'email' => ['required', 'string', 'email', 'max:190'],
              'password' => ['required', 'string'],
          ));  
          $company = Company::getdatabycolumn_name("email",$request->email);
          if (count($company) ) {
            if(Hash::check($request->password, $company[0]->password))
            { 
              if($company[0]->status=='1'){
                  $request->session()->put('phrmacy',$company[0]);
                  $this->createLoginLog($request,$company[0]);
                  EventsLog::create([
                    'website_id' => $company[0]->website_id,
                    'action_by' => $company[0]->id,
                    'action' => 4,
                    'action_detail' => 'login',
                    'comment' => 'login',
                    'ip_address' => $request->ip(),
                    'type' => $company[0]->roll_type,
                    'user_agent' => $request->userAgent(),
                    'authenticated_by' => 'packnpeaks',
                    'status' => 1
                  ]);
                  return redirect('dashboard')->with('account', $account);
                  // return redirect('admin-login')->with('account', $account);
              }
              else{
                 return redirect()->back()->with(["msg"=>'<div class="alert alert-danger""><strong>Wrong </strong> You are blocked . Please contact to  admin . !!!</div>']);
              }
              
            }
            else
            {
              return redirect()->back()->with(["msg"=>'<div class="alert alert-danger""><strong>Wrong </strong> Password does not match !!!</div>']);
            }
          } else {     
              return redirect()->back()->with("msg",'<div class="alert alert-danger""><strong>Wrong </strong> Email does not  match with this credential !!! </div>');
          }
      }

      private function createLoginLog($request, $user, $provider = 'packnpeaks') {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        // // $known = $user->authentications()->whereIpAddress($ip)->whereUserAgent($userAgent)->first();
        $insert_data=array(
          'ip_address' => $ip,
          'user_agent' => $userAgent,
          'login_at' => Carbon::now(),
          'authenticated_by' => $provider,
          'uid' =>$user->id,
          'type' =>$user->roll_type,
          'website_id' =>$user->website_id
        );

         return Authentication_log::insert($insert_data);

    }

	public function sign_in(Request $request){
	      $validatedData = $request->validate(array('email' => 'required','password' => 'required'));
        $user_details = User::get_user_details($request); 
       
		if($user_details != NULL){ 
      
		     if(Hash::check($request->password, $user_details->password)){ 
           
           if($user_details->email_verified_at != NULL){  
                    
                    session(['users_roll_type' =>$user_details->roll_id,'user_id'=>$user_details->id,'email'=>$user_details->email,'name'=>$user_details->name,'join_date'=>$user_details->join_date,'image'=>$user_details->image]); 
                    Auth::login($user_details);
                   if($user_details->roll_id > 0 ){
                    return redirect('/dashboard')->with(["login_success"=>'<div class="alert alert-success""><strong>Success </strong> Login Successfully  !!! </div>']);
                   }
				  } 
				 else{   
				   return redirect('admin-login')->with(["msg"=>'<div class="alert alert-danger""><strong>Note </strong> Your email is not verified at , verification code send in your registered mail ,please verify your mail   !!! </div>']);
				  }  
	
				}
		     else{ 
				  return redirect('admin-login')->with(["msg"=>'<div class="alert alert-danger""><strong>Wrong </strong> Password does not match !!!</div>']);  
				}		
		 }
		else{ 
		  return redirect('admin-login')->with(["msg"=>'<div class="alert alert-danger""><strong>Wrong </strong> Email does not  match with this credential !!! </div>']);
		} 
	}
	
}
