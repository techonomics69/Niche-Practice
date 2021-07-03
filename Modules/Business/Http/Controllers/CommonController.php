<?php

namespace Modules\Business\Http\Controllers;

use App\Services\SessionService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\AdminAlertEntity;
use Modules\Admin\Entities\AdminBusinessEntity;
use Modules\Admin\Entities\AdminCampaignEntity;
use Modules\Admin\Entities\AdminMarketingEntity;
use Modules\Admin\Entities\AdminPromotionEntity;
use Modules\Admin\Entities\AdminTaskEntity;
use Modules\Admin\Http\Controllers\AdminAlertController;
use Modules\Admin\Models\BusinessTask;
use Modules\Business\Entities\BusinessEntity;
use Modules\Business\Entities\CampaignEntity;
use Modules\Business\Entities\KeywordEntity;
use Modules\Business\Entities\PromotionEntity;
use Modules\Business\Entities\TaskEntity;
use Modules\Business\Entities\WebsiteEntity;
use Modules\Business\Models\Business;
use Modules\Business\Models\EmailTemplate;
use Modules\CRM\Entities\CRMEntity;
use Modules\CRM\Entities\GetReviewsEntity;
use Modules\GoogleAnalytics\Entities\GoogleAnalyticsEntity;
use Modules\ThirdParty\Entities\ContentDiscoveryEntity;
use Modules\ThirdParty\Entities\DashboardEntity;
use Modules\ThirdParty\Entities\SocialEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\TripAdvisorEntity;
use Modules\User\Entities\Billing\SubscriptionManagerEntity;
use Modules\User\Entities\NotificationEntity;
use Modules\User\Entities\UserEntity;
use Modules\User\Models\Emailrequestlog;
use Modules\User\Models\Smsrequestlog;
use Modules\User\Models\Users;
use Config;
use Log;
use Exception;
use Modules\User\Http\Controllers\UserController;

class CommonController extends Controller
{
    protected $data;

    protected $sessionService;

    protected $thirdPartyObj;

    protected $socialEntity;

    protected $contentEntity;

    protected $userEntity;

    protected $businessEntity;

    protected $reviewEntity;

    protected $campaignEntity;

    protected $adminCampaignEntity;

    protected $adminTaskEntity;

    protected $adminAlertEntity;

    protected $adminPromotionEntity;

    protected $adminBusinessEntity;

    protected $keywordEntity;

    protected $promotionEntity;

    protected $crmEntity;

    protected $taskEntity;

    protected $dashboardEntity;

    protected $billingEntity;

    protected $adminMarketingEntity;

    protected $googleAnalyticsEntity;

