<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SpotifyService
{
    private string $client_id;
    private string $client_secret;
    private string $token;

    public function __construct()
    {
        $this->client_id = env('SPOTIFY_CLIENT_ID');
        $this->client_secret = env('SPOTIFY_CLIENT_SECRET');
        $this->token = $this->getToken();
    }

    public function getToken()
    {
        Http::post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
        ]);
    }

}