<?php

namespace App\Http\Controllers\endpoints;

use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Franchise;
use App\Http\Resources\scoreboard\StatResource;

class StatController extends Controller
{

    public function stat($date, $matchup)
    {
        return StatResource::collection($this->query($date, $matchup)->get());
    }

    public function query($date, $matchup)
    {
        return QueryBuilder::for(Franchise::class)
                ->with([
                    'daily' => function ($query) use ($date) {
                        $query->date($date)->groupBy('player_id','franchise_id');
                    },

                    'matchup' => function ($query) use ($matchup) {
                        $query->matchup($matchup)->stats()->groupBy('player_id','franchise_id');
                    }
                ])
                ->allowedFilters([
                    'id'
                ]);
    }
}
