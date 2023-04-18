<?php
 
namespace Tests\Feature;
 
use Tests\TestCase;
 
class ApiTest extends TestCase
{
    public function test_the_api(): void
    {
        $response = $this->getJson('/api/v1/albums?q=queen');
        // dd($response);
        $response
            ->assertStatus(200)
            ->assertJsonIsArray()
            ->assertJsonStructure([
                '*' => [
                    'name',
                    'released',
                    'tracks',
                    'cover',
                ],
            ]);
    }

    public function test_the_api_validation(): void
    {
        $response = $this->getJson('/api/v1/albums?q=');
        $response->assertStatus(422);

        $response = $this->getJson('/api/v1/albums');
        $response->assertStatus(422);

        $response = $this->getJson('/api/v1/albums?q=a');
        $response->assertStatus(422);
    }
}