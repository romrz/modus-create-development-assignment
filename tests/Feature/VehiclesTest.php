<?php

namespace Tests\Feature;

use Tests\TestCase;

class VehiclesTest extends TestCase
{
    /**
     * Requirement #1 Test
     * @test
     */  
    public function it_returns_a_list_of_vehicles_using_url_parameters()
    {
        $response = $this->json('GET', '/vehicles/2015/Audi/A3');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'Count',
                'Results' => [
                    '*' => [
                        'Description',
                        'VehicleId'
                    ]
                ]
            ]);
    }

    /**
     * Requirement #1 Test
     * @test
     */
    public function it_returns_no_results_with_invalid_url_parameters()
    {
        $response = $this->json('GET', '/vehicles/undefined/Honda/Accord');

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'Count' => 0,
                'Results' => []
            ]);
    }

    /**
     * Requirement #2 Test
     * @test
     */
    public function it_returns_a_list_of_vehicles_using_body_parameters()
    {
        $response = $this->json('POST', '/vehicles', [
            'modelYear' => 2015,
            'manufacturer' => 'Audi',
            'model' => 'A3'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'Count',
                'Results' => [
                    '*' => [
                        'Description',
                        'VehicleId'
                    ]
                ]
            ]);
    }

    /**
     * Requirement #2 Test
     * @test
     */
    public function it_returns_no_results_with_invalid_body_parameters()
    {
        $response = $this->json('POST', '/vehicles', [
            'manufacturer' => 'Honda',
            'model' => 'Accord'
        ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'Count' => 0,
                'Results' => []
            ]);
    } 

    /**
     * Requirement #3 Test
     * @test
     */
    public function it_returns_a_list_of_vehicles_with_crash_rating()
    {
        $response = $this->json('GET', '/vehicles/2015/Audi/A3?withRating=true');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'Count',
                'Results' => [
                    '*' => [
                        'CrashRating',
                        'Description',
                        'VehicleId'
                    ]
                ]
            ]);
    }

    /**
     * Requirement #3 Test
     * @test
     */
    public function it_returns_a_list_of_vehicles_without_crash_ratings()
    {
        $response1 = $this->json('GET', '/vehicles/2015/Audi/A3?withRating=false');
        $response2 = $this->json('GET', '/vehicles/2015/Audi/A3?withRating=bananas');

        $response1
            ->assertStatus(200)
            ->assertJsonStructure([
                'Count',
                'Results' => [
                    '*' => [
                        'Description',
                        'VehicleId'
                    ]
                ]
            ]);

        $response2
            ->assertStatus(200)
            ->assertJsonStructure([
                'Count',
                'Results' => [
                    '*' => [
                        'Description',
                        'VehicleId'
                    ]
                ]
            ]);
    }

}
