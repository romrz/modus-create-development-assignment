<?php

namespace App;

use GuzzleHttp\Client;

class VehiclesClient
{
    /**
     * @var string
     */
    private $baseUrl = 'https://one.nhtsa.gov/webapi/api/SafetyRatings';

    /**
     * @var $client  Http client to perform the requests to the external API
     */
    private $client;

    /**
     * Initialize the instance with the appropiate dependencies.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Get the list of vehicles matching the parameters 
     * 
     * @param strin $year 
     * @param string $manufacturer 
     * @param string $model 
     * @param bool $withRating 
     * @return Object
     */
    public function getVehicles($year, $manufacturer, $model, $withRating = false)
    {
        $url = "$this->baseUrl/modelyear/$year/make/$manufacturer/model/$model?format=json";

        $response = $this->makeRequest($url);

        if($response && $withRating)
        {
            $response = $this->appendRatings($response);
        }

        return $response;
    } 

    /**
     * Get the information about a single vehicle.
     * 
     * @param int $vehicleId 
     * @return Object
     */
    public function getVehicle($vehicleId)
    {
        $url = "$this->baseUrl/VehicleId/$vehicleId?format=json"; 
        return $this->makeRequest($url);
    } 

    /**
     * Append the 'OverallRating' value for each of the cars in the response.
     * 
     * @param Object $response 
     * @return Object
     */
    private function appendRatings($response)
    {
        foreach($response->Results as $i => $item)
        {
            $res = $this->getVehicle($item->VehicleId);
            $response->Results[$i]->OverallRating = $res->Results[0]->OverallRating;
        }

        return $response;
    }

    /**
     * Performs a GET request to the given URL and gets the response as JSON
     *  
     * @param string $url 
     * @return Object
     */
    private function makeRequest($url)
    {
        try
        {
            $response = $this->client->get($url);
            $json = json_decode($response->getBody(true)->getContents());
        }
        catch (\Exception $e)
        {
            return null;
        }

        return $json;
    }

}