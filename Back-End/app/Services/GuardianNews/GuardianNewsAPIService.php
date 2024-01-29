<?php


namespace App\Services\GuardianNews;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ErrorLogs;
use Exception;

class GuardianNewsAPIService
{
    public static $SUCCESS = 'ok';

    public static function getTags()
    {
        try
        { 
            $response = Http::withHeaders([
                'content-type' => 'application/json',
            ])->get(config('constants.guardiannews.url') . '/tags', [
                'Accept' => 'application/json',
                'api-key' => config('constants.guardiannews.token')
            ]);
            
            // Logging
            if ($response['response']['status'] == GuardianNewsAPIService::$SUCCESS) return $response['response']['results'];

            ErrorLogs::addToLog('Failed Get Tags', $response);
            return [];

        } catch (Exception $exception) {
            ErrorLogs::addToLog('Failed Get Tags', $exception->getMessage());
            return [];
        }
    }

    public static function getSections()
    {
        try
        { 
            $response = Http::withHeaders([
                'content-type' => 'application/json',
            ])->get(config('constants.guardiannews.url') . '/sections', [
                'Accept' => 'application/json',
                'api-key' => config('constants.guardiannews.token')
            ]);
            
            // Logging
            if ($response['response']['status'] == GuardianNewsAPIService::$SUCCESS) return $response['response']['results'];

            ErrorLogs::addToLog('Failed Get Sections', $response);
            return [];

        } catch (Exception $exception) {
            ErrorLogs::addToLog('Failed Get Sections', $exception->getMessage());
            return [];
        }
    }


    public static function getEverything($query = null)
    {
        try 
        {
            $response = Http::withHeaders([
                'content-type' => 'application/json',
            ])->get(config('constants.guardiannews.url') . '/search', [
                'Accept' => 'application/json',
                'api-key' => config('constants.guardiannews.token'),
                'q' => $query
            ]);

            // Logging
            if ($response['response']['status'] == GuardianNewsAPIService::$SUCCESS) return $response['response']['results'];

            ErrorLogs::addToLog('Failed Get Sources', $response);
            return [];

        } catch (Exception $exception) {
            ErrorLogs::addToLog('Failed Get Categories', $exception->getMessage());
            return [];
        }
    }   
}
