<?php

namespace App\Http\Controllers\endpoints;

use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Franchise;
use App\Http\Resources\FranchiseResource;

class FranchiseController extends Controller
{
    public function franchises($date)
    {
        return FranchiseResource::collection($this->query($date)->get());
    }

    public function query($date)
    {
        return QueryBuilder::for(Franchise::class)
                ->with([
                    'player',
                    'player.schedule' => function ($query) use ($date) {
                        $query->date($date);
                    },
                    'player.stat' => function ($query) use ($date) {
                        $query->date($date);
                    },
                    'player.lineup' => function ($query) use ($date) {
                        $query->date($date);
                    },
                ])
                ->allowedFilters([
                    'id'
                ]);
    }
}
