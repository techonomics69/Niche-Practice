<?php
use Carbon\Carbon;
use FuzzyWuzzy\Fuzz;
use Modules\Business\Http\Controllers\HomeController;
use Modules\User\Models\Emailrequestlog;

/**
 * @param $reason
 * @param $message
 * @return array
 */
function make_error_object($reason, $message)
{
    return ['map' => $reason, 'message' => $message];
}

/**
 * @param $messageBagArray
 * @return array
 */
function convert_laravel_input_errors($messageBagArray)
{
    $errors = [];
    foreach ($messageBagArray as $key => $message) {
        $errors[] = make_error_object($key, $message[0]);
    }
    return $errors;
}

/**
 *
 * convert standard error to extension error
 *
 * @param $errors
 * @return array
 */
function convert_laravel_input_errors_to_extension_errors($errors)
{
    return ['error' => $errors[0]['message']];
}

function k_arrayIndexCheck($array, $index)
{
    $value = false;

    if(isset($array[$index]) && $array[$index] != '')
    {
        $value = $array[$index];
    }
    return $value;
}

function messageTimeFormat($timestamp)
{
    $strTime = strtotime($timestamp); // '2017-05-15 11:29:54'

    $time = time() - $strTime; // to get the time since that moment
    $time = ($time<1)? 1 : $time;

    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        172800 => 'one day ago',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    if($time <= 86400)
    {
        $messageTime = 'Today ' . date('g:i A', $strTime);
    }
    else if($time > 86400 && $time <= 172800)
    {
        $messageTime = 'yesterday ' . date('g:i A', $strTime);
    }
    else
    {
        $messageTime = date('M j, Y g:i A', $strTime);
    }

    return $messageTime;
}

function stringEncodeForAPI($name)
{
    $name = str_replace("&", "%26", $name);


    return $name;
}

function bulk_insert($table, $data)
{
    $SQLQuery = '';
    $SQLCols = array();

    $queriesArray = [];

    $columnsCount = -1;
    $previousSQLCols = [];



    foreach ($data as $dataRow) {

        $SQLCols = array_keys($dataRow);

        if ($columnsCount != count($SQLCols)) {
            if ($columnsCount != -1) {
                $SQLQuery = rtrim($SQLQuery, ',');
                $SQLQuery .= " ON DUPLICATE KEY UPDATE \n";
                $OnDuplicateSet = array();
                foreach ($previousSQLCols as $Column) {
                    $OnDuplicateSet[] = "`{$Column}`=VALUES(`{$Column}`)";
                }
                $SQLQuery .= implode(", \n", $OnDuplicateSet) . ";";
                $queriesArray[] = $SQLQuery;
            }
            $columnsCount = count($SQLCols);
            $previousSQLCols = $SQLCols;
            $SQLQuery = 'INSERT INTO `' . $table . '`(' . implode(",", $SQLCols) . ') VALUES ';
        }
        $vals = [];
        foreach ($dataRow as $key => $value) {
            $vals[] = $value ? DB::getPdo()->quote((string)$value) : "NULL";
        }
        $SQLValue = '(' . implode(',', $vals) . ')';
        $SQLQuery .= "" . $SQLValue . ",";

    }

    $SQLQuery = rtrim($SQLQuery, ',');


    $SQLQuery .= " ON DUPLICATE KEY UPDATE \n";
    $OnDuplicateSet = array();
    foreach ($SQLCols as $Column) {
        $OnDuplicateSet[] = "`{$Column}`=VALUES(`{$Column}`)";
    }
    $SQLQuery .= implode(", \n", $OnDuplicateSet) . ";";
    $queriesArray[] = $SQLQuery;


//    DB::enableQueryLog();

    $isLastInserted = 0;

    foreach ($queriesArray as $query) {
        DB::insert(ltrim($query, ";"));

        /**
         * This id keep track what if any new record inserted in a table.
         */
        $isLastInserted = DB::getPdo()->lastInsertId();
    }

    return $isLastInserted;
//    print_r(DB::getQueryLog());exit;
}

function editFieldValue($array, $index)
{
    return  (empty( old($index) ) ) ? $array[$index] : old($index);
}

function editFieldValueV2($array, $index)
{
    if(!empty($array[$index]))
    {
        $value = $array[$index];
    }
    else
    {
        $value = '';
    }

    return  (empty( old($index) ) ) ? $value : old($index);
}

function selectedChosenValueV2($array, $index, $value)
{
    if(isset($array[$index]))
    {
        $recordValue = $array[$index];
    }
    else
    {
        $recordValue = '';
    }

    $oldValue = old($index);

    if(isset($oldValue))
    {
        $oldValue = old($index);
    }
    else
    {
        $oldValue = '';
    }

//    echo "checking $index";
//    print_r($array[$index]);
//    exit;
    return ((trim($oldValue) == trim($value)) || (trim($recordValue) == trim($value))) ? 'selected' : '';
//    return ((isset($recordValue) && trim($recordValue) == trim($value))) ? 'selected' : '';
}

function selectedChosenValue($dataIndex, $value)
{
    return (isset($dataIndex) && trim($dataIndex) == trim($value)) ? 'selected' : '';
}

/**
 * Make sure value
 * - should not be Zero
 * - should not be Empty
 * - should not be Null
 *
 * function designed for to handle zero value because empty lack on zero
 * @param $value
 * @return bool (true on value existance)
 */
function checkValue($value = '')
{
    if(isset($value) && $value !== '')
    {
        return true;
    }

    return false;
}

function urlDomainChecker($url)
{
    $code = 200;
    $status = 'unknown';


    if (preg_match('/http:\/\/(www\.)*vimeo\.com\/.*/', $url)) {
        // do vimeo stuff
        $status = 'vimeo';
    } else if (
    preg_match(
        '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/',
        $url)
    ) {
        // do youtube stuff
        $status = 'youtube';
    } else {
        $code = '403';
    }

    $statusData = [
        'code' => $code,
        'status' => $status,
    ];

    return $statusData;

}

function reformatText($string, $name)
{
    if(empty($name))
    {
        return str_replace(' <first_name>', ucfirst($name), $string);
    }

    return str_replace('<first_name>', ucfirst($name), $string);
}

/**
 * remove media query string from url.
 * @param $url
 * @return string|string[]|null
 */
function cleanReferUrl($url)
{
    return preg_replace('/\?.*/', '', $url);
}

function getUrlDomain($url)
{
    $parseUrl = parse_url(trim($url));

    if (!empty($parseUrl['host'])) {
        $url = 'http://' . $parseUrl['host'];
    } else if (!empty($parseUrl['path'])) {
        $url = 'http://' . $parseUrl['path'];
    }

    return str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
}

