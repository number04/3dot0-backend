<?php

namespace App\Http\Resources\config;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Matchup;
use App\Models\Date;
use App\Models\Franchise;

class ConfigResource extends JsonResource
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
            'franchise' => [
                'total' => $this->value('franchise_total'),
                'detail' =>  FranchiseDetailResource::collection(Franchise::all())
            ],

            'date' => [
                'currentDate' =>  $this->value('date'),
                'currentYMD' =>  Date::find($this->value('date'))->date,
                'season' => DateResource::collection(Date::all())
            ],

            'matchup' => [
                'currentMatchup' => $this->value('matchup'),
                'startDate' => (int) Matchup::find($this->value('matchup'))->start_date,
                'endDate' => (int) Matchup::find($this->value('matchup'))->end_date,
                'startYMD' => $this->date('start_date'),
                'endYMD' =>  $this->date('end_date'),
                'season' => MatchupResource::collection(Matchup::all())
            ],

            'isPlayoff' => $this->value('playoff')
        ];
    }

    private function value($key)
    {
        return (int) $this->where('key', $key)->pluck('value')->first();
    }

    private function date($date)
    {
        return Date::find(Matchup::find($this->value('matchup'))->$date)->date;
    }

}
