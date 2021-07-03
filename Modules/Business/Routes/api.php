<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('test', 'HomeController@home');

//Route::middleware('api')->get('/business', function (Request $request) {
////    return $request->user();
//    return "hey";
//});

//Route::get('test', function (Request $request) {
//    return "hey I'm";
//});

//Route::middleware('api')->get('/test', function (Request $request) {
////    return $request->user();
//    return "hey";
//});

//Route::middleware('api')->get('test', 'HomeController@home');

Route::group(['middleware' => 'api'], function()
{
    Route::post('sendgrid-webhook-allow-post', 'BusinessController@sendgridWebHookLogs');
    Route::post('test-webhook', 'BusinessController@testWebHookLogs');

    Route::get('test', 'BusinessController@webConnect');
//    Route::get('test', function (Request $request) {
//        return "hey I'm";
//    });

    Route::post('schedule-email-campaign', 'CampaignController@scheduleEmailCampaign');
    Route::post('add-post', 'SocialController@addPost');

    Route::group(['prefix' => 'cronjob'], function()
    {
        Route::get('get-new-reviews-notification', 'CronJobController@getNewReviewsNotification');
    });
});

