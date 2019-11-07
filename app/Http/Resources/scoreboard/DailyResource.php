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
            'playerId' => $this->id,
            'playerName' => $this->player_name,
            'playerNameShort' => $this->player_name_short,
            'franchiseId' => (int) $this->franchise_id,
            'nhl' => $this->nhl,
            'position' => $this->position,
            'positionSecondary' => $this->position_secondary,
            'isInjured' => $this->injury_status,
            'games' => [
                'today' => [
                    'date' => $this->schedule->date->date,
                    'opponent' => $this->schedule->opponent,
                    'lineup' => $this->lineup->status,
                    'stats' => $this->stats($this->position)
                ]
            ],
            'href' => route('player', ['date' => $this->date(), 'player' => $this->id])
        ];
    }

    private function date()
    {
        return DB::table('config')->where('key', '=', 'date')->first()->value;
    }

    private function stats($position)
    {
        if ($position ===  'g') {
            return [
                'games_played' => $this->stat->games_played,
                'wins' => $this->stat->wins,
                'losses' => $this->stat->losses,
                'overtime_losses' => $this->stat->overtime_losses,
                'saves' => $this->stat->saves,
                'save_percentage' => $this->stat->save_percentage,
                'goals_against_average' => $this->stat->goals_against_average
            ];
        }

        if ($position ===  't') {
            return [
                'games_played' => $this->stat->games_played,
                'wins' => $this->stat->wins,
                'losses' => $this->stat->losses,
                'overtime_losses' => $this->stat->overtime_losses,
                'points_team' => $this->stat->wins * 2 + $this->stat->overtime_losses,
                'goals_for' => $this->stat->goals_for,
                'goals_against' => $this->stat->goals_against
            ];
        }

        return [
            'games_played' => $this->stat->games_played,
            'goals' => $this->stat->goals,
            'assists' => $this->stat->assists,
            'points_skater' => $this->stat->goals + $this->stat->assists,
            'hits' => $this->stat->hits,
            'shots' => $this->stat->shots,
            'blocked_shots' => $this->stat->blocked_shots,
            'faceoff_wins' => $this->stat->faceoff_wins
        ];
    }
}
