<?php

Route::group(['middleware' => 'web', 'prefix' => 'google-analytics', 'namespace' => 'Modules\GoogleAnalytics\Http\Controllers'], function()
{
    Route::get('get-login', 'GoogleAnalyticsController@getLogin');

    Route::get('callback', 'GoogleAnalyticsController@callback');

    Route::get('get-accounts', 'GoogleAnalyticsController@getAccounts');

    Route::get('get-web-property', 'GoogleAnalyticsController@getWebProperties');

    Route::get('get-profile-view', 'GoogleAnalyticsController@getProfileViews');

    Route::post('exchange-refresh-token', 'GoogleAnalyticsController@exchangeRefreshToken');

    Route::get('{id}/remove-analytics', 'GoogleAnalyticsCoget-profile-view-cron-jobntroller@removeGoogleAnalytics');

    Route::get('get-profile-view-cron-job', 'GoogleAnalyticsController@getProfileViewsCronJob');
});
