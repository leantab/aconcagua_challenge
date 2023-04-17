<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\Log;

class SpotifyService
{
    private string $client_id;
    private string $client_secret;
    private ?string $token;
    private string $token_url = 'https://accounts.spotify.com/api/token';
    private string $base_url = 'https://api.spotify.com/v1/';

    public function __construct()
    {
        $this->client_id = env('SPOTIFY_CLIENT_ID');
        $this->client_secret = env('SPOTIFY_CLIENT_SECRET');
        // $this->token = $this->getToken();
        $this->token = 'BQAp3Kn6n1SHX3ca3WxTt6VBS1glz-lV4t9OncsFCOC81iVsBwCCwp64ghMpM_hs5UPQ2cpHtROV4sPzL-ee9yxOG56MQ9wkXSe69_Ib4v-S376V_vbT';
    }

    public function getToken(): ?string
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post($this->token_url, [
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'grant_type' => 'client_credentials',
            ])->json();
            
            if (true === array_key_exists('error', $response)) {
                throw new Exception($response['error_description']);
            }

            if (false === array_key_exists('access_token', $response)) {
                throw new Exception('Spotify API token not found');
            }

            return $response['access_token'];
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function showToken(): ?string
    {
        return $this->token;
    }

    public function searchForArtist($artist): ?array
    {
        try {
            $response = Http::withToken($this->token)->get($this->base_url . 'search', [
                'q' => $artist,
                'type' => 'artist',
                'limit' => 1,
            ])->json();

            // dd($response);
            if (false === array_key_exists('artists', $response)) {
                throw new \Exception('Spotify API artists not found');
            }

            $artists = $response['artists'];
            // dd($artists);
            if (false === array_key_exists('items', $artists)) {
                throw new Exception('Spotify API artists not found');
            }

            $items = $artists['items'];
            // dd($items);
            return $items[0];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function getArtist(string $artistId): ?array
    {
        try {
            $response = Http::withToken($this->token)->get($this->base_url . 'artists/' . $artistId)->json();

            if (false === array_key_exists('id', $response)) {
                throw new Exception('Spotify API artist not found');
            }

            return $response;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function getArtistAlbums($artistId): array
    {
        try {
            $response = Http::withToken($this->token)
                ->get($this->base_url . 'artists/' . $artistId . '/albums?include_groups=album,single&limit=50')
                ->json();

            if (array_key_exists('error', $response)) {
                throw new Exception($response['error']['message']);
            }

            if (false === array_key_exists('items', $response)) {
                throw new Exception('Spotify API albums not found');
            }

            return $response['items'];
        } catch (Exception $e) {
            // Log::error($e->getMessage());
            dd($e->getMessage());
            return [];
        }
    }

}