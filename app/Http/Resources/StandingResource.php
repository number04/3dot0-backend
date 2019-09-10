<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StandingResource extends JsonResource
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
            'franchiseId' => $this->franchise_id,
            'skater' => $this->skater,
            'goalie' => $this->goalie,
            'team' => $this->team,
            'total' => $this->total
        ];
    }
}