    protected $notificationEntity;

    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->thirdPartyObj = new ThirdPartyEntity();
        $this->socialEntity = new SocialEntity();
        $this->contentEntity = new ContentDiscoveryEntity();
        $this->userEntity = new UserEntity();
        $this->businessEntity = new BusinessEntity();
        $this->reviewEntity = new GetReviewsEntity();
        $this->campaignEntity = new CampaignEntity();
        $this->adminCampaignEntity = new AdminCampaignEntity();
        $this->adminTaskEntity = new AdminTaskEntity();
        $this->taskEntity = new TaskEntity();
        $this->adminAlertEntity = new AdminAlertEntity();
        $this->adminPromotionEntity = new AdminPromotionEntity();
        $this->adminBusinessEntity = new AdminBusinessEntity();
        $this->promotionEntity = new PromotionEntity();
        $this->crmEntity = new CRMEntity();
        $this->keywordEntity = new KeywordEntity();
        $this->billingEntity = new SubscriptionManagerEntity();
        $this->dashboardEntity = new DashboardEntity();
        $this->adminMarketingEntity = new AdminMarketingEntity();
        $this->googleAnalyticsEntity = new GoogleAnalyticsEntity();
        $this->notificationEntity = new NotificationEntity();
    }


    public function requestManager(Request $request)
    {

    }

    public function ajaxRequestManager(Request $request)
    {
//       Log::info($request->all());
//        log::info('common controller request');
//        log::info($request);
        $businessObj = new BusinessEntity();
        $userObj = new UserEntity();
        $webObj = new WebsiteEntity();
        $tripObj = new TripAdvisorEntity();

        $userData = $this->sessionService->getAuthUserSession();

        if ($request->get('send') == 'status-generate') {
            $result = $userObj->updateSession($request);
        } else if ($request->get('send') == 'add-patient-customer') {
            $result = $this->crmEntity->addPatientCustomer($request);
        } else if ($request->get('send') == 'crm-settings-list') {
            $result = $this->crmEntity->customerSettingsList($request);
        } else if ($request->get('send') == 'retrieve-chat-history') {
            $result = $this->notificationEntity->showNotifications($request);
        } else if ($request->get('send') == 'update-chat-status') {
            $result = $this->notificationEntity->changeUnreadStatus($request);
        } else if ($request->get('send') == 'edit-patient-customer') {
            $result = $this->crmEntity->editPatientCustomer($request);
        } elseif ($request->get('send') == 'business-process') {
            $result = $businessObj->collectBusinessData($request);
        } elseif ($request->get('send') == 'web-process') {
            $result = $webObj->trackWebsiteStatus($request);

            if ($result['_metadata']['outcomeCode'] == 200 && empty($request->get('webSource'))) {
                if (!empty($userData)) {
                    $businessData = Business::where('user_id', $userData['id'])->first();

                    if (!empty($businessData)) {
                        $businessData->update(
                            [
                                'discovery_status' => 6
                            ]
                        );
                    }
                }
            }

        } elseif ($request->get('send') == 'reviews-process') {
            $result = $tripObj->SaveHistoricalReviews($request);

            if ($result['_metadata']['outcomeCode'] == 200) {
                if (!empty($userData)) {
                    $businessData = Business::where('user_id', $userData['id'])->first();

                    if (!empty($businessData)) {
                        $businessData->update(
                            [
                                'discovery_status' => 1
                            ]
                        );
                    }
                }
            }
        } elseif ($request->get('send') == 'manual-connect-business') {
            if (!empty($request->type)) {
                if ($request->type == 'facebook') {
                    $socialToken = $this->sessionService->getOAuthToken();
                    $data = [];
                    $data['access_token'] = $socialToken['businessAccessToken'];

                    $request->merge($data);
                    $result = $this->socialEntity->manageSocialBusinessPages($request, 'facebook');
                } elseif ($request->type == 'vitals') {
                    $result = [];
                } else {
                    $result = $businessObj->thirdPartyConnect($request);
//                    Log::info("res" . json_encode($result));
                }
            } else {
                $result = [];
            }

        } elseif ($request->get('send') == 'unlink-app') {
            if (!empty($request->type)) {
                if ($request->type == 'Twitter') {
                    $result = $this->socialEntity->removeThirdParties($request);
                } else {
                    $result = $this->thirdPartyObj->removeThirdPartyBusiness($request);
                }

//                Log::info("res" . json_encode($result));
            } else {
                $result = [];
            }
        } elseif ($request->get('send') == 'super-login') {
            $result = $this->userEntity->superLogin($request);
        } elseif ($request->get('send') == 'update-user-password') {
            $result = $this->userEntity->updateNewPassword($request);
        } elseif ($request->get('send') == 'deactivate-account') {
            $request->merge(['email' => $userData['email']]);
            $result = $this->userEntity->deactivateUserAccount($request);
        } elseif ($request->get('send') == 'admin-change-user-account-status') {
            if ($request->get('status') == 'deleted') {
                $request->merge(
                    [
                        'delete_by' => 1,
                    ]);
            }

            $result = $this->userEntity->changeUserAccountStatus($request);
        } elseif ($request->get('send') == 'delete-account') {
            $result = $this->userEntity->deleteUserAccount($request);
        } elseif ($request->get('send') == 'get-manual-keyword-volume') {
            $result = $this->keywordEntity->getManualKeywordVolume($request);
        } elseif ($request->get('send') == 'add-local-keyword') {
            $result = $this->keywordEntity->addLocalKeyword($request);
        } elseif ($request->get('send') == 'get-keyword-rank') {
            $result = $this->keywordEntity->createProjectForKeyword($request);
        } elseif ($request->get('send') == 'suggested-keyword') {
            $result = $this->keywordEntity->getSuggestedKeyword($request);
        } elseif ($request->get('send') == 'get-broadmatch-keyword') {
            $result = $this->keywordEntity->getBroadMatchKeyword($request);
        } elseif ($request->get('send') == 'save-industry') {
            $result = $this->adminBusinessEntity->saveIndustry($request);
        } elseif ($request->get('send') == 'save-niche') {
            $result = $this->adminBusinessEntity->saveNiche($request);
        } elseif ($request->get('send') == 'save-template-category') {
            $result = $this->adminCampaignEntity->saveCategory($request);
        } elseif ($request->get('send') == 'template-update-category') {
            $result = $this->adminCampaignEntity->updateCategory($request);
        } elseif ($request->get('send') == 'admin-template-category-delete') {
            $result = $this->adminCampaignEntity->deleteCategory($request);
        } elseif ($request->get('send') == 'save-template-type') {
            $result = $this->adminCampaignEntity->saveType($request);
        } elseif ($request->get('send') == 'template-update-type') {
            $result = $this->adminCampaignEntity->updateType($request);
        } elseif ($request->get('send') == 'admin-template-type-delete') {
            $result = $this->adminCampaignEntity->deleteType($request);
        } elseif ($request->get('send') == 'admin-cat-type-status') {
            $result = $this->adminCampaignEntity->changeStatus($request);
        } elseif ($request->get('send') == 'save-category') {
            $result = $this->adminTaskEntity->saveCategory($request);
        } elseif ($request->get('send') == 'update-category') {
            $result = $this->adminTaskEntity->updateCategory($request);
        } elseif ($request->get('send') == 'admin-save-template') {
            $result = $this->adminCampaignEntity->saveTemplate($request);
        } elseif ($request->get('send') == 'save-template') {
            $result = $this->campaignEntity->saveTemplate($request);
        } elseif ($request->get('send') == 'test-email') {
            $result = $this->campaignEntity->sendTestMail($request);
        } elseif ($request->get('send') == 'save-promotion-template') {
            $result = $this->promotionEntity->saveTemplate($request);
        } elseif ($request->get('send') == 'admin-save-promotion-template') {
            $result = $this->adminPromotionEntity->saveTemplate($request);
        } elseif ($request->get('send') == 'delete-promotion') {
            $result = $this->promotionEntity->deleteThisTemplate($request);
        } elseif ($request->get('send') == 'admin-get-promotion-template') {
            $result = $this->adminPromotionEntity->getThisPromotion($request);
        } elseif ($request->get('send') == 'admin-get-template') {
            $result = $this->adminCampaignEntity->getThisTemplate($request);
        } elseif ($request->get('send') == 'admin-get-saved-block-list') {
            $result = $this->adminCampaignEntity->getSavedBlock();
        } elseif ($request->get('send') == 'template-delete-save-block') {
            $result = $this->adminCampaignEntity->deleteSavedBlock($request);
        } elseif ($request->get('send') == 'template-save-block') {
            $result = $this->adminCampaignEntity->saveTemplateBlock($request);
        } elseif ($request->get('send') == 'delete-template') {
            $result = $this->campaignEntity->deleteThisTemplate($request);
        } elseif ($request->get('send') == 'admin-delete-template') {
            $result = $this->adminCampaignEntity->deleteThisTemplate($request);
        } elseif ($request->get('send') == 'admin-copy-template') {
            $result = $this->adminCampaignEntity->copyThisTemplate($request);
        } elseif ($request->get('send') == 'admin-copy-promotion') {
            $result = $this->adminPromotionEntity->copyThisPromotion($request);
        } elseif ($request->get('send') == 'admin-delete-promotion') {
            $result = $this->adminPromotionEntity->deleteThisTemplate($request);
        } elseif ($request->get('send') == 'admin-promotion-status') {
            $result = $this->adminPromotionEntity->changeStatus($request);
        } elseif ($request->get('send') == 'admin-template-status') {
            $result = $this->campaignEntity->changeStatus($request);
        } elseif ($request->get('send') == 'admin-task-status') {
            $result = $this->adminTaskEntity->changeStatus($request);
        } elseif ($request->get('send') == 'admin-copy-category') {
            $result = $this->adminTaskEntity->copyThisCategory($request);
        } elseif ($request->get('send') == 'admin-service-status') {
            $result = $this->adminMarketingEntity->changeStatus($request);
        } elseif ($request->get('send') == 'admin-alert-status') {
            $result = $this->adminAlertEntity->changeStatus($request);
        } elseif ($request->get('send') == 'close-task-suggession') {
            $result = $this->userEntity->userMetaManager($request);
        } elseif ($request->get('send') == 'unsubscribe-me') {
            $result = $this->campaignEntity->unsubscribeUser($request);
        } elseif ($request->get('send') == 'monthly-rating-data') {
            $result = $this->dashboardEntity->getAllStatsCount($request);
//
//            $types =
//                [
//                    'category_type'=> 'RV',
//                    'type' => 'Google Places1',
//                    'is_type' => 'week',
//                ];
//
//            $request->merge($types);
//            $result  = $dashObj->getGraphStatsCount($request);
//        print_r($res['records']);
//exit;

//            foreach($res['records'][0]['graph_data'] as $row)
//            {
////            print_r($row);
////            exit;
//                $this->data['xAxis'][] = $row['activity_date'];
//                $this->data['yAxis'][] = $row['count'];
////            $yAxis = $row['count'];
//            }
//
//            return $this->data['yAxis'] = [3, 4,6,8,10,12];
        } elseif ($request->get('send') == 'show-description') {
            $result = $this->adminAlertEntity->getTask($request->get('id'));
        } elseif ($request->get('send') == 'need-help') {
            $result = $this->adminAlertEntity->getModuleTask($request);
        } elseif ($request->get('send') == 'dasboard-widget-help') {
            $result = $this->adminAlertEntity->getWidgetHelp($request);
        } elseif ($request->get('send') == 'admin-task-delete') {
            $result = $this->adminTaskEntity->deleteTask($request);
        } elseif ($request->get('send') == 'admin-service-delete') {
            $result = $this->adminMarketingEntity->deleteService($request);
        } elseif ($request->get('send') == 'admin-alert-delete') {
            $result = $this->adminAlertEntity->deleteTask($request);
        } elseif ($request->get('send') == 'admin-category-delete') {
            $result = $this->adminTaskEntity->deleteCategory($request);
        } elseif ($request->get('send') == 'forgot-password') {
            $userCObj = new UserController();
            $result = $userCObj->sendResetLinkEmail($request);
        } elseif ($request->get('send') == 'get-template') {
            $result = $this->campaignEntity->getThisTemplate($request);
        } elseif ($request->get('send') == 'template-users-link') {
//            Log::info("next process");
            $result = $this->campaignEntity->linkTemplateUsers($request);
        } elseif ($request->get('send') == 'get-template-users-link') {
            $result = $this->campaignEntity->getLinkTemplateUsers($request);
        } elseif ($request->get('send') == 'send-template-preview') {
//            Log::info("next send-template-preview");
            $request->merge(['user_id' => $userData['id']]);
            $result = $this->campaignEntity->sendTemplatePreviewToUsers($request);

//            Log::info("res" . json_encode($result));
        } elseif ($request->get('send') == 'content-research') {
            $result = $this->contentEntity->getSocialViralContent($request);
        } elseif ($request->get('send') == 'save-feedback') {
            $result = $this->reviewEntity->saveFeedback($request);
        } elseif ($request->get('send') == 'user-profile') {
            $request->merge(['email' => $userData['email']]);
            $result = $this->userEntity->userProfileUpdate($request);

            if ($result['_metadata']['outcomeCode'] == 200) {
                $userData['first_name'] = $request->first_name;
                $userData['last_name'] = $request->last_name;
                $userData['business'][0]['phone'] = $request->phone;
                $this->sessionService->setAuthUserSession($userData);
            }

        } elseif ($request->get('send') == 'update-meta') {
            $request->merge(
                [
                    'email' => $userData['email'],
                    'grant' => 'only_user'
                ]
            );
            $result = $this->userEntity->userProfileUpdate($request);

            if ($result['_metadata']['outcomeCode'] == 200) {
//                $userData = $request->except('send', 'grant');

                $userData['do_yourself'] = $request->do_yourself;

//                Log::info("info to update");
//                Log::info($userData);
                $this->sessionService->setAuthUserSession($userData);
            }

        } elseif ($request->get('send') == 'unlock-campaign') {
            $result = $this->taskEntity->unlockCampaign($request);
//            $request->merge(['email' => $userData['email']]);
//            $result = $this->userEntity->userProfileUpdate($request);
//
//            if($result['_metadata']['outcomeCode'] == 200)
//            {
//                $userData['first_name'] = $request->first_name;
//                $userData['last_name'] = $request->last_name;
//                $userData['business'][0]['phone'] = $request->phone;
//                $this->sessionService->setAuthUserSession($userData);
//            }
        } elseif ($request->get('send') == 'update-business-profile') {
            $result = $this->businessEntity->businessProfileUpdate($request);

            if ($result['_metadata']['outcomeCode'] == 200) {
                $userData['business'] = $result['records'];

                $this->sessionService->setAuthUserSession($userData);
            }
        } elseif ($request->get('send') == 'save-notifications-setting') {
//            log::info('here');
//            log::info($request);
            $result = $this->businessEntity->saveNotification($request);
//            return $result;
        } elseif ($request->get('send') == 'social-profile') {
            $result = $this->businessEntity->socialProfileUpdate($request);

            if ($result['_metadata']['outcomeCode'] == 200) {
                $userData['business'][0]['phone'] = $request->phone;
                $this->sessionService->setAuthUserSession($userData);
            }
        } elseif ($request->get('send') == 'done-me-onboard') {
            $result = $this->businessEntity->donemeonboard($request);
        } elseif ($request->get('send') == 'web-report') {
            $data = '';
            try {
                $apiENV = config::get('apikeys.APP_ENV');

//                Log::info("apiENV $apiENV");

                if ($apiENV != 'local') {
                    $baseUriHost = 'https';
                } else {
                    $baseUriHost = 'http';
                }

                $baseUriHost = 'http';

//                Log::info("url host " . $baseUriHost);

                $client = new Client();
                $websiteUrl = $request->website;

                $response = $client->get($baseUriHost . '://reviewer.nichepractice.com/domains&getImage&site=' . $websiteUrl, [])->getBody()->getContents();

                if (!empty($response)) {
                    $code = 200;
                    $data = $response;
                } else {
                    $code = 404;
                }
            } catch (Exception $e) {
                $code = $e->getCode();
                Log::info("exception web report " . $e->getMessage());
            }

            $statusData = [
                'status_code' => $code,
                'status_message' => "",
                'data' => $data,
                'errors' => ''
            ];

            return json_encode($statusData);
        } elseif ($request->get('send') == 'save-images') {
            return $this->storeImage($request);
        } elseif ($request->get('send') == 'retrieve-tabs-task') {
            $result = $this->taskEntity->list($request, $userData['id']);
        } elseif ($request->get('send') == 'task-count') {
            $taskData =
                [
                    'status' => 'open',
                ];
            $request->merge($taskData);
            $result = $this->taskEntity->list($request, $userData['id']);
            $business_task_open = totalTasksCount($result) + totalTasksCount($result, 'non_marketing_tasks');

            $business_task_skipped = BusinessTask::where('user_id', $userData['id'])->where('status', 'skipped')->count();
            $business_task_done = BusinessTask::where('user_id', $userData['id'])->where('status', 'done')->count();

            $data = [
                'open' => $business_task_open,
                'skipped' => $business_task_skipped,
                'done' => $business_task_done,
            ];

            $statusData = [
                'status_code' => 200,
                'status_message' => 'Task count',
                'data' => $data,
                'errors' => []
            ];

            return json_encode($statusData);
        } elseif ($request->get('send') == 'save-citation') {
            $result = $this->businessEntity->saveCitation($request);
        } elseif ($request->get('send') == 'retrieve-recurring-tasks') {
            $result = $this->taskEntity->recurringTasks($request, $userData['id']);
        } elseif ($request->get('send') == 'task-detail') {
            $result = $this->taskEntity->taskDetail($request);
        } elseif ($request->get('send') == 'sample-detail') {
            $result = $this->taskEntity->sampleDetail($request);
        } elseif ($request->get('send') == 'send-patient-email') {
            $result = $this->campaignEntity->sendPatientEmailInvite($request);
        } elseif ($request->get('send') == 'update-task-status') {
            $result = $this->taskEntity->updateTaskStatus($request);
        } elseif ($request->get('send') == 'purchase-order') {
//            $credits = $request->get('credits');
//            $credits = $request->get('credits');
            $result = $this->billingEntity->purchaseComplete($request);
        } elseif ($request->get('send') == 'billing-make-payment') {
            // billing
            $result = $this->billingEntity->manageSubscription($request);

//            Log::info("result");
//            Log::info($result);
            if ($result['_metadata']['outcomeCode'] == 200) {
                $subscriptionStatus = $this->userEntity->subscriptionStatusCheck();

                $userData = $this->sessionService->getAuthUserSession();

                Log::info("subscriptionStatus billing");
//                Log::info($subscriptionStatus);
                $userData['subscriptionStatus'] = $subscriptionStatus;

                Emailrequestlog::where('users_id', $userData['id'])->update(
                    [
                        'maximum' => '3000',
                    ]);

                Smsrequestlog::where('users_id', $userData['id'])->update(
                    [
                        'maximum' => '100',
                    ]);

                $this->sessionService->setAuthUserSession($userData);
            }

            return $result;
        } elseif ($request->get('send') == 'billing-purchase-credits') {
            // billing
            $result = $this->billingEntity->purchaseCredits($request);
//            return $result;
        } elseif ($request->get('send') == 'update_db_online_time') {
            $result = $this->userEntity->updateOnlineTime();
            return $result;
        } //        ////////////////////////////////////////////////////////////////
        elseif ($request->get('send') == 'analytics-views') {
//            log::info('intel inside');
//            log::info($request);
//            $result = $this->userEntity->updateOnlineTime();
//            return $result;
            if ($request->get('accessToken')) {
                $socialToken = $this->sessionService->getOAuthToken();
                $socialToken->toArray();
                $data['refresh_token'] = $socialToken['analyticsAccessToken'];

                // $requestType = 'accounts';
                $urlAction = 'google-analytics/get-accounts';

                if ($request->has('id')) {
//                    Log::info("id ");
                    // $requestType =  Get account properties
                    $urlAction = 'google-analytics/get-web-property';
                    $data['acount_id'] = $request->get('id');
                } elseif ($request->has('view_id')) {
//                    Log::info("view_id ");
                    // Get website page views
                    $urlAction = 'google-analytics/get-profile-view';
                    $data['view_id'] = $request->get('view_id');
                    $data['name'] = $request->get('name');
                    $data['website'] = $request->get('website');
                }
//                Log::info("actui " . $urlAction);
                $request->merge(['urlAction' => $urlAction]);
                $request->merge($data);
//                log::info('in common controller google analytics $request');
//                log::info($request);
//exit;
//                $response = $this->serveApiRequest()->request
//                (
//                    'GET',
//                    $urlAction,
//                    [
//                        'query' => $data
//                    ]
//                );
                if ($request->has('id')) {
//                    log::info('getWebProperties id');
                    $response = $this->googleAnalyticsEntity->getWebProperties($request);
                } elseif ($request->has('view_id')) {
                    log::info('getProfileViews view_id');
                    $response = $this->googleAnalyticsEntity->getProfileViews($request);
                } else {
                    $response = $this->googleAnalyticsEntity->getAccounts($request);
                }
//                log::info('$response Analytics');
//                log::info($response);
//                print_r($response);
//exit;

//                $responseData = json_decode($response->getBody()->getContents(), true);
                $statusData = '';
                $insightStatus = '';
                $insightTitle = '';
                $responseCode = $response['_metadata']['outcomeCode'];
                if ($response['_metadata']['outcomeCode'] == 200) {
                    $responseMessage = $response['_metadata']['message'];
                    $data = $response['records'];
                    $counted = '';
                    if ($request->has('view_id')) {
                        $types = [
                            'category_type' => 'PV',
                            'type' => 'google-analytics',
                            'is_type' => 'all',
                        ];
                        $request->merge($types);
                        $response = $this->dashboardEntity->getGraphStatsCount($request);

//                        $userData = $this->sessionService->getAuthUserSession();

                        $counted = $response['records'][0]['count'];
                        $insightStatus = $response['records'][0]['insightStatus'];
                        $insightTitle = $response['records'][0]['insightTitle'];
//                        $

//                        Users::where('id', $userData['id'])->update(
//                            [
//                                'google_analytics_views_count' => (!empty($response['records'][0]['count'])) ? $response['records'][0]['count'] : ''
//                        ]);
                    }

                    $statusData = [
                        'status_code' => $responseCode,
                        'status_message' => $responseMessage,
                        'data' => $data,
                        'totalCount' => $counted,
                        'insightStatus' => $insightStatus,
                        'insightTitle' => $insightTitle
                    ];
                } else {
                    $statusData = [
                        'status_code' => $responseCode,
                        'status_message' => 'Requested Account is not linked with any Website.',
                        'data' => $data,
                    ];
                }
                return json_encode($statusData);
            }
        } elseif ($request->get('send') == 'remove-access-token') {
            $socialObj = new SocialController();


            $googleAnalytics = (!empty($request->get('googleAnalytics'))) ? $request->get('googleAnalytics') : '';
//            log::info('s s s');
//            log::info($googleAnalytics);
//            $result =
            $socialObj->removeAccessToken($googleAnalytics);
//            log::info('$result s s s');
//            log::info($result);
//            return $result;
        } elseif ($request->get('send') == 'google-analytics-view-type') {
            $response = $this->dashboardEntity->getGraphStatsCount($request);
//            return  json_encode($response['records']);
            return json_encode($response);
        } elseif ($request->get('send') == 'add-website') {
            $data = '';
            $message = '';
            try {
                $businessResult = $this->businessEntity->userSelectedBusiness();

                if ($businessResult['_metadata']['outcomeCode'] != 200) {
                    return $businessResult;
                }

                $businessResult = $businessResult['records'];
                $businessId = $businessResult['business_id'];
                $website = $request->get('website');
                log::info('bpu');
//                log::info($businessId);
                $response = Business::where('business_id', $businessId)->update(['website' => $website]);


//                log::info('web $response');
//                log::info($response);


                if (!empty($response)) {
                    $code = 200;
                    $data = $response;
                    $message = 'Website added Successfully!';
                } else {
                    $code = 404;
                }
            } catch (Exception $e) {
                $code = $e->getCode();
                Log::info("exception updating website" . $e->getMessage());
                $message = $e->getMessage();
            }

            $statusData = [
                'status_code' => $code,
//                'status_message' => "",
                'status_message' => $message,
                'data' => $data,
                'errors' => ''
            ];

            return json_encode($statusData);

        } elseif ($request->get('send') == 'read-all-notification') {
            $result = $this->notificationEntity->readAllNotification();
        } elseif ($request->get('send') == 'save-association') {

            $result = $this->adminTaskEntity->marketingAssociation($request);

//            $statusData = [];
//            if($result['_metadata']['outcomeCode'] == 200){
//                $statusData = [
//                    'status_code' => $result['_metadata']['outcomeCode'],
////                'status_message' => "",
//                    'status_message' => $result['_metadata']['message'],
//                ];
//            }
//            else{
//                $statusData = [
//                    'status_code' => $result['_metadata']['outcomeCode'],
////                'status_message' => "",
//                    'status_message' => $result['_metadata']['message'],
//                ];
//            }

//            return json_encode($result);

        } elseif ($request->get('send') == 'change-assoc-status') {
            $result = $this->adminTaskEntity->changeAssociationStatus($request);
        } elseif ($request->get('send') == 'retrieve-library-list') {
            $result = $this->businessEntity->associationListWithCampaigns();
        } elseif ($request->get('send') == 'admin-marketing-association-delete') {
            $result = $this->adminCampaignEntity->deleteMarketingAssociation($request);
        } elseif ($request->get('send') == 'marketing-update-association') {
            $result = $this->adminCampaignEntity->updateMarketingAssociation($request);
        } elseif ($request->get('send') == 'get-linked-associations') {
            $result = $this->adminTaskEntity->getLinkedAssociations($request);
        } elseif ($request->get('send') == 'get-niches') {
            $result = $this->userEntity->getNiches();
        } elseif ($request->get('send') == 'update-user-info') {
            $result = $this->adminTaskEntity->updateUserInfo($request);
        } elseif ($request->get('send') == 'campaign_feedback') {
            $result = $this->adminTaskEntity->campaignFeedback($request);
        } elseif ($request->get('send') == 'save-report') {
            $result = $this->adminTaskEntity->saveReport($request);
        } elseif ($request->get('send') == 'admin-report-delete') {
            $result = $this->adminTaskEntity->deleteReport($request);
        } elseif ($request->get('send') == 'admin-report-update') {
            $result = $this->adminTaskEntity->updateReport($request);
        } elseif ($request->get('send') == 'admin-report-status') {
            $result = $this->adminTaskEntity->changeReportStatus($request);
        } elseif ($request->get('send') == 'save-report-user') {
            $result = $this->adminTaskEntity->addReportUser($request);
        } elseif ($request->get('send') == 'admin-report-user-status') {
            $result = $this->adminTaskEntity->changeReportUserStatus($request);
        } elseif ($request->get('send') == 'admin-report-user-delete') {
            $result = $this->adminTaskEntity->deleteReportUser($request);
        } elseif ($request->get('send') == 'update-report-user') {
            $result = $this->adminTaskEntity->updateReportUser($request);
        } elseif ($request->get('send') == 'close-widget') {
            $result = $this->userEntity->closeWidget();
        }
//        $businessData = Business::where('business_id', $businessId)->get()->toArray();
        //
        //                    $isWebsiteChanged = true;
        //              $isWebsiteChanged = false;
//                $businessData[0]['isWebsiteChanged'] = $isWebsiteChanged;
//                if ($isWebsiteChanged == true) {
//                    $businessData[0]['websiteChecker'] = getUrlDomain($website);
//                }
//        ////////////////////////////////////////////////////////////////

        if (!empty($result)) {
            $statusData = [
                'status_code' => $result['_metadata']['outcomeCode'],
                'status_message' => $result['_metadata']['message'],
                'data' => $result['records'],
                'errors' => $result['errors']
            ];
        } else {
            $statusData = [
                'status_code' => 1,
                'status_message' => 'Problem in connecting your app',
                'data' => [],
                'errors' => []
            ];
        }
        return json_encode($statusData);
    }

    public function storeImage($request)
    {
//        Log::info("file of ");
//        Log::info($request->file('file'));

        if ($request->file('file')) {
            $attachment = $request->file('file')->store('editor', 'public');
//            Log::info("attachment ");
//            Log::info($attachment);
            return $attachment;
        }
    }
}
