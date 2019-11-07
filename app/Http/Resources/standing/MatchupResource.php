<?php

namespace App\Http\Resources\standing;

use Illuminate\Http\Resources\Json\JsonResource;

class MatchupResource extends JsonResource
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
            'matchup' => (int) $this->matchup_id,
            'skater' => (int) $this->skater,
            'goalie' => (int) $this->goalie,
            'team' => (int) $this->team,
            'total' => $this->skater + $this->goalie + $this->team
        ];
    }
}
