<?php

use Modules\Admin\Models\Alert;


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

//Route::group(['prefix' => 'admin', 'middleware' => 'guestAllow'], function () {
Route::group(['prefix' => 'admin'], function () {
    Route::get('help-list-delete', function () {
        # code...
        Alert::whereIn('module', ['branded_content', 'blog_articles', 'press_releases', 'advanced_seo', 'pay_per_click', 'upgrade', 'refer', 'contact_us'])->delete();
        return 'soft deleted';
    });
    Route::get('login', 'AdminController@showLoginView')->name('admin-login');
    Route::post('login', 'AdminController@login')->name('post-login');

    Route::get('logout', 'AdminController@logOut')->name('admin.logout');
});

Route::group(['middleware' => 'adminAllow', 'prefix' => 'admin'], function () {


//    Route::get('dashboard/register', 'AdminController@create')->name('register');
//    Route::post('dashboard/register', 'AdminController@store')->name('user.register');


    // Route::get('variable-list', 'BusinessController@VariableList');

    Route::get('dashboard', 'DashboardController@dashboard')->name('adminDashboard');


    // Route::get('/issues', 'IssueController@index')->name('issue.list');

    // Route::get('/leads', 'LeadsController@index')->name('admin.leads');

    // Route::get('link-building-list', 'LinkBuildingController@index')->name('admin.link-building');

    // Route::get('/get-link-building-by-business-id', 'admin\LinkBuildingController@getLinkBuildingByBusinessId')->name('admin.get-link-building-by-business-id');
    // Route::post('/add-link-building-csv', 'admin\LinkBuildingController@addLinkBuildingCSV')->name('admin.add-link-building-csv');

    Route::group(['prefix' => 'task'], function () {
        Route::get('add-category', 'AdminTaskController@categoryPanel')->name('admin.add-category');
        Route::get('add-campaign', 'AdminTaskController@CategoryPanel')->name('admin.add-campaign');
        Route::get('category/{id}/edit', 'AdminTaskController@editTaskCategory')->name('task.edit.category');
        Route::get('campaign/{id}/edit', 'AdminTaskController@editTaskCategory')->name('task.edit.campaign');
        Route::get('category/list', 'AdminTaskController@taskCategoryPanel')->name('admin.category.list');
        Route::get('campaign/list', 'AdminTaskController@taskCategoryPanel')->name('admin.campaign.list');
        Route::get('list', 'AdminTaskController@index')->name('task.list');

        Route::get('{id}/edit', 'AdminTaskController@editTask')->name('task.edit');
        Route::put('update-task/{id}', 'AdminTaskController@updateTask')->name('task.update');

        Route::get('create-task', 'AdminTaskController@create')->name('task.create');
        Route::post('create-task', 'AdminTaskController@store')->name('task.store');
    });

    Route::group(['prefix' => 'pro'], function () {
        Route::get('list', 'AdminMarketingController@index')->name('pro.list');

        Route::get('create', 'AdminMarketingController@create')->name('pro.create');
        Route::post('create-service', 'AdminMarketingController@store')->name('pro.store');

        Route::get('{id}/edit', 'AdminMarketingController@edit')->name('pro.edit');
        Route::put('update-task/{id}', 'AdminMarketingController@updateService')->name('pro.update');
    });

    Route::group(['prefix' => 'alert-controller'], function () {
        Route::get('help-list', 'AdminAlertController@helpList')->name('alert.help.list');

        Route::get('list', 'AdminAlertController@index')->name('alert.list');

        Route::get('{id}/edit', 'AdminAlertController@editTask')->name('alert.edit');
        Route::put('update-task/{id}', 'AdminAlertController@updateTask')->name('alert.update');

        Route::get('create-alert', 'AdminAlertController@create')->name('alert.create');
        Route::post('create-task', 'AdminAlertController@store')->name('alert.store');
    });

    Route::get('add-industry', 'CampaignController@industryPanel')->name('admin.industry.list');
    Route::get('niches', 'CampaignController@industryNichesList')->name('admin.niches.list');
    Route::get('add-niche', 'CampaignController@addNiche')->name('admin.add-niches.list');

    Route::group(['prefix' => 'templates'], function () {
        Route::get('list', 'CampaignController@list')->name('admin.templates.list');
        Route::get('email-template/{templateId?}', 'CampaignController@emailCampaign')->name('admin.email-builder');

        Route::get('category-panel', 'CampaignController@categoryPanel')->name('admin.templates.category');
        Route::get('type-panel', 'CampaignController@typePanel')->name('admin.templates.types');

        Route::get('new-patient-templates', 'CampaignController@adminPatientEmailTemplates')->name('admin.new-patient-emails');
        Route::get('patient-email-template/{templateId?}', 'CampaignController@patientEmailBuilder')->name('admin.patient-email-builder');
//        Route::get('email-templates', 'PageController@emailTemplates')->name('email-templates');
    });

    Route::group(['prefix' => 'promotions'], function () {
        Route::get('list', 'AdminPromotionController@list')->name('admin.promotions.list');
        Route::get('promotion-template/{templateId?}', 'AdminPromotionController@promotionCampaign')->name('admin.promotion-builder');
//        Route::get('system-admin-promotions', 'AdminPromotionController@systemAdminPromotions')->name('system.admin.promotions');
        Route::get('guest-promotion-list', 'AdminPromotionController@list')->name('system.admin.promotions');
    });

    Route::get('marketing-association', 'AdminTaskController@marketingAssociation')->name('admin.campaign.association');
    Route::get('marketing-association/{id}/edit', 'AdminTaskController@editMarketingAssociation')->name('admin.campaign.association.edit');
    Route::get('reports', 'AdminTaskController@reports')->name('admin.reports');
    Route::get('add-report', 'AdminTaskController@addReports')->name('admin.addReports');
    Route::get('reports/{id}/edit', 'AdminTaskController@editReport')->name('report.edit');

    Route::get('reports/add-report-user', 'AdminTaskController@reportUser')->name('report.user');
    Route::get('reports/{id}/edit-report-user', 'AdminTaskController@editReportUser')->name('edit.report.user');
    Route::get('client-info', 'AdminTaskController@clientInfo')->name('admin.clientInfo');
    Route::get('notes-info', 'AdminTaskController@NotesInfo')->name('admin.NotesInfo');
    Route::get('add-client', 'AdminTaskController@addClient')->name('admin.addClient');
    Route::get('add-invoice', 'AdminTaskController@addInvoice')->name('admin.addInvoice');
//    Route::get('add-report', 'AdminTaskController@addReports')->name('admin.addReports');
//    Route::resource('/task', 'admin\TaskController', ['except' => ['index', 'store']]);

    // Route::group(['prefix' => 'objective'], function () {
    //     Route::get('/list', 'admin\ObjectiveController@index')->name('admin.objectives.list');
    //     Route::get('/add', 'admin\ObjectiveController@create')->name('admin.objectives.create');

    //     Route::get('/{objective}/edit', 'admin\ObjectiveController@edit')->name('admin.objectives.edit');
    //     Route::put('/{id}/update', 'admin\ObjectiveController@update')->name('admin.objective.update');

    //     Route::post('add-objective', 'admin\ObjectiveController@store')->name('objectives.store');
    // });

    // Route::post('/delete-list', 'admin\ObjectiveController@deleteList');

    /********************** system administrators users listing *******************/
//     Route::get('list', 'admin\UserListController@index')->name('admin.users.list');
//     Route::get('create', 'admin\UserListController@create')->name('admin.users.create');
//     Route::get('edit/{id}', 'admin\UserListController@editAdminUser')->name('admin.user.edit');
//
//     Route::post('store-admin-user', 'admin\UserListController@storeAdminUser');
//     Route::post('update-admin-user', 'admin\UserListController@updateAdminUser')->name('update.admin.user');
//
//     Route::get('/email-checker/{email}', 'Auth\LoginController@emailChecker')->name('email.check');
});

//Route::get('demo-with-custom-btn', 'CampaignController@emailCampaignDemo');
//Route::get('demo-with-topol-btn', 'CampaignController@emailCampaignDemo2');
