<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class scoreboard extends Model
{
    protected $table = '_scoreboard';

    public $timestamps = false;

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function scopeMatchup($query, $matchup)
    {
        $query->whereBetween('date_id', [
            Matchup::select('start_date')->where('id', $matchup)->first()->start_date,
            Matchup::select('end_date')->where('id', $matchup)->first()->end_date
        ]);
    }

    public function scopeStats($query)
    {
        $query->addSelect(
            '*',
            DB::raw('SUM(games_played) AS games_played'),
            DB::raw('SUM(goals) AS goals'),
            DB::raw('SUM(assists) AS assists'),
            DB::raw('SUM(goals) + SUM(assists) AS points_skater'),
            DB::raw('SUM(shots) AS shots'),
            DB::raw('SUM(hits) AS hits'),
            DB::raw('SUM(blocked_shots) AS blocked_shots'),
            DB::raw('SUM(faceoff_wins) AS faceoff_wins'),
            DB::raw('SUM(wins) AS wins'),
            DB::raw('SUM(losses) AS losses'),
            DB::raw('SUM(overtime_losses) AS overtime_losses'),
            DB::raw('SUM(saves) AS saves'),
            DB::raw('IFNULL(ROUND((SUM(goals_against)* 3600) / SUM(time_on_ice), 2), 0) AS goals_against_average'),
            DB::raw('IFNULL(ROUND(SUM(saves) / (SUM(saves) + SUM(goals_against)), 3), 0) AS save_percentage'),
            DB::raw('SUM(goals_for) AS goals_for'),
            DB::raw('SUM(goals_against) AS goals_against'),
            DB::raw('SUM(wins) * 2 + SUM(overtime_losses) AS points_team')
        );
    }
}
