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

Route::get('/test-thing', 'HomeController@testThing');
Route::group(['middleware' => ['userAllow']], function () {
    Route::get('/', 'HomeController@home')->name('home');
//    Route::get('dashboard', 'HomeController@home');

    Route::get('monitor-your-reviews', 'ReviewsController@reviewsList')->name('reviews');
    Route::get('review-sites', 'ReviewsController@thirdPartyAppsList')->name('connect-app');
    Route::get('customize-invitation', 'ReviewsController@customizeInvitationLayout')->name('edit-invitation');

    Route::get('task-list', 'TaskController@siteTasks')->name('task-list');

    Route::get('seo-audit', 'CustomerController@websiteReportList')->name('website-audit');
    Route::get('social-posts', 'SocialController@socialPosts')->name('social-posts');
    Route::post('next-social-posts', 'SocialController@nextSocialPosts')->name('next-social-posts');

    Route::get('social-media', 'SocialController@socialMediaSettings')->name('social-media');
    Route::get('curated-content', 'SocialController@shareContent')->name('share-content');

    Route::get('getPostDetail', 'SocialController@getSocialMediaPost');
    Route::get('deletePost', 'SocialController@deletePost')->name('deletePost');
    Route::get('deleteFacebookPost', 'SocialController@deleteFacebookPost')->name('deleteFacebookPost');

    Route::post('addSocialMediaPost', 'SocialController@addSocialMediaPost')->name('addSocialMediaPost');
    Route::post('share-this-promotion', 'SocialController@addPromotionPost')->name('addPromotionPost');
    Route::post('updateFacebookPost', 'SocialController@updateFacebookPost')->name('updateFacebookPost');
    Route::get('getFacebookPostDetail', 'SocialController@getFacebookPostDetail')->name('getFacebookPostDetail');

    Route::get('billing-and-plans', 'PageController@billingScreen')->name('billing-screen');
    Route::get('business-profile', 'PageController@businessProfile')->name('business-profile');
    Route::get('email-campaign', 'PageController@emailCampaign')->name('email-campaign');

    Route::get('citation-listings', 'PageController@businessListing')->name('citation-listings');
    Route::get('business-listings', 'PageController@businessListing')->name('business-listings');

    Route::get('refer', 'PageController@referpage')->name('referpage');
    Route::post('referalemail', 'PageController@referalemailstore')->name('referalemail.store');
    Route::get('upgradepage', 'PageController@upgradepage')->name('upgradepage');


    Route::get('contact', 'PageController@contactus')->name('contactus');
    Route::post('contact', 'PageController@contactusstore')->name('contact.store');
    Route::get('testing', 'PageController@testingg')->name('testingg');
//    Route::get('faq', 'PageController@faq')->name('faq');
    Route::get('getting-started', 'PageController@gettingstarted')->name('getting-started');
    Route::get('strategy', 'PageController@strategy')->name('strategy');
    Route::get('onboarding', 'PageController@onboarding')->name('onboarding');
    Route::get('marketing-pro', 'PageController@marketingPro')->name('marketingpro');
    Route::get('marketing-pro/{id}', 'PageController@marketingProDetails')->name('marketing-pro-details');
    Route::get('404', 'PageController@notfount')->name('404');

    Route::get('onboard', 'PageController@onboard')->name('onboard');



    Route::get('googlesearch', 'GoogleSearchController@getSearchResult')->name('googlesearch');

    Route::get('overview', 'PageController@overviewList')->name('overview');
    Route::get('automated-emails', 'PageController@autoCampaignList')->name('automated-emails');

    Route::get('email-campaigns', 'PageController@campaignList')->name('email');
    Route::get('new-patient-emails', 'PageController@patientEmails')->name('front.new-patient-emails');
//    Route::get('welcome-new-patients', 'PageController@welcomeNewPatients')->name('welcome-new-patients');
    Route::get('email-templates', 'PageController@emailTemplates')->name('email-templates');
    Route::get('email/{templateId?}', 'PageController@emailCampaign')->name('email-builder');
    Route::get('email-preview/{templateId}', 'PageController@emailCampaignPreview')->name('email-preview');

    Route::get('promotions', 'PageController@promotionList')->name('promotions-list');
    Route::get('promotion-templates', 'PageController@promotionTemplates')->name('promotion-templates');
    Route::get('create-promotion/{templateId?}', 'PageController@imageBuilder')->name('image-builder');

    Route::get('campaigns-library', 'PageController@campaignsLibrary')->name('campaigns-library');
    Route::get('library-list', 'PageController@campaignsLibraryStaticPage')->name('library-list');

    Route::get('{business}/landing-page', 'PageController@showLandingPage')->name('landing-page');

    Route::get('branded-content', 'PageController@websiteContent')->name('website-content');
    Route::get('social-media-profiles', 'PageController@socialMediaProfile')->name('social-media-profiles');
    Route::get('blog-articles', 'PageController@blogArticle')->name('blog-articles');
    Route::get('press-release', 'PageController@pressRelease')->name('press-release');

    Route::get('advanced-seo', 'PageController@seoVIew')->name('advanced-seo');
    Route::get('custom-social-posts', 'PageController@customSocialPosts')->name('custom-social-posts');
    Route::get('targeted-ads', 'PageController@payPerClick')->name('pay-per-click');
    Route::get('pay-per-click', 'PageController@payPerClick')->name('pay-per-page');
    Route::get('landing-page', 'PageController@landingPage')->name('landing-page');

    Route::get('detailed-analytics', 'PageController@analyticsView')->name('detailed-analytics');

    Route::get('keywords', 'BusinessController@businessKeywords')->name('settings.keywords');
    Route::get('teams', 'TaskController@teams')->name('teams');
    Route::get('csv', 'TaskController@csv')->name('csv');


//    Route::post('add-post', 'SocialController@addPost');
//
//    Route::group(['prefix' => 'task'], function () {
//        Route::get('retrieve-tabs-task', 'TaskController@retrieveTabsTask')->name('detailed-analytics');
//    });
});

Route::get('business-review/{email}/{secret}/{business}/{reviewID}/{flag?}', 'PageController@showBusinessReview');
Route::get('business-review-complete/{email}/{secret}/{business}', 'PageController@businessReviewComplete');

Route::post('done-me', 'CommonController@ajaxRequestManager');
Route::get('unsubscribe/{businessId?}/{email?}/{refer?}/{referSource?}', 'PageController@unSubscribe')->name('unsubscribe');

//Route::get('unsubscribee/{businessId?}/{email?}/{refer?}', 'PageController@unSubscribee')->name('unsubscribee');


Route::prefix('business')->group(function() {
    Route::get('/', 'BusinessController@index');

    Route::post('social-selection-pages', 'SocialController@socialPageList');
    Route::post('remove-access-token', 'SocialController@removeAccessToken');
});
Route::get('privacy-policy','PageController@privacyPolicy')->name('privacyPolicy');

Route::get('testingfbapi', 'SocialController@testingfbapi');



