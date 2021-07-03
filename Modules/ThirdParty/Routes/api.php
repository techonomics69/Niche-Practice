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

Route::group(['middleware' => 'api', 'prefix' => 'google-place'], function () {
    Route::get('get-place-id', 'GooglePlaceController@getFirstPlaceID');

// testing reviews demo route
    Route::get('get-reviews', 'GooglePlaceController@getBusinessReviews');
});

Route::group(['middleware' => 'api', 'prefix' => 'social-media'], function () {
    Route::get('/redirect', 'FacebookController@redirect');
    Route::get('/callback', 'FacebookController@callback');
    Route::get('login', 'FacebookController@getLogin');

    Route::get('/page-detail', 'FacebookController@getUserPageDetail');
    Route::get('/page-info', 'FacebookController@getPageDetail');

    Route::get('/page-posts', 'FacebookController@getPagePostInfo');

    Route::get('/get-access-token', 'FacebookController@getUserAccessToken');

    Route::get('/get-token', 'FacebookController@getToken');

    Route::post('manage-social-business-page', 'FacebookController@manageSocialBusinessPages');

    Route::get('get-page-feed', 'FacebookController@getPageFeed');

    Route::get('get-single-post', 'FacebookController@getSinglePost');

    Route::post('update-single-post', 'FacebookController@updateSinglePost');

    Route::delete('delete-single-post', 'FacebookController@deleteSinglePost');
});

Route::group(['middleware' => 'api', 'prefix' => 'twitter'], function()
{
    // Route::post('callback', 'TwitterController@Callback');
    Route::get('login', 'TwitterController@redirectToProvider');
    Route::get('callback', 'TwitterController@handleProviderCallback');
    Route::post('add-post', 'TwitterController@addPost');
    Route::get('get-posts', 'TwitterController@getPosts');
    Route::get('get-all-published-posts', 'TwitterController@getAllPublishedPost');
    Route::get('manual-twitter-authentication', 'TwitterController@manualTwitterAuthenticaion');
    Route::get('manualCallback', 'TwitterController@manualCallback');
});



Route::group(['middleware' => 'api', 'prefix' => 'online-directory'], function () {

    Route::get('zocdoc', 'OnlineDirectoryController@getZocDocListingDetail');

    Route::get('healthgrade', 'OnlineDirectoryController@getHealthGradeListingDetail');

    Route::get('ratemds', 'OnlineDirectoryController@getRateMdsListingDetail');
    // Route::get('zocdoc', 'OnlineDirectoryController@getZocDocLocationDetail');


});


Route::group(['middleware' => 'api', 'prefix' => 'website'], function () {
    // Route::get('page-speed-result', 'WebsiteController@getPageSpeedResult');
});


Route::group(['middleware' => 'api', 'prefix' => 'buzzsumo'], function () {
    Route::get('get-viral-content', 'ContentDiscoveryController@getViralContent');
});
