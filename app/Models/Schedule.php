<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Schedule extends Model
{
    protected $table = 'schedule';

    public $timestamps = false;

    public function date()
    {
        return $this->belongsTo(Date::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function scopeDate($query, $date)
    {
        return $query->where('date_id', $date);
    }
}
