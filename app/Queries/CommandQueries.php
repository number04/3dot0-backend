<?php

namespace App\Queries;

use App\Models\Lineup;
use App\Models\Config;
use App\Models\Franchise;
use App\Models\Matchup;
use App\Models\Waiver;

use DB;



/**
 *
 */

class CommandQueries
{
    public function timeConversion()
    {
        return Config::where('key', 'conversion')->pluck('value')->first();
    }

    public function pst()
    {
        Config::where('key', 'conversion')->update(['value' => '-8:00']);
    }

    public function pdt()
    {
        Config::where('key', 'conversion')->update(['value' => '-7:00']);
    }

    public function date()
    {
        Config::where('key', 'date')->increment('value');
    }

    public function adds()
    {
        Franchise::query()->update(['weekly_adds' => 0]);
    }

    public function getMatchup()
    {
        return array_map('intval', Matchup::select('start_date')->get()->pluck('start_date')->toArray());
    }

    public function getDate()
    {
        return Config::where('key', 'date')->pluck('value')->first();
    }

    public function waiver()
    {
        Waiver::whereRaw('DATE_ADD(created_at, INTERVAL 2 DAY) < NOW()')
            ->update([
                'active' => 0
            ]);
    }

    public function matchup()
    {
        if (in_array($this->getDate(), $this->getMatchup())) {

            Config::where('key', 'matchup')->increment('value');
        }
    }

    public function lineup()
    {
        Lineup::join('_player', 'lineup.player_id', '=', '_player.id')
            ->join('schedule', function ($join) {
                $join->on('lineup.date_id', '=', 'schedule.date_id')->on('_player.nhl', '=', 'schedule.team');
            })
            ->where('lineup.date_id', function ($query) {
                $query->select('value')->from('config')->where('key', 'date');
            })
            ->update([
                'lineup.active' => DB::raw(
                    "CASE WHEN schedule.time < (
                        SELECT time(
                            CONVERT_TZ(
                                NOW(), @@session.time_zone, '".$this->timeConversion().":00'
                            )
                        )
                    ) THEN 0 ELSE 1 END"
                )
            ]);
    }

    public function claim($claim)
    {
        foreach ($claim->getClaim() as $request) {

            if ($claim->countKeeper($request->player_drop)) {

                $claim->decrementCapHit($request->player_drop, $request->franchise_id);
            }

            if ($claim->countDrop()) {

                $claim->drop($request->player_drop);
                $claim->setLineup($request->player_drop, $claim->getDate(), 0, 0);
                $claim->setWaiver($request->player_drop);
            }

            $claim->add($request->player_id, $request->franchise_id);
            $claim->setLineup($request->player_id, $claim->getDate(), $request->franchise_id, 'b');
            $claim->setStatus('_claim', 'id', $request->id, 'success', 1);
            $claim->setStatus('claim', 'waiver_id', $request->waiver_id, 'process', 1);
            $claim->setStatus('waiver', 'id', $request->waiver_id, 'active', 0);
            $claim->waiverOrder($request->waiver_order, $request->franchise_id, $claim->countFranchise());

            if ($claim->getFail($request->waiver_id) && $request->matchup_id === $claim->getMatchup()) {

                $claim->decrementWeeklyAdds($request->waiver_id);
            }
        }
    }
}
