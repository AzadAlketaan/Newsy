<?php


namespace App\Services\NewsAPI;

use jcobhams\NewsApi\NewsApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Models\ErrorLogs;
use Exception;

class NewsAPIService
{
    private NewsAPI $newsapi;
    public static $SUCCESS = 'ok';
    public static $ItemsPerPage = 50;
    public static $NumOfPages = 1;

    public function __construct()
    {
        $this->newsapi = new NewsAPI(config('constants.newsapi.token'));
    }

    public function getCategories(): Array
    {
        try
        {
            // Call: getCategories
            $response = $this->newsapi->getCategories();

            // Logging
            if (!empty($response)) return $response;

            ErrorLogs::addToLog('Failed Get Top Categories', $response);
            return [];

        } catch (Exception $exception) {
            ErrorLogs::addToLog('Failed Get Categories', $exception->getMessage());
            return [];
        }
    }
    
    public function getCountries(): Array
    {
        try
        {
            // Call: getCountries
            $response = $this->newsapi->getCountries();

            // Logging
            if (!empty($response)) return $response;

            ErrorLogs::addToLog('Failed Get Countries', $response);
            return [];

        } catch (Exception $exception) {
            ErrorLogs::addToLog('Failed Get Countries', $exception->getMessage());
            return [];
        }
    }
    
    public function getLanguages(): Array
    {
        try
        {
            // Call: getLanguages
            $response = $this->newsapi->getLanguages();

            // Logging
            if (!empty($response)) return $response;

            ErrorLogs::addToLog('Failed Get Languages', $response);
            return [];

        } catch (Exception $exception) {
            ErrorLogs::addToLog('Failed Get Languages', $exception->getMessage());
            return [];
        }
    }

    public function getSources($category = null, $language = null, $country = null): Array
    {
        try
        {
            // Call: getSources
            $response = $this->newsapi->getSources($category, $language, $country);
            
            // Logging
            if ($response->status == NewsAPIService::$SUCCESS) return $response->sources;

            ErrorLogs::addToLog('Failed Get Sources', $response);
            return [];

        } catch (Exception $exception) {
            ErrorLogs::addToLog('Failed Get Sources', $exception->getMessage());
            return [];
        }
    }

    public function getTopHeadlines($q = null, $sources, $country = null, $category = null, $page_size = null, $page = null): Array
    {
        try
        {
            // Call: getTopHeadlines
            $response = $this->newsapi->getTopHeadlines($q, $sources, $country, $category, NewsAPIService::$ItemsPerPage, NewsAPIService::$NumOfPages);

            // Logging
            if ($response->status == NewsAPIService::$SUCCESS) return $response->articles;

            ErrorLogs::addToLog('Failed Get Top Headlines', $response);
            return [];

        } catch (Exception $exception) {
            ErrorLogs::addToLog('Failed Get Top Headlines', $exception->getMessage());
            return [];
        }
    }

    public function getEverything($q = null, $sources, $domains = null, $exclude_domains = null, $from = null, $to = null, $language = null, $sort_by = null,  $page_size = null, $page = null): Array
    {
        try
        {
            // Call: getEverything
            $response = $this->newsapi->getEverything($q, $sources, $domains, $exclude_domains, $from, $to, $language, $sort_by, NewsAPIService::$ItemsPerPage, NewsAPIService::$NumOfPages);

            // Logging
            if ($response->status == NewsAPIService::$SUCCESS) return $response->articles;

            ErrorLogs::addToLog('Failed Get Everything', $response);
            return [];

        } catch (Exception $exception) {
            ErrorLogs::addToLog('Failed Get Everything', $exception->getMessage());
            return [];
        }
    }
}