function domainPathGet()
{
    $formatToReplace = ['https://', 'http://'];
    $replaceFormat = [];

    return str_replace($formatToReplace, $replaceFormat, url('/'));
}

function phonFormatter($phone)
{
    $formatToReplace = array("+", " ", "-","(",")");
    $replaceFormat   = array("", "", "","","");

    return str_replace($formatToReplace, $replaceFormat, $phone);
}

/**
 * Get time according to given timezone.
 *
 * @param $timeZone
 * @param $timeStamp
 * @return false|string
 */
function utcZoneTime($timeZone, $timeStamp)
{
    if($timeZone)
    {
        $timeZone = str_replace('GMT', '', $timeZone);

//        $zone = explode(" ",$timeZone);
//        $timeZone = $zone[1];

        $time = strtotime($timeStamp); // get unix time stamp of given timestamp

        return gmdate( "Y-m-j H:i:s", $time + 3600*( $timeZone+date("I") ) );
    }

    return $timeStamp;
}

function getIndexedvalue($array, $index, $return = NULL)
{
    return !empty( $array[$index] ) ? $array[$index] : $return;
}

function appDateFormat($timestamp)
{
    return Date('F d, Y', strtotime($timestamp));
}

function getCountries()
{
    # code...
    $homeObj = new HomeController();
    return $homeObj->getCountries();
}
function usaStates()
{
    return array(
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'District Of Columbia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'WA' => 'Washington',
        'WV' => 'West Virginia',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
    );
}


