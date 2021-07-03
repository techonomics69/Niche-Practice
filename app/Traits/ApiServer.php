<?php
namespace App\Traits;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Config;
use Log;

trait ApiServer
{
    public function serveApiRequest($url = '')
    {
//        $url = url('/') .'/';
//        Log::info(" url " . $url);
        $url = '';
        $client = new Client([
            // Base URI is used with relative requests
//            'base_uri' => config::get('global.targetBaseUri')
            'base_uri' => $url
        ]);

        return $client;
    }

    public function sendgridServeApiRequest()
    {
        $url = 'https://api.sendgrid.com/v3/';
        $client = new Client([
            // Base URI is used with relative requests
//            'base_uri' => config::get('global.targetBaseUri')
            'base_uri' => $url
        ]);

        return $client;
    }
}
