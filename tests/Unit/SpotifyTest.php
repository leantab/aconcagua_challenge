<?php

namespace Tests\Unit;

use App\Services\SpotifyService;
use Tests\TestCase;

class SpotifyTest extends TestCase
{
    public function test_that_token_is_valid(): void
    {
        $service = new SpotifyService();
        $this->assertNotNull($service->showToken());
    }

    public function test_that_search_returns_array(): void
    {
        $service = new SpotifyService();
        $search = $service->searchForArtist('The Beatles');
        $this->assertNotNull($search);
        $this->assertIsArray($search);
        $this->assertArrayHasKey('id', $search);
    }

    public function test_that_albums_returns_array(): void
    {
        $service = new SpotifyService();
        $search = $service->searchForArtist('The Beatles');
        $albums = $service->getArtistAlbums($search['id']);
        $this->assertNotNull($albums);
        $this->assertIsArray($albums);
        $this->assertArrayNotHasKey('errors', $albums);
        $this->assertArrayHasKey('id', $search);
    }
}
