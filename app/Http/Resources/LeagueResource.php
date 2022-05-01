<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeagueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'poster_url' => $this->poster_url,
            'teams_count' => $this->teams()->count(),
            'weeks' => $this->weeks,
            'latest_played_week' => $this->latest_played_week,
            'latest_playing_week' => $this->latest_playing_week,
        ];
    }
}
