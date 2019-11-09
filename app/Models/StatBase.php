<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatBase extends Model
{
    protected $table = 'stats';

    public $timestamps = false;

    protected $appends = [
        'points_skater',
        'points_team',
        'goals_against_average',
        'save_percentage'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function date()
    {
        return $this->belongsTo(Date::class);
    }

    public function scopeDate($query, $date)
    {
        $query->where('date_id', $date);
    }

    public function getGoalsAgainstAverageAttribute()
    {
        if ($this->time_on_ice != 0) {
            return number_format(round(($this->goals_against * 3600) / $this->time_on_ice, 2), 2);
        }

        return 0;
    }

    public function getSavePercentageAttribute()
    {
        if ($this->saves != 0) {
            return ltrim(number_format(round($this->saves / ($this->saves + $this->goals_against), 3), 3), '0');
        }

        return 0;
    }

    public function getPointsSkaterAttribute()
    {
        return $this->goals + $this->assists;
    }

    public function getPointsTeamAttribute()
    {
        return $this->wins * 2 + $this->overtime_losses;
    }
}
