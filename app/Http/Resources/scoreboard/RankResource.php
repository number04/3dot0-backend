<?php

namespace App\Http\Resources\scoreboard;

use Illuminate\Http\Resources\Json\JsonResource;

class RankResource extends JsonResource
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
            'franchise_id' => $this->franchise_id,
            'r_total' => $this->r_total,
            'stats'=> [
                'skater' => [
                    'games_played' => $this->gp_skater,
                    'goals' => $this->goals,
                    'assists' => $this->assists,
                    'points_skater' => $this->points_skater,
                    'shots' => $this->shots,
                    'hits' => $this->hits,
                    'blocked_shots' => $this->blocked_shots,
                    'faceoff_wins' => $this->faceoff_wins
                ],

                'goalie' => [
                    'games_played' => $this->gp_goalie,
                    'saves' => $this->saves,
                    'save_percentage' => ltrim($this->save_percentage, '0'),
                    'goals_against_average' => $this->goals_against_average,
                ],

                'team' => [
                    'games_played' => $this->gp_team,
                    'points_team' => $this->points_team
                ]
            ],

            'rank'=> [
                'goals' => $this->r_goals,
                'assists' => $this->r_assists,
                'pointsSkater' => $this->r_points_skater,
                'shots' => $this->r_shots,
                'hits' => $this->r_hits,
                'blockedShots' => $this->r_blocked_shots,
                'faceoffWins' => $this->r_faceoff_wins,
                'saves' => $this->r_saves,
                'savePercentage' => $this->r_save_percentage,
                'goalsAgainstAverage' => $this->r_goals_against_average,
                'pointsTeam' => $this->r_points_team
            ]
        ];
    }
}
