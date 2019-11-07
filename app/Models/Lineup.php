<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lineup extends Model
{
    protected $table = 'lineup';

    public $timestamps = false;

    protected $hidden = [
        'player_id', 'franchise_id', 'date_id'
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
        return $query->where('date_id', $date);
    }
}
