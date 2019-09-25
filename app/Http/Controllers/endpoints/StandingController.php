<?php

namespace App\Http\Controllers\endpoints;

use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Franchise;
use App\Models\Standing;
use App\Http\Resources\standing\StandingResource;
use App\Http\Resources\standing\TotalResource;

use DB;

class StandingController extends Controller
{
    public function standing($matchup)
    {
        return StandingResource::collection(
                $this->query($matchup)->get()
            )->additional([
                'total' => [TotalResource::collection(DB::table('_standing')->get())]
            ]);
    }

    public function query($matchup)
    {
        return QueryBuilder::for(Franchise::class)
                ->with([
                    'standing'=> function ($query) use ($matchup) {
                        $query->matchup($matchup);
                    }
                ])
                ->allowedFilters([
                    'id'
                ]);
    }
}
