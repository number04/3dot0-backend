<?php

namespace App\Http\Controllers\endpoints;

use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Rank;
use App\Http\Resources\scoreboard\RankResource;

class RankController extends Controller
{
    public function rank($matchup)
    {
        return RankResource::collection(QueryBuilder::for(Rank::class)->where('matchup_id', $matchup)->get());
    }
}
