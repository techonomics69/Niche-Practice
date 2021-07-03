<?php

namespace Modules\Business\Entities;

use App\Entities\AbstractEntity;
use App\Traits\GlobalResponseTrait;
use Exception;
use Log;
use DB;
use Illuminate\Http\Request;
use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;
// use Modules\Business\Models\GoogleSearch;

class GoogleSearchEntity extends AbstractEntity
{
    use GlobalResponseTrait;

    /**
     * This function is not used at the moment
     */

    public function getSearchResult($request)
    {
        // dd($request->all());
        $searchFor = $request->get('searchFor');

        if($searchFor != '')
        {
            try
            {
                $fulltext = new LaravelGoogleCustomSearchEngine(); // initialize

                // dd($fulltext);
                // $fulltext->setEngineId('005484247109571911046:caci1nizay0'); // sets the engine ID
                // $fulltext->setApiKey('someApiId'); // sets the API key
                // dd($fulltext);
                $results = $fulltext->getResults($searchFor, ['num' => 10]); // get first 5 results for query 'some phrase'
                // dd($results);
                $searchResultData = [];
                $i = 0;
                foreach ($results as $searchResult)
                {
                    $searchResultData[$i]['title'] = $searchResult->title;
                    $searchResultData[$i]['url'] = $searchResult->link;
                    $searchResultData[$i]['description'] = $searchResult->snippet;
                    $i++;
                }
               // $this->saveSearchData($searchResultData);

                return $this->helpReturn('Results are.', $searchResultData);
            }
            catch (Exception $e)
            {
                Log::info(" getSearchResult " . $e->getMessage());
                return $this->helpError(1, 'An unknown error has occurred. Please try again.');
            }
        }
        else
        {
            return $this->helpError(2, 'Search string is missing.');
        }
    }

    // public function saveSearchData($searchResultData)
    // {
    //     if($searchResultData)
    //     {
    //          GoogleSearch::insert($searchResultData);
    //     }
    // }

    // public function testTimeFormat($request)
    // {
    //     $searchFor = $request->get('searchFor');

    //     $timeFormat = messageTimeFormat($searchFor);

    //     return $timeFormat;

    // }

}
