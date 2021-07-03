<?php

namespace Modules\ThirdParty\Entities;

use App\Entities\AbstractEntity;
use App\Services\SessionService;
use App\Traits\UserAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Modules\ThirdParty\Models\StatTracking;
use GuzzleHttp\Client;
use Exception;
use Log;
use JWTAuth;
use DB;
use Modules\Business\Entities\BusinessEntity;
use Modules\CRM\Models\ReviewRequest;
use Modules\CRM\Models\Recipient;
use Modules\GoogleAnalytics\Models\GoogleAnalyticsMaster;
use Modules\ThirdParty\Models\SocialMediaInsight;
use Modules\Task\Entities\MarketingObjectiveEntity;
use Modules\Task\Models\BusinessTask;
use Modules\ThirdParty\Models\UserIssues;
use Modules\ThirdParty\Models\TripadvisorMaster;
use Modules\User\Models\Users;
use Modules\Yelp\Models\YelpMaster;
use Modules\GooglePlace\Models\GooglePlaceMaster;

use Modules\ThirdParty\Models\TripadvisorReview;
use Modules\ThirdParty\Entities\TripAdvisorEntity;
use Modules\ThirdParty\Entities\ThirdPartyEntity;
use Modules\ThirdParty\Entities\GooglePlaceEntity;
use Modules\ThirdParty\Entities\YelpEntity;

use Modules\Business\Models\Business;
use Modules\ThirdParty\Models\SMediaReview;
use Modules\ThirdParty\Models\SocialMediaLike;
use Modules\ThirdParty\Models\SocialMediaMaster;
use Config;

class DashboardEntity extends AbstractEntity
{
    use UserAccess;

    protected $sessionService;

    public function __construct()
    {
        $this->sessionService = new SessionService();
    }

    /**
     * @param $request (token, type, (ta,gp,yelp, all), is_type (day,week,past))
     * @return mixed
     */

//    public function thirdPartyReviews($request)
//    {
//        try {
//            $businessObj = new BusinessEntity();
//
//            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();
//
//            // user is not found.
//            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
//                return $checkPoint;
//            }
//            $user = $checkPoint['records'];
//
//            $businessResult = $businessObj->userSelectedBusiness();
//
//            if ($businessResult['_metadata']['outcomeCode'] != 200) {
//                return $this->helpError(1, 'Problem in selection of user busienss.');
//            }
//
//            $businessResult = $businessResult['records'];
//
//            $types = $request->get('type');
//
//            if (!is_array($types)) {
//                $types = [
//                    [
//                        'type' => $types,
//                        'is_type' => !empty($request->get('is_type')) ? $request->get('is_type') : 'day',
//                    ]
//                ];
//            }
//
//            $statusData = [];
//            $i = 0;
//            foreach ($types as $type) {
//                $currentType = strtolower($type['type']);
//                $reviewsType = strtolower($type['is_type']);
//                $thirdPartyResult = [];
//
//                $typeRequested = str_replace('-', ' ', ucfirst($currentType));
//
//                $thirdPartyResult = TripadvisorMaster::where(
//                    [
//                        'business_id' => $businessResult['business_id'],
//                        'type' => $typeRequested
//                    ]
//                )->first();
//
//                if (!empty($thirdPartyResult['name'])) {
//                    if ($currentType == 'google-places') {
//                        $dateFormat = 'Y-m-d';
//                    } else {
//                        $dateFormat = 'Y-m-d';
//                    }
//
//                    $currentDate = Carbon::now($user->time_zone);
//                    $FormatedCurrentDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format($dateFormat);
//                    $weekDate = Carbon::now($user->time_zone)->subDays(7);
//                    $formatedWeekDate = Carbon::createFromFormat('Y-m-d H:i:s', $weekDate)->format($dateFormat);
//
//                    if ($reviewsType == 'all') {
//                        $counts = $thirdPartyResult['review_count'];
//                    } else {
//                        $counts = TripadvisorReview::where('third_party_id', $thirdPartyResult['third_party_id'])
//                            ->where(function ($query) use ($reviewsType, $FormatedCurrentDate, $formatedWeekDate) {
//                                if ($reviewsType == 'week') {
//
//                                    $query->where(DB::raw("STR_TO_DATE(`review_date`, '%m-%d-%Y')"), '<=', $FormatedCurrentDate);
//                                    $query->where(DB::raw("STR_TO_DATE(`review_date`, '%m-%d-%Y')"), '>=', $formatedWeekDate);
//                                } elseif ($reviewsType == 'day') {
//                                    $query->where(DB::raw("STR_TO_DATE(`review_date`, '%m-%d-%Y')"), '=', $FormatedCurrentDate);
//                                }
//                            })
//                            ->count();
//                    }
//                    $statusData[$i]['type'] = $currentType;
//                    $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
//                    $statusData[$i]['count'] = $counts;
//                } else {
//                    $statusData[$i]['type'] = $currentType;
//                    $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
//                    $statusData[$i]['message'] = $typeRequested . ' not setup.';
//                }
//                $i++;
//            }
//
//            return $this->helpReturn("Reviews Count Result.", $statusData);
//        } catch (Exception $e) {
//            Log::info($e->getMessage());
//            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
//        }
//    }

    public function thirdPartyReviewsCount($request)
    {
        try {
            $businessObj = new BusinessEntity();

            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

            // user is not found.
            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                return $checkPoint;
            }
            $user = $checkPoint['records'];

            $businessResult = $businessObj->userSelectedBusiness($user);

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of user busienss.');
            }
            $businessResult = $businessResult['records'];

            $types = $request->get('type');

            if (!is_array($types)) {
                $types = [
                    [
                        'type' => $types,
                        'is_type' => !empty($request->get('is_type')) ? $request->get('is_type') : 'day',
                    ]
                ];
            }

            $statusData = [];
            $i = 0;
            foreach ($types as $type) {
                $currentType = strtolower($type['type']);
                $reviewsType = strtolower($type['is_type']);
                $thirdPartyResult = [];

                $typeRequested = str_replace('-', ' ', ucfirst($currentType));

                $thirdPartyResult = TripadvisorMaster::where(
                    [
                        'business_id' => $businessResult['business_id'],
                        'type' => $typeRequested
                    ]
                )->first();

                if (!empty($thirdPartyResult['name'])) {
                    if ($currentType == 'google-places') {
                        $dateFormat = 'Y-m-d';
                    } else {
                        $dateFormat = 'Y-m-d';
                    }

                    $currentDate = Carbon::now($user->time_zone);
                    $FormatedCurrentDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format($dateFormat);

                    $weekDate = Carbon::now($user->time_zone)->subDays(7);
                    $formatedWeekDate = Carbon::createFromFormat('Y-m-d H:i:s', $weekDate)->format($dateFormat);

                    if ($reviewsType == 'all') {
                        $count = $thirdPartyResult['average_rating'];
                    } else {
                        $count = TripadvisorReview::where('third_party_id', $thirdPartyResult['third_party_id'])
                            ->where(function ($query) use ($reviewsType, $FormatedCurrentDate, $formatedWeekDate) {
                                if ($reviewsType == 'week') {
                                    $query->where(DB::raw("STR_TO_DATE(`review_date`, '%m-%d-%Y')"), '<=', $FormatedCurrentDate);
                                    $query->where(DB::raw("STR_TO_DATE(`review_date`, '%m-%d-%Y')"), '>=', $formatedWeekDate);
                                } elseif ($reviewsType == 'day') {
                                    $query->where(DB::raw("STR_TO_DATE(`review_date`, '%m-%d-%Y')"), '=', $FormatedCurrentDate);
                                }

                            })
                            ->avg('rating');
                    }
                    $count = round($count, 1);

                    $statusData[$i]['type'] = $currentType;
                    $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
                    $statusData[$i]['count'] = $count;

                } else {
                    $statusData[$i]['type'] = $currentType;
                    $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
                    $statusData[$i]['message'] = $typeRequested . ' not setup.';
                }
                $i++;
            }

            return $this->helpReturn("Reviews Count Result.", $statusData);
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    /**
     * Get historical reviews from stat tracking
     * table and this is not needed to be integrated now
     * just for future implementation
     */

    public function getHistoricalReviewsCount($request)
    {
        try {
            $businessObj = new BusinessEntity();

            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

            // user is not found.
            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                return $checkPoint;
            }
            $user = $checkPoint['records'];

            $businessResult = $businessObj->userSelectedBusiness($user);

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of user busienss.');
            }
            $businessResult = $businessResult['records'];

            $types = $request->get('type');

            if (!is_array($types)) {
                $types = [
                    [
                        'type' => $types,
                        'is_type' => !empty($request->get('is_type')) ? $request->get('is_type') : 'day',
                    ]
                ];
            }

            $statusData = [];
            $i = 0;
            foreach ($types as $type) {
                $currentType = strtolower($type['type']);
                $reviewsType = strtolower($type['is_type']);
                $thirdPartyResult = [];

                $typeRequested = str_replace('-', ' ', ucfirst($currentType));

                $thirdPartyResult = TripadvisorMaster::where(
                    [
                        'business_id' => $businessResult['business_id'],
                        'type' => $typeRequested
                    ]
                )->first();

                if (!empty($thirdPartyResult['name'])) {
                    if ($currentType == 'google-places') {
                        $dateFormat = 'Y-m-d';
                    } else {
                        $dateFormat = 'Y-m-d';
                    }

                    $currentDate = Carbon::now($user->time_zone);
                    $FormatedCurrentDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format($dateFormat);

                    $weekDate = Carbon::now($user->time_zone)->subDays(7);
                    $formatedWeekDate = Carbon::createFromFormat('Y-m-d H:i:s', $weekDate)->format($dateFormat);

                    if ($reviewsType == 'all') {
                        $counts = $thirdPartyResult['review_count'];
                    } else {
                        $counts = StatTracking::where('third_party_id', $thirdPartyResult['third_party_id'])
                            ->where('type', 'RV')
                            ->where('site_type', $currentType)
                            ->where(function ($query) use ($reviewsType, $FormatedCurrentDate, $formatedWeekDate) {
                                if ($reviewsType == 'week') {
                                    $query->where(DB::raw("STR_TO_DATE(`activity_date`, '%m-%d-%Y')"), '<=', $FormatedCurrentDate);
                                    $query->where(DB::raw("STR_TO_DATE(`activity_date`, '%m-%d-%Y')"), '>=', $formatedWeekDate);
                                } elseif ($reviewsType == 'day') {

                                    $query->where(DB::raw("STR_TO_DATE(`activity_date`, '%m-%d-%Y')"), '=', $FormatedCurrentDate);
                                }
                            })
                            ->count();
                    }
                    $statusData[$i]['type'] = $currentType;
                    $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
                    $statusData[$i]['count'] = $counts;
                } else {
                    $statusData[$i]['type'] = $currentType;
                    $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
                    $statusData[$i]['message'] = $typeRequested . ' not setup.';
                }
                $i++;
            }

