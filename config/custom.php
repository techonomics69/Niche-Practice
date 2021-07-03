<?php
/**
 * Created by Abdul Rehman
 * Date: 20-Aug-17
 * Time: 2:17 PM
 */

return
    [
//        'webAppDomain' => 'http://localhost/projects/madison-webapp',

        'webAppDomain' => '',

//        'webAppDomain' => 'https://dev-app.netblaze.com',

        'SERVER_URL' =>'http://landingpagelaunchpad.com/',

        'PEN_SERVER_URL' => 'http://198.211.104.70:8089/',

        'Scrapper_Prod_SERVER_URL' =>'http://landingpagelaunchpad.com/',

        'PEN_Scrapper_Prod_SERVER_URL' =>'http://198.211.104.70:8089/',


        'Scrapper_Online_Directory_URL' => 'http://198.211.104.70:8089/',

        'stripeTestUserDetail' =>'madisonsandbox/stripe/sandbox/UserDetail',

        'stripeProdUserDetail' =>'stripe/live/UserDetail',

        'facebookTestBusinessDetail' =>'madisonsandbox/api/home/GetFacebookBuisnessDetailG',

        'facebookProdBusinessDetail' =>'madisonlive/api/home/GetFacebookBuisnessDetailG',

        //'tripAdvisorTestBusinessDetail' =>'madisonsandbox/api/home/GetBuisnessDetailG',
        'tripAdvisorTestBusinessDetail' =>'api/tripAdvisor/scrape',

       // 'tripAdvisorProdBusinessDetail' =>'madisonlive/api/home/GetBuisnessDetailG',
        'tripAdvisorProdBusinessDetail' =>'api/tripAdvisor/scrape',


       // 'tripAdvisorTestManualConnect' => 'madisonsandbox/api/home/GetBuisnessDetailByURL',
        'tripAdvisorTestManualConnect' => 'api/tripAdvisor/scrape',

       // 'tripAdvisorProdManualConnect' => 'madisonlive/api/home/GetBuisnessDetailByURL',
        'tripAdvisorProdManualConnect' => 'api/tripAdvisor/scrape',


        'landingYelpTestBusinessDetail' =>'madisonsandbox/api/home/GetyelpBuisnessDetailG',

        'landingYelpProdBusinessDetail' =>'madisonlive/api/home/GetyelpBuisnessDetailG',


        'landingYelpTestManualConnect' =>'madisonsandbox/api/home/GetYelpBuisnessDetailByURL',

        'landingYelpProdManualConnect' =>'madisonlive/api/home/GetYelpBuisnessDetailByURL',

        'yelpTestBusinessDetail' =>'api/yelp/scrape',

        'yelpProdBusinessDetail' =>'api/yelp/scrape',


        'yelpTestManualConnect' =>'api/yelp/scrape',

        'yelpProdManualConnect' =>'api/yelp/scrape',


        'landingGoogleTestManualConnect' =>'madisonsandbox/api/home/GetGooglePlaceBusinessDetailByURL',
//
//
        'landingGoogleProdManualConnect' =>'madisonlive/api/home/GetGooglePlaceBusinessDetailByURL',

        'googleTestManualConnect' =>'api/googleMap/scrape',

        'googleProdManualConnect' =>'api/googleMap/scrape',

        'zocDocManualConnect' => 'api/zocdoc/scrape',

        'healthGradeManualConnect' => 'api/healthgrade/scrape',

        'rateMdsManualConnect' => 'api/ratemds/scrape',

        'sendgrid' => [
            'list' => [
                'create_list' => 'marketing/lists'
            ],
        ]
    ];
