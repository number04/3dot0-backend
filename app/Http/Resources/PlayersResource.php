<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class PlayersResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this->waiver);

        return [
            'playerId' => $this->id,
            'playerName' => $this->player_name,
            'playerNameShort' => $this->player_name_short,
            'franchiseId' => (int) $this->franchise_id,
            'nhl' => $this->nhl,
            'position' => $this->position,
            'positionSecondary' => $this->position_secondary,
            'keeper' => (int) $this->keeper,
            'block' => (int) $this->block,
            'watching' => (int) $this->watching,
            'capHit' => (int) $this->cap_hit,
            'draftContract' => $this->draft_contract,
            'isRookie' => (int) $this->rookie_status,
            'isInjured' => (int) $this->injury_status,
            'onWaivers' => $this->waivers,
            'rank' => $this->rank,
            'stats' => $this->stats($this->position, $this),
            'games' => [
                'today' => [
                    'date' => $this->schedule->date->date,
                    'opponent' => $this->schedule->opponent,
                    'gameTime' => $this->schedule->time,
                    'lineup' => $this->lineup->status,
                    'isActive' => (int) $this->lineup->active,
                    'stats' => $this->stats($this->position, $this->stat)
                ]
            ],
            'href' => route('player', ['date' => $this->date(), 'player' => $this->id])
        ];
    }

    private function date()
    {
        return DB::table('config')->where('key', '=', 'date')->first()->value;
    }

    private function stats($position, $table)
    {
        if ($position ===  'g') {
            return [
                'games_played' => $table->games_played,
                'wins' => $table->wins,
                'losses' => $table->losses,
                'overtime_losses' => $table->overtime_losses,
                'saves' => $table->saves,
                'save_percentage' => ltrim($table->save_percentage, '0'),
                'goals_against_average' => $table->goals_against_average
            ];
        }

        if ($position ===  't') {
            return [
                'games_played' => $table->games_played,
                'wins' => $table->wins,
                'losses' => $table->losses,
                'overtime_losses' => $table->overtime_losses,
                'points_team' => $table->points_team,
                'goals_for' => $table->goals_for,
                'goals_against' => $table->goals_against
            ];
        }

        return [
            'games_played' => $table->games_played,
            'goals' => $table->goals,
            'assists' => $table->assists,
            'points_skater' => $table->points_skater,
            'hits' => $table->hits,
            'shots' => $table->shots,
            'blocked_shots' => $table->blocked_shots,
            'faceoff_wins' => $table->faceoff_wins
        ];
    }
}
