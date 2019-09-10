<?php

namespace App\Queries;


use App\Models\Lineup;
use App\Models\Config;
use App\Models\PlayerBase;
use App\Models\Franchise;
use App\Models\Claim;
use App\Models\Waiver;

use DB;

/**
 *
 */

class ClaimQueries
{
    // getters

    public function getDate()
    {
        return Config::where('key', 'date')->pluck('value');
    }

    public function getMatchup()
    {
        return Config::where('key', 'matchup')->first()->value;
    }

    public function getClaim()
    {
        return DB::table('_claim')->select('*')->whereRaw('DATE_ADD(created_at, INTERVAL 2 DAY) > NOW()')->get();
    }

    public function getFail($waiver)
    {
        return Claim::where('waiver_id', $waiver)->where('success', 0)->pluck('franchise_id');
    }

    public function getCapHit($player)
    {
        return PlayerBase::where('id', $player)->first()->cap_hit;
    }

    // counts

    public function countKeeper($player)
    {
        return PlayerBase::where('id', $player)->where('keeper', 1)->count();
    }

    public function countDrop()
    {
        return DB::table('_claim')->where('player_drop', '!=', NULL)->count();
    }

    public function countFranchise()
    {
        return Franchise::count();
    }

    // actions

    public function add($player, $franchise)
    {
        PlayerBase::where('id', $player)
            ->update([
                'franchise_id' => $franchise,
                'contract' => 1,
                'contract_status' => 'ufa'
            ]);
    }

    public function drop($player)
    {
        PlayerBase::where('id', $player)
            ->update([
                'franchise_id' => 0,
                'draft' => 'fa',
                'contract' => 0,
                'cap_hit' => 0,
                'contract_status' => NULL,
                'rookie_status' => 0,
                'keeper' => 0,
                'block' => 0
            ]);
    }

    public function waiverOrder($order, $franchise, $count)
    {
        Franchise::where('waiver_order', '>', $order)->decrement('waiver_order');

        Franchise::where('user_id', '=', $franchise)
            ->update([
                'waiver_order' => $count
            ]);
    }

    public function setLineup($player, $date, $franchise, $status)
    {
        Lineup::where('player_id', '=', $player)
            ->where('date_id', '>=', $date)
            ->update([
                'franchise_id' => $franchise,
                'status' => $status
            ]);
    }

    public function setWaiver($player)
    {
        Waiver::insert(['player_id' => $player]);
    }

    public function setStatus($table, $column, $id, $status, $value)
    {
        DB::table($table)
            ->where($column, '=', $id)
            ->update([
                $status => $value
            ]);
    }

    public function decrementCapHit($player, $franchise)
    {
        Franchise::where('user_id', $franchise)->decrement('cap_hit', $this->getCapHit($player));
    }

    public function decrementWeeklyAdds($waiver)
    {
        Franchise::whereIn('user_id', $this->getFail($waiver))->decrement('weekly_adds');
    }
}
