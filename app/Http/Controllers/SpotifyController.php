<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpotifyAlbumResource;
use App\Services\SpotifyService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpotifyController extends Controller
{
    public function albums(Request $request): JsonResource
    {
        $request->validate([
            'q' => 'required|string|min:2',
        ]);

        $service = new SpotifyService();
        return SpotifyAlbumResource::collection(
            $service->handleAlbumSearch($request->q)
        );
    }
}
