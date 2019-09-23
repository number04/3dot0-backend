<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    protected $table = '_standing';

    public $timestamps = false;

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function scopeMatchup($query, $matchup)
    {
        return $query->where('matchup_id', '<=', $matchup);
    }

    // public function scopeTotals($query)
    // {
    //     $query->addSelect(
    //         '*',
    //         DB::raw('SUM(skater) AS total_skater')
    //     );
    // }
}