            return $this->helpReturn("Historical Reviews Count Result.", $statusData);
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }

    }

    /**
     * Get historical rating count from stat tracking
     * table this is not needed to be integrated now
     * just for future implementation
     */

    public function getHistoricalRatingCount($request)
    {

        try {
            $businessObj = new BusinessEntity();

            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

            // user is not found.
            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                return $checkPoint;
            }
            $user = $checkPoint['records'];

            $businessResult = $businessObj->userSelectedBusiness($user);

            if ($businessResult['_metadata']['outcomeCode'] != 200) {
                return $this->helpError(1, 'Problem in selection of user busienss.');
            }
            $businessResult = $businessResult['records'];

            $types = $request->get('type');

            if (!is_array($types)) {
                $types = [
                    [
                        'type' => $types,
                        'is_type' => !empty($request->get('is_type')) ? $request->get('is_type') : 'day',
                    ]
                ];
            }

            $statusData = [];
            $i = 0;
            foreach ($types as $type) {
                $currentType = strtolower($type['type']);
                $reviewsType = strtolower($type['is_type']);
                $thirdPartyResult = [];

                $typeRequested = str_replace('-', ' ', ucfirst($currentType));

                $thirdPartyResult = TripadvisorMaster::where(
                    [
                        'business_id' => $businessResult['business_id'],
                        'type' => $typeRequested
                    ]
                )->first();

                if (!empty($thirdPartyResult['name'])) {
                    if ($currentType == 'google-places') {
                        $dateFormat = 'Y-m-d';
                    } else {
                        $dateFormat = 'Y-m-d';
                    }

                    $currentDate = Carbon::now($user->time_zone);
                    $FormatedCurrentDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format($dateFormat);
                    $weekDate = Carbon::now($user->time_zone)->subDays(7);
                    $formatedWeekDate = Carbon::createFromFormat('Y-m-d H:i:s', $weekDate)->format($dateFormat);

                    if ($reviewsType == 'all') {
                        $avgRating = $thirdPartyResult['average_rating'];
                    } else {
                        $avgRating = StatTracking::where('third_party_id', $thirdPartyResult['third_party_id'])
                            ->where('type', 'RG')
                            ->where('site_type', $request->type)
                            ->where(function ($query) use ($reviewsType, $FormatedCurrentDate, $formatedWeekDate) {
                                if ($reviewsType == 'week') {
                                    $query->where(DB::raw("STR_TO_DATE(`activity_date`, '%m-%d-%Y')"), '<=', $FormatedCurrentDate);
                                    $query->where(DB::raw("STR_TO_DATE(`activity_date`, '%m-%d-%Y')"), '>=', $formatedWeekDate);
                                } elseif ($reviewsType == 'day') {

                                    $query->where(DB::raw("STR_TO_DATE(`activity_date`, '%m-%d-%Y')"), '=', $FormatedCurrentDate);
                                }

                            })->avg('count');
                        $avgRating = round($avgRating, 1);
                    }

                    $statusData[$i]['type'] = $currentType;
                    $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
                    $statusData[$i]['count'] = $avgRating;
                } else {
                    $statusData[$i]['type'] = $currentType;
                    $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
                    $statusData[$i]['message'] = $typeRequested . ' not setup.';
                }
                $i++;
            }

            return $this->helpReturn("Historical Rating Count Result.", $statusData);
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }

    }

    /**
     * get counts from third_party_review and
     * save data in stat_tracking table
     */
    public function countHistoricalData($request)
    {
        try {
            $userData = $this->sessionService->getAuthUserSession();

            Log::info('countHistoricalData');
            Log::info('$request');
            Log::info($request);

            if (isset($request->business_id) && empty($userData['id'])) {
                //cron job section

                $businessId = $request->business_id;
                $currentDate = Carbon::now();

                $businessRes = Business::find($businessId);
                $userId = $businessRes['user_id'];
            }
            else {
                //token based user get and store record in state tracking

                $businessObj = new BusinessEntity();
                $businessResult = $businessObj->userSelectedBusiness();

                if ($businessResult['_metadata']['outcomeCode'] != 200) {
                    return $this->helpError(1, 'Problem in selection of user business.');
                }
                $businessResult = $businessResult['records'];
                $businessId = $businessResult['business_id'];
                $userId = $businessResult['user_id'];

//                $businessObj = new BusinessEntity();

//                $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();
//
//                if ($checkPoint['_metadata']['outcomeCode'] != 200) {
//                    return $checkPoint;
//                }
//                $user = $checkPoint['records'];

//                $businessResult = $businessObj->userSelectedBusiness($user);
//                $businessId = $businessResult['records']['business_id'];
//
//                if ($businessResult['_metadata']['outcomeCode'] != 200) {
//                    return $this->helpError(1, 'Problem in selection of user business.');
//                }
//                $currentDate = Carbon::now($user->time_zone);
                $currentDate = Carbon::now();
            }

//            $thirdPartytypes = moduleSiteList();
            $thirdPartytypes = thirdPartyModuleSources();

            $dateFormat = dateFormatUsing();
            $FormatedCurrentDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format($dateFormat);

            $thirdPartyIds = TripadvisorMaster::select('third_party_id')->where('business_id', $businessId)->get()->toArray();

            if (isset($request->business_id) && empty($userData['id'])) {
                Log::info('data cron job');
                $historical_reviews = TripadvisorReview::whereIn('third_party_id', $thirdPartyIds)//Query for historical reivew
                //->where('review_id','>=',$firstReviewId)
                ->whereIn('type', $thirdPartytypes)
                    ->where(DB::raw("STR_TO_DATE(`review_date`, '%Y-%m-%d')"), '<=', $FormatedCurrentDate)
                    ->select('third_party_id', 'review_date', 'type', DB::raw('count(review_date) as total'))
                    ->groupBy('type', 'review_date', 'third_party_id')
                    ->get()->toArray();
            } else {
                $historical_reviews = TripadvisorReview::whereIn('third_party_id', $thirdPartyIds)//Query for historical reivew
                ->where('type', $request['type'])
                    ->where(DB::raw("STR_TO_DATE(`review_date`, '%Y-%m-%d')"), '<=', $FormatedCurrentDate)
                    ->select('third_party_id', 'review_date', 'type', DB::raw('count(review_date) as total'))
                    ->groupBy('type', 'review_date', 'third_party_id')
                    ->get()->toArray();

            }
            /*********************************Review section **********************/

            if (empty($historical_reviews)) {
                if ($request->business_id) {
                    Log::info('No Review Found.'); //use for cron job
                } else {
                    return $this->helpReturn("No Review Found."); //return use for token based call
                }
            }

            foreach ($historical_reviews as $review) {
                $reviewDate = getFormattedDate($review['review_date']);


                $appendReviewArray[] = [
                    'third_party_id' => $review['third_party_id'],
                    'user_id' => $userId,
                    'activity_date' => $reviewDate,
                    'site_type' => $review['type'],
                    'count' => $review['total'],
                    'type' => 'RV',
                ];
            }

            /**************************Rating Section***************************/
            if (isset($request->business_id) && empty($userData['id'])) {

                $historical_rating = TripadvisorReview::whereIn('third_party_id', $thirdPartyIds)//Query for Rating
                // ->where('review_id','>=',$firstReviewId)
                ->whereIn('type', $thirdPartytypes)
                    ->where(DB::raw("STR_TO_DATE(`review_date`, '%Y-%m-%d')"), '<=', $FormatedCurrentDate)
                    ->select('third_party_id', 'review_date', 'type', 'review_date', DB::raw('sum(rating) as sum'), DB::raw('count(review_date) as total'))
                    ->groupBy('review_date', 'third_party_id', 'review_date', 'type')->get()->toArray();
            } else {
                $historical_rating = TripadvisorReview::whereIn('third_party_id', $thirdPartyIds)//Query for Rating
                ->where('type', $request['type'])
                    ->where(DB::raw("STR_TO_DATE(`review_date`, '%Y-%m-%d')"), '<=', $FormatedCurrentDate)
                    ->select('third_party_id', 'review_date', 'type', 'review_date', DB::raw('sum(rating) as sum'), DB::raw('count(review_date) as total'))
                    ->groupBy('review_date', 'third_party_id', 'review_date', 'type')->get()->toArray();
            }

            if (empty($historical_rating)) {
                if ($request->business_id) {
                    Log::info('No Rating Found.'); //use for cron job
                } else {
                    return $this->helpReturn("No Rating Found."); //return use for token based call
                }

            }
            foreach ($historical_rating as $rating) { //loop for facebook rating
                $reviewDate = getFormattedDate($rating['review_date']);

                $appendRatingArray[] = [
                    'third_party_id' => $rating['third_party_id'],
                    'user_id' => $userId,
                    'activity_date' => $reviewDate,
                    'site_type' => $rating['type'],
                    'count' => $rating['sum'] / $rating['total'], //sun amd total find using query and submit in database
                    'type' => 'RG',
                ];
            }

            if (isset($businessId) && empty($userData['id'])) {
                StatTracking::whereIn('third_party_id', $thirdPartyIds)->delete();
                StatTracking::insert($appendReviewArray); //for  Review
                StatTracking::insert($appendRatingArray); //for  Rating
            } else {
                bulk_insert("stat_tracking", $appendReviewArray);
                bulk_insert("stat_tracking", $appendRatingArray);
            }

            $finalArray[] = [
                'reviews' => $appendReviewArray,
                'ratings' => $appendRatingArray,
            ];
            return $this->helpReturn("Reviews Update.", $finalArray);

        } catch (Exception $e) {
            Log::info(" countHistoricalData > " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function countFacebookReviewRating($third_party_id, $request)
    {
        try {
            if (!empty($request->token) && !empty($third_party_id)) { // for authenticated user
                $businessObj = new BusinessEntity();
                $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();
                if ($checkPoint['_metadata']['outcomeCode'] != 200) {
                    return $checkPoint;
                }
                $user = $checkPoint['records'];
                $businessResult = $businessObj->userSelectedBusiness($user);
                $businessId = $businessResult['records']['business_id'];
                if (empty($businessId)) {
                    return $this->helpReturn("Business Not Exist.");
                }
                $socialMediaId = SocialMediaMaster::select('id')
                    ->where('business_id', $businessId)
                    ->first();
                $socialMediaId = $socialMediaId->id;
            } else { //for cron job
                $socialMediaId = $third_party_id;
            }

            $currentDate = Carbon::now();
            $FormatedCurrentDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('Y-m-d');

            $historical_reviews = SMediaReview::where('social_media_id', $socialMediaId)//Query for historical reivew
            ->where(DB::raw("STR_TO_DATE(`review_date`, '%Y-%m-%d')"), '<=', $FormatedCurrentDate)
                ->select('social_media_id', 'review_date', DB::raw('count(review_date) as total'))
                ->groupBy('review_date', 'social_media_id')->get()->toArray();

            if (empty($historical_reviews)) {
                return $this->helpReturn("No Review Found.");
            }
            $dateFormat = dateFormatUsing();
            foreach ($historical_reviews as $review) {
                $reviewDate = getFormattedDate($review['review_date']);
                $appendReviewArray[] = [
                    'social_media_id' => $review['social_media_id'],
                    'activity_date' => $reviewDate,
                    'site_type' => 'Facebook',
                    'count' => $review['total'],
                    'type' => 'RV',
                ];
            }
            /**************************Rating Section***************************/
            $historical_rating = SMediaReview::where('social_media_id', $socialMediaId)//Query for Rating
            ->where(DB::raw("STR_TO_DATE(`review_date`, '%Y-%m-%d')"), '<=', $FormatedCurrentDate)
                ->select('social_media_id', 'review_date', DB::raw('sum(rating) as sum'), DB::raw('count(review_date) as total'))
                ->groupBy('review_date', 'social_media_id', 'review_date')->get()->toArray();

            if (empty($historical_rating)) {
                return $this->helpReturn("No Review Found.");
            }
            foreach ($historical_rating as $rating) { //loop for facebook rating
                $reviewDate = getFormattedDate($rating['review_date']);
                $appendRatingArray[] = [
                    'social_media_id' => $rating['social_media_id'],
                    'activity_date' => $reviewDate,
                    'site_type' => 'Facebook',
                    'count' => round($rating['sum'] / $rating['total'], 1), //sum amd total find using query and submit in database
                    'type' => 'RG',
                ];
            }
            /**************************Likes Section***************************/
            $historical_likes = SocialMediaLike::where('social_media_id', $socialMediaId)//Query for historical review
            ->where('like_date', '<=', $FormatedCurrentDate)
                ->select('social_media_id', 'like_date', DB::raw('sum(count) as total'))
                ->groupBy('like_date', 'social_media_id')->get()->toArray();
            if (empty($historical_likes)) {
                return $this->helpReturn("No Likes Found.");
            }

            $dateFormat = dateFormatUsing();

            foreach ($historical_likes as $likes) {
                $likesDate = getFormattedDate($likes['like_date']);
                $appendLikesArray[] = [
                    'social_media_id' => $likes['social_media_id'],
                    'activity_date' => $likesDate,
                    'site_type' => 'Facebook',
                    'count' => $likes['total'],
                    'type' => 'LK',
                ];
            }
            /**************************POST Section***************************/
            $historical_posts = SocialMediaInsight::where('social_media_id', $socialMediaId)//Query for historical review
            ->where('activity_date', '<=', $FormatedCurrentDate)
                ->where('type', '=', 'Page Post')
                ->select('social_media_id', 'activity_date',  DB::raw('sum(count) as total'))
                ->groupBy('activity_date', 'social_media_id')->get()->toArray();
            if (empty($historical_posts)) {
                return $this->helpReturn("No Post Found.");
            }
            $dateFormat = dateFormatUsing();

            foreach ($historical_posts as $posts) {

                $postsDate = getFormattedDate($posts['activity_date']);
                $appendPostsArray[] = [
                    'social_media_id' => $posts['social_media_id'],
                    'activity_date' => $postsDate,
                    'site_type' => 'Facebook',
                    'count' => $posts['total'],
                    'type' => 'FP',
                ];
            }

            /**************************Page Views Section***************************/
            $historical_page_views = SocialMediaInsight::where('social_media_id', $socialMediaId)//Query for historical review
            ->where('activity_date', '<=', $FormatedCurrentDate)
                ->where('type', '=', 'Page Views')
                ->select('social_media_id', 'activity_date', DB::raw('sum(count) as total'))
                ->groupBy('activity_date', 'social_media_id')->get()->toArray();

            if (empty($historical_page_views)) {
                return $this->helpReturn("No Page View Found.");
            }

            $dateFormat = dateFormatUsing();

            foreach ($historical_page_views as $pageview) {

                $pageViewsDate = getFormattedDate($pageview['activity_date']);
                $appendPageViewsArray[] = [
                    'social_media_id' => $pageview['social_media_id'],
                    'activity_date' => $pageViewsDate,
                    'site_type' => 'Facebook',
                    'count' => $pageview['total'],
                    'type' => 'PA',
                ];
            }

            /**************************Total Reach Section***************************/
            $historical_page_total_reach = SocialMediaInsight::where('social_media_id', $socialMediaId)//Query for historical review
            ->where('activity_date', '<=', $FormatedCurrentDate)
                ->where('type', '=', 'Total Reach')
                ->select('social_media_id', 'activity_date', DB::raw('sum(count) as total'))
                ->groupBy('activity_date', 'social_media_id')->get()->toArray();

            if (empty($historical_page_total_reach)) {
                return $this->helpReturn("No Total Reach Found.");
            }

            $dateFormat = dateFormatUsing();


            foreach ($historical_page_total_reach as $totalreach) {

                $totalReachDate = getFormattedDate($totalreach['activity_date']);
                $appendPageTotalReachArray[] = [
                    'social_media_id' => $totalreach['social_media_id'],
                    'activity_date' => $totalReachDate,
                    'site_type' => 'Facebook',
                    'count' => $totalreach['total'],
                    'type' => 'TR',
                ];
            }

            /**************************People Engaged Section***************************/
            $historical_page_people_engaged = SocialMediaInsight::where('social_media_id', $socialMediaId)//Query for historical review
            ->where('activity_date', '<=', $FormatedCurrentDate)
                ->where('type', '=', 'People Engaged')
                ->select('social_media_id', 'activity_date', DB::raw('sum(count) as total'))
                ->groupBy('activity_date', 'social_media_id')->get()->toArray();
            if (empty($historical_page_people_engaged)) {
                return $this->helpReturn("No People Engaged Found.");
            }

            $dateFormat = dateFormatUsing();

            foreach ($historical_page_people_engaged as $peopleengaged) {

                $peopleEngagedDate = getFormattedDate($peopleengaged['activity_date']);
                $appendPeopleEngagedArray[] = [
                    'social_media_id' => $peopleengaged['social_media_id'],
                    'activity_date' => $peopleEngagedDate,
                    'site_type' => 'Facebook',
                    'count' => $peopleengaged['total'],
                    'type' => 'PE',
                ];
            }

            StatTracking::where('social_media_id', $socialMediaId)->delete();
            StatTracking::insert($appendReviewArray); //for  Review
            StatTracking::insert($appendRatingArray); //for  Rating
            StatTracking::insert($appendLikesArray); //for  Likes
            StatTracking::insert($appendPostsArray); //for  Posts
            StatTracking::insert($appendPageViewsArray); //for  Page Views
            StatTracking::insert($appendPageTotalReachArray); //for Page Total Reach
            StatTracking::insert($appendPeopleEngagedArray); //for Page People Engaged
            $finalArray[] = [
                'reviews' => $appendReviewArray,
                'ratings' => $appendRatingArray,
                'likes' => $appendLikesArray,
                'posts' => $appendPostsArray,
                'views' => $appendPageViewsArray,
                'total reach' => $appendPageTotalReachArray,
                'people engaged' => $appendPeopleEngagedArray,
            ];

            return $this->helpReturn("Get Stats Count Update Cron Job.", $finalArray);
        } catch (Exception $e) {
            Log::info("countFacebookReviewRating " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getAllStatsCount($request)
    {
        try {
            $userData = $this->sessionService->getAuthUserSession();

            $graphStatsQuery = StatTracking::where('user_id', $userData['id'])->where('type', 'RV');

            $last_twelve_month_ary = $salesTotalAry = [];
            $varCounter = 0;
            for ($g = 5; $g > -1; $g--){
                $varCounter++;
                $bar_year = date("Y", strtotime("-$g months"));
                $bar_month = date("m", strtotime("-$g months"));

                ${'standard_query_'.$varCounter} = clone $graphStatsQuery;

                //prepare condition
                $data = ${'standard_query_'.$varCounter}->whereMonth('activity_date', '=', $bar_month)->whereYear('activity_date', '=', $bar_year)->sum('count');

                $last_twelve_month_ary[$varCounter]['activity_date'] = date("M Y", strtotime("-$g months"));
                $last_twelve_month_ary[$varCounter]['count'] = (int)$data;
            }

            return $this->helpReturn("Dashboard Widget and Graph Stats.", $last_twelve_month_ary);
        }
        catch (Exception $e) {
            Log::info("getAllStatsCount " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }

    public function getGraphStatsCount($request)
    {
        try {
            $businessObj = new BusinessEntity();
            $businessResult = $businessObj->userSelectedBusiness();

//            print_r($businessResult);
//            exit;

            $businessResult = $businessResult['records'];
            $businessId = $businessResult['business_id'];
            $userId = $businessResult['user_id'];

            $user = Users::where('id', $userId)->get()->toArray();

//            print_r($user);
//            exit;

            $types = $request->get('type');

            if (!is_array($types)) {
                $types = [
                    [
                        'type' => $types,
                        'is_type' => !empty($request->get('is_type')) ? $request->get('is_type') : 'day',
                        'category_type' => !empty($request->get('category_type')) ? $request->get('category_type') : 'day',
                    ]
                ];
            }

            $statusData = [];
            $i = 0;
//            $objectiveManager = new MarketingObjectiveEntity();
            $objective = '';
            $categoryHeading = '';

            foreach ($types as $type) {
                $currentType = strtolower($type['type']);
                $reviewsType = strtolower($type['is_type']);
                $category_type = $request->get('category_type');

                if (strtoupper($category_type) == 'RV') {
                    $categoryHeading = 'Reviews';
                } elseif (strtoupper($category_type) == 'LK') {
                    $categoryHeading = 'Likes';
                } elseif (strtoupper($category_type) == 'RG') {
                    $categoryHeading = 'Rating';
                } elseif (strtoupper($category_type) == 'PV') {
                    $categoryHeading = 'Page View';
                }

                $typeRequested = str_replace('-', ' ', ucfirst($currentType));

                if ($typeRequested == 'Facebook') {
                    $thirdPartyResult = SocialMediaMaster::where(
                        [
                            'business_id' => $businessId,
                            'type' => $typeRequested
                        ]
                    )->first();
                }
                elseif ($typeRequested == 'Googleanalytics' || $typeRequested == 'Google analytics') {
                    if ($typeRequested == 'Google analytics') {
                        $typeRequested = 'Googleanalytics';
                    }

                    $thirdPartyResult = GoogleAnalyticsMaster::where(
                        [
                            'business_id' => $businessId,
                        ]
                    )->first();
                }
                else if ($typeRequested == 'Crm') {

                    $thirdPartyResult = Recipient::where(
                        [
                            'user_id' => $userId,
                            //'type' => $typeRequested
                        ]
                    )->first();
                }
                else {
                    $thirdPartyResult = TripadvisorMaster::where(
                        [
                            'business_id' => $businessId,
                            'type' => $typeRequested
                        ]
                    )->first();
                }

//                print_r($thirdPartyResult);
//                exit;

                if (!empty($thirdPartyResult['name']) || !empty($thirdPartyResult['email'])) {
                    $dateFormat = dateFormatUsing();

                    $timeZone = 'UTC';
//                    print_r(Carbon::now());
//                    exit;
//                    $currentDate = isset($request->start_date) ? $request->start_date : Carbon::now($user->time_zone);
                    $currentDate = isset($request->start_date) ? $request->start_date : Carbon::now();
                    $yesterdayDate = Carbon::yesterday($timeZone);

//                    print_r($currentDate);
//                    exit;
                    $formattedCurrentDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format($dateFormat);
                    $formattedYesterdayDate = Carbon::createFromFormat('Y-m-d H:i:s', $yesterdayDate)->format($dateFormat);
                    $formattedWeekDate = '';

                    if ($reviewsType == 'week') {

//                        echo "in";
//                        exit;
                        $weekDate = isset($request->end_date) ? $request->end_date : Carbon::now($timeZone)->subDays(6);

//                        print_r($weekDate);
//                        exit;
                        //$lastWeekDate = isset($request->end_date) ? Carbon::createFromFormat('Y-m-d H:i:s', $request->end_date)->subDays(6)->format($dateFormat) : Carbon::now($user->time_zone)->subDays(13);
                        $lastWeekDate = isset($request->end_date) ? Carbon::createFromFormat('Y-m-d H:i:s', $request->end_date)->subDays(6)->format($dateFormat) : (isset($request->from) && $request->from == 'cronjob' ? Carbon::now($timeZone)->subDays(12) : Carbon::now($timeZone)->subDays(13));
                        $formattedWeekDate = Carbon::createFromFormat('Y-m-d H:i:s', $weekDate)->format($dateFormat);

//                        print_r($formattedWeekDate);
//                        exit;

                        $formattedLastWeekDate = isset($request->end_date) ?  Carbon::createFromFormat('Y-m-d H:i:s', $lastWeekDate.'00:00:00')->format($dateFormat) :  Carbon::createFromFormat('Y-m-d H:i:s', $lastWeekDate)->format($dateFormat);

                        $weekDates = extractWeekDays($formattedWeekDate);

//                        print_r($weekDates);
//                        exit;
                        $lastWeekDates = extractWeekDays($formattedLastWeekDate);
                    }

//                    print_r($weekDates);
//                    echo "out";
//                    exit;
                    $graphStatsQuery = StatTracking::where(function ($q) use ($typeRequested, $thirdPartyResult,$user) {
                        if ($typeRequested == 'Facebook') {
                            $q->where('social_media_id', $thirdPartyResult['id']);
                        }
                        else if ($typeRequested == 'Googleanalytics') {
                            $q->where('google_analytics_id', $thirdPartyResult['id']);
                        } else if ($typeRequested == 'Crm') {
                            $q->where('user_id', $user['id']);
                        }
                        else {

                            $q->where('third_party_id', $thirdPartyResult['third_party_id']);
                        }
                    })->where('type', $category_type)->where('site_type', $typeRequested);
//log::info('$graphStatsQuery');
//log::info($graphStatsQuery->Array());
                    $graphStatsSelection = '';
                    if ($reviewsType == 'week' || $reviewsType == 'day') {
                        $graphStatsSelection = clone $graphStatsQuery;
                    }

                    $graphStatsQuery->where(function ($query) use ($reviewsType, $formattedCurrentDate, $formattedWeekDate) {
                        if ($reviewsType == 'week') {
                            $query->where('activity_date', '<=', $formattedCurrentDate);
                            $query->where('activity_date', '>=', $formattedWeekDate);
                        } elseif ($reviewsType == 'day') {
                            $query->where('activity_date', '=', $formattedCurrentDate);
                        } else if ($reviewsType == 'all') {
                            $query->where('activity_date', '<=', $formattedCurrentDate);
                        }
                    });

                    $graphStats = $graphStatsQuery->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                    $insightData = [];

                    /**
                     * review request must not be all and widget category type is not be Reviews, likes..
                     */
                    if (!($reviewsType == 'all' && ($category_type == 'RV' || $category_type == 'LK'))) {
//                        $objectiveData = $objectiveManager->getObjectiveQuery($currentType, $categoryHeading);
//
//                        if (!empty($objectiveData)) {
//                            $objective = $objectiveData['id'];
//                        }
                    }

                    if ($reviewsType == 'all' && $category_type == 'RV') {
                        if ($typeRequested == 'Facebook') {
                            $counts = $thirdPartyResult['page_reviews_count'];
                        } else {
                            $counts = $thirdPartyResult['review_count'];
                        }
                    }
                    elseif ($reviewsType == 'all' && $category_type == 'LK') {
                        $counts = $thirdPartyResult['page_likes_count'];
                    }
                    elseif ($reviewsType == 'all' && $category_type == 'RG') {
                        $counts = $thirdPartyResult['average_rating'];
                        $insightData = insightTitle($counts, '', '', $category_type, $objective);
                    }
                    elseif ($category_type == 'RG') {
                        $counts = $graphStatsQuery->avg('count');
                        /*******new code for weekly email send**********/
                        $lastCounts = 0;
//                        echo "\n";
//                        echo "formattedLastWeekDate $formattedLastWeekDate";
//                        echo "\n";
                        // comparison of week with last week
                        /***************** Part to cover Last week & today-yesterday case *****************************/
                        if ($reviewsType == 'week') {
                            $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                                $query->where('activity_date', '<', $formattedWeekDate);
                                $query->where('activity_date', '>=', $formattedLastWeekDate);
                            });
                        }
                        elseif ($reviewsType == 'day') {
                            $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                                $query->where('activity_date', '=', $formattedYesterdayDate);
                            });
                        }

                        if (!empty($graphStatsSelection)) {
                            $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                        }

                        $lastCounts = $graphStatsSelection->avg('count');

//                        echo "count $counts";
//                        echo "\n";
//                        echo "lastCounts $lastCounts";
//                        echo "\n";
//                        echo "reviewsType $reviewsType";
//                        echo "\n";
//                        echo "category_type $category_type";
//                        echo "\n";
//                        echo "objective $objective";
//                        echo "\n";
                        /***************** Part to cover Last week & today-yesterday case *****************************/
//                        print_r($insightData);
//                        exit;




                        /*******new code for weekly email**********/
                        $counts = round($counts, 1);

                        $insightData = insightTitle($counts, $lastCounts, '', $category_type, $objective);


                    }
                    elseif ($category_type == 'PV') {

                        $counts = $graphStatsQuery->sum('count');
                        $lastCounts = 0;

                        if ($reviewsType == 'day') {
                            $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                                $query->where('activity_date', '=', $formattedYesterdayDate);
                            });

                            if (!empty($graphStatsSelection)) {
                                $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                            }

                            $lastCounts = $graphStatsSelection->sum('count');
                        }

                        $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                    } /**
                     * New Code Add For Facebook Related Counts
                     */
                    elseif ($category_type == 'FP') {

                        $counts = $graphStatsQuery->sum('count');
                        $lastCounts = 0;
                        if ($reviewsType == 'week') {
                            $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                                $query->where('activity_date', '<', $formattedWeekDate);
                                $query->where('activity_date', '>=', $formattedLastWeekDate);
                            });
                        }
                        elseif ($reviewsType == 'day') {
                            $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                                $query->where('activity_date', '=', $formattedYesterdayDate);
                            });
                        }

                        if (!empty($graphStatsSelection)) {
                            $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                        }

                        $lastCounts = $graphStatsSelection->sum('count');
                        $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                    }elseif ($category_type == 'PA') {

                        $counts = $graphStatsQuery->sum('count');
                        $lastCounts = 0;
                        if ($reviewsType == 'week') {
                            $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                                $query->where('activity_date', '<', $formattedWeekDate);
                                $query->where('activity_date', '>=', $formattedLastWeekDate);
                            });
                        }
                        elseif ($reviewsType == 'day') {
                            $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                                $query->where('activity_date', '=', $formattedYesterdayDate);
                            });
                        }

                        if (!empty($graphStatsSelection)) {
                            $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                        }

                        $lastCounts = $graphStatsSelection->sum('count');
                        $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                    }elseif ($category_type == 'TR') {

                        $counts = $graphStatsQuery->sum('count');
                        $lastCounts = 0;
                        if ($reviewsType == 'week') {
                            $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                                $query->where('activity_date', '<', $formattedWeekDate);
                                $query->where('activity_date', '>=', $formattedLastWeekDate);
                            });
                        }
                        elseif ($reviewsType == 'day') {
                            $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                                $query->where('activity_date', '=', $formattedYesterdayDate);
                            });
                        }

                        if (!empty($graphStatsSelection)) {
                            $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                        }

                        $lastCounts = $graphStatsSelection->sum('count');
                        $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                    }
                    /********New Code For CUSTOMER*******/
                    elseif ($category_type == 'CU') {

                        $counts = $graphStatsQuery->sum('count');
                        $lastCounts = 0;
                        if ($reviewsType == 'week') {
                            $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                                $query->where('activity_date', '<', $formattedWeekDate);
                                $query->where('activity_date', '>=', $formattedLastWeekDate);
                            });
                        }
                        elseif ($reviewsType == 'day') {
                            $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                                $query->where('activity_date', '=', $formattedYesterdayDate);
                            });
                        }

                        if (!empty($graphStatsSelection)) {
                            $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                        }

                        $lastCounts = $graphStatsSelection->sum('count');
                        $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                    }
                    elseif ($category_type == 'RR') {

                        $counts = $graphStatsQuery->sum('count');
                        $lastCounts = 0;
                        if ($reviewsType == 'week') {
                            $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                                $query->where('activity_date', '<', $formattedWeekDate);
                                $query->where('activity_date', '>=', $formattedLastWeekDate);
                            });
                        }
                        elseif ($reviewsType == 'day') {
                            $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                                $query->where('activity_date', '=', $formattedYesterdayDate);
                            });
                        }

                        if (!empty($graphStatsSelection)) {
                            $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                        }

                        $lastCounts = $graphStatsSelection->sum('count');
                        $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                    }
                    elseif ($category_type == 'SP') {

                        $counts = $graphStatsQuery->sum('count');
                        $lastCounts = 0;
                        if ($reviewsType == 'week') {
                            $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                                $query->where('activity_date', '<', $formattedWeekDate);
                                $query->where('activity_date', '>=', $formattedLastWeekDate);
                            });
                        }
                        elseif ($reviewsType == 'day') {
                            $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                                $query->where('activity_date', '=', $formattedYesterdayDate);
                            });
                        }

                        if (!empty($graphStatsSelection)) {
                            $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                        }

                        $lastCounts = $graphStatsSelection->sum('count');
                        $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                    }elseif ($category_type == 'EP') {

                        $counts = $graphStatsQuery->sum('count');
                        $lastCounts = 0;
                        if ($reviewsType == 'week') {
                            $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                                $query->where('activity_date', '<', $formattedWeekDate);
                                $query->where('activity_date', '>=', $formattedLastWeekDate);
                            });
                        }
                        elseif ($reviewsType == 'day') {
                            $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                                $query->where('activity_date', '=', $formattedYesterdayDate);
                            });
                        }

                        if (!empty($graphStatsSelection)) {
                            $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                        }

                        $lastCounts = $graphStatsSelection->sum('count');
                        $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                    }
                    elseif ($category_type == 'PE') {

                        $counts = $graphStatsQuery->sum('count');
                        $lastCounts = 0;
                        if ($reviewsType == 'week') {
                            $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                                $query->where('activity_date', '<', $formattedWeekDate);
                                $query->where('activity_date', '>=', $formattedLastWeekDate);
                            });
                        }
                        elseif ($reviewsType == 'day') {
                            $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                                $query->where('activity_date', '=', $formattedYesterdayDate);
                            });
                        }

                        if (!empty($graphStatsSelection)) {
                            $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                        }

                        $lastCounts = $graphStatsSelection->sum('count');
                        $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                    }
                    //new addition for weekly email senting
                    elseif ($category_type == 'RV' || $category_type == 'LK') {
                        $counts = $graphStatsQuery->sum('count');

//                        echo "\n";
//                        echo "formattedLastWeekDate $formattedLastWeekDate";
//                        echo "\n";
                        // comparison of week with last week
                        /***************** Part to cover Last week & today-yesterday case *****************************/
                        if ($reviewsType == 'week') {
                            $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                                $query->where('activity_date', '<', $formattedWeekDate);
                                $query->where('activity_date', '>=', $formattedLastWeekDate);
                            });
                        }
                        elseif ($reviewsType == 'day') {
                            $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                                $query->where('activity_date', '=', $formattedYesterdayDate);
                            });
                        }

                        if (!empty($graphStatsSelection)) {
                            $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                        }

                        $lastCounts = $graphStatsSelection->sum('count');
