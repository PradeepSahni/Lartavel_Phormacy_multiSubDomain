<?php 
Route::domain('{account}.' . env('PROJECT_HOST', 'packnpeaks.tk'))->group(function () {
    //Login Routes
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::get('admin-login','Auth\LoginController@showLoginForm')->name('admin-login');
    Route::post('pharmacylogin','Auth\LoginController@pharmacylogin')->name('pharmacylogin');
    // Route::get('logout', 'Tenant\PharmacyController@logout');
/* Dashboard Route */
    // Route::middleware('auth:pharmacy')->group(function () {
    Route::group(['middleware'=>['checkpharmacy']],function () {
        Route::name('tenant.')->namespace('Tenant')->group(function() {

            // Route::get('patients/delete/{id}', function ($id,$id1) {
            //     return $id1;
            // });
              
            Route::get('testPage','CommonController@testPage')->name('testPage');

            Route::get('dashboard','HomeController@dashboard')->name('dashboard');
            Route::get('logout','PharmacyController@logout')->name('logout');
            Route::get('profile','HomeController@profile')->name('profile');
            Route::post('update_profile','HomeController@update_profile')->name('update_profile');
            Route::post('update_access','HomeController@update_access')->name('update_access');
            Route::post('update_password','HomeController@update_password')->name('update_password'); 

            Route::get('technician','Technician@technician')->name('technician')->middleware('CheckPharmacyAdmin');
            Route::post('add_technician','Technician@add_technician')->name('add_technician')->middleware('CheckPharmacyAdmin');;
            Route::get('all_technician','Technician@all_technician')->name('all_technician');
            Route::get('all_admin','Technician@all_admin')->name('all_admin');
            
            Route::get('technician/status/{id}','Technician@technicianStatus')->name('technician/status/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::get('technician/edit/{id}','Technician@technicianEdit')->name('technician/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::post('technician/edit/{id}','Technician@technicianEdit')->name('technician/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::get('technician/delete/{id}','Technician@technicianDelete')->name('technician/delete/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');


            Route::get('add_pharmacy','Pharmacist@add_pharmacy')->name('add_pharmacy');
            Route::get('all_pharmacies','Pharmacist@all_pharmacies')->name('all_pharmacies');
            Route::get('subscriptions','Subscriptions@subscriptions')->name('subscriptions');
            Route::get('{form}/add_form/{id}','Subscriptions@add_form')->name('{form}/add_form/{id}');
            Route::post('update_form','Subscriptions@update_form')->name('update_form');
            Route::get('edit_subscription/{row_id}','Subscriptions@edit_subscription')->name('edit_subscription/{row_id}')->middleware('CheckPharmacyAdmin');
            Route::post('update_subscription/{row_id}','Subscriptions@update_subscription')->name('update_subscription/{row_id}');
            
            Route::get('pickups','PickUp@pickups')->name('pickups');
            Route::get('pickups/delete/{id}','PickUp@pickupsDelete')->name('pickups/delete/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::get('pickups/edit/{id}','PickUp@pickupsEdit')->name('pickups/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::post('pickups/edit/{id}','PickUp@pickupsEdit')->name('pickups/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::get('pickups/show/{id}','PickUp@pickupsShow')->name('pickups/show/{id}')->where('id','[0-9]+');

            Route::post('add_pickups','PickUp@add_pickups')->name('add_pickups');
            Route::get('pickups_reports','PickUp@pickups_reports')->name('pickups_reports');
            Route::get('patients_picked_up_last_month','PickUp@patients_picked_up_last_month')->name('patients_picked_up_last_month');
            Route::get('pickups_calender','PickUp@pickups_calender')->name('pickups_calender');
            Route::post('getAllPickupForMonth','PickUp@getAllPickupForMonth');
            Route::get('six_month_compliance','PickUp@six_month_compliance')->name('six_month_compliance');
            Route::get('all_compliance','PickUp@all_compliance')->name('all_compliance');
            Route::get('patients','Patient@patients')->name('patients');
            Route::post('save_patient','Patient@save_patient')->name('save_patient');
            Route::get('patients/delete/{id}','Patient@patientsDelete')->name('patients/delete/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::get('patients/notification/{id}','Patient@notification')->name('patients/notification/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::get('patients/edit/{id}','Patient@patientsEdit')->name('patients/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::post('patients/edit/{id}','Patient@patientsEdit')->name('patients/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');

            Route::get('new_patients_report','Patient@new_patients_report')->name('new_patients_report');
            Route::post('checkduplicatePatient','Patient@checkduplicatePatient')->name('checkduplicatePatient'); 

            Route::get('notes_for_patients','Notes_For_Patient@notes_for_patients')->name('notes_for_patients');

            Route::post('save_notes_for_patients','Notes_For_Patient@save_notes_for_patients')->name('save_notes_for_patients');
            Route::get('notes_for_patients/edit/{id}','Notes_For_Patient@notes_for_patientsEdit')->name('notes_for_patients/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::post('notes_for_patients/edit/{id}','Notes_For_Patient@notes_for_patientsEdit')->name('notes_for_patients/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::get('notes_for_patients/delete/{id}','Notes_For_Patient@notes_for_patientsDelete')->name('notes_for_patients/delete/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');

            Route::get('notes_for_patients_report','Notes_For_Patient@notes_for_patients_report')->name('notes_for_patients_report');
            Route::get('sms_tracking_report','Notes_For_Patient@sms_tracking_report')->name('sms_tracking_report');

            Route::get('checkings','Checking@checkings')->name('checkings');
            Route::get('checkings/edit/{id}','Checking@checkingsEdit')->name('checkings/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::post('checkings/edit/{id}','Checking@checkingsEdit')->name('checkings/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::get('checkings/delete/{id}','Checking@checkingsDelete')->name('checkings/delete/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::post('save_checking','Checking@save_checking')->name('save_checking');
            Route::get('checkings_report','Checking@checkings_report')->name('checkings_report');

            Route::get('returns','Return_@returns')->name('returns');
            Route::post('save_return','Return_@save_return')->name('save_return');
            Route::get('all_returns','Return_@all_returns')->name('all_returns');
            Route::get('return/edit/{id}','Return_@returnEdit')->name('return/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::post('return/edit/{id}','Return_@returnEdit')->name('return/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::get('return/delete/{id}','Return_@returnDelete')->name('return/delete/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            /* new  */
            Route::get('audits','Audit@audits')->name('audits');
            Route::get('all_audits','Audit@all_audits')->name('all_audits');
            Route::post('save_audits','Audit@save_audits')->name('save_audits');
            Route::get('audits/edit/{id}','Audit@auditsEdit')->name('audits/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::post('audits/edit/{id}','Audit@auditsEdit')->name('audits/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::get('audits/delete/{id}','Audit@auditsDelete')->name('audits/delete/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');

            Route::get('near_miss','Near_Miss@near_miss')->name('near_miss');
            Route::get('all_near_miss','Near_Miss@all_near_miss')->name('all_near_miss');
            Route::get('nm_last_month','Near_Miss@nm_last_month')->name('nm_last_month');
            Route::get('nm_monthly','Near_Miss@nm_monthly')->name('nm_monthly');
            Route::post('save_near_miss','Near_Miss@save_near_miss')->name('save_near_miss');
            Route::get('near_miss/edit/{id}','Near_Miss@near_missEdit')->name('near_miss/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::post('near_miss/edit/{id}','Near_Miss@near_missEdit')->name('near_miss/edit/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');
            Route::get('near_miss/delete/{id}','Near_Miss@near_missDelete')->name('near_miss/delete/{id}')->where('id','[0-9]+')->middleware('CheckPharmacyAdmin');

            Route::post('deleteAll/{modelName}','CommonController@deleteAll')->name('deleteAll/{modelName}')->where('modelName','[a-zA-Z]+')->middleware('CheckPharmacyAdmin');
            Route::post('archiveAll/{modelName}','CommonController@archiveAll')->name('archiveAll/{modelName}')->where('modelName','[a-zA-Z]+');
            Route::post('unarchiveAll/{modelName}','CommonController@unarchiveAll')->name('unarchiveAll/{modelName}')->where('modelName','[a-zA-Z]+');






          Route::get('notification_details/{id}','HomeController@notification_details')->name('notification_details/{id}')->where('id','[0-9]+');

          Route::get('search','Search@index'); 
          Route::post('search_patient','Search@search_patient');
          Route::get('create_patient_details_pdf/{row_id}','Search@create_patient_details_pdf');

          Route::get('patients_notification','Patient@patients_notification'); 
          Route::post('import_patients','Patient@import_patients'); 
        });
    });


});
















