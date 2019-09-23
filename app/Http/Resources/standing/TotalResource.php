<?php

namespace App\Http\Resources\standing;

use Illuminate\Http\Resources\Json\JsonResource;

class TotalResource extends JsonResource
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
            'franchiseId' => (int) $this->franchise_id,
            'skater' => (int) $this->skater,
            'goalie' => (int) $this->goalie,
            'team' => (int) $this->team,
            'total' => (int) $this->total
        ];
    }
}
