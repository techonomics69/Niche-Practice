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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api', 'prefix' => 'test-queue'], function () {
    Route::get('run-email-test', 'JobController@enqueue');
});
//App\Http\Controllers\Modules\Business\Http\Controllers\HomeController
//
//Route::group(['middleware' => 'api', 'namespace' => 'Modules\Business\Http\Controllers'], function()
//{
//    Route::get('test', function (Request $request) {
//        return "hey";
//    });
//});

//Route::get('test', function (Request $request) {
//    return "hey";
//});