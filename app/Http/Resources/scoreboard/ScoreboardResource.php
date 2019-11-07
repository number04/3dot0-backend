<?php

namespace App\Http\Resources\scoreboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ScoreboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'franchiseId' => $this->id,
            'franchiseName' => $this->franchise_name,
            'matchup' => MatchupResource::collection($this->scoreboard),
            'daily' => DailyResource::collection($this->player)
        ];
    }
}
