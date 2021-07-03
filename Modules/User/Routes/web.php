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
use Modules\User\Models\Users;
Route::get('/userseeder', function ()
{
    $users = Users::all()->pluck('id');
        $users_count = $users->count();
        for ($i=0; $i < $users_count; $i++) {
            $user_id = $users[$i];
            $user =  Users::find($user_id);
            $user->emailrequestlog()->create([
                'remaining' => '2000',
                'maximum' => '2000'
                  ]);
            $user->smsrequestlog()->create([
                'remaining' => '20',
                 'maximum' => '20'
                 ]);
        }
        return 'DB Seeded';
 });
Route::group(['middleware' => 'guestAllow'], function () {
    Route::get('admin-register', 'UserController@create')->name('register');
    Route::post('admin-register', 'UserController@store')->name('user.register');

    Route::get('login', 'UserController@showLogin')->name('login');
    Route::post('login', 'UserController@login')->name('user.login');

    Route::get('forgot-password', 'UserController@showForgotPasswordLayout')->name('forgot-password');
    Route::post('password/email', 'UserController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'UserController@showResetForm')->name('password.reset');
    Route::post('password/update', 'UserController@passwordUpdate')->name('password.update');
});


Route::get('account-delete', 'UserController@accountDelete')->name('user.delete');

Route::get('logout', 'UserController@logOut')->name('user.logout');

Route::get('industry-niches', 'UserController@getNiches');

Route::get('auth-manager', 'UserController@oauthManager')->name('auth-manager');

Route::group(['middleware' => ['userAllow']], function () {


//    Route::get('register', 'UserController@create')->name('register');
//    Route::post('register', 'UserController@store')->name('user.register');

    Route::get('user-profile', 'UserController@userProfileLayout')->name('user-profile');
    Route::get('practice-profile', 'UserController@userPracticeProfile')->name('practice-profile');
    Route::get('upgrade', 'UserController@upgrade')->name('upgrade');

    Route::get('upgrade-live-test', 'UserController@upgradeLiveTest')->name('upgrade-live-test');
    Route::get('sms', 'UserController@sms')->name('sms');
    Route::get('credits', 'UserController@credits')->name('credits');

    Route::post('videoSeen', 'UserController@videoSeen')->name('videoSeen');
    Route::post('viewedSendReviewInviteSettings', 'UserController@viewedSendReviewInviteSettings')->name('viewedSendReviewInviteSettings');
});

Route::group(['middleware' => ['adminAllow']], function () {
});


Route::group(['prefix' => 'user'], function () {
    Route::get('/', 'UserController@index');
});
