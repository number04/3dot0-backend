<?php

namespace App\Http\Controllers\endpoints;

use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Franchise;
use App\Http\Resources\scoreboard\ScoreboardResource;

class ScoreboardController extends Controller
{

    public function scoreboard($date, $matchup)
    {
        return ScoreboardResource::collection($this->query($date, $matchup)->get());
    }

    public function query($date, $matchup)
    {
        return QueryBuilder::for(Franchise::class)
                ->with([
                    'player',
                    'player.stat' => function ($query) use ($date) {
                        $query->date($date);
                    },

                    'player.lineup' => function ($query) use ($date) {
                        $query->date($date);
                    },

                    'player.schedule' => function ($query) use ($date) {
                        $query->date($date);
                    },

                    'scoreboard' => function ($query) use ($matchup) {
                        $query->matchup($matchup)->stats()->groupBy('id','franchise_id');
                    }
                ])
                ->allowedFilters([
                    'id'
                ]);
    }
}
