<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpotifyAlbumResource;
use App\Services\SpotifyService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpotifyController extends Controller
{
    public function index()
    {
        $service = new SpotifyService();
        $artist = $service->searchForArtist('radiohead');
        dd($service->getArtistAlbums($artist['id']));
    }

    public function albums(Request $request): JsonResource
    {
        $request->validate([
            'q' => 'required|string|min:2',
        ]);

        $service = new SpotifyService();
        $artist = $service->searchForArtist($request->q);
        return SpotifyAlbumResource::collection($service->getArtistAlbums($artist['id']) ?? []);
    }
}
