<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class StatResource extends JsonResource
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
            'date' => Carbon::parse($this->date)->format('j M'),
            'opponent' => $this->opponent,
            'stats' => $this->stats($this->position)
        ];
    }

    public function savePercentage()
    {
        if ($this->saves != 0) {
            return ltrim(number_format(round($this->saves / ($this->saves + $this->goals_against), 3), 3), '0');
        }

        return '.000';
    }

    public function goalsAgainstAverage()
    {
        if ($this->time_on_ice != 0) {
            return number_format(round(($this->goals_against * 3600) / $this->time_on_ice, 2), 2);
        }

        return '0.00';
    }

    public function result()
    {
        if ($this->overtime_losses === 1) {
            return 'otl';
        }

        if ($this->losses === 1) {
            return 'l';
        }

        if ($this->wins === 1) {
            return 'w';
        }

        return '-';
    }

    private function stats($position)
    {
        if ($position ===  'g') {
            return [
                'result' => $this->result(),
                'goalsAgainst' => $this->goals_against,
                'saves' => $this->saves,
                'savePercentage' => $this->savePercentage(),
                'goalsAgainstAverage' => $this->goalsAgainstAverage()
            ];
        }

        if ($position ===  't') {
            return [
                'result' => $this->result(),
                'points' => ($this->wins * 2) + $this->overtime_losses,
                'goalsFor' => $this->goals_for,
                'goalsAgainst' => $this->goals_against
            ];
        }

        return [
            'goals' => $this->goals,
            'assists' => $this->assists,
            'points' => $this->goals + $this->assists,
            'hits' => $this->hits,
            'shots' => $this->shots,
            'blockedShots' => $this->blocked_shots,
            'faceoffWins' => $this->faceoff_wins
        ];
    }
}
