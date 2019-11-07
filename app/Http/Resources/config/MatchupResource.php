<?php

namespace App\Http\Resources\config;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Date;

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
            'matchup' => $this->id,
            'startDate' => (int) $this->start_date,
            'endDate' => (int) $this->end_date,
            'startYMD' => Date::find($this->start_date)->date,
            'endYMD' => Date::find($this->end_date)->date
        ];
    }
}