//                        echo "count $counts";
//                        echo "\n";
//                        echo "lastCounts $lastCounts";
//                        echo "\n";
//                        echo "reviewsType $reviewsType";
//                        echo "\n";
//                        echo "category_type $category_type";
//                        echo "\n";
//                        echo "objective $objective";
//                        echo "\n";
                        $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                        log::info('$insightData');
                        log::info($insightData);
                        /***************** Part to cover Last week & today-yesterday case *****************************/
//                        print_r($insightData);
//                        exit;
                    }

                    if ($reviewsType == 'week') {
                        if (!empty($graphStats)) {
                            foreach ($graphStats as $row) {
                                $activityDate = $row['activity_date'];
                                $key = array_search($activityDate, array_column($weekDates, 'activity_date'));

                                if (isset($weekDates[$key]['activity_date']) && $activityDate == $weekDates[$key]['activity_date']) {
                                    $weekDates[$key]['count'] = $row['count'];
                                }
                            }
                        }

                        $graphStats = $weekDates;
                    } else {
                        // if graph stats is empty then show data with current date 0
                        if (empty($graphStats)) {
                            $graphStats[0]['activity_date'] = $formattedCurrentDate;
                            $graphStats[0]['count'] = 0;
                        }
                    }

                    if (empty($insightData)) {
                        $insightData = [
                            'objective' => '',
                            'insightTitle' => '',
                            'insightDescription' => '',
                            'insightStatus' => '',
                        ];
                    }
                    $statusData[$i] = $insightData;
                    $statusData[$i]['type'] = $currentType;
                    $statusData[$i]['name'] = $thirdPartyResult['name'];
                    $statusData[$i]['last_count'] = isset($lastCounts) ? $lastCounts : 0;

                    if (!empty($thirdPartyResult['website'])) {
                        $statusData[$i]['website'] = $thirdPartyResult['website'];
                    }

                    if ($typeRequested == 'Googleanalytics') {
                        $statusData[$i]['typeTitle'] = 'Google analytics';
                    } else {
                        $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
                    }
                    $statusData[$i]['count'] = $counts;
                    $statusData[$i]['graph_data'] = $graphStats;


                    if($request['flag'] == 'email'){ //this check use for weekly email function
                        $newNumber = $counts;
                        $originalNumber = $lastCounts;
                        if($counts == 0 && $lastCounts == 0){
                            $increase = 'No Activity';
                        }else {

                            $increase = $newNumber - $originalNumber;
                            if ($originalNumber == 0) {
                                $originalNumber = 1;
                            }
                            $increase = $increase / $originalNumber * 100;
                            $increase = round($increase, 2);
                        }
                        $statusData[$i] = [
                            'type' => $currentType,
                            'count' => $counts,
                            'previouse_count' => $lastCounts,
                            'trend' => $increase,
                        ];
                    }

                }
                else {
                    $statusData[$i]['type'] = $currentType;
                    $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
                    $statusData[$i]['message'] = ucwords(strtolower($typeRequested)) . ' not connected';
                    $statusData[$i]['status'] = 'not_connected';

                    $url = config::get('custom.webAppDomain');

                    if($request['flag'] == 'email') { //this check use for weekly email function
                        $statusData[$i]['type'] = $currentType;
                        $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
                        $statusData[$i]['message'] = ucwords(strtolower($typeRequested)) . ' is not connected with your Nichepractice account. <a href='.$url.'>Login</a> to NichePractice to connect.';

                    }

                }

                $i++;
            }

            return $this->helpReturn("Dashboard Widget and Graph Stats.", $statusData);
        } catch (Exception $e) {
            Log::info("getGraphStatsCount " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }
//
//    public function getGraphStatsCount($request)
//    {
//        try {
//            $businessObj = new BusinessEntity();
//            $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();
//
//            // user is not found.
//            if ($checkPoint['_metadata']['outcomeCode'] != 200) {
//                return $checkPoint;
//            }
//
//            $user = $checkPoint['records'];
//            $businessResult = $businessObj->userSelectedBusiness($user);
//
//            if ($businessResult['_metadata']['outcomeCode'] != 200) {
//                return $this->helpError(1, 'Problem in selection of user business.');
//            }
//
//            $businessResult = $businessResult['records'];
//
//            $types = $request->get('type');
//
//            if (!is_array($types)) {
//                $types = [
//                    [
//                        'type' => $types,
//                        'is_type' => !empty($request->get('is_type')) ? $request->get('is_type') : 'day',
//                        'category_type' => !empty($request->get('category_type')) ? $request->get('category_type') : 'day',
//                    ]
//                ];
//            }
//
//            $statusData = [];
//            $i = 0;
//            $objectiveManager = new MarketingObjectiveEntity();
//            $objective = '';
//            $categoryHeading = '';
//
//            foreach ($types as $type) {
//                $currentType = strtolower($type['type']);
//                $reviewsType = strtolower($type['is_type']);
//                $category_type = $request->get('category_type');
//
//                if (strtoupper($category_type) == 'RV') {
//                    $categoryHeading = 'Reviews';
//                } elseif (strtoupper($category_type) == 'LK') {
//                    $categoryHeading = 'Likes';
//                } elseif (strtoupper($category_type) == 'RG') {
//                    $categoryHeading = 'Rating';
//                } elseif (strtoupper($category_type) == 'PV') {
//                    $categoryHeading = 'Page View';
//                }
//
//                $typeRequested = str_replace('-', ' ', ucfirst($currentType));
//
//                if ($typeRequested == 'Facebook') {
//                    $thirdPartyResult = SocialMediaMaster::where(
//                        [
//                            'business_id' => $businessResult['business_id'],
//                            'type' => $typeRequested
//                        ]
//                    )->first();
//                } elseif ($typeRequested == 'Googleanalytics' || $typeRequested == 'Google analytics') {
//                    if ($typeRequested == 'Google analytics') {
//                        $typeRequested = 'Googleanalytics';
//                    }
//
//                    $thirdPartyResult = GoogleAnalyticsMaster::where(
//                        [
//                            'business_id' => $businessResult['business_id'],
//                        ]
//                    )->first();
//                } else {
//                    $thirdPartyResult = TripadvisorMaster::where(
//                        [
//                            'business_id' => $businessResult['business_id'],
//                            'type' => $typeRequested
//                        ]
//                    )->first();
//                }
//
//                if (!empty($thirdPartyResult['name'])) {
//                    $dateFormat = dateFormatUsing();
//                    $currentDate = Carbon::now($user->time_zone);
//                    $yesterdayDate = Carbon::yesterday($user->time_zone);
//
//                    $formattedCurrentDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format($dateFormat);
//                    $formattedYesterdayDate = Carbon::createFromFormat('Y-m-d H:i:s', $yesterdayDate)->format($dateFormat);
//                    $formattedWeekDate = '';
//
//                    if ($reviewsType == 'week') {
//                        $weekDate = Carbon::now($user->time_zone)->subDays(6);
//                        $lastWeekDate = Carbon::now($user->time_zone)->subDays(13);
//
//                        $formattedWeekDate = Carbon::createFromFormat('Y-m-d H:i:s', $weekDate)->format($dateFormat);
//                        $formattedLastWeekDate = Carbon::createFromFormat('Y-m-d H:i:s', $lastWeekDate)->format($dateFormat);
//
//                        $weekDates = extractWeekDays($formattedWeekDate);
//                        $lastWeekDates = extractWeekDays($formattedLastWeekDate);
//                    }
//
//                    $graphStatsQuery = StatTracking::where(function ($q) use ($typeRequested, $thirdPartyResult) {
//                        if ($typeRequested == 'Facebook') {
//                            $q->where('social_media_id', $thirdPartyResult['id']);
//                        } else if ($typeRequested == 'Googleanalytics') {
//                            $q->where('google_analytics_id', $thirdPartyResult['id']);
//                        } else {
//                            $q->where('third_party_id', $thirdPartyResult['third_party_id']);
//                        }
//                    })->where('type', $category_type)->where('site_type', $typeRequested);
//
//                    $graphStatsSelection = '';
//                    if ($reviewsType == 'week' || $reviewsType == 'day') {
//                        $graphStatsSelection = clone $graphStatsQuery;
//                    }
//
//                    $graphStatsQuery->where(function ($query) use ($reviewsType, $formattedCurrentDate, $formattedWeekDate) {
//                        if ($reviewsType == 'week') {
//                            $query->where('activity_date', '<=', $formattedCurrentDate);
//                            $query->where('activity_date', '>=', $formattedWeekDate);
//                        } elseif ($reviewsType == 'day') {
//                            $query->where('activity_date', '=', $formattedCurrentDate);
//                        } else if ($reviewsType == 'all') {
//                            $query->where('activity_date', '<=', $formattedCurrentDate);
//                        }
//                    });
//
//                    $graphStats = $graphStatsQuery->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
//
//                    $insightData = [];
//
//                    /**
//                     * review request must not be all and widget category type is not be Reviews, likes..
//                     */
//                    if (!($reviewsType == 'all' && ($category_type == 'RV' || $category_type == 'LK'))) {
//                        $objectiveData = $objectiveManager->getObjectiveQuery($currentType, $categoryHeading);
//
//                        if (!empty($objectiveData)) {
//                            $objective = $objectiveData['id'];
//                        }
//                    }
//
//                    if ($reviewsType == 'all' && $category_type == 'RV') {
//                        if ($typeRequested == 'Facebook') {
//                            $counts = $thirdPartyResult['page_reviews_count'];
//                        } else {
//                            $counts = $thirdPartyResult['review_count'];
//                        }
//                    } elseif ($reviewsType == 'all' && $category_type == 'LK') {
//                        $counts = $thirdPartyResult['page_likes_count'];
//                    } elseif ($reviewsType == 'all' && $category_type == 'RG') {
//                        $counts = $thirdPartyResult['average_rating'];
//                        $insightData = insightTitle($counts, '', '', $category_type, $objective);
//                    } elseif ($category_type == 'RG') {
//                        $counts = $graphStatsQuery->avg('count');
//                        $counts = round($counts, 1);
//                        $insightData = insightTitle($counts, '', '', $category_type, $objective);
//                    } elseif ($category_type == 'PV') {
//                        $counts = $graphStatsQuery->sum('count');
//                        $lastCounts = 0;
//
//                        if ($reviewsType == 'day') {
//                            $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
//                                $query->where('activity_date', '=', $formattedYesterdayDate);
//                            });
//
//                            if (!empty($graphStatsSelection)) {
//                                $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
//                            }
//
//                            $lastCounts = $graphStatsSelection->sum('count');
//                        }
//
//                        $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
//                    } elseif ($category_type == 'RV' || $category_type == 'LK') {
//                        $counts = $graphStatsQuery->sum('count');
//
//                        // comparison of week with last week
//                        /****************** Part to cover Last week & today-yesterday case ******************************/
//                        if ($reviewsType == 'week') {
//                            $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
//                                $query->where('activity_date', '<', $formattedWeekDate);
//                                $query->where('activity_date', '>=', $formattedLastWeekDate);
//                            });
//                        } elseif ($reviewsType == 'day') {
//                            $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
//                                $query->where('activity_date', '=', $formattedYesterdayDate);
//                            });
//                        }
//
//                        if (!empty($graphStatsSelection)) {
//                            $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
//                        }
//
//                        $lastCounts = $graphStatsSelection->sum('count');
//                        $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
//
//                        /****************** Part to cover Last week & today-yesterday case ******************************/
//                    }
//
//                    if ($reviewsType == 'week') {
//                        if (!empty($graphStats)) {
//                            foreach ($graphStats as $row) {
//                                $activityDate = $row['activity_date'];
//                                $key = array_search($activityDate, array_column($weekDates, 'activity_date'));
//
//                                if (isset($weekDates[$key]['activity_date']) && $activityDate == $weekDates[$key]['activity_date']) {
//                                    $weekDates[$key]['count'] = $row['count'];
//                                }
//                            }
//                        }
//
//                        $graphStats = $weekDates;
//                    } else {
//                        // if graph stats is empty then show data with current date 0
//                        if (empty($graphStats)) {
//                            $graphStats[0]['activity_date'] = $formattedCurrentDate;
//                            $graphStats[0]['count'] = 0;
//                        }
//                    }
//
//                    if (empty($insightData)) {
//                        $insightData = [
//                            'objective' => '',
//                            'insightTitle' => '',
//                            'insightDescription' => '',
//                            'insightStatus' => '',
//                        ];
//                    }
//                    $statusData[$i] = $insightData;
//                    $statusData[$i]['type'] = $currentType;
//                    $statusData[$i]['name'] = $thirdPartyResult['name'];
//
//                    if (!empty($thirdPartyResult['website'])) {
//                        $statusData[$i]['website'] = $thirdPartyResult['website'];
//                    }
//
//                    if ($typeRequested == 'Googleanalytics') {
//                        $statusData[$i]['typeTitle'] = 'Google analytics';
//                    } else {
//                        $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
//                    }
//                    $statusData[$i]['count'] = $counts;
//                    $statusData[$i]['graph_data'] = $graphStats;
//                } else {
//                    $statusData[$i]['type'] = $currentType;
//                    $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
//                    $statusData[$i]['message'] = ucwords(strtolower($typeRequested)) . ' not connected';
//                }
//                $i++;
//            }
//
//            return $this->helpReturn("Dashboard Widget and Graph Stats.", $statusData);
//        } catch (Exception $e) {
//            Log::info("getGraphStatsCount " . $e->getMessage());
//            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
//        }
//    }

    public function updateThirdPartyReviewRating($request)
    {
        try
        {
            $tripEntity = new TripAdvisorEntity();
            $yelpEntity = new YelpEntity();
            $googleEntity = new GooglePlaceEntity();
            $allBusiness = Business::select('business_id')->get();
            $thirdPartyData = TripadvisorMaster::select('page_url', 'business_id', 'type')
                ->whereIn('business_id', $allBusiness)
                ->get()->toArray();

            foreach ($thirdPartyData as $row)
            {
                if (strtolower($row['type']) == 'yelp')
                {
                    $result = $yelpEntity->getBusinessUrlHistoricalDetail($row['page_url']);
                }
                else if (strtolower($row['type']) == 'tripadvisor')
                {
                    $result = $tripEntity->getBusinessUrlHistoricalDetail($row['page_url']);
                }
                else if (strtolower($row['type']) == 'google places')
                {
                    $result = $googleEntity->getBusinessUrlHistoricalDetail($row['page_url']);
                }

                if ($result['_metadata']['outcomeCode'] == 200)
                {
                    if ($row['type'] == 'google places')
                    {
                        $rating = $result['records']['Rating'];
                        $review = $result['records']['Review'];
                    }
                    else
                    {
                        $rating = $result['records']['Results']['Rating'];
                        $review = $result['records']['Results']['Review'];
                    }

                    TripadvisorMaster::where('business_id', $row['business_id'])
                        ->where('type', $row['type'])
                        ->update(['review_count' => $review, 'average_rating' => $rating]);
                }
            }
            return $this->helpReturn("Update Reviews and Rating Cron Job Processed.");
        }
        catch (Exception $e)
        {
            Log::info(" updateThirdPartyReviewRating > " . $e->getMessage());
            return $this->helpError(1, 'Some Problem happened Please Try Again.');
        }
    }

    public function updateAddReviewUrl($request)
    {
        try {
            $tripEntity = new TripAdvisorEntity();
            $yelpEntity = new YelpEntity();
            $googleEntity = new GooglePlaceEntity();
            $allBusiness = Business::select('business_id')->get();
            $thirdPartyData = TripadvisorMaster::select('page_url', 'business_id', 'type')
                ->whereIn('business_id', $allBusiness)
                ->get()->toArray();

            foreach ($thirdPartyData as $row) {
                if (strtolower($row['type']) == 'yelp') {
                    $result = $yelpEntity->getBusinessUrlHistoricalDetail($row['page_url']);
                } else if (strtolower($row['type']) == 'tripadvisor') {
                    $result = $tripEntity->getBusinessUrlHistoricalDetail($row['page_url']);
                } else if (strtolower($row['type']) == 'google places') {
                    $result = $googleEntity->getBusinessUrlHistoricalDetail($row['page_url']);
                }

                if ($result['_metadata']['outcomeCode'] == 200) {
                    if ($row['type'] == 'google places') {
                        $reviewUrl = $result['records']['AddReviewURL'];
                    } else {
                        $reviewUrl = $result['records']['Results']['AddReviewURL'];
                    }

                    TripadvisorMaster::where('business_id', $row['business_id'])
                        ->where('type', $row['type'])
                        ->update(['add_review_url' => $reviewUrl]);
                }
            }
            return $this->helpReturn("Update Add Review URL is processed");
        } catch (Exception $e) {
            Log::info("updateAddReviewUrl > " . $e->getMessage());
            return $this->helpError(1, 'Some Problem happened Please Try Again.');
        }
    }


    public function updateBusinessIssuesTask($request)
    {

        Log::info('inside business issues');

        try {
            $tripEntity = new TripAdvisorEntity();
            $yelpEntity = new YelpEntity();
            $googleEntity = new GooglePlaceEntity();

            $thirdPartyEntity = new ThirdPartyEntity();
            $allBusiness = Business::select('business_id')->get();

            $thirdPartyData = DB::table('business_master as bm')
                ->join('third_party_master as tpm', 'bm.business_id', '=', 'tpm.business_id')
                ->join('user_master as usm', 'bm.user_id', '=', 'usm.id')
                ->where('bm.business_id', 48)
                //->whereIn('bm.business_id', $allBusiness)
                ->where('tpm.is_manual_deleted', 0)
                ->where('bm.business_profile_status', 'completed')
                ->select('bm.user_id', 'bm.business_id', 'bm.name as ThirdPartyBusinessName', 'third_party_id', 'page_url','tpm.phone','tpm.street', 'type')
                ->orderby('tpm.business_id')
                ->get()->toArray();


            if (!empty($thirdPartyData)) {
                foreach ($thirdPartyData as $row) {
                    $type = $row->type;
                    if ($type == 'Yelp') {
                        $result = $yelpEntity->getBusinessUrlHistoricalDetail($row->page_url);
                    }
                    else if ($type == 'Tripadvisor')
                    {
                        $result = $tripEntity->getBusinessUrlHistoricalDetail($row->page_url);
                    }
                    else if ($type == 'Google Places') {
                        $result = $googleEntity->getBusinessUrlHistoricalDetail($row->page_url);
                    }

                    if ($result['_metadata']['outcomeCode'] == 200)
                    {

                        $records = $result['records']['Results'];
                        $phone = $records['ContactNo'];
                        $address = $records['Address'];
                        $website = $records['Website'];

                        TripadvisorMaster::where('business_id', $row->business_id)
                            ->where('type', $row->type)
                            ->update(['phone' => $phone,
                                'street' => $address,
                                'website'=>$website
                            ]);
                        Log::info('inside 200');
                        if ($type == 'Yelp') {
                            Log::info('inside yelp');
                            $issueData = [
                                [
                                    'key' => 'phone',
                                    'value' => $phone,
                                    'issue' => ($phone != '') ? 13 : 43,
                                    'oldIssue' => ($phone == '') ? 13 : 43
                                ],

                                [
                                    'key' => 'address',
                                    'value' => $address,
                                    'issue' => ($address != '') ? 14 : 45,
                                    'oldIssue' => ($address == '') ? 14 : 45
                                ],
                                [
                                    'key' => 'website',
                                    'value' => $website,
                                    'issue' => ($website != '') ? 15 : 44,
                                    'oldIssue' => ($website == '') ? 15 : 44
                                ]

                            ];
                        }
                        else if($type == 'Tripadvisor')
                        {
                            Log::info('inside Tripadvisor');
                            $issueData = [
                                [
                                    'key' => 'phone',
                                    'value' => $phone,
                                    'issue' => ($phone != '') ? 4 : 40,
                                    'oldIssue' => ($phone == '') ? 4 : 40
                                ],
                                [
                                    'key' => 'address',
                                    'value' => $address,
                                    'issue' => ($address != '') ? 5 : 42,
                                    'oldIssue' => ($address == '') ? 5 : 42
                                ],
                                [
                                    'key' => 'website',
                                    'value' => $website,
                                    'issue' => ($website != '') ? 6 : 41,
                                    'oldIssue' => ($website == '') ? 6 : 41
                                ]
                            ];
                        }
                        else if($type == 'Google Places')
                        {
                            Log::info('inside Google Places');
                            $issueData = [
                                [
                                    'key' => 'phone',
                                    'value' => $phone,
                                    'issue' => ($phone != '') ? 7 : 46,
                                    'oldIssue' => ($phone == '') ? 7 : 46
                                ],
                                [
                                    'key' => 'address',
                                    'value' => $address,
                                    'issue' => ($address != '') ? 8 : 48,
                                    'oldIssue' => ($address == '') ? 8 : 48
                                ],
                                [
                                    'key' => 'website',
                                    'value' => $website,
                                    'issue' => ($website != '') ? 9 : 47,
                                    'oldIssue' => ($website == '') ? 9 : 47
                                ]
                            ];
                        }

                        $thirdPartyEntity->globalIssueGenerator($row->user_id, $row->business_id, $row->third_party_id, $issueData, $row->type, 'local');

                    }

                }
                return $this->helpReturn("Third Party Business Issues/Task Updated.");

            }

        }

        catch (Exception $e) {
            Log::info(" updateBusinessIssuesTask > " . $e->getMessage());
            return $this->helpError(1, 'Some Problem happened Please Try Again.');
        }
    }

    /**
     * When this call has to re-open and any working required we've to link some Internal functions
     * to new scrapper api functions (getBusinessListed)
     * @param $request
     * @return mixed
     */
    public function automateBusinessListing($request)
    {
        try {
            $tripEntity = new TripAdvisorEntity();

            $thirdPartyEntity = new ThirdPartyEntity();
            $yelpEntity = new YelpEntity();
            $googleEntity = new GooglePlaceEntity();

            $allBusiness = Business::select('business_id')->get();

            $thirdPartyData = DB::table('business_master as bm')
                ->join('third_party_master as tpm', 'bm.business_id', '=', 'tpm.business_id')
                ->join('user_master as usm', 'bm.user_id', '=', 'usm.id')
                ->where('bm.business_id', 1)
                // ->whereIn('bm.business_id', $allBusiness)
                ->select('bm.user_id', 'bm.business_id', 'bm.state','bm.country','bm.name', 'third_party_id','tpm.business_id','type', 'tpm.add_review_url','tpm.page_url','tpm.review_count', 'tpm.average_rating', 'tpm.website','tpm.phone','tpm.street')
                ->orderby('tpm.business_id')
                ->get()->toArray();

            foreach ($thirdPartyData as $row) {

                $TAresult = $tripEntity->getBusinessListed($row->name);

                $YELPresult = $yelpEntity->getBusinessListed($row->name,$row->state,$row->country);

                $GPresult = $googleEntity->getBusinessListed($row->name);

                if ($TAresult['_metadata']['outcomeCode'] == 200 ) {

                    Log::info("TA");
                    $records = $TAresult['records']['Results'];
                    $data['business_id'] = $row->business_id;
                    $data['type'] = 'Tripadvisor';
                    $data['name'] = $records['Name'];
                    $data['page_url'] = $records['URL'];
                    $data['review_count'] = $records['Review'];
                    $data['average_rating'] = $records['Rating'];
                    $data['phone'] = $records['ContactNo'];
                    $data['street'] = $records['Address'];
                    $data['website'] = $records['Website'];
                    $data['add_review_url'] = $records['AddReviewURL'];

                    /**
                     * Remove http in website before saving into database
                     */
                    $str = $data['website'];
                    $str = preg_replace('#^http?://#', '', rtrim($str, '/'));
                    $data['website'] = $str;


                    $TripadvisorResult = TripadvisorMaster::create($data);


                    $thirdPartyId = (!empty($TripadvisorResult['third_party_id'])) ? $TripadvisorResult['third_party_id'] : NULL;
                    $issueData = [
                        [
                            'key' => 'phone',
                            'value' => $data['phone'],
                            'issue' => ($data['phone'] != '') ? 4 : 40,
                            'oldIssue' => ($data['phone'] == '') ? 4 : 40
                        ],
                        [
                            'key' => 'address',
                            'value' => $data['street'],
                            'issue' => ($data['street'] != '') ? 5 : 42,
                            'oldIssue' => ($data['street'] == '') ? 5 : 42
                        ],
                        [
                            'key' => 'website',
                            'value' => $data['website'],
                            'issue' => ($data['website'] != '') ? 6 : 41,
                            'oldIssue' => ($data['website'] == '') ? 6 : 41
                        ]
                    ];

                    $thirdPartyEntity->globalIssueGenerator($row->user_id, $row->business_id, $thirdPartyId, $issueData, $data['type'], 'local');


                }
                if ($YELPresult['_metadata']['outcomeCode'] == 200 )
                {
                    Log::info("YP");

                    $records = $YELPresult['records']['Results'];
                    $data['business_id'] = $row->business_id;
                    $data['type'] = 'Yelp';
                    $data['page_url'] = $records['URL'];
                    $data['review_count'] = $records['Review'];
                    $data['average_rating'] = $records['Rating'];
                    $data['phone'] = $records['ContactNo'];
                    $data['street'] = $records['Address'];
                    $data['website'] = $records['Website'];
                    $data['add_review_url'] = $records['AddReviewURL'];

                    /**
                     * Remove extra spaces from address
                     */

                    $address = $data['street'];

                    $address = preg_replace('/\s+/', ' ', $address);

                    $data['street'] = $address;

                    $YelpResult = YelpMaster::create($data);

                    $thirdPartyId = (!empty($YelpResult['third_party_id'])) ? $YelpResult['third_party_id'] : NULL;

                    $issueData = [
                        [
                            'key' => 'phone',
                            'value' => $data['phone'],
                            'issue' => ($data['phone'] != '') ? 13 : 43,
                            'oldIssue' => ($data['phone'] == '') ? 13 : 43
                        ],
                        [
                            'key' => 'address',
                            'value' => $data['street'],
                            'issue' => ($data['street'] != '') ? 14 : 45,
                            'oldIssue' => ($data['street'] == '') ? 14 : 45
                        ],
                        [
                            'key' => 'website',
                            'value' => $data['website'],
                            'issue' => ($data['website'] != '') ? 15 : 44,
                            'oldIssue' => ($data['website'] == '') ? 15 : 44
                        ]
                    ];

                    $thirdPartyEntity->globalIssueGenerator($row->user_id, $row->business_id, $thirdPartyId, $issueData, $data['type'], 'local');

                }
                if ($GPresult['_metadata']['outcomeCode'] == 200 ) {

                    $records = $GPresult['records'];


                    $data['business_id'] = $row->business_id;
                    $data['type'] = 'Google Places';
                    $data['name'] = $records['name'];
                    $data['average_rating'] = $records['average_rating'];
                    $data['website'] = $records['website'];
                    $data['phone'] = $records['phone'];
                    $data['street'] = $records['street'];
                    $data['page_url'] = $records['page_url'];
                    $str = $data['website'];
                    $str = preg_replace('#^http?://#', '', rtrim($str, '/'));
                    $data['website'] = $str;

                    $GooglePlaceResult = GoogleplaceMaster::create($data);
                    $thirdPartyId = (!empty($GooglePlaceResult['third_party_id'])) ? $GooglePlaceResult['third_party_id'] : NULL;
                    $issueData = [
                        [
                            'key' => 'phone',
                            'value' => $data['phone'],
                            'issue' => ($data['phone'] != '') ? 7 : 46,
                            'oldIssue' => ($data['phone'] == '') ? 7 : 46
                        ],
                        [
                            'key' => 'address',
                            'value' => $data['street'],
                            'issue' => ($data['street'] != '') ? 8 : 48,
                            'oldIssue' => ($data['street'] == '') ? 8 : 48
                        ],
                        [
                            'key' => 'website',
                            'value' => $data['website'],
                            'issue' => ($data['website'] != '') ? 9 : 47,
                            'oldIssue' => ($data['website'] == '') ? 9 : 47
                        ]
                    ];
                    $thirdPartyEntity->globalIssueGenerator($row->user_id, $row->business_id, $thirdPartyId, $issueData, $data['type'], 'local');

                }




            }

            return $this->helpReturn("Automated Listing Business Cron Job ");

        } catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->helpError(1, 'Some Problem happened Please Try Again.');
        }

    }

    public function weeklySummaryStatsCount($request)
    {


        //try {
        $businessObj = new BusinessEntity();
        $checkPoint = $this->setCurrentUser($request->get('token'))->userAllow();

        // user is not found.
        if ($checkPoint['_metadata']['outcomeCode'] != 200) {
            return $checkPoint;
        }

        $user = $checkPoint['records'];
        $businessResult = $businessObj->userSelectedBusiness($user);

        if ($businessResult['_metadata']['outcomeCode'] != 200) {
            return $this->helpError(1, 'Problem in selection of user business.');
        }

        $businessResult = $businessResult['records'];
        Log::info('check each business result');
//        Log::info($businessResult);
        Log::info('check each business result');
        $types = $request->get('type');

        if (!is_array($types)) {
            $types = [
                [
                    'type' => $types,
                    'is_type' => !empty($request->get('is_type')) ? $request->get('is_type') : 'day',
                    'category_type' => !empty($request->get('category_type')) ? $request->get('category_type') : 'day',
                ]
            ];
        }

        $statusData = [];
        $i = 0;
        $objectiveManager = new MarketingObjectiveEntity();
        $objective = '';
        $categoryHeading = '';

        foreach ($types as $type) {
            $currentType = strtolower($type['type']);
            $reviewsType = strtolower($type['is_type']);
            $category_type = $request->get('category_type');

            if (strtoupper($category_type) == 'RV') {
                $categoryHeading = 'Reviews';
            } elseif (strtoupper($category_type) == 'LK') {
                $categoryHeading = 'Likes';
            } elseif (strtoupper($category_type) == 'RG') {
                $categoryHeading = 'Rating';
            } elseif (strtoupper($category_type) == 'PV') {
                $categoryHeading = 'Page View';
            }

            $typeRequested = str_replace('-', ' ', ucfirst($currentType));

            if ($typeRequested == 'Facebook') {
                $thirdPartyResult = SocialMediaMaster::where(
                    [
                        'business_id' => $businessResult['business_id'],
                        'type' => $typeRequested
                    ]
                )->first();
            } elseif ($typeRequested == 'Googleanalytics' || $typeRequested == 'Google analytics') {
                if ($typeRequested == 'Google analytics') {
                    $typeRequested = 'Googleanalytics';
                }

                $thirdPartyResult = GoogleAnalyticsMaster::where(
                    [
                        'business_id' => $businessResult['business_id'],
                    ]
                )->first();
            }
            else if ($typeRequested == 'Crm') {

                $thirdPartyResult = Recipient::where(
                    [
                        'user_id' => $user['id'],
                        //'type' => $typeRequested
                    ]
                )->first();
            }
            else {
                $thirdPartyResult = TripadvisorMaster::where(
                    [
                        'business_id' => $businessResult['business_id'],
                        'type' => $typeRequested
                    ]
                )->first();
            }


            if (!empty($thirdPartyResult['name']) || !empty($thirdPartyResult['email'])) {

                $dateFormat = dateFormatUsing();
                $currentDate = isset($request->start_date) ? $request->start_date : Carbon::now($user->time_zone);
                $yesterdayDate = Carbon::yesterday($user->time_zone);

                $formattedCurrentDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format($dateFormat);
                $formattedYesterdayDate = Carbon::createFromFormat('Y-m-d H:i:s', $yesterdayDate)->format($dateFormat);
                $formattedWeekDate = '';

                if ($reviewsType == 'week') {

                    $weekDate = isset($request->end_date) ? $request->end_date : Carbon::now($user->time_zone)->subDays(7);
                    $inverseDate = Carbon::createFromFormat('Y-m-d H:i:s', $request->end_date)->subDays(1);
                    $lastWeekDate = isset($inverseDate) ? Carbon::createFromFormat('Y-m-d H:i:s', $inverseDate)->subDays(6)->format($dateFormat) : '';

                    $formattedWeekDate = Carbon::createFromFormat('Y-m-d H:i:s', $weekDate)->format($dateFormat);


                    $formattedLastWeekDate = isset($request->end_date) ?  Carbon::createFromFormat('Y-m-d H:i:s', $lastWeekDate.'00:00:00')->format($dateFormat) :  Carbon::createFromFormat('Y-m-d H:i:s', $lastWeekDate)->format($dateFormat);

                    $weekDates = extractWeekDays($formattedWeekDate);
                    $lastWeekDates = extractWeekDays($formattedLastWeekDate);
                }


                $graphStatsQuery = StatTracking::where(function ($q) use ($typeRequested, $thirdPartyResult,$user) {
                    if ($typeRequested == 'Facebook') {
                        $q->where('social_media_id', $thirdPartyResult['id']);
                    } else if ($typeRequested == 'Googleanalytics') {
                        $q->where('google_analytics_id', $thirdPartyResult['id']);
                    } else if ($typeRequested == 'Crm') {
                        $q->where('user_id', $user['id']);
                    }
                    else {

                        $q->where('third_party_id', $thirdPartyResult['third_party_id']);
                    }
                })->where('type', $category_type)->where('site_type', $typeRequested);

                $graphStatsSelection = '';
                if ($reviewsType == 'week' || $reviewsType == 'day') {
                    $graphStatsSelection = clone $graphStatsQuery;
                }

                $graphStatsQuery->where(function ($query) use ($reviewsType, $formattedCurrentDate, $formattedWeekDate) {
                    if ($reviewsType == 'week') {
                        $query->where('activity_date', '<=', $formattedCurrentDate);
                        $query->where('activity_date', '>=', $formattedWeekDate);
                    } elseif ($reviewsType == 'day') {
                        $query->where('activity_date', '=', $formattedCurrentDate);
                    } else if ($reviewsType == 'all') {
                        $query->where('activity_date', '<=', $formattedCurrentDate);
                    }
                });

                $graphStats = $graphStatsQuery->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                $insightData = [];

                /**
                 * review request must not be all and widget category type is not be Reviews, likes..
                 */
                if (!($reviewsType == 'all' && ($category_type == 'RV' || $category_type == 'LK'))) {
                    $objectiveData = $objectiveManager->getObjectiveQuery($currentType, $categoryHeading);

                    if (!empty($objectiveData)) {
                        $objective = $objectiveData['id'];
                    }
                }

                if ($reviewsType == 'all' && $category_type == 'RV') {
                    if ($typeRequested == 'Facebook') {
                        $counts = $thirdPartyResult['page_reviews_count'];
                    } else {
                        $counts = $thirdPartyResult['review_count'];
                    }
                }
                elseif ($reviewsType == 'all' && $category_type == 'LK') {
                    $counts = $thirdPartyResult['page_likes_count'];
                }
                elseif ($reviewsType == 'all' && $category_type == 'RG') {
                    $counts = $thirdPartyResult['average_rating'];
                    $insightData = insightTitle($counts, '', '', $category_type, $objective);
                }
                elseif ($category_type == 'RG') {
                    $counts = $graphStatsQuery->avg('count');
                    /*******new code for weekly email send**********/
                    $lastCounts = 0;
//                        echo "\n";
//                        echo "formattedLastWeekDate $formattedLastWeekDate";
//                        echo "\n";
                    // comparison of week with last week
                    /***************** Part to cover Last week & today-yesterday case *****************************/
                    if ($reviewsType == 'week') {
                        $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                            $query->where('activity_date', '<', $formattedWeekDate);
                            $query->where('activity_date', '>=', $formattedLastWeekDate);
                        });
                    }
                    elseif ($reviewsType == 'day') {
                        $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                            $query->where('activity_date', '=', $formattedYesterdayDate);
                        });
                    }

                    if (!empty($graphStatsSelection)) {
                        $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                    }

                    $lastCounts = $graphStatsSelection->avg('count');

                    /*******new code for weekly email**********/
                    $counts = round($counts, 1);

                    $insightData = insightTitle($counts, $lastCounts, '', $category_type, $objective);

                }
                elseif ($category_type == 'PV') {

                    $counts = $graphStatsQuery->sum('count');
                    $lastCounts = 0;

                    if ($reviewsType == 'day') {
                        $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                            $query->where('activity_date', '=', $formattedYesterdayDate);
                        });

                        if (!empty($graphStatsSelection)) {
                            $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                        }

                        $lastCounts = $graphStatsSelection->sum('count');
                    }

                    $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                } /**
                 * New Code Add For Facebook Related Counts
                 */
                elseif ($category_type == 'FP') {

                    $counts = $graphStatsQuery->sum('count');
                    $lastCounts = 0;
                    if ($reviewsType == 'week') {
                        $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                            $query->where('activity_date', '<', $formattedWeekDate);
                            $query->where('activity_date', '>=', $formattedLastWeekDate);
                        });
                    }
                    elseif ($reviewsType == 'day') {
                        $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                            $query->where('activity_date', '=', $formattedYesterdayDate);
                        });
                    }

                    if (!empty($graphStatsSelection)) {
                        $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                    }

                    $lastCounts = $graphStatsSelection->sum('count');
                    $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                }elseif ($category_type == 'PA') {

                    $counts = $graphStatsQuery->sum('count');
                    $lastCounts = 0;
                    if ($reviewsType == 'week') {
                        $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                            $query->where('activity_date', '<', $formattedWeekDate);
                            $query->where('activity_date', '>=', $formattedLastWeekDate);
                        });
                    }
                    elseif ($reviewsType == 'day') {
                        $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                            $query->where('activity_date', '=', $formattedYesterdayDate);
                        });
                    }

                    if (!empty($graphStatsSelection)) {
                        $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                    }

                    $lastCounts = $graphStatsSelection->sum('count');
                    $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                }elseif ($category_type == 'TR') {

                    $counts = $graphStatsQuery->sum('count');
                    $lastCounts = 0;
                    if ($reviewsType == 'week') {
                        $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                            $query->where('activity_date', '<', $formattedWeekDate);
                            $query->where('activity_date', '>=', $formattedLastWeekDate);
                        });
                    }
                    elseif ($reviewsType == 'day') {
                        $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                            $query->where('activity_date', '=', $formattedYesterdayDate);
                        });
                    }

                    if (!empty($graphStatsSelection)) {
                        $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                    }

                    $lastCounts = $graphStatsSelection->sum('count');
                    $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                }
                /********New Code For CUSTOMER*******/
                elseif ($category_type == 'CU') {

                    $counts = $graphStatsQuery->sum('count');
                    $lastCounts = 0;
                    if ($reviewsType == 'week') {
                        $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                            $query->where('activity_date', '<', $formattedWeekDate);
                            $query->where('activity_date', '>=', $formattedLastWeekDate);
                        });
                    }
                    elseif ($reviewsType == 'day') {
                        $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                            $query->where('activity_date', '=', $formattedYesterdayDate);
                        });
                    }

                    if (!empty($graphStatsSelection)) {
                        $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                    }

                    $lastCounts = $graphStatsSelection->sum('count');
                    $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                }
                elseif ($category_type == 'RR') {

                    $counts = $graphStatsQuery->sum('count');
                    $lastCounts = 0;
                    if ($reviewsType == 'week') {
                        $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                            $query->where('activity_date', '<', $formattedWeekDate);
                            $query->where('activity_date', '>=', $formattedLastWeekDate);
                        });
                    }
                    elseif ($reviewsType == 'day') {
                        $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                            $query->where('activity_date', '=', $formattedYesterdayDate);
                        });
                    }

                    if (!empty($graphStatsSelection)) {
                        $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                    }

                    $lastCounts = $graphStatsSelection->sum('count');
                    $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                }
                elseif ($category_type == 'SP') {

                    $counts = $graphStatsQuery->sum('count');
                    $lastCounts = 0;
                    if ($reviewsType == 'week') {
                        $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                            $query->where('activity_date', '<', $formattedWeekDate);
                            $query->where('activity_date', '>=', $formattedLastWeekDate);
                        });
                    }
                    elseif ($reviewsType == 'day') {
                        $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                            $query->where('activity_date', '=', $formattedYesterdayDate);
                        });
                    }

                    if (!empty($graphStatsSelection)) {
                        $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                    }

                    $lastCounts = $graphStatsSelection->sum('count');
                    $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                }elseif ($category_type == 'EP') {

                    $counts = $graphStatsQuery->sum('count');
                    $lastCounts = 0;
                    if ($reviewsType == 'week') {
                        $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                            $query->where('activity_date', '<', $formattedWeekDate);
                            $query->where('activity_date', '>=', $formattedLastWeekDate);
                        });
                    }
                    elseif ($reviewsType == 'day') {
                        $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                            $query->where('activity_date', '=', $formattedYesterdayDate);
                        });
                    }

                    if (!empty($graphStatsSelection)) {
                        $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                    }

                    $lastCounts = $graphStatsSelection->sum('count');
                    $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                }
                elseif ($category_type == 'PE') {
                    if($request->end_date) {
                        Log::info('report section');
                        Log::info("Testing people engage for email". $formattedLastWeekDate);
                        Log::info("Testing people engage for email". $formattedWeekDate);
                    }else{
                        Log::info('email section');
                        Log::info("Testing people engage for email". $formattedLastWeekDate);
                        Log::info("Testing people engage for email". $formattedWeekDate);
                    }
                    $counts = $graphStatsQuery->sum('count');
                    $lastCounts = 0;
                    if ($reviewsType == 'week') {
                        $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                            $query->where('activity_date', '<', $formattedWeekDate);
                            $query->where('activity_date', '>=', $formattedLastWeekDate);
                        });
                    }
                    elseif ($reviewsType == 'day') {
                        $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                            $query->where('activity_date', '=', $formattedYesterdayDate);
                        });
                    }

                    if (!empty($graphStatsSelection)) {
                        $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                    }

                    $lastCounts = $graphStatsSelection->sum('count');
                    $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                }
                //new addition for weekly email sending
                elseif ($category_type == 'RV' || $category_type == 'LK') {
                    $counts = $graphStatsQuery->sum('count');

                    // comparison of week with last week
                    /***************** Part to cover Last week & today-yesterday case *****************************/
                    Log::info('formated week date like end date');
                    Log::info($formattedWeekDate);
                    Log::info('end date to previouse data');
                    Log::info($formattedLastWeekDate);
                    if ($reviewsType == 'week') {
                        $graphStatsSelection->where(function ($query) use ($formattedLastWeekDate, $formattedWeekDate) {
                            $query->where('activity_date', '<', $formattedWeekDate);
                            $query->where('activity_date', '>=', $formattedLastWeekDate);
                        });
                    }
                    elseif ($reviewsType == 'day') {
                        $graphStatsSelection->where(function ($query) use ($formattedYesterdayDate) {
                            $query->where('activity_date', '=', $formattedYesterdayDate);
                        });
                    }

                    if (!empty($graphStatsSelection)) {
                        $graphStatsSelection->select('activity_date', 'count')->orderBy('activity_date', 'ASC')->get()->toArray();
                    }

                    $lastCounts = $graphStatsSelection->sum('count');

                    $insightData = insightTitle($counts, $lastCounts, $reviewsType, $category_type, $objective);
                    /***************** Part to cover Last week & today-yesterday case *****************************/

                }

                if ($reviewsType == 'week') {
                    if (!empty($graphStats)) {
                        foreach ($graphStats as $row) {
                            $activityDate = $row['activity_date'];
                            $key = array_search($activityDate, array_column($weekDates, 'activity_date'));

                            if (isset($weekDates[$key]['activity_date']) && $activityDate == $weekDates[$key]['activity_date']) {
                                $weekDates[$key]['count'] = $row['count'];
                            }
                        }
                    }

                    $graphStats = $weekDates;
                } else {
                    // if graph stats is empty then show data with current date 0
                    if (empty($graphStats)) {
                        $graphStats[0]['activity_date'] = $formattedCurrentDate;
                        $graphStats[0]['count'] = 0;
                    }
                }

                if (empty($insightData)) {
                    $insightData = [
                        'objective' => '',
                        'insightTitle' => '',
                        'insightDescription' => '',
                        'insightStatus' => '',
                    ];
                }
                $statusData[$i] = $insightData;
                $statusData[$i]['type'] = $currentType;
                $statusData[$i]['name'] = $thirdPartyResult['name'];
                $statusData[$i]['last_count'] = isset($lastCounts) ? $lastCounts : 0;

                if (!empty($thirdPartyResult['website'])) {
                    $statusData[$i]['website'] = $thirdPartyResult['website'];
                }

                if ($typeRequested == 'Googleanalytics') {
                    $statusData[$i]['typeTitle'] = 'Google analytics';
                } else {
                    $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
                }
                $statusData[$i]['count'] = $counts;
                $statusData[$i]['graph_data'] = $graphStats;


                if($request['flag'] == 'email'){ //this check use for weekly email function
                    $newNumber = $counts;
                    $originalNumber = $lastCounts;
                    if($counts == 0 && $lastCounts == 0){
                        $increase = 'No Activity';
                    }else {

                        $increase = $newNumber - $originalNumber;
                        if ($originalNumber == 0) {
                            $originalNumber = 1;
                        }
                        $increase = $increase / $originalNumber * 100;
                        $increase = round($increase, 2);
                    }
                    $statusData[$i] = [
                        'type' => $currentType,
                        'count' => $counts,
                        'previouse_count' => $lastCounts,
                        'trend' => $increase,
                    ];
                }

            } else {
                $statusData[$i]['type'] = $currentType;
                $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
                $statusData[$i]['message'] = ucwords(strtolower($typeRequested)) . ' not connected';
                $url = config::get('custom.webAppDomain');

                if($request['flag'] == 'email') { //this check use for weekly email function
                    $statusData[$i]['type'] = $currentType;
                    $statusData[$i]['typeTitle'] = ucwords(strtolower($typeRequested));
                    $statusData[$i]['message'] = ucwords(strtolower($typeRequested)) . ' is not connected with your NetBlaze account. <a href='.$url.'>Login</a> to NetBlaze to connect.';

                }

            }

            $i++;
        }

        return $this->helpReturn("Dashboard Widget and Graph Stats.", $statusData);
//        } catch (Exception $e) {
//            Log::info("getGraphStatsCount " . $e->getMessage());
//            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
//        }
    }



}
