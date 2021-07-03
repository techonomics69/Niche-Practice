<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['userAllow']], function () {
    Route::get('old-get-more-reviews', 'CRMController@customersList')->name('crm-customers');
//    Route::get('get-more-reviews', 'CRMController@customersList')->name('crm-customers');
    Route::get('patient-contacts', 'CRMController@customersList')->name('patients-list');
    Route::get('get-more-reviews', 'CRMController@addPatient')->name('add-patient');

    Route::get('patients-list-test', 'CRMController@customersListTest')->name('patients-list-test');

    Route::get('crm-delete-customer', 'CRMController@deleteCustomer')->name('crm-delete-customer');

    Route::post('crm-add-customer', 'CRMController@addCustomer')->name('crm-add-customer');

    Route::post('crm-upload-customer-csv', 'CRMController@uploadCustomersCSV')->name('crm-upload-customer-csv');

    Route::post('crm-upload-customer-file', 'CRMController@uploadCustomersFile')->name('crm-upload-customer-file');

    Route::post('crm-background-service', 'CRMController@CRMBackgroundService')->name('crm-background-service');

    Route::get('crm-customers-settings', 'CRMController@crmCustomersSettings')->name('crm-customers-settings');
    Route::post('saveCustomersSettings', 'CRMController@addCustomerSettings')->name('crm-customers-settings');

    Route::get('crm-customers-list', 'CRMController@getCRMCustomersList')->name('crm-customers-list');

    Route::get('requests-sent', 'CRMController@showRecipientList')->name('reviews-recipients');

    Route::get('assets', 'CRMController@showAssetList')->name('user-assets');

});
