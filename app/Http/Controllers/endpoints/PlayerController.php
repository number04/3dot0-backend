<?php

namespace App\Http\Controllers\endpoints;

use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;
use App\Models\Player;
use App\Http\Resources\PlayersResource;
use App\Http\Resources\PlayerResource;

class PlayerController extends Controller
{
    public function players($date)
    {
        return PlayersResource::collection($this->query($date)->paginate(30));
    }

    public function player($date, $player)
    {
        return PlayerResource::collection($this->query($date)->where('id', '=', $player)->get());
    }

    public function query($date)
    {
        return QueryBuilder::for(Player::class)
                ->with([
                    'schedule.date',
                    'schedule' => function ($query) use ($date) {
                        $query->date($date);
                    },
                    'stat' => function ($query) use ($date) {
                        $query->date($date);
                    },
                    'lineup' => function ($query) use ($date) {
                        $query->date($date);
                    }
                ])
                ->allowedFilters([
                    Filter::scope('position'),
                    'player_name',
                    'nhl',
                    'franchise_id',
                    'watch'
                ]);
    }
}
