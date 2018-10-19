<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class VehiclesController extends Controller
{
    /**
     * Get the list of vehicles.
     * 
     * @param string $year 
     * @param string $manufacturer 
     * @param string $model 
     * @return Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = $this->makeRequest(
            $request->modelYear,
            $request->manufacturer,
            $request->model
        );
        $response = $this->transformResponse($response);

        return response()->json($response, 200);
    }

    /**
     * Perform the request to the external API
     * 
     * @param strin $year 
     * @param string $manufacturer 
     * @param string $model 
     * @return Object
     */
    private function makeRequest($year, $manufacturer, $model)
    {
        $url = "https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/$year/make/$manufacturer/model/$model?format=json";

        $client = new Client();

        try
        {
            $response = $client->get($url);
            $json = json_decode($response->getBody(true)->getContents());
        }
        catch (\Exception $e)
        {
            return null;
        }

        return $json;
    } 

    /**
     * Transform the response from the external API to our needs.
     * 
     * @param Object $response 
     * @return array
     */
    private function transformResponse($response)
    {
        if($response == null) {
            return  [
                'Count' => 0,
                'Results' => []
            ];
        }

        return [
            'Count' => $response->Count,
            'Results' => $this->transformResults($response->Results)
        ];
    }

    /**
     * Transform the collection of results from the response
     * of the external API.
     * 
     * @param array $items 
     * @return array
     */
    private function transformResults($items)
    {
        $result = [];
        
        foreach($items as $item)
        {
            $result[] = [
                'Description' => $item->VehicleDescription,
                'VehicleId' => $item->VehicleId
            ];
        } 

        return $result;
    }

}
