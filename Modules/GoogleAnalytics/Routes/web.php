<?php

Route::group(['middleware' => 'web', 'prefix' => 'google-analytics', 'namespace' => 'Modules\GoogleAnalytics\Http\Controllers'], function()
{
//    Route::get('/google-analytics/analytics-views', 'GoogleAnalyticsController@getData')->name('analytics-views');

    Route::get('google-analytics/get-login', 'GoogleAnalyticsController@getLogin');

    Route::get('google-analytics/callback', 'GoogleAnalyticsController@callback');

    Route::get('google-analytics/get-accounts', 'GoogleAnalyticsController@getAccounts');

    Route::get('google-analytics/get-web-property', 'GoogleAnalyticsController@getWebProperties');

    Route::get('google-analytics/get-profile-view', 'GoogleAnalyticsController@getProfileViews');

    Route::post('exchange-refresh-token', 'GoogleAnalyticsController@exchangeRefreshToken');

//    Route::get('{id}/remove-analytics', 'GoogleAnalyticsCoget-profile-view-cron-jobntroller@removeGoogleAnalytics');
//    Route::post('remove-access-token', 'SocialController@removeAccessToken');
    Route::get('get-profile-view-cron-job', 'GoogleAnalyticsController@getProfileViewsCronJob');
});
