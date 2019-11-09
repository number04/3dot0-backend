<?php

namespace App\Queries;

use DB;
use App\Models\PlayerBase;
use App\Models\Lineup;
use App\Models\Franchise;
use App\Models\Need;

/**
 *
 */

class RosterQueries
{
    public function watch($player, $franchise, $watch)
    {
        if ($watch) {
            return PlayerBase::where('id', $player)
                ->update(['watch' => DB::raw(
                    'JSON_INSERT(watch, "$.'. $franchise .'", "'. $franchise .'")'
                )]);
        }

        return PlayerBase::where('id', $player)
            ->update(['watch' => DB::raw(
                'JSON_REMOVE(watch, "$.'. $franchise .'")'
            )]);
    }

    public function lineup($player, $date, $status, $franchise)
    {
        return Lineup::where('player_id', '=', $player)
            ->where('date_id', '>=', $date)
            ->update([
                'status' => $status,
                'franchise_id' => $franchise
            ]);
    }

    public function block($player, $block)
    {
        return PlayerBase::where('id', '=', $player)
            ->update([
                'block' => $block
            ]);
    }

    public function need($franchise, $need)
    {
        Need::where('franchise_id', '=', $franchise)
            ->update ([
                $need => DB::raw('CASE WHEN `'. $need .'` = 1 THEN 0 WHEN `'. $need .'` = 0 THEN 1 ELSE NULL END')
            ]);
    }

    public function keeper($player, $keeper)
    {
        return Player::where('id', $player)
            ->update([
                'keeper' => $keeper
            ]);
    }

    public function cap($franchise, $keeper, $cap)
    {
        if ($keeper) {
            return Franchise::where('user_id', $franchise)->increment('cap_hit', $cap);
        }

        return Franchise::where('user_id', $franchise)->decrement('cap_hit', $cap);
    }
}
