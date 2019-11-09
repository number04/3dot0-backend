<?php

namespace App\Http\Resources\scoreboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ScoreboardResource extends JsonResource
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
            'score' => $this->score,
            'stats'=> [
                'skater' => [
                    'games_played' => $this->games_played_skater,
                    'goals' => $this->goals,
                    'assists' => $this->assists,
                    'points_skater' => $this->points_skater,
                    'shots' => $this->shots,
                    'hits' => $this->hits,
                    'blocked_shots' => $this->blocked_shots,
                    'faceoff_wins' => $this->faceoff_wins
                ],

                'goalie' => [
                    'games_played' => $this->games_played_goalie,
                    'saves' => $this->saves,
                    'save_percentage' => ltrim($this->save_percentage, '0'),
                    'goals_against_average' => $this->goals_against_average,
                ],

                'team' => [
                    'games_played' => $this->games_played_team,
                    'points_team' => $this->points_team
                ]
            ],

            'stats_score'=> [
                'goals' => $this->goals_score,
                'assists' => $this->assists_score,
                'pointsSkater' => $this->points_skater_score,
                'shots' => $this->shots_score,
                'hits' => $this->hits_score,
                'blockedShots' => $this->blocked_shots_score,
                'faceoffWins' => $this->faceoff_wins_score,
                'saves' => $this->saves_score,
                'savePercentage' => $this->save_percentage_score,
                'goalsAgainstAverage' => $this->goals_against_average_score,
                'pointsTeam' => $this->points_team_score
            ]
        ];
    }
}
