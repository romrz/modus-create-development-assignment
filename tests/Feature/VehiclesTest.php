<?php

namespace Tests\Feature;

use Tests\TestCase;

class VehiclesTest extends TestCase
{
    /**
     * Requirement #1 Test
     * @test
     */  
    public function it_retrieves_a_list_of_vehicles_passing_url_parameters()
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
    public function it_retrieves_no_results_with_invalid_parameters()
    {
        $response = $this->json('GET', '/vehicles/invalid/invalid/invalid');

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'Count' => 0,
                'Results' => []
            ]);
    }

}
