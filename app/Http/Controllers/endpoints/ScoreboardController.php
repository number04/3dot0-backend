<?php

namespace App\Http\Controllers\endpoints;

use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Scoreboard;
use App\Http\Resources\scoreboard\ScoreboardResource;

class ScoreboardController extends Controller
{
    public function scoreboard($matchup)
    {
        return ScoreboardResource::collection(
            QueryBuilder::for(Scoreboard::class)->where('matchup_id', $matchup)->get()
        );
    }
}
