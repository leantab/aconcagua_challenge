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
}