<?php

namespace App\Queries;

use DB;
use App\Models\PlayerBase;
use App\Models\Lineup;
use App\Models\Transaction;
use App\Models\Waiver;
use App\Models\Franchise;
use App\Models\Claim;
use App\Models\Config;

/**
 *
 */

class TransactionQueries
{
    public function timeConversion()
    {
        return Config::where('key', 'conversion')->pluck('value')->first();
    }

    public function increments($franchise, $column)
    {
        Franchise::where('id', $franchise)->increment($column);
    }

    public function decrements($franchise, $column)
    {
        Franchise::where('id', $franchise)->decrement($column);
    }

    public function add($player, $franchise)
    {
        PlayerBase::where('id', $player)
            ->update([
                'franchise_id' => $franchise,
                'contract' => 1,
                'contract_status' => 'ufa'
            ]);

        $this->increments($franchise, 'weekly_adds');
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

    public function lineup($player, $franchise, $date, $status)
    {
        Lineup::where('player_id', '=', $player)
            ->where('date_id', '>=', $date)
            ->update([
                'franchise_id' => $franchise,
                'status' => $status
            ]);
    }

    public function cap($franchise, $cap)
    {
        Franchise::where('user_id', $franchise)->decrement('cap_hit', $cap);
    }

    public function transaction($player, $franchise, $type)
    {
        Transaction::insert([
            'franchise_id' => $franchise,
            'player_id' => $player,
            'type' => $type
        ]);
    }

    public function waiver($player)
    {
        Waiver::insert([
            'player_id' => $player,
            'created_at' => gmdate("Y-m-d H:i:s", strtotime($this->timeConversion()))
        ]);
    }

    public function countWaiver($player)
    {
        return Waiver::where('player_id', $player)->where('active', 1)->count();
    }

    public function countClaim($player, $franchise)
    {
        return Claim::join('waiver', 'claim.waiver_id', '=', 'waiver.id')
            ->where('waiver.player_id', $player)
            ->where('claim.franchise_id', $franchise)
            ->where('waiver.active', 1)
            ->count();
    }

    public function countClaimDrop($player, $franchise)
    {
        if ($player) {

        return Claim::join('waiver', 'claim.waiver_id', '=', 'waiver.id')
            ->where('claim.player_drop', $player)
            ->where('claim.franchise_id', $franchise)
            ->where('waiver.active', 1)
            ->count();
        }

        return;
    }

    public function createClaim($add, $franchise, $waiver, $drop = NULL, $matchup)
    {
        if ($this->countClaimDrop($drop, $franchise)) {

            return response()->json([
                'error' => 'player dropped involed in another claim'
            ]);
        }

        if ($this->countClaim($add, $franchise)) {

            return Claim::join('waiver', 'claim.waiver_id', '=', 'waiver.id')
                ->where('waiver.player_id', $add)
                ->where('claim.franchise_id', $franchise)
                ->update([
                    'player_drop' => $drop
                ]);
        }

        Claim::insert([
            'waiver_id' => Waiver::where('player_id', $add)->where('active', 1)->pluck('id')->first(),
            'franchise_id' => $franchise,
            'waiver_order' => $waiver,
            'player_drop' => $drop,
            'matchup_id' => $matchup
        ]);

        $this->increments($franchise, 'weekly_adds');
    }

    public function removeClaim($claim, $franchise)
    {
        Claim::where('id', $claim)->delete();

        $this->decrements($franchise, 'weekly_adds');
    }

    public function confirmClaim($claim)
    {
        Claim::where('id', '=', $claim)
            ->update([
                'confirm' => 1
            ]);
    }
}
