<?php

Route::prefix('/admin')->group(function() {
    
    Route::middleware('auth:web')->group(function() {
       
        
    });
     
     Route::group(['middleware'=>['checkadmin']],function () {
            
            Route::get('add_pharmacy','Admin\Pharmacist@add_pharmacy');
            Route::post('save_pharmacy','Admin\Pharmacist@register');
            
            Route::get('logout','Admin\Auth\LoginController@logout');
            Route::get('dashboard','Admin\AdminController@dashboard');
            Route::get('all_pharmacies','Admin\Pharmacist@all_pharmacies');
            Route::get('pharmacy_deatils/{website_id}','Admin\Pharmacist@pharmacy_deatils');  
            Route::get('edit_pharmacy/{website_id}','Admin\Pharmacist@edit_pharmacy');  
            Route::post('update_pharmacy/{website_id}','Admin\Pharmacist@update_pharmacy');
            Route::post('get_parmacydata_by_website_id','Admin\Pharmacist@get_parmacydata_by_website_id');
            
            Route::post('update_validity','Admin\Pharmacist@update_validity');  
            Route::get('subscriptions','Admin\Subscriptions@subscriptions');
            Route::get('{form}/add_form/{id}','Admin\Subscriptions@add_form'); 
            Route::post('update_form','Admin\Subscriptions@update_form'); 
            Route::post('update_form_tenant_admin_technician','Admin\Subscriptions@update_form_tenant_admin_technician');
            Route::post('update_form_of_tenant','Admin\Subscriptions@update_form_of_tenant');
            Route::get('edit_subscription/{row_id}','Admin\Subscriptions@edit_subscription'); 
            Route::post('update_subscription/{row_id}','Admin\Subscriptions@update_subscription'); 
            Route::get('pickups','Admin\PickUp@pickups');
            Route::get('pickups_reports','Admin\PickUp@pickups_reports'); 
            Route::get('pickups_calender','Admin\PickUp@pickups_calender'); 
            Route::post('getAllPickupForMonth','Admin\PickUp@getAllPickupForMonth');
            Route::get('six_month_compliance','Admin\PickUp@six_month_compliance'); 
            Route::get('all_compliance','Admin\PickUp@all_compliance'); 
            Route::get('patients_picked_up_last_month','Admin\PickUp@patients_picked_up_last_month'); 
            Route::get('patients','Admin\Patient@patients');
            Route::get('new_patients_report','Admin\Patient@new_patients_report'); 
            Route::post('checkduplicatePatient','Admin\Patient@checkduplicatePatient');
            /* New */ 
            Route::get('checkings','Admin\Checking@checkings'); 
            Route::get('checkings_report','Admin\Checking@checkings_report'); 
            /* New  */ 
            Route::get('near_miss','Admin\Near_Miss@near_miss'); 
            Route::get('all_near_miss','Admin\Near_Miss@all_near_miss'); 
            Route::get('nm_last_month','Admin\Near_Miss@nm_last_month'); 
            Route::get('nm_monthly','Admin\Near_Miss@nm_monthly'); 
            /* new  */
            Route::get('returns','Admin\Return_@returns'); 
            Route::get('all_returns','Admin\Return_@all_returns');
            /* new  */ 
            Route::get('audits','Admin\Audit@audits');
            Route::get('all_audits','Admin\Audit@all_audits');

            /* technician */
             Route::get('technician','Admin\Pharmacist@technician');
             Route::post('save_technician','Admin\Pharmacist@save_technician');
             Route::get('all_technician','Admin\Pharmacist@all_technician');
             Route::post('delete_technician','Admin\Pharmacist@delete_technician');
             Route::get('edit_technician/{website_id}/{row_id}','Admin\Pharmacist@edit_technician'); 
             Route::post('update_technician/{website_id}/{row_id}','Admin\Pharmacist@update_technician');

            /* new  */ 

            Route::get('notes_for_patients','Admin\Notes_For_Patient@notes_for_patients'); 
            Route::get('notes_for_patients_report','Admin\Notes_For_Patient@notes_for_patients_report'); 
            Route::get('sms_tracking_report','Admin\Notes_For_Patient@sms_tracking_report'); 
            /* new  */
            Route::get('patients','Admin\Patient@patients');

            /* get All  patiets  of tenant database  */

            Route::post('save_patient','Admin\Patient@save_patient');
            Route::post('get_patients_by_website_id','Admin\Patient@get_patients_by_website_id'); 
            Route::post('get_patient_dob','Admin\Patient@get_patient_dob'); 
            Route::post('save_return','Admin\Return_@save_return'); 
            Route::post('save_near_miss','Admin\Near_Miss@save_near_miss'); 
            Route::post('save_note_for_patient','Admin\Notes_For_Patient@save_note_for_patient'); 
            Route::post('save_checking','Admin\Checking@save_checking'); 
            Route::post('save_pickup','Admin\PickUp@save_pickup'); 
            // Route::get('new_pickup','Admin\PickUp@new_pickup'); 

            Route::post('save_audit','Admin\Audit@save_audit'); 

            /* Edit  Route  */
            Route::get('edit_note_for_patient/{website_id}/{row_id}','Admin\Notes_For_Patient@edit_note_for_patient'); 
            Route::post('update_note_for_patient/{website_id}/{row_id}','Admin\Notes_For_Patient@update_note_for_patient');
            Route::post('delete_note_for_patient','Admin\Notes_For_Patient@delete_note_for_patient'); 
            Route::delete('multiple_delete_note_for_patient','Admin\Notes_For_Patient@multiple_delete_note_for_patient'); 
            Route::post('multiple_pdf_export_note_for_patient','Admin\Notes_For_Patient@multiple_pdf_export_note_for_patient'); 
            

            Route::get('edit_audit/{website_id}/{row_id}','Admin\Audit@edit_audit'); 
            Route::post('update_audit/{website_id}/{row_id}','Admin\Audit@update_audit'); 
            Route::post('delete_audit','Admin\Audit@delete_audit'); 
            Route::delete('multiple_delete_audit','Admin\Audit@multiple_delete_audit'); 

            Route::get('edit_return/{website_id}/{row_id}','Admin\Return_@edit_return'); 
            Route::post('update_return/{website_id}/{row_id}','Admin\Return_@update_return'); 
            Route::post('delete_return','Admin\Return_@delete_return');
            Route::delete('multiple_delete_return','Admin\Return_@multiple_delete_return');

            Route::get('edit_near_miss/{website_id}/{row_id}','Admin\Near_Miss@edit_near_miss');
            Route::post('update_near_miss/{website_id}/{row_id}','Admin\Near_Miss@update_near_miss');
            Route::post('delete_near_miss','Admin\Near_Miss@delete_near_miss');
            Route::delete('multiple_delete_near_miss','Admin\Near_Miss@multiple_delete_near_miss');

            Route::get('edit_checking/{website_id}/{row_id}','Admin\Checking@edit_checking');
            Route::post('update_checking/{website_id}/{row_id}','Admin\Checking@update_checking');
            Route::delete('multiple_delete_checking','Admin\Checking@multiple_delete_checking');

            Route::get('edit_checking/{website_id}/{row_id}','Admin\Checking@edit_checking');
            Route::post('update_checking/{website_id}/{row_id}','Admin\Checking@update_checking');
            Route::post('delete_checking','Admin\Checking@delete_checking');

            Route::get('edit_patient/{website_id}/{row_id}','Admin\Patient@edit_patient');
            Route::post('update_patient/{website_id}/{row_id}','Admin\Patient@update_patient');
            Route::post('delete_patient','Admin\Patient@delete_patient');
            
            Route::get('edit_pickup/{website_id}/{row_id}','Admin\PickUp@edit_pickup'); 
            Route::post('update_pickup/{website_id}/{row_id}','Admin\PickUp@update_pickup'); 
            Route::post('delete_pickup','Admin\PickUp@delete_pickup');

            Route::get('search','Admin\Search@index'); 
            Route::post('search_patient','Admin\Search@search_patient');
            Route::get('create_patient_details_pdf/{website_id}/{row_id}','Admin\Search@create_patient_details_pdf');
            Route::get('create_patient_details_excel/{website_id}/{row_id}','Admin\Search@create_patient_details_excel'); 

            /*Logs*/
            Route::get('logs','Admin\Log@logs');
            /* View Details*/
            Route::get('patient_info/{website_id}/{row_id}','Admin\Patient@patient_info'); 
            Route::get('pickup_info/{website_id}/{row_id}','Admin\PickUp@pickup_info'); 
            Route::get('return_info/{website_id}/{row_id}','Admin\Return_@return_info'); 
            Route::get('near_miss_info/{website_id}/{row_id}','Admin\Near_Miss@near_miss_info'); 
            Route::get('audit_info/{website_id}/{row_id}','Admin\Audit@audit_info'); 
            Route::get('checking_info/{website_id}/{row_id}','Admin\Checking@checking_info'); 
            Route::get('noteForPatients_info/{website_id}/{row_id}','Admin\Notes_For_Patient@noteForPatients_info'); 
        }); 

});