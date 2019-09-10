<?php

namespace App\Http\Controllers\endpoints;

use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Standing;
use App\Http\Resources\StandingResource;

class StandingController extends Controller
{
    public function standing($matchup)
    {
        return StandingResource::collection($this->query($matchup)->get());
    }

    public function query($matchup)
    {
        return QueryBuilder::for(Standing::class)
                ->where('matchup_id', '<=', $matchup)
                ->with([
                    'franchise',
                ])
                ->allowedFilters([
                    'franchise_id'
                ]);
    }
}
