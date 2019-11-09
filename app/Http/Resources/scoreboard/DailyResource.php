<?php

namespace App\Http\Resources\scoreboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class DailyResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'playerId' => $this->player_id,
            'playerName' => $this->player_name,
            'playerNameShort' => $this->player_name_short,
            'franchiseId' => (int) $this->franchise_id,
            'nhl' => $this->nhl,
            'position' => $this->position,
            'positionSecondary' => $this->position_secondary,
            'isInjured' => $this->injury_status,
            'games' => [
                'today' => [
                    'date' => $this->date,
                    'opponent' => $this->opponent,
                    'lineup' => $this->lineup,
                    'stats' => $this->stats($this->position)
                ]
            ],
            'href' => route('player', ['date' => $this->date(), 'player' => $this->player_id])
        ];
    }

    private function date()
    {
        return DB::table('config')->where('key', '=', 'date')->first()->value;
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

    private function stats($position)
    {
        if ($position ===  'g') {
            return [
                'games_played' => $this->games_played,
                'wins' => $this->wins,
                'losses' => $this->losses,
                'overtime_losses' => $this->overtime_losses,
                'saves' => $this->saves,
                'save_percentage' => $this->savePercentage(),
                'goals_against_average' => $this->goalsAgainstAverage()
            ];
        }

        if ($position ===  't') {
            return [
                'games_played' => $this->games_played,
                'wins' => $this->wins,
                'losses' => $this->losses,
                'overtime_losses' => $this->overtime_losses,
                'points_team' => $this->wins * 2 + $this->overtime_losses,
                'goals_for' => $this->goals_for,
                'goals_against' => $this->goals_against
            ];
        }

        return [
            'games_played' => $this->games_played,
            'goals' => $this->goals,
            'assists' => $this->assists,
            'points_skater' => $this->goals + $this->assists,
            'hits' => $this->hits,
            'shots' => $this->shots,
            'blocked_shots' => $this->blocked_shots,
            'faceoff_wins' => $this->faceoff_wins
        ];
    }
}
