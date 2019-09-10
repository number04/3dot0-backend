<?php

namespace App\Http\Resources\config;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;

class FranchiseDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->franchise_name,
            'tag' => $this->franchise_tag,
            'waiverOrder' => (int) $this->waiver_order,
            'rosterSize' => $this->count($this->id),
            'weeklyAdds' => (int) $this->weekly_adds,
            'goalieStarts' => (int) $this->starts($this->id),
            'capHit' => (int) $this->cap_hit
        ];
    }

    private function date()
    {
        return DB::table('config')->where('key', '=', 'date')->first()->value;
    }

    private function matchup()
    {
        return DB::table('config')->where('key', '=', 'matchup')->first()->value;
    }

    private function matchupStartDate()
    {
        return DB::table('matchup')->where('id', $this->matchup())->first()->start_date;
    }

    private function matchupEndDate()
    {
        return DB::table('matchup')->where('id', $this->matchup())->first()->end_date;
    }

    private function starts($franchise)
    {
        return DB::table('_player as p')
            ->join('lineup as l', 'p.id', '=', 'l.player_id')
            ->join('stats as s', function ($join) {
                $join->on('p.id', '=', 's.player_id')->on('l.date_id', '=', 's.date_id');
            })
            ->where('p.franchise_id', $franchise)
            ->where('l.status', 'g')
            ->whereBetween('s.date_id', [$this->matchupStartDate(), $this->matchupEndDate()])
            ->sum('s.games_played');
    }

    private function count($franchise)
    {
        return DB::table('_player')
            ->join('lineup', '_player.id', '=', 'lineup.player_id')
            ->where('_player.franchise_id', $franchise)
            ->whereIn('lineup.status', ['c', 'r', 'l', 'd', 's', 'g', 't', 'b', 'f'])
            ->where('lineup.date_id', $this->date())
            ->count();
    }
}
