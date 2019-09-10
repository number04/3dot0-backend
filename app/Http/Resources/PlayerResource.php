<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class PlayerResource extends JsonResource
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
            'franchiseId' => $this->franchise_id,
            'nhl' => $this->nhl,
            'position' => $this->position,
            'positionSecondary' => $this->position_secondary,
            'keeper' => (int) $this->keeper,
            'block' => (int) $this->block,
            'capHit' => (int) $this->cap_hit,
            'watching' => (int) $this->watching,
            'draftContract' => $this->draft_contract,
            'contractStatus' => $this->contract_status,
            'age' => $this->age,
            'isRookie' => (int) $this->rookie_status,
            'isInjured' => (int) $this->injury_status,
            'stats' => $this->stats($this->position),
            'games' => [
                'upcoming' => StatResource::collection(
                    $this->games($this->id, $this->player_name, '>=', $this->schedule->date_id, 'ASC', 4)->reverse()
                ),
                'previous' => StatResource::collection(
                    $this->games($this->id, $this->player_name, '<', $this->schedule->date_id, 'DESC', 8)
                )
            ]
        ];
    }

    private function games($id, $player, $operator, $date, $order, $limit)
    {
        return DB::table('_player')
            ->join('schedule', '_player.nhl', '=', 'schedule.team')
            ->join('stats', 'schedule.date_id', '=', 'stats.date_id')
            ->join('date', 'schedule.date_id', '=', 'date.id')
            ->where('stats.player_id', '=', $id)
            ->where('_player.player_name', '=', $player)
            ->where('schedule.opponent', '!=', NULL)
            ->where('schedule.date_id', $operator, $date)
            ->orderBy('schedule.date_id', $order)
            ->limit($limit)
            ->get();
    }

    private function stats($position)
    {
        if ($position ===  'g') {
            return [
                'gamesPlayed' => $this->games_played,
                'wins' => $this->wins,
                'losses' => $this->losses,
                'overtimeLosses' => $this->overtime_losses,
                'saves' => $this->saves,
                'savePercentage' => ltrim($this->save_percentage, '0'),
                'goalsAgainstAverage' => $this->goals_against_average
            ];
        }

        if ($position ===  't') {
            return [
                'gamesPlayed' => $this->games_played,
                'wins' => $this->wins,
                'losses' => $this->losses,
                'overtimeLosses' => $this->overtime_losses,
                'points' => ($this->wins * 2) + $this->overtime_losses,
                'goalsFor' => $this->goals_for,
                'goalsAgainst' => $this->goals_against
            ];
        }

        return [
            'gamesPlayed' => $this->games_played,
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
