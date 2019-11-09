<?php

namespace App\Http\Resources\scoreboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class MatchupResource extends JsonResource
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
            'stats' => $this->stats($this->position),
            'href' => route('player', ['date' => $this->date(), 'player' => $this->player_id])
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
                'games_played' => $this->games_played,
                'wins' => $this->wins,
                'losses' => $this->losses,
                'overtime_losses' => $this->overtime_losses,
                'saves' => $this->saves,
                'save_percentage' => ltrim($this->save_percentage, '0'),
                'goals_against_average' => $this->goals_against_average
            ];
        }

        if ($position ===  't') {
            return [
                'games_played' => $this->games_played,
                'wins' => $this->wins,
                'losses' => $this->losses,
                'overtime_losses' => $this->overtime_losses,
                'points_team' => $this->points_team,
                'goals_for' => $this->goals_for,
                'goals_against' => $this->goals_against
            ];
        }

        return [
            'games_played' => $this->games_played,
            'goals' => $this->goals,
            'assists' => $this->assists,
            'points_skater' => $this->points_skater,
            'hits' => $this->hits,
            'shots' => $this->shots,
            'blocked_shots' => $this->blocked_shots,
            'faceoff_wins' => $this->faceoff_wins
        ];
    }
}
