<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpotifyAlbumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this['name'],
            'released' => $this->getFormatedReleaseDate($this['release_date']),
            'tracks' => $this['total_tracks'],
            'cover' => $this['images'][0],
        ];
    }

    public function getFormatedReleaseDate($date): string
    {
        return Carbon::parse($date)->format('d-m-Y');
    }
}