function AgoFormatConvertInDateFormat($string)
{
    $stringArray = explode(" ",$string);
    $number = $stringArray[0];
    if(isset($stringArray[1])){
        $str = $stringArray[1];
    }else{ // this is yelp case because yelp no having second index
        $str = $string;
    }

    if ($number == 'a') {
        $number = "1";
    }


    if($str == 'second' || $str == 'Second' || $str == 'seconds' || $str == 'Seconds'){
        $currentDate = Carbon::now();
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    else if($str == 'minute' || $str == 'Minute' || $str == 'minutes' || $str == 'Minutes'){
        $currentDate = Carbon::now();
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    else if($str == 'hour' || $str == 'Hour' || $str == 'hours' || $str == 'Hours'){
        $currentDate = Carbon::now();
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    else if($str == 'today' || $str == 'Today'){
        $currentDate = Carbon::now();
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    else if($str == 'yesterday' || $str == 'Yesterday'){
        $currentDate = Carbon::now()->subDays(1);
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    else if($str == 'Days' || $str == 'days' || $str == 'Day' || $str == 'Days'){
        $currentDate = Carbon::now()->subDays($number);
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    else if($str == 'Week' || $str == 'week' || $str == 'Weeks' || $str == 'weeks'){
        $currentDate = Carbon::now()->subWeek($number);
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    else if($str == 'Month' || $str == 'month' || $str == 'Months' || $str == 'months'){
        $currentDate = Carbon::now()->subMonth($number);
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    else if($str == 'year' || $str == 'Year' || $str == 'years' || $str == 'Years'){
        $currentDate = Carbon::now()->subYear($number);
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    else if($string == 'in the last day'){
        $currentDate = Carbon::now()->subDays(1);
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    //special cases for google places
    else if($string == 'in the last week'){
        $currentDate = Carbon::now()->subWeek(1);
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');

    }else if($string == 'just now' || $string == 'Just now' || $string == 'just Now'){
        $currentDate = Carbon::now();
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');

    }
    else if($string == 'in the last month'){
        $currentDate = Carbon::now()->subMonth(1);
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    else if($string == 'Less than 1 month ago'  || $string == 'less_than_1_month'){
        $currentDate = Carbon::now()->subMonth(1);
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    else if($string == 'Less than 3 months ago' || $string == 'less_than_3_months'){
        $currentDate = Carbon::now()->subMonth(3);
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    else if($string == 'Less than 6 months ago' || $string == 'less_than_6_months'){
        $currentDate = Carbon::now()->subMonth(6);
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    else if($string == 'in the last year' || $string == 'less_than_1_year' || $string == 'less_than_1_year' || $string == 'more_than_1_year' || $string == 'More than 1 year ago' || $string == 'Less than 1 year ago'){
        $currentDate = Carbon::now()->subYear(1);
        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }
    else{
        $string = explode(' ',$string); // this login use for tripadvisor and yelp

        if(isset($string[0]) && isset($string[1]) && isset($string[2]) && isset($string[3])){ //remove extra content hai spaces

            $finalString = trim($string[0]);  // remove extra spaces

        }else{

            $finalString = implode(" ",$string);;
        }

        $convertdate = strtotime($finalString);
        $formatedDate = date('m-d-Y', $convertdate );

    }

    return $formatedDate;
}

function filterPhoneNumber($phone)
{
    $formatToReplace = array("+", " ", "-","(",")",".");
    $replaceFormat   = array("", "", "","","");
    $phone = str_replace($formatToReplace, $replaceFormat, $phone);

    if(is_numeric($phone))
    {
        return ltrim($phone, '0');
    }

    return '';

}

function appModule()
{
//    return '';
    return [
        'dashboard' => 'Dashboard',
        'patient_contacts' => 'Patient Contacts',
        'review_request' => 'Review Requests History',
        'reviews' => 'Monitor Reviews',
        'get_more_reviews' => 'Get More Reviews',
        'email_campaigns' => 'Email Campaigns',
        'new_patient_email_campaigns' => 'New Patient Email Campaigns',
        'social_posts' => 'Social Posts',
        'search_content' => 'Curated Content',
        'keywords' => 'Keyword Research',
        // 'branded_content' => 'Branded Content',
        // 'blog_articles' => 'Blog Articles',
        // 'press_releases' => 'Press Releases',
        'web_audit' => 'SEO Audit',
        'citation_listings' => 'Citation Listings',
        'more_local_citation_listings' => 'Add More Local Citations',
        // 'advanced_seo' => 'Advanced SEO',
        'promotions' => 'Promotions',
        // 'pay_per_click' => 'Pay Per Click',
        // 'upgrade' => 'Upgrade',
        'business_profile' => 'Business Profile',
        'billing_and_plans' => 'billing-and-plans',
        'review_sites' => 'Review Sites',
        'social_media' => 'Social Media',
        'task_list' => 'Marketing Plan',
        // 'refer' => 'Refer',
        // 'contact_us' => 'Contact Us',
        'how_to_send_review_requests' => 'How to Send Review Requests',
        'smart_routing' => 'Smart Routing',
        'send_reminder' => 'Send Reminder',
        'do_it_yourself' => 'Do-It-Yourself',
        'scratch' => 'Marketing From Scratch',
        'campaign' => 'Start With a Campaign',
        'for_you' => 'We-Do-It-All For-You',




    ];
}
function dashboardWidgets()
{
    # code...
    return [
        'to_do_list_status' => 'To-Do-List Status',
        'send_review_invite' => 'Send Review Invite',
        'recent_top_reviews' => 'Recent Top Reviews',
        'social_media' => 'Social Media',
        'new_patient_emails' => 'New Patient Emails',
        'email_marketing_stats' => 'Email Marketing Stats',
        'citation_listings' => 'Citation Listings',
        'seo_audit_report' => 'SEO Audit Report',
        'website_audit' => 'Website Audit',
        'get_rewarded' => 'Get Rewarded',
    ];
}

function emailData()
{
    $userData = app()->make('SessionService')->getAuthUserSession();
    $emailLimitData = Emailrequestlog::where('users_id', $userData['id'])->get()->toArray();

    return $emailLimitData;
}

function isActivePaid($userId = '')
{
    if(!empty($userId))
    {
        $userObj = new \Modules\User\Entities\UserEntity();
        $subData = $userObj->subscriptionStatusCheck($userId);
    }
    else
    {
        $userData = app()->make('SessionService')->getAuthUserSession();
        $subData = !empty($userData['subscriptionStatus']) ? $userData['subscriptionStatus'] : '';
    }

    if(!empty($subData))
    {
        return ($subData['subscription_expired'] == false && $subData['subscription_type'] == 'paid') ? true : false;
    }
    else
    {
        return false;
    }
}

/**
 * check if user is active (paid/trial)
 *
 * @param string $userId
 * @return bool
 * @throws \Illuminate\Contracts\Container\BindingResolutionException
 */
function isActive($userId = '')
{
    if(!empty($userId))
    {
        $userObj = new \Modules\User\Entities\UserEntity();
        $subData = $userObj->subscriptionStatusCheck($userId);
    }
    else
    {
        $userData = app()->make('SessionService')->getAuthUserSession();
        $subData = $userData['subscriptionStatus'];
    }

    if(!empty($subData))
    {
        // subscription not expired return true.
        return ($subData['subscription_expired'] == false) ? true : false;
    }
    else
    {
        return false;
    }
}

function remainingEmails()
{
    $emailLimitData = emailData();

    $maximum = getIndexedvalue($emailLimitData[0], 'maximum', 0);
    $used =  getIndexedvalue($emailLimitData[0], 'used', 0);
    $remaining = $maximum - $used;

    return $remaining;
}

function smsData()
{
    $userData = app()->make('SessionService')->getAuthUserSession();
    $smsLimitData = \Modules\User\Models\Smsrequestlog::where('users_id', $userData['id'])->get()->toArray();

    return $smsLimitData;
}

function remainingSMS()
{
    $limitData = smsData();

    $maximum = getIndexedvalue($limitData[0], 'maximum', 0);
    $used =  getIndexedvalue($limitData[0], 'used', 0);

    $remaining = $maximum - $used;

    return $remaining;
}

//function appModule()
//{
//    return [
//        [
//            'id'=> 'dashboard',
//            'value' => 'Dashboard'
//        ],
//        [
//            'id'=> 'patient_contacts',
//            'value' => 'Patient Contacts'
//        ],
//        [
//            'id'=> 'reviews',
//            'value' => 'Monitor Reviews'
//        ],
//        [
//            'id'=> 'get_more_reviews',
//            'value' => 'Get More Reviews'
//        ],
//        [
//            'id'=> 'review_request',
//            'value' => 'Review Requests History'
//        ],
//        [
//            'id'=> 'email_campaigns',
//            'value' => 'Email Campaigns'
//        ],
//        [
//            'id'=> 'social_posts',
//            'value' => 'Social Posts'
//        ],
//
////        'search_content' => 'Curated Content',
////        'keywords' => 'Keyword Research',
////        'branded_content' => 'Branded Content',
////        'blog_articles' => 'Blog Articles',
////        'press_releases' => 'Press Releases',
////        'web_audit' => 'SEO Audit',
////        'citation_listings' => 'Citation Listings',
////        'advanced_seo' => 'Advanced SEO',
////        'promotions' => 'Promotions',
////        'pay_per_click' => 'Pay Per Click',
//    ];
//}
function moduleList()
{
    return ['Local Marketing', 'Social Media', 'Website'];
}

function moduleSmallSiteList()
{
    return ['TA','GP','YP','FB'];

}
function moduleSiteList()
{
    return ['Tripadvisor', 'Google Places', 'Yelp', 'Facebook', 'Website'];

}
function moduleSocialList($required = 'main')
{
    if($required == 'main')
    {
        return ['Facebook', 'Twitter'];
    }
    return ['Twitter', 'Linkedin', 'Instagram','Facebook'];
}


/**
 * @param $day
 * @param string $extractWeek (next,previous)
 */
function extractWeekDays($day, $extractDays = 6)
{
    //dd($day);
// parse about any English textual datetime description into a Unix timestamp
    $timestamp = strtotime($day);
    $dateFormat = dateFormatUsing();

    for($i=0;$i<=$extractDays;$i++) {
        $date = strtotime("+$i day", $timestamp);
        $weekDates[$i]['activity_date'] = date($dateFormat, $date);
        $weekDates[$i]['count'] = 0;
    }

    return $weekDates;
}

//function extractWeekDays($day, $extractWeek = 'next')
//{
//    // parse about any English textual datetime description into a Unix timestamp
//    $timestamp = strtotime($day);
//    $dateFormat = dateFormatUsing();
//
//    for($i=0;$i<=7;$i++) {
//        $date = strtotime("+$i day", $timestamp);
//        $weekDates[] = date($dateFormat, $date);
//    }
//
//    return $weekDates;
//}

function dateFormatUsing($format = 'Y-m-d')
{
    return $format;
}

function getFormattedDate($date, $dateFormat = '')
{
    if($dateFormat == '')
    {
        $dateFormat = dateFormatUsing();
    }

    $timestamp = strtotime(str_replace('-', '/', $date));

    if ($timestamp === FALSE) {
        $timestamp = strtotime(str_replace('/', '-', $date));
    }

    return date('Y-m-d', $timestamp);
}

function contentDiscoveryDateConversion($date)
{
    if ($date == 'Last 24 Hours') {
        $numberOfDay = 1;
        // $currentDate = Carbon::now();
        // $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    } else if ($date == 'Last Week') {
        $numberOfDay = 7;
        //  $currentDate = Carbon::now()->subWeek(1);
        // $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    } else if ($date == 'Last Month') {
        $numberOfDay = 30;
        // $currentDate = Carbon::now()->subMonth(1);
        // $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    } else if ($date == 'Last 6 Months') {
        $numberOfDay = 282;
        // $currentDate = Carbon::now()->subMonth(6);
        // $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    } else if ($date == 'Last Year') {
        $numberOfDay = 365;
        // $currentDate = Carbon::now()->subYear(1);
        // $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    } else if ($date == 'Last 2 Years') {
        $numberOfDay = 730;
        // $currentDate = Carbon::now()->subYear(2);
        // $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->format('m-d-Y');
    }

    return $numberOfDay;
}

/**
 * @param $newNumber ($newNumber, today)
 * @param int $originalNumber ($newNumber, yesterday)
 * @param string $type
 * @return array
 */
function insightTitle($newNumber = 0, $originalNumber = 0, $type = 'week', $category ='RV', $id = '')
{

    $data['objective'] = '';
    $data['insightDescription'] = '';

    if($category == 'RV' || $category == 'LK') {
        if ($type == 'week') {
            $increase = $newNumber - $originalNumber;
            if ($originalNumber == 0) {
                $originalNumber = 1;
            }
            $increase = $increase / $originalNumber * 100;
            $increase = round($increase, 2);

            if ($increase == 0 || strpos($increase, '-') !== false) {
                $increase = str_replace('-', '', $increase);

                $data['insightTitle'] = "Down $increase% from previous week";
                $data['insightStatus'] = "down";
            } else {
                $data['insightTitle'] = "Up $increase% from previous week";
                $data['insightStatus'] = "up";
            }
        } else {
            $diff = $newNumber - $originalNumber;
            if ($diff == 0 || strpos($diff, '-') !== false) {
                $diff = str_replace('-', '', $diff);
                $data['insightTitle'] = "Down $diff from yesterday";
                $data['insightStatus'] = "down";
            } else {
                $data['insightTitle'] = "Up $diff from yesterday";
                $data['insightStatus'] = "up";
            }
        }

        if($category == 'LK')
        {
            $data['insightDescription'] = "Click here how to learn more on how you can increase your Facebook page likes.";
        }
        else
        {
            $data['insightDescription'] = "Click here how to learn more about how you can increase your reviews.";
        }
    }
    elseif($category == 'RG')
    {
        if($newNumber >= 1 && $newNumber < 3)
        {
            $data['insightTitle'] = "Poor customer rating";
            $data['insightDescription'] = "Your customers rate your services or products low. Click here for the task on how to improve your customer satisfactory rating.";
            $data['insightStatus'] = "down";
        }
        elseif($newNumber >= 3 && $newNumber < 4)
        {
            $data['insightTitle'] = "Average customer rating";
            $data['insightDescription'] = "Your customers are not exactly blown away by your service but you can do better. Click here to read the task on how to improve your customer satisfactory rating.";
            $data['insightStatus'] = "average";
        }
        elseif($newNumber >= 4 && $newNumber < 5)
        {
            $data['insightTitle'] = "Good customer rating";
            $data['insightDescription'] = "Your customers are happy with your services but there’s still a little room for improvement. Click here to read the task on how to improve your customer satisfactory rating.";
            $data['insightStatus'] = "up";
        }
        elseif($newNumber == 5)
        {
            $data['insightTitle'] = "Perfect customer rating!";
            $data['insightDescription'] = "";
            $data['insightStatus'] = "up";
        }
        else
        {
            $data['insightTitle'] = "Not received any feedback";
            $data['insightDescription'] = "You have not received any feedback. Click here to learn how to get your customers to leave feedback on your site.";
            $data['insightStatus'] = "down";
            $data['objective'] = $id;
        }
    }
    elseif($category == 'analytics' || $category == 'PV')
    {
        if ($type == 'week') {
            $diff = $newNumber/7;
            $diff = round($diff, 2);

            $data['insightTitle'] = "Average of $diff pageviews <br> for last 7 days";
            $data['insightStatus'] = "up";
            $data['insightDescription'] = "Click here to learn how you can increase your website traffic.";
        }
        elseif ($type == 'all') {
            $diff = $newNumber/30;
            $diff = round($diff, 2);

            $data['insightTitle'] = "Average of $diff pageviews <br> for last 30 days";
            $data['insightStatus'] = "up";
            $data['insightDescription'] = "Click here to learn how you can increase your website traffic.";
        }
        elseif ($type == 'day') {
            $diff = $newNumber - $originalNumber;
//            log::info('$diff');
//            log::info($diff);
//            log::info('$newNumber');
//            log::info($newNumber);
//            log::info('$originalNumber');
//            log::info($originalNumber);
            if ($diff == 0 || strpos($diff, '-') !== false) {
                $diff = str_replace('-', '', $diff);
                $data['insightTitle'] = "Down $diff from yesterday";
                $data['insightStatus'] = "down";
            } else {
                $data['insightTitle'] = "Up $diff from yesterday";
                $data['insightStatus'] = "up";
            }

            $data['insightDescription'] = "Click here how to learn more on how you can increase your website traffic.";
        }
        else
        {
            $data['insightTitle'] = "Google Analytics not detected <br> on website.";
            $data['insightDescription'] = "We have not detected your Google Analytics code on your website. <View task> on how to add GA to your website.";
            $data['insightStatus'] = "down";
        }
    }
    else
    {
        if($newNumber >= 0 && $newNumber < 70)
        {
            $data['insightTitle'] = "Poor optimization";
            $data['insightDescription'] = "This page is not optimized and is likely to deliver a slow user experience. Click here to read the task on how to optimize your website.";
            $data['insightStatus'] = "down";
        }
        elseif($newNumber >= 70 && $newNumber < 85)
        {
            $data['insightTitle'] = "Average optimization";
            $data['insightDescription'] = "This page is missing some common performance optimizations that may result in a slow user experience. Click here to read the task on how to optimize your website.";
            $data['insightStatus'] = "average";
        }
        elseif($newNumber >= 85 && $newNumber <= 100)
        {
            $data['insightTitle'] = "Great optimization";
            $data['insightDescription'] = "“Nice work! This page applies most performance best practices and should deliver a good user experience. See how you can optimize your website further. Click here.";
            $data['insightStatus'] = "up";
        }
    }

    $data['insightDescription'] = str_replace('Click here', '<Click here>', $data['insightDescription']);

    if($data['insightDescription'] != '' && $data['objective'] == '')
    {
        $data['objective'] = $id;
    }


    if( empty($data['insightTitle']) )
    {
        return $data = [
            'insightTitle' => '',
            'insightDescription' => '',
            'insightStatus' => '',
            'objective' => '',
        ];
    }

    return $data;
}

function hasWord($word, $text) {
    $patt = "/(?:^|[^a-zA-Z0-9])" . preg_quote($word, '/') . "(?:$|[^a-zA-Z0-9])/i";
    return preg_match($patt, $text);
}



function randomString($length = 8)
{
    $str = "";
    $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}

function getDynamicAppSupportEmail()
{
    return "support@nichepractice.com";
}

function appName()
{
    return getDynamicAppName();
}

function getDynamicAppName()
{
    return 'NichePractice';
}

function getThirdPartyTypeLongToShortForm($type)
{
    $type =  str_replace(" ", "", strtolower($type));

    if ($type == 'tripadvisor') {
        $shortType = 'TA';
    } else if ($type == 'googleplaces') {
        $shortType = 'GP';
    } else if ($type == 'yelp') {
        $shortType = 'YP';
    } else if ($type == 'facebook') {
        $shortType = 'FB';
    }
    else if ($type == 'zocdoc') {
        $shortType = 'ZD';
    }
    else if ($type == 'vitals') {
        $shortType = 'VT';
    }
    else if ($type == 'ratemd') {
        $shortType = 'RM';
    }
    else if ($type == 'healthgrades') {
        $shortType = 'HG';
    }
    return $shortType;
}
function getThirdPartyTypeShortToLongForm($type)
{
    $longType = '';
    if ($type == 'TA') {
        $longType = 'Tripadvisor';
    } else if ($type == 'GP') {
        $longType = 'Google';
    } else if ($type == 'YP') {
        $longType = 'Yelp';
    } else if ($type == 'FB') {
        $longType = 'Facebook';
    }
    else if ($type == 'ZD') {
        $longType = 'Zocdoc';
    }
    else if ($type == 'VT') {
        $longType = 'Vitals';
    }
    else if ($type == 'RM') {
        $longType = 'RateMD';
    }
    else if ($type == 'HG') {
        $longType = 'Healthgrades';
    }

    return $longType;
}

function compareStringGetSubSetResult($scrapperName,$userName)
{

    $userName = preg_replace("/[^a-zA-Z]/", "", strtolower($userName));
    $scrapperName = preg_replace("/[^a-zA-Z]/", "", strtolower($scrapperName));
//    Log::info('original business name '.$userName);
//    Log::info('scrapper normalize name'.$scrapperName);

    if (strpos($scrapperName, $userName) !== false) {
        $res =  'true';
    }else{
        $res = 'false';
    }
    return $res;
}


function get_longest_common_subsequence($string_1, $string_2)
{
    $string_1_length = strlen($string_1);
    $string_2_length = strlen($string_2);
    $return          = '';

    if ($string_1_length === 0 || $string_2_length === 0)
    {
        // No similarities
        return $return;
    }

    $longest_common_subsequence = array();

    // Initialize the CSL array to assume there are no similarities
    $longest_common_subsequence = array_fill(0, $string_1_length, array_fill(0, $string_2_length, 0));

    $largest_size = 0;

    for ($i = 0; $i < $string_1_length; $i++)
    {
        for ($j = 0; $j < $string_2_length; $j++)
        {
            // Check every combination of characters
            if ($string_1[$i] === $string_2[$j])
            {
                // These are the same in both strings
                if ($i === 0 || $j === 0)
                {
                    // It's the first character, so it's clearly only 1 character long
                    $longest_common_subsequence[$i][$j] = 1;

                }
                else
                {
                    // It's one character longer than the string from the previous character
                    $longest_common_subsequence[$i][$j] = $longest_common_subsequence[$i - 1][$j - 1] + 1;
                }

                if ($longest_common_subsequence[$i][$j] > $largest_size)
                {
                    // Remember this as the largest
                    $largest_size = $longest_common_subsequence[$i][$j];
                    // Wipe any previous results
                    $return       = '';
                    // And then fall through to remember this new value
                }

                if ($longest_common_subsequence[$i][$j] === $largest_size)
                {
                    // Remember the largest string(s)
                    $return = substr($string_1, $i - $largest_size + 1, $largest_size);
                }
            }
            // Else, $CSL should be set to 0, which it was already initialized to
        }
    }

    // Return the list of matches
    return $return;
}


//function stringComparisonScore($string1,$string2)
//{
//   // try {
//        $strOne = strtolower($string1);
//        $strTwo = strtolower($string2);
//
//        if(empty($strOne) || empty($strTwo))
//        {
//            return $this->helpError(3, 'Both string requried to give you score');
//        }
//
//
//        $fuzz = new Fuzz();
//
//        $score = $fuzz->tokenSortRatio($strOne, $strTwo);
//        return $score;
//
////    }
////    catch (Exception $exception) {
////        Log::info(" stringComparisonScore helper file> " . $exception->getMessage());
////        return $this->helpError(1, 'An unknown error has occurred. Please try again. please try again later.');
////    }
//}


function getDomain()
{
//    return uri();
    return url('/');
}

function internationalCallingCountryCodes()
{
    return $country_codes = [
        'AE +971' => '971',
        'AD +376' => '376',
        'AG +1268' => '1268',
        'AO +244' => '244',
        'AI +1264' => '1264',
        'AM +374' => '374',
        'AR +54' => '54',
        'AW +297' => '297',
        'AU +61' => '61',
        'AT +43' => '43',
        'AZ +994' => '994',
        'BS +1242' => '1242',
        'BH +973' => '973',
        'BD +880' => '880',
        'BB +1246' => '1246',
        'BY +375' => '375',
        'BE +32' => '32',
        'BZ +501' => '501',
        'BJ +229' => '229',
        'BM +1441' => '1441',
        'BT +975' => '975',
        'BO +591' => '591',
        'BA +387' => '387',
        'BW +267' => '267',
        'BR +55' => '55',
        'BN +673' => '673',
        'BG +359' => '359',
        'BF +226' => '226',
        'BI +257)' => '257',
        'CM +237' => '237',
        'CA +1' => '1',
        'CV +238' => '238',
        'CF +236' => '236',
        'CL +56' => '56',
        'CN +86' => '86',
        'CO +57' => '57',
        'CG +242' => '242',
        'CK +682' => '682',
        'CR +506' => '506',
        'CU +53' => '53',
        'CY +90392' => '90392',
        'CY +357' => '357',
        'CZ +42' => '42',
        'CS +381' => '381',
        'CH +41' => '41',
        'DZ +213' => '213',
        'DK +45' => '45',
        'DJ +253' => '253',
        'DE +49' => '49',
        'DM +1809' => '1809',
        'EC +593' => '593',
        'ES +34' => '34',
        'EG +20' => '20',
        'ER +291' => '291',
        'EE +372' => '372',
        'ET +251' => '251',
        'FK +500' => '500',
        'FO +298' => '298',
        'FJ +679' => '679',
        'FI +358' => '358',
        'FR +33' => '33',
        'FM +691' => '691',
        'GQ +240' => '240',
        'GA +241' => '241',
        'GF +594' => '594',
        'GM +220' => '220',
        'GE +7880' => '7880',
        'GH +233' => '233',
        'GI +350' => '350',
        'GR +30' => '30',
        'GL +299' => '299',
        'GD +1473' => '1473',
        'GP +590' => '590',
        'GU +671' => '671',
        'GT +502' => '502',
        'GN +224' => '224',
        'GW +245' => '245',
        'GY +592' => '592',
        'GB +44' => '44',
        'HR +385' => '385',
        'HT +509' => '509',
        'HN +504' => '504',
        'HK +852' => '852',
        'HU +36' => '36',
        'IS +354' => '354',
        'IN +91' => '91',
        'ID +62' => '62',
        'IR +98' => '98',
        'IQ +964' => '964',
        'IE +353' => '353',
        'IL +972' => '972',
        'IT +39' => '39',
        'JM +1876' => '1876',
        'JP +81' => '81',
        'JO +962' => '962',
        'KY +1345' => '1345',
        'KM +269' => '269',
        'KZ +7' => '7',
        'KE +254' => '254',
        'KI +686' => '686',
        'KP +850' => '850',
        'KR +82' => '82',
        'KH +855' => '855',
        'KW +965' => '965',
        'KG +996' => '996',
        'KN +1869' => '1869',
        'LA +856' => '856',
        'LV +371' => '371',
        'LB +961' => '961',
        'LS +266' => '266',
        'LR +231' => '231',
        'LY +218' => '218',
        'LI +417' => '417',
        'LU +352' => '352',
        'LK +94' => '94',
        'MO +853' => '853',
        'MK +389' => '389',
        'MG +261' => '261',
        'MW +265' => '265',
        'MY +60' => '60',
        'MV +960' => '960',
        'ML +223' => '223',
        'MT +356' => '356',
        'MH +692' => '692',
        'MQ +596' => '596',
        'MR +222' => '222',
        'MX +52' => '52',
        'MD +373' => '373',
        'MC +377' => '377',
        'MN +976' => '976',
        'MS +1664' => '1664',
        'MA +212' => '212',
        'MZ +258' => '258',
        'MN +95' => '95',
        'NA +264' => '264',
        'NR +674' => '674',
        'NP +977' => '977',
        'NL +31' => '31',
        'NC +687' => '687',
        'NZ +64' => '64',
        'NI +505' => '505',
        'NE +227' => '227',
        'NG +234' => '234',
        'NU +683' => '683',
        'NF +672' => '672',
        'NP +670' => '670',
        'NO +47' => '47',
        'OM +968' => '968',
        'PF +689' => '689',
        'PK +92' => '92',
        'PW +680' => '680',
        'PA +507' => '507',
        'PG +675' => '675',
        'PY +595' => '595',
        'PE +51' => '51',
        'PH +63' => '63',
        'PL +48' => '48',
        'PT +351' => '351',
        'PR +1787' => '1787',
        'QA +974' => '974',
        'RE +262' => '262',
        'RO +40' => '40',
        'RU +7' => '7',
        'RW +250' => '250',
        'SV +503' => '503',
        'SM +378' => '378',
        'ST +239' => '239',
        'SA +966' => '966',
        'SN +221' => '221',
        'SC +248' => '248',
        'SL +232' => '232',
        'SG +65' => '65',
        'SK +421' => '421',
        'SI +386' => '386',
        'SB +677' => '677',
        'SO +252' => '252',
        'SH +290' => '290',
        'SC +1758' => '1758',
        'SD +249' => '249',
        'SR +597' => '597',
        'SZ +268' => '268',
        'SE +46' => '46',
        'SI +963' => '963',
        'TW +886' => '886',
        'TJ +7' => '7',
        'TH +66' => '66',
        'TT +1868' => '1868',
        'TG +228' => '228',
        'TO +676' => '676',
        'TT +1868)' => '1868',
        'TN +216' => '216',
        'TR +90' => '90',
        'TM +7' => '7',
        'TC +1649' => '1649',
        'TV +688' => '688',
        'UG +256' => '256',
        'UA +380' => '380',
        'UY +598' => '598',
        'US +1' => '1',
        'UZ +7' => '7',
        'VU +678' => '678',
        'VA +379' => '379',
        'VE +58' => '58',
        'VN +84' => '84',
        'WF +681' => '681',
        'YT +269' => '269',
        'YE +969' => '969',
        'YE +967' => '967',
        'ZA +27' => '27',
        'ZM +260' => '260',
        'ZW +263' => '263'
    ];
}

function getDomainName()
{
    return "NichePractice";
}

function scriptVersion()
{
    return time();
}

function getDomainHeading()
{
    return "NichePractice";
}

function decSerBase($str){
    return unserialize(base64_decode($str));
}

function thirdPartySources($exclude = '')
{
    //        'Vitals',
    $sources = [
        'Zocdoc',
        'Google Places',
        'Facebook',
        'RateMD',
        'Yelp',
        'HealthGrades'
    ];

    return $sources;
}
function thirdPartyModuleSources($exclude = '')
{
//    'Vitals',
    $sources = [
        'Zocdoc',
        'Google Places',
        'Facebook',
        'RateMD',
        'Yelp',
        'HealthGrades',
        'Website'
    ];

    return $sources;
}

function uploadImagePath($file)
{
//    echo "file is $file";
    return url('storage/app/'.$file);
}

function size_as_kb($yoursize) {
    $size_kb = round($yoursize/1024);
    return $size_kb;
}

function lang_code_to_lnag ($code ){
    $lang = null;
    if( $code == 'ab' ) $lang = 'Abkhazian';
    if( $code == 'aa' ) $lang = 'Afar';
    if( $code == 'af' ) $lang = 'Afrikaans';
    if( $code == 'sq' ) $lang = 'Albanian';
    if( $code == 'am' ) $lang = 'Amharic';
    if( $code == 'ar' ) $lang = 'Arabic';
    if( $code == 'an' ) $lang = 'Aragonese';
    if( $code == 'hy' ) $lang = 'Armenian';
    if( $code == 'as' ) $lang = 'Assamese';
    if( $code == 'ay' ) $lang = 'Aymara';
    if( $code == 'az' ) $lang = 'Azerbaijani';
    if( $code == 'ba' ) $lang = 'Bashkir';
    if( $code == 'eu' ) $lang = 'Basque';
    if( $code == 'bn' ) $lang = 'Bengali (Bangla)';
    if( $code == 'dz' ) $lang = 'Bhutani';
    if( $code == 'bh' ) $lang = 'Bihari';
    if( $code == 'bi' ) $lang = 'Bislama';
    if( $code == 'br' ) $lang = 'Breton';
    if( $code == 'bg' ) $lang = 'Bulgarian';
    if( $code == 'my' ) $lang = 'Burmese';
    if( $code == 'be' ) $lang = 'Byelorussian (Belarusian)';
    if( $code == 'km' ) $lang = 'Cambodian';
    if( $code == 'ca' ) $lang = 'Catalan';
    if( $code == 'zh' ) $lang = 'Chinese';
    if( $code == 'zh-Hans' ) $lang = 'Chinese (Simplified)';
    if( $code == 'zh-Hant' ) $lang = 'Chinese (Traditional)';
    if( $code == 'co' ) $lang = 'Corsican';
    if( $code == 'hr' ) $lang = 'Croatian';
    if( $code == 'cs' ) $lang = 'Czech';
    if( $code == 'da' ) $lang = 'Danish';
    if( $code == 'nl' ) $lang = 'Dutch';
    if( $code == 'en' ) $lang = 'English';
    if( $code == 'eo' ) $lang = 'Esperanto';
    if( $code == 'et' ) $lang = 'Estonian';
    if( $code == 'fo' ) $lang = 'Faeroese';
    if( $code == 'fa' ) $lang = 'Farsi';
    if( $code == 'fj' ) $lang = 'Fiji';
    if( $code == 'fi' ) $lang = 'Finnish';
    if( $code == 'fr' ) $lang = 'French';
    if( $code == 'fy' ) $lang = 'Frisian';
    if( $code == 'gl' ) $lang = 'Galician';
    if( $code == 'gd' ) $lang = 'Gaelic (Scottish)';
    if( $code == 'gv' ) $lang = 'Gaelic (Manx)';
    if( $code == 'ka' ) $lang = 'Georgian';
    if( $code == 'de' ) $lang = 'German';
    if( $code == 'el' ) $lang = 'Greek';
    if( $code == 'kl' ) $lang = 'Greenlandic';
    if( $code == 'gn' ) $lang = 'Guarani';
    if( $code == 'gu' ) $lang = 'Gujarati';
    if( $code == 'ht' ) $lang = 'Haitian Creole';
    if( $code == 'ha' ) $lang = 'Hausa';
    if( $code == 'he' ) $lang = 'Hebrew';
    if( $code == 'iw' ) $lang = 'Hebrew';
    if( $code == 'hi' ) $lang = 'Hindi';
    if( $code == 'hu' ) $lang = 'Hungarian';
    if( $code == 'is' ) $lang = 'Icelandic';
    if( $code == 'io' ) $lang = 'Ido';
    if( $code == 'id' ) $lang = 'Indonesian';
    if( $code == 'in' ) $lang = 'Indonesian';
    if( $code == 'ia' ) $lang = 'Interlingua';
    if( $code == 'ie' ) $lang = 'Interlingue';
    if( $code == 'iu' ) $lang = 'Inuktitut';
    if( $code == 'ik' ) $lang = 'Inupiak';
    if( $code == 'ga' ) $lang = 'Irish';
    if( $code == 'it' ) $lang = 'Italian';
    if( $code == 'ja' ) $lang = 'Japanese';
    if( $code == 'jv' ) $lang = 'Javanese';
    if( $code == 'kn' ) $lang = 'Kannada';
    if( $code == 'ks' ) $lang = 'Kashmiri';
    if( $code == 'kk' ) $lang = 'Kazakh';
    if( $code == 'rw' ) $lang = 'Kinyarwanda (Ruanda)';
    if( $code == 'ky' ) $lang = 'Kirghiz';
    if( $code == 'rn' ) $lang = 'Kirundi (Rundi)';
    if( $code == 'ko' ) $lang = 'Korean';
    if( $code == 'ku' ) $lang = 'Kurdish';
    if( $code == 'lo' ) $lang = 'Laothian';
    if( $code == 'la' ) $lang = 'Latin';
    if( $code == 'lv' ) $lang = 'Latvian (Lettish)';
    if( $code == 'li' ) $lang = 'Limburgish ( Limburger)';
    if( $code == 'ln' ) $lang = 'Lingala';
    if( $code == 'lt' ) $lang = 'Lithuanian';
    if( $code == 'mk' ) $lang = 'Macedonian';
    if( $code == 'mg' ) $lang = 'Malagasy';
    if( $code == 'ms' ) $lang = 'Malay';
    if( $code == 'ml' ) $lang = 'Malayalam';
    if( $code == 'mt' ) $lang = 'Maltese';
    if( $code == 'mi' ) $lang = 'Maori';
    if( $code == 'mr' ) $lang = 'Marathi';
    if( $code == 'mo' ) $lang = 'Moldavian';
    if( $code == 'mn' ) $lang = 'Mongolian';
    if( $code == 'na' ) $lang = 'Nauru';
    if( $code == 'ne' ) $lang = 'Nepali';
    if( $code == 'no' ) $lang = 'Norwegian';
    if( $code == 'oc' ) $lang = 'Occitan';
    if( $code == 'or' ) $lang = 'Oriya';
    if( $code == 'om' ) $lang = 'Oromo (Afaan Oromo)';
    if( $code == 'ps' ) $lang = 'Pashto (Pushto)';
    if( $code == 'pl' ) $lang = 'Polish';
    if( $code == 'pt' ) $lang = 'Portuguese';
    if( $code == 'pa' ) $lang = 'Punjabi';
    if( $code == 'qu' ) $lang = 'Quechua';
    if( $code == 'rm' ) $lang = 'Rhaeto-Romance';
    if( $code == 'ro' ) $lang = 'Romanian';
    if( $code == 'ru' ) $lang = 'Russian';
    if( $code == 'sm' ) $lang = 'Samoan';
    if( $code == 'sg' ) $lang = 'Sangro';
    if( $code == 'sa' ) $lang = 'Sanskrit';
    if( $code == 'sr' ) $lang = 'Serbian';
    if( $code == 'sh' ) $lang = 'Serbo-Croatian';
    if( $code == 'st' ) $lang = 'Sesotho';
    if( $code == 'tn' ) $lang = 'Setswana';
    if( $code == 'sn' ) $lang = 'Shona';
    if( $code == 'ii' ) $lang = 'Sichuan Yi';
    if( $code == 'sd' ) $lang = 'Sindhi';
    if( $code == 'si' ) $lang = 'Sinhalese';
    if( $code == 'ss' ) $lang = 'Siswati';
    if( $code == 'sk' ) $lang = 'Slovak';
    if( $code == 'sl' ) $lang = 'Slovenian';
    if( $code == 'so' ) $lang = 'Somali';
    if( $code == 'es' ) $lang = 'Spanish';
    if( $code == 'su' ) $lang = 'Sundanese';
    if( $code == 'sw' ) $lang = 'Swahili (Kiswahili)';
    if( $code == 'sv' ) $lang = 'Swedish';
    if( $code == 'tl' ) $lang = 'Tagalog';
    if( $code == 'tg' ) $lang = 'Tajik';
    if( $code == 'ta' ) $lang = 'Tamil';
    if( $code == 'lz' ) $lang = 'Balaji';
    if( $code == 'tt' ) $lang = 'Tatar';
    if( $code == 'te' ) $lang = 'Telugu';
    if( $code == 'th' ) $lang = 'Thai';
    if( $code == 'bo' ) $lang = 'Tibetan';
    if( $code == 'ti' ) $lang = 'Tigrinya';
    if( $code == 'to' ) $lang = 'Tonga';
    if( $code == 'ts' ) $lang = 'Tsonga';
    if( $code == 'tr' ) $lang = 'Turkish';
    if( $code == 'tk' ) $lang = 'Turkmen';
    if( $code == 'tw' ) $lang = 'Twi';
    if( $code == 'ug' ) $lang = 'Uighur';
    if( $code == 'uk' ) $lang = 'Ukrainian';
    if( $code == 'ur' ) $lang = 'Urdu';
    if( $code == 'uz' ) $lang = 'Uzbek';
    if( $code == 'vi' ) $lang = 'Vietnamese';
    if( $code == 'vo' ) $lang = 'Volap�k';
    if( $code == 'wa' ) $lang = 'Wallon';
    if( $code == 'cy' ) $lang = 'Welsh';
    if( $code == 'wo' ) $lang = 'Wolof';
    if( $code == 'xh' ) $lang = 'Xhosa';
    if( $code == 'yi' ) $lang = 'Yiddish';
    if( $code == 'ji' ) $lang = 'Yiddish';
    if( $code == 'yo' ) $lang = 'Yoruba';
    if( $code == 'zu' ) $lang = 'Zulu';
    if( $code == '') $lang = 'Unknown';
    if( $lang == null) $lang = strtoupper($code);
    return $lang;
}


//
function nextInvoice($subscriptionDate)
{
    $statusData = [];
    # code...
    $trialEndsAt = Date('Y-m-d', strtotime('+1 month', strtotime($subscriptionDate)));
    $currentDay = Date('Y-m-d', time());
    $targetDay = Date('Y-m-d', strtotime($trialEndsAt));
    $diff=date_diff(date_create($targetDay),date_create($currentDay));
    $dateDiff = $diff->format("%R%a");
    if($dateDiff <= 0) {
        if($dateDiff == 31) {
            $dateDiff = 30;
        }
        if (str_replace(["-", "+"], ["", ""], $dateDiff) <= 1) {
            # code...
//            return str_replace(["-", "+"], ["", ""], $dateDiff) . ' day left.';

            $statusData['status'] = str_replace(["-", "+"], ["", ""], $dateDiff) . ' day left.';
            $statusData['days'] = str_replace(["-", "+"], ["", ""], $dateDiff);

            return $statusData;

        } else {
            # code...
//            return str_replace(["-", "+"], ["", ""], $dateDiff) . ' days left.';
            $statusData['status'] = str_replace(["-", "+"], ["", ""], $dateDiff) . ' days left.';
            $statusData['days'] = str_replace(["-", "+"], ["", ""], $dateDiff);

            return $statusData;
        }

    } else {
//        return 'Expired';
        $statusData['status'] = 'Expired';
        $statusData['days'] = 1000;

        return $statusData;
    }

}

function trailEnds($trailEndsDate)
{
    $statusData = [];

    # code...
    $trialEndsAt = $trailEndsDate;
    $currentDay = Date('Y-m-d', time());
    $targetDay = Date('Y-m-d', strtotime($trialEndsAt));
    $diff=date_diff(date_create($targetDay),date_create($currentDay));
    $dateDiff = $diff->format("%R%a");
    if($dateDiff <= 0) {
        if($dateDiff == 31) {
            $dateDiff = 30;
        }
        if (str_replace(["-", "+"], ["", ""], $dateDiff) <= 1) {
            # code...
//            return str_replace(["-", "+"], ["", ""], $dateDiff) . ' day left.';

            $statusData['status'] = str_replace(["-", "+"], ["", ""], $dateDiff) . ' day left.';
            $statusData['days'] = str_replace(["-", "+"], ["", ""], $dateDiff);

            return $statusData;

        } else {
            $statusData['status'] = str_replace(["-", "+"], ["", ""], $dateDiff) . ' days left.';
            $statusData['days'] = str_replace(["-", "+"], ["", ""], $dateDiff);

            return $statusData;
        }
    } else {
        $statusData['status'] = 'Expired';
        $statusData['days'] = 1000;

        return $statusData;
//        return 'Expired';
    }
}

function creditText($module)
{
    if($module == 'business_task')
    {
        $str = 'TO-DO-LIST';
    }
    else if($module == 'email_templates_pre_order')
    {
        $str = 'Premium Email Template';
    }
    else if($module == 'promotion_templates_pre_order')
    {
        $str = 'Premium Promotion Template';
    }
    else if($module == 'new-patient-emails')
    {
        $str = 'New Patient Email DESIGN SERVICE';
    }
    else if($module == 'new-patient-emails')
    {
        $str = 'New Patient Email DESIGN SERVICE';
    }
    else if($module == 'user_task_category')
    {
        $str = 'Marketing Campaign';
    }
    else if($module == 'marketing_pro_service')
    {
        $str = 'Marketing Pro Service';
    }
    else
    {
        $str = $module;
    }

    return $str;
}

function totalTasksCount($list, $taskModule = 'marketing_tasks')
{
    if(!empty($list['records'][$taskModule]))
    {
        $loopCount = count($list['records'][$taskModule]);
    }
    else
    {
        $loopCount = 0;
    }

    $totalTasks = 0;
    for($i=0; $i < $loopCount; $i++)
    {
        if(!empty($list['records'][$taskModule][$i]['tasks']))
        {
            $totalTasks += count($list['records'][$taskModule][$i]['tasks']);
        }
    }

    return $totalTasks;
}

