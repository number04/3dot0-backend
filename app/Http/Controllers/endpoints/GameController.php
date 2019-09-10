<?php

namespace App\Http\Controllers\endpoints;

use App\Http\Controllers\Controller;

use App\Models\Lineup;

class GameController extends Controller
{
    public function index()
    {
        Lineup::join('player', 'lineup.player_id', '=', 'player.id')
            ->join('schedule', function ($join) {
                $join->on('lineup.date_id', '=', 'schedule.date_id')->on('player.nhl', '=', 'schedule.team');
            })
            ->where('lineup.date_id', function ($query) {
                $query->select('value')->from('config')->where('key', 'date');
            })
            ->update([
                'lineup.active' => DB::raw(
                    "CASE WHEN schedule.time < (
                        SELECT time(
                            CONVERT_TZ(
                                NOW(), @@session.time_zone, '-8:00'
                            )
                        )
                    ) THEN 0 ELSE 1 END"
                )
            ]);
    }
}
