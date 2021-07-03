<?php


namespace Modules\ThirdParty\Entities;


use App\Entities\AbstractEntity;
use App\Traits\UserAccess;
use Exception;
use GuzzleHttp\Client;
use Log;
use Config;

class OnlineDirectoryEntity extends AbstractEntity
{

    use UserAccess;


    public function __construct()
    {

    }

    public function getZocDocListingDetail($businessUrl)
    {
        try {
            Log::info("getZocDocListingDetail");
            $client = new Client([]);

            $serverUrl = Config::get('custom.Scrapper_Online_Directory_URL');
            $scrapperUrl = Config::get('custom.zocDocManualConnect');

            $url = $serverUrl . $scrapperUrl;

//            Log::info("url ");
//            Log::info($url);

            $response = $client->request(
                'GET',
                $url,
                [
                    'query' => [
                        'key'=> '3E265565747A3',
                        'url' => $businessUrl,
                        'pagination' => 'true',
                        'paginationLimit' => 1,
                    ]
                ]
            );

            $responseData = json_decode($response->getBody()->getContents(), true);

            if ($responseData['code'] == 200 && !empty($responseData['Results']['Name'])) {
                return $this->helpReturn("Zoc Doc Listing Detail", $responseData['Results']);

            }

            return $this->helpError(404, 'Record not found.');
        } catch (Exception $e) {
            Log::info(" getLocationDetail " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }


    public function getHealthGradeListingDetail($businessUrl)
    {
        try {
//            $businessUrl = $request->get('businessUrl');

            $client = new Client([]);

            $serverUrl = config('custom.Scrapper_Online_Directory_URL');
            $scrapperUrl = config('custom.healthGradeManualConnect');

            $url = $serverUrl . $scrapperUrl;

            $response = $client->request(
                'GET',
                $url,
                [
                    'query' => [
                        'key'=> '87AD8F91D83A4',
                        'url' => $businessUrl,
                        'pagination' => 'true',
                        'paginationLimit' => '3'
                    ]
                ]
            );

            $responseData = json_decode($response->getBody()->getContents(), true);

            if ($responseData['code'] == 200 && !empty($responseData['Results']['Name'])) {
                return $this->helpReturn("Health Grade Listing Detail", $responseData['Results']);

            }

            return $this->helpError(404, 'Record not found.');
        } catch (Exception $e) {
            Log::info(" getHealthGradeListingDetail " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }


    public function getRateMdsListingDetail($businessUrl)
    {
        try {
//            $businessUrl = $request->get('businessUrl');

            $client = new Client([]);

            $serverUrl = Config::get('custom.Scrapper_Online_Directory_URL');
            $scrapperUrl = Config::get('custom.rateMdsManualConnect');

            $url = $serverUrl . $scrapperUrl;

            $response = $client->request(
                'POST',
                $url,
                [
                    'form_params' => [
                        'url' => $businessUrl,
                        'key'=> '7C842B72B916B',
                    ]
                ]
            );

            $responseData = json_decode($response->getBody()->getContents(), true);

            if ($responseData['code'] == 200 && !empty($responseData['Results']['Name'])) {
                return $this->helpReturn("Ratemd Listing Detail", $responseData['Results']);

            }

            return $this->helpError(404, 'Record not found.');
        } catch (Exception $e) {
            Log::info(" getRateMdsListingDetail " . $e->getMessage());
            return $this->helpError(1, 'An unknown error has occurred. Please try again.');
        }
    }


}
