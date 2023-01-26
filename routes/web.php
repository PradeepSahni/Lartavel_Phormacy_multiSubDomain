<?php
use Illuminate\Support\Facades\Route;
// use Spatie\Honeypot\ProtectAgainstSpam;


// Sub-Domain Tenant Routes
require_once 'tenant.php';

// Sub-Admin Routes
require_once 'super-admin.php';


/*  Cron Job  Time Shedule  */
Route::get('create_expiry_notification','Home@before_expiry_send_notification'); 
Route::get('on_expiry_send_notification','Home@on_expiry_send_notification'); 
Route::get('on_trail_expiry_notification','Home@on_trail_expiry_notification');
Route::get('create_archive','Home@create_archive');
/*End Cron Job Route */
Route::post('/host-forward', 'Controller@pharmacy_login');
Route::get('pharmacist_login', 'Admin\Pharmacist@pharmacist_login');
Route::get('pharmacist_signup', 'Admin\Pharmacist@pharmacist');
// Route::get('admin/add_pharmacy','Admin\Pharmacist@add_pharmacy');
// Route::post('admin/save_pharmacy','Admin\Pharmacist@register');
Route::post('add_phermacist','Admin\Pharmacist@add_phermacist');
/* ADMIN  AUTH */
 Route::get('/', 'Admin\Auth\LoginController@showLoginForm'); 
 Route::get('admin-login','Admin\Auth\LoginController@showLoginForm');
 Route::get('/superadmin','Tenant\Pharmacist@def_pharmacy');
 Route::post('save_pharmacy','Tenant\Pharmacist@register');
// Route::get('admin-login', function () {
//     $redirect= 'http://'.env('TENANCY_DEFAULT_HOSTNAME').'.'.env('PROJECT_HOST').'/Pack-Peak/public/';
//     return redirect($redirect);
// }); 

Route::post("sign_in" , "Admin\Auth\LoginController@sign_in");

// Route::group(['middleware'=>['checkadmin']],function () {
//           Route::get('admin/dashboard','Admin\AdminController@dashboard');
//           Route::get('admin/all_pharmacies','Admin\Pharmacist@all_pharmacies'); 
// }); 


Auth::routes();
/* START  Swagger route   */
// Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) { 
        return redirect()->route('admin.home')->with('status', session('status'));
    }
    return redirect()->route('admin.home');
});
Auth::routes(['register' => false]);

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
});

/* END OF Swagger route  */


