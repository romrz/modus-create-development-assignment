<?php

namespace App\Http\Controllers;

use App\VehiclesClient;
use Illuminate\Http\Request;
use App\Transformers\VehicleTransformer;

class VehiclesController extends Controller
{
    /**
     * @var VehiclesClient
     */
    protected $client;

    /**
     * @var VehicleTransformer
     */
    protected $transformer;

    /**
     * Initializes the controller instance with the
     * appropiate dependencies.
     */
    public function __construct()
    {
        $this->client = new VehiclesClient();
        $this->transformer = new VehicleTransformer();
    }

    /**
     * Get the list of vehicles.
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Perform the request to the external API
        $response = $this->client->getVehicles(
            $request->modelYear,
            $request->manufacturer,
            $request->model,
            $request->withRating == 'true' ?? false
        );

        // Respond with empty results if the request was invalid
        if($response == null) return $this->respondOK();

        $results = $this->transformer->transformCollection($response->Results);

        return $this->respondOK($results);
    }

    /**
     * Helper function to respond with status OK - 200 and
     * the given results.
     * 
     * @param array $results 
     * @return Illuminate\Http\Response
     */
    private function respondOK($results = [])
    {
        return response()->json([
            'Count' => count($results),
            'Results' => $results
        ], 200);
    }

}
